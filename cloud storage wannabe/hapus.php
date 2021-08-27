<?php 
require 'function.php';

$id = $_GET["id"];
$user = $_GET["user"];
if(delete($id,$user) > 0){
    echo "<Script>alert('File Berhasil dihapus')</script>";
    header("Location: index.php?user=" . $user );
}else{
    echo "<Script>alert('File gagal dihapus')</script>";
    header("Location: index.php?user=" . $user );
}


?>