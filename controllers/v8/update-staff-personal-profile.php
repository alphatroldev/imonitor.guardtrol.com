<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
include_once(getcwd().'/controllers/classes/Staff.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $stf_fname = htmlspecialchars(strip_tags($_POST['stf_fname']));
    $stf_mname = htmlspecialchars(strip_tags($_POST['stf_mname']));
    $stf_lname = htmlspecialchars(strip_tags($_POST['stf_lname']));
    $stf_phone = htmlspecialchars(strip_tags($_POST['stf_phone']));
    $stf_email = htmlspecialchars(strip_tags($_POST['stf_email']));
    $s_sno = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_sno']));

    if (!empty($stf_fname) && !empty($stf_mname) && !empty($stf_lname) && !empty($stf_phone) && !empty($stf_email)) {
        $result = $staff->update_staff_personal_profile($s_sno,$stf_fname,$stf_mname,$stf_lname,$stf_phone,$stf_email);
        if ($result==true) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Your account profile has been successfully updated."));
        } else if ($result=="no_change"){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update profile, no changes found."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update profile."));
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