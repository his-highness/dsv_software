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
?>