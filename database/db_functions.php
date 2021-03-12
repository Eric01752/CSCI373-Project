<?php

    function get_connection(){
        require "config.php";

        //Database connection object
        $connection = new mysqli($host, $username, $password, $dbname);

        //Check if database connection works
        if($connection->connect_error){
            die("Connection failed: " . $connection->connect_error);
        }

        return $connection;
    }
    //End get_connection
?>