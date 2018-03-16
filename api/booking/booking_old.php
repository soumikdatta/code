<?php

	// required headers
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	include_once '../config/open_db.php';
	
	$patient_id=$_GET["patient_id"];
 
	//calculate current day
	$offset_from_server_time = 5.5;
	$my_time = time() + ( 60 * 60 * $offset_from_server_time );
	$today=gmdate("Y-m-d", $my_time);
	
	// get posted data
	 
	$query = "SELECT
				c.booking_id, 
				c.visit_date, 
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
				tbl_chamber b, 
				tbl_booking c 
			WHERE 
				a.facility_id = b.facility_id 
			AND
				b.chamber_id = c.chamber_id 
			AND 
				c.patient_id = '".$patient_id."' 
			AND
				c.isActive=0";
	$msg=mysql_query($query);
	if($msg){
		if(mysql_num_rows($msg)>0)
		{
			$search_arr=array();
			$search_arr["message"]="Booking available";
			$search_arr["records"]=array();
			while($row = mysql_fetch_array($msg)){
				// extract row
				// this will make $row['name'] to
				// just $name only
				extract($row);
				
/*				$q1=mysql_query("select * from tbl_booking where booking_id<=".$booking_id." and chamber_id='".$chamber_id."' and isActive=1");
				$que_srl = mysql_num_rows($q1);
*/		 
				$search_item=array(
					"booking_id" => $booking_id,
					"visit_date" => $visit_date,
					"facility_id" => $facility_id,
					"chamber_id" => $chamber_id,
					"facility_name" => $facility_name,
					"facility_address" => html_entity_decode($facility_address),
					"facility_phone" => $facility_phone,
					"isActive" => $isActive,
					"chamber_start" => $chamber_start,
					"chamber_end" => $chamber_end,
//					"queue_status" => $que_srl,
					"no_patient" => $no_patient
				);
				
				array_push($search_arr["records"], $search_item);
			}
			echo json_encode($search_arr);
		}
		else{
			echo '{';
			echo '"message": "No Booking available."';
			echo '}';
		}
	}
		// if unable to create the register, tell the user
	else{
		echo '{';
			echo '"message": "Unable to retrieve booking.","patient_id":"'.$patient_id.'"';
		echo '}';
	}
	 
?>