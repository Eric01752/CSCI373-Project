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

    function db_insert(string $table, array $data){

        $connection = get_connection();

        //Values placeholder array
        $temparray = array();
        for($x = 0; $x < sizeof($data); $x++){
            $temparray[$x] = "?";
        }

        //Types placeholder array
        $temptypes = array();
        for($x = 0; $x < sizeof($data); $x++){
            if(gettype($data[$x]) == "string"){
                $temptypes[$x] = "s";
            }
            elseif(gettype($data[$x]) == "integer"){
                $temptypes[$x] = "i";
            }
            elseif(gettype($data[$x]) == "double"){
                $temptypes[$x] = "d";
            }
        }

        //Data array keys
        $fields = array_keys($data);
        //Build the sql statement
        $sql = "INSERT INTO " . $table . "(" . implode(", ", $fields) . ")" . " VALUES(" . implode(", ", $temparray) . ")";

        $statement = $connection->prepare($sql);
        $statement->bind_param(implode("", $temptypes), implode(", ", $data));

        $statement->execute();

        $statement->close();
        $connection->close();
    }
    //End db_insert

    function db_selectAll(string $table, $whereField="", $whereValue=""){

        $connection = get_connection();

        $sql = "SELECT * FROM " . $table;
        if($whereField != ""){
            $sql .= "WHERE " . $whereField . "=?";
        }
        
        $statement = $connection->prepare($sql);
        $statement->bind_param("s", );

        $statement->execute();
        $result = $statement->get_result();

        $statement->close();
        $connection->close();

        return $result;
    }
    //End db_select

?>