<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Support.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $sup_id = htmlspecialchars(strip_tags(trim($_POST['support_id'])));
    $sup_name = htmlspecialchars(strip_tags(trim($_POST['fullname'])));
    $sup_email = htmlspecialchars(strip_tags(trim($_POST['email'])));
    $sup_super = htmlspecialchars(strip_tags(trim($_POST['sup_type'])));
    $sup_active = htmlspecialchars(strip_tags(trim($_POST['sup_status'])));

    if (!empty($sup_id) && !empty($sup_name) && !empty($sup_email) && !empty($sup_super) && !empty($sup_active)) {
        $result = $support->update_support_profile_by_id($sup_id,$sup_name,$sup_email,$sup_super,$sup_active);
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