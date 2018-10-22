<?php

	/* Checks if a project is available for taking attendance or not, by going through the emp_atten and all_absent relation*/
	function avail_for_atten($project_code, $date, $db_conn) {

		$atten_rel = "SELECT COUNT(emp_atten.p_code) AS num FROM emp_atten INNER JOIN project ON emp_atten.p_code = project.p_code WHERE emp_atten.p_code = $project_code AND emp_atten.dated = $date";

		$absent_rel ="SELECT COUNT(all_absent.p_code) AS num FROM all_absent INNER JOIN project ON all_absent.p_code = project.p_code WHERE all_absent.p_code = $project_code AND all_absent.dated = $date";

		$atten_result = mysqli_query($db_conn, $atten_rel) or die(mysqli_error($db_conn));

		$absent_result = mysqli_query($db_conn, $absent_rel) or die(mysqli_error($db_conn));

		$numa = mysqli_fetch_row($atten_result);
		$numb = mysqli_fetch_row($absent_result);

		if($numa[0] > 0 || $numb[0] > 0) {
			return false;
		} else {
			return true;
		}
	}


	/* Generates an array filled with the details of the projects which are available for taking attendance */
	function avail_arr_gen($db_conn, $date) {
		$query = "SELECT p_code, name FROM project WHERE status = 1";

		$result = mysqli_query($db_conn, $query) or (mysqli_info());

		$available = array();

		while($row=mysqli_fetch_row($result)) {
			$status = avail_for_atten($row[0], $date, $db_conn);
			if($status) {
				$available[] = array($row[0], $row[1]);
			}
		}

		return $available;
	}


	/* Generates a list of all the projects which are available for taking attendance, for users to see */
	function pro_list_gen($pro_det_array) {

		if(sizeof($pro_det_array)>0) {

 		// Generating table header
 		$head_arr = array('Project Code', 'Project Name', 'Option');
 		table_head_gen($head_arr);					

		// All the projects with running status
	
		for($i=0; $i<sizeof($pro_det_array); $i++) {	
				echo '<tr>';
				echo '<td>'.$pro_det_array[$i][0].'</td><td>'.$pro_det_array[$i][1].'</td>';
				echo "<td><a href=\"atten.php?p_c={$pro_det_array[$i][0]}&p_n={$pro_det_array[$i][1]}\">Take Attendance</a></td>";
				echo '</tr>';	
		}
?>
				</tbody>
			</table>
<?php

		} else {
			echo '<p>No more projects to take attendance today, proceed to add <a href="projects_cost.php">costs</a> and <a href="projects_timing.php">timings</a>.</p>';
		}
	}

	/* Generates a table header, taking array filled with header details as the parameter */
	function table_head_gen($head_array) {

?>
			<table border="1">
				<thead>
					<tr>
<?php
			foreach ($head_array as $head_name) {
				echo "<th>$head_name</th>";
			}
?>				
					</tr>
				</thead>
				<tbody>
<?php				
	}


	/* Generates an array with a list of projects for which the attendance is taken but the costs have not been added */
	function avail_for_cost($db_conn, $date) {
		// Attendance taken for projects for today's date
		$pro_atten = "SELECT DISTINCT p_code FROM emp_atten WHERE dated = $date";

		// Cost taken for projects for today's date
		$pro_cost = "SELECT DISTINCT emp_atten.p_code FROM (( emp_atten INNER JOIN project ON emp_atten.p_code = project.p_code) INNER JOIN emp_cost ON emp_atten.p_code = emp_cost.p_code) WHERE emp_cost.dated = $date AND project.status = 1";

		$pro_atten_res = mysqli_query($db_conn, $pro_atten) or die('Project Attendance: '.mysqli_error($db_conn));

		$pro_cost_res = mysqli_query($db_conn, $pro_cost) or die('Project Cost: '.mysqli_error($db_conn));

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

		return $pro_ca_arr;
	}


	/* Gets the project details: name from db, taking an array filled with p_codes as the parameter */
	function pro_names($db_conn, $pro_code_array) {
		$pi_arr = array();

		foreach ($pro_code_array as $pro_code) {
			$pro_info_query = "SELECT p_code, name FROM project WHERE p_code = $pro_code";

			$pi_query_res = mysqli_query($db_conn, $pro_info_query) or die("pro_names functions: " . mysqli_error($db_conn));

			$row = mysqli_fetch_row($pi_query_res);

			$pi_arr[] = array($row[0], $row[1]);
		}

		return $pi_arr;
	}

	/* Generates the list of projects available for adding costs, for the user to see */
	function cost_list_gen($db_conn, $p_code_arr) {

		if(sizeof($p_code_arr)>0) {
		
			$pi_arr = pro_names($db_conn, $p_code_arr);

			// Generating table header
			$head_arr = array('Project Code', 'Project Name', 'Option');
			table_head_gen($head_arr);

			foreach ($pi_arr as $pi_arr_elem) {
				echo "<tr><td>".$pi_arr_elem[0]."</td><td>".$pi_arr_elem[1]."</td><td><a href=\"cost_store.php?p_c={$pi_arr_elem[0]}&p_n={$pi_arr_elem[1]}\">Add Costs</a></td></tr>";
			}
?>
				</tbody>
			</table>
<?php
		} else {
			echo '<p>No projects to add costs, take employee <a href="projects.php">attendance</a> or add <a href="projects_timing.php">employee timings</a>.</p>';
		}
	}

	/* Generates an array with a list of projects for which the attendance is taken but the timings have not been added */
	function avail_for_time($db_conn, $date) {
		// Attendance taken for projects for today's date
		$pro_atten = "SELECT DISTINCT p_code FROM emp_atten WHERE dated = $date";

		// Time taken for projects for today's date
		$pro_time = "SELECT DISTINCT emp_atten.p_code FROM (( emp_atten INNER JOIN project ON emp_atten.p_code = project.p_code) INNER JOIN emp_time ON emp_atten.p_code = emp_time.p_code) WHERE emp_time.dated = $date AND project.status = 1";

		$pro_atten_res = mysqli_query($db_conn, $pro_atten) or die('Project Attendance: '.mysqli_error($db_conn));

		$pro_time_res = mysqli_query($db_conn, $pro_time) or die('Project Timing: '.mysqli_error($db_conn));

		$pro_atten_arr = array(); // Store pro_atten_res result

		$pro_time_arr = array(); // Store pro_time_res result

		// Loop to store pro_atten_res result
		while($row=mysqli_fetch_row($pro_atten_res)) {
			$pro_atten_arr[] = $row[0];
		}

		// Loop to store pro_time_res result
		while($row=mysqli_fetch_row($pro_time_res)) {
			$pro_time_arr[] = $row[0];
		}

		// Array to store project code for adding costs
		$pro_ta_arr = array();

		if (sizeof($pro_time_arr)==0) {
			$pro_ta_arr = $pro_atten_arr;
		} else {
			for($i=0;$i<sizeof($pro_atten_arr);$i++) {
				if(!is_int(array_search($pro_atten_arr[$i], $pro_time_arr))) {
					$pro_ta_arr[] = $pro_atten_arr[$i];
				}
			}		
		}

		return $pro_ta_arr;
	}

	/* Generates the list of projects available for adding costs, for the user to see */
	function time_list_gen($db_conn, $p_code_arr) {

		if(sizeof($p_code_arr)>0) {
			// Getting project name details 
			$pi_arr = pro_names($db_conn, $p_code_arr);

			// Generating table header
			$head_arr = array('Project Code', 'Project Name', 'Option');
			table_head_gen($head_arr);

			foreach ($pi_arr as $pi_arr_elem) {
				echo "<tr><td>".$pi_arr_elem[0]."</td><td>".$pi_arr_elem[1]."</td><td><a href=\"time_store.php?p_c={$pi_arr_elem[0]}&p_n={$pi_arr_elem[1]}\">Add Timings</a></td></tr>";
			}

		} else {
			echo '<p>No projects to add timings, take employee <a href="projects.php">attendance</a>, or add <a href="projects_cost.php">employee costs</a>.</p>';
		}
	}

	/* Generates an array with employee details: Id, Name, Contractor's name, while taking Project code as parameter */
	function emp_det_gen($db_conn, $pro_code) {
		
		$query = "SELECT employee.e_id, employee.name, employee.cont_name FROM employee INNER JOIN on_project ON employee.e_id = on_project.emp_id WHERE on_project.p_code = $pro_code";

		$result = mysqli_query($db_conn, $query) or die("emp_det_arr function: ".mysqli_error($db_conn));

		$arr = array();

		while($row=mysqli_fetch_row($result)) {
			$arr[] = array($row[0], $row[1], $row[2]);
		}

		return $arr;
	}

	/* Generating attendance form for the users, for taking employee attendance */
	function gen_atten_form($emp_det_arr, $pro_code, $date) {
?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<?php
		// Generating table header
		$head_arr = array('Employee ID', 'Name', 'Contractor\'s Name', 'Present');
		table_head_gen($head_arr);

		foreach ($emp_det_arr as $emp_elem) {
			echo "<tr><td>{$emp_elem[0]}</td><td>{$emp_elem[1]}</td><td>{$emp_elem[2]}</td><td><input type='checkbox' name='present[]' value='{$emp_elem[0]}' /></td></tr>";
		}

?>
				</tbody>
			</table>
			<input type="hidden" name="date" value="<?php echo $date;?>" />
			<input type="hidden" name="p_c" value="<?php echo $pro_code;?>" />
			<input type="submit" value="Save attendance" name="submit" />
		</form>	
		<a href="all_absent.php?p_code=<?php echo $pro_code; ?>&date=<?php echo $date; ?>">All Absent</a>
<?php				
	}

	
	/* Storing attendance for the employees present on a particular day, taking db_conn, an array filled with present emp_id, pro_code and date as parameters */
	function store_atten($db_conn, $emp_pre_arr, $pro_code, $date) {
		
		if(sizeof($emp_pre_arr)>0) {
			/* Formation of the query, instead of multiple queries, a single query is executed to store attendance */ 

			$query = "INSERT INTO emp_atten VALUES";

			for($i=0;$i<sizeof($emp_pre_arr);$i++) {
				$pv = (int)$emp_pre_arr[$i];
				$query .= " ($pv, $pro_code, $date)";
				if($i < sizeof($emp_pre_arr) - 1) {
					$query .= ",";
				}
			}
			$query .= ";";

			$result = mysqli_query($db_conn, $query) or die('store_atten function: '.mysqli_error($db_conn));

			if($result) {
				echo "<h3>Attendance stored successfully</h3>";
				echo "<p><a href='projects.php'>Take attendance for another project</a><p>";
				echo "<p><a href='projects_cost.php'>Add costs and timings</a></p>";
			} else {
				echo "<h4>Error saving in the database, please try again or contact the system administrator</h4>";
			}
		} else {
			echo '<p>Error: Please choose at least one employee for taking attendance.</p>';
			echo '<a href="projects.php">Go back to projects</a>';
		}
	}

	
	/* Get the costs of breakfast, lunch, dinner and transportation, in an array */
	function get_total($db_conn, $pro_code, $date) {
		$query = "SELECT SUM(bf), SUM(lc), SUM(dn), SUM(tn) FROM emp_cost WHERE p_code = {$pro_code} AND dated = {$date}";

		$result = mysqli_query($db_conn, $query) or die('get_total function: ' . mysqli_error($db_conn));

		$arr = array();
		$row = mysqli_fetch_row($result);
		foreach($row as $cost) {
			$arr[] = $cost;
		}

		return $arr;
	}

	
	/* Get the cost of the food for a particular project code and date */
	function get_food_cost($db_conn, $pro_code, $date) {
		
		$total = get_total($db_conn, $pro_code, $date);
		
		$cost = 0;

		for($i=0;$i<3;$i++) {
			$cost += $total[$i];
		}

		return $cost;
	}

	
	/* Get the total cost by the employee for the day */
	function get_total_cost($db_conn, $pro_code, $date) {

		$total = get_total($db_conn, $pro_code, $date);

		$total_cost = 0;

		foreach($total as $cost) {
			$total_cost += $cost;
		}

		return $total_cost;
	}


	/* Get the list of running projects */
	function run_pro($db_conn, $date = "" ) {
		$query = "SELECT p_code, name FROM project WHERE status = 1";

		$result = mysqli_query($db_conn, $query) or die('run_pro function: ' . mysqli_error($db_conn));

		$arr = array();

		while($row=mysqli_fetch_array($result)) {
			$arr[] = array($row[0], $row[1]);
		}

		return $arr;
	}

	/* Generate form for viewing the project details */
	function gen_view_form($running_project_array, $error) {
		if($error) {
			echo '<p>Please fill all fields with valid values</p>';
		}
?>			
		<form method="get" action="view_emp_cost.php">
			<label for="pro_code">Project Code</label>
			<select name="pro_code">
				<option value="none">Choose Project</option>
<?php
	foreach($running_project_array as $pro_det) {
		echo "<option value='{$pro_det[0]}'>{$pro_det[1]}</option>";
	}	
?>
			</select>

			<label for="dated">Date</label>
			<input type="date" name="dated" />

			<input type="submit" name="submit" value="View Details" />
		</form>
<?php		
	}

	/* Get project detail from database */
	function get_pro_det($db_conn, $pro_code, $detail) {
		$query = "SELECT $detail FROM project WHERE p_code = {$pro_code}";

		$result = mysqli_query($db_conn, $query) or die('get_pro_det function: '.mysqli_error($db_conn));

		$row = mysqli_fetch_array($result);

		return $row[0];
	}


