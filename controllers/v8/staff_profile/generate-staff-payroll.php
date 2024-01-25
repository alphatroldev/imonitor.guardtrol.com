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

    if (isset($_POST['staff_check']) && count($_POST['staff_check']) > 0){
        $spr_month = htmlspecialchars(strip_tags($_POST['sel_month']));

        $spr_year = htmlspecialchars(strip_tags($_POST['sel_year']));
        $comp_id = $c['company_id'];

        $spr_created_on = date("Y-m-d H:i:s");
        $spr_updated_on = date("Y-m-d H:i:s");
        $data = array();
        $staff_ids = array();

        $payroll_check = $company->check_if_payroll_exist($spr_month,$spr_year,$comp_id);
        if ($payroll_check['myCount'] > 0) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Payroll already exist for ".$spr_month.' - '.$spr_year));
            exit();
        } else {
            if (isset($_SESSION['COMPANY_LOGIN'])){
                foreach ($_POST['staff_check'] AS $key => $id) {
                    $staff_id = $_POST['staff_check'][$key];
                    $offense_ded = $company->sum_up_staff_offense_amt_per_month($staff_id, $spr_month, $spr_year, $comp_id);
                    $offense_amt = $offense_ded['Amt']==null?0:$offense_ded['Amt'];
                    $offense_days = $offense_ded['days']==null?0:$offense_ded['days'];
                    $month_days = date("t", strtotime($spr_month));
                    $rem_sal_days = $month_days - $offense_days;
                    $s_d = $company->get_payroll_staff_data($comp_id, $staff_id);
                    $days_miss_amt = ($offense_days / $month_days) * $s_d['staff_salary'];
                    $tot_offence_amt = $days_miss_amt + $offense_amt;

                    $sal_days_amt = $s_d['staff_salary'] - $days_miss_amt;



                    $res = $company->count_in_progress_loan($s_d['staff_loan_id'], $staff_id, $comp_id);
                    $repay_id = '0';
                    if ($res['myCount'] >= $s_d['staff_loan_month']) {
                        $monthly_loan_amount = 0;
                    } else {
                        $exist_this_month_deduct = $company->test_if_loan_is_settled_this_month($s_d['staff_loan_id'], $staff_id, $comp_id, $spr_created_on, $spr_created_on);
                        if ($exist_this_month_deduct['myCount'] > 0) {
                            $monthly_loan_amount = 0;
                            $repay_id = '0';
                        } else {
                            $loan_balance = $s_d['staff_loan_curr_balance'] - $s_d['staff_loan_monthly_amount'];
                            $month_left = $s_d['staff_loan_month'] - 1;
                            $monthly_loan_amount = $s_d['staff_loan_monthly_amount'];
                            $paid_month = date("F", strtotime($spr_created_on));
                            $paid_year = date("Y", strtotime($spr_created_on));
                            $repay_id = $company->create_staff_repayment_deduct($s_d['staff_loan_id'], $comp_id, $staff_id, $loan_balance, $month_left, $paid_month, $paid_year, $spr_created_on);
                            $company->update_curr_loan_balance($s_d['staff_loan_id'], $comp_id, $staff_id, $loan_balance);
                        }
                    }

                    $payroll_cred_data = 0;
                    $payroll_deb_data = 0;
                    $spd = $company->get_staff_payroll_data_settings($c['company_id']);
                    if ($spd->num_rows > 0) {
                        while ($spd_s = $spd->fetch_assoc()) {
                            if ($spd_s['payroll_type']=="Credit"){
                                if ($spd_s['payment_mode'] == "Monthly"){
                                    $payroll_cred_data = $payroll_cred_data + $spd_s['payroll_amount'];
                                } elseif($spd_s['payment_mode'] == "One Time") {
                                    if ($spd_s['mon_month']==$spr_month && $spd_s['mon_year']==$spr_year){
                                        $payroll_cred_data = $payroll_cred_data + $spd_s['payroll_amount'];
                                    } else {
                                        $payroll_cred_data = $payroll_cred_data + 0;
                                    }
                                }
                            } else if ($spd_s['payroll_type']=="Debit"){
                                if ($spd_s['payment_mode'] == "Monthly"){
                                    $payroll_deb_data = $payroll_deb_data + $spd_s['payroll_amount'];
                                } elseif($spd_s['payment_mode'] == "One Time") {
                                    if ($spd_s['mon_month']==$spr_month && $spd_s['mon_year']==$spr_year){
                                        $payroll_deb_data = $payroll_deb_data + $spd_s['payroll_amount'];
                                    } else {
                                        $payroll_deb_data = $payroll_deb_data + 0;
                                    }
                                }
                            }
                        }
                    }

                    $res_sal_adv = $company->sum_up_staff_sal_adv_amt_per_month($staff_id, $comp_id, $spr_month, $spr_year);
                    $monthly_salary_advance = $res_sal_adv['advMonAmt'];

                    $total_deduction = $tot_offence_amt + $monthly_loan_amount + $monthly_salary_advance+$payroll_deb_data;
                    $net_pay = $s_d['staff_salary'] + $payroll_cred_data - $total_deduction;

                    $company->create_staff_payroll(
                        $spr_month,$spr_year,$s_d['staff_salary'],$offense_amt,$offense_days,$monthly_loan_amount,$repay_id,
                        $monthly_salary_advance,$staff_id,$comp_id,$tot_offence_amt,$payroll_cred_data,$payroll_deb_data,
                        $total_deduction,$net_pay, $spr_created_on,$spr_created_on
                    );

                    $staff_details = [
                        'staff_id' => $staff_id,
                        'staff_name' => $s_d['staff_firstname'] . " " . $s_d['staff_lastname'],
                        'staff_dept' => $s_d['company_role_name'],
                        'total_offense' => $tot_offence_amt,
                        'total_loan' => $monthly_loan_amount,
                        'salary_adv' => $monthly_salary_advance,
                        'sur_c_days' => $offense_days,
                        'sur_c_amt' => $offense_amt,
                        'total_penalty' => $tot_offence_amt,
                        'total_deduction' => $total_deduction,
                        'net_pay' => $net_pay
                    ];
                    $data[] = $staff_details;
                }

                if (count($data) > 0) {
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Generate a staff payroll for ".$spr_month.' - '.$spr_year,
                        url_path('/company/staff-payroll/'.$spr_month.'-'.$spr_year,true,true), $c['staff_photo'],$c['staff_name']
                    );

                    http_response_code(200);
                    echo json_encode(array(
                        "status" => 1,
                        "message" => "Payroll Generated, click `continue` to view print page",
                        "result" => $data,
                        "location" => url_path('/company/staff-payroll/'.$spr_month.'-'.$spr_year,true,true)
                    ));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Could not fetch staff loan offense details"));
                }
            }else{
                $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                $permission_sno = $privileges->get_generate_payroll_permission_id();
                $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

                if(!in_array($permission_sno['perm_sno'], $array)){
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                } else{
                    foreach ($_POST['staff_check'] AS $key => $id) {
                        $staff_id = $_POST['staff_check'][$key];
                        $offense_ded = $company->sum_up_staff_offense_amt_per_month($staff_id, $spr_month, $spr_year, $comp_id);
                        $offense_amt = $offense_ded['Amt']==null?0:$offense_ded['Amt'];
                        $offense_days = $offense_ded['days']==null?0:$offense_ded['days'];
                        $month_days = date("t", strtotime($spr_month));
                        $rem_sal_days = $month_days - $offense_days;
                        $s_d = $company->get_payroll_staff_data($comp_id, $staff_id);
                        $days_miss_amt = ($offense_days / $month_days) * $s_d['staff_salary'];
                        $tot_offence_amt = $days_miss_amt + $offense_amt;

                        $sal_days_amt = $s_d['staff_salary'] - $days_miss_amt;

                        $payroll_cred_data = 0;
                        $payroll_deb_data = 0;
                        $spd = $company->get_staff_payroll_data_settings($c['company_id']);
                        if ($spd->num_rows > 0) {
                            while ($spd_s = $spd->fetch_assoc()) {
                                if ($spd_s['payroll_type']=="Credit"){
                                    if ($spd_s['payment_mode'] == "Monthly"){
                                        $payroll_cred_data = $payroll_cred_data + $spd_s['payroll_amount'];
                                    } elseif($spd_s['payment_mode'] == "One Time") {
                                        if ($spd_s['mon_month']==$spr_month && $spd_s['mon_year']==$spr_year){
                                            $payroll_cred_data = $payroll_cred_data + $spd_s['payroll_amount'];
                                        } else {
                                            $payroll_cred_data = $payroll_cred_data + 0;
                                        }
                                    }
                                } else if ($spd_s['payroll_type']=="Debit"){
                                    if ($spd_s['payment_mode'] == "Monthly"){
                                        $payroll_deb_data = $payroll_deb_data + $spd_s['payroll_amount'];
                                    } elseif($spd_s['payment_mode'] == "One Time") {
                                        if ($spd_s['mon_month']==$spr_month && $spd_s['mon_year']==$spr_year){
                                            $payroll_deb_data = $payroll_deb_data + $spd_s['payroll_amount'];
                                        } else {
                                            $payroll_cred_data = $payroll_cred_data + 0;
                                        }
                                    }
                                }
                            }
                        }

                        $repay_id = '0';
                        $res = $company->count_in_progress_loan($s_d['staff_loan_id'], $staff_id, $comp_id);
                        if ($res['myCount'] >= $s_d['staff_loan_month']) {
                            $monthly_loan_amount = 0;
                        } else {
                            $exist_this_month_deduct = $company->test_if_loan_is_settled_this_month($s_d['staff_loan_id'], $staff_id, $comp_id, $spr_created_on, $spr_created_on);
                            if ($exist_this_month_deduct['myCount'] > 0) {
                                $monthly_loan_amount = 0;
                                $repay_id = '0';
                            } else {
                                $loan_balance = $s_d['staff_loan_curr_balance'] - $s_d['staff_loan_monthly_amount'];
                                $month_left = $s_d['staff_loan_month'] - 1;
                                $monthly_loan_amount = $s_d['staff_loan_monthly_amount'];
                                $paid_month = date("F", strtotime($spr_created_on));
                                $paid_year = date("Y", strtotime($spr_created_on));
                                $repay_id = $company->create_staff_repayment_deduct($s_d['staff_loan_id'], $comp_id, $staff_id, $loan_balance, $month_left, $paid_month, $paid_year, $spr_created_on);
                                $company->update_curr_loan_balance($s_d['staff_loan_id'], $comp_id, $staff_id, $loan_balance);
                            }
                        }

                        $res_sal_adv = $company->sum_up_staff_sal_adv_amt_per_month($staff_id, $comp_id, $spr_month, $spr_year);
                        $monthly_salary_advance = $res_sal_adv['advMonAmt'];

                        $total_deduction = $tot_offence_amt + $monthly_loan_amount + $monthly_salary_advance;
                        $net_pay = $s_d['staff_salary'] - $total_deduction;

                        $company->create_staff_payroll(
                            $spr_month,$spr_year,$s_d['staff_salary'],$offense_amt,$offense_days,$monthly_loan_amount,$repay_id,
                            $monthly_salary_advance,$staff_id,$comp_id,$tot_offence_amt,$payroll_cred_data,$payroll_deb_data,
                            $total_deduction,$net_pay, $spr_created_on,$spr_created_on
                        );

                        $staff_details = [
                            'staff_id' => $staff_id,
                            'staff_name' => $s_d['staff_firstname'] . " " . $s_d['staff_lastname'],
                            'staff_dept' => $s_d['company_role_name'],
                            'total_offense' => $tot_offence_amt,
                            'total_loan' => $monthly_loan_amount,
                            'salary_adv' => $monthly_salary_advance,
                            'sur_c_days' => $offense_days,
                            'sur_c_amt' => $offense_amt,
                            'total_penalty' => $tot_offence_amt,
                            'total_deduction' => $total_deduction,
                            'net_pay' => $net_pay
                        ];
                        $data[] = $staff_details;
                    }

                    if (count($data) > 0) {
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Generate a staff payroll for ".$spr_month.' - '.$spr_year,
                            url_path('/company/staff-payroll/'.$spr_month.'-'.$spr_year,true,true), $c['staff_photo'],$c['staff_name']
                        );
                        http_response_code(200);
                        echo json_encode(array(
                            "status" => 1,
                            "message" => "Payroll Generated, click `continue` to view print page",
                            "result" => $data,
                            "location" => url_path('/staff/staff-payroll/'.$spr_month.'-'.$spr_year,true,true)
                        ));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Could not fetch staff loan offense details"));
                    }
                }
            }
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly select at least one staff, to generate payroll"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>