<?php
	function avail_for_atten($project_code, $date) {
		$dbc = mysqli_connect('localhost', 'tester', '123456', 'tinker_db') or die(mysqli_error());

		$atten_rel = "SELECT COUNT(emp_atten.p_code) AS num FROM emp_atten INNER JOIN project ON emp_atten.p_code = project.p_code WHERE emp_atten.p_code = $project_code AND emp_atten.dated = $date";

		$absent_rel ="SELECT COUNT(all_absent.p_code) AS num FROM all_absent INNER JOIN project ON all_absent.p_code = project.p_code WHERE all_absent.p_code = $project_code AND all_absent.dated = $date";

		$atten_result = mysqli_query($dbc, $atten_rel) or die(mysqli_error());

		$absent_result = mysqli_query($dbc, $absent_rel) or die(mysqli_error());

		$numa = mysqli_fetch_row($atten_result);
		$numb = mysqli_fetch_row($absent_result);

		if($numa[0] > 0 || $numb[0] > 0) {
			return false;
		} else 
			return true;
	}
?>