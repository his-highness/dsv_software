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

	$dbc = mysqli_connect("localhost", "tester", "123456", "tinker_db");

	$query = "SELECT p_code, name FROM project WHERE status = 1";

	$result = mysqli_query($dbc, $query) or (mysqli_info());

	$available = array();

	while($row=mysqli_fetch_row($result)) {
		$status = avail_for_atten($row[0], $date);
		if($status) {
			$available[] = array($row[0], $row[1]);
		}
	}
			
	
	if(sizeof($available)>0) {

	// The Table Header
?>
			<table border="1">
				<thead>
					<tr>
						<th>Project Code</th>
						<th>Project Name</th>
						<th>Option</th>
					</tr>
				</thead>

				<tbody>
<?php					

	// All the projects with running status
	
		for($i=0; $i<sizeof($available); $i++) {	
				echo '<tr>';
				echo '<td>'.$available[$i][0].'</td><td>'.$available[$i][1].'</td>';
				echo "<td><a href=\"atten.php?p_c={$available[$i][0]}&p_n={$available[$i][1]}\">Take Attendance</a></td>";
				echo '</tr>';	
		}
?>
				</tbody>
			</table>
<?php

	} else {
		echo '<p>No more projects to take attendance today</p>';
	}

	mysqli_close($dbc);
?>
		</body>
	</html>
