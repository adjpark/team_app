<?php
    include_once "sqlConfig.php";
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>TEAM Sign Up</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">
    <link href="css/bootstrap-social.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
</head>
<body>
    <div class="top">
        <img src="./img/login%20logo.png" alt="logo" id="logo">
    </div>
    <form id="register-form" method="POST" class="col-md-12" novalidate="novalidate" >
    <p><input data-validation="length custom" data-validation-regexp="^([a-zA-Z]+)$" data-validation-length="min2" id="firstname" type="text" name="firstname" class="form-control formInput centerItem" placeholder="Enter First Name"/></p>
    <p><input data-validation="length custom" data-validation-regexp="^([a-zA-Z]+)$" data-validation-length="min2" id="lastname" type="text" name="lastname" class="form-control formInput centerItem" placeholder="Enter Last Name"/></p>
    <p><input data-validation="email" id="email" type="text" name="email" class="form-control formInput centerItem" placeholder="Enter Your Email"/></p>
    <p><input data-validation="strength" data-validation-strength="2" type="password" name="pass" class="form-control formInput centerItem" placeholder="Enter Password"/></p>
    <?php
        if ( isset($_POST['btn-signup']) ) {
            $firstname = trim($_POST['firstname']);
            $lastname = trim($_POST['lastname']);
            $name = $firstname." ".$lastname;
            $email = trim($_POST['email']);
            $password = trim($_POST['pass']);
            $statement = $conn->prepare("SELECT userEmail FROM users");
            $statement->execute();
            $userEmailRow = $statement->fetchAll(PDO::FETCH_ASSOC); 
            $emailChecker = false;
            for($i = 0; $i < count($userEmailRow); $i++){
                if($email == $userEmailRow[$i]["userEmail"]){
                    $emailChecker = true;
                }
            }       
            if($emailChecker == false){
                $query = $conn->prepare("INSERT INTO users (userName, userEmail, userPass) VALUES (:userName, :userEmail, :userPass)");
                $query->bindParam(':userName', $name);
                $query->bindParam(':userEmail', $email);
                $query->bindParam(':userPass', $password);
                $query->execute();  
                header("Location: index.php");
            }
            elseif($emailChecker == true){
                echo "<span style='color:#ff6a6a;' class='help-block form-error has-error'>Account with this email exists.</span>";
            }
        }
    ?>
    <button id="loginMargin" type="submit" class="btn btn-block btn-primary btn-outline centerItem" name="btn-signup">Register</button>
    <div id="loginLink">     
        <a id="already" href="index.php">Already have an account? Sign in Here</a>
    </div>
    </form>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/regvalidate.js"></script>
</body>
</html>