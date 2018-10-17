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

	$date = (int)implode("", explode("-", date_format(date_create(), 'Y-m-d')));

	$dbc = mysqli_connect('localhost', 'tester', '123456', 'tinker_db') or die(mysqli_error());

	// Attendance taken for projects for today's date
	$pro_atten = "SELECT DISTINCT p_code FROM emp_atten WHERE dated = $date";

	// Cost taken for projects for today's date
	$pro_cost = "SELECT DISTINCT emp_atten.p_code FROM (( emp_atten INNER JOIN project ON emp_atten.p_code = project.p_code) INNER JOIN emp_cost ON emp_atten.p_code = emp_cost.p_code) WHERE emp_cost.dated = $date AND project.status = 1";

	$pro_atten_res = mysqli_query($dbc, $pro_atten) or die('Project Attendance: '.mysqli_error());

	$pro_cost_res = mysqli_query($dbc, $pro_cost) or die('Project Cost: '.mysqli_error());

	$pro_atten_arr = array(); // Store pro_atten_res result

	$pro_cost_arr = array(); // Store pro_cost_res result

	// Loop to store pro_atten_res result
	while($row=mysqli_fetch_row($pro_atten_res)) {
		$pro_atten_arr[] = $row[0];
	}

	// Loop to store pro_cost_res result
	while($row=mysqli_fetch_row($pro_cost_res)) {
		$pro_cost_arr[] = $row[0];
	}

	// Array to store project code for adding costs
	$pro_ca_arr = array();

	if (sizeof($pro_cost_arr)==0) {
		$pro_ca_arr = $pro_atten_arr;
	} else {
		for($i=0;$i<sizeof($pro_atten_arr);$i++) {
			if(!is_int(array_search($pro_atten_arr[$i], $pro_cost_arr))) {
				$pro_ca_arr[] = $pro_atten_arr[$i];
			}
		}		
	}


	if(sizeof($pro_ca_arr)>0) {
		$pi_arr = array();

		for($j=0;$j<sizeof($pro_ca_arr);$j++) {
			$pro_info_query = "SELECT p_code, name FROM project WHERE p_code = $pro_ca_arr[$j]";

			$pi_query_res = mysqli_query($dbc, $pro_info_query) or die("Project info retrieving: " . mysqli_error());

			$row = mysqli_fetch_row($pi_query_res);

			$pi_arr[] = array($row[0], $row[1]);
		}

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
		for($k=0;$k<sizeof($pi_arr);$k++) {
			echo "<tr><td>".$pi_arr[$k][0]."</td><td>".$pi_arr[$k][1]."</td><td>coming soon</td></tr>";
		}

	} else {
		echo '<p>No projects to add costs</p>';
	}
	

?>			
		</body>
	</html>