<?php
// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once '../config/open_db.php';
 
	// instantiate database and login object
	$u_id = $_GET["user_id"];
	$user_type = $_GET["user_type"];

	if($user_type=="PATIENT")
	{
		$table = "tbl_patient";
		$key = "patient_id";
	}
	else if($user_type=="DOCTOR")
	{
		$table = "tbl_doctor";
		$key = "doctor_id";
	}

	// query login
	$query = "SELECT
					a.patient_id, a.user_id, a.password, a.user_type, b.isActive
				FROM
					tbl_credential a, " . $table . " b
				WHERE 
					a.user_id = '".$u_id."' 
				AND
					a.user_type = '".$user_type."' 
				AND 
					a.patient_id = b." . $key . " 
				AND 
					b.isActive=1";
	
	$stmt = mysql_query($query);
	$num = mysql_num_rows($stmt);
	 
	// check if more than 0 record found
	if($num>0){
	 
		// login array
		$login_arr=array();
		$login_arr["records"]=array();
	 
		// retrieve our table contents
		// fetch() is faster than fetchAll()
		// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
		while ($row = mysql_fetch_array($stmt)){
			// extract row
			// this will make $row['name'] to
			// just $name only
			extract($row);
	 
			$login_item=array(
				"patient_id" => $patient_id,
				"user_id" => $user_id,
				"password" => $password,
				"user_type" => $user_type,
				"isActive" => $isActive
			);
	 
			array_push($login_arr["records"], $login_item);
		}
	 
		echo json_encode($login_arr);
	}
	 
	else{
		echo json_encode(
			array("message" => "No login found.")
		);
	}
?>