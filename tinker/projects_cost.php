<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<title>Add Food Cost | D S V</title>
			<link rel="stylesheet" type="text/css" href=""/>
		</head>
		<body>
			<h1>Add Food Cost</h1>
<?php
	require_once('avail_for_atten.php');

	$date = (int)implode("", explode("-", date_format(date_create(), 'Y-m-d')));

	$dbc = mysqli_connect('localhost',  "root", "", 'tinker_db') or die(mysqli_error());

	// An array with pro codes for available projects
	$pro_ca_arr = avail_for_cost($dbc, $date);

	// Generates a list, for the users to see
	cost_list_gen($dbc, $pro_ca_arr);

	mysqli_close($dbc);
?>
		</body>
	</html>
