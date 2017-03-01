<?php
    include_once "sqlConfig.php";
    session_start();
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $newTeamImg = json_decode($_POST["newImgLink"]);
    $teamId = json_decode($_POST["teamId"]);
    echo $newTeamImg;
    $statement = $conn->prepare("UPDATE teams SET teamImg = :teamImg WHERE teamId = :teamId");
    $statement->bindParam(':teamImg', $newTeamImg, PDO::PARAM_STR);
    $statement->bindParam(':teamId', $teamId, PDO::PARAM_STR);
    $statement->execute();
?>