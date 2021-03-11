<?php include "templates/header.php"; ?>

    <h2>Import NHL Teams</h2>

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
    </form>

    <img id="teamImg" src="img/ARI.png">

    <script language="Javascript">
        function changeImg(imageID, folder, newImg){
            document.getElementById(imageID).src = folder + "/" + newImg + ".png";
        }
    </script>

<?php include "templates/footer.php"; ?>