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
    $beat_id = htmlspecialchars(strip_tags($_POST['beat_id']));
    $dc_category = htmlspecialchars(strip_tags($_POST['dc_category']));
    $dc_reason = htmlspecialchars(strip_tags($_POST['dc_reason']));
//    $chr_days = htmlspecialchars(strip_tags(isset($_POST['chr_days'])?$_POST['chr_days']:0));
    $cred_amt = htmlspecialchars(strip_tags($_POST['cred_amt']));
    $deb_amt = htmlspecialchars(strip_tags($_POST['deb_amt']));
    $no_guard = htmlspecialchars(strip_tags($_POST['no_guard']));
    $start = htmlspecialchars(strip_tags($_POST['start']));
    $end = htmlspecialchars(strip_tags($_POST['end']));
    $client_id = htmlspecialchars(strip_tags($_POST['client_id']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $dc_created_on = date("Y-m-d H:i:s");

    $begin = new DateTime($start);
    $end2 = new DateTime($end);
    $interval = DateInterval::createFromDateString('1 month');
    $period = new DatePeriod($begin, $interval, $end2);
    $i = 0;
    foreach ( $period as $dt ){
        if($i==0){
            $month[$dt->format('F')] = cal_days_in_month(CAL_GREGORIAN, $dt->format('m'), $dt->format('Y')) - $dt->format('d');
        } else {
            $month[$dt->format('F')] = cal_days_in_month(CAL_GREGORIAN, $dt->format('m'), $dt->format('Y'));
        }
        $i++;
    }
    $month[$end2->format('F')] = $end2->format('d');
    $err = 0;

    if (!empty($beat_id) &&!empty($dc_category) &&!empty($dc_reason) && !empty($client_id) && !empty($comp_id) && !empty($dc_created_on)) {
        $check_invoice_deb_cre = $company->check_invoice_debit_credit($beat_id,$dc_category,$dc_reason,$client_id,$comp_id);
//        if ($check_invoice_deb_cre['myCount'] > 0) {
//            http_response_code(200);
//            echo json_encode(array("status" => 0, "message" => "Invoice credit/debit already exist"));
//        } else {
    if (isset($_SESSION['COMPANY_LOGIN'])){
        $inc = 0;
        foreach ($month as $key2 => $val) {
//            $beat_det = $company->get_all_client_beats($beat_id,$comp_id,$client_id);
//            $beat_personnel_amount = $beat->get_beat_personnel_details($beat_id, $comp_id);
//            $beat_personnel = $beat->get_beat_personnel($comp_id,$beat_id);

            $crdb_date = date("Y-m-d", strtotime('+'.$inc." month",strtotime($start)));
            $month = date("F",strtotime($crdb_date));
            $month_nu = date("m",strtotime($crdb_date));
            $year = date("Y",strtotime($crdb_date));

//            $calendar_days = cal_days_in_month(CAL_GREGORIAN, $month_nu, $year);
//            $charge_days_amt = ($beat_det['beat_amount_per_guard']/ $calendar_days) * $chr_days;

//            $result = $company->create_invoice_debit_credit($comp_id,$client_id,$beat_id,$dc_category,$chr_days,$charge_days_amt,$deb_amt,$no_guard,$month,$year,$dc_reason,$dc_created_on);
            $result = $company->create_invoice_debit_credit($comp_id,$client_id,$beat_id,$dc_category,$cred_amt,$deb_amt,$no_guard,$month,$year,$dc_reason,$dc_created_on);
            if ($result) $err = 0; else ++$err;
            $inc++;
        }
        if ($err == 0) {
            $client_det = $client->get_client_by_id($client_id,$c['company_id']);
            $client_res = $client_det->fetch_assoc();
            $company->insert_notifications(
                $c['company_id'],"General","1", $c['staff_name']." Create an invoice ".$dc_category." on client: ".$client_res['client_fullname'],
                url_path('/company/edit-client/'.$client_id,true,true), $c['staff_photo'],$c['staff_name']
            );
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => $dc_category." Invoice saved successfully",
                ));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Could not save invoice debit/credit"));
        }
    }else{

            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_update_client_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
             http_response_code(200);
             echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            }else{
                $inc = 0;
                foreach ($month as $key2 => $val) {
        //            $beat_det = $company->get_all_client_beats($beat_id,$comp_id,$client_id);
        //            $beat_personnel_amount = $beat->get_beat_personnel_details($beat_id, $comp_id);
        //            $beat_personnel = $beat->get_beat_personnel($comp_id,$beat_id);
        
                    $crdb_date = date("Y-m-d", strtotime('+'.$inc." month",strtotime($start)));
                    $month = date("F",strtotime($crdb_date));
                    $month_nu = date("m",strtotime($crdb_date));
                    $year = date("Y",strtotime($crdb_date));
        
        //            $calendar_days = cal_days_in_month(CAL_GREGORIAN, $month_nu, $year);
        //            $charge_days_amt = ($beat_det['beat_amount_per_guard']/ $calendar_days) * $chr_days;
        
        //            $result = $company->create_invoice_debit_credit($comp_id,$client_id,$beat_id,$dc_category,$chr_days,$charge_days_amt,$deb_amt,$no_guard,$month,$year,$dc_reason,$dc_created_on);
                    $result = $company->create_invoice_debit_credit($comp_id,$client_id,$beat_id,$dc_category,$cred_amt,$deb_amt,$no_guard,$month,$year,$dc_reason,$dc_created_on);
                    if ($result) $err = 0; else ++$err;
                    $inc++;
                }
                if ($err == 0) {
                    $client_det = $client->get_client_by_id($client_id,$c['company_id']);
                    $client_res = $client_det->fetch_assoc();
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Create an invoice ".$dc_category." on client: ".$client_res['client_fullname'],
                        url_path('/company/edit-client/'.$client_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => $dc_category." Invoice saved successfully",
                        ));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Could not save invoice debit/credit"));
                }
            }
    }
//        }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>