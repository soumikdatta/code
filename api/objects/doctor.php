<?php
class Doctor{
 
	// database connection and table name
    private $conn;
    private $table1_name = "tbl_doctor";
    private $table2_name = "tbl_credential";
 
    // object properties
    public $doctor_id;
    public $doctor_name;
    public $doctor_address;
    public $doctor_email;
    public $doctor_phone;
    public $doctor_photo;
    public $isActive;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	// read products
	function read($p_id){
	 
		// select all query
		$query = "SELECT
					doctor_id, doctor_name, doctor_regno, doctor_spclty, doctor_exp, doctor_address, doctor_email, doctor_phone, doctor_photo, isActive
				FROM
					" . $this->table1_name . "
				WHERE 
					doctor_id = '".$p_id."' 
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
					doctor_name=:doctor_name, 
					doctor_regno=:doctor_regno, 
					doctor_spclty=:doctor_spclty, 
					doctor_exp=:doctor_exp, 
					doctor_address=:doctor_address, 
					doctor_email=:doctor_email, 
					doctor_phone=:doctor_phone 
				WHERE 
					doctor_id=:doctor_id";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->doctor_id=htmlspecialchars(strip_tags($this->doctor_id));
		$this->doctor_name=htmlspecialchars(strip_tags($this->doctor_name));
		$this->doctor_regno=htmlspecialchars(strip_tags($this->doctor_regno));
		$this->doctor_spclty=htmlspecialchars(strip_tags($this->doctor_spclty));
		$this->doctor_exp=htmlspecialchars(strip_tags($this->doctor_exp));
		$this->doctor_address=htmlspecialchars(strip_tags($this->doctor_address));
		$this->doctor_email=htmlspecialchars(strip_tags($this->doctor_email));
		$this->doctor_phone=htmlspecialchars(strip_tags($this->doctor_phone));
	 
		// bind values
		$stmt->bindParam(":doctor_id", $this->doctor_id);
		$stmt->bindParam(":doctor_name", $this->doctor_name);
		$stmt->bindParam(":doctor_regno", $this->doctor_regno);
		$stmt->bindParam(":doctor_spclty", $this->doctor_spclty);
		$stmt->bindParam(":doctor_exp", $this->doctor_exp);
		$stmt->bindParam(":doctor_address", $this->doctor_address);
		$stmt->bindParam(":doctor_email", $this->doctor_email);
		$stmt->bindParam(":doctor_phone", $this->doctor_phone);

		// prepare query
		$state=$stmt->execute();
		if($state)
			return $this->doctor_id;
		else
			return false;
		 
	}
	
	// create doctor
	function create(){
	 
		// query to insert record
		$query1 = "INSERT INTO
					" . $this->table1_name . "
				SET
					doctor_id=:doctor_id, 
					doctor_name=:doctor_name, 
					doctor_regno=:doctor_regno, 
					doctor_spclty=:doctor_spclty, 
					doctor_exp=:doctor_exp, 
					doctor_address=:doctor_address, 
					doctor_email=:doctor_email, 
					doctor_phone=:doctor_phone";
	 
		// query to insert record
		$query2 = "INSERT INTO
					" . $this->table2_name . "
				SET
					user_id=:user_id, password=:password, user_type='DOCTOR'";
	 
		// prepare query
		$stmt2 = $this->conn->prepare($query2);
	 
		// sanitize
		$this->doctor_name=htmlspecialchars(strip_tags($this->doctor_name));
		$this->doctor_regno=htmlspecialchars(strip_tags($this->doctor_regno));
		$this->doctor_spclty=htmlspecialchars(strip_tags($this->doctor_spclty));
		$this->doctor_exp=htmlspecialchars(strip_tags($this->doctor_exp));
		$this->doctor_address=htmlspecialchars(strip_tags($this->doctor_address));
		$this->doctor_email=htmlspecialchars(strip_tags($this->doctor_email));
		$this->doctor_phone=htmlspecialchars(strip_tags($this->doctor_phone));
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
			$this->doctor_id = $id;
			
			$stmt1 = $this->conn->prepare($query1);

			// bind values
			$stmt1->bindParam(":doctor_id", $this->doctor_id);
			$stmt1->bindParam(":doctor_name", $this->doctor_name);
			$stmt1->bindParam(":doctor_regno", $this->doctor_regno);
			$stmt1->bindParam(":doctor_spclty", $this->doctor_spclty);
			$stmt1->bindParam(":doctor_exp", $this->doctor_exp);
			$stmt1->bindParam(":doctor_address", $this->doctor_address);
			$stmt1->bindParam(":doctor_email", $this->doctor_email);
			$stmt1->bindParam(":doctor_phone", $this->doctor_phone);

			// prepare query
			
			$state1=$stmt1->execute();
			if($state1)
				return $this->doctor_id;
			return $this->doctor_id;
		}
	 
		return false;
		 
	}
}
?>