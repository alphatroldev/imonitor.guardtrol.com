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
    $id = htmlspecialchars(strip_tags($_POST['id']));
    $guard_id = htmlspecialchars(strip_tags($_POST['guard_id']));
    $beat_id = htmlspecialchars(strip_tags($_POST['beat']));
    $date_of_deploy = htmlspecialchars(strip_tags($_POST['date_of_deploy']));
    $observe_start = htmlspecialchars(strip_tags($_POST['observe_start']));
    $observe_end = htmlspecialchars(strip_tags($_POST['observe_end']));
    $commence_date = htmlspecialchars(strip_tags($_POST['commence_date']));
    $paid_observe = htmlspecialchars(strip_tags($_POST['paid_observe']));
    $guard_position = htmlspecialchars(strip_tags($_POST['guard_position']));
    $guard_shift = htmlspecialchars(strip_tags($_POST['guard_shift']));
    $guard_salary = htmlspecialchars(strip_tags($_POST['guard_salary']));
    $num_days_worked = htmlspecialchars(strip_tags(isset($_POST['num_days_worked'])?$_POST['num_days_worked']:0));

    $updated_at = date("Y-m-d H:i:s");
    
    if (!empty($id) && !empty($beat_id) && !empty($date_of_deploy) && !empty($observe_start) && !empty($observe_end) && !empty($commence_date)
        && !empty($paid_observe) && !empty($guard_position) && !empty($guard_shift) && !empty($guard_salary)) {
        $guard_active = $deploy_guard->count_guard_deploy_beat_active($beat_id,$c['company_id']);
        $beat_det = $deploy_guard->get_beat_by_id($beat_id,$c['company_id']);
        $beat_personnel = $beat->get_beat_personnel($c['company_id'],$beat_id);
        if ($guard_active <= $beat_personnel) {
            if (isset($_SESSION['COMPANY_LOGIN'])) {
                $ga_det = $guard->get_guard_deploy_details_by_guard_id($guard_id);
                if ($ga_det['beat_id'] != $beat_id) {
                     // get first day in the month
                    $commence_date2 = substr($commence_date, 0, 8);
                    $commence_date2 = $commence_date2.'01';
                    $start_date = new DateTime($commence_date2);
                   
                    $end_date = new DateTime($commence_date);
                    $days_worked = $start_date->diff($end_date)->format("%a");
                    
                    $gpr_year = date("Y", strtotime($commence_date));
                    $gd_no_work_per_month = $company->sum_up_guard_no_work_per_month($guard_id,$c['company_id'],$commence_date,$gpr_year);
                    $no_work = (!empty($gd_no_work_per_month))?$gd_no_work_per_month['no_work_days']:0;
                    
                    $days_worked = $days_worked - $no_work;
                    
                    // print_r(date("F", strtotime($commence_date))); die;
                    if ($end_date >= $start_date) {
                        // $gpr_month = date("F", strtotime($commence_date));
                        // $gpr_year = date("Y", strtotime($commence_date));
                        
                        // $offense_ded = $company->sum_up_guard_offense_amt_per_month($guard_id,$gpr_month,$gpr_year,$c['company_id']);
                        // $tot_offense_amt = $offense_ded['Amt'] == null?0:$offense_ded['Amt'];
                        // $offense_days = $offense_ded['DaysOf'] == null?0:$offense_ded['DaysOf'];
                        // $offense_days_amt = ($offense_days/$days_in_inv_month) * $guard_pay_salary;
                        
                        $days_in_dep_month = cal_days_in_month(CAL_GREGORIAN, $start_date->format('m'), $start_date->format('Y'));
                        $paid_amount = ($days_worked / $days_in_dep_month) * $ga_det['g_dep_salary'];
                        $guard->create_guard_redeployment_payment($c['company_id'], $guard_id, $ga_det['beat_id'], $days_worked, $paid_amount, $commence_date, $updated_at);
                    }
                }
                $result = $deploy_guard->update_guard_deployment($c['company_id'], $id, $beat_id, $date_of_deploy, $observe_start, $observe_end, $commence_date,
                    $paid_observe, $guard_position, $guard_shift, $guard_salary, $num_days_worked, $updated_at);
                if ($result == true) {
                    $g_det = $beat->get_guard_details_by_id($guard_id, $beat_id);
                     $company->insert_notifications(
                        $c['company_id'], "General", "1", $c['staff_name'] . " Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." norminal roll",
                        url_path('/company/edit-norminal-roll/' . $guard_id, true, true), $c['staff_photo'], $c['staff_name']
                    );
                    $beat->insert_beat_log(
                        $beat_id, $c['company_id'], $g_det['client_id'], "Info", "Re-Deployed Guard",
                        $updated_at, $g_det['guard_firstname'] . " " . $g_det['guard_lastname'] . " was re-deployed to " . $g_det['beat_name']. ". Commence: ".$commence_date,
                        NULL
                    );
                    $guard->insert_guard_log(
                        $c['company_id'], $guard_id, "Info", "Re-Deployed Guard",
                        $updated_at, $g_det['guard_firstname'] . " " . $g_det['guard_lastname'] . " was re-deployed to " . $g_det['beat_name']. ". Commence: ".$commence_date,
                        NULL
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Guard Deployment has been successfully updated."));
                } else if ($result == "no_change") {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update, no changes found."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update Guard Deployment."));
                }
            } else {
                $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                $permission_sno = $privileges->get_redeploy_guard_permission_id();
                $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                $array = array_map('intval', explode(',', $staff_perm_ids['perm_sno']));

                if (!in_array($permission_sno['perm_sno'], $array)) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                } else {
                    $ga_det = $guard->get_guard_deploy_details_by_guard_id($guard_id);
                    if ($ga_det['beat_id'] != $beat_id) {
                         // get first day in the month
                        $commence_date2 = substr($commence_date, 0, 8);
                        $commence_date2 = $commence_date2.'01';
                        $start_date = new DateTime($commence_date2);
                   
                        $end_date = new DateTime($commence_date);
                        $days_worked = $start_date->diff($end_date)->format("%a");
                        
                        $days_in_dep_month = cal_days_in_month(CAL_GREGORIAN, $start_date->format('m'), $start_date->format('Y'));
                        $paid_amount = ($days_worked / $days_in_dep_month) * $ga_det['g_dep_salary'];
                        $guard->create_guard_redeployment_payment($c['company_id'], $guard_id, $ga_det['beat_id'], $days_worked, $paid_amount, $commence_date, $updated_at);
                    }
                    $result = $deploy_guard->update_guard_deployment($c['company_id'], $id, $beat_id, $date_of_deploy, $observe_start, $observe_end, $commence_date,
                        $paid_observe, $guard_position, $guard_shift, $guard_salary, $num_days_worked, $updated_at);
                    if ($result == true) {
                        $g_det = $beat->get_guard_details_by_id($guard_id, $beat_id);
                        $company->insert_notifications(
                            $c['company_id'], "General", "1", $c['staff_name'] . " Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." norminal roll",
                            url_path('/company/edit-norminal-roll/' . $guard_id, true, true), $c['staff_photo'], $c['staff_name']
                        );
                        $beat->insert_beat_log(
                            $beat_id, $c['company_id'], $g_det['client_id'], "Info", "Re-Deployed Guard",
                            $updated_at, $g_det['guard_firstname'] . " " . $g_det['guard_lastname'] . " was re-deployed to " . $g_det['beat_name']. ". Commence: ".$commence_date,
                            NULL
                        );
                        $guard->insert_guard_log(
                            $c['company_id'], $guard_id, "Info", "Re-Deployed Guard",
                            $updated_at, $g_det['guard_firstname'] . " " . $g_det['guard_lastname'] . " was re-deployed to " . $g_det['beat_name']. ". Commence: ".$commence_date,
                            NULL
                        );
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Guard Deployment has been successfully updated."));
                    } else if ($result == "no_change") {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Failed to update, no changes found."));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Failed to update Guard Deployment."));
                    }
                }
            }
        } else {
            // $g_det = $beat->get_guard_details_by_deploy_id($id);
            // $beat->insert_beat_log(
            //     $g_det['beat_id'],$c['company_id'],$g_det['client_id'],"Warning", "Back to Pool",
            //     $updated_at,$g_det['guard_firstname']." ".$g_det['guard_lastname']." was return to pool from ".$g_det['beat_name'],NULL
            // );
            // $guard->insert_guard_log(
            //     $c['company_id'],$g_det['guard_id'],"Warning", "Back to Pool",
            //     $updated_at,$g_det['guard_firstname']." ".$g_det['guard_lastname']." was return to pool from ".$g_det['beat_name'],NULL
            // );
            // if ($guard_active > $beat_personnel) {
            //     if ($deploy_guard->delete_nominal_roll($id)) {
                    // if (isset($_SESSION['COMPANY_LOGIN'])) {
                    //     $company->insert_notifications(
                    //         $c['company_id'], "General", "1", $c['staff_name'] . " Return guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." to pool",
                    //         url_path('/company/list-guards', true, true), $c['staff_photo'], $c['staff_name']
                    //     );
                    // } else {
                    //     $company->insert_notifications(
                    //         $c['company_id'], "General", "1", $c['staff_name'] . " Return guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." to pool",
                    //         url_path('/company/list-guards', true, true), $c['staff_photo'], $c['staff_name']
                    //     );
                    // }
                // }
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Beat maximum number of guards exceeded (Norminal Roll updated), contact supervisor"));
            // }
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