<?php include "templates/header.php"; ?>

    <?php
        if(isset($_POST['submit'])){

            require "config.php";

            $connection = new mysqli($host, $username, $password, $dbname);

            if($connection->connect_error){
                die("Connection failed: " . $connection->connect_error);
            }

            $statement = $connection->prepare("INSERT INTO teams (teamname) VALUES (?)");
            $statement->bind_param("s", $teamname);

            $teamname = $_POST['teamname'];
            $statement->execute();

            $statement->close();
            $connection->close();
        }
    ?>

    <h2>Add a team</h2>

    <?php
        if(isset($_POST['submit']) && isset($_POST['teamname'])){
            echo "<p>" . $_POST['teamname'] . " was succesfully added.</p>";
        }
    ?>

    <form method="post">
        <label for="teamname">Enter Team Name:</label>
        <input type="text" id="teamname" name="teamname">
        <input type="submit" name="submit" value="submit">
    </form>

    <a href="index.php">Back to home</a>

<?php include "templates/footer.php"; ?>