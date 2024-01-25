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
    $salary_adv_reason = htmlspecialchars(strip_tags($_POST['salary_adv_reason']));
    $salary_adv_amount = htmlspecialchars(strip_tags($_POST['salary_adv_amount']));
    $ded_month = htmlspecialchars(strip_tags($_POST['ded_month']));
    $ded_year = htmlspecialchars(strip_tags($_POST['ded_year']));
    $c_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $full_date = $ded_month.'/'.'01/'.$ded_year;

    $created_at = date("Y-m-d H:i:s", strtotime($full_date));

          if (!empty($guard_id) &&!empty($salary_adv_reason) &&!empty($salary_adv_amount) &&!empty($c_id)) {
                $month = date("F",strtotime($created_at));
                $year = date("Y",strtotime($created_at));
                $payroll_check = $company->check_if_guard_payroll_exist($month,$year,$c_id);
                if ($payroll_check['myCount'] > 0) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Guard Payroll already exist for ".$month.' - '.$year.". Delete existing payroll to issue salary advance"));
                    exit();
                } else {
                    if (isset($_SESSION['COMPANY_LOGIN'])){
                        $result = $guard->guard_issue_salary_adv($c_id,$guard_id, $salary_adv_reason, $salary_adv_amount, $created_at);
                        if ($result) {
                            $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Issue a salary advance to guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                                url_path('/company/guard-salary-advanced',true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $guard->insert_guard_log(
                                $c_id,$guard_id,"Info", "Issue Salary Adv.",$created_at,
                                $g_det['guard_firstname']." ".$g_det['guard_lastname']." was issue a salary advance of #".$salary_adv_amount,
                                $salary_adv_reason
                            );
                            http_response_code(200);
                             echo json_encode(array("status" => 1, "message" => "Salary Advance Approved"));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Salary Advance Not Approved"));
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
                            
                            $result = $guard->guard_issue_salary_adv($c_id,$guard_id, $salary_adv_reason, $salary_adv_amount, $created_at);
                             if ($result) {
                                $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                                $company->insert_notifications(
                                    $c['company_id'],"General","1", $c['staff_name']." Issue a salary advance to guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                                    url_path('/company/guard-salary-advanced',true,true), $c['staff_photo'],$c['staff_name']
                                );
                                 $guard->insert_guard_log(
                                     $c_id,$guard_id,"Info", "Issue Salary Adv.",$created_at,
                                     $g_det['guard_firstname']." ".$g_det['guard_lastname']." was issue a salary advance of #".$salary_adv_amount,
                                     $salary_adv_reason
                                 );
                               http_response_code(200);
                               echo json_encode(array("status" => 1, "message" => "Salary Advance Approved"));
                            } else {
                               http_response_code(200);
                               echo json_encode(array("status" => 0, "message" => "Salary Advance Not Approved"));
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