<?php include "templates/header.php"; ?>

    <h2>Add a player</h2>

    <form method="post">
        <label for="team">Team</label>
        <input type="text" id="team" name="team">
    	<label for="firstname">First Name</label>
    	<input type="text" name="firstname" id="firstname">
    	<label for="lastname">Last Name</label>
    	<input type="text" name="lastname" id="lastname">
    	<label for="age">Age</label>
    	<input type="text" name="age" id="age">
        <label for="position">Position</label>
        <input type="text" id="position" name="position">
    	<input type="submit" name="submit" value="Submit">
    </form>

    <a href="index.php">Back to home</a>

<?php include "templates/footer.php"; ?>