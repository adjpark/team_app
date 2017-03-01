<?php
    include_once "sqlConfig.php";
    session_start();
        if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $statement = $conn->prepare("SELECT * FROM users WHERE userId = ?");
    $statement->execute(array($_SESSION['user']));
    $userRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
?>
<!DOCTYPE html>
<html>
<head>
<title>TEAM Profile</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/profile.css" rel="stylesheet">
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
                <div class="smallIcon">
                    <a href="addProfile.php"><img id="edit" src="./img/edit_button.png" alt="logo"></a>
                </div>
        </div>
    </nav>
    <div id="contentMargin">
    <img class="applyerimg" id="profileImg" src="<?php echo $userRow[0]['userImg']; ?>" />
    <p id="uploadInfo"><i>PNG, JPG, JPEG, or GIF (2024K max file size)</i></p>
    <button class="centerItem btn btn-default" id="upload">Change Picture</button>
    <div id="profileView">
        <b>Name:</b><p id="profileName"><?php echo $userRow[0]['userName']; ?></p>
        <hr>
        <b>Age:</b><p id="profileAge"><?php echo $userRow[0]['userAge']; ?></p>
        <hr>
        <b>Gender:</b><p id="profileGender"><?php echo $userRow[0]['userGender']; ?></p>
        <hr>
        <b>Location:</b><p id="profileLocation"><?php echo $userRow[0]['userLocation']; ?></p>
        <hr>
        <b>Bio:</b><p id="profileBio"><?php echo $userRow[0]['userBio']; ?></p>
        <hr>
        <b>Email:</b><p id="profileEmail"><?php echo $userRow[0]['userEmail']; ?></p>
        <hr>
    </div>
    <a href="logout.php?logout">
        <button id="logoutbut" class="centerItem btn btn-default">Log Out</button>
    </a>
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
                        echo "<img src='./img/manage.png' alt='manage' id='managepage'>";
                    }
                    else{
                        echo "<img src='./img/notify.png' alt='manage' id='managepage'>";
                    }
                  ?>
              </a>
          </div>
          <div class="botttomNavIcon">
              <a href="profile.php"><img src="./img/profile1.png" alt="profile" id="profilepage"></a>
          </div>
      </div>
    </nav> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/SimpleAjaxUploader.js"></script>
    <script src="js/profileImageUpload.js"></script>
</body>
</html>