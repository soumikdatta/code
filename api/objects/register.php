<?php
class Register{
 
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
    public $isActive;
	
	public $user_id;
	public $password;
	
	// constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
 
}