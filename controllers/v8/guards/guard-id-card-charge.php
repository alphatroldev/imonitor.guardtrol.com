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
    
    $guard_id = htmlspecialchars(strip_tags($_POST['guard_id']));
    $guard_id_card_remark = htmlspecialchars(strip_tags($_POST['guard_id_card_remark']));
    $guard_id_card_amt = htmlspecialchars(strip_tags($_POST['guard_id_card_amt']));
    $c_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $created_at = date("Y-m-d H:i:s");

          if (!empty($guard_id) &&!empty($guard_id_card_remark) &&!empty($guard_id_card_amt) &&!empty($c_id)) {
             if (isset($_SESSION['COMPANY_LOGIN'])){
                $result = $guard->guard_id_card_charge($c_id,$guard_id,$guard_id_card_remark, $guard_id_card_amt,$created_at);
                if ($result) {
                    $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Book guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." for (ID charge)",
                        url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    $guard->insert_guard_log(
                        $c_id,$guard_id,"Info", "ID card charge",$created_at,
                        $g_det['guard_firstname']." ".$g_det['guard_lastname']." was charge for ID card #".$guard_id_card_amt,
                        $guard_id_card_remark
                    );
                    http_response_code(200);
                     echo json_encode(array("status" => 1, "message" => "ID Card Issuance Approved"));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Request Failed"));
                }
             }else{
                $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                $permission_sno = $privileges->get_update_guard_permission_id();
                $staff_perm_ids = $privileges->staff_perm_ids($staff_id);
        
                $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));
        
                if(!in_array($permission_sno['perm_sno'], $array)){
                 http_response_code(200);
                 echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                }else{
                    $result = $guard->guard_id_card_charge($c_id,$guard_id,$guard_id_card_remark, $guard_id_card_amt,$created_at);
                   if ($result) {
                        $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Book guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." for (ID charge)",
                            url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                        );
                        $guard->insert_guard_log(
                           $c_id,$guard_id,"Info", "ID card charge",$created_at,
                           $g_det['guard_firstname']." ".$g_det['guard_lastname']." was charge for ID card #".$guard_id_card_amt,
                           $guard_id_card_remark
                        );
                     http_response_code(200);
                     echo json_encode(array("status" => 1, "message" => "ID Card Issuance Approved"));
                   } else {
                     http_response_code(200);
                     echo json_encode(array("status" => 0, "message" => "Request Failed"));
                   }
                }
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