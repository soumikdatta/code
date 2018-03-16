<?php

	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once '../config/open_db.php';
 
	//get parameters
	$lat = $_GET["lat"];
	$lng = $_GET["lng"];
	$max_distance = $_GET["distance"];

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

	//calculate current day
	$offset_from_server_time = 5.5;
	$my_time = time() + ( 60 * 60 * $offset_from_server_time );
	$today=strtoupper(gmdate("l", $my_time));
	 
	 
	// query patients
	$query = "SELECT
				a.facility_id, 
				b.chamber_id, 
				a.facility_name, 
				a.facility_address, 
				a.facility_lat, 
				a.facility_lng, 
				a.facility_phone, 
				a.isActive, 
				b.chamber_start, 
				b.chamber_end, 
				b.no_patient 
			FROM
				tbl_facility a, 
				tbl_chamber b
			WHERE 
				a.facility_id = b.facility_id 
			AND
				b.chamber_day LIKE '%".$today."%' 
			AND
				a.isActive=1";
	$stmt = mysql_query($query);
	$num = mysql_num_rows($stmt);
	 
	// check if more than 0 record found
	if($num>0){
	 
		// patient array
		$search_arr=array();
		//$search_arr["records"]=array();
	 
		// retrieve our table contents
		// fetch() is faster than fetchAll()
		// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
		do{
			$i=0;
			$search_arr["records"]=array();
			while ($row = mysql_fetch_array($stmt)){
				// extract row
				// this will make $row['name'] to
				// just $name only
				extract($row);
		 
				$distance = distance($lat, $lng, $facility_lat, $facility_lng, "K");
				$search_item=array(
					"facility_id" => $facility_id,
					"chamber_id" => $chamber_id,
					"facility_name" => $facility_name,
					"facility_address" => html_entity_decode($facility_address),
					"facility_phone" => $facility_phone,
					"isActive" => $isActive,
					"chamber_start" => $chamber_start,
					"chamber_end" => $chamber_end,
					"no_patient" => $no_patient,
					"distance" => $distance
				);
		 
				if($distance<$max_distance)
				{
					array_push($search_arr["records"], $search_item);
					$i++;
				}
			}
			//echo $i;
			$max_distance = $max_distance+1;
		}while($i<5 && $max_distance<15);
	 
		echo json_encode($search_arr);
	}
	 
	else{
		echo json_encode(
			array("message" => "No doctor found.")
		);
	}
?>