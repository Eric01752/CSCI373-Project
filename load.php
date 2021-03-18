<?php include "templates/header.php"; ?>

    <h2>Load NHL Teams</h2>

    <?php
        if(isset($_POST['submit'])){

            require "database/db_functions.php";

            //Team code comparison array
            $team_array = array(
                "ANA" => "Anaheim Ducks",
                "ARI" => "Arizona Coyotes",
                "BOS" => "Boston Bruins",
                "BUF" => "Buffalo Sabres",
                "CAR" => "Carolina Hurricanes",
                "CBJ" => "Columbus Blue Jackets",
                "CHI" => "Chicago Blackhawks",
                "DAL" => "Dallas Stars",
                "DET" => "Detroit Red Wings",
                "FLA" => "Florida Panthers",
                "NJD" => "New Jersey Devils",
                "NYI" => "New York Islanders",
                "NYR" => "New York Rangers",
                "PHI" => "Philadelphia Flyers",
                "PIT" => "Pittsburgh Penguins",
                "WSH" => "Washington Capitals"
            );

            //Check to see if team already exists in database
            $connection = get_connection();
            $team = $team_array[$_POST['teams']];
            $sql_check_team = "SELECT teamname FROM teams WHERE teamname='$team'";
            $result = $connection->query($sql_check_team);
            //End

            if($result->num_rows == 0){
                //Insert team into database
                $connection2 = get_connection();
                $sql_insert_team = "INSERT INTO teams(teamname) VALUES(?)";
                $statement = $connection2->prepare($sql_insert_team);
                $statement->bind_param("s", $team);
                $statement->execute();

                $statement->close();
                $connection2->close();
                //End

                //Get teamID from the team that was just inserted
                $connection3 = get_connection();
                $sql_teamID = "SELECT teamID FROM teams WHERE teamname='$team'";
                $result = $connection3->query($sql_teamID);
                $player_teamID = $result->fetch_assoc();
                $player_teamID = (integer)$player_teamID['teamID'];
                $connection3->close();
                //End

                //Load team roster data file into database
                $connection4 = get_connection();
                $team_file = fopen("data/" . $_POST['teams'] . ".txt", "r");

                while(!feof($team_file)){
                    $line = fgets($team_file);
                    $player_info = explode(" ", $line);

                    $player_firstname = (string)$player_info[0];
                    $player_lastname = (string)$player_info[1];
                    $player_birthyear = (integer)$player_info[2];
                    $player_position = (string)$player_info[3];
                    
                    $sql_insert_player = "INSERT INTO players (fk_teamID, firstname, lastname, birthyear, position)
                                        VALUES ($player_teamID, '$player_firstname', '$player_lastname', $player_birthyear, '$player_position')";
                    if($connection4->query($sql_insert_player) === TRUE){
                    }
                    else{
                        echo "Error: " . $connection4->error;
                    }
                }

                fclose($team_file);
                $connection4->close();
                //End
                
                //Get all current team players id's
                $connection5 = get_connection();
                $sql_playerID = "SELECT playerID FROM players WHERE fk_teamID='$player_teamID'";
                $result = $connection5->query($sql_playerID);
                $playerID = array();
                while($row = $result->fetch_assoc()){
                    array_push($playerID, $row['playerID']);
                }
                $connection5->close();
                //End
                
                //Insert player stats reference into database
                $connection6 = get_connection();
                for($x = 0;$x < sizeof($playerID);$x++){
                    $sql_insert_stats_ref = "INSERT INTO stats (fk_playerID) VALUES ($playerID[$x])";
                    if($connection6->query($sql_insert_stats_ref) === TRUE){
                    }
                    else{
                        echo "Error: " . $connection6->error;
                    }
                }
                $connection6->close();
                //End

                echo "<p>$team has been loaded into database</p>";
            }
            else{
                echo "<p>$team is already loaded into database</p>";
            }

            $connection->close();

        }
    ?>

    <form method="post">
    	<label for="teams">Select a team to import:</label>
    	<select name="teams" size="1" onChange="changeImg('teamImg', 'img', this.value)">
            <option value="ANA">Anaheim Ducks</option>
            <option value="ARI">Arizona Coyotes</option>
            <option value="BOS">Boston Bruins</option>
            <option value="BUF">Buffalo Sabres</option>
            <option value="CGY">Calgary Flames</option>
            <option value="CAR">Carolina Hurricanes</option>
            <option value="CHI">Chicago Blackhawks</option>
            <option value="COL">Colorado Avalanche</option>
            <option value="CBJ">Columbus Blue Jackets</option>
            <option value="DAL">Dallas Stars</option>
            <option value="DET">Detroit Red Wings</option>
            <option value="EDM">Edmonton Oilers</option>
            <option value="FLA">Florida Panthers</option>
            <option value="LAK">Los Angeles Kings</option>
            <option value="MIN">Minnesota Wild</option>
            <option value="MTL">Montreal Canadiens</option>
            <option value="NSH">Nashville Predators</option>
            <option value="NJD">New Jersey Devils</option>
            <option value="NYI">New York Islanders</option>
            <option value="NYR">New York Rangers</option>
            <option value="OTT">Ottawa Senators</option>
            <option value="PHI">Philadelphia Flyers</option>
            <option value="PIT">Pittsburgh Penguins</option>
            <option value="SJS">San Jose Sharks</option>
            <option value="STL">St. Louis Blues</option>
            <option value="TBL">Tampa Bay Lightning</option>
            <option value="TOR">Toronto Maple Leafs</option>
            <option value="VAN">Vancouver Canucks</option>
            <option value="VGK">Vegas Golden Knights</option>
            <option value="WSH">Washington Capitals</option>
            <option value="WPG">Winnipeg Jets</option>
        </select>
        <input type="submit" name="submit" value="Load Team">
    </form>

    <img id="teamImg" src="img/ANA.png">

    <script language="Javascript">
        function changeImg(imageID, folder, newImg){
            document.getElementById(imageID).src = folder + "/" + newImg + ".png";
        }
    </script>

<?php include "templates/footer.php"; ?>