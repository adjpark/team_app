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
<title>TEAM Apply Role</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/teamProfileApply.css" rel="stylesheet">
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
             <div id="msgView">
                    <b><span>Applying To Team:</span></b>
                    <p id="teamTitle"></p>
                    <hr>
                    <br>
                    <b><span>Role Position:</span></b>
                    <p id="roleName"></p>
                    <hr>   
                    <br>
                    <b><span>To Organizer:</span></b>
                    <p id="organizerName"></p>
                    <hr>   
                    <br>
                    <b><span>Message:</span></b>  
                    <br>
                    <textarea data-autoresize id="message" placeholder="Enter a message for organizer"></textarea>
                    <hr> 
                    <br>
                    <p id="applyError"></p>
                    <button type="submit" id="sendApp">Send Application</button>
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
        <script src="js/teamProfileApply.js"></script>
    </body>
</html>    