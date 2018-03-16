<?php
class Patient{
 
	// database connection and table name
    private $conn;
    private $table1_name = "tbl_patient";
    private $table2_name = "tbl_credential";
 
    // object properties
    public $patient_id;
    public $patient_name;
    public $patient_address;
    public $patient_email;
    public $patient_phone;
    public $patient_photo;
    public $isActive;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	// read products
	function read($p_id){
	 
		// select all query
		$query = "SELECT
					patient_name, patient_id, patient_name, patient_address, patient_email, patient_phone, patient_photo, isActive
				FROM
					" . $this->table1_name . "
				WHERE 
					patient_id = '".$p_id."' 
				AND 
					isActive=1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	
	function update(){
	 
	 
		// query to update record
		$query = "UPDATE 
					" . $this->table1_name . "
				SET
					patient_name=:patient_name, 
					patient_address=:patient_address, 
					patient_email=:patient_email, 
					patient_phone=:patient_phone 
				WHERE 
					patient_id=:patient_id";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->patient_id=htmlspecialchars(strip_tags($this->patient_id));
		$this->patient_name=htmlspecialchars(strip_tags($this->patient_name));
		$this->patient_address=htmlspecialchars(strip_tags($this->patient_address));
		$this->patient_email=htmlspecialchars(strip_tags($this->patient_email));
		$this->patient_phone=htmlspecialchars(strip_tags($this->patient_phone));
	 
		// bind values
		$stmt->bindParam(":patient_id", $this->patient_id);
		$stmt->bindParam(":patient_name", $this->patient_name);
		$stmt->bindParam(":patient_address", $this->patient_address);
		$stmt->bindParam(":patient_email", $this->patient_email);
		$stmt->bindParam(":patient_phone", $this->patient_phone);

		// prepare query
		$state=$stmt->execute();
		if($state)
			return $this->patient_id;
		else
			return false;
		 
	}
	
	// create patient
	function create(){
	 
		// query to insert record
		$query1 = "INSERT INTO
					" . $this->table1_name . "
				SET
					patient_id=:patient_id, patient_name=:patient_name, patient_address=:patient_address, patient_email=:patient_email, patient_phone=:patient_phone";
	 
		// query to insert record
		$query2 = "INSERT INTO
					" . $this->table2_name . "
				SET
					user_id=:user_id, password=:password";
	 
		// prepare query
		$stmt2 = $this->conn->prepare($query2);
	 
		// sanitize
		$this->patient_name=htmlspecialchars(strip_tags($this->patient_name));
		$this->patient_address=htmlspecialchars(strip_tags($this->patient_address));
		$this->patient_email=htmlspecialchars(strip_tags($this->patient_email));
		$this->patient_phone=htmlspecialchars(strip_tags($this->patient_phone));
		$this->user_id=htmlspecialchars(strip_tags($this->user_id));
		$this->password=htmlspecialchars(strip_tags($this->password));
	 
		// bind values
		$stmt2->bindParam(":user_id", $this->user_id);
		$stmt2->bindParam(":password", $this->password);
	 
		// execute query
		if($stmt2->execute()){
			$query3 = "SELECT patient_id as id 
					FROM 
						" . $this->table2_name . " 
					WHERE 
						user_id = '" . $this->user_id . "' 
					AND 
						password = '" . $this->password . "'
					";
			$stmt3 = $this->conn->prepare($query3);
			$stmt3->execute();
			$row = $stmt3->fetch(PDO::FETCH_ASSOC);
			extract($row);
			$this->patient_id = $id;
			
			$stmt1 = $this->conn->prepare($query1);

			// bind values
			$stmt1->bindParam(":patient_id", $this->patient_id);
			$stmt1->bindParam(":patient_name", $this->patient_name);
			$stmt1->bindParam(":patient_address", $this->patient_address);
			$stmt1->bindParam(":patient_email", $this->patient_email);
			$stmt1->bindParam(":patient_phone", $this->patient_phone);

			// prepare query
			
			$state1=$stmt1->execute();
			if($state1)
				return $this->patient_id;
			return $this->patient_id;
		}
	 
		return false;
		 
	}
}
?>