<?php 
// start sesi
session_start();

require 'function.php';

// saat ada cookie
if(isset($_COOKIE['id']) && isset($_COOKIE['key']) ){
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];

  $result = mysqli_query($db_connect, "SELECT username FROM user WHERE id = '$id'");
  $row = mysqli_fetch_assoc($result);

  if($key === hash('sha512',$row['username'])){
    $_SESSION['login'] = true;
  }


}

// saat ada sesi 
if(isset($_SESSION["login"]) ){
    header("Location: index.php");
    exit;
}


if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $result = mysqli_query($db_connect, "SELECT * FROM user WHERE username = '$username'");

    // cek username jika benar maka akan lanjut ke cek password
    if(mysqli_num_rows($result) === 1 ){

        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"]) ){
            $_SESSION["login"] = true ;
            $_SESSION["user"] = $username;
            // set cookie
            setcookie('id',$row['id'],time() +120);
            setcookie('key',hash('sha512',hash('sha512',$row['username'])),time() +120);
            // redirect
            header("Location: index.php?user=" . $_SESSION['user']);
            exit;
        }
       
    }

    $tes = true ;

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Storage | login</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="container">
<div class="alert">
          <?php if(isset($tes)) :  ?>
            <div class="failed">
            <p>password / username salah gan</p>
            </div>
          <?php endif ;?>
        </div>
      <div class="main-container">
          <h1>Login akun</h1>
      <form action="" method="post">
        <label for="username">username</label>
        <input type="text" placeholder="username" name="username" id="username" required>
        <label for="password">Password</label>
        <input type="password" placeholder="password" name="password" id="password" required>
        <button type="submit" name="login">login</button>
        <label>belom punya akun ? register <a href="register.php"> disini</a></label>
        </form>
      </div>
    </div>


</body>
</html>