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

    $edit_pos_type = htmlspecialchars(strip_tags($_POST['edit_pos_type']));
    $edit_pos_title = htmlspecialchars(strip_tags($_POST['edit_pos_title']));
    $edit_comp_id = htmlspecialchars(strip_tags($_POST['edit_comp_id']));
    $edit_pos_sno = htmlspecialchars(strip_tags($_POST['edit_pos_sno']));

    if (!empty($edit_pos_type) &&!empty($edit_pos_title) && !empty($edit_comp_id) &&!empty($edit_pos_sno)) {
        $result = $deploy_guard->update_guard_position($edit_pos_type,$edit_pos_title,$edit_comp_id,$edit_pos_sno);
        if ($result) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Guard position updated successfully"));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Guard position not updated"));
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