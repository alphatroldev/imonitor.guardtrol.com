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
    $g_salary = htmlspecialchars(strip_tags($_POST['g_salary']));
    $offense_title = htmlspecialchars(strip_tags($_POST['offense_title']));
    $charge_mode = htmlspecialchars(strip_tags($_POST['charge_mode']));

    $d = new DateTime($_POST['offense_date']);
    $calendar_days = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y'));

    if ($charge_mode == "Flat Amount"){
        $charge_days = "0";
        $charge_amt = htmlspecialchars(strip_tags($_POST['charge_amt']));
    } else if ($charge_mode == "Deduct days worked"){
        $charge_days = htmlspecialchars(strip_tags($_POST['charge_days']));
        $charge_amt = ($charge_days/$calendar_days) * $g_salary;
    } else if ($charge_mode == "Permanent dismissal"){
        $charge_days = "0";
        $charge_amt = 0.00;
    }

    $guard_offense_remark = htmlspecialchars(strip_tags($_POST['guard_offense_remark']));
    $c_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $created_at = date("Y-m-d H:i:s", strtotime($_POST['offense_date']));

          if (!empty($guard_id) &&!empty($offense_title) &&!empty($charge_mode)&&!empty($guard_offense_remark) &&!empty($c_id)) {
                $month = date("F",strtotime($created_at));
                $year = date("Y",strtotime($created_at));
                $payroll_check = $company->check_if_guard_payroll_exist($month,$year,$c_id);
                if ($payroll_check['myCount'] > 0) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Guard Payroll already exist for ".$month.' - '.$year.". Delete existing payroll  to book a guard"));
                    exit();
                } else {
                    if (isset($_SESSION['COMPANY_LOGIN'])){
                       $result = $guard->book_guard_offense($c_id,$guard_id,$offense_title,$charge_mode,$charge_days,$charge_amt,$guard_offense_remark,$created_at);
                        if ($result) {
                            if ($charge_mode == "Permanent dismissal"){
                                $guard->guard_status($c_id,$guard_id,"Deactivate", $guard_offense_remark, "no",$created_at);
                            }
                            $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Book a guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                                url_path('/company/guard-offenses',true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $guard->insert_guard_log(
                                $c_id,$guard_id,"Info", "Booked guard",$created_at,
                                $g_det['guard_firstname']." ".$g_det['guard_lastname']." was booked for ".$offense_title,$guard_offense_remark
                            );
                            http_response_code(200);
                             echo json_encode(array("status" => 1, "message" => "Guard Booked"));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Request Failed"));
                       }
                    } else {
                        $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                        $permission_sno = $privileges->get_book_guard_permission_id();
                        $staff_perm_ids = $privileges->staff_perm_ids($staff_id);
                
                        $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));
                
                        if(!in_array($permission_sno['perm_sno'], $array)){
                             http_response_code(200);
                             echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                        } else {
                            $result = $guard->book_guard_offense($c_id,$guard_id,$offense_title,$charge_mode,$charge_days,$charge_amt,$guard_offense_remark,$created_at);
                            if ($result) {
                               $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                                $company->insert_notifications(
                                    $c['company_id'],"General","1", $c['staff_name']." Book a guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                                    url_path('/company/guard-offenses',true,true), $c['staff_photo'],$c['staff_name']
                                );
                                $guard->insert_guard_log(
                                    $c_id,$guard_id,"Info", "Booked guard",$created_at,
                                    $g_det['guard_firstname']." ".$g_det['guard_lastname']." was booked for ".$offense_title,$guard_offense_remark
                                );
                                 http_response_code(200);
                                 echo json_encode(array("status" => 1, "message" => "Guard Booked"));
                            } else {
                             http_response_code(200);
                             echo json_encode(array("status" => 0, "message" => "Request Failed"));
                            }
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