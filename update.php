<?php include "templates/header.php"; ?>

    <?php require_once "database/db_functions.php";?>

    <h2>Update Information/Stats</h2>

    <?php

        //Get the teamcodes and teamnames
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
            
            echo "<form method='post'>";
            echo "<label for='teams'>Select a team to update:</label>";
            echo "<select name='teams' size=1>";
            
            foreach($teams as $array){
                echo "<option value=$array[teamID]>" . $array['teamname'] . "</option>";
            }

            echo "</select>";
            echo "<input type='submit' name='select_team' value='Select'>";
            echo "</form>";
        }
        else{
            echo "<h4>No teams to display:</h4>
                <p> Load NHL teams from the load link on the home page or</p>
                <p>create your own using the create link on the homepage.</p>";
        }

        if(isset($_POST['select_team'])){

            $teamID = $_POST['teams'];

            $connection = get_connection();
            $sql_team = "SELECT teamcode, teamname, wins, losses, overtimelosses, winningpercentage FROM teams WHERE teamID=$teamID";
            $result = $connection->query($sql_team);
            $connection->close();

            if($result->num_rows != 0){
                $teamdata = array();
                while($row = $result->fetch_assoc()){
                    array_push($teamdata, $row);
                }

                $teamcode = $teamdata[0]['teamcode'];
                $teamname = $teamdata[0]['teamname'];
                $wins = $teamdata[0]['wins'];
                $losses = $teamdata[0]['losses'];
                $overtimelosses = $teamdata[0]['overtimelosses'];
                if(($wins + $losses + $overtimelosses) == 0){
                    $winningpercentage = number_format(0.0, 3);
                }
                else{
                    $winningpercentage = number_format(($wins / ($wins + $losses + $overtimelosses)), 3);
                }

                echo "<h3>Currently Updating: $teamname</h3>";
                
                echo "<h4>Team</h4>";
                
                echo "<form method='post'>";
                echo "<label for='teamID'>Team ID:</label>";
                echo "<input type='number' name='teamID' min=1 value='$teamID' readonly>";
                echo "<label for='teamcode'>Abbreviation:</label>";
                echo "<input type='text' name='teamcode' value='$teamcode'>";
                echo "<label for='teamname'>Team Name:</label>";
                echo "<input type='text' name='teamname' value='$teamname'>";

                echo "<label for='wins'>Wins:</label>";
                echo "<input type='number' id='wins' name='wins' min='0' max='100' value='$wins' onchange='changeWinningPercentage()'>";
                echo "<label for='losses'>Losses:</label>";
                echo "<input type='number' id='losses' name='losses' min='0' max='100' value='$losses' onchange='changeWinningPercentage()'>";
                echo "<label for='overtimelosses'>Overtime Losses:</label>";
                echo "<input type='number' id='overtimelosses' name='overtimelosses' min='0' max='100' value='$overtimelosses' onchange='changeWinningPercentage()'>";
                echo "<label for='winningpercentage'>Winning %:</label>";
                echo "<input type='text' id='winningpercentage' name='winningpercentage' value='$winningpercentage' readonly>";
                
                echo "<input type='submit' name='submit_team' value='Update Team'>";
                echo "<input type='reset'>";
                echo "</form>";

                echo "<h4>Players</h4>";

                $connection = get_connection();
                $sql_players = "SELECT playerID, fk_teamID, firstname, lastname, birthyear, position FROM players WHERE fk_teamID=$teamID";
                $result = $connection->query($sql_players);
                $connection->close();

                //Display the dropdown list of players on selected team
                if($result->num_rows != 0){
                    $players = array();
                    while($row = $result->fetch_assoc()){
                        array_push($players, $row);
                    }

                    $connection = get_connection();
                    $sql_player_stats = "SELECT gamesplayed, goals, assists, points, plusminus, faceoffswon, faceoffslost, faceoffpercentage, wins, losses, overtimelosses, shotsagainst, goalsagainst, goalsagainstaverage, savepercentage, shutouts FROM stats WHERE fk_stats_teamID=$teamID";
                    $result = $connection->query($sql_player_stats);
                    $connection->close();
                    
                    $playerstats = array();
                    while($row = $result->fetch_assoc()){
                        array_push($playerstats, $row);
                    }

                    $playercount = sizeof($players);
                    $count = 0;
                    
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='playercount' value=$playercount>";
                    foreach($players as $player){

                        $playerstat = $playerstats[$count];

                        echo "<div class='players'>";
                        echo "<label for='team_$count'>Team:</label>";
                        echo "<select name='team_$count' size=1>";
                
                        foreach($teams as $array){
                            if($array['teamname'] == $teamname){
                                echo "<option value=$array[teamID] selected>" . $array['teamname'] . "</option>";
                            }
                            else{
                                echo "<option value=$array[teamID]>" . $array['teamname'] . "</option>";
                            }
                        }

                        echo "</select>";
                        echo "<label for='playerID_$count'>Player ID:</label>";
                        echo "<input type='number' name='playerID_$count' min=1 value=$player[playerID] readonly>";
                        echo "<label for='firstname_$count'>First Name:</label>";
                        echo "<input type='text' name='firstname_$count' value='$player[firstname]'>";
                        echo "<label for='lastname_$count'>Last Name:</label>";
                        echo "<input type='text' name='lastname_$count' value='$player[lastname]'>";
                        echo "<label for='birthyear_$count'>Birth Year:</label>";
                        echo "<input type='text' name='birthyear_$count' value=$player[birthyear]>";
                        echo "<label for='position_$count'>Position:</label>";
                        echo "<select name='position_$count' size=1>";
                            if($player['position'] == "Center"){
                                echo "<option value='Center' selected>Center</option>";
                            }
                            else{
                                echo "<option value='Center'>Center</option>";
                            }
                            if($player['position'] == "LeftWing"){
                                echo "<option value='LeftWing' selected>Left Wing</option>";
                            }
                            else{
                                echo "<option value='LeftWing'>Left Wing</option>";
                            }
                            if($player['position'] == "RightWing"){
                                echo "<option value='RightWing' selected>Right Wing</option>";
                            }
                            else{
                                echo "<option value='RightWing'>Right Wing</option>";
                            }
                            if($player['position'] == "Defense"){
                                echo "<option value='Defense' selected>Defense</option>";
                            }
                            else{
                                echo "<option value='Defense'>Defense</option>";
                            }
                            if($player['position'] == "Goalie"){
                                echo "<option value='Goalie' selected>Goalie</option>";
                            }
                            else{
                                echo "<option value='Goalie'>Goalie</option>";
                            }
                        echo "</select>";
                        
                        if($player['position'] != "Goalie"){
                            echo "<label for='gamesplayed_$count'>Games Played:</label>";
                            echo "<input type='number' name='gamesplayed_$count' min=0 max=100 value=$playerstat[gamesplayed]>";
                            echo "<label for='goals_$count'>Goals:</label>";
                            echo "<input type='number' id='goals_$count' name='goals_$count' min=0 value=$playerstat[goals] onchange='changePoints($count)'>";
                            echo "<label for='assists_$count'>Assists:</label>";
                            echo "<input type='number' id='assists_$count' name='assists_$count' min=0 value=$playerstat[assists] onchange='changePoints($count)'>";
                            echo "<label for='points_$count'>Points:</label>";
                            echo "<input type='number' id='points_$count' name='points_$count' min=0 value=$playerstat[points] readonly>";
                            echo "<label for='plusminus_$count'>Plus/Minus:</label>";
                            echo "<input type='number' name='plusminus_$count' value=$playerstat[plusminus]>";
                            echo "<label for='faceoffswon_$count'>Faceoffs Won:</label>";
                            echo "<input type='number' id='faceoffswon_$count' name='faceoffswon_$count' min=0 value=$playerstat[faceoffswon] onchange='changeFaceoffPercentage($count)'>";
                            echo "<label for='faceoffslost_$count'>Faceoffs Lost:</label>";
                            echo "<input type='number' id='faceoffslost_$count' name='faceoffslost_$count' min=0 value=$playerstat[faceoffslost] onchange='changeFaceoffPercentage($count)'>";
                            echo "<label for='faceoffpercentage_$count'>Faceoff %:</label>";
                            echo "<input type='text' id='faceoffpercentage_$count' name='faceoffpercentage_$count' min=0 value='$playerstat[faceoffpercentage]' readonly>";
                        }
                        else{
                            echo "<label for='gamesplayed_$count'>Games Played:</label>";
                            echo "<input type='number' id='gamesplayed_$count' name='gamesplayed_$count' min=0 max=100 value=$playerstat[gamesplayed] onchange='changeGoalsAgainstAverage($count)'>";
                            echo "<label for='wins_$count'>Wins:</label>";
                            echo "<input type='number' name='wins_$count' min=0 value=$playerstat[wins]>";
                            echo "<label for='losses_$count'>Losses:</label>";
                            echo "<input type='number' name='losses_$count' min=0 value=$playerstat[losses]>";
                            echo "<label for='overtimelosses_$count'>OTL:</label>";
                            echo "<input type='number' name='overtimelosses_$count' min=0 value=$playerstat[overtimelosses]>";
                            echo "<label for='shotsagainst_$count'>Shots Against:</label>";
                            echo "<input type='number' id='shotsagainst_$count' name='shotsagainst_$count' min=0 value=$playerstat[shotsagainst] onchange='changeSavePercentage($count)'>";
                            echo "<label for='goalsagainst_$count'>Goals Against:</label>";
                            echo "<input type='number' id='goalsagainst_$count' name='goalsagainst_$count' min=0 value=$playerstat[goalsagainst] onchange='changeBoth($count)'>";
                            echo "<label for='goalsagainstaverage_$count'>Goals Against Average:</label>";
                            echo "<input type='number' id='goalsagainstaverage_$count' name='goalsagainstaverage_$count' min=0 value=$playerstat[goalsagainstaverage] readonly>";
                            echo "<label for='savepercentage_$count'>Save %:</label>";
                            echo "<input type='number' id='savepercentage_$count' name='savepercentage_$count' min=0 value=$playerstat[savepercentage] readonly>";
                            echo "<label for='shutouts_$count'>Shutouts:</label>";
                            echo "<input type='number' name='shutouts_$count' min=0 value=$playerstat[shutouts]>";
                        }
                        echo "</div>";
                        $count++;
                    }

                    echo "<input type='submit' name='submit_players' value='Update Players'>";
                    echo "<input type='reset'>";
                    echo "</form>";
                }
                else{
                    echo "<p>No available players to update</p>";
                }

            }
        }

        if(isset($_POST['submit_team'])){

            $teamID = (integer) $_POST['teamID'];
            $teamcode = (string) strtoupper(trim($_POST['teamcode']));
            $teamname = (string) ucwords(trim($_POST['teamname']));
            $wins = (integer) $_POST['wins'];
            $losses = (integer) $_POST['losses'];
            $overtimelosses = (integer) $_POST['overtimelosses'];
            $winningpercentage = (float) $_POST['winningpercentage'];

            $connection = get_connection();
            $sql_update_team = "UPDATE teams SET teamcode='$teamcode', teamname='$teamname', wins=$wins, losses=$losses, overtimelosses=$overtimelosses, winningpercentage=$winningpercentage WHERE teamID=$teamID";
            if($connection->query($sql_update_team) === TRUE){
                echo "<script>alert('The team has been updated.')</script></p>";
            }
            else{
                echo "<p>Error updating team.</p>";
                echo $connection->error;
            }
            $connection->close();
        }

        if(isset($_POST['submit_players'])){

            $connection = get_connection();
            for($x=0; $x < $_POST['playercount']; $x++){
                $playerID = (integer) $_POST["playerID_" . $x];
                $fk_teamID = (integer) $_POST["team_" . $x];
                $firstname = (string) ucwords(trim($_POST["firstname_" . $x]));
                $lastname = (string) ucwords(trim($_POST["lastname_" . $x]));
                $birthyear = (integer) $_POST["birthyear_" . $x];
                $position = (string) $_POST["position_" . $x];
                $sql_update_players = "UPDATE players SET fk_teamID=$fk_teamID, firstname='$firstname', lastname='$lastname', birthyear=$birthyear, position='$position' WHERE playerID=$playerID";
                if($connection->query($sql_update_players) === TRUE){
                }
                else{
                    echo "<p>Error updating team.</p>";
                    echo $connection->error;
                }

                $gamesplayed = (integer) $_POST["gamesplayed_" . $x];
                $goals = (integer) $_POST["goals_" . $x];
                $assists = (integer) $_POST["assists_" . $x];
                $points = (integer) $_POST["points_" . $x];
                $plusminus = (integer) $_POST["plusminus_" . $x];
                $faceoffswon = (integer) $_POST["faceoffswon_" . $x];
                $faceoffslost = (integer) $_POST["faceoffslost_" . $x];
                $faceoffpercentage = (float) $_POST["faceoffpercentage_" . $x];
                $wins = (integer) $_POST["wins_" . $x];
                $losses = (integer) $_POST["losses_" . $x];
                $overtimelosses = (integer) $_POST["overtimelosses_" . $x];
                $shotsagainst = (integer) $_POST["shotsagainst_" . $x];
                $goalsagainst = (integer) $_POST["goalsagainst_" . $x];
                $goalsagainstaverage = (float) $_POST["goalsagainstaverage_" . $x];
                $savepercentage = (float) $_POST["savepercentage_" . $x];
                $shutouts = (integer) $_POST["shutouts_" . $x];
                $sql_update_players_stats = "UPDATE stats SET fk_stats_teamID=$fk_teamID, gamesplayed=$gamesplayed, goals=$goals, assists=$assists, points=$points, plusminus=$plusminus, faceoffswon=$faceoffswon, faceoffslost=$faceoffslost, faceoffpercentage=$faceoffpercentage, wins=$wins, losses=$losses, overtimelosses=$overtimelosses, shotsagainst=$shotsagainst, goalsagainst=$goalsagainst, goalsagainstaverage=$goalsagainstaverage, savepercentage=$savepercentage, shutouts=$shutouts WHERE fk_playerID=$playerID";
                if($connection->query($sql_update_players_stats) === TRUE){
                }
                else{
                    echo "<p>Error updating team.</p>";
                    echo $connection->error;
                }
            }
            echo "<script>alert('The players have been updated.')</script></p>";
            $connection->close();
        }

    ?>

    <script language="Javascript">
        function changeWinningPercentage(){
            var wins = Number(document.getElementById("wins").value);
            var losses = Number(document.getElementById("losses").value);
            var overtimelosses = Number(document.getElementById("overtimelosses").value);
            var totalgames = wins + losses + overtimelosses;
            var winningpercentage = (wins / totalgames).toFixed(3);
            
            document.getElementById("winningpercentage").value = winningpercentage;
        }

        function changePoints(count){
            var number = count;
            var goals = Number(document.getElementById("goals_" + number).value);
            var assists = Number(document.getElementById("assists_" + number).value);
            var points = goals + assists;

            document.getElementById("points_" + number).value = points;
        }

        function changeFaceoffPercentage(count){
            var number = count;
            var faceoffswon = Number(document.getElementById("faceoffswon_" + number).value);
            var faceoffslost = Number(document.getElementById("faceoffslost_" + number).value);
            var totalfaceoffs = faceoffswon + faceoffslost;
            var faceoffpercentage = ((faceoffswon / totalfaceoffs) * 100.0).toFixed(2);

            document.getElementById("faceoffpercentage_" + number).value = faceoffpercentage;
        }

        function changeGoalsAgainstAverage(count){
            var number = count;
            var gamesplayed = Number(document.getElementById("gamesplayed_" + number).value);
            var goalsagainst = Number(document.getElementById("goalsagainst_" + number).value);
            var goalsagainstaverage;
            if(gamesplayed == 0){
                goalsagainstaverage = 0.00;
            }
            else{
                goalsagainstaverage = (goalsagainst / gamesplayed).toFixed(2);
            }

            document.getElementById("goalsagainstaverage_" + number).value = goalsagainstaverage;
        }

        function changeSavePercentage(count){
            var number = count;
            var goalsagainst = Number(document.getElementById("goalsagainst_" + number).value);
            var shotsagainst = Number(document.getElementById("shotsagainst_" + number).value);
            var saves;
            if(goalsagainst >= shotsagainst){
                saves = 0;
            }
            else{
                saves = shotsagainst - goalsagainst;
            }
            var savepercentage = (saves / shotsagainst).toFixed(3);
            console.log(number);
            console.log(goalsagainst);
            console.log(shotsagainst);
            console.log(saves);
            console.log(savepercentage);

            document.getElementById("savepercentage_" + number).value = savepercentage;
        }

        function changeBoth(count){
            changeGoalsAgainstAverage(count);
            changeSavePercentage(count);
        }
    </script>

<?php include "templates/footer.php"; ?>