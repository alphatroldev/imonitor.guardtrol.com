<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Company.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $offense_name = htmlspecialchars(strip_tags($_POST['offense_name']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $off_charge = htmlspecialchars(strip_tags($_POST['off_charge']));
    $charge_amt = htmlspecialchars(strip_tags($_POST['charge_amt']));
    $days_deduct = htmlspecialchars(strip_tags($_POST['days_deduct']));
    $p_created_on = date("Y-m-d H:i:s");

    if (!empty($offense_name) && !empty($comp_id) && !empty($off_charge) && !empty($p_created_on)) {
        $s_data = $company->create_company_penalty($comp_id,$offense_name,$off_charge,$charge_amt,$days_deduct,$p_created_on);
        if ($s_data) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Penalty has been successfully saved."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Server error, could not create penalty"));
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