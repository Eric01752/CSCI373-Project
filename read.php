<?php include "templates/header.php"; ?>

    <h2>Find player based on team</h2>

    <form method="post">
    	<label for="team">Team</label>
    	<input type="text" id="team" name="team">
    	<input type="submit" name="submit" value="View Results">
    </form>

    <a href="index.php">Back to home</a>

<?php include "templates/footer.php"; ?>