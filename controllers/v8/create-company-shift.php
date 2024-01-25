<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Company.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $shift_title = htmlspecialchars(strip_tags($_POST['shift_title']));
    $shift_hours = htmlspecialchars(strip_tags($_POST['shift_hours']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $res_time = htmlspecialchars(strip_tags($_POST['resume_time']));
    $cls_time = htmlspecialchars(strip_tags($_POST['close_time']));
    $r_created_on = date("Y-m-d H:i:s");

    if (!empty($shift_title) &&!empty($shift_hours) && !empty($comp_id) && !empty($res_time) && !empty($cls_time)) {
       
        $s_data = $company->create_company_shift($comp_id,$shift_title, $shift_hours, $res_time, $cls_time, $r_created_on);
        
        if ($s_data) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Shift has been successfully saved."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Server error, could not create shift"));
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