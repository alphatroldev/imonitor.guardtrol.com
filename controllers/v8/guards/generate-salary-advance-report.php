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

    $sa_rh_month = htmlspecialchars(strip_tags($_POST['sel_month']));
    $sa_rh_year = htmlspecialchars(strip_tags($_POST['sel_year']));

    $comp_id = $c['company_id'];
    $sa_rh_created_on = date("Y-m-d H:i:s");

    $days_sa_rh_month = cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($sa_rh_month."-".$sa_rh_year)),$sa_rh_year);
    $data = array();

    $payroll_check = $company->check_if_salary_advance_report_exist($sa_rh_month,$sa_rh_year,$comp_id);
    if ($payroll_check['myCount'] > 0) {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Salary advance report already exist for ".$sa_rh_month.' - '.$sa_rh_year));
        exit();
    } else {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $res_sal_adv = $company->sum_up_guard_sal_adv_amt_per_month_for_report($comp_id,$sa_rh_month,$sa_rh_year);
            $company_monthly_salary_advance = $res_sal_adv['advMonAmt'];

            $company->create_salary_advance_report_history($sa_rh_month,$sa_rh_year,$company_monthly_salary_advance,$sa_rh_created_on,$comp_id);
            $company->insert_notifications(
                $c['company_id'],"General","1", $c['staff_name']." Generate a guard salary advance report for ".$sa_rh_month.' - '.$sa_rh_year,
                url_path('/company/guard-salary-advance-report-details/'.$sa_rh_month.'-'.$sa_rh_year,true,true), $c['staff_photo'],$c['staff_name']
            );

            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "message" => "Guard Salary Advance Report Generated, click `continue` to view print page",
                "result" => $data,
                "location" => url_path('/company/guard-salary-advance-report-details/'.$sa_rh_month.'-'.$sa_rh_year,true,true)
            ));
        } else {
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_generate_payroll_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            } else{
                $res_sal_adv = $company->sum_up_guard_sal_adv_amt_per_month_for_report($comp_id,$sa_rh_month,$sa_rh_year);
                $company_monthly_salary_advance = $res_sal_adv['advMonAmt'];

                $company->create_salary_advance_report_history($sa_rh_month,$sa_rh_year,$company_monthly_salary_advance,$sa_rh_created_on,$comp_id);
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Generate a guard salary advance report for ".$sa_rh_month.' - '.$sa_rh_year,
                    url_path('/company/guard-salary-advance-report-details/'.$sa_rh_month.'-'.$sa_rh_year,true,true), $c['staff_photo'],$c['staff_name']
                );

                http_response_code(200);
                echo json_encode(array(
                    "status" => 1,
                    "message" => "Guard Salary Advance Report Generated, click `continue` to view print page",
                    "result" => $data,
                    "location" => url_path('/company/guard-salary-advance-report-details/'.$sa_rh_month.'-'.$sa_rh_year,true,true)
                ));
            }
        }
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>