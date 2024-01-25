<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Company.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $inv_acc_name = htmlspecialchars(strip_tags($_POST['inv_acc_name']));
    $inv_acc_no = htmlspecialchars(strip_tags($_POST['inv_acc_no']));
    $inv_bank_name = htmlspecialchars(strip_tags($_POST['inv_bank_name']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $inv_created_on = date("Y-m-d H:i:s");

    if (!empty($inv_acc_name) && !empty($inv_acc_no) && !empty($inv_bank_name) && !empty($comp_id) && !empty($inv_created_on)) {
        $acc_data = $company->create_company_invoice_account($comp_id,$inv_acc_name,$inv_acc_no,$inv_bank_name,$inv_created_on);
        if ($acc_data) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "company invoice account successfully saved."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Server error, could not create account"));
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