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

    if (isset($_POST['beat_check']) && count($_POST['beat_check']) > 0){
        $start = htmlspecialchars(strip_tags($_POST['start']));
        $end = htmlspecialchars(strip_tags($_POST['end']));

        $client_id = htmlspecialchars(strip_tags($_POST['client_id']));
        $invoice_id = rand(1000000,9999999);
        $comp_id = $c['company_id'];

        $dateDiffDays = $company->dateDiffDays($start, $end);
        $dateDiffMonth = $company->dateDiffMonth($start, $end);
        $inv_created_on = date("Y-m-d H:i:s");

        $inv_month = date("F");
        $inv_year = date("Y");

        $data = array();
        $begin = new DateTime( $start );
        $end2 = new DateTime( $end );

        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($begin, $interval, $end2);

        if (isset($_SESSION['COMPANY_LOGIN'])){
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

            if ($begin < $end2) {
                $company->create_beat_invoice($invoice_id,$comp_id,$client_id,$inv_month,$inv_year,$inv_created_on);
                foreach ($_POST['beat_check'] AS $key => $id) {
                    $beat_id = $_POST['beat_check'][$key];

                    $total_amt = 0;
                    $total_credit_amt = 0;
                    $total_debit_amt = 0;
                    $net_cred_total = 0;
                    $net_deb_total = 0;
                    $beat_net_pay_for_range = 0;

                    $beat_det = $company->get_all_client_beats($beat_id,$comp_id,$client_id);
                    $amt_super = $beat_det['beat_amount_per_supervisor'];
                    $amt_guard = $beat_det['beat_amount_per_guard'];
                    $no_of_super = $beat_det['beat_num_supervisor'];
                    $no_of_guard = $beat_det['beat_num_guards'];

                    $inc = 0;
                    foreach ($month as $key2 => $val) {
                        $crdb_date = date("Y-m-d", strtotime('+'.$inc." month",strtotime($start)));
                        $month_nu = date("m",strtotime($crdb_date));
                        $year = date("Y",strtotime($crdb_date));
                        $calendar_days_for_month = cal_days_in_month(CAL_GREGORIAN, $month_nu, $year);
                        $cd_for_month = $company->invoice_credit_amount($crdb_date,$comp_id,$beat_id,$client_id);
                        $db_for_month = $company->invoice_debit_amount($crdb_date,$comp_id,$beat_id,$client_id);
                        if (!empty($cd_for_month)){
                            $total_credit_amt = $cd_for_month['chr_days_amt'];
                            $n=$cd_for_month['num_of_guard'];
                        } else {
                            $total_credit_amt = 0;$n =0;
                        }
                        if (!empty($db_for_month)){
                            $total_debit_amt = $db_for_month['charge_amt'];
                            $n2 = $cd_for_month['num_of_guard'];
                        } else {
                            $total_debit_amt = 0;$n2 =0;
                        }

                        $net_cred_total = $net_cred_total + ($total_credit_amt * $n);
                        $net_deb_total = $net_deb_total + ($total_debit_amt * $n2);
                        $inc++;

                        $total_guard_amt_each_month = ($val/$calendar_days_for_month)*$amt_guard*$no_of_guard;
                        $total_super_amt_each_month = ($val/$calendar_days_for_month)*$amt_super*$no_of_super;

                        $total_paid_in_beat = $total_guard_amt_each_month + $total_super_amt_each_month;

                        $beat_net_pay_for_range = $beat_net_pay_for_range + $total_paid_in_beat;
                    }

                    $credit = $net_cred_total - $net_deb_total;
                    $amount_aft_char = $beat_net_pay_for_range + ($credit);
                    $manned_guard = $no_of_guard+$no_of_super;
                    $desc = "Provision of ". $manned_guard ." Manned security Guard for ".$beat_det['beat_name'].
                        " ".date('jS F Y',strtotime($start))." to ".date('jS F Y',strtotime($end)).
                        ($net_cred_total > 0 ? " + extra ".$n." guard(s)":'').
                        ($net_deb_total > 0 ? " - charges for ".$n." no of guard(s)":'');
                    $super_desc ="Provision of ".$no_of_super ." Manned security Supervisor Guard services for ".$beat_det['beat_name'].
                        " ".date('jS F Y',strtotime($start))." to ".date('jS F Y',strtotime($end)).
                        ($net_cred_total > 0 ? " + extra ".$n2." supervisor(s)":'').
                        ($net_deb_total > 0 ? " - charges for ".$n2." no of supervisor(s)":'');

                    $company->create_beat_invoice_details(
                        $invoice_id,$beat_id,$amt_super,$amt_guard,$no_of_super,$no_of_guard,$start,$end,$beat_net_pay_for_range,
                        $net_cred_total,$net_deb_total,$amount_aft_char,$desc,$super_desc,$inv_month,$inv_year,$inv_created_on
                    );
                    $inv_details = [
                        'invoice_id' => $invoice_id,
                        'beat_id' => $beat_id,
                        'total_due' => $beat_net_pay_for_range,
                        'balance' => $amount_aft_char,
                        'credit_charge' => $net_cred_total,
                        'debit_charge' => $net_deb_total,
                        'start' => $start,
                        'end' => $end,
                        'desc' => $desc,
                        'inv_month' => $inv_month,
                        'inv_year' => $inv_year,
                    ];
                    $data[] = $inv_details;
                }

                if (count($data) > 0) {
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Generate an invoice for $inv_month - $inv_year",
                        url_path('/company/invoice-preview/'.$client_id."/".$invoice_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array(
                        "status" => 1,
                        "message" => "Invoice Generated, click `continue` to view print page",
                        "result" => $data,
                        "location" => url_path('/company/invoice-preview/'.$client_id."/".$invoice_id,true,true)
                    ));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Could not fetch beat info"));
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Incorrect date format, end date cannot be greater than or equal to start date"));
            }
        }else{
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_create_beat_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Not Allowed"));
            }else{
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

                if ($begin < $end2) {
                    $company->create_beat_invoice($invoice_id,$comp_id,$client_id,$inv_month,$inv_year,$inv_created_on);
                    foreach ($_POST['beat_check'] AS $key => $id) {
                        $beat_id = $_POST['beat_check'][$key];

                        $total_amt = 0;
                        $total_credit_amt = 0;
                        $total_debit_amt = 0;
                        $net_cred_total = 0;
                        $net_deb_total = 0;
                        $beat_net_pay_for_range = 0;

                        $beat_det = $company->get_all_client_beats($beat_id,$comp_id,$client_id);
                        $amt_super = $beat_det['beat_amount_per_supervisor'];
                        $amt_guard = $beat_det['beat_amount_per_guard'];
                        $no_of_super = $beat_det['beat_num_supervisor'];
                        $no_of_guard = $beat_det['beat_num_guards'];

                        $inc = 0;
                        foreach ($month as $key2 => $val) {
                            $crdb_date = date("Y-m-d", strtotime('+'.$inc." month",strtotime($start)));
                            $month_nu = date("m",strtotime($crdb_date));
                            $year = date("Y",strtotime($crdb_date));
                            $calendar_days_for_month = cal_days_in_month(CAL_GREGORIAN, $month_nu, $year);
                            $cd_for_month = $company->invoice_credit_amount($crdb_date,$comp_id,$beat_id,$client_id);
                            $db_for_month = $company->invoice_debit_amount($crdb_date,$comp_id,$beat_id,$client_id);
                            if (!empty($cd_for_month)){
                                $total_credit_amt = $cd_for_month['chr_days_amt'];
                                $n=$cd_for_month['num_of_guard'];
                            } else {
                                $total_credit_amt = 0;$n =0;
                            }
                            if (!empty($db_for_month)){
                                $total_debit_amt = $db_for_month['charge_amt'];
                                $n2 = $cd_for_month['num_of_guard'];
                            } else {
                                $total_debit_amt = 0;$n2 =0;
                            }

                            $net_cred_total = $net_cred_total + ($total_credit_amt * $n);
                            $net_deb_total = $net_deb_total + ($total_debit_amt * $n2);
                            $inc++;

                            $total_guard_amt_each_month = ($val/$calendar_days_for_month)*$amt_guard*$no_of_guard;
                            $total_super_amt_each_month = ($val/$calendar_days_for_month)*$amt_super*$no_of_super;

                            $total_paid_in_beat = $total_guard_amt_each_month + $total_super_amt_each_month;

                            $beat_net_pay_for_range = $beat_net_pay_for_range + $total_paid_in_beat;
                        }

                        $credit = $net_cred_total - $net_deb_total;
                        $amount_aft_char = $beat_net_pay_for_range + ($credit);
                        $manned_guard = $no_of_guard+$no_of_super;
                        $desc = "Provision of ". $manned_guard ." Manned security Guard for ".$beat_det['beat_name'].
                            " ".date('jS F Y',strtotime($start))." to ".date('jS F Y',strtotime($end)).
                            ($net_cred_total > 0 ? " + extra ".$n." guard(s)":'').
                            ($net_deb_total > 0 ? " - charges for ".$n." no of guard(s)":'');
                        $super_desc ="Provision of ".$no_of_super ." Manned security Supervisor Guard services for ".$beat_det['beat_name'].
                            " ".date('jS F Y',strtotime($start))." to ".date('jS F Y',strtotime($end)).
                            ($net_cred_total > 0 ? " + extra ".$n2." supervisor(s)":'').
                            ($net_deb_total > 0 ? " - charges for ".$n2." no of supervisor(s)":'');

                        $company->create_beat_invoice_details(
                            $invoice_id,$beat_id,$amt_super,$amt_guard,$no_of_super,$no_of_guard,$start,$end,$beat_net_pay_for_range,
                            $net_cred_total,$net_deb_total,$amount_aft_char,$desc,$super_desc,$inv_month,$inv_year,$inv_created_on
                        );
                        $inv_details = [
                            'invoice_id' => $invoice_id,
                            'beat_id' => $beat_id,
                            'total_due' => $beat_net_pay_for_range,
                            'balance' => $amount_aft_char,
                            'credit_charge' => $net_cred_total,
                            'debit_charge' => $net_deb_total,
                            'start' => $start,
                            'end' => $end,
                            'desc' => $desc,
                            'inv_month' => $inv_month,
                            'inv_year' => $inv_year,
                        ];
                        $data[] = $inv_details;
                    }

                    if (count($data) > 0) {
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Generate an invoice for $inv_month - $inv_year",
                            url_path('/company/invoice-preview/'.$client_id."/".$invoice_id,true,true), $c['staff_photo'],$c['staff_name']
                        );
                        http_response_code(200);
                        echo json_encode(array(
                            "status" => 1,
                            "message" => "Invoice Generated, click `continue` to view print page",
                            "result" => $data,
                            "location" => url_path('/company/invoice-preview/'.$client_id."/".$invoice_id,true,true)
                        ));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Could not fetch beat info"));
                    }
                } else {
                    http_response_code(200);
                    echo json_encode(array("status"=>0,"message"=>"Incorrect date format, end date cannot be greater than or equal to start date"));
                }
            }
        }

    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly select at least one beat, to generate invoice"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>