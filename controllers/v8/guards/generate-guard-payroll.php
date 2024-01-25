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

    if (isset($_POST['guard_check']) && count($_POST['guard_check']) > 0){
        $gpr_month = htmlspecialchars(strip_tags($_POST['sel_month']));

        $gpr_year = htmlspecialchars(strip_tags($_POST['sel_year']));
        $comp_id = $c['company_id'];

        // $gpr_created_on = date("Y-m-d H:i:s");
        // $gpr_updated_on = date("Y-m-d H:i:s");

        $days_in_inv_month = cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($gpr_month."-".$gpr_year)),$gpr_year);
        
        $full_date = $days_in_inv_month."-".$gpr_month.' - '.$gpr_year;
        $gpr_created_on = date("Y-m-d H:i:s", strtotime($full_date));
        $gpr_updated_on = date("Y-m-d H:i:s", strtotime($full_date));
        $data = array();
        $guard_ids = array();

        $payroll_check = $company->check_if_guard_payroll_exist($gpr_month,$gpr_year,$comp_id);
        if ($payroll_check['myCount'] > 0) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Guard Payroll already exist for ".$gpr_month.' - '.$gpr_year));
            exit();
        } else {
            if (isset($_SESSION['COMPANY_LOGIN'])){
                foreach ($_POST['guard_check'] AS $key => $id) {
                    $guard_id = $_POST['guard_check'][$key];
                    $offense_ded = $company->sum_up_guard_offense_amt_per_month($guard_id,$gpr_month,$gpr_year,$comp_id);
                    $tot_offense_amt = $offense_ded['Amt'] == null?0:$offense_ded['Amt'];
                    $offense_days = $offense_ded['DaysOf'] == null?0:$offense_ded['DaysOf'];
                    $obs_pay = 0;
                    $agent_fee = 0;

                    $gd_deactivated_per_month = $company->sum_up_guard_deactivated_pay_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                    $w_amt_b4_deactivate = !empty($gd_deactivated_per_month)?$gd_deactivated_per_month['amount_pay']:0;
                    $w_day_b4_deactivate = !empty($gd_deactivated_per_month)?$gd_deactivated_per_month['days_pay']:0;

                    $g_d = $company->get_payroll_guard_data($comp_id,$guard_id);
                    
                    $dop_date = new DateTime($g_d['dop']);
                    $gpr_date = new DateTime($full_date);
                    
                    if (!empty($g_d['dop']) && ($gpr_date >= $dop_date) ) {
                        $deployment_date = !empty($g_d) ? $g_d['commencement_date'] : "0000-00-00";

                        $dep_month = date("F", strtotime($deployment_date));
                        $dep_year = date("Y", strtotime($deployment_date));

                        $days_worked = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($gpr_month . "-" . $gpr_year)), $gpr_year);
                        if ($dep_month == $gpr_month && $dep_year == $gpr_year) {
                            $d = new DateTime($deployment_date);
                            $days_worked_N = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y')) + 1 - $d->format('d');
                            $days_in_dep_month = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y'));
                            $days_worked = $days_worked_N;
                            $guard_pay_salary = ($days_worked / $days_in_dep_month) * $g_d['g_dep_salary'];
                            if ($g_d['paid_observation'] == "yes") {
                                $obs_pay = ($g_d['number_of_days_worked'] / $days_in_dep_month) * $g_d['g_dep_salary'];
                            }
                        } else {
                            $g_dep_salary=isset($g_d['g_dep_salary'])?$g_d['g_dep_salary']:0;
                            $guard_pay_salary = ($days_worked / $days_in_inv_month) * $g_dep_salary;
                        }
                    } else {
                        $guard_pay_salary = 0;
                        $days_worked = 0;
                    }

                    if ($c['take_agent'] =="Yes"){
                        $agent_num_month_char = substr($c['agent_mode'],0,1);
                        $agent_num_month = is_numeric($agent_num_month_char)?(int)$agent_num_month_char:-20;
                        if ($company->count_company_guard_payroll_history($c['company_id']) < $agent_num_month){
                            if ($c['agent_mode'] == "1 month pay off"){
                                $agent_fee = $c['agent_fee'];
                            } elseif ($c['agent_mode'] == "2 months pay off"){
                                $agent_fee = $c['agent_fee']/2;
                            } elseif ($c['agent_mode'] == "3 months pay off"){
                                $agent_fee = $c['agent_fee']/3;
                            } elseif ($c['agent_mode'] == "fixed amount monthly"){
                                $agent_fee = $c['agent_fee'];
                            } else {
                                $agent_fee = 0;
                            }
                        }
                    }
//
                    $guard_pay_salary = $guard_pay_salary + $obs_pay;

                    $g_l = $company->get_payroll_guard_loan_data($comp_id,$guard_id);
                    if (!empty($g_l)) {
                        $offense_days_amt = ($offense_days / $days_in_inv_month) * $guard_pay_salary;
                        $res = $company->count_in_progress_guard_loan($g_l['guard_loan_id'], $guard_id, $comp_id);
                        $repay_id = '0';
                        if ($res['myCount'] >= $g_l['guard_loan_month']) {
                            $monthly_loan_amount = 0;
                        } else {
                            $exist_this_month_deduct = $company->test_if_guard_loan_is_settled_this_month($g_l['guard_loan_id'], $guard_id, $comp_id, $gpr_created_on, $gpr_created_on);
                            if ($exist_this_month_deduct['myCount'] > 0) {
                                $monthly_loan_amount = 0;
                                $repay_id = '0';
                            } else {
                                $loan_balance = $g_l['guard_loan_curr_balance'] - $g_l['guard_loan_monthly_amount'];
                                $month_left = $g_l['guard_loan_month'] - 1;
                                $monthly_loan_amount = $g_l['guard_loan_monthly_amount'];
                                $paid_month = date("F", strtotime($gpr_created_on));
                                $paid_year = date("Y", strtotime($gpr_created_on));
                                $repay_id = $company->create_guard_repayment_deduct($g_l['guard_loan_id'], $comp_id, $guard_id, $loan_balance, $month_left, $paid_month, $paid_year, $gpr_created_on);
                                $company->update_guard_curr_loan_balance($g_l['guard_loan_id'], $comp_id, $guard_id, $loan_balance);
                            }
                        }
                    } else {
                        $monthly_loan_amount = 0;
                        $offense_days_amt = 0;
                        $repay_id = '0';
                    }

                   $payroll_cred_data = 0;
                    $payroll_deb_data = 0;
                    $spd = $company->get_guard_payroll_data_settings($c['company_id']);
                    if ($spd->num_rows > 0) {
                        while ($spd_s = $spd->fetch_assoc()) {
                            if ($spd_s['payroll_type']=="Credit"){
                                if ($spd_s['payment_mode'] == "Monthly"){
                                    $payroll_cred_data = $payroll_cred_data + $spd_s['payroll_amount'];
                                } elseif($spd_s['payment_mode'] == "One Time") {
                                    if ($spd_s['mon_month']==$gpr_month && $spd_s['mon_year']==$gpr_year){
                                        $payroll_cred_data = $payroll_cred_data + $spd_s['payroll_amount'];
                                    } else {
                                        $payroll_cred_data = $payroll_cred_data + 0;
                                    }
                                }
                            } else if ($spd_s['payroll_type']=="Debit"){
                                if ($spd_s['payment_mode'] == "Monthly"){
                                    $payroll_deb_data = $payroll_deb_data + $spd_s['payroll_amount'];
                                } elseif($spd_s['payment_mode'] == "One Time") {
                                    if ($spd_s['mon_month']==$gpr_month && $spd_s['mon_year']==$gpr_year){
                                        $payroll_deb_data = $payroll_deb_data + $spd_s['payroll_amount'];
                                    } else {
                                        $payroll_deb_data = $payroll_deb_data + 0;
                                    }
                                }
                            }
                        }
                    }
//
                    $res_sal_adv = $company->sum_up_guard_sal_adv_amt_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                    $monthly_salary_advance = $res_sal_adv['advMonAmt'];

                    $res_ex_duty = $company->sum_up_guard_extra_duty_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                    $monthly_ex_duty = $res_ex_duty['exDutyAmt'];
                    
                    $res_ex_duty2 = $company->sum_up_guard_extra_duty_days_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                    $monthly_ex_days = $res_ex_duty2['exDutyDays'];

                    $res_iss_kit = $company->sum_up_guard_kit_issued_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                    $res_iss_kit_permanent = $company->sum_up_guard_kit_issued_permanent($guard_id,$comp_id);
                    $monthly_iss_kit = $res_iss_kit['kitAmt'] + $res_iss_kit_permanent['kitAmt'];

                    $res_abs_train = $company->sum_up_guard_abs_train_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                    $monthly_abs_train = $res_abs_train['absTrainAmt'];

                    $res_id_charge = $company->sum_up_guard_id_chg_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                    $monthly_id_charge = $res_id_charge['idChgAmt'];

                    $g_payroll_credit_monthly = $guard->guard_payroll_credit_monthly($comp_id,$guard_id);
                    $g_payroll_credit_one_time = $guard->guard_payroll_credit_one_time($comp_id,$guard_id,$gpr_month,$gpr_year);
                    $g_payroll_debit_monthly = $guard->guard_payroll_debit_monthly($comp_id,$guard_id);
                    $g_payroll_debit_one_time = $guard->guard_payroll_debit_one_time($comp_id,$guard_id,$gpr_month,$gpr_year);

                    $tot_g_payroll_credit = $g_payroll_credit_monthly + $g_payroll_credit_one_time;
                    $tot_g_payroll_debit = $g_payroll_debit_monthly + $g_payroll_debit_one_time;
                    $tot_g_payroll = $tot_g_payroll_credit - $tot_g_payroll_debit;

                    $total_deduction = $tot_offense_amt + $monthly_loan_amount + $monthly_salary_advance + $payroll_deb_data + $monthly_iss_kit +
                                        $monthly_abs_train + $monthly_id_charge + $tot_g_payroll_debit;
                    $total_addition = $payroll_cred_data + $monthly_ex_duty + $tot_g_payroll_credit;
                    $net_pay = (int)$w_amt_b4_deactivate + $guard_pay_salary + $total_addition - $total_deduction;
                    
                    $g_proll_details = $company->get_guard_by_id_proll($guard_id, $comp_id);
                    $gdp_de_ac = $company->get_guard_deactivate_history_limit_1($comp_id,$guard_id,$gpr_month,$gpr_year);
                    $gName = $g_proll_details['guard_firstname']." ".$g_proll_details['guard_middlename']." ".$g_proll_details['guard_lastname'];
                    $gBeatname = $g_proll_details['beat_name'];
                    $gCommDate = !empty($gdp_de_ac['date_of_deploy'])?$gdp_de_ac['date_of_deploy']:$g_proll_details['commencement_date'];
//
                    if(!empty($company->check_if_guard_is_deployed($guard_id,$gpr_month,$gpr_year,$comp_id)) || !empty($company->check_if_guard_as_deactivate_history($guard_id,$gpr_month,$gpr_year,$comp_id))){
                        $company->create_guard_payroll(
                            $gpr_month,$gpr_year,$guard_pay_salary+(int)$w_amt_b4_deactivate,$offense_days_amt,$offense_days,$monthly_loan_amount,$repay_id,
                            $monthly_salary_advance,$guard_id,$gName,$gBeatname,$gCommDate,$comp_id,$tot_offense_amt,$payroll_cred_data,$payroll_deb_data,
                            $agent_fee,$days_worked+(int)$w_day_b4_deactivate,$monthly_ex_days,$monthly_ex_duty,$monthly_iss_kit,$monthly_abs_train,$monthly_id_charge,
                            $tot_g_payroll_credit,$tot_g_payroll_debit,
                            $total_deduction,$net_pay,$gpr_created_on,$gpr_created_on
                        );
                    } else {
                        $company->create_guard_payroll(
                            $gpr_month,$gpr_year,0,0,0,0,0,0,$guard_id,$gName,$gBeatname,$gCommDate,$comp_id,0,0,0,
                            0,0,0,0,0,0,0,0,0,0,0,$gpr_created_on,$gpr_created_on
                        );
                    }

                    $guard_details = [
                        'guard_id' => $guard_id,
                        'guard_fullname' => !empty($g_d['guard_firstname'])?$g_d['guard_firstname']." ".$g_d['guard_lastname']:"",
                        'total_loan' => $monthly_loan_amount,
                        'salary_adv' => $monthly_salary_advance,
                        'booking_days' => $offense_days,
                        'booking_days_amt' => $offense_days_amt,
                        'total_offense' => $tot_offense_amt,
                        'total_deduction' => $total_deduction,
                        'net_pay' => $net_pay
                    ];
                    $data[] = $guard_details;
                }

                if (count($data) > 0) {
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Generate a guard payroll for ".$gpr_month.' - '.$gpr_year,
                        url_path('/company/guard-payroll/'.$gpr_month.'-'.$gpr_year,true,true), $c['staff_photo'],$c['staff_name']
                    );

                    http_response_code(200);
                    echo json_encode(array(
                        "status" => 1,
                        "message" => "Guard Payroll Generated, click `continue` to view print page",
                        "result" => $data,
                        "location" => url_path('/company/guard-payroll/'.$gpr_month.'-'.$gpr_year,true,true)
                    ));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Could not fetch guard details"));
                }
            } else {
                $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                $permission_sno = $privileges->get_generate_payroll_permission_id();
                $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

                if(!in_array($permission_sno['perm_sno'], $array)){
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                } else {
                    foreach ($_POST['guard_check'] AS $key => $id) {
                        $guard_id = $_POST['guard_check'][$key];
                        $offense_ded = $company->sum_up_guard_offense_amt_per_month($guard_id,$gpr_month,$gpr_year,$comp_id);
                        $tot_offense_amt = $offense_ded['Amt'] == null?0:$offense_ded['Amt'];
                        $offense_days = $offense_ded['DaysOf'] == null?0:$offense_ded['DaysOf'];
                        $obs_pay = 0;
                        $agent_fee = 0;

                        $gd_deactivated_per_month = $company->sum_up_guard_deactivated_pay_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                        $w_amt_b4_deactivate = !empty($gd_deactivated_per_month)?$gd_deactivated_per_month['amount_pay']:0;
                        $w_day_b4_deactivate = !empty($gd_deactivated_per_month)?$gd_deactivated_per_month['days_pay']:0;

                        $g_d = $company->get_payroll_guard_data($comp_id,$guard_id);
                        $dop_date = new DateTime($g_d['dop']);
                        $gpr_date = new DateTime($full_date);
                        
                        if (!empty($g_d['dop']) && ($gpr_date >= $dop_date) ) {
                            $deployment_date = !empty($g_d) > 0 ? $g_d['commencement_date'] : "0000-00-00";
                            $dep_month = date("F", strtotime($deployment_date));
                            $dep_year = date("Y", strtotime($deployment_date));

                            $days_worked = cal_days_in_month(CAL_GREGORIAN, date("m", strtotime($gpr_month . "-" . $gpr_year)), $gpr_year);
                            if ($dep_month == $gpr_month && $dep_year == $gpr_year) {
                                $d = new DateTime($deployment_date);
                                $days_worked_N = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y')) + 1 - $d->format('d');
                                $days_in_dep_month = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y'));
                                $days_worked = $days_worked_N;
                                $guard_pay_salary = ($days_worked / $days_in_dep_month) * $g_d['g_dep_salary'];
                                if ($g_d['paid_observation'] == "yes") {
                                    $obs_pay = ($g_d['number_of_days_worked'] / $days_in_dep_month) * $g_d['g_dep_salary'];
                                }
                            } else {
                                $g_dep_salary=isset($g_d['g_dep_salary'])?$g_d['g_dep_salary']:0;
                                $guard_pay_salary = ($days_worked / $days_in_inv_month) * $g_dep_salary;
                            }
                        } else {
                            $guard_pay_salary = 0;
                            $days_worked = 0;
                        }

                        if ($c['take_agent'] =="Yes"){
                            $agent_num_month_char = substr($c['agent_mode'],0,1);
                            $agent_num_month = is_numeric($agent_num_month_char)?(int)$agent_num_month_char:-20;
                            if ($company->count_company_guard_payroll_history($c['company_id']) < $agent_num_month){
                                if ($c['agent_mode'] == "1 month pay off"){
                                    $agent_fee = $c['agent_fee'];
                                } elseif ($c['agent_mode'] == "2 months pay off"){
                                    $agent_fee = $c['agent_fee']/2;
                                } elseif ($c['agent_mode'] == "3 months pay off"){
                                    $agent_fee = $c['agent_fee']/3;
                                } elseif ($c['agent_mode'] == "fixed amount monthly"){
                                    $agent_fee = $c['agent_fee'];
                                } else {
                                    $agent_fee = 0;
                                }
                            }
                        }
//
                        $guard_pay_salary = $guard_pay_salary + $obs_pay;

                        $g_l = $company->get_payroll_guard_loan_data($comp_id,$guard_id);
                        if (!empty($g_l)) {
                            $offense_days_amt = ($offense_days / $days_in_inv_month) * $guard_pay_salary;
                            $res = $company->count_in_progress_guard_loan($g_l['guard_loan_id'], $guard_id, $comp_id);
                            $repay_id = '0';
                            if ($res['myCount'] >= $g_l['guard_loan_month']) {
                                $monthly_loan_amount = 0;
                            } else {
                                $exist_this_month_deduct = $company->test_if_guard_loan_is_settled_this_month($g_l['guard_loan_id'], $guard_id, $comp_id, $gpr_created_on, $gpr_created_on);
                                if ($exist_this_month_deduct['myCount'] > 0) {
                                    $monthly_loan_amount = 0;
                                    $repay_id = '0';
                                } else {
                                    $loan_balance = $g_l['guard_loan_curr_balance'] - $g_l['guard_loan_monthly_amount'];
                                    $month_left = $g_l['guard_loan_month'] - 1;
                                    $monthly_loan_amount = $g_l['guard_loan_monthly_amount'];
                                    $paid_month = date("F", strtotime($gpr_created_on));
                                    $paid_year = date("Y", strtotime($gpr_created_on));
                                    $repay_id = $company->create_guard_repayment_deduct($g_l['guard_loan_id'], $comp_id, $guard_id, $loan_balance, $month_left, $paid_month, $paid_year, $gpr_created_on);
                                    $company->update_guard_curr_loan_balance($g_l['guard_loan_id'], $comp_id, $guard_id, $loan_balance);
                                }
                            }
                        } else {
                            $monthly_loan_amount = 0;
                            $offense_days_amt = 0;
                            $repay_id = '0';
                        }

                        $payroll_cred_data = 0;
                        $payroll_deb_data = 0;
                        $spd = $company->get_guard_payroll_data_settings($c['company_id']);
                        if ($spd->num_rows > 0) {
                            while ($spd_s = $spd->fetch_assoc()) {
                                if ($spd_s['payroll_type']=="Credit"){
                                    if ($spd_s['payment_mode'] == "Monthly"){
                                        $payroll_cred_data = $payroll_cred_data + $spd_s['payroll_amount'];
                                    } elseif($spd_s['payment_mode'] == "One Time") {
                                        if ($spd_s['mon_month']==$gpr_month && $spd_s['mon_year']==$gpr_year){
                                            $payroll_cred_data = $payroll_cred_data + $spd_s['payroll_amount'];
                                        } else {
                                            $payroll_cred_data = $payroll_cred_data + 0;
                                        }
                                    }
                                } else if ($spd_s['payroll_type']=="Debit"){
                                    if ($spd_s['payment_mode'] == "Monthly"){
                                        $payroll_deb_data = $payroll_deb_data + $spd_s['payroll_amount'];
                                    } elseif($spd_s['payment_mode'] == "One Time") {
                                        if ($spd_s['mon_month']==$gpr_month && $spd_s['mon_year']==$gpr_year){
                                            $payroll_deb_data = $payroll_deb_data + $spd_s['payroll_amount'];
                                        } else {
                                            $payroll_deb_data = $payroll_deb_data + 0;
                                        }
                                    }
                                }
                            }
                        }
//
                        $res_sal_adv = $company->sum_up_guard_sal_adv_amt_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                        $monthly_salary_advance = $res_sal_adv['advMonAmt'];

                        $res_ex_duty = $company->sum_up_guard_extra_duty_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                        $monthly_ex_duty = $res_ex_duty['exDutyAmt'];
                        
                        $res_ex_duty2 = $company->sum_up_guard_extra_duty_days_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                        $monthly_ex_days = $res_ex_duty2['exDutyDays'];

                        $res_iss_kit = $company->sum_up_guard_kit_issued_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                        $res_iss_kit_permanent = $company->sum_up_guard_kit_issued_permanent($guard_id,$comp_id);
                        $monthly_iss_kit = $res_iss_kit['kitAmt'] + $res_iss_kit_permanent['kitAmt'];

                        $res_abs_train = $company->sum_up_guard_abs_train_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                        $monthly_abs_train = $res_abs_train['absTrainAmt'];

                        $res_id_charge = $company->sum_up_guard_id_chg_per_month($guard_id,$comp_id,$gpr_month,$gpr_year);
                        $monthly_id_charge = $res_id_charge['idChgAmt'];

                        $g_payroll_credit_monthly = $guard->guard_payroll_credit_monthly($comp_id,$guard_id);
                        $g_payroll_credit_one_time = $guard->guard_payroll_credit_one_time($comp_id,$guard_id,$gpr_month,$gpr_year);
                        $g_payroll_debit_monthly = $guard->guard_payroll_debit_monthly($comp_id,$guard_id);
                        $g_payroll_debit_one_time = $guard->guard_payroll_debit_one_time($comp_id,$guard_id,$gpr_month,$gpr_year);

                        $tot_g_payroll_credit = $g_payroll_credit_monthly + $g_payroll_credit_one_time;
                        $tot_g_payroll_debit = $g_payroll_debit_monthly + $g_payroll_debit_one_time;
                        $tot_g_payroll = $tot_g_payroll_credit - $tot_g_payroll_debit;

                        $total_deduction = $tot_offense_amt + $monthly_loan_amount + $monthly_salary_advance + $payroll_deb_data + $monthly_iss_kit +
                            $monthly_abs_train + $monthly_id_charge + $tot_g_payroll_debit;
                        $total_addition = $payroll_cred_data + $monthly_ex_duty + $tot_g_payroll_credit;
                        $net_pay = (int)$w_amt_b4_deactivate + $guard_pay_salary + $total_addition - $total_deduction;
                        
                        $g_proll_details = $company->get_guard_by_id_proll($guard_id, $comp_id);
                        $gdp_de_ac = $company->get_guard_deactivate_history_limit_1($comp_id,$guard_id,$gpr_month,$gpr_year);
                        $gName = $g_proll_details['guard_firstname']." ".$g_proll_details['guard_middlename']." ".$g_proll_details['guard_lastname'];
                        $gBeatname = $g_proll_details['beat_name'];
                        $gCommDate = !empty($gdp_de_ac['date_of_deploy'])?$gdp_de_ac['date_of_deploy']:$g_proll_details['commencement_date'];
//
                        if(!empty($company->check_if_guard_is_deployed($guard_id,$gpr_month,$gpr_year,$comp_id)) || !empty($company->check_if_guard_as_deactivate_history($guard_id,$gpr_month,$gpr_year,$comp_id))){
                            $company->create_guard_payroll(
                                $gpr_month,$gpr_year,$guard_pay_salary+(int)$w_amt_b4_deactivate,$offense_days_amt,$offense_days,$monthly_loan_amount,$repay_id,
                                $monthly_salary_advance,$guard_id,$gName,$gBeatname,$gCommDate,$comp_id,$tot_offense_amt,$payroll_cred_data,$payroll_deb_data,
                                $agent_fee,$days_worked+(int)$w_day_b4_deactivate,$monthly_ex_days,$monthly_ex_duty,$monthly_iss_kit,$monthly_abs_train,$monthly_id_charge,
                                $tot_g_payroll_credit,$tot_g_payroll_debit,
                                $total_deduction,$net_pay,$gpr_created_on,$gpr_created_on
                            );
                        } else {
                            $company->create_guard_payroll(
                                $gpr_month,$gpr_year,0,0,0,0,0,0,$guard_id,$gName,$gBeatname,$gCommDate,$comp_id,0,0,0,
                                0,0,0,0,0,0,0,0,0,0,0,$gpr_created_on,$gpr_created_on
                            );
                        }

                        $guard_details = [
                            'guard_id' => $guard_id,
                            'guard_fullname' => !empty($g_d['guard_firstname'])?$g_d['guard_firstname']." ".$g_d['guard_lastname']:"",
                            'total_loan' => $monthly_loan_amount,
                            'salary_adv' => $monthly_salary_advance,
                            'booking_days' => $offense_days,
                            'booking_days_amt' => $offense_days_amt,
                            'total_offense' => $tot_offense_amt,
                            'total_deduction' => $total_deduction,
                            'net_pay' => $net_pay
                        ];
                        $data[] = $guard_details;
                    }

                    if (count($data) > 0) {
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Generate a guard payroll for ".$gpr_month.' - '.$gpr_year,
                            url_path('/company/guard-payroll/'.$gpr_month.'-'.$gpr_year,true,true), $c['staff_photo'],$c['staff_name']
                        );

                        http_response_code(200);
                        echo json_encode(array(
                            "status" => 1,
                            "message" => "Guard Payroll Generated, click `continue` to view print page",
                            "result" => $data,
                            "location" => url_path('/staff/guard-payroll/'.$gpr_month.'-'.$gpr_year,true,true)
                        ));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Could not fetch guard details"));
                    }
                }
            }
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly select at least one guard, to generate payroll"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>