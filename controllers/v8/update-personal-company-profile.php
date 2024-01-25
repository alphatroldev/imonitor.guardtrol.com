<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
include_once(getcwd().'/controllers/classes/Company.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $com_name = htmlspecialchars(strip_tags(strtoupper($_POST['c_name'])));
        $com_email = htmlspecialchars(strip_tags($_POST['c_email']));
        $com_address = htmlspecialchars(strip_tags($_POST['c_address']));
        $com_phone = htmlspecialchars(strip_tags($_POST['c_phone']));
        $com_description = htmlspecialchars(strip_tags($_POST['c_description']));
        $c_id = htmlspecialchars(strip_tags($_SESSION['COMPANY_LOGIN']['company_sno']));

        if (!empty($com_name) && !empty($com_email) && !empty($com_phone)) {
            $result = $company->update_company_personal_profile($c_id,$com_name,$com_email,$com_address,$com_phone,$com_description);
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