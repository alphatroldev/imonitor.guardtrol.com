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
    // $kit_type = htmlspecialchars(strip_tags($_POST['kit_type']));
    // $kit_id = htmlspecialchars(strip_tags($_POST['kit_id']));
    // $kit_num = htmlspecialchars(strip_tags($_POST['kit_num']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $k_created_on = date("Y-m-d H:i:s");
    $k_updated_on = date("Y-m-d H:i:s");

    $kit_number = count($_POST["kit_type"]);
    
    // print_r($kit_number); die;

    if ($kit_number > 0) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $error = 0;
            for ($i = 0; $i < $kit_number; $i++) {
                $kit_type = htmlspecialchars(strip_tags($_POST['kit_type'][$i]));
                $kit_id = htmlspecialchars(strip_tags($_POST['kit_id'][$i]));
                $kit_qty = htmlspecialchars(strip_tags($_POST['kit_num'][$i]));
                if(!empty($kit_type) && !empty($kit_id) && !empty($kit_qty)) {
                    $company->create_company_kit_inventory($comp_id,$kit_type,$kit_id,$kit_qty,$k_created_on,$k_updated_on);
                    $company->create_kit_inventory_history(
                        $comp_id,"Success",NULL,"Add New Kit",$kit_id." was Added to inventory; qty - ".$kit_qty,$k_created_on
                    );
                } else{
                    $error++;
                }
            }

            if ($error == 0) {
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Add a new kit",
                    url_path('/company/kit-inventory',true,true), $c['staff_photo'],$c['staff_name']
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Kit inventory has been successfully saved.","location"=>url_path('/company/kit-inventory',true,true)));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Server error, could not save kit inventory (empty field)"));
            }
        } else {
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_manage_kit_inventory_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            } else{
                $error = 0;
                for ($i = 0; $i < $kit_number; $i++) {
                    $kit_type = htmlspecialchars(strip_tags($_POST['kit_type'][$i]));
                    $kit_id = htmlspecialchars(strip_tags($_POST['kit_id'][$i]));
                    $kit_qty = htmlspecialchars(strip_tags($_POST['kit_num'][$i]));

                    if(!empty($kit_type) && !empty($kit_id) && !empty($kit_qty)) {
                        $company->create_company_kit_inventory($comp_id,$kit_type,$kit_id,$kit_qty,$k_created_on,$k_updated_on);
                        $company->create_kit_inventory_history(
                            $comp_id,"Success",NULL,"Add New Kit",$kit_id." was Added to inventory; qty - ".$kit_qty,$k_created_on
                        );
                    } else{
                        $error++;
                    }
                }

                if ($error == 0) {
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Add a new kit",
                        url_path('/company/kit-inventory',true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Kit inventory has been successfully saved.","location"=>url_path('/staff/kit-inventory',true,true)));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Server error, could not save kit inventory (empty field)"));
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