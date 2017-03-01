<?php
    include_once "sqlConfig.php";
    session_start();
    if( !isset($_SESSION['user']) ) {
        header("Location: index.php");
        exit;
    }
    $applicantIdJSON = json_encode($_SESSION['user']);
    $teamList = array();
    $statement1 = $conn->prepare("SELECT * FROM teams");
    $statement1->execute();
    while($userRow1 = $statement1->fetchAll(PDO::FETCH_ASSOC)) 
    { 
        for($i = 0; $i < count($userRow1); $i++){
            $tempArr = array(
                'teamId' => $userRow1[$i]['teamId'],
                'title' => $userRow1[$i]['title'],
                'organizer' => $userRow1[$i]['organizer'],
                'location' => $userRow1[$i]['location'],
                'description' => $userRow1[$i]['description'],
                'email' => $userRow1[$i]['email'],
                'users_userId' => $userRow1[$i]['users_userId'],
                'teamImg' => $userRow1[$i]['teamImg'],
                'teamCategory' => $userRow1[$i]['teamCategory']
            );
            array_push($teamList, $tempArr);
        }
    }
    $teamListJSON = json_encode($teamList);
    $roleList = array();
    $statement2 = $conn->prepare("SELECT * FROM roles");
    $statement2->execute();
    while($userRow2 = $statement2->fetchAll(PDO::FETCH_ASSOC)) 
    {
        for($i = 0; $i < count($userRow2); $i++){
            $tempArr = array(
                'roleName' => $userRow2[$i]['roleName'],
                'availability' => $userRow2[$i]['availability'],
                'applied_user' => $userRow2[$i]['applied_user'],
                'teams_teamId' => $userRow2[$i]['teams_teamId']
            );

            array_push($roleList, $tempArr);
        }
    } 
    $roleListJSON = json_encode($roleList);
    if (isset($_POST["state"]) && !empty($_POST["state"])) {
        echo "Yes, category is set";    
    }else{  
        echo "N0, category is not set";
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>TEAM Search</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/search.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-default navbar-fixed-top">
        <div class="navbartop">
                <div class="smallIcon">
                    <a href="home.php"><img id="plus" src="./img/back_but.png" alt="logo"></a>
                </div>
                <div class="logoIcon">
                    <a href="home.php"><img id="logo" src="./img/whitelogo.png" alt="logo"></a>
                </div>
        </div>
    </nav>
    <div id="contentMargin">
        <div id="search">
            <input id="searchInput" type="text" name="title" class="title" placeholder="Search team title"/>
            <button id="searchSubmit" />
        </div>
        <div class="dropdown">
              <button class="dropbtn">Categories</button>
              <div id="myDropdown" class="dropdown-content">
                <a id="categoryMusic">Music</a>
                <a id="categorySport">Sport</a>
                <a id="categoryGame">Game</a>
              </div>
        </div>
        <p id="searchError"></p>
        <div id="contentTeamList"></div>
    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom">
      <div class="container">
          <div class="botttomNavIcon">
              <a href="home.php"><img src="./img/home2.png" alt="home" id="homepage"></a>
          </div>
          <div class="botttomNavIcon">
              <a href="search.php"><img src="./img/search1.png" alt="search" id="searchpage"></a>
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
    <script>
        $(document).ready(function() {
            var teamListJSON = <?php echo $teamListJSON; ?>;
            var teamNumberINT = <?php echo count($teamList); ?>;
            window.teamsList = teamListJSON;
            window.teamNumber = teamNumberINT;
            var roleListJSON = <?php echo $roleListJSON; ?>;
            var roleNumberINT = <?php echo count($roleList); ?>;
            window.rolesList = roleListJSON;
            window.roleNumber = roleNumberINT;
            var applicantIdJSON = <?php echo $applicantIdJSON; ?>;
            window.applicantId = applicantIdJSON;
        });
    </script>
    <script src="js/search.js"></script>
</body>
</html>