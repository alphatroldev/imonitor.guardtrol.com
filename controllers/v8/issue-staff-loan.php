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
    $loan_amount = htmlspecialchars(strip_tags($_POST['loan_amount']));
    $loan_duration = htmlspecialchars(strip_tags($_POST['loan_duration']));
    $loan_monthly_amount = htmlspecialchars(strip_tags($_POST['loan_monthly_amount']));
    $issue_date = htmlspecialchars(strip_tags($_POST['issue_date']));
    $loan_reason = htmlspecialchars(strip_tags($_POST['loan_reason']));
    $staff_id = htmlspecialchars(strip_tags($_POST['staff_id']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));

    $loan_id = 'SL' . rand(100000, 999999);
    $l_created_on = date("Y-m-d H:i:s");

    $dt = strtotime($issue_date);
    $loan_due_date = date("Y-m-d", strtotime("+$loan_duration months",$dt));

    $loan_due_month = date("F",strtotime($loan_due_date));
    $loan_due_year = date("Y",strtotime($loan_due_date));

    $curr_month = date("m");
    $m_diff = 12 - $curr_month;
//    if (date('t') == date('d')){
//        $month_diff = $m_diff;
//    } else {
//        $month_diff = $m_diff+1;
//    }

    if (!empty($loan_amount) && !empty($loan_duration) && !empty($loan_monthly_amount) && !empty($loan_reason) && !empty($issue_date)) {
        if (!is_numeric($loan_monthly_amount)) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Invalid monthly repayment amount"));
        } else {
            if ($c['loan_config_type'] == 'yearly loan repayment type' && ($loan_duration > $m_diff)) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "This loan request (duration) exceed your company loan configuration (yearly loan repayment type)"));
            } else {
                if ($loan_amount < 1000) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Minimum loan amount is ₦1000"));
                } else {
                    if (isset($_SESSION['COMPANY_LOGIN'])){
                        if ($company->issue_staff_loan(
                            $loan_id, $comp_id, $staff_id, $loan_reason, $loan_amount, $loan_duration, $loan_monthly_amount,
                            $loan_amount,$issue_date,$loan_due_date,$loan_due_month,$loan_due_year,$l_created_on,$l_created_on
                        )) {
                            $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Issue a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." loan",
                                url_path('/company/staff-loan',true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $staff->insert_staff_log(
                                $comp_id,$staff_id,"Info", "Issue Loan",$l_created_on,
                                $s_det['staff_firstname']." ".$s_det['staff_lastname']." was issue a loan of #".$loan_amount. " for ".$loan_duration ." month(s)",$loan_reason
                            );
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Staff loan has been submitted successfully."));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Server error, could not submit loan"));
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
                            if ($company->issue_staff_loan(
                                $loan_id, $comp_id, $staff_id, $loan_reason, $loan_amount, $loan_duration, $loan_monthly_amount,
                                $loan_amount,$issue_date,$loan_due_date,$loan_due_month,$loan_due_year,$l_created_on,$l_created_on
                            )) {
                                $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                                $company->insert_notifications(
                                    $c['company_id'],"General","1", $c['staff_name']." Issue a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." loan",
                                    url_path('/company/staff-loan',true,true), $c['staff_photo'],$c['staff_name']
                                );
                                $staff->insert_staff_log(
                                    $comp_id,$staff_id,"Info", "Issue Loan",$l_created_on,
                                    $s_det['staff_firstname']." ".$s_det['staff_lastname']." was issue a loan of #".$loan_amount. " for ".$loan_duration ." month(s)",$loan_reason
                                );
                                http_response_code(200);
                                echo json_encode(array("status" => 1, "message" => "Staff loan has been submitted successfully."));
                            } else {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "Server error, could not submit loan"));
                            }
                        }
                    }
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