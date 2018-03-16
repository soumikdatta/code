<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	
	mysql_connect("localhost", "ideation", "Admin@123");
	mysql_select_db("smarthealth");

	//calculate current day
	$offset_from_server_time = 5.5;
	$my_time = time() + ( 60 * 60 * $offset_from_server_time );
	$today=strtoupper(gmdate("dmY_his", $my_time));
	//echo "<br>";

	$target_path = "profile_pic/";
	
	$pid = $_GET["pid"];
	
//	$image_name = $pid."_".$today.".".pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	$image_name = $_FILES['file']['name'];
	//echo "<br>";
	 
	$target_path = $target_path . $image_name;
	 
	if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
		$query = "update tbl_patient set patient_photo='".$image_name."' where patient_id='".$pid."'";
		mysql_query($query);
		echo "Upload and move success";
	} else {
		echo $target_path;
		echo "There was an error uploading the file, please try again!";
	}
?>