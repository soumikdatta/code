<?php
class Search{
 
	// database connection and table name
    private $conn;
    private $table1_name = "tbl_facility";
    private $table2_name = "tbl_chamber";
 
    // object properties
    public $facility_id;
    public $facility_name;
    public $facility_address;
    public $facility_lat;
    public $facility_lng;
    public $facility_phone;
    public $isActive;
    public $chamber_start;
    public $chamber_end;
    public $no_patient;
	
	// constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// create product
	function search($today){
	 
		// query to insert record
		$query = "SELECT
					a.facility_id, 
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
					" . $this->table1_name . " a, 
					" . $this->table2_name . " b
				WHERE 
					a.facility_id = b.facility_id 
				AND
					b.chamber_day LIKE '%".$today."%' 
				AND
					a.isActive=1";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		$stmt->execute();
		
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