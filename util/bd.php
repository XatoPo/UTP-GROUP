<?php

    $serverName = "localhost:3306";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "UTP_GROUP";
    
    $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);
    
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    else {
        echo "CON";
    }


?>
