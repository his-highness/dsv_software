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

?>