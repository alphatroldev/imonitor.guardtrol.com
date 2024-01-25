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
    $c_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $beat_id = htmlspecialchars(strip_tags($_POST['beat_id']));
    $guardStatus = htmlspecialchars(strip_tags($_POST['guardStatus']));
    $CurrSalary = htmlspecialchars(strip_tags($_POST['cur_salary']));
    $DaysWorked = htmlspecialchars(strip_tags($_POST['days_worked']));
    $NewSalary = htmlspecialchars(strip_tags($_POST['new_salary']));
    $GPay = htmlspecialchars(strip_tags($_POST['gpay']));
    $comm_date = htmlspecialchars(strip_tags($_POST['comm_date']));
    $created_at = date("Y-m-d H:i:s", strtotime($_POST['dated_on']));
    $payEligible = htmlspecialchars(strip_tags($_POST['pay_eligibility']));
    $statusReason = htmlspecialchars(strip_tags($_POST['statusReason']));


    if (!empty($CurrSalary)&&!empty($guardStatus)&&!empty($statusReason)&&!empty($payEligible)&&!empty($DaysWorked)&&!empty($c_id)) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $DeEntry = $guard->guard_deactivate_entry(
                $c_id,$guard_id,$beat_id,$guardStatus,$payEligible,$CurrSalary,$DaysWorked,$NewSalary,$GPay,$statusReason,
                $comm_date,$created_at
            );
            if($DeEntry){
                if ($guard->delete_guard_deployment_data($guard_id,$c_id)) {
                    $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." status",
                        url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Return guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." to pool",
                        url_path('/company/list-guards',true,true), $c['staff_photo'],$c['staff_name']
                    );
                    $guard->insert_guard_log(
                        $c_id,$guard_id,"Info", "Change Status: $guardStatus",$created_at,
                        $g_det['guard_firstname']." ".$g_det['guard_lastname']." status changed to ".$guardStatus,$statusReason
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Guard successfully deactivated"));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Deactivated but Unable to delete deployment details."));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("status" => 0, "message" => "Unable to deactivate guard"));
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
                 $DeEntry = $guard->guard_deactivate_entry(
                    $c_id,$guard_id,$beat_id,$guardStatus,$payEligible,$CurrSalary,$DaysWorked,$NewSalary,$GPay,$statusReason,
                    $comm_date,$created_at
                );
                if($DeEntry){
                    if ($guard->delete_guard_deployment_data($guard_id,$c_id)) {
                        $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." status",
                            url_path('/staff/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                        );
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Return guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." to pool",
                            url_path('/staff/list-guards',true,true), $c['staff_photo'],$c['staff_name']
                        );
                        $guard->insert_guard_log(
                            $c_id,$guard_id,"Info", "Change Status: $guardStatus",$created_at,
                            $g_det['guard_firstname']." ".$g_det['guard_lastname']." status changed to ".$guardStatus,$statusReason
                        );
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Guard successfully deactivated"));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Deactivated but Unable to delete deployment details."));
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(array("status" => 0, "message" => "Unable to deactivate guard"));
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