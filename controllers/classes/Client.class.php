<?php ob_start(); session_status()?null:session_start();
// namespace App;
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');
date_default_timezone_set('Africa/Lagos'); // WAT
class Client
{
    public $conn;
    private $tbl_client;

    //constructor
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function register_client(
        $c_id,$client_id, $client_full_name, $client_office_address, $client_office_phone, $client_email,
        $cc_fn_1, $cc_po_1, $cc_ph_1, $cc_ce_1,$cc_fn_2,$cc_po_2,$cc_ph_2,$cc_ce_2,
        $cc_fn_3, $cc_po_3,$cc_ph_3, $cc_ce_3, $client_photo, $client_status, $client_id_card_Type,
        $client_id_card_front, $client_id_card_back,$created_at
    ){
        $temp_query = "INSERT INTO tbl_client SET company_id=?,client_id=?,client_fullname=?,client_office_address=?,client_office_phone=?,
                    client_email=?,client_contact_fullname=?,client_contact_position=?,client_contact_phone=?,client_contact_email=?,
                    client_contact_fullname_2=?,client_contact_position_2=?,client_contact_phone_2=?,client_contact_email_2=?,
                    client_contact_fullname_3=?,client_contact_position_3=?,client_contact_phone_3=?,client_contact_email_3=?,
                    client_photo=?,client_status=?,client_idcard_type=?,client_idcard_front=?,client_idcard_back=?,created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param(
            "ssssssssssssssssssssssss",
            $c_id,$client_id, $client_full_name, $client_office_address, $client_office_phone, $client_email,
            $cc_fn_1, $cc_po_1, $cc_ph_1, $cc_ce_1,$cc_fn_2,$cc_po_2,$cc_ph_2,$cc_ce_2,
            $cc_fn_3, $cc_po_3,$cc_ph_3, $cc_ce_3, $client_photo, $client_status, $client_id_card_Type,
            $client_id_card_front, $client_id_card_back,$created_at);
        if ($temp_obj->execute()) {
            $this->client_status_on_client_create($c_id,$client_id,"Active","Newly created account",$created_at);
            if ($this->create_client_wallet($c_id,$client_id)) {
                $this->create_client_payment_balance($c_id,$client_id);
                return true;
            }
            return false;
        }
        return false;
    }

