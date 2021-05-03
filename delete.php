<?php include "templates/header.php"; ?>

    <?php require_once "database/db_functions.php";?>

    <h2>Delete Teams/Players</h2>

    <?php

        //Get the teamID and teamnames
        $connection = get_connection();
        $sql_teams = "SELECT teamID, teamname FROM teams ORDER BY teamname";
        $result = $connection->query($sql_teams);
        $connection->close();

        //Display the dropdown list of teams
        if($result->num_rows != 0){
            $teams = array();
            while($row = $result->fetch_assoc()){
                array_push($teams, $row);
            }

            echo "<div class='center'>";
            echo "<h3 class='h3_left'>Delete Team</h3>";
            echo "<h4>***CAUTION: Deleting a team will also delete its players.***</h4>";
            
            echo "<form method='post'>";
            echo "<label for='teams'>Select a team to delete:</label>";
            echo "<select name='teams' size=1>";
            
            foreach($teams as $array){
                echo "<option value=$array[teamID]>" . $array['teamname'] . "</option>";
            }

            echo "</select>";
            echo "<input type='submit' name='submit_team' value='Delete Team'>";
            echo "</form>";
        }
        else{
            echo "<h4>No teams to delete:</h4>
                <p> Load NHL teams from the load link on the home page or</p>
                <p>create your own using the create link on the homepage.</p>";
        }

        echo "<h3 class='h3_left'>Delete Player</h3>";

        if(isset($_POST['submit_player'])){

            $firstname = (string) ucwords(trim($_POST['firstname']));
            $lastname = (string) ucwords(trim($_POST['lastname']));
            $birthyear = (integer) trim($_POST['birthyear']);

            $connection = get_connection();
            $sql_delete_player = "DELETE FROM players WHERE firstname='$firstname' AND lastname='$lastname' AND birthyear=$birthyear";
            if($connection->query($sql_delete_player) === TRUE){
                echo "<script>alert('$firstname $lastname has been deleted.')</script></p>";
            }
            else{
                echo "Player does not exist. Please enter a player that exists.";
            }
            $connection->close();
        }

        echo "<div class='center'>";
        echo "<form method='post'>";
        echo "<div class='row'>";
        echo "<label for='firstname'>Firstname:</label>";
        echo "<input type='text' name='firstname'>";
        echo "<label for='lastname'>Lastname:</label>";
        echo "<input type='text' name='lastname'>";
        echo "<label for='birthyear'>Birth Year:</label>";
        echo "<input type='text' name='birthyear'>";
        echo "</div>";
        echo "<input type='submit' name='submit_player' value='Delete Player'>";
        echo "</form>";
        echo "</div>";

        if(isset($_POST['submit_team'])){

            $teamID = $_POST['teams'];
            
            $connection = get_connection();
            $sql_delete_team = "DELETE FROM teams WHERE teamID=$teamID";
            if($connection->query($sql_delete_team) === TRUE){
                echo "<script>alert('The team has been deleted.')</script></p>";
                header("Refresh: " . 0.0001);
            }
            else{
                echo $connection->error;
            }
            $connection->close();
        }
    ?>

<?php include "templates/footer.php"; ?>