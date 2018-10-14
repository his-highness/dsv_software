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
	$db = mysqli_connect("localhost", "tester", "123456", "tinker_db");

	$query = "SELECT p_code, name FROM project WHERE status = 1;";
	
	$result = mysqli_query($db, $query) or ("Result fucked");

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

	while($row = mysqli_fetch_row($result)) {
		echo '<tr>';
		echo '<td>'.$row[0].'</td><td>'.$row[1].'</td>';
		echo "<td><a href=\"atten.php?p_c={$row[0]}&p_n={$row[1]}\">Take Attendance</a></td>";
		echo '</tr>';
	}
?>
				</tbody>
			</table>
<?php
	mysqli_close($db);
?>
		</body>
	</html>
