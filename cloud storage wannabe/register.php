<?php 
require 'function.php';

$status = false ;
if(isset($_POST["register"]) ){
  if(register($_POST) > 0 ){
     $status = true ;
  }
}


?>

<!-- html -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud storage | register</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/regis.css">
    <!-- font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
      <div class="main-container">
          <h1>Register akun</h1>
      <form action="" method="post">
        <label for="username">username</label>
        <input type="text" placeholder="username" name="username" id="username" required>
        <label for="password">Password</label>
        <input type="password" placeholder="password" name="password" id="password" required>
        <label for="password2">Ulang Password</label>
        <input type="password" placeholder="password" name="password2" id="password2" required>
        <button type="submit" name="register">Register</button>
        <label>sudah punya akun ? login <a href="login.php"> disini</a></label>
        </form>
      </div>
    </div>
</body>
</html>