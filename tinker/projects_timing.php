<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<title>Add Timing | D S V</title>
			<link rel="stylesheet" type="text/css" href=""/>
		</head>
		<body>
			<h1>Add In and Out Timings</h1>
<?php
	require_once('avail_for_atten.php');

	$date = (int)implode("", explode("-", date_format(date_create(), 'Y-m-d')));

	$dbc = mysqli_connect('localhost',  "root", "", 'tinker_db') or die(mysqli_error());

	// Getting the list of project codes availble for time addition
	$pro_ta_arr = avail_for_time($dbc, $date);

	// Generating a list of project details for users to see
	time_list_gen($dbc, $pro_ta_arr);

	mysqli_close($dbc);
?>

		</body>
	</html>
