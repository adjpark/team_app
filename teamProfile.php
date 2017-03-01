<?php
    include_once "sqlConfig.php";
    session_start();
     if( !isset($_SESSION['user']) ) {
      header("Location: index.php");
      exit;
     }
?>
<!DOCTYPE html>
<html>
<head>
<title>TEAM Team Page</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/teamProfile.css" rel="stylesheet">
</head>
    <body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
                <div class="smallIcon">
                    <a href="home.php"><img id="back" src="./img/back_but.png" alt="logo"></a>
                </div>
                <div class="logoIcon">
                    <a href="home.php"><img id="logo" src="./img/whitelogo.png" alt="logo"></a>
                </div>
        </div>
    </nav>
        <div id="contentMargin">
            <div id="teamView">
                <img class="applyerimg" id="teamImg" src="" />
                <b>Title:</b><p id="teamTitle"></p>
                <hr>
                <b>Organizer:</b><p id="teamOrganizer"></p>
                <hr>
                <b>Location:</b><p id="teamLocation"></p>
                <hr>
                <b>Description:</b><p id="teamDesc"></p>
                <hr>
                <b>Email:</b><p id="teamEmail"></p>
                <hr>
                <b>Roles:</b><p id="teamRoles"></p>
                <p id="appStatus"></p>
                <p id="reminder">Tap on the role you would like to apply. You can only apply one role per team.</p>
                <hr>
                <b>Category:</b><p id="teamCategory"></p>
            </div>
        </div>
   <nav class="navbar navbar-default navbar-fixed-bottom">
      <div class="container">
          <div class="botttomNavIcon">
              <a href="home.php"><img src="./img/home1.png" alt="home" id="homepage"></a>
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
                        echo "<img src='./img/manage.png' alt='manage' id='managepage'>";
                    }
                    else{
                        echo "<img src='./img/notify.png' alt='manage' id='managepage'>";
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
    <script src="js/teamProfile.js"></script>
</body>
</html>