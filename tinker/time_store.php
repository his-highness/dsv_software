<!DOCTYPE html5>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<title>Add Timing | D S V</title>
			<link rel="stylesheet" type="text/css" href=""/>
		</head>
		<body>
			<h1>Add In and Out Timings</h1>
<?php
	$date = date_format(date_create(), 'Y-m-d');
	$date_query = (int)implode("", explode("-", $date));

	// When page continues from projects_cost.php
	if(isset($_GET['p_c']) && isset($_GET['p_n'])) {
		$p_code = $_GET['p_c'];
		$p_name = $_GET['p_n'];

		echo "<h2>{$p_name}</h2>";
		echo "<h2>{$date}</h2>";
		if(isset($_GET['err'])) {
			echo '<p>Please fill all the fields, and try again</p>';
		}

		$dbc = mysqli_connect('localhost', 'tester', '123456', 'tinker_db') or die(mysqli_error());

		$query = "SELECT employee.e_id, employee.name, employee.cont_name FROM employee INNER JOIN emp_atten ON employee.e_id = emp_atten.emp_id WHERE emp_atten.p_code = {$p_code} AND emp_atten.dated = {$date_query}";

		$result = mysqli_query($dbc, $query) or die(mysqli_error());

		// To store the present employee ids
		$ei_arr = array();

?>
			<form method="post" action="time_store.php">  
				<table border="1">
					<thead>
						<tr>
							<th>Name</th>
							<th>Contractor's Name</th>
							<th>In Time</th>
							<th>Out Time</th>
						</tr>
					</thead>
					<tbody>
<?php
		while($row=mysqli_fetch_row($result)) {
			// Attribute name will have the following pattern
			$it = 'it'.$row[0];			
			$ot = 'ot'.$row[0];

			echo "<tr><td>$row[1]</td><td>$row[2]</td>";
			echo '<td><input type="time" name="'.$it.'" placeholder="00:00" value="'.(isset($_GET[$it]) ? $_GET[$it] : "").'"/></td>';
			echo '<td><input type="time" name="'.$ot.'" placeholder="00:00" value="'.(isset($_GET[$ot]) ? $_GET[$ot] : "").'"/></td>';
			echo '<input type="hidden" name="eia[]" value="'. $row[0] . '" />';
		}
?>
					</tbody>
				</table>

				<input type="hidden" name="p_c" value="<?php echo $p_code; ?>" />
				<input type="hidden" name="p_n" value="<?php echo $p_name; ?>" />
				<input type="submit" name="time_submit" value="Save Timings" />
			</form>	
<?php
	
	}

	// When the form is submitted after adding costs
	if(isset($_POST['time_submit'])) {

		$ei_arr = $_POST['eia'];
		$p_code = $_POST['p_c'];
		$p_name = $_POST['p_n'];

		$all_filled = true;

		// Loop to check if all the fields are filled
		// and of numeric type
		foreach($ei_arr as $value) {
			$it = 'it'.$value;
			$ot = 'ot'.$value;

			if(empty($_POST[$it])) {
				$all_filled = false;
			}
			
			if(empty($_POST[$ot])) {
				$all_filled = false;
			}
		}
		
		// If all the fields are not filled, redirect back
		// to the adding costs form
		if(!$all_filled) {
			$url = "time_store.php?p_c={$p_code}&p_n={$p_name}&err=1";
			foreach($ei_arr as $value) {
			$it = 'it'.$value;
			$ot = 'ot'.$value;

			$url .= "&{$it}={$_POST[$it]}&{$ot}={$_POST[$ot]}";

		}	
			header("Location: $url");
			exit();
		} else {
			$dbc = mysqli_connect('localhost', 'tester', '123456', 'tinker_db') or die(mysqli_error());

			$ts_query = "INSERT INTO emp_time VALUES ";

			// Building the query to save the costs 
			for($i=0;$i<sizeof($ei_arr);$i++) {
				$it = (string)'it'.$ei_arr[$i];
				$ot = (string)'ot'.$ei_arr[$i];

				$ts_query .= "({$ei_arr[$i]}, {$p_code}, {$date_query}, '{$_POST[$it]}', '{$_POST[$ot]}')";
				if($i < sizeof($ei_arr)-1) {
					$ts_query .= ", ";
				}
			}

			$ts_query .= ";";

			$ts_query_res = mysqli_query($dbc, $ts_query) or die(mysqli_error($dbc));

			if ($ts_query_res) {
				echo "<p>Timings succesesfully saved in the database, <a href=\"projects_timing.php\">add more timings</a> or <a href=\"projects_cost.php\">add costs</a></p> ";
			} else {
				echo "<p>Operation failed, please try again</p><a href=\"timing_store.php?p_c={$p_code}&p_n={$p_name}\">Go back</a>";
			}
		} 				
	}
		
	mysqli_close($dbc);
?>

		</body>
	</html>