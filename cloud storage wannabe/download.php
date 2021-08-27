<?php 

require 'function.php';

$user = $_GET["user"];
$filename = $_GET["file"];

$folder_path = "storage/";
$file = $folder_path . $filename ;

if (file_exists($file))
    {
    download($file);
    header("Location: index.php?user=".$user);
};
?>