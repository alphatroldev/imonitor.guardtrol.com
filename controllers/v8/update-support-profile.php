<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Support.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $sup_name = htmlspecialchars(strip_tags(strtoupper($_POST['sup_name'])));
    $sup_email = htmlspecialchars(strip_tags($_POST['sup_email']));
    $sup_super = htmlspecialchars(strip_tags($_POST['sup_super']));
    $s_id = htmlspecialchars(strip_tags($_SESSION['SUPPORT_LOGIN']['support_sno']));

    if (!empty($sup_name) && !empty($sup_email) && !empty($sup_super)) {
        $result = $support->update_support_profile($s_id,$sup_name,$sup_email,$sup_super);
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