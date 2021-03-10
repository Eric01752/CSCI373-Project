<?php include "templates/header.php"; ?>

    <?php
        //Check if form was submitted
        if(isset($_POST['submit'])){

            require "database/db_functions.php";

            //Form data array
            $data = array("teamname" => $_POST['teamname']);
            //Custom database insert function
            db_insert("teams", $data);
        }
    ?>

    <h2>Add a team</h2>

    <?php
        //Check if form was submitted and data provided
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