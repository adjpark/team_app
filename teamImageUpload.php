<?php
    include_once "sqlConfig.php";
    session_start();
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $uploadUserId = $_SESSION['user'];
    $statement = $conn->prepare("SELECT teamCreated FROM users WHERE userId = ?");
    $statement->execute(array($uploadUserId));
    $userRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
    $deleteUpload = "./teamUploads/TEAM_team_".$uploadUserId."_".$userRow[0]["teamCreated"]."*.*";
    array_map('unlink', glob($deleteUpload));
    $target_dir = "./teamUploads/";
    $temp = explode(".", $_FILES["uploadfile"]["name"]);
    $newfilename = "TEAM_team_". $uploadUserId ."_".$userRow[0]["teamCreated"]. '.' . end($temp);
    move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_dir.$newfilename);
    echo $target_dir.$newfilename;
?>