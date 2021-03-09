<?php

    function db_insert(string $table, array $data){

        require "config.php";

        //Database connection object
        $connection = new mysqli($host, $username, $password, $dbname);

        //Check if database connection works
        if($connection->connect_error){
            die("Connection failed: " . $connection->connect_error);
        }

        //Values placeholder array
        $temparray = array();
        for($x = 0; $x < sizeof($data); $x++){
            $temparray[$x] = "?";
        }
        //Data array keys
        $fields = array_keys($data);
        //Build the sql statement
        $sql = "INSERT INTO " . $table . "(" . implode(", ", $fields) . ")" . " VALUES(" . implode(", ", $temparray) . ")";

        $statement = $connection->prepare($sql);
        $statement->bind_param(str_repeat("s", sizeof($data)), implode(", ", $data));

        $statement->execute();

        $statement->close();
        $connection->close();
    }
    //End db_insert

    function db_select(){
        
    }
    //End db_select

?>