<?php
    include_once "sqlConfig.php";
    session_start();
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $applicationInfo = $_POST['accepted'];
    if($applicationInfo == "yes"){
        $statement = $conn->prepare("DELETE FROM applications WHERE applicationId = ?");
        $statement->execute(array($_POST["selectedApp"]["applicationId"]));
        $statement = $conn->prepare("UPDATE roles SET availability='closed' WHERE rolesId = ?");
        $statement->execute(array($_POST["selectedApp"]["roles_rolesId"]));
        $statement = $conn->prepare("UPDATE roles SET applied_user = ? WHERE rolesId = ?");
        $statement->execute(array($_POST["selectedApp"]["users_userId"], $_POST["selectedApp"]["roles_rolesId"]));
        $statement = $conn->prepare("SELECT * FROM roles WHERE teams_teamId = ?");
        $statement->execute(array($_POST["selectedRole"][0]["teams_teamId"]));
        $roleRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
        print_r($roleRow);
        echo count($roleRow);
        $availabilityChecker = false;
        for($i = 0 ; $i < count($roleRow) ; $i++){
            if($roleRow[$i]["availability"] == "closed"){
                $availabilityChecker = true;
            }
            elseif($roleRow[$i]["availability"] == "open"){
                $availabilityChecker = false;
            }
        }
        if($availabilityChecker == true){
            echo "all roles are filled";
            
            $statement = $conn->prepare("DELETE FROM roles WHERE teams_teamId = ?");
            $statement->execute(array($_POST["selectedRole"][0]["teams_teamId"]));
            
            $statement = $conn->prepare("DELETE FROM teams WHERE teamId = ?");
            $statement->execute(array($_POST["selectedRole"][0]["teams_teamId"]));
        }
    }
    elseif($applicationInfo == "no"){
        $statement = $conn->prepare("DELETE FROM applications WHERE applicationId = ?");
        $statement->execute(array($_POST["selectedApp"]["applicationId"]));
    }
?>