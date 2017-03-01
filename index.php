<?php
 include_once "sqlConfig.php";
 session_start();
    //--------------FACEBOOK LOGIN---------------------------------
    if(isset($_SESSION['user']['FBid'])){
        $statement = $conn->prepare("SELECT userId FROM users WHERE userFBkey=:userFBkey");
        $statement->bindParam(':userFBkey', $_SESSION['user']['FBid']);
        $statement->execute();
        $FBuserRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
        $_SESSION['user'] = $FBuserRow[0]["userId"];
    }
    //----------If session exists redirect to home---------
     if ( isset($_SESSION['user'])!="" ) {
      header("Location: home.php");
      exit;
     }
?>
<!DOCTYPE html>
<html>
<head>
<title>TEAM Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/bootstrap-social.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
</head>
<body>
    <div class="top">
        <img src="./img/login%20logo.png" alt="logo" id="logo">
    </div>
    <div id="parent">
            <form class="well form-horizontal" action=" " method="post" id="contact_form">
                <div class="form-group">
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <input data-validation="email" id="emailinput" name="email" placeholder="E-Mail Address" class="form-control" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            
                            <input name="pass" placeholder="Password" class="form-control" type="password">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-4">
                        <?php
                            //--------------NORMAL LOGIN---------------------------------
                             if( isset($_POST['btn-login']) ) {
                                 $email = trim($_POST['email']);
                                 $password = trim($_POST['pass']);
                                 
                                 if($password== ""){
                                     echo "<span style='color:#ff6a6a;' class='help-block form-error'>Invalid email address and password.</span>";
                                 }
                                 else{
                                     $query = $conn->prepare("SELECT userId, userEmail, userPass FROM users WHERE userEmail=:userEmail AND userPass=:userPass");
                                     $query->bindParam(':userEmail', $email);
                                     $query->bindParam(':userPass', $password);
                                     $query->execute();
                                     
                                     if($row = $query->fetch()){
                                        $_SESSION['user'] = $row['userId'];
                                        header("Location: home.php");
                                     }
                                     else{
                                         echo "<span style='color:#ff6a6a;' class='help-block form-error'>Invalid email address and password.</span>";
                                     }
                                 }
                             }
                        ?>
                        <button type="submit" id="loginMargin" type="submit" class="btn btn-warning btn-block btn-primary btn-outline centerItem" name="btn-login">Login</button>

                    </div>
                </div>

            </form>

        </div>
        <a id="signupanchor" href="register.php">
            <button id="signupbtn" class="btn btn-block btn-primary btn-outline centerItem">Sign Up</button>
        </a>
    <div id="fbHolder">
        <a id="fbLogin" name="fb-login"><img id="fblogo" src="img/fb.png"/>Facebook Login</a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="js/fb.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="js/indvalidate.js"></script>
    </body>
</html>