<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Support.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (trim($data->action_code) == '101' && !empty(trim($data->s_id))) {
        if ($support->update_support_status($data->active,$data->s_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Support status updated.","location"=> url_path('/support/list', true, true)));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update support status."));
        }
    }

    if (trim($data->action_code) == '102' && !empty(trim($data->s_id))) {
        if ($support->delete_support($data->s_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Support deleted successfully.","location"=> url_path('/support/list', true, true)));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete support."));
        }
    }

    if (trim($data->action_code) == '201' && !empty(trim($data->c_sno))) {
        if ($support->delete_company($data->c_sno)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Company profile deleted successfully.","location"=> url_path('/company/list-company', true, true)));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete company profile."));
        }
    }

    if (trim($data->action_code) == '202' && !empty(trim($data->c_sno))) {
        if ($support->update_company_status($data->active,$data->c_sno,$data->c_id,$data->s_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Company status updated.","location"=> url_path('/support/list-company', true, true)));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update company status."));
        }
    }
}