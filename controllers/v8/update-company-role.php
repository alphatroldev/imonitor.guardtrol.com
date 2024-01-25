<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Company.class.php');
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $role_name = htmlspecialchars(strip_tags($_POST['role_name']));
    $role_sno = htmlspecialchars(strip_tags($_POST['role_sno']));
    $comp_role_sno = htmlspecialchars(strip_tags($_POST['comp_role_sno']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));

    if (!empty($role_name) && !empty($role_sno) && !empty($comp_role_sno)) {
        $result = $company->update_company_role_by_sno($role_name,$role_sno,$comp_role_sno,$comp_id);
        if ($result==true) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Role has been successfully updated.","location"=>url_path('/company/roles',true,true)));
        } else if ($result=="no_change"){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update role, no changes found."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update role."));
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