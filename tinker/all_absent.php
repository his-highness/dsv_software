<?php
	if ( isset($_GET['p_code']) && isset($_GET['date'])) {

		// Generating date in proper format
		$date = (int)implode("", explode("-", $_GET['date']));

		$dbc = mysqli_connect('localhost', "root", "", 'tinker_db') or die(mysqli_error());

		$query = "INSERT INTO all_absent VALUES ({$_GET['p_code']}, {$date})";

		$result = mysqli_query($dbc, $query) or die(mysqli_error());

		if($result) {
			echo '<p>Attendance saved, take attendance for another <a href="projects.php">project</a></p>';
		}
	}
?>
