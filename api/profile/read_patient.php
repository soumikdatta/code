<?php

	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once '../config/open_db.php';
 
	// instantiate database and patient object
	$p_id = $_GET["patient_id"];

	 
	// query patients
	$query = "SELECT
					patient_name, patient_id, patient_name, patient_address, patient_email, patient_phone, patient_photo, isActive
				FROM
					tbl_patient 
				WHERE 
					patient_id = '".$p_id."' 
				AND 
					isActive=1";
	$stmt = mysql_query($query);
	$num = mysql_num_rows($stmt);
	 
	// check if more than 0 record found
	if($num>0){
	 
		// patient array
		$patients_arr=array();
		$patients_arr["records"]=array();
	 
		// retrieve our table contents
		// fetch() is faster than fetchAll()
		// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
		while ($row = mysql_fetch_array($stmt)){
			// extract row
			// this will make $row['name'] to
			// just $name only
			extract($row);
	 
			$patient_item=array(
				"patient_id" => $patient_id,
				"patient_name" => $patient_name,
				"patient_address" => html_entity_decode($patient_address),
				"patient_email" => $patient_email,
				"patient_phone" => $patient_phone,
				"patient_photo" => $patient_photo,
				"isActive" => $isActive
			);
	 
			array_push($patients_arr["records"], $patient_item);
		}
	 
		echo json_encode($patients_arr);
	}
	 
	else{
		echo json_encode(
			array("message" => "No patients found.")
		);
	}
?>