<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Company.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $role_name = htmlspecialchars(strip_tags($_POST['role_name']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $role_sno = htmlspecialchars(strip_tags($_POST['role_sno']));
    $r_created_on = date("Y-m-d H:i:s");

    if (!empty($role_name) && !empty($comp_id) && !empty($role_sno) && !empty($r_created_on)) {
        $role_data = $company->check_role_name($role_name,$comp_id);
        if (empty($email_data)) {
            $r_data = $company->create_company_role($role_name, $comp_id, $role_sno, $r_created_on);
            if ($r_data) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Role has been successfully saved."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Server error, could not create role"));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Duplicate entry for Role name not allowed"));
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