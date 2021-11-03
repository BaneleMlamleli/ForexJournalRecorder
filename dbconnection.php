<?php
    $serverName = "";
    $username = "";
    $password = "";
    $dbName = "";

    switch($_SERVER["SERVER_NAME"]){
        case "localhost":
            $serverName = "localhost";
            $username = "root";
            $password = "";
            $dbName = "forexjournalrecorder";
            break;
    }

    // Create connection
    $conn = new mysqli($serverName, $username, $password, $dbName);

    // Check connection
    if ($conn->connect_error) {
        echo "<script type=text/javascript>alert('Database Connection failed')</script>";
        die($conn->connect_error);
    } 
?>