<?php

	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once '../config/open_db.php';
 

	// get posted data
	$data = json_decode(file_get_contents("php://input"));
	 
	// set ID property of product to be edited
	$patient_id = $data->patient_id;

	// set patient property values
	$patient_name = $data->patient_name;
	$patient_address = $data->patient_address;
	$patient_email = $data->patient_email;
	$patient_phone = $data->patient_phone;
	$patient_photo = $data->patient_photo;
	 
	// query to update record
	mysql_query("update tbl_patient set isActive=0 where patient_id='".$patient_id."'");
	// query to insert record
	$query = "INSERT INTO
				tbl_patient 
				(patient_id, patient_name, patient_address, patient_email, patient_phone, patient_photo) 
			VALUES
				('".$patient_id."', '".$patient_name."', '".$patient_address."', '".$patient_email."', '".$patient_phone."', '".$patient_photo."')";
	$msg=mysql_query($query);
	if($msg){
		echo '{';
			echo '"message": "Patient Profile was updated.","patient_id":"'.$patient_id.'"';
		echo '}';
	}
	 
	// if unable to update the profile, tell the user
	else{
		echo '{';
			echo '"message": "Unable to update profile. '.$patient_id.'"';
		echo '}';
	}
?>