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
	$date = (int)implode("", explode("-", date_format(date_create(), 'Y-m-d')));

	$dbc = mysqli_connect("localhost", "tester", "123456", "tinker_db");

	$query = "SELECT p_code, name FROM project WHERE status = 1";

	$result = mysqli_query($dbc, $query) or (mysqli_info());

	if($check=mysql_num_rows($result)) {

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
	
		while($row=mysqli_fetch_row($result)) {

		$query1 = "SELECT * FROM emp_atten WHERE p_code = {$row[0]} AND dated = {$date}";

		$query2 = "SELECT * FROM all_absent WHERE p_code = {$row[0]} AND dated = {$date}";

		$result1 = mysqli_query($dbc, $query1) or die(mysqli_error());
		$result2 = mysqli_query($dbc, $query2) or die(mysqli_error()); 

			if (!($row1 = mysqli_fetch_row($result1)) && !($row2 = mysqli_fetch_row($result2))) {
				
				echo '<tr>';
				echo '<td>'.$row[0].'</td><td>'.$row[1].'</td>';
				echo "<td><a href=\"atten.php?p_c={$row[0]}&p_n={$row[1]}\">Take Attendance</a></td>";
				echo '</tr>';	

			}
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
