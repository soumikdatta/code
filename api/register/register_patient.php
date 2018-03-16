<?php

	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once '../config/open_db.php';
 
	// get posted data
	$data = json_decode(file_get_contents("php://input"));
	 
	// set register property values
	$patient_name = $data->patient_name;
	$patient_address = $data->patient_address;
	$patient_email = $data->patient_email;
	$patient_phone = $data->patient_phone;
	$user_id = $data->user_id;
	$password = $data->password;
	 
	// create the register
	$query2 = "INSERT INTO
					tbl_credential 
					(user_id, password, user_type) 
				VALUES
					('".$user_id."', '".$password."', 'PATIENT')";
	$q1=mysql_query($query2);
	if($q1)
	{
		$patient_id = mysql_insert_id();
		$query = "INSERT INTO
					tbl_patient 
					(patient_id, patient_name, patient_address, patient_email, patient_phone) 
				VALUES
					('".$patient_id."', '".$patient_name."', '".$patient_address."', '".$patient_email."', '".$patient_phone."')";
		$msg=mysql_query($query);
		if($msg){
			echo '{';
				echo '"message": "Register was created.","patient_id":"'.$patient_id.'"';
			echo '}';
		}
			// if unable to create the register, tell the user
		else{
			echo '{';
				echo '"message": "Unable to create register.","patient_id":"'.$patient_id.'"';
			echo '}';
		}
	}
	 
	// if unable to create the register, tell the user
	else{
		echo '{';
			echo '"message": "User Id exists.","patient_id":"BLANK"';
		echo '}';
	}
?>