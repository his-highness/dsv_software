<!-- To generate a list of employees in a particular project, for which attendance will be taken -->

<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<title>Attendance | DSV</title>
			<link rel="stylesheet" type="text/css" href=""/>
		</head>
		<body>
			<h1>Daily Employee Attendance</h1>
<?php
	require_once('avail_for_atten.php');

	$date_fancy = date_format(date_create(), "d M, Y");
	$date = date_format(date_create(), "Y-m-d");

	$dbc = mysqli_connect("localhost",  "root", "", "tinker_db") or die("Error connecting to the database - 1");

	if (isset($_GET['p_c']) && isset($_GET['p_n'])) {
	// Present day Date, Project code and Project name
	$p_code = $_GET['p_c'];
	$p_name = $_GET['p_n'];

	echo "<h2>{$p_name}</h2>";
	echo "<h3>{$date_fancy}</h3>";

	// Generate the array containing employee details
	$arr = emp_det_gen($dbc, $p_code);

	// Generate a form for taking attendance
	gen_atten_form($arr, $p_code, $date);

	} else if (isset($_POST['submit'])) {
		$present = (isset($_POST['present']) ? $_POST['present'] : array());
		$p_code = (isset($_POST['p_c']) ? $_POST['p_c'] : "");
		$date = (int)implode("", explode("-", (isset($_POST['date']) ? $_POST['date'] : date_format(date_create(), "Y-m-d"))));

		// Storing the employee attendance in db
		store_atten($dbc, $present, $p_code, $date);

	}
?>
		</body>
	</html>
