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
        <title>TEAM Edit Profile</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/addProfile.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="smallIcon">
                    <a href="profile.php"><img id="back" src="./img/back_but.png" alt="logo"></a>
                </div>
                <div class="logoIcon">
                    <a href="home.php"><img id="logo" src="./img/whitelogo.png" alt="logo"></a>
                </div>
            </div>
        </nav>
        <div id="contentMargin">
            <form>
                <b>Name:</b><br><p><input data-validation="length" data-validation-length="min3" class="customInputSize" type="text" id="profileName" placeholder="Enter your name" name="" value="<?php echo $userRow[0]['userName']; ?>"/></p>
                <hr>
                <b>Age:</b><br><p><input data-validation="number" data-validation-allowing="range[1;100]" class="customInputSize" type="text" id="profileAge" placeholder="Enter your age" name="" value="<?php echo $userRow[0]['userAge']; ?>"/></p>
                <hr>
                <b>Gender:</b><br><p><input data-validation="length" data-validation-length="min4" class="customInputSize" type="text" id="profileGender" placeholder="Enter your gender" name="" value="<?php echo $userRow[0]['userGender']; ?>"/></p>
                <hr>
                <b>Location:</b><br><p><input data-validation="length" data-validation-length="min3" class="customInputSize" type="text" id="profileLocation" placeholder="Enter your location" name="" value="<?php echo $userRow[0]['userLocation']; ?>"/></p>
                <hr>
                <b>Bio:</b><br><p><textarea data-autoresize data-validation="length" data-validation-length="min4" class="customInputSize" type="text" id="profileBio" placeholder="Enter your biography" name=""><?php echo $userRow[0]['userBio']; ?></textarea></p>
                <hr>
                <b>Email:</b><br><p><input data-validation="length" data-validation-length="min4" class="customInputSize" type="email" id="profileEmail" placeholder="Enter your email" name="" value="<?php echo $userRow[0]['userEmail']; ?>"/></p>
            </form>
                <hr>
                <div id="submitError"></div>
                <button class="btn btn-primary" type="submit" name="upload" value="Submit" id="profileSubmit">Submit</button>
                <br>
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
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
        <script src="js/editProfilevalidate.js"></script>
        <script src="js/editProfile.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>