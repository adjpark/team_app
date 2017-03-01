<?php
    include_once "sqlConfig.php";
    session_start();
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $teamTitle = trim($_POST['teamTitle']);
    $teamOrganizer = trim($_POST['teamOrganizer']);
    $teamLocation = trim($_POST['teamLocation']);
    $teamDesc = trim($_POST['teamDesc']);
    $teamEmail = trim($_POST['teamEmail']);
    $teamImg = json_decode(trim($_POST['teamImg']));
    $teamCategory = trim($_POST['teamCategory']);
    $teamRoles = $_POST['teamRoles'];
    $uploadUserId = $_SESSION['user'];
    $statement = $conn->prepare("INSERT INTO teams(title, organizer, location, description, email, teamImg, teamCategory, users_userId)
    VALUES(:title, :organizer, :location, :description, :email, :teamImg, :teamCategory, :users_userId)");
    $statement->execute(array(
        "title" => "$teamTitle",
        "organizer" => "$teamOrganizer",
        "location" => "$teamLocation",
        "description" => "$teamDesc",
        "email" => "$teamEmail",
        "teamImg" => "$teamImg",
        "teamCategory" => "$teamCategory",
        "users_userId" => "$uploadUserId"
    ));
    $last_id = $conn->lastInsertId();
    for($i = 0; $i < count($teamRoles); $i++)
    {
        $statement3 = $conn->prepare("INSERT INTO roles(roleName, teams_teamId) VALUES(:roleName, :teams_teamId)");
        $statement3->execute(array(
            "roleName" => "$teamRoles[$i]",
            "teams_teamId" => "$last_id"
        ));
    }
    $uploadUserId = $_SESSION['user'];
    $statement = $conn->prepare("SELECT teamCreated FROM users WHERE userId = ?");
    $statement->execute(array($uploadUserId));
    $userRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
    $teamCreatedUpdated = $userRow[0]["teamCreated"] + 1;
    $statement = $conn->prepare("UPDATE users SET teamCreated='$teamCreatedUpdated' WHERE userId = ?");
    $statement->execute(array($uploadUserId));
?>