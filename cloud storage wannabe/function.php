<?php
$db_connect = mysqli_connect("localhost","root","","cloud_storage");


function register($data) {
    global $db_connect ;
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($db_connect, $data["password"]);
    $password2 = mysqli_real_escape_string($db_connect, $data["password2"]);
    // cek username sudah terdaftar atau belom
    $result = mysqli_query($db_connect, "SELECT username FROM user WHERE username = '$username' ");

    // jika sudah ada maka akan mengembalikan false
    if(mysqli_fetch_assoc($result) ){
        echo '<div class="failed">
        <p>register gagal username sudah ada</p>
      </div>' ;
        return false ;
    }

    // jika password tidak mirip dengan password konfirmasi
    if($password !== $password2 ){
        echo '<div class="failed">
        <p>register gagal password konfirmasi berbeda</p>
      </div>' ;
        return false ;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    // tambahkan user baru ke db
    mysqli_query($db_connect,"INSERT INTO user VALUES('','$username','$password')");
    mysqli_query($db_connect,"CREATE TABLE `$username` ( `id` INT NOT NULL AUTO_INCREMENT , `nama_file` VARCHAR(100) NOT NULL ,`ukuran_file` INT(255) NOT NULL , PRIMARY KEY (`id`) )");
    echo '<div class="success">
    <p>akun berhasil teregistrasi silahkan login <a href="login.php">disini</a></p>
  </div>' ;
    return mysqli_affected_rows($db_connect);

}

function upload() {
  global $db_connect;

  $namafile = $_FILES['file']['name'];
  $ukuranfile = $_FILES['file']['size'];
  $error = $_FILES['file']['error'];
  $tmpName = $_FILES['file']['tmp_name'];
  $username = $_GET["user"];


  if($ukuranfile == 0 ){
    echo "<script>alert('max 100mb gan')</script>";
    return false;
  }

  if($ukuranfile > 100000000){
    echo "<script>alert('max 100mb gan')</script>";
    return false;
  }

  // cek file sudah ada atau belom
  $result = mysqli_query($db_connect, "SELECT nama_file FROM `$username` WHERE nama_file = '$namafile' ");

  // jika sudah ada maka akan memberikan angka
  if(mysqli_fetch_assoc($result) ){
    $pecahnama = explode('.', $namafile);
    $pecahnama2 = end($pecahnama);
    $namafile = $pecahnama[0] . "2." . $pecahnama2;
  }

  // up file ke storage
  move_uploaded_file($tmpName, 'storage/' . $namafile);

  // masukkan data ke db
  mysqli_query($db_connect, "INSERT INTO `$username` VALUES ('','$namafile','$ukuranfile')" );

}

function download($file){
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename='.basename($file));
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($file));
  ob_clean();
  flush();
  readfile($file);
}

function fetch($query){
  global $db_connect;
  $result = mysqli_query($db_connect, $query);
  $rows = [];
  while($row = mysqli_fetch_assoc($result) ){
    $rows[] = $row;
  }

  return $rows;
}


function convertsize($size, $precision = 2) {
  $unit = ["B", "KB", "MB", "GB"];
  $exp = floor(log($size, 1024)) | 0;
  return round($size / (pow(1024, $exp)), $precision).$unit[$exp];
}

function delete($id,$user){
  global $db_connect;
  $query = mysqli_query($db_connect, "SELECT nama_file FROM `$user` WHERE id = $id");
  $namafile = mysqli_fetch_assoc($query);
  unlink('storage/' . $namafile["nama_file"] );
  mysqli_query($db_connect, "DELETE FROM `$user` WHERE id = $id ");
}


?>