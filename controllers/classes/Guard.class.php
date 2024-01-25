<?php ob_start(); session_status()?null:session_start();
// namespace App;
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');
date_default_timezone_set('Africa/Lagos'); // WAT
class Guard{
    public $conn;
    private $tbl_guards;

    //constructor
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function get_all_company_guards($c_id){
        $role_query = "SELECT * FROM tbl_guards
                        WHERE company_id=? AND guard_status ='Active'";
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("s", $c_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function get_all_company_clients($c_id){
        $role_query = "SELECT * FROM tbl_client
                        WHERE company_id=? AND client_status ='Active'";
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("s", $c_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function get_all_client_beats($client_id){
        $role_query = "SELECT * FROM tbl_beats WHERE client_id=? AND beat_status ='Active'";
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("s", $client_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function get_all_company_shift_arrangement($comp_id){
        $com_query = "SELECT * FROM tbl_company_shifts WHERE company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function get_all_company_guard_position($comp_id){
        $com_query = "SELECT * FROM tbl_guard_positions WHERE company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function get_current_guard_position($guard_position_id){
        $com_query = "SELECT * FROM tbl_guard_positions WHERE pos_sno=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $guard_position_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function get_current_shift($shift_id){
        $com_query = "SELECT * FROM tbl_company_shifts WHERE shift_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $shift_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }
    
    public function check_if_guard_exist($guard_phone, $c_id){
        $gd_query = "SELECT * FROM tbl_guards WHERE phone=? AND company_id=?";
        $gd_obj = $this->conn->prepare($gd_query);
        $gd_obj->bind_param("ss", $guard_phone,$c_id);
        if ($gd_obj->execute()) {
            $data = $gd_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function register_guard(
        $c_id, $client_id, $guard_id, $guard_f_name, $guard_m_name, $guard_l_name, $guard_height,$guard_sex,$guard_phone,$guard_alt_phone,
        $referral,$referral_name,$referral_address,$referral_phone, $referral_fee, $guard_next_of_kin_name, $guard_next_of_kin_phone,
        $guard_next_of_kin_relationship,$vetting,$guard_state_of_origin,$guard_religion,$guard_dob,$guard_nickname,$guard_address,
        $guard_qualification,
        $gi_ti_1,$gi_fn_1,$gi_mn_1,$gi_ln_1,$gi_se_1,$gi_ph_1,$gi_em_1,$gi_yor_1,$gi_pow_1,$gi_ra_1,
        $gi_add_1,$gi_wad_1,$gi_idt_1,
        $gi_ti_2,$gi_fn_2,$gi_mn_2,$gi_ln_2,$gi_se_2,$gi_ph_2,$gi_em_2,$gi_yor_2,$gi_pow_2,$gi_ra_2,
        $gi_add_2,$gi_wad_2,$gi_idt_2,
        $gi_ti_3,$gi_fn_3,$gi_mn_3,$gi_ln_3,$gi_se_3,$gi_ph_3,$gi_em_3,$gi_yor_3,$gi_pow_3,$gi_ra_3,
        $gi_add_3,$gi_wad_3,$gi_idt_3,
        $guard_id_Type,$guard_bank,$guard_acct_number,$guard_acct_name,$guard_blood_group,$guard_remark,$guard_status,$created_at
    ){
        $temp_query = "INSERT INTO tbl_guards SET
                    company_id=?, client_id=?,guard_id=?,guard_firstname=?,guard_middlename=?,guard_lastname=?,height=?,sex=?,phone=?,phone2=?,
                    referral=?,referral_name=?,referral_phone=?,referral_address=?,referral_fee=?,next_kin_name=?,next_kin_phone=?,
                    next_kin_relationship=?,vetting=?,state_of_origin=?,religion=?,dob=?,nickname=?,guard_address=?,qualification=?,
                    guarantor_title=?,guarantor_fname=?,guarantor_mname=?,guarantor_lname=?,guarantor_sex=?,guarantor_phone=?,
                    guarantor_email=?,guarantor_add=?,guarantor_wk_pl=?,guarantor_rank=?,guarantor_wk_add=?,
                    guarantor_yr_or=?,guarantor_id_type=?,
                    guarantor_title_2=?,guarantor_fname_2=?,guarantor_mname_2=?,guarantor_lname_2=?,guarantor_sex_2=?,guarantor_phone_2=?,
                    guarantor_email_2=?,guarantor_add_2=?,guarantor_wk_pl_2=?,guarantor_rank_2=?,guarantor_wk_add_2=?,
                    guarantor_yr_or_2=?,guarantor_id_type_2=?,
                    guarantor_title_3=?,guarantor_fname_3=?,guarantor_mname_3=?,guarantor_lname_3=?,guarantor_sex_3=?,guarantor_phone_3=?,
                    guarantor_email_3=?,guarantor_add_3=?,guarantor_wk_pl_3=?,guarantor_rank_3=?,guarantor_wk_add_3=?,
                    guarantor_yr_or_3=?,guarantor_id_type_3=?,
                    guard_id_type=?,bank=?,account_name=?,account_number=?,
                    guard_status=?,remark=?,blood_group=?,created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param(
            "ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
            $c_id,$client_id,$guard_id,$guard_f_name,$guard_m_name,$guard_l_name,$guard_height,$guard_sex,$guard_phone,$guard_alt_phone,
            $referral, $referral_name, $referral_phone,$referral_address, $referral_fee,$guard_next_of_kin_name,$guard_next_of_kin_phone,
            $guard_next_of_kin_relationship,$vetting,$guard_state_of_origin,$guard_religion,$guard_dob,$guard_nickname,$guard_address,
            $guard_qualification,
            $gi_ti_1,$gi_fn_1,$gi_mn_1,$gi_ln_1,$gi_se_1,$gi_ph_1,$gi_em_1,$gi_add_1,$gi_pow_1,$gi_ra_1,$gi_wad_1,$gi_yor_1,
            $gi_idt_1,
            $gi_ti_2,$gi_fn_2,$gi_mn_2,$gi_ln_2,$gi_se_2,$gi_ph_2,$gi_em_2,$gi_add_2,$gi_pow_2,$gi_ra_2,$gi_wad_2,$gi_yor_2,
            $gi_idt_2,
            $gi_ti_3,$gi_fn_3,$gi_mn_3,$gi_ln_3,$gi_se_3,$gi_ph_3,$gi_em_3,$gi_add_3,$gi_pow_3,$gi_ra_3,$gi_wad_3,$gi_yor_3,
            $gi_idt_3,
            $guard_id_Type, $guard_bank, $guard_acct_name,$guard_acct_number,
            $guard_status,$guard_remark,$guard_blood_group, $created_at
        );
        if ($temp_obj->execute()) {
            if ($this->guard_status($c_id,$guard_id,"Active","Newly created account","No",$created_at)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function guard_status($c_id,$guard_id, $guardStatus, $statusReason,$payEligible,$created_at){
        $temp_query = "INSERT INTO tbl_guard_status SET company_id=?,guard_id=?,guard_status=?,remark=?,gpay_eligibility=?,created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssssss",
            $c_id,$guard_id, $guardStatus, $statusReason,$payEligible, $created_at);
        if ($temp_obj->execute()) {
            $guard_status_query = "UPDATE tbl_guards SET guard_status='$guardStatus' WHERE guard_id=$guard_id";
            $guard_status_obj = $this->conn->prepare($guard_status_query);
            $guard_status_obj->execute();
            return true;
        }
        return false;
    }

    public function guard_status_no_work_days($c_id,$guard_id,$no_work_days,$payEligible,$created_at){
        $temp_query = "INSERT INTO tbl_guard_status_no_work_days SET company_id=?,guard_id=?,no_work_days=?,gpay_eligible=?,nwd_date=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssiss",
            $c_id,$guard_id, $no_work_days,$payEligible,$created_at);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }
    
    public function guard_deactivate_entry(
        $c_id,$guard_id,$beat_id,$guardStatus,$payEligible,$CurrSalary,$DaysWorked,$NewSalary,$GPay,$statusReason,$comm_date,$created_at
    ){
        $temp_query = "INSERT INTO tbl_deactivated_history 
                        SET deh_company_id=?,deh_guard_id=?,deh_beat_id=?,deh_status=?,gpay_eligibility=?,deh_curr_salary=?,
                        deh_days_work=?,deh_new_salary=?,deh_gpays=?,deh_remark=?,date_of_deploy=?,deactivated_date=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssssdiddsss",
            $c_id,$guard_id,$beat_id,$guardStatus,$payEligible,$CurrSalary,$DaysWorked,$NewSalary,$GPay,$statusReason,
            $comm_date,$created_at
        );
        if ($temp_obj->execute()) {
//            $this->update_guard_status_by_gid("Deactivate",$guard_id);
            return true;
        }
        return false;
    }

    public function update_guard_status_by_gid($status,$guard_id){
        $guard_status_query = "UPDATE tbl_guards SET guard_status='$status' WHERE guard_id='$guard_id'";
        $guard_status_obj = $this->conn->prepare($guard_status_query);
        if ($guard_status_obj->execute()){
            if ($guard_status_obj->affected_rows > 0){return true;}
            return false;
        }
        return false;
    }

    public function delete_guard_deployment_data($guard_id,$comp_id){
        $guard_query = "DELETE FROM tbl_guard_deployments WHERE company_id='$comp_id' AND guard_id='$guard_id'";
        $guard_obj = $this->conn->prepare($guard_query);
        if ($guard_obj->execute()){
            if ($guard_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function get_guard_latest_status($c_id,$guard_id){
        $guard_query = "SELECT * FROM tbl_guard_status WHERE guard_id=? AND company_id=? ORDER BY id DESC LIMIT 1";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ss",$guard_id, $c_id);
        if ($guard_obj->execute()) {
            $data = $guard_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function guard_issue_salary_adv($c_id,$guard_id, $salary_adv_reason, $salary_adv_amount, $created_at){
        $temp_query = "INSERT INTO tbl_guard_salary_advance SET
                    company_id=?,guard_id=?,salary_adv_reason=?,
                    salary_adv_amount=?,created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssss",
            $c_id,$guard_id, $salary_adv_reason, $salary_adv_amount, $created_at);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function issue_guard_loan(
        $loan_id,$comp_id,$guard_id,$loan_r,$loan_amt,$loan_dur,$loan_repay,$l_amt_bal,
        $issue_date,$loan_due_date,$loan_due_month,$loan_due_year,$l_created_on,$l_update_on
    ){
        $temp_query = "INSERT INTO tbl_guard_loan SET
                    guard_loan_id=?,company_id=?,guard_id=?,guard_loan_reason=?,guard_loan_amount=?,
                    guard_loan_month=?, guard_loan_monthly_amount=?,guard_loan_curr_balance=?,guard_loan_date=?,
                    loan_due_date=?,loan_due_month=?,loan_due_year=?,guard_loan_created_at=?,guard_loan_updated_on=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param(
            "ssssdiddssssss",
            $loan_id,$comp_id,$guard_id,$loan_r,$loan_amt,$loan_dur,$loan_repay,$l_amt_bal,
                $issue_date,$loan_due_date,$loan_due_month,$loan_due_year,$l_created_on,$l_update_on
        );
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function guard_loan_repayment($loan_id,$comp_id,$guard_id,$loan_bal,$month_left,$created_on){
        $com_query = "INSERT INTO tbl_guard_loan_repayment SET 
                        guard_loan_id=?,company_id=?,guard_id=?,guard_loan_balance=?,guard_month_left=?,gd_re_created_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssssis",$loan_id,$comp_id,$guard_id,$loan_bal,$month_left,$created_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function book_guard_offense($c_id,$guard_id,$offense_title,$c_mode,$c_days,$c_amt,$guard_off_remark,$created_at){
        $temp_query = "INSERT INTO tbl_guard_offense SET
                    company_id=?,guard_id=?,offense_name=?,offense_charge=?,no_of_days=?,charge_amt=?,offense_reason=?,g_off_created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param(
            "sssssdss", $c_id,$guard_id,$offense_title,$c_mode,$c_days,$c_amt,$guard_off_remark,$created_at
        );
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function guard_extra_duty($c_id,$guard_id,$extra_duty_remark, $extra_duty_beat_id, $extra_duty_guard_replace,$extra_duty_No_Of_Days,$charge_amt,$created_at){
        $temp_query = "INSERT INTO tbl_guard_extra_duty SET
                    company_id=?,guard_id=?,reason_remark=?,beat_id=?, guard_replace=?, no_of_days=?,days_amount=?,created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssssssds",
            $c_id,$guard_id,$extra_duty_remark, $extra_duty_beat_id, $extra_duty_guard_replace,$extra_duty_No_Of_Days,$charge_amt,$created_at);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function guard_absent_training($c_id,$guard_id,$absent_training_remark, $absent_training_No_Of_Days,$charge_amt,$created_at){
        $temp_query = "INSERT INTO tbl_guard_absent_training SET company_id=?,guard_id=?,remark_reason=?,no_of_days=?,charge_amt=?,created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssssds",
            $c_id,$guard_id,$absent_training_remark, $absent_training_No_Of_Days,$charge_amt,$created_at);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function issue_guard_kit($c_id,$guard_id,$guard_kit_type,$listKit,$lanyards, $guard_kit_remark, $guard_kit_amt,$monthly_charge,$no_of_month,$created_at,$updated_at){
        $temp_query = "INSERT INTO tbl_issue_guard_kit SET
                        company_id=?,guard_id=?,kit_type=?,issued_kit=?,lanyard=?,reason_remark=?,amount=?,monthly_charge=?,no_of_month=?,created_at=?,updated_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssssssssiss",
            $c_id,$guard_id,$guard_kit_type,$listKit,$lanyards, $guard_kit_remark, $guard_kit_amt,$monthly_charge,$no_of_month,$created_at,$updated_at);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function update_kit_inventory($kit_name,$comp_id){
        $kit_q = "UPDATE tbl_kits_inventory SET kit_number=(kit_number-1) WHERE company_id='$comp_id' AND kit_name='$kit_name'";
        $kit_obj = $this->conn->prepare($kit_q);
        if ($kit_obj->execute()){
            if ($kit_obj->affected_rows > 0){return true;}
            return false;
        }
        return false;
    }

    public function guard_id_card_charge($c_id,$guard_id,$guard_id_card_remark, $guard_id_card_amt,$created_at){
        $temp_query = "INSERT INTO tbl_guard_id_card_charge SET
                    company_id=?,guard_id=?,
                    reason_remark=?, amount=?,
                    created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssss",
            $c_id,$guard_id,$guard_id_card_remark, $guard_id_card_amt,$created_at);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_all_active_guards($c_id){
        $guard_query = "SELECT c.*,g.*, dg.guard_id AS g_id, b.* FROM tbl_guards g 
        LEFT JOIN tbl_guard_deployments dg ON dg.guard_id = g.guard_id      
          LEFT JOIN tbl_beats b ON dg.beat_id = b.beat_id
          LEFT JOIN tbl_client c ON c.client_id = b.client_id
         WHERE g.company_id=? AND g.guard_status IN('Active')";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("s",$c_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result();
        }
        return array();
    }

    public function get_all_active_beat_guards($c_id,$beat_id){
        $guard_query = "SELECT g.*, dg.guard_id AS g_id, b.*, c.* FROM tbl_guards g 
        LEFT JOIN tbl_guard_deployments dg ON dg.guard_id = g.guard_id      
          LEFT JOIN tbl_beats b ON dg.beat_id = b.beat_id
          LEFT JOIN tbl_client c ON c.client_id = b.client_id
         WHERE g.company_id=? AND dg.beat_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ss",$c_id,$beat_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result();
        }
        return array();
    }

    public function get_active_beats($c_id){
        $beat_query = "SELECT * FROM tbl_beats WHERE company_id=? AND beat_status IN('Active')";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("s",$c_id);
        if ($beat_obj->execute()) {
            return $beat_obj->get_result();
        }
        return array();
    }

    public function get_inactive_guards($c_id){
        $guard_query = "SELECT g.*, dg.guard_id AS g_id, b.*, c.* FROM tbl_guards g 
        LEFT JOIN tbl_guard_deployments dg ON dg.guard_id = g.guard_id      
          LEFT JOIN tbl_beats b ON dg.beat_id = b.beat_id
          LEFT JOIN tbl_client c ON c.client_id = b.client_id
         WHERE g.company_id=? AND g.guard_status IN('Deactivate')";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("s",$c_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result();
        }
        return array();
    }


    public function get_client_name($client_id){
        $client_name_query = "SELECT * FROM tbl_client WHERE client_id=?";
        $client_name_obj = $this->conn->prepare($client_name_query);
        $client_name_obj->bind_param("s",$client_id);
        if ($client_name_obj->execute()) {
            return $client_name_obj->get_result();
        }
        return array();
    }

    public function get_beat_name($beat_id){
        $beat_name_query = "SELECT * FROM tbl_beats WHERE beat_id=?";
        $beat_name_obj = $this->conn->prepare($beat_name_query);
        $beat_name_obj->bind_param("s",$beat_id);
        if ($beat_name_obj->execute()) {
            return $beat_name_obj->get_result();
        }
        return array();
    }

    public function update_guard_status($status,$id){
        $guard_status_query = "UPDATE tbl_guards SET guard_status='$status' WHERE id=$id";
        $guard_status_obj = $this->conn->prepare($guard_status_query);
        if ($guard_status_obj->execute()){
            if ($guard_status_obj->affected_rows > 0){return true;}
            return false;
        }
        return false;
    }

    public function delete_guard($guard_id) {

        $guard_query = "DELETE FROM tbl_guards WHERE guard_id='$guard_id'";
        $guard_obj = $this->conn->prepare($guard_query);
        if ($guard_obj->execute()){
            if ($guard_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }
    
     public function delete_guard_offense($g_offense_id,$guard_id) {
        $guard_query = "DELETE FROM tbl_guard_offense WHERE guard_offense_id=$g_offense_id";
        $guard_obj = $this->conn->prepare($guard_query);
        if ($guard_obj->execute()){
            if ($guard_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function get_guard_by_id($guard_id, $c_id){
        $guard_query = "SELECT g.*,d.guard_id AS g_id,d.g_dep_salary,d.beat_id,d.commencement_date FROM tbl_guards g 
                        LEFT JOIN tbl_guard_deployments d ON d.guard_id=g.guard_id
                        WHERE g.guard_id=? AND g.company_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ss",$guard_id, $c_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result();
        }
        return array();
    }

    public function get_guard_by_id_new($guard_id, $c_id){
        $guard_query = "SELECT g.*,d.guard_id AS g_id,d.g_dep_salary,d.beat_id,d.commencement_date FROM tbl_guards g 
                        LEFT JOIN tbl_guard_deployments d ON d.guard_id=g.guard_id
                        WHERE g.guard_id=? AND g.company_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ss",$guard_id, $c_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function update_guard_section_one(
        $c_id, $id,$guard_fname,$guard_mname,$guard_lname, $guard_height,$guard_sex, $guard_phone,$guard_phone_2, $referral,$referral_name,
        $referral_address, $referral_fee,$referral_phone, $guard_next_of_kin_name,$guard_next_of_kin_phone, $guard_next_of_kin_relationship,
        $vetting,$guard_state_of_origin, $guard_religion,$guard_qualification, $guard_dob,$guard_nickname, $guard_address, $updated_at
    ){
        $guard_query = "UPDATE tbl_guards SET 
        guard_firstname=?,guard_middlename=?,guard_lastname=?,height=?,sex=?,phone=?,phone2=?,referral=?,referral_name=?,
        referral_phone=?,referral_address=?,referral_fee=?,next_kin_name=?,next_kin_phone=?,next_kin_relationship=?,
        vetting=?,state_of_origin=?,religion=?, qualification=?,dob=?,nickname=?,guard_address=?, updated_at=? 
        WHERE id=? AND company_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("sssssssssssssssssssssssis",
            $guard_fname,$guard_mname,$guard_lname, $guard_height,$guard_sex, $guard_phone,$guard_phone_2, $referral,$referral_name,
            $referral_phone, $referral_address, $referral_fee,$guard_next_of_kin_name, $guard_next_of_kin_phone,$guard_next_of_kin_relationship,
            $vetting, $guard_state_of_origin, $guard_religion,$guard_qualification,$guard_dob,$guard_nickname, $guard_address, $updated_at,
            $id, $c_id);
        if ($guard_obj->execute()) {
            if ($guard_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_guard_section_two(
        $c_id,$id,
        $guarantor_title,$guarantor_first_name,$guarantor_middle_name,$guarantor_last_name,$guarantor_sex, $guarantor_phone,
        $guarantor_email,$guarantor_address,$guarantor_years_of_relationship,$guarantor_place_of_work, $guarantor_rank,
        $guarantor_work_address, $guarantor_id_Type,
        $guarantor_title_2,$guarantor_first_name_2,$guarantor_middle_name_2,$guarantor_last_name_2,$guarantor_sex_2, $guarantor_phone_2,
        $guarantor_email_2,$guarantor_address_2,$guarantor_years_of_relationship_2,$guarantor_place_of_work_2, $guarantor_rank_2,
        $guarantor_work_address_2, $guarantor_id_Type_2,
        $guarantor_title_3,$guarantor_first_name_3,$guarantor_middle_name_3,$guarantor_last_name_3,$guarantor_sex_3, $guarantor_phone_3,
        $guarantor_email_3,$guarantor_address_3,$guarantor_years_of_relationship_3,$guarantor_place_of_work_3, $guarantor_rank_3,
        $guarantor_work_address_3, $guarantor_id_Type_3,
        $guarantor_photo_save, $guarantor_idcard_front_save, $guarantor_idcard_back_save,
        $guarantor_photo_save_2, $guarantor_idcard_front_save_2, $guarantor_idcard_back_save_2,
        $guarantor_photo_save_3, $guarantor_idcard_front_save_3, $guarantor_idcard_back_save_3,
        $updated_at
    )
    {
        $guard_query = "UPDATE tbl_guards SET 
        guarantor_title=?,guarantor_fname=?,guarantor_mname=?,guarantor_lname=?,guarantor_sex=?,guarantor_phone=?,guarantor_email=?,
        guarantor_add=?,guarantor_wk_pl=?,guarantor_rank=?,guarantor_wk_add=?,guarantor_yr_or=?,guarantor_id_type=?,guarantor_photo=?,
        guarantor_id_front=?,guarantor_id_back=?,
        guarantor_title_2=?,guarantor_fname_2=?,guarantor_mname_2=?,guarantor_lname_2=?,guarantor_sex_2=?,guarantor_phone_2=?,guarantor_email_2=?,
        guarantor_add_2=?,guarantor_wk_pl_2=?,guarantor_rank_2=?,guarantor_wk_add_2=?,guarantor_yr_or_2=?,guarantor_id_type_2=?,guarantor_photo_2=?,
        guarantor_id_front_2=?,guarantor_id_back_2=?,
        guarantor_title_3=?,guarantor_fname_3=?,guarantor_mname_3=?,guarantor_lname_3=?,guarantor_sex_3=?,guarantor_phone_3=?,guarantor_email_3=?,
        guarantor_add_3=?,guarantor_wk_pl_3=?,guarantor_rank_3=?,guarantor_wk_add_3=?,guarantor_yr_or_3=?,guarantor_id_type_3=?,guarantor_photo_3=?,
        guarantor_id_front_3=?,guarantor_id_back_3=?,updated_at=? 
        WHERE id=? AND company_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param(
            "sssssssssssssssssssssssssssssssssssssssssssssssssis",
            $guarantor_title,$guarantor_first_name,$guarantor_middle_name,$guarantor_last_name,$guarantor_sex, $guarantor_phone,
            $guarantor_email,$guarantor_address,$guarantor_place_of_work,$guarantor_rank,$guarantor_work_address,$guarantor_years_of_relationship,
            $guarantor_id_Type,$guarantor_photo_save, $guarantor_idcard_front_save,$guarantor_idcard_back_save,
            $guarantor_title_2,$guarantor_first_name_2,$guarantor_middle_name_2,$guarantor_last_name_2,$guarantor_sex_2, $guarantor_phone_2,
            $guarantor_email_2,$guarantor_address_2,$guarantor_place_of_work_2,$guarantor_rank_2,$guarantor_work_address_2,$guarantor_years_of_relationship_2,
            $guarantor_id_Type_2,$guarantor_photo_save_2, $guarantor_idcard_front_save_2,$guarantor_idcard_back_save_2,
            $guarantor_title_3,$guarantor_first_name_3,$guarantor_middle_name_3,$guarantor_last_name_3,$guarantor_sex_3, $guarantor_phone_3,
            $guarantor_email_3,$guarantor_address_3,$guarantor_place_of_work_3,$guarantor_rank_3,$guarantor_work_address_3,$guarantor_years_of_relationship_3,
            $guarantor_id_Type_3,$guarantor_photo_save_3, $guarantor_idcard_front_save_3,$guarantor_idcard_back_save_3,
            $updated_at, $id, $c_id);
        if ($guard_obj->execute()) {
            if ($guard_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_guard_section_three(
        $c_id,$id,$client_id,$guard_id_Type,$guard_bank,$guard_acct_number,$guard_acct_name,$beat,$guard_blood_group,$guard_remark,$updated_at
    ){
        $guard_query = "UPDATE tbl_guards SET
                        client_id=?,guard_id_type=?,bank=?,account_number=?,account_name=?,blood_group=?,remark=?,updated_at=? 
                        WHERE id=? AND company_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ssssssssis",
            $client_id, $guard_id_Type,$guard_bank,$guard_acct_number,$guard_acct_name,$guard_blood_group, $guard_remark, $updated_at, $id, $c_id);
        if ($guard_obj->execute()) {
            if ($guard_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function get_guard_details_by_guard_id($guard_id){
        $g_query = "SELECT g.*,b.*,gd.* FROM tbl_guards g 
                    LEFT JOIN tbl_guard_deployments gd ON gd.guard_id=g.guard_id
                    LEFT JOIN tbl_beats b ON b.beat_id=gd.beat_id
                    WHERE g.guard_id=?";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("s",$guard_id);
        if ($g_obj->execute()) {
            $data = $g_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_guard_deploy_details_by_guard_id($guard_id){
        $g_query = "SELECT g.*,b.*,gd.* FROM tbl_guards g 
                    INNER JOIN tbl_guard_deployments gd ON gd.guard_id=g.guard_id
                    INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id
                    WHERE g.guard_id=?";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("s",$guard_id);
        if ($g_obj->execute()) {
            $data = $g_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function insert_guard_log($c_id,$guard_id,$act_type,$action_title,$act_date,$act_msg,$act_rea){
        $temp_query = "INSERT INTO tbl_guard_logs SET company_id=?,guard_id=?,action_type=?,action_title=?,action_date=?,action_message=?,action_reason=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssssss", $c_id,$guard_id,$act_type,$action_title,$act_date,$act_msg,$act_rea);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_guard_logs($guard_id){
        $g_query = "SELECT * FROM tbl_guard_logs WHERE guard_id=?";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("s",$guard_id);
        if ($g_obj->execute()) {
            return $g_obj->get_result();
        }
        return array();
    }

    public function get_all_company_guard_pardon($comp_id){
        $g_query = "SELECT gop.*,gof.*,g.* FROM tbl_guard_offense_pardon gop
                    INNER JOIN tbl_guard_offense gof ON gof.guard_offense_id=gop.g_par_guard_offense_id
                    INNER JOIN tbl_guards g ON g.guard_id=gof.guard_id
                    WHERE gof.company_id=?";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("s",$comp_id);
        if ($g_obj->execute()) {
            return $g_obj->get_result();
        }
        return array();
    }

    public function get_all_company_staff_pardon($comp_id){
        $g_query = "SELECT sop.*,sof.*,s.* FROM tbl_staff_offense_pardon sop
                    INNER JOIN tbl_staff_offense sof ON sof.staff_offense_id=sop.par_staff_offense_id
                    INNER JOIN tbl_staff s ON s.staff_id=sof.staff_id
                    WHERE sof.company_id=?";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("s",$comp_id);
        if ($g_obj->execute()) {
            return $g_obj->get_result();
        }
        return array();
    }

    public function create_guard_redeployment_payment($c_id,$guard_id,$beat_id,$days_worked,$paid_amount,$redeploy_date,$created_at){
        $temp_query = "INSERT INTO tbl_redeployment_payment 
                        SET company_id=?,guard_id=?,beat_id=?,re_days_worked=?,paid_amount=?,redeploy_date=?,red_pay_created_on=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssidss", $c_id,$guard_id,$beat_id,$days_worked,$paid_amount,$redeploy_date,$created_at);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_guard_redeployment_amount($comp_id,$guard_id,$re_date){
        $month = date("m", strtotime($re_date));
        $year = date("Y", strtotime($re_date));
        $re_query = "SELECT SUM(paid_amount) as Amt FROM tbl_redeployment_payment 
            WHERE guard_id=? AND company_id=? AND MONTH(redeploy_date)='$month' AND YEAR(redeploy_date)='$year' ";
        $re_obj = $this->conn->prepare($re_query);
        $re_obj->bind_param("ss",$guard_id,$comp_id);
        if ($re_obj->execute()){
            $data = $re_obj->get_result()->fetch_assoc();
            if ($data['Amt'] != '') return $data['Amt'];
            else return 0;
        }
        return 0;
    }

    public function get_guard_redeployment_days($comp_id,$guard_id,$re_date){
        $month = date("m", strtotime($re_date));
        $year = date("Y", strtotime($re_date));
        $re_query = "SELECT SUM(re_days_worked) as re_days FROM tbl_redeployment_payment 
            WHERE guard_id=? AND company_id=? AND MONTH(redeploy_date)='$month' AND YEAR(redeploy_date)='$year' ";
        $re_obj = $this->conn->prepare($re_query);
        $re_obj->bind_param("ss",$guard_id,$comp_id);
        if ($re_obj->execute()){
            $data = $re_obj->get_result()->fetch_assoc();
            if ($data['re_days'] != '') return $data['re_days'];
            else return 0;
        }
        return 0;
    }
    
    public function get_guard_payroll_debit_credit($guard_id,$comp_id){
        $g_query = "SELECT * FROM tbl_guard_payroll_data WHERE guard_id=? AND company_id=?";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("ss",$guard_id,$comp_id);
        if ($g_obj->execute()) {
            return $g_obj->get_result();
        }
        return array();
    }

    public function create_guard_payroll_data($comp_id,$g_id,$p_tit,$p_typ,$pay_mode,$pay_amt,$month,$year,$pay_rem,$pay_created_on,$issue_date){
        $temp_query = "INSERT INTO tbl_guard_payroll_data SET 
                company_id=?,guard_id=?,gpd_title=?,gpd_type=?,gpd_pmode=?,gpd_amount=?,gpd_mon_month=?,gpd_mon_year=?,gpd_desc=?,gpd_date=?,gpd_issue_date=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssssdsssss", $comp_id,$g_id,$p_tit,$p_typ,$pay_mode,$pay_amt,$month,$year,$pay_rem,$pay_created_on,$issue_date);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function delete_guard_payroll_data($gpd_sno,$comp_id){
        $guard_query = "DELETE FROM tbl_guard_payroll_data WHERE gpd_sno=$gpd_sno";
        $guard_obj = $this->conn->prepare($guard_query);
        if ($guard_obj->execute()){
            if ($guard_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function guard_payroll_credit_one_time($comp_id,$guard_id,$month,$year){
        $com_query = "SELECT SUM(gpd_amount) AS cr_one_time_amt FROM tbl_guard_payroll_data WHERE guard_id=? AND company_id=? AND 
                                                    gpd_type='Credit' AND gpd_mon_month='$month' AND gpd_mon_year='$year' AND gpd_pmode='One Time'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            if( $data['cr_one_time_amt'] > 0){ return  $data['cr_one_time_amt']; }
            else { return 0; }
        }
        return 0;
    }

    public function guard_payroll_credit_monthly($comp_id,$guard_id){
        $com_query = "SELECT SUM(gpd_amount) AS cr_monthly_amt FROM tbl_guard_payroll_data WHERE guard_id=? AND company_id=? AND gpd_type='Credit' AND gpd_pmode='Monthly'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            if( $data['cr_monthly_amt'] > 0){ return  $data['cr_monthly_amt']; }
            else { return 0; }
        }
        return 0;
    }

    public function guard_payroll_debit_one_time($comp_id,$guard_id,$month,$year){
        $com_query = "SELECT SUM(gpd_amount) AS db_one_time_amt FROM tbl_guard_payroll_data WHERE guard_id=? AND company_id=? AND gpd_type='Debit' AND gpd_mon_month='$month' AND gpd_mon_year='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            if( $data['db_one_time_amt'] > 0){ return  $data['db_one_time_amt']; }
            else { return 0; }
        }
        return 0;
    }

    public function guard_payroll_debit_monthly($comp_id,$guard_id){
        $com_query = "SELECT SUM(gpd_amount) AS db_monthly_amt FROM tbl_guard_payroll_data WHERE guard_id=? AND company_id=? AND gpd_type='Debit' AND gpd_pmode='Monthly'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
             $data = $com_obj->get_result()->fetch_assoc();
            if( $data['db_monthly_amt'] > 0){ return  $data['db_monthly_amt']; }
            else { return 0; }
        }
        return ;
    }
    
    public function get_all_guards_payroll_data($comp_id){
        $guard_payroll_query = "SELECT gd.*, gdp.* FROM tbl_guards gd INNER JOIN tbl_guard_payroll_data gdp ON gd.guard_id = gdp.guard_id WHERE gdp.company_id=?";
        $guard_payroll_obj = $this->conn->prepare($guard_payroll_query);
        $guard_payroll_obj->bind_param("s", $comp_id);
        if ($guard_payroll_obj->execute()) {
            return $guard_payroll_obj->get_result();
        }
        return array();
    }

     public function delete_guard_report_payroll_data($payroll_data_sno,$comp_id){
        $gdp_query = "DELETE FROM tbl_guard_payroll_data WHERE gpd_sno=? AND company_id=?";
        $gdp_obj = $this->conn->prepare($gdp_query);
        $gdp_obj->bind_param("is",$payroll_data_sno,$comp_id);
        if ($gdp_obj->execute()) {
            if ($gdp_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }
    
    public function get_guard_uniform_deduct($guard_id,$comp_id){
        $g_query = "SELECT * FROM tbl_issue_guard_kit WHERE guard_id=? AND company_id=?";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("ss",$guard_id,$comp_id);
        if ($g_obj->execute()) {
            return $g_obj->get_result();
        }
        return array();
    }

    public function delete_guard_uniform_ded_data($un_id,$comp_id){
        $guard_query = "DELETE FROM tbl_issue_guard_kit WHERE id=$un_id";
        $guard_obj = $this->conn->prepare($guard_query);
        if ($guard_obj->execute()){
            if ($guard_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

}

$guard = new Guard();
?>