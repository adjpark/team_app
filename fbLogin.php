<?php
    include_once "sqlConfig.php";
    session_start();
    $FBid = trim($_POST['userID']);    
    $FBname = trim($_POST['userName']);
    $FBpicture = trim($_POST['userPicture']);
    $FBemail = trim($_POST['userEmail']);
    $FBage = trim($_POST['userAge']);
    $FBgender = trim($_POST['userGender']);
    $statement = $conn->prepare("SELECT * FROM users WHERE userFBkey = :userFBkey");
    $statement->execute(array(':userFBkey' => $FBid));
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if (! $result) 
        {
            $statement = $conn->prepare("INSERT INTO users (userName,userEmail,userImg,userFBkey,userAge,userGender)
            VALUES(:userName, :userEmail, :userImg, :userFBkey, :userAge, :userGender)");
            $statement->execute(array(
                ":userName" => "$FBname",
                ":userEmail" => "$FBemail",
                ":userImg" => "$FBpicture",
                ":userFBkey" => "$FBid",
                ":userAge" => "$FBage",
                ":userGender" => "$FBgender"
            ));

            $_SESSION['user']['FBid'] = $FBid;
        }
    else 
        {
            $statement2 = $conn->prepare("SELECT userId FROM users WHERE userFBkey = :userFBkey");
            $statement2->execute(array(':userFBkey' => $FBid));
            $userRow=$statement2->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user'] = $userRow['userId'];
        }
?>
