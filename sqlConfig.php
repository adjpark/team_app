<?php
    $servername = "50.62.209.187";
    $username = "djpark994";
    $password = "Fow54o&9";
    $dbname = "team_app";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    catch(PDOException $e)
        {
        echo "Connection failed: " . $e->getMessage();
        }
?>