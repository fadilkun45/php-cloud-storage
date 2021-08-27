<?php 
// mulai sesi
session_start();

// panggil function php
require 'function.php';

// cek apakah ada sesi login atau tidak jika tidak maka akan diredirect balik ke panel login
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
};

// kalo tombol up file dipanggil
if(isset($_POST["submit"]) ){
    upload();
    header("Location: index.php?user=" . $_SESSION["user"]);
}

// render file yang ada
$username = $_GET["user"];

if($username === NULL ){
    header("Location: index.php?user=" . $_SESSION["user"]);
}


$daftar_file = fetch("SELECT * FROM `$username` ORDER BY id");


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud Storage | home</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<nav>
   <div class="nav-container">
   <div class="nav-logo">
        Cloud Storage 
    </div>
    <div class="profile-menu">
    <img src="profile-pict/dumny.png">
       <div class="profile-menu-inner">
        <p><?= $username ?></p>
        <a href="logout.php">logout</a>
       </div>
    </div>
   </div>
</nav>
<div class="container">
    <div class="main">
            <?php if($daftar_file === NULL ) : ?>
                <h2>jumlah File : 0 </h2>
            <?php else : ?>
                <h2>jumlah File : <?= count($daftar_file); ?></h2>
            <?php endif ; ?>
    <div class="file-list-render">
            <?php foreach($daftar_file as $file ) : ?>
        <div class="file">
            <h3><?= $file["nama_file"] ?></h3>
            <p><?= convertsize($file["ukuran_file"]) ?></p>
            <a href="hapus.php?id=<?= $file['id'] ?>&user=<?= $_GET['user'] ?>" >Hapus file</a>
            <a href="download.php?file=<?=$file['nama_file']?>&user=<?= $_GET['user']?>" >download</a>
            <a href="downlink.php?file=<?=$file['nama_file']?>" >generate link download</a>
        </div>

            <?php endforeach ; ?>
        </div>
    </div>
    <div class="upload-section">
        <h2>upload file disini max size file 100mb</h2>
        <form action="" method="post" enctype="multipart/form-data">
        <input type="file"name="file" id="file" require>
        <button type="submit" name="submit" >upload File</button>
        </form>
    </div>
</div>
</body>
</html>