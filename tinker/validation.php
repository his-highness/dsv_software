<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>My Company | Login</title>
		</head>
		<body>
			<h1>Add Employee Details to the Database</h1>

			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?> ">
				<label for="firstname">First Name</label>
				<input type="text" name="firstname" id="firstname">

				<label for="lastname">Last Name</label>
				<input type="text" name="lastname" id="lastname">

				<label for="cont_name">Contractor's Name</label>
				<input type="text" name="cont_name" id="cont_name">

				<input type="submit" name="add_emp" value="Add Employee">
			</form>

<?php
	if(isset($_POST["add_emp"])) {

		$form_data = array('firstname', 'lastname', 'cont_name');

		function val_form_det($data_array) {
			$empty_det = array();
			$data_arr_len = sizeof($data_array);

			for($i=0;$i<$data_arr_len;$i++) {
				if(empty($_POST[$data_array[$i]])) {
					$empty_det[] = $data_array[$i];
				}	
			}

			return $empty_det;
		}

		$empty_form_det = val_form_det($form_data);
		print_r($empty_form_det);


		
	}
	

?>


		</body>
	</html>