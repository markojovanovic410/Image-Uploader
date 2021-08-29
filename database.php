<?php
    // change servername, username, password
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "imageupload_db";
    $tbname = "imageinfo";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die ("Connect error: " . $conn->error);
    }

    