<?php
    include_once "sqlConfig.php";
    session_start();
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $teamApplicationInfo = array();
    $teamListInfo = array();
    $statement = $conn->prepare("SELECT * FROM users WHERE userId = ?");
    $statement->execute(array($_SESSION['user']));
    $userRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
    $statement = $conn->prepare("SELECT * FROM applications WHERE teams_userId = ?");
    $statement->execute(array($_SESSION['user']));
    $applicationRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
    for($i = 0 ; $i<count($applicationRow); $i++){
        $statement = $conn->prepare("SELECT * FROM roles WHERE rolesId = ?");
        $statement->execute(array($applicationRow[$i]["roles_rolesId"]));
        $roleRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
        $statement = $conn->prepare("SELECT * FROM teams WHERE teamId = ?");
        $statement->execute(array($applicationRow[$i]["teams_teamId"]));
        $teamRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
        $statement = $conn->prepare("SELECT userId,userName,userEmail,userAge,userGender,userBio,userImg,userLocation FROM users WHERE userId = ?");
        $statement->execute(array($applicationRow[$i]["users_userId"]));
        $applicantRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
        $tempArr = array($roleRow,$teamRow,$applicantRow,$applicationRow[$i]);
        array_push($teamApplicationInfo,$tempArr); 
        }
    $statement = $conn->prepare("SELECT * FROM teams WHERE users_userId = ?");
    $statement->execute(array($_SESSION['user']));
    $myTeamListAjax = $statement->fetchAll(PDO::FETCH_ASSOC); 
    for($i = 0 ; $i<count($myTeamListAjax); $i++){
        $statement = $conn->prepare("SELECT * FROM roles WHERE teams_teamId = ?");
        $statement->execute(array($myTeamListAjax[$i]["teamId"]));
        $myTeamRolesListAjax = $statement->fetchAll(PDO::FETCH_ASSOC); 
        $tempArr = array($myTeamListAjax[$i],$myTeamRolesListAjax);
        array_push($teamListInfo,$tempArr);
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>TEAM Manage</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/manage.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
                <div class="smallIcon" id="initialBack">
                    <a href="home.php"><img id="back" src="./img/back_but.png" alt="logo"></a>
                </div>
                <div class="smallIcon" id="noneBackBut">
                   <img id="back" src="./img/back_but.png" alt="logo">
                </div>
                <div class="logoIcon">
                    <a href="home.php"><img id="logo" src="./img/whitelogo.png" alt="logo"></a>
                </div>
        </div>
    </nav>
<div id="contentMargin">
    <div id="applicationList">    
        <div id="myApplicationsList">
        <h1>Application List</h1>
        <?php
            $appNumCounter = count($applicationRow);
            for($i = 0 ; $i < $appNumCounter ; $i++){
                $statement = $conn->prepare("SELECT * FROM users WHERE userId = ?");
                $statement->execute(array($applicationRow[$i]["users_userId"]));
                $appliedUserRow = $statement->fetchAll(PDO::FETCH_ASSOC);
                $tempImg = $appliedUserRow[0]["userImg"];
                $tempName = $appliedUserRow[0]["userName"];
                $statement = $conn->prepare("SELECT * FROM roles WHERE rolesId = ?");
                $statement->execute(array($applicationRow[$i]["roles_rolesId"]));
                $appliedRoleRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
                $tempRoleName = $appliedRoleRow[0]["roleName"];
                echo "<div class='appStyle' id='app".$i."'>"."<img class='applyerimg' src='$tempImg' />"."<p class='applyernames'>".$tempName.' is applying for '.$tempRoleName."</p>"."</div><br/><hr id='applyerhr'>";
            }
        ?>
        </div>
        <div id="myTeamsList">
        <h1>My Team List</h1>
        <?php
            $statement = $conn->prepare("SELECT * FROM teams WHERE users_userId = ?");
            $statement->execute(array($_SESSION['user']));
            $myTeamList = $statement->fetchAll(PDO::FETCH_ASSOC); 
            $teamNumCounter = count($myTeamList);
            for($i = 0 ; $i < $teamNumCounter ; $i++){
                $tempImg = $myTeamList[$i]["teamImg"];
                $tempName = $myTeamList[$i]["title"];
                echo "<div class='myTeam' id='myTeam".$i."'>"."<img class='applyerimg' src=$tempImg />"."<p class='applyernames'>".$tempName."</p>"."</div><br/><hr id='applyerhr'>";
            }
        ?>
        </div>
    </div>
    <div id="applicationForm">
        <div id="applyerinfo">
            <b id="firsttitle">Application For TEAM:</b><p id="teamName"></p>
            <b id="secondtitle">For Role:</b><p id="roleName"></p>
        </div>
        <hr>
        <b>Applicant Info:</b><img id="profileImg" src="" />
        <b>Name:</b><p id="appName"></p>
        <hr>
        <b>Age:</b><p id="appAge"></p>
        <hr>
        <b>Gender:</b><p id="appGender"></p>
        <hr>
        <b>Location:</b><p id="appLocation"></p>
        <hr>
        <b>Bio:</b><p id="appBio"></p>
        <hr>
        <b>Email:</b><p id="appEmail"></p>
        <hr>
        <b>Description:</b><p id="appDesc"></p>
        <button id="applicationAccept">Accept</button>
        <button id="applicationDecline">Decline</button>
    </div>
</div>
  <nav class="navbar navbar-default navbar-fixed-bottom">
      <div class="container">
          <div class="botttomNavIcon">
              <a href="home.php"><img src="./img/home2.png" alt="home" id="homepage"></a>
          </div>
          <div class="botttomNavIcon">
              <a href="search.php"><img src="./img/search2.png" alt="search" id="searchpage"></a>
          </div>
          <div class="botttomNavIcon">
              <a href="manage.php">
                <?php
                    $statement = $conn->prepare("SELECT applicationId FROM applications WHERE teams_userId = ?");
                    $statement->execute(array($_SESSION['user']));
                    $myTeamRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
                    
                    if(count($myTeamRow) <= 0){
                        echo "<img src='./img/manage1.png' alt='manage' id='managepage'>";
                    }
                    else{
                        echo "<img src='./img/notify2.png' alt='manage' id='managepage'>";
                    }
                  ?>
              </a>
          </div>
          <div class="botttomNavIcon">
              <a href="profile.php"><img src="./img/profile2.png" alt="profile" id="profilepage"></a>
          </div>
      </div>
    </nav> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/manage.js"></script>
    <script>
        window.appList = <?php echo json_encode( $teamApplicationInfo ) ?>;
        console.log(window.appList)
        window.teamListInfo = <?php echo json_encode( $teamListInfo ) ?>;
        console.log(window.teamListInfo)
    </script>
</body>
</html>