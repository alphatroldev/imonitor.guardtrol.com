<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../controllers/config/database.php');
include_once('../controllers/classes/Support.class.php');

$s_name = "Fred Abbey";
$s_email = "fredrickbdn@gmail.com";
$s_password = "support@123#";
$s_c_password = "support@123#";

$s_id = rand(1000000,9999999);
$s_created_on = date("Y-m-d H:i:s");

$s_data = $support->create_support_instance($s_id,$s_name,$s_email,$s_password,$s_created_on);
if ($s_data == "ERR_E_EXIST"){
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Support account with ".$s_email." already exist."));
} elseif ($s_data == true) {
    http_response_code(200);
    echo json_encode(array("status" => 1, "message" => "Support account has been successfully created."));
} elseif ($s_data == false){
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Server error, could not create support instance"));
}

