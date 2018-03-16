<?php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once '../config/open_db.php';

	$data = json_decode(file_get_contents("php://input"));
	
	$user_id = $data->user_id;
	$timestamp = $data->timestamp;
	$latitude = $data->latitude;
	$longitude = $data->longitude;
	
	mysql_query("delete from tbl_family_gps where user_id in ('".$user_id."','')");
	mysql_query("update tbl_family_gps set isActive=0 where user_id in ('".$user_id."','')");
	$query="insert into tbl_family_gps (user_id, latitude, longitude) values ('".$user_id."', '".$latitude."', '".$longitude."')";
	
	$msg=mysql_query($query);
	if($msg){
		echo '{';
			echo '"message": "Location was stored."';
		echo '}';
	}
	 
	// if unable to create the register, tell the user
	else{
		echo '{';
			echo '"message": "Unable to store location.'.$msg.'"';
		echo '}';
	}

?>