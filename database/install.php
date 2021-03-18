<?php

    require "config.php";

    //Install Database with tables
    $connection = new mysqli($host, $username, $password);

    if($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    }
    else{
        echo "Connection Success<br />";
    }

    $sql = file_get_contents("init.sql");

    if($connection->multi_query($sql) === TRUE){
        echo "Database and tables created";
    }
    else{
        echo "Database Error: " . $connection->error;
    }
    
    $connection->close();
    //End
?>