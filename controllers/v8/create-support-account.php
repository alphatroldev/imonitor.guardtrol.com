<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Support.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $s_name = htmlspecialchars(strip_tags($_POST['fullname']));
    $s_email = htmlspecialchars(strip_tags($_POST['email']));
    $s_type = htmlspecialchars(strip_tags($_POST['sup_type']));
    $s_status = htmlspecialchars(strip_tags($_POST['sup_status']));
    $s_password = htmlspecialchars(strip_tags($_POST['password']));
    $s_c_password = htmlspecialchars(strip_tags($_POST['confirm_password']));

    $s_id = rand(1000000,9999999);
    $s_created_on = date("Y-m-d H:i:s");

    if (!empty($s_name) && !empty($s_email) && !empty($s_type) && !empty($s_status) && !empty($s_password) && !empty($s_c_password) && !empty($s_id) && !empty($s_created_on)) {
        if ($s_password !== $s_c_password){
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Password not matched."));
        } else {
            $email_data = $support->check_email($s_email);
            if (!empty($email_data)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Support account with ".$s_email." already exist."));
            } else {
                $s_data = $support->create_support_instance($s_id, $s_name, $s_email, $s_type, $s_status, $s_password, $s_created_on);
                if ($s_data) {
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Support account has been successfully created."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Server error, could not create support instance"));
                }
            }
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>