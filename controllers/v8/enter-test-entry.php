<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Company.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $fname = $_POST['fname'];
    $lname =$_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    if (!empty($fname) && !empty($lname) && !empty($phone) && !empty($email)) {
        $s_data = $company->create_test_entry($fname,$lname,$phone,$email);
        if ($s_data) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Test entry successfully saved."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Server error, could not save"));
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