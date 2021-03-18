<?php include "templates/header.php"; ?>

    <h2>Team Stats</h2>

    <?php
        
        require "database/db_functions.php";

        //Get all teams from database
        $connection = get_connection();
        $sql_teams = "SELECT teamname,wins,losses,overtimelosses,winningpercentage FROM teams ORDER BY teamname";
        $result = $connection->query($sql_teams);

        //Check if data is received
        if($result->num_rows != 0){
            $teams = array();
            while($row = $result->fetch_assoc()){
                array_push($teams, $row);
            }

            //Create html table using database data
            echo "<table>";
            echo "<tr>";
            echo "<th>Team Name</th>";
            echo "<th>Wins</th>";
            echo "<th>Losses</th>";
            echo "<th>OTL</th>";
            echo "<th>Winning %</th>";
            echo "</tr>";

            foreach($teams as $array){
                echo "<tr>";
                foreach($array as $x => $x_value){
                    echo "<td>" . $x_value . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            //End
        }
        else{
            echo "<h4>No teams to display:</h4><br />
                <p> Load NHL teams from the load link on the home page or</p><br />
                <p>create your own using the create link on the homepage.</p>";
        }
        
        $connection->close();
    ?>

<?php include "templates/footer.php"; ?>