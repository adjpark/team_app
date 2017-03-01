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
        <title>TEAM Create Team</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/addTeam.css" type="text/css" rel="stylesheet">
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
            <img class="applyerimg" id="teamImg" src="./img/defaultteam.png" />
            <p id="uploadInfo"><i>PNG, JPG, JPEG, or GIF (2024K max file size)</i></p>
            <button class="centerItem btn btn-default" id="upload">Upload Picture</button>
            <form>
            <hr>
            <b>Title:</b><p><input data-validation="length" data-validation-length="min4" class="customInputSize" type="text" id="teamTitle" placeholder="Enter team title"/></p>
            <hr>
            <b>Organizer:</b><p id="teamOrganizer"><?php echo $userRow[0]['userName']; ?></p>
            <hr>
            <b>Location:</b><p id="teamLocation"><?php echo $userRow[0]['userLocation']; ?></p>
            <hr>
            <b>Description:</b><p><textarea data-validation="length" data-validation-length="min4" data-autoresize class="customInputSize" type="text" id="teamDesc" placeholder="Enter description"></textarea></p>
            <hr>
            <b>Email:</b><p id="teamEmail"><?php echo $userRow[0]['userEmail']; ?></p>
            <hr>
            <b>Roles:</b>
            <p><input class="customInputSize" type="text" id="teamRoles" placeholder="Enter roles &#40;Minimum 1 role&#41;"/></p>
            <div id="roleError"></div>
            </form>
            <button id="submitRoles" class="btn btn-default">Add Roles</button>
            <div id="rolesList"></div>
            <br>
            <hr>
            <div class="dropdown">
              <button class="dropbtn">Categories</button>
              <div id="myDropdown" class="dropdown-content">
                <a href="#" id="categoryMusic">Music</a>
                <a href="#" id="categorySport">Sport</a>
                <a href="#" id="categoryGame">Game</a>
              </div>
            </div>
            <div id="categoryList"></div>
            <div id="categoryError"></div>
            <br>
            <hr>
            <div id="TDerror"></div>
            <button type="submit" value="Submit" id="teamSubmit" class="btn btn-default">Submit</button>
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
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
        <script src="js/addTeamvalidate.js"></script>
        <script src="js/SimpleAjaxUploader.js"></script>
        <script src="js/teamImageUpload.js"></script>
        <script src="js/addTeam.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>