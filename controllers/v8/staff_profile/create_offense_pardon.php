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
    $offense_id = htmlspecialchars(strip_tags($_POST['offense_id']));
    $pardon_reason = htmlspecialchars(strip_tags($_POST['pardon_reason']));
    $pa_created_on = date("Y-m-d H:i:s");

    if (!empty($offense_id) && !empty($pardon_reason) && !empty($pa_created_on)) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $s_data = $company->create_staff_offense_pardon($offense_id, $pardon_reason, $pa_created_on);
            if ($s_data) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Offense has been pardon."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Server error, could not pardon offence"));
            }
        } else {
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_book_staff_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',', $staff_perm_ids['perm_sno']));

            if (!in_array($permission_sno['perm_sno'], $array)) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            } else {
                $s_data = $company->create_staff_offense_pardon($offense_id, $pardon_reason, $pa_created_on);
                if ($s_data) {
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Offense has been pardon."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Server error, could not pardon offence"));
                }
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