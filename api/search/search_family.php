<?php

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once '../config/open_db.php';

	class Search{
	 
		
		// create product
		function search_family($user_id){
		 
			// query to insert record
			echo $query = "SELECT
						b.name, 
						b.nick_name, 
						b.pic_name, 
						a.latitude, 
						a.longitude 
					FROM
						tbl_family_gps a, 
						(select user_id, name, nick_name, pic_name from tbl_family_member where family = (select family from tbl_family_member where user_id='".$user_id."') and user_id != '".$user_id."') b
					WHERE 
						a.user_id = b.user_id 
					AND
						a.isActive=1";
		 
			// prepare query
			$stmt = mysql_query($query);
		 
			return $stmt;
			 
		}
		
		function distance($lat1, $lon1, $lat2, $lon2, $unit) {

		  $theta = $lon1 - $lon2;
		  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		  $dist = acos($dist);
		  $dist = rad2deg($dist);
		  $miles = $dist * 60 * 1.1515;
		  $unit = strtoupper($unit);

		  if ($unit == "K") {
			return ($miles * 1.609344);
		  } else if ($unit == "N") {
			  return ($miles * 0.8684);
			} else {
				return $miles;
			  }
		}
	 
	}
	
	
	//get parameters
	$lat = $_GET["lat"];
	$lng = $_GET["lng"];
	$user_id = $_GET["user_id"];

	//calculate current day
	$offset_from_server_time = 5.5;
	$my_time = time() + ( 60 * 60 * $offset_from_server_time );
	$today=strtoupper(gmdate("l", $my_time));
	 
	// initialize object
	$search = new Search();
	 
	// query patients
	$stmt = $search->search_family($user_id);
	$num = mysql_num_rows($stmt);
	 
	// check if more than 0 record found
	if($num>0){
	 
		// patient array
		$search_arr=array();
		$search_arr["records"]=array();
	 
		// retrieve our table contents
		// fetch() is faster than fetchAll()
		// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
		while ($row = mysql_fetch_array($stmt)){
			// extract row
			// this will make $row['name'] to
			// just $name only
			extract($row);
	 
			$distance = $search->distance($lat, $lng, $latitude, $longitude, "K");
			$search_item=array(
				"name" => $name,
				"nick_name" => $nick_name,
				"pic_name" => $pic_name,
				"latitude" => $latitude,
				"longitude" => $longitude,
				"distance" => $distance
			);
	 
			array_push($search_arr["records"], $search_item);
		}
	 
		echo json_encode($search_arr);
	}
	 
	else{
		echo json_encode(
			array("message" => "No member found.")
		);
	}
	
?>