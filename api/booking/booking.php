<?php

	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once '../config/open_db.php';
 
	//calculate current day
	$offset_from_server_time = 5.5;
	$my_time = time() + ( 60 * 60 * $offset_from_server_time );
	$today=gmdate("Y-m-d", $my_time);
	
	// get posted data
	$data = json_decode(file_get_contents("php://input"));
	 
	// set register property values
	$chamber_id = $data->chamber_id;
	$patient_id = $data->patient_id;
	$patient_name = $data->patient_name;
	$patient_address = $data->patient_address;
	$patient_phone = $data->patient_phone;
	$patient_age = $data->patient_age;
	$patient_sex = $data->patient_sex;
	$visit_date = $today;
	$booking_date = $today;
	 
	$query = "INSERT INTO
				tbl_booking 
				(patient_id, chamber_id, patient_name, patient_address, patient_phone, patient_age, patient_sex, visit_date, booking_date) 
			VALUES
				('".$patient_id."', '".$chamber_id."', '".$patient_name."', '".$patient_address."', '".$patient_phone."', '".$patient_age."', '".$patient_sex."', '".$visit_date."', '".$booking_date."')";
	$msg=mysql_query($query);
	if($msg){
		$booking_id = mysql_insert_id();
		$q1=mysql_query("select * from tbl_booking where booking_id<=".$booking_id." and chamber_id='".$chamber_id."' and visit_date='".$visit_date."'");
		$que_srl = mysql_num_rows($q1);
		echo '{';
			echo '"message": "Booking was created.","booking_id":"'.$booking_id.'","queue_status":"'.$que_srl.'"';
		echo '}';
	}
		// if unable to create the register, tell the user
	else{
		echo '{';
			echo '"message": "Unable to create booking.","patient_id":"'.$patient_id.'"';
		echo '}';
	}
	 
?>