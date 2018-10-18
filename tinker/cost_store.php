<!DOCTYPE html5>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<title>Add Costs | D S V</title>
			<link rel="stylesheet" type="text/css" href=""/>
		</head>
		<body>
			<h1>Add Costs</h1>
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
			<form method="post" action="cost_store.php">  
				<table border="1">
					<thead>
						<tr>
							<th>Name</th>
							<th>Contractor's Name</th>
							<th>Breakfast</th>
							<th>Lunch</th>
							<th>Dinner</th>
							<th>Transport</th>
						</tr>
					</thead>
					<tbody>
<?php
		while($row=mysqli_fetch_row($result)) {
			// Attribute name will have the following pattern
			$bf = 'bf'.$row[0];			
			$lc = 'lc'.$row[0];			
			$dn = 'dn'.$row[0];			
			$tn = 'tn'.$row[0];

			echo "<tr><td>$row[1]</td><td>$row[2]</td>";
			echo '<td><input type="number" min="0" max="999" step="any" name="'.$bf.'" placeholder="000.00" value="'.(isset($_GET[$bf]) ? $_GET[$bf] : "").'"/></td>';
			echo '<td><input type="number" min="0" max="999" step="any" name="'.$lc.'" placeholder="000.00" value="'.(isset($_GET[$lc]) ? $_GET[$lc] : "").'"/></td>';
			echo '<td><input type="number" min="0" max="999" step="any" name="'.$dn.'" placeholder="000.00" value="'.(isset($_GET[$dn]) ? $_GET[$dn] : "").'"/></td>';
			echo '<td><input type="number" min="0" max="999" step="any" name="'.$tn.'" placeholder="000.00" value="'.(isset($_GET[$tn]) ? $_GET[$tn] : "").'"/></td></tr>';
			echo '<input type="hidden" name="eia[]" value="'. $row[0] . '" />';
		}
?>
					</tbody>
				</table>

				<input type="hidden" name="p_c" value="<?php echo $p_code; ?>" />
				<input type="hidden" name="p_n" value="<?php echo $p_name; ?>" />
				<input type="submit" name="cost_submit" value="Save Costs" />
			</form>	
<?php
	
	}

	// When the form is submitted after adding costs
	if(isset($_POST['cost_submit'])) {

		$ei_arr = $_POST['eia'];
		$p_code = $_POST['p_c'];
		$p_name = $_POST['p_n'];

		$all_filled = true;

		// Loop to check if all the fields are filled
		// and of numeric type
		foreach($ei_arr as $value) {
			$bf = 'bf'.$value;
			$lc = 'lc'.$value;
			$dn = 'dn'.$value;
			$tn = 'tn'.$value;

			if(!(!empty($_POST[$bf]) && is_numeric($_POST[$bf]))) {
				$all_filled = false;
			}
			
			if(!(!empty($_POST[$lc]) && is_numeric($_POST[$lc]))) {
				$all_filled = false;
			}

			if(!(!empty($_POST[$dn]) && is_numeric($_POST[$dn]))) {
				$all_filled = false;
			}

			if(!(!empty($_POST[$tn]) && is_numeric($_POST[$tn]))) {
				$all_filled = false;
			}
		}
		
		// If all the fields are not filled, redirect back
		// to the adding costs form
		if(!$all_filled) {
			$url = "cost_store.php?p_c={$p_code}&p_n={$p_name}&err=1";
			foreach($ei_arr as $value) {
			$bf = 'bf'.$value;
			$lc = 'lc'.$value;
			$dn = 'dn'.$value;
			$tn = 'tn'.$value;
			$url .= "&{$bf}={$_POST[$bf]}&{$lc}={$_POST[$lc]}&{$dn}={$_POST[$dn]}&{$tn}={$_POST[$tn]}";

		}	
			header("Location: $url");
			exit();
		} else {
			$dbc = mysqli_connect('localhost', 'tester', '123456', 'tinker_db') or die(mysqli_error());

			$cs_query = "INSERT INTO emp_cost VALUES ";

			// Building the query to save the costs 
			for($i=0;$i<sizeof($ei_arr);$i++) {
				$bf = 'bf'.$ei_arr[$i];
				$lc = 'lc'.$ei_arr[$i];
				$dn = 'dn'.$ei_arr[$i];
				$tn = 'tn'.$ei_arr[$i];

				$cs_query .= "({$ei_arr[$i]}, {$p_code}, {$date_query}, {$_POST[$bf]}, {$_POST[$lc]}, {$_POST[$dn]}, {$_POST[$tn]})";
				if($i < sizeof($ei_arr)-1) {
					$cs_query .= ", ";
				}
			}

			$cs_query .= ";";
			
			$cs_query_res = mysqli_query($dbc, $cs_query) or die(mysqli_error());

			if ($cs_query_res) {
				echo "<p>Costs succesesfully saved in the database, <a href=\"projects_cost.php\">add more costs</a></p> ";
			} else {
				echo "<p>Operation failed, please try again</p><a href=\"cost_store.php?p_c={$p_code}&p_n={$p_name}"">Go back</a>";
			}
		} 				
	}
		
	mysqli_close($dbc);
?>

		</body>
	</html>