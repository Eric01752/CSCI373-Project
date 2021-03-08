<?php include "templates/header.php"; ?>

    

    <h2>List players based on team</h2>

    <form method="post">
    	<label for="teamname">Enter Team Name:</label>
    	<input type="text" id="teamname" name="teamname">
    	<input type="submit" name="submit" value="View Results">
    </form>

    <?php

        require "config.php";

        $connection = new mysqli($host, $username, $password, $dbname);

        if($connection->connect_error){
            die("Connection failed: " . $connection->connect_error);
        }

        $statement = $connection->prepare("SELECT p.firstname, p.lastname FROM players AS p, teams AS t WHERE p.teamID=t.id AND t.teamname=?");
        $statement->bind_param("s", $teamname);

        $teamname = $_POST['teamname'];
        $statement->execute();
        $result = $statement->get_result();

        while($row = $result->fetch_assoc()){
            echo $row['firstname'] . " " . $row['lastname'] . "<br />";
        }

        $statement->close();
        $connection->close();
    ?>

    <a href="index.php">Back to home</a>

<?php include "templates/footer.php"; ?>