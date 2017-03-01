<?php
    include_once "sqlConfig.php";
    session_start();
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $uploadUserId = $_SESSION['user'];
    $deleteUpload = "./profileUploads/TEAM_user".$uploadUserId."*.*";
    array_map('unlink', glob($deleteUpload));
    $target_dir = "./profileUploads/";
    $temp = explode(".", $_FILES["uploadfile"]["name"]);
    $newfilename = "TEAM_user". $uploadUserId . '.' . end($temp);
    move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_dir.$newfilename);
    $profileImg = "profileUploads/".$newfilename;
    $statement = $conn->prepare("UPDATE users SET userImg = :userImg WHERE userId = :userId");
    $statement->bindParam(':userImg', $profileImg, PDO::PARAM_STR);
    $statement->bindParam(':userId', $uploadUserId, PDO::PARAM_STR);
    $statement->execute();
    echo $target_dir.$newfilename;
?>