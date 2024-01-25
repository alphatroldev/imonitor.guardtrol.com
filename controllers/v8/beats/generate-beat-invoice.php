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
        $inv_month = htmlspecialchars(strip_tags($_POST['sel_month']));
        $inv_year = htmlspecialchars(strip_tags($_POST['sel_year']));
        $inv_account = htmlspecialchars(strip_tags($_POST['sel_acct']));

        $client_id = htmlspecialchars(strip_tags($_POST['client_id']));
        
        $add_to_invoice = htmlspecialchars(strip_tags($_POST['add_to_inv']));
        $invoice_id = rand(1000000,9999999);
        $comp_id = $c['company_id'];
        $inv_created_on = date("Y-m-d H:i:s");
        $data = array();
        

        $current_balance = 0;
        $client_wallet_balance = $client->get_client_wallet_balance($client_id, $comp_id);
        $status_det = $client->get_current_client_status($comp_id,$client_id);
        $client_created = $status_det['created_at'];

        $inv_yearmonth = $inv_year.'-'.date("m",strtotime($inv_month));
        $client_yearmonth = date("Y-m",strtotime($client_created));

        if (strtotime($inv_yearmonth) >= strtotime($client_yearmonth)){
            // $payroll_check = $client->check_if_invoice_exist($inv_month,$inv_year,$comp_id,$client_id);
            // if ($payroll_check['myCount'] > 0) {
            //     http_response_code(200);
            //     echo json_encode(array("status" => 0, "message" => "Invoice already exist for ".$inv_month.' - '.$inv_year));
            //     exit();
            // } else {
                if (isset($_SESSION['COMPANY_LOGIN'])) {
                    $total_amt = 0;
                    $manned_guard_total = 0;
                    foreach ($_POST['beat_check'] AS $key => $id) {
                        $beat_id = $_POST['beat_check'][$key];

                        $total_credit_amt = 0;
                        $total_debit_amt = 0;
                        
                        $invoice_check = $client->check_if_invoice_exist_for_beat($inv_month,$inv_year,$comp_id,$client_id,$beat_id);
                        // print_r($invoice_check); die;
                        if (in_array($beat_id, $invoice_check)) {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "One or more Beat Invoice already exist for ".$inv_month.' - '.$inv_year));
                            exit();
                        } else {
                            $bt_status_det = $client->get_current_beat_status($comp_id,$beat_id);
                            $beat_created = $bt_status_det['bt_st_created_at'];
    
                            $beat_terminated = "2050-12-31";
                            if ($bt_status_det['beat_status'] =="Deactivated"){
                                $beat_terminated = $bt_status_det['bt_st_created_at'];
                            } elseif($bt_status_det['beat_status'] =="Active") {
                                $beat_created = $bt_status_det['bt_st_created_at'];
                            }
                            $created_month = date("F",strtotime($beat_created));
                            $created_year = date("Y", strtotime($beat_created));
                            $terminated_month = date("F", strtotime($beat_terminated));
                            $terminated_year = date("Y", strtotime($beat_terminated));
    
                            $beat_det = $company->get_all_client_beats($beat_id, $comp_id, $client_id);
                            $beat_personnel_amount = $beat->get_beat_personnel_details($beat_id, $comp_id);
                            $beat_personnel = $beat->get_beat_personnel($comp_id,$beat_id);
                            
                            if ($created_month == $inv_month && $created_year == $inv_year) {
                                $d = new DateTime($beat_created);
                                $created_days_left = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y')) - $d->format('d');
                                $created_days_left = $created_days_left + 1;
                                $days_in_cre_month = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y'));
                                $amt_personnel = ($created_days_left / $days_in_cre_month) * $beat_personnel_amount;
                            } elseif ($terminated_month == $inv_month && $terminated_year == $inv_year) {
                                $d = new DateTime($beat_terminated);
                                $terminated_days_left = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y')) - $d->format('d');
                                $terminated_days_left = $terminated_days_left + 1;
                                $days_in_ter_month = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y'));
                                $amt_personnel = ($terminated_days_left / $days_in_ter_month) * $beat_personnel_amount;
                            } else {
                                $amt_personnel = $beat_personnel_amount;
                            }
    
                            $no_of_personnel = $beat_personnel;
    
                            $cd_for_month = $company->invoice_credit_amount($comp_id, $beat_id, $client_id, $inv_month, $inv_year);
                            $db_for_month = $company->invoice_debit_amount($comp_id, $beat_id, $client_id, $inv_month, $inv_year);
                            
                            // echo $cd_for_month; die();
                            if (!empty($cd_for_month)) {
                                $total_credit_amt = $cd_for_month['chr_days_amt'];
                                $n = $cd_for_month['num_of_guard'];
                            } else {
                                $total_credit_amt = 0;
                                $n = 0;
                            }
                            if (!empty($db_for_month)) {
                                $total_debit_amt = $db_for_month['charge_amt'];
                                $n2 = $db_for_month['num_of_guard'];
                            } else {
                                $total_debit_amt = 0;
                                $n2 = 0;
                            }
    
                            $net_cred_total = $total_credit_amt * $n;
                            $net_deb_total = $total_debit_amt * $n2;
                            
                            // echo $n; die();
    
                            $total_paid_in_beat = $amt_personnel;
    
                            $amount_aft_char = $total_paid_in_beat + $net_cred_total - $net_deb_total;
                            $manned_guard = $no_of_personnel;
                            $manned_guard_total = $manned_guard_total + $manned_guard;
                            $desc = "Provision of " . $manned_guard . " Manned security personnel for " . $inv_month . ", " . $inv_year;
    
                            if ($beat_det['beat_vat_config'] == "Inclusive"){
                                $beat_VAT = 0.075 * $total_paid_in_beat;
                            } else {
                                $beat_VAT = 0.00;
                            }
                            
                            
                            // echo ($invoice_id .", ".$beat_id.", ".$amt_personnel.", ".$no_of_personnel.", ".$total_paid_in_beat.", ".$net_cred_total.", ".$net_deb_total.", ".$amount_aft_char.", ".$beat_VAT.", ".$desc.", ".$inv_month.", ".$inv_year.", ".$inv_created_on); die;
                            
                            $company->create_beat_invoice_details(
                                $invoice_id, $beat_id, $amt_personnel, $no_of_personnel, $total_paid_in_beat,
                                $net_cred_total, $net_deb_total, $amount_aft_char,$beat_VAT, $desc, $inv_month, $inv_year, $inv_created_on
                            );
                            
    
                            $total_amt = $total_amt + $amount_aft_char;
                            $inv_details = [
                                'invoice_id' => $invoice_id,
                                'beat_id' => $beat_id,
                                'total_due - ' . $beat_det['beat_name'] => $total_paid_in_beat,
                                'balance - ' . $beat_det['beat_name'] => $amount_aft_char,
                                'credit_charge' => $net_cred_total,
                                'debit_charge' => $net_deb_total,
                                'desc' => $desc,
                                'inv_month' => $inv_month,
                                'inv_year' => $inv_year,
                                'wallet_balance' => $current_balance,
                            ];
                            $data[] = $inv_details;
                        }
                    }
    
                        if (count($data) > 0) {
                            $current_balance = $client_wallet_balance - $total_amt;
                            if ($current_balance < 0) {$status = "Pending";}
                            else {$status = "Paid";}
                            $led_desc = "Provision of " . $manned_guard_total . " Manned security personnel for " . $inv_month . ", " . $inv_year;
                            
                            $client->insert_credit_client_ledger($client_id, $comp_id,"Invoice",$total_amt,$total_amt, 0,$current_balance,$invoice_id, NULL, "Debit", $led_desc);
                            
                            $company->create_beat_invoice($invoice_id, $comp_id, $client_id, $inv_month, $inv_year, $total_amt,$inv_account,$add_to_invoice,$status,$inv_created_on);
                            
                            $client->update_client_wallet_balance($current_balance, $client_id, $comp_id);
                            $client_det = $client->get_client_by_id($client_id,$c['company_id']);
                            $client_res = $client_det->fetch_assoc();
                            $company->insert_notifications(
                                $c['company_id'], "General", "1", $c['staff_name'] . " Generate an invoice for $inv_month - $inv_year, client: ".$client_res['client_fullname'],
                                url_path('/company/invoice-preview/' . $client_id . "/" . $invoice_id, true, true), $c['staff_photo'], $c['staff_name']
                            );
                            http_response_code(200);
                            echo json_encode(array(
                                "status" => 1,
                                "message" => "Invoice Generated, click `continue` to view print page",
                                "result" => $data,
                                "location" => url_path('/company/invoice-preview/' . $client_id . "/" . $invoice_id, true, true)
                            ));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Could not fetch beat info"));
                        }
                    
                } else {
                    $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                    $permission_sno = $privileges->get_generate_inv_permission_id();
                    $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                    $array = array_map('intval', explode(',', $staff_perm_ids['perm_sno']));

                    if (!in_array($permission_sno['perm_sno'], $array)) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                    } else {
                        $total_amt = 0;
                        $manned_guard_total = 0;
                        foreach ($_POST['beat_check'] AS $key => $id) {
                            $beat_id = $_POST['beat_check'][$key];
    
                            $total_credit_amt = 0;
                            $total_debit_amt = 0;
                            
                            $invoice_check = $client->check_if_invoice_exist_for_beat($inv_month,$inv_year,$comp_id,$client_id,$beat_id);
                            // print_r($invoice_check); die;
                            if (in_array($beat_id, $invoice_check)) {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "One or more Beat Invoice already exist for ".$inv_month.' - '.$inv_year));
                                exit();
                            } else {
                                $bt_status_det = $client->get_current_beat_status($comp_id,$beat_id);
                                $beat_created = $bt_status_det['bt_st_created_at'];
        
                                $beat_terminated = "2050-12-31";
                                if ($bt_status_det['beat_status'] =="Deactivated"){
                                    $beat_terminated = $bt_status_det['bt_st_created_at'];
                                } elseif($bt_status_det['beat_status'] =="Active") {
                                    $beat_created = $bt_status_det['bt_st_created_at'];
                                }
                                $created_month = date("F",strtotime($beat_created));
                                $created_year = date("Y", strtotime($beat_created));
                                $terminated_month = date("F", strtotime($beat_terminated));
                                $terminated_year = date("Y", strtotime($beat_terminated));
        
                                $beat_det = $company->get_all_client_beats($beat_id, $comp_id, $client_id);
                                $beat_personnel_amount = $beat->get_beat_personnel_details($beat_id, $comp_id);
                                $beat_personnel = $beat->get_beat_personnel($comp_id,$beat_id);
                                
                                if ($created_month == $inv_month && $created_year == $inv_year) {
                                    $d = new DateTime($beat_created);
                                    $created_days_left = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y')) - $d->format('d');
                                    $created_days_left = $created_days_left + 1;
                                    $days_in_cre_month = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y'));
                                    $amt_personnel = ($created_days_left / $days_in_cre_month) * $beat_personnel_amount;
                                } elseif ($terminated_month == $inv_month && $terminated_year == $inv_year) {
                                    $d = new DateTime($beat_terminated);
                                    $terminated_days_left = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y')) - $d->format('d');
                                    $terminated_days_left = $terminated_days_left + 1;
                                    $days_in_ter_month = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y'));
                                    $amt_personnel = ($terminated_days_left / $days_in_ter_month) * $beat_personnel_amount;
                                } else {
                                    $amt_personnel = $beat_personnel_amount;
                                }
        
                                $no_of_personnel = $beat_personnel;
    
                                $cd_for_month = $company->invoice_credit_amount($comp_id, $beat_id, $client_id, $inv_month, $inv_year);
                                $db_for_month = $company->invoice_debit_amount($comp_id, $beat_id, $client_id, $inv_month, $inv_year);
                                
                                // print_r($cd_for_month); die();
                                if (!empty($cd_for_month)) {
                                    $total_credit_amt = $cd_for_month['chr_days_amt'];
                                    $n = $cd_for_month['num_of_guard'];
                                } else {
                                    $total_credit_amt = 0;
                                    $n = 0;
                                }
                                if (!empty($db_for_month)) {
                                    $total_debit_amt = $db_for_month['charge_amt'];
                                    $n2 = $db_for_month['num_of_guard'];
                                } else {
                                    $total_debit_amt = 0;
                                    $n2 = 0;
                                }
        
                                $net_cred_total = $total_credit_amt * $n;
                                $net_deb_total = $total_debit_amt * $n2;
                                
                                $total_paid_in_beat = $amt_personnel;
        
                                $amount_aft_char = $total_paid_in_beat + $net_cred_total - $net_deb_total;
                                $manned_guard = $no_of_personnel;
                                $manned_guard_total = $manned_guard_total + $manned_guard;
                                $desc = "Provision of " . $manned_guard . " Manned security personnel for " . $inv_month . ", " . $inv_year;
        
                                if ($beat_det['beat_vat_config'] == "Inclusive"){
                                    $beat_VAT = 0.075 * $total_paid_in_beat;
                                } else {
                                    $beat_VAT = 0.00;
                                }
                                $company->create_beat_invoice_details(
                                    $invoice_id, $beat_id, $amt_personnel, $no_of_personnel, $total_paid_in_beat,
                                    $net_cred_total, $net_deb_total, $amount_aft_char,$beat_VAT, $desc, $inv_month, $inv_year, $inv_created_on
                                );
        
                                $total_amt = $total_amt + $amount_aft_char;
                                $inv_details = [
                                    'invoice_id' => $invoice_id,
                                    'beat_id' => $beat_id,
                                    'total_due - ' . $beat_det['beat_name'] => $total_paid_in_beat,
                                    'balance - ' . $beat_det['beat_name'] => $amount_aft_char,
                                    'credit_charge' => $net_cred_total,
                                    'debit_charge' => $net_deb_total,
                                    'desc' => $desc,
                                    'inv_month' => $inv_month,
                                    'inv_year' => $inv_year,
                                    'wallet_balance' => $current_balance,
                                ];
                                $data[] = $inv_details;
                            }
                        }
    
                        if (count($data) > 0) {
                            $current_balance = $client_wallet_balance - $total_amt;
                            if ($current_balance < 0) {$status = "Pending";}
                            else {$status = "Paid";}
                            $led_desc = "Provision of " . $manned_guard_total . " Manned security personnel for " . $inv_month . ", " . $inv_year;
                            
                            $client->insert_credit_client_ledger($client_id, $comp_id,"Invoice",$total_amt,$total_amt, 0,$current_balance,$invoice_id, NULL, "Debit", $led_desc);
                            
                            $company->create_beat_invoice($invoice_id, $comp_id, $client_id, $inv_month, $inv_year, $total_amt,$inv_account,$add_to_invoice,$status,$inv_created_on);
                        
                            $client->update_client_wallet_balance($current_balance, $client_id, $comp_id);
                            $client_det = $client->get_client_by_id($client_id,$c['company_id']);
                            $client_res = $client_det->fetch_assoc();
                            $company->insert_notifications(
                                $c['company_id'], "General", "1", $c['staff_name'] . " Generate an invoice for $inv_month - $inv_year, client: ".$client_res['client_fullname'],
                                url_path('/company/invoice-preview/' . $client_id . "/" . $invoice_id, true, true), $c['staff_photo'], $c['staff_name']
                            );
                            http_response_code(200);
                            echo json_encode(array(
                                "status" => 1,
                                "message" => "Invoice Generated, click `continue` to view print page",
                                "result" => $data,
                                "location" => url_path('/staff/invoice-preview/' . $client_id . "/" . $invoice_id, true, true)
                            ));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Could not fetch beat info"));
                        }
                    }
                }
            // }
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Can't generate invoice for this date - client not created"));
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