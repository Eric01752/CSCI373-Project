<?php include "templates/header.php"; ?>

    <?php require_once "database/db_functions.php";?>

    <h2>Create Teams And Players</h2>

    <h3>Team</h3>

    <?php

        if(isset($_POST['submit_team'])){

            if(trim($_POST['team']) != "" && trim($_POST['teamcode']) != ""){
                $teamname = (string) ucwords(trim($_POST['team']));
                $teamcode = (string) strtoupper(trim($_POST['teamcode']));

                $connection = get_connection();
                $sql_check_teamname = "SELECT teamname FROM teams WHERE teamname='$teamname'";
                $result = $connection->query($sql_check_teamname);
                $sql_check_teamcode = "SELECT teamcode FROM teams WHERE teamcode='$teamcode'";
                $result2 = $connection->query($sql_check_teamcode);
                $connection->close();

                if($result->num_rows == 0 && $result2->num_rows == 0){
                    $connection = get_connection();
                    $sql_insert_team = "INSERT INTO teams(teamcode, teamname) VALUES(?, ?)";
                    $statement = $connection->prepare($sql_insert_team);
                    $statement->bind_param("ss", $teamcode, $teamname);
                    $statement->execute();

                    $statement->close();
                    $connection->close();

                    echo "<script>alert('$teamname ($teamcode) has been created.')</script></p>";
                }
                elseif($result->num_rows != 0 && $result2->num_rows == 0){
                    echo "<p>$teamname already exists. Please use a different team name.</p>";
                }
                elseif($result2->num_rows != 0 && $result->num_rows == 0){
                    echo "<p>$teamcode already exists. Please use a different abbreviation.</p>";
                }
                else{
                    echo "<p>Both $teamname and $teamcode already exists. Please use a different team name and abbreviation.</p>";
                }
                
            }
            else{
                echo "<p>Please fill in all fields.</p>";
            }

        }

    ?>

    <form method="post">
        <label for="team">Name:</label>
        <input type="text" name="team">
        <label for="teamcode">Abbreviation: (Ex. ABC)</label>
        <input type="text" name="teamcode">
        <br />
        <input type="submit" name="submit_team" value="Create Team">
    </form>

    <h3>Player</h3>

    <?php

        if(isset($_POST['submit_player'])){

            if(trim($_POST['firstname']) != "" && trim($_POST['lastname']) != "" && trim($_POST['birthyear']) != ""){
                $firstname = (string) ucwords(trim($_POST['firstname']));
                $lastname = (string) ucwords(trim($_POST['lastname']));
                if(is_numeric(trim($_POST['birthyear']))){
                    $birthyear = (integer) trim($_POST['birthyear']);
                }
                else{
                    echo "<p>Birth year is not numeric. Make sure birth year is numeric.</p>";
                }
                $position = $_POST['position'];
                $fk_teamID = $_POST['team'];

                $connection = get_connection();
                $sql_insert_player = "INSERT INTO players(fk_teamID, firstname, lastname, birthyear, position) VALUES(?, ?, ?, ?, ?)";
                $statement = $connection->prepare($sql_insert_player);
                $statement->bind_param("issis", $fk_teamID, $firstname, $lastname, $birthyear, $position);
                $statement->execute();

                $statement->close();
                $connection->close();

                $connection = get_connection();
                $sql_new_playerID = "SELECT playerID FROM players WHERE fk_teamID=$fk_teamID AND firstname='$firstname' AND lastname='$lastname' AND birthyear=$birthyear";
                $result = $connection->query($sql_new_playerID);
                $playerID = $result->fetch_assoc()['playerID'];
                $connection->close();

                $connection = get_connection();
                $sql_insert_player_stat_ref = "INSERT INTO stats(fk_playerID) VALUES($playerID)";
                if($connection->query($sql_insert_player_stat_ref) === TRUE){
                    echo "<script>alert('$firstname $lastname has been created.')</script></p>";
                }
                else{
                    echo "Player was not successfully added.";
                }
                $connection->close();
            }
            else{
                echo "<p>Please fill in all fields.</p>";
            }
        }

    ?>

    <form method="post">
        <label for="firstname">First name:</label>
        <input type="text" name="firstname">
        <label for="lastname">Last name:</label>
        <input type="text" name="lastname">
        <label for="birthyear">Birth Year:</label>
        <input type="text" name="birthyear">
        <label for="position">Position:</label>
        <select name="position" size="1">
            <option value="Center">Center</option>
            <option value="LeftWing">Left Wing</option>
            <option value="RightWing">Right Wing</option>
            <option value="Defense">Defense</option>
            <option value="Goalie">Goalie</option>
        </select>
        <label for="team">Team:</label>
        
        <?php
            //Get the teamcodes and teamnames
            $connection = get_connection();
            $sql_teams = "SELECT teamID, teamname FROM teams ORDER BY teamname";
            $result = $connection->query($sql_teams);

            //Display the dropdown list of teams
            if($result->num_rows != 0){
                $teams = array();
                while($row = $result->fetch_assoc()){
                    array_push($teams, $row);
                }
                
                echo "<select name='team' size=1>";
                
                foreach($teams as $array){
                    echo "<option value=$array[teamID]>" . $array['teamname'] . "</option>";
                }

                echo "</select>";
            }
        ?>

        <br />
        <input type="submit" name="submit_player" value="Create Player">
    </form>

<?php include "templates/footer.php"; ?>