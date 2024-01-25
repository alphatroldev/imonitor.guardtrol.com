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
} else {
    $c = get_staff();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    $client_id = htmlspecialchars(strip_tags($_POST['client_id']));
    $con_client_pay_amt = htmlspecialchars(strip_tags($_POST['con_client_pay_amt']));
    $con_client_pay_method = htmlspecialchars(strip_tags($_POST['con_client_pay_method']));
    $con_client_pay_date = htmlspecialchars(strip_tags($_POST['con_client_pay_date']));
    $con_client_pay_remark = htmlspecialchars(strip_tags($_POST['con_client_pay_remark']));
    $cheque_no = htmlspecialchars(strip_tags($_POST['cheque_no']));
    $bank_name = htmlspecialchars(strip_tags($_POST['bank_name']));
    $receive_name = htmlspecialchars(strip_tags($_POST['receive_name']));
    $receive_name_2 = htmlspecialchars(strip_tags($_POST['receive_name_2']));
    $c_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $created_at = date("Y-m-d H:i:s");

    $receipt_id = rand(100000000,999999999);

  if (!empty($client_id) &&!empty($con_client_pay_amt)
     &&!empty($con_client_pay_method)&&!empty($con_client_pay_date)&&!empty($con_client_pay_remark) &&!empty($c_id) &&!empty($receipt_id)) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $client_wallet_balance = $client->get_client_wallet_balance($client_id, $c_id);
            $current_balance = $client_wallet_balance + floatval($con_client_pay_amt);

            $prev_leftover = $client->get_client_wallet_payment_leftover($client_id, $c_id);
            $new_payment_total = $prev_leftover + floatval($con_client_pay_amt);

            $result = $client->client_confirm_pay(
                $c_id,$receipt_id,$client_id,$con_client_pay_amt, $con_client_pay_method, $cheque_no,$bank_name,$receive_name,
                $receive_name_2, $con_client_pay_date,$con_client_pay_remark,$created_at
            );
            if ($result) {
                $sum_up_debit_amt =0;
                $led = $client->get_client_ledger($client_id,$c_id);
                if ($led->num_rows > 0) { while ($ledger = $led->fetch_assoc()) {
                    $sum_up_debit_amt = $sum_up_debit_amt + $ledger['debit'];
                    if (($new_payment_total >= $sum_up_debit_amt)){
                        $client->update_invoice_status($client_id,$c_id,$ledger['invoice_id']);
                        $new_leftover = $new_payment_total - $sum_up_debit_amt;
                    } else {
                        $new_leftover = $new_payment_total;
                    }
                    $client->update_client_payment_balance($new_leftover,$client_id,$c_id);
                }}
                $client_det = $client->get_client_by_id($client_id,$c['company_id']);
                $client_res = $client_det->fetch_assoc();
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Confirm client: ".$client_res['client_fullname']." payment",
                    url_path('/company/payment-receipt-preview/'.$receipt_id,true,true), $c['staff_photo'],$c['staff_name']
                );
                http_response_code(200);
                 echo json_encode(array("status" => 1, "message" => "Payment Confirmed"));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Request Failed"));
            }
        } else {
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_update_client_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
             http_response_code(200);
             echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            }else{
                $client_wallet_balance = $client->get_client_wallet_balance($client_id, $c_id);
                $current_balance = $client_wallet_balance + floatval($con_client_pay_amt);

                $prev_leftover = $client->get_client_wallet_payment_leftover($client_id, $c_id);
                $new_payment_total = $prev_leftover + floatval($con_client_pay_amt);

                $result = $client->client_confirm_pay(
                    $c_id,$receipt_id,$client_id,$con_client_pay_amt, $con_client_pay_method, $cheque_no,$bank_name,$receive_name,
                    $receive_name_2, $con_client_pay_date,$con_client_pay_remark,$created_at
                );
                if ($result) {
                    $sum_up_debit_amt =0;
                    $led = $client->get_client_ledger($client_id,$c_id);
                    if ($led->num_rows > 0) { while ($ledger = $led->fetch_assoc()) {
                        $sum_up_debit_amt = $sum_up_debit_amt + $ledger['debit'];
                        if (($new_payment_total >= $sum_up_debit_amt)){
                            $client->update_invoice_status($client_id,$c_id,$ledger['invoice_id']);
                            $new_leftover = $new_payment_total - $sum_up_debit_amt;
                        } else {
                            $new_leftover = $new_payment_total;
                        }
                        $client->update_client_payment_balance($new_leftover,$client_id,$c_id);
                    }}
                    
                    $client_det = $client->get_client_by_id($client_id,$c['company_id']);
                    $client_res = $client_det->fetch_assoc();
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Confirm client: ".$client_res['client_fullname']." payment",
                        url_path('/company/payment-receipt-preview/'.$receipt_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Payment Confirmed"));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Request Failed"));
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