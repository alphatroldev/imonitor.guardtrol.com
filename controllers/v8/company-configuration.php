<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Company.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $c_uniform_charge = htmlspecialchars(strip_tags($_POST['uniform_charge']));
    $c_uniform_charge_amt = htmlspecialchars(strip_tags($_POST['uniform_charge_amt']));
    $c_uni_mode = htmlspecialchars(strip_tags($_POST['uni_mode']));
    $c_agent = htmlspecialchars(strip_tags($_POST['agent']));
    $c_agent_fee = htmlspecialchars(strip_tags($_POST['agent_fee']));
    $c_agent_mode = htmlspecialchars(strip_tags($_POST['agent_mode']));
    $c_shift = null;
    $c_act_date = htmlspecialchars(strip_tags($_POST['act_date']));
    $loan_type = htmlspecialchars(strip_tags($_POST['loan_type']));
    $c_penalties = null;
    $com_id = htmlspecialchars(strip_tags($_POST['comp_id']));

    $c_created_on = date("Y-m-d H:i:s");

    if (!empty($c_agent) && !empty($c_uniform_charge) && !empty($c_act_date) && !empty($loan_type)) {
        if($c_agent == 'Yes' && ($c_agent_fee == null || $c_agent_fee == 0)){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "You must $c_agent_fee enter an amount for your agent fee, if you accept agent"));
        }else if($c_uniform_charge == 'Yes' && ($c_uniform_charge_amt == null || $c_uniform_charge_amt == 0)){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "You must enter a fee for your uniform, if you accept uniform"));
        }else{
            $c_data = $company->create_company_config($com_id, $c_uniform_charge,$c_uniform_charge_amt,$c_uni_mode,$c_agent ,$c_agent_fee,$c_agent_mode,$c_shift,$c_act_date,$loan_type,$c_penalties,$c_created_on);
            if ($c_data) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "company configuration has been successfully saved."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Server error, could not create company instance"));
            }
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