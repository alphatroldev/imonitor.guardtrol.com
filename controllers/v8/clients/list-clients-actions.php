<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Client.class.php');
include_once(getcwd().'/controllers/classes/Company.class.php');


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (trim($data->action_code) == '101' && !empty(trim($data->id))) {
        if ($client->update_client_status($data->active,$data->id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Client status updated.",
                "location"=>url_path('/company/list-clients',true,true),
                "location2"=>url_path('/company/inactive-clients',true,true)));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update client status."));
        }
    }

    if (trim($data->action_code) == '102' && !empty(trim($data->id))) {
        if ($client->delete_client($data->id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Client deleted successfully.","location"=>url_path('/company/list-clients',true,true)));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete client."));
        }
    }

    if (trim($data->action_code) == '103' && !empty(trim($data->inv_dc_sno)) && !empty(trim($data->comp_id))) {
        if ($company->delete_inv_credit_debit($data->inv_dc_sno,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => ""));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete client."));
        }
    }

    if (trim($data->action_code) == '104' && !empty(trim($data->invoice_id)) && !empty(trim($data->comp_id)) && !empty(trim($data->client_id))) {
        if ($company->delete_inv_histories($data->invoice_id,$data->comp_id,$data->client_id,$data->invoice_amt)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Invoice details successfully deleted."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete invoice."));
        }
    }

    if (trim($data->action_code) == '105' && !empty(trim($data->receipt_id)) && !empty(trim($data->comp_id))) {
        if ($company->delete_payment_receipt($data->receipt_id,$data->client_id,$data->pay_amt,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Payment Receipt details successfully deleted."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete invoice."));
        }
    }
    
    if (trim($data->action_code) == '100' && !empty(trim($data->date))  && !empty(trim($data->comp_id)) && !empty(trim($data->client_id))) {
        $res_pay = $client->check_if_payment_amount_exist($data->date,$data->comp_id,$data->client_id);
        if ($res_pay['myCount'] > 0) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Date already exist"));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "No date found."));
        }
    }

    
}