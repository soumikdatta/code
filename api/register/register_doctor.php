<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate register object
include_once '../objects/doctor.php';
 
$database = new Database();
$db = $database->getConnection();
 
$doctor = new Doctor($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set register property values
$doctor->doctor_name = $data->doctor_name;
$doctor->doctor_regno = $data->doctor_regno;
$doctor->doctor_spclty = $data->doctor_spclty;
$doctor->doctor_exp = $data->doctor_exp;
$doctor->doctor_address = $data->doctor_address;
$doctor->doctor_email = $data->doctor_email;
$doctor->doctor_phone = $data->doctor_phone;
$doctor->user_id = $data->user_id;
$doctor->password = $data->password;
 
// create the doctor
$msg=$doctor->create();
if($msg){
    echo '{';
        echo '"message": "doctor was created.","doctor_id":"'.$msg.'"';
    echo '}';
}
 
// if unable to create the doctor, tell the user
else{
    echo '{';
        echo '"message": "Unable to create doctor.'.$msg.'"';
    echo '}';
}
?>