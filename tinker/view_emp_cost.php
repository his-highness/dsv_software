<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<title>View Costs | D S V</title>
			<link rel="stylesheet" type="text/css" href=""/>
		</head>
		<body>
<?php
	require_once('avail_for_atten.php');

	$dbc = mysqli_connect('localhost', 'tester', '123456', 'tinker_db') or die(mysqli_error($dbc));

	$run_pro_arr = run_pro($dbc);

	if(isset($_GET['submit'])) {
		if((isset($_GET['pro_code']) && $_GET['pro_code']!='none') && (isset($_GET['dated']) && ($_GET['dated']!=""))) {
			$head_arr = array('Amenity', 'Cost');
			
			$date=(int)implode("",explode("-", $_GET['dated']));
			
			$total = get_total($dbc, $_GET['pro_code'], $date);
			
			$tot_cost = get_total_cost($dbc, $_GET['pro_code'], $date);
			echo "<h1>".get_pro_det($dbc, $_GET['pro_code'], 'name')."</h1>";
			echo "<h2>Project Code: ". $_GET['pro_code']."</h2>";
			echo "<h3>".date_format(date_create($_GET['dated']), "d M, Y")."</h3>";

			table_head_gen($head_arr);
?>	
					<tr>
						<td>Breakfast</td>
						<td><?php echo $total[0]; ?></td>
					</tr>
					<tr>
						<td>Lunch</td>
						<td><?php echo $total[1]; ?></td>
					</tr>
					<tr>
						<td>Dinner</td>
						<td><?php echo $total[2]; ?></td>
					</tr>
					<tr>
						<td>Transport</td>
						<td><?php echo $total[3]; ?></td>
					</tr>
					<tr>
						<th>Total</th>
						<td><?php echo $tot_cost; ?></td>
					</tr>
				</tbody>
			</table>
<?php			
		} else {
			gen_view_form($run_pro_arr, True);
		}
	} else {
		gen_view_form($run_pro_arr, False);
	}

?>			
		</body>
	</html>