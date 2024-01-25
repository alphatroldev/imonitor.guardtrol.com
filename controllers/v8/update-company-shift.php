<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Company.class.php');
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $shift_title = htmlspecialchars(strip_tags($_POST['shift_title']));
    $shift_hours = htmlspecialchars(strip_tags($_POST['shift_hours']));
    $shift_id = htmlspecialchars(strip_tags($_POST['shift_id']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $resume_time = htmlspecialchars(strip_tags($_POST['resume_time']));
    $close_time = htmlspecialchars(strip_tags($_POST['close_time']));

    if (!empty($shift_title) && !empty($shift_hours) && !empty($resume_time) && !empty($close_time) && !empty($shift_id)) {
        $result = $company->update_company_shift_by_id($shift_title,$shift_hours,$resume_time,$close_time,$shift_id,$comp_id);
        if ($result==true) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Shift has been successfully updated.","location"=> url_path('/company/shifts',true,true)));
        } else if ($result=="no_change"){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update shift, no changes found."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update shift."));
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