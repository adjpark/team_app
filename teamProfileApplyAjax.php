<?php
    include_once "sqlConfig.php";
    session_start();
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $teamTitle = trim($_POST['teamTitle']);
    $roleName = trim($_POST['roleName']);
    $teamOrganizer = trim($_POST['teamOrganizer']);
    $teamEmail = trim($_POST['teamEmail']);
    $message = trim($_POST['message']);
    $statement = $conn->prepare("SELECT * FROM teams WHERE title = ?");
    $statement->execute(array($teamTitle));
    $teamRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
    $statement = $conn->prepare("SELECT * FROM roles WHERE teams_teamId = ?");
    $statement->execute(array($teamRow[0]["teamId"]));
    $roleRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
    $roleCounter = count($roleRow);
    for($i=0; $i < $roleCounter; $i++){
        if($roleRow[$i]["roleName"] == $roleName){
            $specificRole = $roleRow[$i];
        }
    }
    $applicantId = $_SESSION['user'];
    $statement2 = $conn->prepare("INSERT INTO applications(message, roles_rolesId, 	teams_teamId, users_userId, teams_userId) VALUES(:message, :rolesId, :teamId, :userId, :organizerId)");
    $statement2->execute(array(
        "message" => $message,
        "rolesId" => $specificRole['rolesId'],
        "teamId" => $teamRow[0]['teamId'],
        "userId" => $applicantId,
        "organizerId" => $teamRow[0]['users_userId']
    ));
    echo "success";
?>