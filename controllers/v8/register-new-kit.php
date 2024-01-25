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
    $kit_name = htmlspecialchars(strip_tags($_POST['kit_name']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $k_created_on = date("Y-m-d H:i:s");

    if (!empty($kit_name) && !empty($comp_id) && !empty($k_created_on)) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $s_data = $company->create_company_kit($comp_id,$kit_name,$k_created_on);
            if ($s_data) {
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Create a new kit",
                    url_path('/company/kit-inventory',true,true), $c['staff_photo'],$c['staff_name']
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Kit has been successfully saved."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Server error, could not add kit"));
            }
        }else{
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_manage_kit_inventory_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            } else{
                $s_data = $company->create_company_kit($comp_id,$kit_name,$k_created_on);
                if ($s_data) {
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Create a new kit",
                        url_path('/company/kit-inventory',true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Kit has been successfully saved."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Server error, could not add kit"));
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