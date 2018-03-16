<?php
class Login{
 
	// database connection and table name
    private $conn;
    private $table_name = "tbl_credential";
 
    // object properties
    public $patient_id;
    public $user_id;
    public $password;
    public $user_type;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	// read products
	function read($u_id, $user_type){
	 
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
		// select all query
		$query = "SELECT
					a.patient_id, a.user_id, a.password, a.user_type, b.isActive
				FROM
					" . $this->table_name . " a, " . $table . " b
				WHERE 
					a.user_id = '".$u_id."' 
				AND
					a.user_type = '".$user_type."' 
				AND 
					a.patient_id = b." . $key . " 
				AND 
					b.isActive=1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
}
?>