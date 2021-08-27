<?php
error_reporting(E_ERROR | E_PARSE);
$filename = $_GET["file"];
$status = false;
require 'function.php';

// cek apakah ada parameter file atau tidak bila ada maka status akan bernilai true
if(isset($filename)){
    $status = true;
}

$folder_path = "storage/";
$file = $folder_path . $filename ;
// cek apakah ada nama file ada yang sesuai di storage  atau tidak bila ada maka status akan bernilai false
if (file_exists($file) == null ){
    $status = false;
}

if(isset($_POST["submit"]) ){
    downtrigger();
}
    // TRIGGER DOWNLOAD FILE
    function downtrigger(){
        $folder_path = "storage/";
        global $filename;
        $file = $folder_path . $filename ;
        if (file_exists($file))
        {
            download($file);
     }else {
        
         return;
     }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download <?=$filename?></title>
</head>
<body style="text-align: center ;">

  <?php if($status === true ) : ?>
    <h1>Download <?=$filename ?></h1>
    <form action="" method="post">
        <button type="submit" name="submit">Download File</button>
    </form>
    
  <?php else : ?>
    <h1>File not Found</h1>
    <?php endif; ?>

</body>
</html>