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
    $loan_amount = htmlspecialchars(strip_tags($_POST['loan_amount']));
    $loan_duration = htmlspecialchars(strip_tags($_POST['loan_duration']));
    $issue_date = htmlspecialchars(strip_tags($_POST['issue_date']));
    $loan_monthly_amount = htmlspecialchars(strip_tags($_POST['loan_monthly_amount']));
    $loan_reason = htmlspecialchars(strip_tags($_POST['loan_reason']));
    $c_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $created_at = date("Y-m-d H:i:s");

    $generate_loan_id = rand(1000000, 9999999);
    $loan_id = 'GL'.$generate_loan_id;

    $dt = strtotime($issue_date);
    $loan_due_date = date("Y-m-d", strtotime("+$loan_duration months",$dt));

    $loan_due_month = date("F",strtotime($loan_due_date));
    $loan_due_year = date("Y",strtotime($loan_due_date));

    $curr_month = date("m");
    $m_diff = 12 - $curr_month;

    $loan_type = "Loan";
    $loan_month = 1;
    $current_balance = $loan_monthly_amount;
    $loan_status ="In Progress";


    if (!empty($guard_id) &&!empty($loan_amount) &&!empty($loan_duration) &&!empty($loan_monthly_amount)&&!empty($loan_reason) &&!empty($c_id)) {
            $month = date("F",strtotime($created_at));
            $year = date("Y",strtotime($created_at));
            $payroll_check = $company->check_if_guard_payroll_exist($loan_due_month,$loan_due_year,$c_id);
            if ($payroll_check['myCount'] > 0) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Guard Payroll already exist for ".$month.' - '.$year.". Delete existing payroll to issue a guard loan"));
                exit();
            } else {
                if (isset($_SESSION['COMPANY_LOGIN'])){
                    $result = $guard->issue_guard_loan(
                    $loan_id,$c_id,$guard_id,$loan_reason,$loan_amount,$loan_duration,$loan_monthly_amount,
                    $loan_amount,$issue_date,$loan_due_date,$loan_due_month,$loan_due_year,$created_at,$created_at);
        
                    if ($result) {
                        $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Issue  guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." a loan",
                            url_path('/company/guard-loan',true,true), $c['staff_photo'],$c['staff_name']
                        );
                        $guard->insert_guard_log(
                            $c_id,$guard_id,"Info", "Issue Loan",$created_at,
                            $g_det['guard_firstname']." ".$g_det['guard_lastname']." was issue a ".$loan_duration."month(s) loan of #".$loan_amount,
                            $loan_reason
                        );
                        http_response_code(200);
                         echo json_encode(array("status" => 1, "message" => "Loan Approved"));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Loan Not Approved"));
             }
                } else {
                    $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                    $permission_sno = $privileges->get_update_guard_permission_id();
                    $staff_perm_ids = $privileges->staff_perm_ids($staff_id);
            
                    $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));
            
                    if(!in_array($permission_sno['perm_sno'], $array)){
                     http_response_code(200);
                     echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                    } else {
                        $result = $guard->issue_guard_loan(
                        $loan_id,$c_id,$guard_id,$loan_reason,$loan_amount,$loan_duration,$loan_monthly_amount,
                        $loan_amount,$issue_date,$loan_due_date,$loan_due_month,$loan_due_year,$created_at,$created_at);
                        if ($result) {
                            $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Issue  guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." a loan",
                                url_path('/company/guard-loan',true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $guard->insert_guard_log(
                                $c_id,$guard_id,"Info", "Issue Loan",$created_at,
                                $g_det['guard_firstname']." ".$g_det['guard_lastname']." was issue a ".$loan_duration."month(s) loan of #".$loan_amount,
                                $loan_reason
                            );
                            http_response_code(200);
                             echo json_encode(array("status" => 1, "message" => "Loan Approved"));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Loan Not Approved"));
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