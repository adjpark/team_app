<?php
    include_once "sqlConfig.php";
    session_start();
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $profileName = trim($_POST['profileName']);
    $profileAge = trim($_POST['profileAge']);
    $profileGender = trim($_POST['profileGender']);
    $profileBio = trim($_POST['profileBio']);
    $profileEmail = trim($_POST['profileEmail']);
    $profileLocation = trim($_POST['profileLocation']);
    $uploadUserId = $_SESSION['user'];
    $statement = $conn->prepare("UPDATE users SET userName = :userName, userEmail = :userEmail, userAge = :userAge, userGender = :userGender, userBio = :userBio,  userLocation = :userLocation WHERE userId = :userId");
    $statement->bindParam(':userName', $profileName, PDO::PARAM_STR);
    $statement->bindParam(':userEmail', $profileEmail, PDO::PARAM_STR);
    $statement->bindParam(':userAge', $profileAge, PDO::PARAM_STR);
    $statement->bindParam(':userGender', $profileGender, PDO::PARAM_STR);
    $statement->bindParam(':userBio', $profileBio, PDO::PARAM_STR);
    $statement->bindParam(':userLocation', $profileLocation, PDO::PARAM_STR);
    $statement->bindParam(':userId', $uploadUserId, PDO::PARAM_INT);
    $statement->execute();
?>