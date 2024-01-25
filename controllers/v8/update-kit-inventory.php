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
    $kit_type = htmlspecialchars(strip_tags($_POST['edit_kit_type']));
    $kit_id = htmlspecialchars(strip_tags($_POST['edit_kit_id']));
    $kit_num = htmlspecialchars(strip_tags($_POST['edit_kit_num']));
    $comp_id = htmlspecialchars(strip_tags($_POST['edit_comp_id']));
    $kit_inv_sno = htmlspecialchars(strip_tags($_POST['edit_kit_inv_sno']));
    $k_updated_on = date("Y-m-d H:i:s");
    
    // echo $kit_num." # "; die;

    if (!empty($kit_type) && !empty($kit_id) && !empty($comp_id) && !empty($kit_inv_sno) && !empty($k_updated_on)) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $s_data = $company->update_company_kit_inventory($comp_id,$kit_inv_sno,$kit_type,$kit_id,$kit_num,$k_updated_on);
            if ($s_data) {
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Update kit inventory",
                    url_path('/company/kit-inventory/',true,true), $c['staff_photo'],$c['staff_name']
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Kit inventory has been successfully updated."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Server error, could not update kit inventory"));
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
                $s_data = $company->update_company_kit_inventory($comp_id,$kit_inv_sno,$kit_type,$kit_id,$kit_num,$k_updated_on);
                if ($s_data) {
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Update kit inventory",
                        url_path('/company/kit-inventory/',true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Kit inventory has been successfully updated."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Server error, could not update kit inventory"));
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