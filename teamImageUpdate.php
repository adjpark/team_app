<?php
    include_once "sqlConfig.php";
    session_start();
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $first_key = key($_FILES);
    $deleteUpload = "./teamUploads/".$first_key."*.*";
    array_map('unlink', glob($deleteUpload));
    $target_dir = "./teamUploads/";
    $temp = explode(".", $_FILES[$first_key]["name"]);
    $newfilename = $first_key. '.' . end($temp);
    move_uploaded_file($_FILES[$first_key]["tmp_name"], $target_dir.$newfilename);
    echo $target_dir.$newfilename;
?>
