<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Beat.class.php');
include_once(getcwd().'/controllers/classes/Client.class.php');
include_once(getcwd().'/controllers/classes/DeployGuard.class.php');
include_once(getcwd().'/controllers/classes/Guard.class.php');
include_once(getcwd().'/controllers/classes/Company.class.php');
include_once(getcwd().'/controllers/classes/Staff.class.php');
include_once(getcwd().'/controllers/classes/Privileges.class.php');
include_once(getcwd().'/company/inc/helpers.php');
include_once(getcwd().'/staff/inc/helpers.php');
if (isset($_SESSION['COMPANY_LOGIN'])){
    $c = get_company();
}else{
    $c = get_staff();
}
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $offense_name = htmlspecialchars(strip_tags($_POST['offense_name']));
    $offense_id = htmlspecialchars(strip_tags($_POST['offense_id']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $off_charge = htmlspecialchars(strip_tags($_POST['off_charge']));
    $charge_amt = htmlspecialchars(strip_tags($_POST['charge_amt']));
    $days_deduct = htmlspecialchars(strip_tags($_POST['days_deduct']));

    if (!empty($offense_name) && !empty($offense_id) && !empty($comp_id) && !empty($off_charge)) {
        $result = $company->update_company_penalty_by_id($offense_name,$off_charge,$charge_amt,$days_deduct,$offense_id,$comp_id);
        if ($result==true) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Penalty has been successfully updated.","location"=>url_path('/company/penalties', true, true)));
        } else if ($result=="no_change"){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update penalty, no changes found."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update penalty."));
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