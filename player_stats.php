<?php include "templates/header.php"; ?>

    <?php require_once "database/db_functions.php";?>

    <h2>Player Stats</h2>

    <?php
        
        //Get the teamcodes and teamnames
        $connection = get_connection();
        $sql_teams = "SELECT teamcode, teamname FROM teams ORDER BY teamname";
        $result = $connection->query($sql_teams);

        //Display the dropdown list of teams
        if($result->num_rows != 0){
            $teams = array();
            while($row = $result->fetch_assoc()){
                array_push($teams, $row);
            }
            
            echo "<div class='center'>";
            echo "<form method='post'>";
            echo "<label for='teams'>Select a team to view roster:</label>";
            echo "<select name='teams' size=1>";
            
            foreach($teams as $array){
                echo "<option value='$array[teamcode]'>" . $array['teamname'] . "</option>";
            }

            echo "</select>";
            echo "<input type='submit' name='submit' value='View Roster'>";
            echo "</form>";
        }
        else{
            echo "<h4>No teams to display:</h4>
                <p> Load NHL teams from the load link on the home page or</p>
                <p>create your own using the create link on the homepage.</p>";
        }
        $connection->close();

        //When view roster button is pressed
        if(isset($_POST['submit'])){
            
            //Get teamID and teamname
            $connection2 = get_connection();
            $sql_teamID = "SELECT teamID, teamname FROM teams WHERE teamcode='$_POST[teams]'";
            $result = $connection2->query($sql_teamID);
            $data = array();
            while($row = $result->fetch_assoc()){
                array_push($data, $row);
            }
            $connection2->close();

            //Team data
            $teamID = $data[0]['teamID'];
            $teamname = $data[0]['teamname'];

            //Get the selected team's forwards
            $connection3 = get_connection();
            $sql_forwards = "SELECT p.firstname, p.lastname, p.position, s.gamesplayed, s.goals, s.assists, s.points, s.plusminus, s.faceoffswon, s.faceoffslost, s.faceoffpercentage 
                            FROM players AS p, stats AS s
                            WHERE p.fk_teamID=$teamID AND p.playerID=s.fk_playerID AND p.position NOT IN('Goalie', 'Defense')
                            ORDER BY p.lastname";
            $result = $connection3->query($sql_forwards);

            //Display the forwards table
            if($result->num_rows != 0){
                $forwards = array();
                while($row = $result->fetch_assoc()){
                    array_push($forwards, $row);
                }

                echo "<h3>Current Team: $teamname</h3>";

                echo "<h5>Forwards</h5>";

                echo "<table>";
                echo "<tr>";
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "<th>Position</th>";
                echo "<th>Games Played</th>";
                echo "<th>Goals</th>";
                echo "<th>Assists</th>";
                echo "<th>Points</th>";
                echo "<th>+/-</th>";
                echo "<th>Faceoffs Won</th>";
                echo "<th>Faceoffs Lost</th>";
                echo "<th>Faceoffpercentage</th>";
                echo "</tr>";

                foreach($forwards as $array){
                    echo "<tr>";
                    foreach($array as $x => $x_value){
                        echo "<td>" . $x_value . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            else{
                echo "<h4>No players to display:</h4>
                    <p>This team currently has no players.</p>
                    <p>To add players to this team head to the create link on the homepage.</p>";
            }
            $connection3->close();

            //Get the selected team's defensemen
            $connection4 = get_connection();
            $sql_defensemen = "SELECT p.firstname, p.lastname, p.position, s.gamesplayed, s.goals, s.assists, s.points, s.plusminus, s.faceoffswon, s.faceoffslost, s.faceoffpercentage 
                                FROM players AS p, stats AS s
                                WHERE p.fk_teamID=$teamID AND p.playerID=s.fk_playerID AND p.position='Defense'
                                ORDER BY p.lastname";
            $result = $connection4->query($sql_defensemen);

            //Display the defensemen table
            if($result->num_rows != 0){
                $defensemen = array();
                while($row = $result->fetch_assoc()){
                    array_push($defensemen, $row);
                }

                echo "<h5>Defensemen</h5>";

                echo "<table>";
                echo "<tr>";
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "<th>Position</th>";
                echo "<th>Games Played</th>";
                echo "<th>Goals</th>";
                echo "<th>Assists</th>";
                echo "<th>Points</th>";
                echo "<th>+/-</th>";
                echo "<th>Faceoffs Won</th>";
                echo "<th>Faceoffs Lost</th>";
                echo "<th>Faceoffpercentage</th>";
                echo "</tr>";

                foreach($defensemen as $array){
                    echo "<tr>";
                    foreach($array as $x => $x_value){
                        echo "<td>" . $x_value . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            $connection4->close();

            //Get the selected team's goalies
            $connection5 = get_connection();
            $sql_goalies = "SELECT p.firstname, p.lastname, p.position, s.gamesplayed, s.wins, s.losses, s.overtimelosses, s.shotsagainst, s.goalsagainst, s.goalsagainstaverage, s.savepercentage, s.shutouts
                                FROM players AS p, stats AS s
                                WHERE p.fk_teamID=$teamID AND p.playerID=s.fk_playerID AND p.position='Goalie'
                                ORDER BY p.lastname";
            $result = $connection5->query($sql_goalies);

            //Display the goalies table
            if($result->num_rows != 0){
                $goalies = array();
                while($row = $result->fetch_assoc()){
                    array_push($goalies, $row);
                }

                echo "<h5>Goalies</h5>";

                echo "<table>";
                echo "<tr>";
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "<th>Position</th>";
                echo "<th>Games Played</th>";
                echo "<th>Wins</th>";
                echo "<th>Losses</th>";
                echo "<th>OTL</th>";
                echo "<th>Shots Against</th>";
                echo "<th>Goals Against</th>";
                echo "<th>Goals Against Average</th>";
                echo "<th>Save %</th>";
                echo "<th>Shutouts</th>";
                echo "</tr>";

                foreach($goalies as $array){
                    echo "<tr>";
                    foreach($array as $x => $x_value){
                        echo "<td>" . $x_value . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            $connection5->close();
        }

    ?>

<?php include "templates/footer.php"; ?>