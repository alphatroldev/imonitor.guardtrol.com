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
    $stfStat = htmlspecialchars(strip_tags($_POST['stfStat']));
    $statusReason = htmlspecialchars(strip_tags($_POST['statusReason']));
    $staff_id = htmlspecialchars(strip_tags($_POST['staff_id']));
    $c_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $pay_eligible = htmlspecialchars(strip_tags($_POST['pay_eligibility']));

    if (!empty($c_id) && !empty($staff_id) && !empty($stfStat) && !empty($statusReason) && !empty($pay_eligible)) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $result = $company->update_staff_account_stat($stfStat,$statusReason,$pay_eligible,$staff_id,$c_id);
            if ($result==true) {
                $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Update a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." profile",
                    url_path('/company/edit-staff/'.$staff_id,true,true), $c['staff_photo'],$c['staff_name']
                );
                $staff->insert_staff_log(
                    $c_id,$staff_id,"Info", "Change Status: $stfStat",date("Y-m-d H:i:s"),
                    $s_det['staff_firstname']." ".$s_det['staff_lastname']." status was changed to ".$stfStat,$statusReason
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Staff account status update successful"));
            } else if ($result =="no_change"){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Failed to update staff account status, no changes found."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Failed to update staff account status."));
            }
        }else{
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_update_staff_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            } else{
                $result = $company->update_staff_account_stat($stfStat,$statusReason,$pay_eligible,$staff_id,$c_id);
                if ($result==true) {
                    $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Update a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." profile",
                        url_path('/company/edit-staff/'.$staff_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    $staff->insert_staff_log(
                        $c_id,$staff_id,"Info", "Change Status: $stfStat",date("Y-m-d H:i:s"),
                        $s_det['staff_firstname']." ".$s_det['staff_lastname']." status was changed to ".$stfStat,$statusReason
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Staff account status update successful"));
                } else if ($result =="no_change"){
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update staff account status, no changes found."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update staff account status."));
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