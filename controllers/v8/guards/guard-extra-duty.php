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
    $extra_duty_remark = htmlspecialchars(strip_tags($_POST['extra_duty_remark']));
    $extra_duty_beat_id = htmlspecialchars(strip_tags($_POST['extra_duty_beat_id']));
    $extra_duty_guard_replace = htmlspecialchars(strip_tags($_POST['extra_duty_guard_replace']));
    $extra_duty_No_Of_Days = htmlspecialchars(strip_tags($_POST['extra_duty_No_Of_Days']));
    $c_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $g_salary = htmlspecialchars(strip_tags((floatval($_POST['g_salary']))));
    $created_at = date("Y-m-d H:i:s", strtotime($_POST['extra_duty_date']));
    $calendar_days = date("t", strtotime($_POST['extra_duty_date']));

    
    $charge_amt = ($extra_duty_No_Of_Days/$calendar_days) * $g_salary;

          if (!empty($guard_id) &&!empty($extra_duty_remark) &&!empty($extra_duty_beat_id) &&!empty($extra_duty_guard_replace) &&!empty($extra_duty_No_Of_Days) &&!empty($c_id)) {
                $month = date("F",strtotime($created_at));
                $year = date("Y",strtotime($created_at));
                $payroll_check = $company->check_if_guard_payroll_exist($month,$year,$c_id);
                // if ($payroll_check['myCount'] > 0) {
                //     http_response_code(200);
                //     echo json_encode(array("status" => 0, "message" => "Guard Payroll already exist for ".$month.' - '.$year.". Delete existing payroll to save extra duty details"));
                //     exit();
                // } else {
                    if (isset($_SESSION['COMPANY_LOGIN'])){
                        $result = $guard->guard_extra_duty($c_id,$guard_id,$extra_duty_remark,$extra_duty_beat_id,$extra_duty_guard_replace,$extra_duty_No_Of_Days,$charge_amt,$created_at);
                        if ($result) {
                            $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Issue an extra duty to guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                                url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $guard->insert_guard_log(
                                $c_id,$guard_id,"Info", "Extra Duty",$created_at,
                                $g_det['guard_firstname']." ".$g_det['guard_lastname']." worked extra duty for ".$extra_duty_No_Of_Days." days",
                                $extra_duty_remark
                            );
                            http_response_code(200);
                             echo json_encode(array("status" => 1, "message" => "Approved"));
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
                            $result = $guard->guard_extra_duty($c_id,$guard_id,$extra_duty_remark, $extra_duty_beat_id, $extra_duty_guard_replace,$extra_duty_No_Of_Days,$charge_amt,$created_at);
                            if ($result) {
                                $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                                $company->insert_notifications(
                                    $c['company_id'],"General","1", $c['staff_name']." Issue an extra duty to guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                                    url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                                );
                                $guard->insert_guard_log(
                                    $c_id,$guard_id,"Info", "Extra Duty",$created_at,
                                    $g_det['guard_firstname']." ".$g_det['guard_lastname']." worked extra duty for ".$extra_duty_No_Of_Days." days",
                                    $extra_duty_remark
                                );
                                http_response_code(200);
                                 echo json_encode(array("status" => 1, "message" => "Approved"));
                            } else {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "Request Failed"));
                            }
                        }
            }
                // }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>