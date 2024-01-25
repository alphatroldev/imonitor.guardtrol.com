<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Company.class.php');


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (trim($data->action_code) == '104' && !empty(trim($data->inv_acc_sno)) && !empty(trim($data->comp_id))) {
        if ($company->update_invoice_account_status($data->inv_acc_sno,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Account status updated."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update Account status."));
        }
    }

    if (trim($data->action_code) == '102' && !empty(trim($data->inv_acc_sno)) && !empty(trim($data->comp_id))) {
        if ($company->delete_company_invoice_acct_data($data->inv_acc_sno,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Account data deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete account."));
        }
    }
}