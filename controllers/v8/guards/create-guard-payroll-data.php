<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Company.class.php');
include_once(getcwd().'/controllers/classes/Beat.class.php');
include_once(getcwd().'/controllers/classes/Client.class.php');
include_once(getcwd().'/controllers/classes/DeployGuard.class.php');
include_once(getcwd().'/controllers/classes/Guard.class.php');
include_once(getcwd().'/controllers/classes/Staff.class.php');
include_once(getcwd().'/controllers/classes/Privileges.class.php');
include_once(getcwd().'/company/inc/helpers.php');
include_once(getcwd().'/staff/inc/helpers.php');
if (isset($_SESSION['COMPANY_LOGIN'])){
    $c = get_company();
} else {
    $c = get_staff();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $g_id = htmlspecialchars(strip_tags($_POST['guard_id']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $p_tit = htmlspecialchars(strip_tags($_POST['payroll_title']));
    $p_typ = htmlspecialchars(strip_tags($_POST['payroll_typ']));
    $pay_mode = htmlspecialchars(strip_tags($_POST['payment_mode']));
    $pay_amt = htmlspecialchars(strip_tags($_POST['payroll_amount']));
    $month = htmlspecialchars(strip_tags($_POST['mon_month']));
    $year = htmlspecialchars(strip_tags($_POST['mon_year']));
    $pay_rem = htmlspecialchars(strip_tags($_POST['payroll_remark']));

    $pay_created_on = date("Y-m-d H:i:s",strtotime($_POST['pay_data_date']));
    $issue_date = date("Y-m-d H:i:s");

    if (!empty($p_tit) && !empty($p_typ) && !empty($pay_mode) && !empty($pay_amt) && !empty($pay_rem)) {

        $payroll_check = $company->check_if_guard_payroll_exist($month,$year,$comp_id);
        if ($payroll_check['myCount'] > 0) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Guard Payroll already exist for ".$month.' - '.$year.". Delete existing payroll before you can create payroll data"));
            exit();
        } else {
            if (isset($_SESSION['COMPANY_LOGIN'])) {
                $gpd_data = $guard->create_guard_payroll_data($comp_id, $g_id, $p_tit, $p_typ, $pay_mode, $pay_amt, $month, $year, $pay_rem, $pay_created_on, $issue_date);
                if ($gpd_data) {
                    $g_det = $guard->get_guard_details_by_guard_id($g_id);
                    $company->insert_notifications(
                        $c['company_id'],
                        "General",
                        "1",
                        $c['staff_name']." Issue guard: ". $g_det['guard_firstname']." ".$g_det['guard_lastname'].
                        "a payroll ".$p_typ." on ".$issue_date,
                        url_path('/company/edit-guard/'.$g_id, true, true),
                        $c['staff_photo'],
                        $c['staff_name']
                    );
                    $guard->insert_guard_log(
                        $c['company_id'],
                        $g_id,
                        "Info",
                        "Payroll ".$p_typ,
                        $issue_date,
                        $g_det['guard_firstname']." ".$g_det['guard_lastname']." was issue a payroll ".$p_typ,
                        $pay_rem
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Payroll data created successfully."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Server error, could not create payroll data"));
                }
            } else {
                $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                $permission_sno = $privileges->get_book_guard_permission_id();
                $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                $array = array_map('intval', explode(',', $staff_perm_ids['perm_sno']));

                if (!in_array($permission_sno['perm_sno'], $array)) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                } else {
                    $gpd_data = $guard->create_guard_payroll_data($comp_id, $g_id, $p_tit, $p_typ, $pay_mode, $pay_amt, $month, $year, $pay_rem, $pay_created_on, $issue_date);
                    if ($gpd_data) {
                        $g_det = $guard->get_guard_details_by_guard_id($g_id);
                        $company->insert_notifications(
                            $c['company_id'],
                            "General",
                            "1",
                            $c['staff_name']." Issue guard: ". $g_det['guard_firstname']." ".$g_det['guard_lastname'].
                        "a ".$p_typ." on ".$issue_date,
                            url_path('/company/edit-guard/'.$g_id, true, true),
                            $c['staff_photo'],
                            $c['staff_name']
                        );
                        $guard->insert_guard_log(
                            $c['company_id'],
                            $g_id,
                            "Info",
                            "Payroll ".$p_typ,
                            $issue_date,
                            $g_det['guard_firstname']." ".$g_det['guard_lastname']." was issue a payroll ".$p_typ,
                            $pay_rem
                        );
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Payroll data created successfully."));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Server error, could not create payroll data"));
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
?>