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
	// Present day Date, Project code and Project name
	$date = date_format(date_create(), "Y-m-d");
	$p_code = $_GET['p_c'];
	$p_name = $_GET['p_n'];

	echo "<h2>{$p_name}</h2>";
	echo "<h3>{$date}</h3>";

	$dbc = mysqli_connect("localhost", "tester", "123456", "tinker_db") or die("Error connecting to the database - 1");

	$query = "SELECT employee.e_id, employee.name, employee.cont_name FROM employee INNER JOIN on_project ON employee.e_id = on_project.emp_id WHERE on_project.p_code = $p_code";

	$result = mysqli_query($dbc, $query);
	// Table Header
?>
		<form method="post" action="store.php">
			<table border="1">
				<thead>
					<tr>
						<th>Employee ID</th>
						<th>Name</th>
						<th>Contractor's Name</th>
						<th>Present</th>
					</tr>
				</thead>
				<tbody>
<?php
	
	while($row=mysqli_fetch_row($result)) {
		echo "<tr><td>{$row[0]}</td><td>{$row[1]}</td><td>{$row[2]}</td>";
		echo "<td><input type='checkbox' name='present[]' value='{$row[0]}' /></td></tr>";
	}
	mysqli_close($dbc);
?>
				</tbody>
			</table>
			<input type="hidden" name="date" value="<?php echo $date;?>" />
			<input type="hidden" name="p_c" value="<?php echo $p_code;?>" />
			<input type="submit" value="Save attendance" name="submit" />
		</form>	
		<a href="all_absent.php?p_code=<?php echo $p_code; ?>&date=<?php echo $date; ?>">All Absent</a>
		</body>
	</html>
