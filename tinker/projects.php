<!-- To generate a list of ongoing projects, for which attendance will be taken -->

<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<title>List Of Projects</title>
			<link rel="stylesheet" type="text/css" href=""/>
		</head>
		<body>
			<h1>List of Ongoing Projects</h1>
<?php
	require_once('avail_for_atten.php');

	$date = (int)implode("", explode("-", date_format(date_create(), 'Y-m-d')));

	$dbc = mysqli_connect("localhost", "root", "", "tinker_db");

	// Generates an array with the details for available projects
	$available = avail_arr_gen($dbc, $date);

	mysqli_close($dbc);

	// Generates a list of available projects for the users to see
	pro_list_gen($available);

?>
		</body>
	</html>