    public function create_client_wallet($comp_id,$client_id){
        $wallet_id = rand(1000000,9999999);
        $date = date("Y-m-d H:i:s");
        $c_query = "INSERT INTO tbl_client_wallet SET wallet_id=?,company_id=?,client_id=?,wal_created_on=?";
        $c_obj = $this->conn->prepare($c_query);
        $c_obj->bind_param("ssss",$wallet_id,$comp_id,$client_id,$date);
        if ($c_obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_client_payment_balance($comp_id,$client_id){
        $date = date("Y-m-d H:i:s");
        $c_query = "INSERT INTO tbl_client_payment_balance SET company_id=?,client_id=?,c_pay_bal_date=?";
        $c_obj = $this->conn->prepare($c_query);
        $c_obj->bind_param("sss",$comp_id,$client_id,$date);
        if ($c_obj->execute()) {
            return true;
        }
        return false;
    }

    public function check_client_email($client_email,$c_id){
        $check_email_query = "SELECT * FROM tbl_client WHERE client_email=? AND company_id=?";
        $user_obj = $this->conn->prepare($check_email_query);
        $user_obj->bind_param("ss", $client_email,$c_id);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_client_name($client_full_name,$c_id){
        $check_name_query = "SELECT * FROM tbl_client WHERE client_fullname=? AND company_id=?";
        $client_obj = $this->conn->prepare($check_name_query);
        $client_obj->bind_param("ss", $client_full_name,$c_id);
        if ($client_obj->execute()) {
            $data = $client_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_all_active_clients($c_id){
        $client_query = "SELECT * FROM tbl_client WHERE company_id=? AND client_status IN('Active')";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("s",$c_id);
        if ($client_obj->execute()) {
            return $client_obj->get_result();
        }
        return array();
    }

    public function get_inactive_clients($c_id){
        $client_query = "SELECT * FROM tbl_client WHERE company_id=? AND client_status NOT IN('Active')";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("s",$c_id);
        if ($client_obj->execute()) {
            return $client_obj->get_result();
        }
        return array();
    }

    public function get_client_by_id($client_id, $c_id){
        $client_query = "SELECT * FROM tbl_client WHERE client_id=? AND company_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("ss",$client_id, $c_id);
        if ($client_obj->execute()) {
            return $client_obj->get_result();
        }
        return array();
    }

    public function get_client_wallet_balance($client_id, $c_id){
        $client_query = "SELECT * FROM tbl_client_wallet WHERE client_id=? AND company_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("ss",$client_id, $c_id);
        if ($client_obj->execute()) {
            $data = $client_obj->get_result()->fetch_assoc();
            return $data['wallet_balance'];
        }
        return "no_wallet";
    }

    public function get_client_wallet_payment_leftover($client_id, $c_id){
        $client_query = "SELECT * FROM tbl_client_payment_balance WHERE client_id=? AND company_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("ss",$client_id, $c_id);
        if ($client_obj->execute()) {
            $data = $client_obj->get_result()->fetch_assoc();
            return $data['pay_leftover'];
        }
        return "no_wallet";
    }

    public function update_client_wallet_balance($amt,$client_id, $c_id){
        $client_query = "UPDATE tbl_client_wallet SET wallet_balance=? WHERE client_id=? AND company_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("dss",$amt,$client_id, $c_id);
        if ($client_obj->execute()) {
            if ($client_obj->affected_rows > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function update_client_payment_balance($amt,$client_id, $c_id){
        $client_query = "UPDATE tbl_client_payment_balance SET pay_leftover=? WHERE client_id=? AND company_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("dss",$amt,$client_id, $c_id);
        if ($client_obj->execute()) {
            if ($client_obj->affected_rows > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function update_invoice_status($client_id, $comp_id,$inv_id){
        $client_query = "UPDATE tbl_invoices SET invoice_status='Paid' WHERE client_id=? AND company_id=? AND invoice_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("sss",$client_id,$comp_id,$inv_id);
        if ($client_obj->execute()) {
            if ($client_obj->affected_rows > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function update_client_info($c_id,$id,$edit_client_full_name,$edit_client_office_address,$edit_client_office_phone,$edit_client_email,$updated_at){
        $client_query = "UPDATE tbl_client SET client_fullname=?,client_office_address=?,client_office_phone=?,client_email=?,updated_at=? WHERE id=? AND company_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("sssssis",$edit_client_full_name,$edit_client_office_address,$edit_client_office_phone,$edit_client_email,$updated_at, $id, $c_id);
        if ($client_obj->execute()) {
            if ($client_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_client_contact_info(
        $c_id,$id,$cc_fn_1, $cc_po_1, $cc_ph_1, $cc_ce_1,$cc_fn_2,$cc_po_2,$cc_ph_2,$cc_ce_2, $cc_fn_3, $cc_po_3,$cc_ph_3, $cc_ce_3, $updated_at
    ){
        $client_query = "UPDATE tbl_client SET client_contact_fullname=?,client_contact_position=?,client_contact_phone=?,client_contact_email=?,
                    client_contact_fullname_2=?,client_contact_position_2=?,client_contact_phone_2=?,client_contact_email_2=?,
                    client_contact_fullname_3=?,client_contact_position_3=?,client_contact_phone_3=?,client_contact_email_3=?, 
                    updated_at=? WHERE id=? AND company_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param(
            "sssssssssssssis",
            $cc_fn_1, $cc_po_1, $cc_ph_1, $cc_ce_1,$cc_fn_2,$cc_po_2,$cc_ph_2,$cc_ce_2,$cc_fn_3, $cc_po_3,$cc_ph_3, $cc_ce_3,
            $updated_at, $id, $c_id);
        if ($client_obj->execute()) {
            if ($client_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_client_official_info($c_id, $id, $photo, $idcard_type, $idcard_front, $idcard_back,$updated_at){
        $stf_query = "UPDATE tbl_client SET client_photo=?,client_idcard_type=?,client_idcard_front=?, client_idcard_back=?, updated_at=? WHERE id=? AND company_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("sssssis",$photo, $idcard_type, $idcard_front, $idcard_back,$updated_at, $id, $c_id);
        if ($stf_obj->execute()) {
            if ($stf_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function check_client_email_for_update($client_email, $c_id, $id){
        $check_email_query = "SELECT * FROM tbl_client WHERE client_email=? AND company_id=? AND id NOT IN('$id')";
        $user_obj = $this->conn->prepare($check_email_query);
        $user_obj->bind_param("ss", $client_email,$c_id);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_client_name_for_update($client_full_name, $c_id, $id){
        $check_name_query = "SELECT * FROM tbl_client WHERE client_fullname=? AND company_id=? AND id NOT IN('$id')";
        $client_obj = $this->conn->prepare($check_name_query);
        $client_obj->bind_param("ss", $client_full_name,$c_id);
        if ($client_obj->execute()) {
            $data = $client_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    //not functioning at the moment
    public function update_client_status($status,$id){
        $client_query = "UPDATE tbl_client SET client_status='$status' WHERE id=$id";
        $client_obj = $this->conn->prepare($client_query);
        if ($client_obj->execute()){
            if ($client_obj->affected_rows > 0){
                //update beats status under this client
                $get_client_id_query = "SELECT client_id FROM tbl_client WHERE id=$id";
                $client_id_obj = $this->conn->prepare($get_client_id_query);
                $client_id_obj->execute();
                $client_id_obj->Store_result();
                $client_id_obj->bind_result($client_id);
                $client_id_obj->fetch();

                $beat_status_update_query = "UPDATE tbl_beats SET beat_status='$status' WHERE client_id=$client_id";
                $beat_obj = $this->conn->prepare($beat_status_update_query);
                $beat_obj->execute();
                return true;
            }
            return false;
        }
        return false;
    }

    //not functioning at the moment
    public function client_status($c_id,$client_id, $clientStatus, $clientStatusRemark, $created_at){
        $temp_query = "INSERT INTO tbl_client_status SET company_id=?,client_id=?,client_status=?,remark=?,sta_created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssss", $c_id,$client_id, $clientStatus, $clientStatusRemark, $created_at);
        if ($temp_obj->execute()) {
            $client_status_query = "UPDATE tbl_client SET client_status='$clientStatus' WHERE client_id=$client_id";
            $client_status_obj = $this->conn->prepare($client_status_query);
            $client_status_obj->execute();
            $beat_status_update_query = "UPDATE tbl_beats SET beat_status='$clientStatus' WHERE client_id=$client_id";
            $beat_obj = $this->conn->prepare($beat_status_update_query);
            $beat_obj->execute();
//            ############### For beat status table once disabled from client page ##########
            $get_client_id_query = "SELECT * FROM tbl_beats WHERE client_id='$client_id'";
            $client_id_obj = $this->conn->prepare($get_client_id_query);
            $client_id_obj->execute();
            $c_data = $client_id_obj->get_result();
            while ($row = $c_data->fetch_assoc()){
                $temp_query = "INSERT INTO tbl_beat_status SET company_id=?,beat_id=?,beat_status=?,bt_remark=?,bt_st_created_at=?";
                $temp_obj = $this->conn->prepare($temp_query);
                $temp_obj->bind_param("sssss", $row['company_id'],$row['beat_id'],$clientStatus,$clientStatusRemark,$created_at);
                $temp_obj->execute();
            }
            return true;
        }
        return false;
    }

    public function client_status_on_client_create($c_id,$client_id, $clientStatus, $clientStatusRemark, $created_at){
        $temp_query = "INSERT INTO tbl_client_status SET company_id=?,client_id=?,client_status=?,remark=?,sta_created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssss", $c_id,$client_id, $clientStatus, $clientStatusRemark, $created_at);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function delete_client($id) {
        $client_query = "DELETE FROM tbl_client WHERE id=$id";
        $client_obj = $this->conn->prepare($client_query);
        if ($client_obj->execute()){
            if ($client_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function check_client_details($id, $c_id) {
        $query = "SELECT * FROM tbl_client WHERE id=? AND company_id=?";
        $client_obj = $this->conn->prepare($query);
        $client_obj->bind_param("ss",$id, $c_id);
        if ($client_obj->execute()){
            return $client_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function check_client_beats($c_id,$client_id) {
        $query = "SELECT * FROM tbl_beats WHERE company_id=? AND client_id=? AND beat_status='Active'";
        $client_obj = $this->conn->prepare($query);
        $client_obj->bind_param("ss",$c_id, $client_id);
        if ($client_obj->execute()){
            return $client_obj->get_result();
        }
        return array();
    }

    public function get_staff_type($c_id){
        $staff_type_query = "SELECT * FROM tbl_staff WHERE company_id=?";
        $staff_type_obj = $this->conn->prepare($staff_type_query);
        $staff_type_obj->bind_param("s",$c_id);
        if ($staff_type_obj->execute()){
            return $staff_type_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function client_confirm_pay(
        $c_id,$receipt_id,$client_id,$con_client_pay_amt, $con_client_pay_method,
        $cheque_no,$bank_name,$receive_name, $receive_name_2,
        $con_client_pay_date,$con_client_pay_remark,$created_at
    ){
        $temp_query = "INSERT INTO tbl_client_confirm_payment SET receipt_id=?,company_id=?,client_id=?,amount=?,payment_method=?,
                        cheque_no=?,bank_name=?,ch_receive_name=?,ca_receive_name=?,date=?,remark=?,created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param(
            "ssssssssssss",
            $receipt_id,$c_id,$client_id,$con_client_pay_amt, $con_client_pay_method,$cheque_no,$bank_name,
            $receive_name, $receive_name_2, $con_client_pay_date,$con_client_pay_remark,$created_at
        );
        if ($temp_obj->execute()) {
            $curr_bal = $this->get_client_wallet_balance($client_id,$c_id);
            $new_bal = $curr_bal + $con_client_pay_amt;
            $this->insert_credit_client_ledger($client_id,$c_id,$con_client_pay_method,$con_client_pay_amt,NULL,
                $con_client_pay_amt,$new_bal,NULL,$receipt_id,"Credit",$con_client_pay_remark);
            if ($this->update_client_wallet_balance($new_bal,$client_id,$c_id)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function insert_credit_client_ledger($client_id,$comp_id,$pay_met,$amount,$debit,$cred,$bal,$invoice_id,$receipt_id,$trans_type,$comment){
        $created_on = date("Y-m-d H:i:s");
        $c_query = "INSERT INTO tbl_client_ledger SET client_id=?,company_id=?,payment_method=?,debit=?,credit=?,amount=?,balance=?,
                    invoice_id=?,receipt_id=?,trans_type=?,comment=?,created_on=?";
        $c_obj = $this->conn->prepare($c_query);
        $c_obj->bind_param("sssddddsssss",$client_id,$comp_id,$pay_met,$debit,$cred,$amount,$bal,$invoice_id,
            $receipt_id,$trans_type,$comment,$created_on);
        if ($c_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_client_ledger_history($client_id,$comp_id){
        $c_type_query = "SELECT * FROM tbl_client_ledger WHERE client_id=? AND company_id=? ORDER BY ledger_id DESC";
        $c_type_obj = $this->conn->prepare($c_type_query);
        $c_type_obj->bind_param("ss",$client_id,$comp_id);
        if ($c_type_obj->execute()){
            return $c_type_obj->get_result();
        }
        return array();
    }

    public function get_client_ledger($client_id,$comp_id){
        $c_type_query = "SELECT l.*,v.* FROM tbl_client_ledger l INNER JOIN tbl_invoices v ON v.invoice_id=l.invoice_id 
                        WHERE l.client_id=? AND l.company_id=? AND v.invoice_status='Pending'";
        $c_type_obj = $this->conn->prepare($c_type_query);
        $c_type_obj->bind_param("ss",$client_id,$comp_id);
        if ($c_type_obj->execute()){
            return $c_type_obj->get_result();
        }
        return array();
    }

    public function get_current_client_status($comp_id,$client_id){
        $cs_query = "SELECT st.*,c.* FROM tbl_client_status st 
                    INNER JOIN tbl_client c ON c.client_id=st.client_id WHERE st.company_id=? AND st.client_id=? 
                    ORDER BY st.id DESC LIMIT 1";
        $cs_obj = $this->conn->prepare($cs_query);
        $cs_obj->bind_param("ss",$comp_id,$client_id);
        if ($cs_obj->execute()){
            return $cs_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_current_beat_status($comp_id,$beat_id){
        $cs_query = "SELECT b_st.*,b.* FROM tbl_beat_status b_st 
                    INNER JOIN tbl_beats b ON b.beat_id=b_st.beat_id WHERE b_st.company_id=? AND b_st.beat_id=? 
                    ORDER BY b_st.bt_id DESC LIMIT 1";
        $cs_obj = $this->conn->prepare($cs_query);
        $cs_obj->bind_param("ss",$comp_id,$beat_id);
        if ($cs_obj->execute()){
            return $cs_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function check_if_invoice_exist($month,$year,$comp_id,$client_id){
        $c_query = "SELECT count(*) AS myCount FROM tbl_invoices WHERE invoice_month=? AND invoice_year=? AND company_id=? AND client_id=?";
        $c_obj = $this->conn->prepare($c_query);
        $c_obj->bind_param("ssss",$month,$year,$comp_id,$client_id);
        if ($c_obj->execute()){
            $data = $c_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }
    
    public function check_if_invoice_exist_for_beat($month,$year,$comp_id,$client_id,$beat_id){
        $beat_id_arr = array();
        $c_query = "SELECT i.*,ih.* FROM tbl_invoices i INNER JOIN tbl_invoice_history ih ON ih.invoice_id=i.invoice_id 
                    WHERE i.invoice_month=? AND i.invoice_year=? AND i.company_id=? AND i.client_id=?";
        $c_obj = $this->conn->prepare($c_query);
        $c_obj->bind_param("ssss",$month,$year,$comp_id,$client_id);
        if ($c_obj->execute()){
            $data = $c_obj->get_result();
            while($row = $data->fetch_assoc()) {
              $beat_id_arr[] = $row['beat_id'];
            }
            return $beat_id_arr;
        }
        return array();
    }
    
    public function check_if_payment_amount_exist($date,$comp_id,$client_id){
        $c_query = "SELECT count(*) AS myCount FROM tbl_client_confirm_payment WHERE date=? AND company_id=? AND client_id=?";
        $c_obj = $this->conn->prepare($c_query);
        $c_obj->bind_param("sss",$date,$comp_id,$client_id);
        if ($c_obj->execute()){
            $data = $c_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }
    
    public function get_all_client_login_profile($c_id){
        $beat_query = "SELECT * FROM tbl_client_login clp INNER JOIN tbl_client cl ON cl.client_id=clp.clp_client_id WHERE clp.clp_company_id=?";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("s",$c_id);
        if ($beat_obj->execute()) {
            return $beat_obj->get_result();
        }
        return array();
    }

    public function get_all_client_profile($c_id){
        $beat_query = "SELECT * FROM tbl_client WHERE company_id=? ORDER BY client_fullname ASC";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("s",$c_id);
        if ($beat_obj->execute()) {
            return $beat_obj->get_result();
        }
        return array();
    }

    public function create_client_login($client_id,$comp_id,$password,$created_on){
        $pass = password_hash($password, PASSWORD_DEFAULT);

        $cl_query = "INSERT INTO tbl_client_login SET clp_client_id=?,clp_company_id=?,clp_password=?,clp_created_on=?";
        $cl_obj = $this->conn->prepare($cl_query);
        $cl_obj->bind_param("ssss",$client_id,$comp_id,$pass,$created_on);
        if ($cl_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_client_login_by_id($client_id,$comp_id){
        $clp_query = "SELECT * FROM tbl_client_login clp INNER JOIN tbl_client cl ON cl.client_id=clp.clp_client_id 
                        WHERE clp.clp_company_id=? AND clp.clp_client_id=?";
        $clp_obj = $this->conn->prepare($clp_query);
        $clp_obj->bind_param("ss",$comp_id,$client_id);
        if ($clp_obj->execute()) {
            return $clp_obj->get_result();
        }
        return array();
    }

    public function update_client_login_password($password, $client_id){
        $pass = password_hash($password, PASSWORD_DEFAULT);

        $client_query = "UPDATE tbl_client_login SET clp_password='$pass' WHERE clp_client_id='$client_id'";
        $client_obj = $this->conn->prepare($client_query);
        if ($client_obj->execute()) {
            if ($client_obj->affected_rows > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function delete_client_login_profile($client_id) {
        $clp_query = "DELETE FROM tbl_client_login WHERE clp_client_id='$client_id'";
        $clp_obj = $this->conn->prepare($clp_query);
        if ($clp_obj->execute()){
            if ($clp_obj->affected_rows > 0){
                return true;
            }
            return false;
        }
        return false;
    }
    
    public function get_client_beats_by_id($cli_id){
        $com_query = "SELECT * FROM tbl_beats WHERE client_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("i",$cli_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function login_client($c_email) {
        $sup_query = "SELECT * FROM tbl_client_login cl INNER JOIN tbl_client c ON c.client_id=cl.clp_client_id WHERE c.client_email=?";
        $sup_obj = $this->conn->prepare($sup_query);
        $sup_obj->bind_param("s",$c_email);
        if ($sup_obj->execute()){
            return $sup_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function count_client_total_guard($comp_id, $beat_str){
        $array=array_map('intval', explode(',', $beat_str));
        $array = implode("','",$array);
        $com_query = "SELECT count(*) AS myCount FROM tbl_guard_deployments WHERE company_id=? AND beat_id IN ('".$array."')";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_client_total_clock_in_today($c_id, $beat_str){
        $array=array_map('intval', explode(',', $beat_str));
        $array = implode("','",$array);
        $com_query = "SELECT COUNT(DISTINCT guard_id) AS myCount FROM tbl_send_attendance WHERE company_id=? AND beat_id IN ('".$array."') AND 
                            date_format(created_at, '%Y-%m-%d') = CURDATE()";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$c_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_client_total_clock_in_this_month($c_id, $beat_str){
        $array=array_map('intval', explode(',', $beat_str));
        $array = implode("','",$array);
        $com_query = "SELECT COUNT(DISTINCT guard_id) AS myCount FROM tbl_send_attendance WHERE company_id=? AND beat_id IN ('".$array."') AND 
                            date_format(created_at, '%m') = MONTH(CURDATE()) 
	                        AND date_format(created_at, '%Y') = YEAR(CURDATE())";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$c_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function get_client_guard_routing_report($c_id, $beat_str) {
        $array=array_map('intval', explode(',', $beat_str));
        $array = implode("','",$array);

        $cl_query = "SELECT brt.cr_sno,brt.company_id,brt.guard_id,brt.route_status,brt.start_time,
                        brt.end_time,brt.cp_created_on,rn.route_name,rn.route_id,gd.*,g.*,b.*,cl.* FROM tbl_beat_routing_task brt 
                      INNER JOIN tbl_routes rn ON rn.route_id=brt.route_id
                      INNER JOIN tbl_guard_deployments gd ON gd.guard_id=brt.guard_id
                      INNER JOIN tbl_guards g ON g.guard_id=gd.guard_id
                      INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id
                      INNER JOIN tbl_client cl ON cl.client_id=b.client_id
                       WHERE brt.company_id=? AND gd.beat_id IN ('".$array."') ORDER BY brt.cp_created_on DESC";
        $cl_obj = $this->conn->prepare($cl_query);
        $cl_obj->bind_param("s",$c_id);
        if ($cl_obj->execute()) {
            return $cl_obj->get_result();
        }
        return array();
    }

    public function get_client_company_details($client_id,$c_id){
        $client_query = "SELECT * FROM tbl_company co INNER JOIN tbl_client c ON co.company_id = c.company_id 
                        WHERE c.client_id=? AND c.company_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("ss",$client_id,$c_id);
        if ($client_obj->execute()) {
            return $client_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_client_guard_clock_in_out_report($c_id, $beat_str){
        $array=array_map('intval', explode(',', $beat_str));
        $array = implode("','",$array);
        $cl_query = "SELECT sa.at_id,sa.company_id,sa.guard_id,sa.clock_in_time,sa.clock_out_time,
                        sa.created_at AS clk_date,gd.*,g.*,b.*,cl.* FROM tbl_send_attendance sa 
                      INNER JOIN tbl_guard_deployments gd ON gd.guard_id=sa.guard_id
                      INNER JOIN tbl_guards g ON g.guard_id=gd.guard_id
                      INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id
                      INNER JOIN tbl_client cl ON cl.client_id=b.client_id
                       WHERE sa.company_id=? AND gd.beat_id IN ('".$array."') ORDER BY sa.created_at DESC";
        $cl_obj = $this->conn->prepare($cl_query);
        $cl_obj->bind_param("s",$c_id);
        if ($cl_obj->execute()) {
            return $cl_obj->get_result();
        }
        return array();
    }
    
    public function count_client_total_complete_route_today($c_id, $beat_str){
        $array=array_map('intval', explode(',', $beat_str));
        $array = implode("','",$array);
        $com_query = "SELECT COUNT(*) AS myCount FROM tbl_beat_routing_task WHERE company_id=? AND beat_id IN ('".$array."') AND route_status='Complete' AND 
                            date_format(cp_created_on, '%Y-%m-%d') = CURDATE()";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$c_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }
    
     public function count_client_total_incomplete_route_today($c_id, $beat_str){
        $array=array_map('intval', explode(',', $beat_str));
        $array = implode("','",$array);
        $com_query = "SELECT COUNT(*) AS myCount FROM tbl_beat_routing_task WHERE company_id=? AND beat_id IN ('".$array."') AND route_status='Incomplete' AND 
                            date_format(cp_created_on, '%Y-%m-%d') = CURDATE()";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$c_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

}

$client = new Client();
?>