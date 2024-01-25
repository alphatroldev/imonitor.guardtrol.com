<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Company.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $payroll_title = htmlspecialchars(strip_tags($_POST['payroll_title']));
    $payroll_typ = htmlspecialchars(strip_tags($_POST['payroll_typ']));
    $access_typ = htmlspecialchars(strip_tags($_POST['access_typ']));
    $payment_mode = htmlspecialchars(strip_tags($_POST['payment_mode']));
    $mon_month = htmlspecialchars(strip_tags(isset($_POST['mon_month'])?$_POST['mon_month']:''));
    $mon_year = htmlspecialchars(strip_tags(isset($_POST['mon_year'])?$_POST['mon_year']:''));
    $fixed_amount = htmlspecialchars(strip_tags($_POST['fixed_amount']));
    $payroll_amount = htmlspecialchars(strip_tags(isset($_POST['payroll_amount'])?$_POST['payroll_amount']:''));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $edit_payroll_settings_sno = htmlspecialchars(strip_tags($_POST['edit_payroll_settings_sno']));
    $payroll_settings_updated_on = date("Y-m-d H:i:s");
   
    if (!empty($payroll_title) && !empty($payroll_typ) && !empty($access_typ) && !empty($payroll_amount) && !empty($comp_id) && !empty($edit_payroll_settings_sno)
        && !empty($payroll_settings_updated_on)) {
        $s_data = $company->update_company_payroll_settings(
            $payroll_title,$payroll_typ,$access_typ,$payment_mode,$mon_month,$mon_year,$fixed_amount,$payroll_amount,$comp_id,
            $edit_payroll_settings_sno,$payroll_settings_updated_on
        );
        if ($s_data) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Payroll setting has been successfully updated."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Server error, could not update payroll setting"));
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