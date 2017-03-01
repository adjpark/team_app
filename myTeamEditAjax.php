<?php
    include_once "sqlConfig.php";
    session_start();
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $actionType = $_POST['actionType'];
    if($actionType == "delete"){
        $teamProfileObj = $_POST['deletedTeam'];
        for($i = 0 ; $i < count($teamProfileObj[1]) ; $i++){
            echo $teamProfileObj[1][$i]["rolesId"];
            $statement = $conn->prepare("DELETE FROM roles WHERE rolesId = ?");
            $statement->execute(array($teamProfileObj[1][$i]["rolesId"]));
        }
        $statement = $conn->prepare("DELETE FROM teams WHERE teamId = ?");
        $statement->execute(array($teamProfileObj[0]["teamId"]));
        echo "Deleted Team";
    }
    elseif($actionType == "update"){
        $teamProfileObj = $_POST['updatedTeam'];
        $updatedRolesObj = $_POST['updatedRoles'];
        $newRolesObj = $_POST['newRoles'];
        print_r($teamProfileObj);
        for($i = 0 ; $i < count($updatedRolesObj) ; $i++){
            if($updatedRolesObj[$i]["availability"] == "deleted"){
                $statement = $conn->prepare("DELETE FROM roles WHERE rolesId = ?");
                $statement->execute(array($updatedRolesObj[$i]["rolesId"]));
            }
        }
        for($i = 0 ; $i < count($newRolesObj) ; $i++){
            $statement = $conn->prepare("INSERT INTO roles(roleName, teams_teamId) VALUES(:roleName, :teams_teamId)");
            $statement->execute(array(
                "roleName" => $newRolesObj[$i],
                "teams_teamId" => $teamProfileObj['teamId']
            ));
        }
        $statement = $conn->prepare("UPDATE teams SET title = :title, organizer = :organizer, location = :location, description = :description, email = :email, teamCategory = :teamCategory WHERE teamId = :teamId");
        $statement->bindParam(':title', $teamProfileObj["title"], PDO::PARAM_STR);
        $statement->bindParam(':organizer', $teamProfileObj["organizer"], PDO::PARAM_STR);
        $statement->bindParam(':location', $teamProfileObj["location"], PDO::PARAM_STR);
        $statement->bindParam(':description', $teamProfileObj["description"], PDO::PARAM_STR);
        $statement->bindParam(':email', $teamProfileObj["email"], PDO::PARAM_STR);
        $statement->bindParam(':teamCategory', $teamProfileObj["teamCategory"], PDO::PARAM_STR);
        $statement->bindParam(':teamId', $teamProfileObj["teamId"], PDO::PARAM_INT);
        $statement->execute();
    }
?>