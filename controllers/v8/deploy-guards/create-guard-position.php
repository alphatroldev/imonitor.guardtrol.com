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

    $pos_type = htmlspecialchars(strip_tags($_POST['pos_type']));
    $pos_title = htmlspecialchars(strip_tags($_POST['pos_title']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));

    $created_at = date("Y-m-d H:i:s");

    if (!empty($pos_type) &&!empty($pos_title) &&!empty($comp_id) &&!empty($created_at)) {
        $result = $deploy_guard->create_guard_position($pos_type,$pos_title,$comp_id,$created_at);
        if ($result) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Guard position added successfully"));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Guard position not added"));
        }

    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>