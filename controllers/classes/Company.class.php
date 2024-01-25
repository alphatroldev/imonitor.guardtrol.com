<?php ob_start(); session_status()?null:session_start();
// namespace App;
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');
date_default_timezone_set('Africa/Lagos'); // WAT
class Company
{
    public $conn;
    private $tbl_company;

    //constructor
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function check_email($email){
        $com_query = "SELECT * FROM tbl_staff WHERE staff_email=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $email);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function create_company_instance_self($c_id,$c_name,$c_email,$c_address,$c_phone,$c_password,$c_logo,$c_reg_no,$c_created_on) {
        $pass = password_hash($c_password, PASSWORD_DEFAULT);
        $status = '0';
        $s_id = rand(1000000, 9999999);
        $role = '0';
        $type = 'Owner';
        $sup_query = "INSERT INTO tbl_company SET company_id=?,company_name=?,company_email=?,company_address=?,company_phone=?,
                        company_logo=?,company_rc_no=?,company_status=?,com_created_at=?";
        $sup_obj = $this->conn->prepare($sup_query);
        $sup_obj->bind_param("sssssssss", $c_id,$c_name,$c_email,$c_address,$c_phone,$c_logo,$c_reg_no,$status,$c_created_on);
        if ($sup_obj->execute()) {
            if ($this->create_staff_self($c_id,$s_id,$c_name,$c_phone,$c_email,$pass,$role,$type,'Deactivate')){
                return true;
            }
            return false;
        }
        return false;
    }

    public function create_test_entry($fname,$lname,$phone,$email){
        $temp_query = "INSERT INTO test_entry SET first_name=?,last_name=?,phone_number=?,email=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssss",$fname,$lname,$phone,$email);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_staff_self($c_id,$staff_id,$staff_firstname,$staff_phone,$staff_email,$staff_password,$staff_role,$staff_type,$staff_acc_status){
        $temp_query = "INSERT INTO tbl_staff SET 
                    company_id=?,staff_id=?,staff_firstname=?,staff_phone=?,staff_email=?,staff_password=?,staff_role=?,staff_type=?,staff_acc_status=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssssssss", $c_id,$staff_id,$staff_firstname,$staff_phone,$staff_email,$staff_password,$staff_role,$staff_type,$staff_acc_status);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_company_config($c_id,$c_un_ch,$c_un_fee,$c_uni_mode,$c_agent,$c_agent_fee,$c_agent_mode,$c_shift_me,$c_act_Date,$loan_type,$c_penalties,$c_created) {
        $com_query_2 = "INSERT INTO tbl_company_config SET con_company_id=?,uniform_charge=?,uniform_fee=?,uniform_mode=?,agent=?,agent_fee=?,agent_mode=?,
                                    shift_method=?,activation_date=?,loan_config_type=?,penalties=?,created_at=?";
        $com_obj_2 = $this->conn->prepare($com_query_2);
        $com_obj_2->bind_param("ssdssdssssss", $c_id,$c_un_ch,$c_un_fee,$c_uni_mode,$c_agent,$c_agent_fee,$c_agent_mode,$c_shift_me,$c_act_Date,$loan_type,$c_penalties,$c_created);
        if ($com_obj_2->execute()) {
            $this->update_company_first_login($c_id);
            return true;
        }
        return false;
    }

    public function update_company_config($c_id,$c_un_ch,$c_un_fee,$c_uni_mode,$c_agent,$c_agent_fee,$c_agent_mode,$c_shift_me,$c_act_Date,$loan_type,$c_penalties) {
        $com_query = "UPDATE tbl_company_config SET uniform_charge=?,uniform_fee=?,uniform_mode=?,agent=?,agent_fee=?,agent_mode=?,shift_method=?,
                                loan_config_type=?,penalties=?,activation_date=? WHERE con_company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sdssdssssss", $c_un_ch,$c_un_fee,$c_uni_mode,$c_agent,$c_agent_fee,$c_agent_mode,$c_shift_me,$loan_type,$c_penalties,$c_act_Date,$c_id);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_company_config_by_c_id($c_id){
        $com_query = "SELECT * FROM tbl_company_config WHERE con_company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$c_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function login_company($c_email) {
        $com_query = "SELECT * FROM tbl_staff s LEFT JOIN tbl_company c ON s.company_id=c.company_id WHERE s.staff_email=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$c_email);
        if ($com_obj->execute()){
            return $com_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_company_by_sno($s_id){
        $com_query = "SELECT c.*,s.*, cs.* FROM tbl_company c INNER JOIN tbl_staff s ON s.company_id=c.company_id
                            LEFT JOIN tbl_company_config cs ON c.company_id = cs.con_company_id WHERE c.company_sno=? AND s.staff_type='Owner'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("i",$s_id);

        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function get_company_by_id($s_id){
        $com_query = "SELECT * FROM tbl_company WHERE company_sno=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("i",$s_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function update_company_personal_profile($c_id,$c_name,$c_email,$c_address,$c_phone, $c_description){
        $com_query = "UPDATE tbl_company SET company_name=?,company_email=?,company_address=?, company_phone=?, company_description=? WHERE company_sno=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sssssi",$c_name,$c_email,$c_address,$c_phone,$c_description,$c_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_com_staff_personal_password($new_pwd,$c_id,$s_id){
        $sup_query = "UPDATE tbl_staff SET staff_password=? WHERE company_id=? AND staff_id=?";
        $sup_obj = $this->conn->prepare($sup_query);
        $sup_obj->bind_param("sss",$new_pwd,$c_id,$s_id);
        if ($sup_obj->execute()) {
            return true;
        }
        return false;
    }

    public function update_company_profile_doc($c_id,$c_op,$c_no_op,$c_rc_no,$c_tax_id,$cac_file,$c_license){
        $sup_query = "UPDATE tbl_company SET company_op_state=?,company_no_op_state=?,company_rc_no=?,company_tax_id_no=?, 
                                company_cac_file=?,company_op_license=? WHERE company_id=?";
        $sup_obj = $this->conn->prepare($sup_query);
        $sup_obj->bind_param("sssssss",$c_op,$c_no_op,$c_rc_no,$c_tax_id,$cac_file,$c_license,$c_id);
        if ($sup_obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_staff(
        $c_id, $staff_id, $staff_firstname, $staff_middlename, $staff_lastname, $staff_sex, $staff_dob, $staff_home_addr, $staff_height,
        $staff_blood_grp, $staff_religion, $staff_marital_stat, $staff_phone, $staff_email, $staff_qualification, $staff_password, $staff_role,
        $gi_ti_1,$gi_fn_1,$gi_mn_1,$gi_ln_1,$gi_se_1,$gi_ph_1,$gi_em_1,$gi_yor_1,$gi_pow_1,$gi_ra_1,
        $gi_add_1,$gi_wad_1,$gi_idt_1,$g_ph_1,$g_id_f_1,$g_id_b_1,
        $gi_ti_2,$gi_fn_2,$gi_mn_2,$gi_ln_2,$gi_se_2,$gi_ph_2,$gi_em_2,$gi_yor_2,$gi_pow_2,$gi_ra_2,
        $gi_add_2,$gi_wad_2,$gi_idt_2,$g_ph_2,$g_id_f_2,$g_id_b_2,
        $gi_ti_3,$gi_fn_3,$gi_mn_3,$gi_ln_3,$gi_se_3,$gi_ph_3,$gi_em_3,$gi_yor_3,$gi_pow_3,$gi_ra_3,
        $gi_add_3,$gi_wad_3,$gi_idt_3,$g_ph_3,$g_id_f_3,$g_id_b_3,
        $next_kin_firstname, $next_kin_middlename,
        $next_kin_lastname, $next_kin_gender,$next_home_addr, $next_kin_phone, $next_kin_relationship, $staff_bank, $staff_account_name,
        $staff_account_number, $staff_salary, $staff_photo, $staff_signature
    ){
        $hash_pwd = password_hash($staff_password, PASSWORD_DEFAULT);
        $temp_query = "INSERT INTO tbl_staff SET 
                    company_id=?,staff_id=?,staff_firstname=?,staff_middlename=?,staff_lastname=?, 
                    staff_sex=?, stf_dob=?, stf_home_addr=?, stf_height=?, stf_blood_grp=?, stf_religion=?, 
                    stf_marital_stat=?, staff_phone=?,staff_email=?,staff_qualification=?,staff_password=?,staff_role=?,
                    staff_guarantor_title=?,staff_guarantor_fname=?,staff_guarantor_mname=?,staff_guarantor_lname=?,staff_guarantor_sex=?,
                    staff_guarantor_phone=?,staff_guarantor_email=?,staff_guarantor_add=?,staff_guarantor_wk_pl=?,staff_guarantor_rank=?,
                    staff_guarantor_wk_add=?,staff_guarantor_yr_or=?,staff_guarantor_id_type=?,staff_guarantor_id_photo=?,
                    staff_guarantor_id_front=?,staff_guarantor_id_back=?,
                    staff_guarantor_title_2=?,staff_guarantor_fname_2=?,staff_guarantor_mname_2=?,staff_guarantor_lname_2=?,staff_guarantor_sex_2=?,
                    staff_guarantor_phone_2=?,staff_guarantor_email_2=?,staff_guarantor_add_2=?,staff_guarantor_wk_pl_2=?,staff_guarantor_rank_2=?,
                    staff_guarantor_wk_add_2=?,staff_guarantor_yr_or_2=?,staff_guarantor_id_type_2=?,staff_guarantor_id_photo_2=?,
                    staff_guarantor_id_front_2=?,staff_guarantor_id_back_2=?,
                    staff_guarantor_title_3=?,staff_guarantor_fname_3=?,staff_guarantor_mname_3=?,staff_guarantor_lname_3=?,staff_guarantor_sex_3=?,
                    staff_guarantor_phone_3=?,staff_guarantor_email_3=?,staff_guarantor_add_3=?,staff_guarantor_wk_pl_3=?,staff_guarantor_rank_3=?,
                    staff_guarantor_wk_add_3=?,staff_guarantor_yr_or_3=?,staff_guarantor_id_type_3=?,staff_guarantor_id_photo_3=?,
                    staff_guarantor_id_front_3=?,staff_guarantor_id_back_3=?,
                    next_kin_firstname=?,next_kin_middlename=?, next_kin_lastname=?,next_kin_gender=?, next_kin_home_addr=?, next_kin_phone=?,
                    next_kin_relationship=?,staff_bank=?,staff_account_name=?,staff_account_number=?,staff_salary=?,staff_photo=?,staff_signature=?
                    ";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param(
            "ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
            $c_id, $staff_id, $staff_firstname, $staff_middlename, $staff_lastname, $staff_sex, $staff_dob, $staff_home_addr,
            $staff_height, $staff_blood_grp, $staff_religion, $staff_marital_stat, $staff_phone, $staff_email, $staff_qualification,
            $hash_pwd, $staff_role,
            $gi_ti_1,$gi_fn_1,$gi_mn_1,$gi_ln_1,$gi_se_1,$gi_ph_1,$gi_em_1,$gi_add_1,$gi_pow_1,$gi_ra_1,$gi_wad_1,$gi_yor_1,
            $gi_idt_1,$g_ph_1,$g_id_f_1,$g_id_b_1,
            $gi_ti_2,$gi_fn_2,$gi_mn_2,$gi_ln_2,$gi_se_2,$gi_ph_2,$gi_em_2,$gi_add_2,$gi_pow_2,$gi_ra_2,$gi_wad_2,$gi_yor_2,
            $gi_idt_2,$g_ph_2,$g_id_f_2,$g_id_b_2,
            $gi_ti_3,$gi_fn_3,$gi_mn_3,$gi_ln_3,$gi_se_3,$gi_ph_3,$gi_em_3,$gi_add_3,$gi_pow_3,$gi_ra_3,$gi_wad_3,$gi_yor_3,
            $gi_idt_3,$g_ph_3,$g_id_f_3,$g_id_b_3,
            $next_kin_firstname, $next_kin_middlename, $next_kin_lastname, $next_kin_gender,$next_home_addr, $next_kin_phone,
            $next_kin_relationship, $staff_bank, $staff_account_name, $staff_account_number, $staff_salary,
            $staff_photo, $staff_signature
        );
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function check_company_staff_email($staff_email, $c_id){
        $email_query = "SELECT * FROM tbl_staff WHERE staff_email=? AND company_id=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("ss", $staff_email,$c_id);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function update_staff_files($c_id,$staff_sno,$staff_photo,$staff_signature){
//        $query = "SELECT * FROM tbl_staff WHERE staff_sno=$staff_sno";
//        $req_obj = $this->conn->prepare($query);
//        if ($req_obj->execute()){
//            $res = $req_obj->get_result()->fetch_assoc();
//            if ($staff_photo!='null' && $staff_photo!=""){
//                $delLink = getcwd().'/public/uploads/staff/'.$res['staff_photo'];
//                unlink($delLink);
//            }
//            if ($staff_signature!='null' && $staff_signature!=""){
//                $delLink_4 = getcwd().'/public/uploads/staff/'.$res['staff_signature'];
//                unlink($delLink_4);
//            }
//        }

        $stf_query = "UPDATE tbl_staff SET staff_photo=?, staff_signature=? WHERE staff_sno=? AND company_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("ssis",$staff_photo,$staff_signature,$staff_sno,$c_id);
        if ($stf_obj->execute()) {
            if ($stf_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function get_all_company_staff_account($c_id){
        $stf_query = "SELECT s.*,cr.* FROM tbl_staff s INNER JOIN tbl_company_roles cr ON cr.comp_role_sno=s.staff_role 
                            WHERE s.company_id=? AND s.staff_type='Staff'";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("s",$c_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_all_company_active_staff_account($c_id){
        $stf_query = "SELECT s.*,cr.* FROM tbl_staff s INNER JOIN tbl_company_roles cr ON cr.comp_role_sno=s.staff_role 
                            WHERE s.company_id=? AND s.staff_type='Staff' AND s.staff_acc_status='Active'";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("s",$c_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_all_company_guard_account($c_id){
        $stf_query = "SELECT g.* FROM tbl_guards g WHERE g.guard_status='Active' AND g.company_id=? ORDER by g.guard_firstname ASC";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("s",$c_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_all_company_deployed_guard_account($c_id){
        $stf_query = "SELECT g.*,dg.* FROM tbl_guards g INNER JOIN tbl_guard_deployments dg ON dg.guard_id=g.guard_id
                        WHERE g.company_id=? AND g.guard_status='Active' ORDER by g.guard_firstname ASC";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("s",$c_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_staff_by_id($staff_id, $c_id){
        $stf_query = "SELECT * FROM tbl_staff WHERE staff_id=? AND company_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("ss",$staff_id, $c_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function update_staff_password_by_id($new_pwd,$staff_sno){
        $stf_query = "UPDATE tbl_staff SET staff_password=? WHERE staff_sno=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("si",$new_pwd,$staff_sno);
        if ($stf_obj->execute()) {
            return true;
        }
        return false;
    }

    public function update_staff_account_stat($stfStat,$statusReason,$pay_eligible,$staff_id,$c_id){
        $stf_acc_stat_query = "UPDATE tbl_staff SET staff_acc_status=?,update_status_reason=? WHERE staff_id=? AND company_id=?";
        $stf_acc_stat_obj = $this->conn->prepare($stf_acc_stat_query);
        $stf_acc_stat_obj->bind_param("ssss", $stfStat,$statusReason,$staff_id,$c_id);
        if ($stf_acc_stat_obj->execute()) {
            if ($stf_acc_stat_obj->affected_rows > 0){
                $this->create_staff_stat_hiStory($staff_id,$c_id,$stfStat,$statusReason,$pay_eligible);
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function create_staff_stat_hiStory($staff_id,$company_id,$stfStat,$statusReason,$pay_eligible){
        $date_on = date("Y-m-d H:i");
        $stf_acc_stat_query = "INSERT INTO tbl_status_history 
                                SET staff_id=?,company_id=?,his_status=?,his_stat_reason=?,spay_eligibility=?,his_created_on=?";
        $stf_acc_stat_obj = $this->conn->prepare($stf_acc_stat_query);
        $stf_acc_stat_obj->bind_param("ssssss", $staff_id,$company_id,$stfStat,$statusReason,$pay_eligible,$date_on);
        if ($stf_acc_stat_obj->execute()) {
            return true;
        }
        return false;
    }

    public function update_staff_basic_info_by_id($c_id,$staff_sno,$stf_fname,$stf_mname,$stf_lname,$stf_gender,$stf_marital_status,$stf_home_address,$stf_height,$stf_dob,$stf_religion,$stf_blood_grp,$stf_qualification,$stf_email,$stf_phone,$stf_role,$stf_status){
        $stf_query = "UPDATE tbl_staff SET staff_firstname=?,staff_middlename=?,staff_lastname=?,staff_sex=?,stf_marital_stat=?,stf_home_addr=?,stf_height=?,stf_dob=?,stf_religion=?,stf_blood_grp=?,staff_qualification=?,staff_email=?,staff_phone=?,staff_role=?,staff_acc_status=? WHERE staff_sno=? AND company_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("sssssssssssssssis",$stf_fname,$stf_mname,$stf_lname,$stf_gender,$stf_marital_status,$stf_home_address,$stf_height,$stf_dob,$stf_religion,$stf_blood_grp,$stf_qualification,$stf_email,$stf_phone,$stf_role,$stf_status,$staff_sno,$c_id);
        if ($stf_obj->execute()) {
            if ($stf_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_staff_guarantor_info_by_id(
        $c_id,$staff_sno,
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
        $guarantor_photo_save_3, $guarantor_idcard_front_save_3, $guarantor_idcard_back_save_3
    ){
        $stf_query = "UPDATE tbl_staff SET 
                        staff_guarantor_title=?,staff_guarantor_fname=?,staff_guarantor_mname=?,staff_guarantor_lname=?,staff_guarantor_sex=?,staff_guarantor_phone=?,staff_guarantor_email=?,
                        staff_guarantor_add=?,staff_guarantor_wk_pl=?,staff_guarantor_rank=?,staff_guarantor_wk_add=?,staff_guarantor_yr_or=?,staff_guarantor_id_type=?,staff_guarantor_id_photo=?,
                        staff_guarantor_id_front=?,staff_guarantor_id_back=?,
                        staff_guarantor_title_2=?,staff_guarantor_fname_2=?,staff_guarantor_mname_2=?,staff_guarantor_lname_2=?,staff_guarantor_sex_2=?,staff_guarantor_phone_2=?,staff_guarantor_email_2=?,
                        staff_guarantor_add_2=?,staff_guarantor_wk_pl_2=?,staff_guarantor_rank_2=?,staff_guarantor_wk_add_2=?,staff_guarantor_yr_or_2=?,staff_guarantor_id_type_2=?,staff_guarantor_id_photo_2=?,
                        staff_guarantor_id_front_2=?,staff_guarantor_id_back_2=?,
                        staff_guarantor_title_3=?,staff_guarantor_fname_3=?,staff_guarantor_mname_3=?,staff_guarantor_lname_3=?,staff_guarantor_sex_3=?,staff_guarantor_phone_3=?,staff_guarantor_email_3=?,
                        staff_guarantor_add_3=?,staff_guarantor_wk_pl_3=?,staff_guarantor_rank_3=?,staff_guarantor_wk_add_3=?,staff_guarantor_yr_or_3=?,staff_guarantor_id_type_3=?,staff_guarantor_id_photo_3=?,
                        staff_guarantor_id_front_3=?,staff_guarantor_id_back_3=? 
                        WHERE staff_sno=? AND company_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param(
            "ssssssssssssssssssssssssssssssssssssssssssssssssis",
            $guarantor_title,$guarantor_first_name,$guarantor_middle_name,$guarantor_last_name,$guarantor_sex, $guarantor_phone,
            $guarantor_email,$guarantor_address,$guarantor_place_of_work,$guarantor_rank,$guarantor_work_address,$guarantor_years_of_relationship,
            $guarantor_id_Type,$guarantor_photo_save, $guarantor_idcard_front_save,$guarantor_idcard_back_save,
            $guarantor_title_2,$guarantor_first_name_2,$guarantor_middle_name_2,$guarantor_last_name_2,$guarantor_sex_2, $guarantor_phone_2,
            $guarantor_email_2,$guarantor_address_2,$guarantor_place_of_work_2,$guarantor_rank_2,$guarantor_work_address_2,$guarantor_years_of_relationship_2,
            $guarantor_id_Type_2,$guarantor_photo_save_2, $guarantor_idcard_front_save_2,$guarantor_idcard_back_save_2,
            $guarantor_title_3,$guarantor_first_name_3,$guarantor_middle_name_3,$guarantor_last_name_3,$guarantor_sex_3, $guarantor_phone_3,
            $guarantor_email_3,$guarantor_address_3,$guarantor_place_of_work_3,$guarantor_rank_3,$guarantor_work_address_3,$guarantor_years_of_relationship_3,
            $guarantor_id_Type_3,$guarantor_photo_save_3, $guarantor_idcard_front_save_3,$guarantor_idcard_back_save_3,
            $staff_sno,$c_id
        );
        if ($stf_obj->execute()) {
            if ($stf_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_staff_next_of_kin_info_by_id($c_id,$staff_sno,$stf_kinfirstname,$stf_kinMiddlename,$stf_kinLastname,$stf_kinGender,$stf_kinPhone,$stf_kinRel){
        $stf_query = "UPDATE tbl_staff SET next_kin_firstname=?,next_kin_middlename=?,next_kin_lastname=?,next_kin_gender=?,next_kin_phone=?,next_kin_relationship=? WHERE staff_sno=? AND company_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("ssssssis",$stf_kinfirstname,$stf_kinMiddlename,$stf_kinLastname,$stf_kinGender,$stf_kinPhone,$stf_kinRel,$staff_sno,$c_id);
        if ($stf_obj->execute()) {
            if ($stf_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_staff_acc_info_by_id($c_id,$staff_sno,$stf_accBnk,$stf_accName,$stf_accNo,$stf_salary){
        $stf_query = "UPDATE tbl_staff SET staff_bank=?,staff_account_name=?,staff_account_number=?,staff_salary=? WHERE staff_sno=? AND company_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("ssssis",$stf_accBnk,$stf_accName,$stf_accNo,$stf_salary,$staff_sno,$c_id);
        if ($stf_obj->execute()) {
            if ($stf_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_staff_profile_by_id($staff_sno,$stf_fname,$stf_lname,$stf_email,$stf_role,$stf_status){
        $stf_query = "UPDATE tbl_staff SET staff_firstname=?,staff_lastname=?,staff_email=?,staff_role=?,staff_acc_status=? WHERE staff_sno=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("sssssi",$stf_fname,$stf_lname,$stf_email,$stf_role,$stf_status,$staff_sno);
        if ($stf_obj->execute()) {
            if ($stf_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function get_staff_privileges_by_id($staff_id, $c_id){
        $stf_query = "SELECT stf.*, r.* FROM tbl_staff stf INNER JOIN tbl_company_roles r ON stf.staff_role=r.comp_role_sno  WHERE stf.staff_id=? AND stf.company_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("ss",$staff_id, $c_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_staff_profile_by_id($staff_id, $c_id){
        $stf_query = "SELECT stf.*, c.*, com.* FROM tbl_staff stf INNER JOIN tbl_company_roles c ON stf.staff_role=c.comp_role_sno 
        INNER JOIN tbl_company com ON stf.company_id=com.company_id  WHERE stf.staff_id=? AND stf.company_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("ss",$staff_id, $c_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_guard_profile_by_id($guard_id, $c_id){
        $stf_query = "SELECT grd.*, com.* FROM tbl_guards grd
        INNER JOIN tbl_company com ON grd.company_id=com.company_id  WHERE grd.guard_id=? AND grd.company_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("ss",$guard_id, $c_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_client_profile_by_id($client_id, $c_id){
        $clt_query = "SELECT clt.*, com.* FROM tbl_client clt INNER JOIN tbl_company com ON clt.company_id=com.company_id  WHERE clt.client_id=? AND clt.company_id=?";
        $clt_obj = $this->conn->prepare($clt_query);
        $clt_obj->bind_param("ss",$client_id, $c_id);
        if ($clt_obj->execute()) {
            return $clt_obj->get_result();
        }
        return array();
    }

    public function update_staff_status($status,$staff_sno){
        $stf_query = "UPDATE tbl_staff SET staff_acc_status='$status' WHERE staff_sno=$staff_sno";
        $stf_obj = $this->conn->prepare($stf_query);
        if ($stf_obj->execute()){
            if ($stf_obj->affected_rows > 0){return true;}
            return false;
        }
        return false;
    }

    public function delete_staff($staff_sno) {
        $query = "SELECT * FROM tbl_staff WHERE staff_sno=$staff_sno";
        $req_obj = $this->conn->prepare($query);
        if ($req_obj->execute()){
            $res = $req_obj->get_result()->fetch_assoc();
            if ($res['staff_photo']!='null' && $res['staff_photo']!=""){
                $delLink = getcwd().'/public/uploads/staff/'.$res['staff_photo'];
                unlink($delLink);
            }
            if ($res['staff_guarantor_photo']!='null' && $res['staff_guarantor_photo']!=""){
                $delLink_1 = getcwd().'/public/uploads/staff/'.$res['staff_guarantor_photo'];
                unlink($delLink_1);
            }
            if ($res['staff_guarantor_idcard_photo_front']!='null' && $res['staff_guarantor_idcard_photo_front']!=""){
                $delLink_2 = getcwd().'/public/uploads/staff/'.$res['staff_guarantor_idcard_photo_front'];
                unlink($delLink_2);
            }
            if ($res['staff_guarantor_idcard_photo_back']!='null' && $res['staff_guarantor_idcard_photo_back']!=""){
                $delLink_3 = getcwd().'/public/uploads/staff/'.$res['staff_guarantor_idcard_photo_back'];
                unlink($delLink_3);
            }
            if ($res['staff_signature']!='null' && $res['staff_signature']!=""){
                $delLink_4 = getcwd().'/public/uploads/staff/'.$res['staff_signature'];
                unlink($delLink_4);
            }
        }

        $stf_query = "DELETE FROM tbl_staff WHERE staff_sno=$staff_sno";
        $stf_obj = $this->conn->prepare($stf_query);
        if ($stf_obj->execute()){
            if ($stf_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function get_staff_details_by_email($email, $c_id) {
        $email_query = "SELECT * FROM tbl_staff WHERE staff_email=? AND staff_acc_status='Active' AND company_id=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("ss",$email, $c_id);
        if ($user_obj->execute()){
            return $user_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_company_first_login($c_id){
        $email_query = "SELECT * FROM tbl_company WHERE company_id=? AND company_first_login='YES'";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s",$c_id);
        if ($user_obj->execute()){
            return $user_obj->get_result();
        }
        return array();
    }

    public function update_company_first_login($c_id) {
        $com_query = "UPDATE tbl_company SET company_first_login='NO' WHERE company_id='$c_id'";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()){
            if ($com_obj->affected_rows > 0){return true;}
            return false;
        }
        return false;
    }

    public function get_all_company_roles($c_id){
        $role_query = "SELECT cr.*,r.* FROM tbl_company_roles cr INNER JOIN tbl_roles r ON r.role_sno = cr.role_sno
                        WHERE cr.company_id=?";
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("s", $c_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function get_all_company_shifts($c_id){
        $role_query = "SELECT * FROM tbl_company_shifts WHERE company_id=?";
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("s", $c_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function get_all_company_penalties($c_id){
        $role_query = "SELECT * FROM tbl_company_penalties WHERE company_id=?";
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("s", $c_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function get_all_roles(){
        $role_query = "SELECT * FROM tbl_roles";
        $role_obj = $this->conn->prepare($role_query);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function create_company_role($role_name, $comp_id, $role_sno, $r_created_on){
        $com_query = "INSERT INTO tbl_company_roles SET company_id=?,role_sno=?,company_role_name=?,company_role_created_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("siss", $comp_id,$role_sno,$role_name,$r_created_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }
    
    public function create_company_shift($comp_id,$shift_title, $shift_hours, $res_time, $cls_time, $r_created_on){
        $com_query = "INSERT INTO tbl_company_shifts SET company_id=?,shift_title=?,shift_hours=?,resume_time=?, close_time=?, shift_created_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssssss", $comp_id,$shift_title, $shift_hours, $res_time, $cls_time, $r_created_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }


    public function create_company_penalty($comp_id,$off_name,$off_charge,$charge_amt,$charge_days,$off_created_on){
        $off_query = "INSERT INTO tbl_company_penalties SET company_id=?,offense_name=?,offense_charge=?,charge_amt=?,days_deduct=?,off_created_on=?";
        $off_obj = $this->conn->prepare($off_query);
        $off_obj->bind_param("sssdis", $comp_id,$off_name,$off_charge,$charge_amt,$charge_days,$off_created_on);
        if ($off_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_all_staff_offences($c_id){
        $stf_offence_query = "SELECT so.*,s.*,op.* FROM tbl_staff_offense so INNER JOIN tbl_staff s ON s.staff_id=so.staff_id
                                LEFT JOIN tbl_staff_offense_pardon op ON op.par_staff_offense_id=so.staff_offense_id
                                WHERE so.company_id=? AND op.par_staff_offense_id IS NULL ";
        $stf_offence_obj = $this->conn->prepare($stf_offence_query);
        $stf_offence_obj->bind_param("s", $c_id);
        if ($stf_offence_obj->execute()) {
            return $stf_offence_obj->get_result();
        }
        return array();
    }

    public function create_staff_offense_pardon($offense_id, $pardon_reason, $pa_created_on){
        $com_query = "INSERT INTO tbl_staff_offense_pardon SET par_staff_offense_id=?,par_reason=?,par_created_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("iss", $offense_id, $pardon_reason, $pa_created_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_guard_offense_pardon($offense_id, $pardon_reason, $pa_created_on){
        $com_query = "INSERT INTO tbl_guard_offense_pardon SET g_par_guard_offense_id=?,g_par_reason=?,g_par_created_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("iss", $offense_id, $pardon_reason, $pa_created_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_all_company_guard_positions($c_id){
        $p_query = "SELECT * FROM tbl_guard_positions WHERE company_id=?";
        $p_obj = $this->conn->prepare($p_query);
        $p_obj->bind_param("s", $c_id);
        if ($p_obj->execute()) {
            return $p_obj->get_result();
        }
        return array();
    }

    public function get_all_guard_offences($c_id){
        $guard_offence_query = "SELECT gof.*,g.*,op.* FROM tbl_guard_offense gof INNER JOIN tbl_guards g ON g.guard_id=gof.guard_id
                                LEFT JOIN tbl_guard_offense_pardon op ON op.g_par_guard_offense_id=gof.guard_offense_id
                                WHERE gof.company_id=? AND op.g_par_guard_offense_id IS NULL ";
        $guard_offence_obj = $this->conn->prepare($guard_offence_query);
        $guard_offence_obj->bind_param("s", $c_id);
        if ($guard_offence_obj->execute()) {
            return $guard_offence_obj->get_result();
        }
        return array();
    }

    public function get_all_staff_loans($c_id){
        $stf_loan_query = "SELECT so.*,s.* FROM tbl_staff_loan so INNER JOIN tbl_staff s ON s.staff_id=so.staff_id WHERE so.company_id=?";
        $stf_loan_obj = $this->conn->prepare($stf_loan_query);
        $stf_loan_obj->bind_param("s", $c_id);
        if ($stf_loan_obj->execute()) {
            return $stf_loan_obj->get_result();
        }
        return array();
    }

    public function get_all_guard_loans($c_id){
        $gd_loan_query = "SELECT g.*,s.* FROM tbl_guard_loan g INNER JOIN tbl_guards s ON s.guard_id=g.guard_id WHERE g.company_id=?";
        $gd_loan_obj = $this->conn->prepare($gd_loan_query);
        $gd_loan_obj->bind_param("s", $c_id);
        if ($gd_loan_obj->execute()) {
            return $gd_loan_obj->get_result();
        }
        return array();
    }

    public function get_all_guard_salary_advance($c_id){
        $gd_loan_query = "SELECT sa.*,s.* FROM tbl_guard_salary_advance sa INNER JOIN tbl_guards s ON s.guard_id=sa.guard_id WHERE sa.company_id=?";
        $gd_loan_obj = $this->conn->prepare($gd_loan_query);
        $gd_loan_obj->bind_param("s", $c_id);
        if ($gd_loan_obj->execute()) {
            return $gd_loan_obj->get_result();
        }
        return array();
    }

    public function get_all_staff_salary_advance($c_id){
        $stf_loan_query = "SELECT sa.*,s.* FROM tbl_staff_salary_advance sa INNER JOIN tbl_staff s ON s.staff_id=sa.staff_id WHERE sa.company_id=?";
        $stf_loan_obj = $this->conn->prepare($stf_loan_query);
        $stf_loan_obj->bind_param("s", $c_id);
        if ($stf_loan_obj->execute()) {
            return $stf_loan_obj->get_result();
        }
        return array();
    }

    public function check_role_name($role_name,$comp_id){
        $com_query = "SELECT * FROM tbl_company_roles WHERE company_role_name=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss", $role_name,$comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_company_role_by_id($role_sno, $comp_id){
        $role_query = "SELECT * FROM tbl_company_roles WHERE comp_role_sno=? AND company_id=?";
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("is",$role_sno,$comp_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function get_company_shift_by_id($shift_id, $comp_id){
        $role_query = "SELECT * FROM tbl_company_shifts WHERE shift_id=? AND company_id=?";
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("is",$shift_id,$comp_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function get_company_penalty_by_id($offense_id, $comp_id){
        $off_query = "SELECT * FROM tbl_company_penalties WHERE offense_id=? AND company_id=?";
        $off_obj = $this->conn->prepare($off_query);
        $off_obj->bind_param("is",$offense_id,$comp_id);
        if ($off_obj->execute()) {
            return $off_obj->get_result();
        }
        return array();
    }

    public function update_company_role_by_sno($role_name,$role_sno,$comp_role_sno,$comp_id){
        $com_query = "UPDATE tbl_company_roles SET company_role_name=?,role_sno=? WHERE comp_role_sno=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssis", $role_name, $role_sno, $comp_role_sno, $comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0) {
                return true;
            }
            return "no_change";
        }
        return false;

    }

    public function update_company_shift_by_id($shift_title,$shift_hours,$resume_time,$close_time,$shift_id,$comp_id){
        $com_query = "UPDATE tbl_company_shifts SET shift_title=?,shift_hours=?,resume_time=?,close_time=? WHERE shift_id=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sssiis",$shift_title,$shift_hours,$resume_time,$close_time,$shift_id,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_company_penalty_by_id($off_name,$off_charge,$charge_amt,$charge_days,$offense_id,$comp_id){
        $com_query = "UPDATE tbl_company_penalties SET offense_name=?,offense_charge=?,charge_amt=?,days_deduct=? WHERE offense_id=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssdiis",$off_name,$off_charge,$charge_amt,$charge_days,$offense_id,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function delete_company_role($comp_role_sno,$comp_id){
        $com_query = "DELETE FROM tbl_company_roles WHERE comp_role_sno=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("is",$comp_role_sno,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function delete_company_shift($shift_id,$comp_id){
        $com_query = "DELETE FROM tbl_company_shifts WHERE shift_id=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("is",$shift_id,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function delete_company_penalty($offense_id,$comp_id){
        $com_query = "DELETE FROM tbl_company_penalties WHERE offense_id=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("is",$offense_id,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function create_report_incident($r_id,$c_id,$s_id,$r_title,$r_beat,$r_occ_date,$r_des,$ph_1,$ph_2,$ph_3,$ph_4,$ph_5,$r_on){
        $off_query = "INSERT INTO tbl_incident_reports SET inc_rep_id=?,company_id=?,staff_id=?,report_title=?,report_beat=?,report_occ_date=?,report_describe=?,
                                report_photo_1=?,report_photo_2=?,report_photo_3=?,report_photo_4=?,report_photo_5=?,report_created_on=?";
        $off_obj = $this->conn->prepare($off_query);
        $off_obj->bind_param("sssssssssssss", $r_id,$c_id,$s_id,$r_title,$r_beat,$r_occ_date,$r_des,$ph_1,$ph_2,$ph_3,$ph_4,$ph_5,$r_on);
        if ($off_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_all_company_incidents($comp_id){
        $role_query = "SELECT ir.*,s.* FROM tbl_incident_reports ir INNER JOIN tbl_staff s ON s.staff_id=ir.staff_id WHERE ir.company_id=?";
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("s", $comp_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function delete_company_incident($incident_id,$comp_id){
        $query = "SELECT * FROM tbl_incident_reports WHERE inc_rep_id='$incident_id'";
        $req_obj = $this->conn->prepare($query);
        if ($req_obj->execute()){
            $res = $req_obj->get_result()->fetch_assoc();
            if ($res['report_photo_1']!='null' && $res['report_photo_1']!=""){
                $delLink = getcwd().'/public/uploads/reports/'.$res['report_photo_1'];
                unlink($delLink);
            }
            if ($res['report_photo_2']!='null' && $res['report_photo_2']!=""){
                $delLink_1 = getcwd().'/public/uploads/reports/'.$res['report_photo_2'];
                unlink($delLink_1);
            }
            if ($res['report_photo_3']!='null' && $res['report_photo_3']!=""){
                $delLink_2 = getcwd().'/public/uploads/reports/'.$res['report_photo_3'];
                unlink($delLink_2);
            }
            if ($res['report_photo_4']!='null' && $res['report_photo_4']!=""){
                $delLink_3 = getcwd().'/public/uploads/reports/'.$res['report_photo_4'];
                unlink($delLink_3);
            }
            if ($res['report_photo_5']!='null' && $res['report_photo_5']!=""){
                $delLink_4 = getcwd().'/public/uploads/reports/'.$res['report_photo_5'];
                unlink($delLink_4);
            }
        }

        $com_query = "DELETE FROM tbl_incident_reports WHERE inc_rep_id=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$incident_id,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function get_company_incident_by_id($incident_id, $comp_id){
        $inc_query = "SELECT ir.*,s.* FROM tbl_incident_reports ir INNER JOIN tbl_staff s ON s.staff_id=ir.staff_id WHERE ir.inc_rep_id=? AND ir.company_id=?";
        $inc_obj = $this->conn->prepare($inc_query);
        $inc_obj->bind_param("ss",$incident_id,$comp_id);
        if ($inc_obj->execute()) {
            return $inc_obj->get_result();
        }
        return array();
    }

    public function create_company_kit($comp_id,$kit_name,$k_created_on){
        $com_query = "INSERT INTO tbl_kits SET company_id=?,kit_name=?,kit_created_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss", $comp_id,$kit_name,$k_created_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_company_kit_inventory($comp_id,$kit_type,$kit_id,$kit_num,$k_created_on,$k_updated_on){
        $com_query = "INSERT INTO tbl_kits_inventory SET company_id=?,kit_name=?,kit_type=?,kit_number=?,k_inv_created=?,k_inv_updated=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sssiss", $comp_id,$kit_id,$kit_type,$kit_num,$k_created_on,$k_updated_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function update_company_kit_inventory($comp_id,$kit_inv_sno,$kit_type,$kit_id,$kit_num,$k_updated_on){
        $com_query = "UPDATE tbl_kits_inventory SET kit_type=?,kit_number=?,k_inv_updated=? WHERE kit_inv_sno=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sisis", $kit_type,$kit_num,$k_updated_on, $kit_inv_sno, $comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function get_company_kits_by_id($comp_id){
        $comp_query = "SELECT * FROM tbl_kits WHERE company_id=?";
        $comp_obj = $this->conn->prepare($comp_query);
        $comp_obj->bind_param("s", $comp_id);
        if ($comp_obj->execute()) {
            return $comp_obj->get_result();
        }
        return array();
    }

    public function get_all_company_kits_inventory($comp_id){
        $com_query = "SELECT * FROM tbl_kits_inventory WHERE company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function get_all_company_kits_inventory_in_stock($comp_id){
        $com_query = "SELECT * FROM tbl_kits_inventory WHERE company_id=? AND kit_number > 0";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function delete_company_kit_inventory($kit_inv_sno,$comp_id){
        $com_query = "DELETE FROM tbl_kits_inventory WHERE kit_inv_sno=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("is",$kit_inv_sno,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function delete_company_registered_kit($kit_sno,$comp_id){
        $com_query = "DELETE FROM tbl_kits WHERE kit_sno=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("is",$kit_sno,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }
    
    public function delete_guard_xtraduty_entry($xtraduty_id,$comp_id){
        $com_query = "DELETE FROM tbl_guard_extra_duty WHERE id=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("is",$xtraduty_id,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function create_kit_inventory_history($comp_id,$type,$guard_id,$action,$message,$k_date){
        $com_query = "INSERT INTO tbl_kit_logs SET company_id=?,guard_id=?,kl_type=?,kl_action=?,kl_message=?,kl_date=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssssss", $comp_id,$guard_id,$type,$action,$message,$k_date);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_kits_inventory_history($comp_id){
        $com_query = "SELECT kl.*,g.* FROM tbl_kit_logs kl LEFT JOIN tbl_guards g ON g.guard_id=kl.guard_id WHERE kl.company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function issue_staff_loan(
        $loan_id,$comp_id,$staff_id,$loan_r,$loan_amt,$loan_dur,$loan_repay,$l_amt_bal,
        $issue_date,$loan_due_date,$loan_due_month,$loan_due_year,$l_created_on,$l_update_on
    ){
        $com_query = "INSERT INTO tbl_staff_loan SET staff_loan_id=?,company_id=?,staff_id=?,staff_loan_reason=?,staff_loan_amount=?,
                        staff_loan_month=?,staff_loan_monthly_amount=?,staff_loan_curr_balance=?,staff_loan_date=?,
                        loan_due_date=?,loan_due_month=?,loan_due_year=?,staff_loan_created_at=?,staff_loan_updated_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param(
            "ssssdiddssssss",
            $loan_id,$comp_id,$staff_id,$loan_r,$loan_amt,$loan_dur,$loan_repay,$l_amt_bal,
                    $issue_date,$loan_due_date,$loan_due_month,$loan_due_year,$l_created_on,$l_update_on
        );
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function staff_loan_repayment($loan_id,$comp_id,$staff_id,$loan_bal,$month_left,$created_on){
        $com_query = "INSERT INTO tbl_staff_loan_repayment SET 
                    staff_loan_id=?,company_id=?,staff_id=?,staff_loan_balance=?,staff_month_left=?,staff_month_left=?,sl_re_created_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssssis",$loan_id,$comp_id,$staff_id,$loan_bal,$month_left,$created_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_staff_surcharge($offense_title,$charge_mode,$charge_days,$charge_amt,$charge_reason,$staff_id,$comp_id,$su_created_on){
        $com_query = "INSERT INTO tbl_staff_offense SET company_id=?,staff_id=?,offense_name=?,charge_mode=?,no_of_days=?,charge_amt=?,offense_remark=?,stf_created_at=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssssidss", $comp_id,$staff_id,$offense_title,$charge_mode,$charge_days,$charge_amt,$charge_reason,$su_created_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_staff_salary_advance($comp_id,$staff_id,$sa_reason,$sa_amt,$sa_created_on,$sa_update_on){
        $com_query = "INSERT INTO tbl_staff_salary_advance SET company_id=?,staff_id=?,salary_adv_amount=?,salary_adv_reason=?,created_at=?,updated_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssdsss",$comp_id,$staff_id,$sa_amt,$sa_reason,$sa_created_on,$sa_update_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function check_salary_adv_not_exceed_basic_salary($comp_id,$staff_id,$amount){
        $month = date("F");
        $year = date("Y");
        $s_d = $this->get_payroll_staff_data($comp_id,$staff_id);
        $total_amount_this_month = $this->sum_up_staff_sal_adv_amt_per_month($staff_id,$comp_id,$month,$year);

        $net_amt = $total_amount_this_month['advMonAmt']+$amount;

        if ($net_amt >= $s_d['staff_salary']) return false;
        else return true;
    }

    public function generate_staff_payroll($spr_mon,$spr_yr,$stf_sal,$pen_ch_amt,$pen_ch_days,$mon_ln_amt,$sal_adv,$staff_id,$comp_id,$stf_dept,$crt_on,$up_on){
        $com_query = "INSERT INTO tbl_staff_payroll SET spr_month=?,spr_year=?,staff_salary=?,pen_charge_amt=?,pen_charge_days=?,monthly_loan_amt=?,
                            salary_advance=?,staff_id=?,company_id=?,staff_dept=?,spr_created_at=?,spr_updated_at=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param(
            "ssddiddsssss",
            $spr_mon,$spr_yr,$stf_sal,$pen_ch_amt,$pen_ch_days,$mon_ln_amt,$sal_adv,$staff_id,$comp_id,$stf_dept,$crt_on,$up_on
        );
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_payroll_staff_data($comp_id,$staff_id){
        $com_query = "SELECT s.*,l.*,cr.* FROM tbl_staff s LEFT JOIN tbl_staff_loan l ON s.staff_id = l.staff_id
                        LEFT JOIN tbl_company_roles cr ON cr.comp_role_sno = s.staff_role
                        WHERE s.company_id=? AND s.staff_id=?  AND s.staff_type='Staff'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss", $comp_id,$staff_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_payroll_guard_data($comp_id,$guard_id){
        $com_query = "SELECT g.*,l.*,dg.* FROM tbl_guards g 
                        INNER JOIN tbl_guard_deployments dg ON dg.guard_id=g.guard_id
                        LEFT JOIN tbl_guard_loan l ON g.guard_id = l.guard_id WHERE g.company_id=? AND g.guard_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss", $comp_id,$guard_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result()->fetch_assoc();
        }
        return array();
    }
    
    public function get_payroll_guard_loan_data($comp_id,$guard_id){
        $com_query = "SELECT g.*,l.* FROM tbl_guards g
                        LEFT JOIN tbl_guard_loan l ON g.guard_id = l.guard_id WHERE g.company_id=? AND g.guard_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss", $comp_id,$guard_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function sum_up_staff_offense_amt_per_month($staff_id,$month,$year,$comp_id){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(so.charge_amt) as Amt, SUM(so.no_of_days) as days FROM tbl_staff_offense so 
            LEFT JOIN tbl_staff_offense_pardon op ON so.staff_offense_id=op.par_staff_offense_id
            WHERE so.staff_id=? AND so.company_id=? AND MONTH(so.stf_created_at)='$month' AND YEAR(so.stf_created_at)='$year' AND op.par_staff_offense_id IS NULL";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$staff_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return array();
    }

    public function sum_up_guard_offense_amt_per_month($guard_id,$month,$year,$comp_id){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(gof.charge_amt) as Amt, SUM(gof.no_of_days) as DaysOf FROM tbl_guard_offense gof 
            LEFT JOIN tbl_guard_offense_pardon op ON gof.guard_offense_id=op.g_par_guard_offense_id
            WHERE gof.guard_id=? AND gof.company_id=? AND MONTH(gof.g_off_created_at)='$month' 
            AND YEAR(gof.g_off_created_at)='$year' AND op.g_par_guard_offense_id IS NULL";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return array();
    }

    public function sum_up_staff_sal_adv_amt_per_month($staff_id,$comp_id,$month,$year){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(salary_adv_amount) as advMonAmt FROM tbl_staff_salary_advance WHERE staff_id=? AND company_id=? AND MONTH(created_at)='$month' AND YEAR(created_at)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$staff_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function sum_up_guard_sal_adv_amt_per_month($guard_id,$comp_id,$month,$year){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(salary_adv_amount) as advMonAmt FROM tbl_guard_salary_advance WHERE guard_id=? AND company_id=? AND MONTH(created_at)='$month' AND YEAR(created_at)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function sum_up_guard_extra_duty_per_month($guard_id,$comp_id,$month,$year){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(days_amount) as exDutyAmt FROM tbl_guard_extra_duty WHERE guard_id=? AND company_id=? AND MONTH(created_at)='$month' AND YEAR(created_at)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function sum_up_guard_extra_duty_days_per_month($guard_id,$comp_id,$month,$year){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(no_of_days) as exDutyDays FROM tbl_guard_extra_duty WHERE guard_id=? AND company_id=? AND MONTH(created_at)='$month' AND YEAR(created_at)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function sum_up_guard_kit_issued_per_month($guard_id,$comp_id,$month,$year){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(monthly_charge) as kitAmt FROM tbl_issue_guard_kit WHERE guard_id=? AND company_id=? AND MONTH(created_at)='$month' AND YEAR(created_at)='$year'  AND no_of_month !=0";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function sum_up_guard_kit_issued_permanent($guard_id,$comp_id){
        $com_query = "SELECT SUM(monthly_charge) as kitAmt FROM tbl_issue_guard_kit WHERE guard_id=? AND company_id=? AND no_of_month=0";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function sum_up_guard_abs_train_per_month($guard_id,$comp_id,$month,$year){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(charge_amt) as absTrainAmt FROM tbl_guard_absent_training WHERE guard_id=? AND company_id=? AND MONTH(created_at)='$month' AND YEAR(created_at)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function sum_up_guard_id_chg_per_month($guard_id,$comp_id,$month,$year){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(amount) as idChgAmt FROM tbl_guard_id_card_charge WHERE guard_id=? AND company_id=? AND MONTH(created_at)='$month' AND YEAR(created_at)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function sum_up_guard_no_work_per_month($guard_id,$comp_id,$c_date,$year){
        $month = date("m", strtotime($c_date));
        $com_query = "SELECT SUM(no_work_days) as no_work_days FROM tbl_guard_status_no_work_days WHERE guard_id=? AND company_id=? AND gpay_eligible='No' AND MONTH(nwd_date)='$month' AND YEAR(nwd_date)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }
    
    public function sum_up_guard_deactivated_pay_per_month($guard_id,$comp_id,$month,$year){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(deh_gpays) as amount_pay,SUM(deh_days_work) as days_pay FROM tbl_deactivated_history 
                        WHERE deh_guard_id=? AND deh_company_id=? AND gpay_eligibility='Yes' AND MONTH(deactivated_date)='$month' AND YEAR(deactivated_date)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function count_in_progress_loan($loan_id,$staff_id,$comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_staff_loan_repayment WHERE staff_loan_id=? AND staff_id=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$loan_id,$staff_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function count_in_progress_guard_loan($loan_id,$guard_id,$comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_guard_loan_repayment WHERE guard_loan_id=? AND guard_id=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$loan_id,$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }
    
    public function get_all_guard_xtraduties($guard_id){
        $com_query = "SELECT xd.*,b.beat_name FROM tbl_guard_extra_duty xd INNER JOIN tbl_beats b ON b.beat_id=xd.beat_id WHERE xd.guard_id=? ORDER BY xd.id DESC";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $guard_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }
    
    

    public function test_if_loan_is_settled_this_month($loan_id,$staff_id,$comp_id,$month,$year){
        $month = date("m", strtotime($month));
        $year = date("Y", strtotime($year));
        $com_query = "SELECT count(*) AS myCount FROM tbl_staff_loan_repayment WHERE staff_loan_id=? AND 
                        staff_id=? AND company_id=? AND MONTH(sl_re_created_on)='$month' AND YEAR(sl_re_created_on)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$loan_id,$staff_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function test_if_guard_loan_is_settled_this_month($loan_id,$guard_id,$comp_id,$month,$year){
        $month = date("m", strtotime($month));
        $year = date("Y", strtotime($year));
        $com_query = "SELECT count(*) AS myCount FROM tbl_guard_loan_repayment WHERE guard_loan_id=? AND 
                        guard_id=? AND company_id=? AND MONTH(gd_re_created_on)='$month' AND YEAR(gd_re_created_on)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$loan_id,$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function create_staff_repayment_deduct($stf_loan_id,$comp_id,$stf_id,$ln_bal,$mon_left,$pad_mon,$pad_yr,$re_date){
        $com_query = "INSERT INTO tbl_staff_loan_repayment SET staff_loan_id=?,company_id=?,staff_id=?,staff_loan_balance=?,
                    staff_month_left=?,stf_paid_month=?,stf_paid_year=?,sl_re_created_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssssisss",$stf_loan_id,$comp_id,$stf_id,$ln_bal,$mon_left,$pad_mon,$pad_yr,$re_date);
        if ($com_obj->execute()) {
            return $this->conn->insert_id;
        }
        return 0;
    }

    public function create_guard_repayment_deduct($g_loan_id,$comp_id,$g_id,$ln_bal,$mon_left,$pad_mon,$pad_yr,$re_date){
        $com_query = "INSERT INTO tbl_guard_loan_repayment SET guard_loan_id=?,company_id=?,guard_id=?,guard_loan_balance=?,
                        guard_month_left=?,grd_paid_month=?,grd_paid_year=?,gd_re_created_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssssisss",$g_loan_id,$comp_id,$g_id,$ln_bal,$mon_left,$pad_mon,$pad_yr,$re_date);
        if ($com_obj->execute()) {
            return $this->conn->insert_id;
        }
        return 0;
    }

    public function update_curr_loan_balance($stf_loan_id,$comp_id,$stf_id,$balance){
        $com_query = "UPDATE tbl_staff_loan SET staff_loan_curr_balance=? WHERE staff_loan_id=? AND company_id=? AND staff_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("dsis", $balance, $stf_loan_id, $comp_id, $stf_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function update_guard_curr_loan_balance($g_loan_id,$comp_id,$g_id,$balance) {
        $com_query = "UPDATE tbl_guard_loan SET guard_loan_curr_balance=? WHERE guard_loan_id=? AND company_id=? AND guard_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("dsis",$balance,$g_loan_id,$comp_id,$g_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function get_all_company_payroll_history($comp_id){
        $com_query = "SELECT DISTINCT spr_month,spr_year FROM tbl_staff_payroll WHERE company_id=? ORDER BY spr_year desc";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function get_all_company_guard_payroll_history($comp_id){
        $com_query = "SELECT DISTINCT gpr_month,gpr_year FROM tbl_guard_payroll WHERE company_id=? ORDER BY gpr_year desc";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function count_company_guard_payroll_history($comp_id){
        $com_query = "SELECT count(DISTINCT gpr_month,gpr_year) as myCount FROM tbl_guard_payroll WHERE company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function delete_company_staff_payroll($spr_month,$spr_year,$comp_id){
        $com_query = "DELETE FROM tbl_staff_payroll WHERE spr_month=? AND spr_year=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$spr_month,$spr_year,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function delete_company_guard_payroll($gpr_month,$gpr_year,$comp_id){
        $com_query = "DELETE FROM tbl_guard_payroll WHERE gpr_month=? AND gpr_year=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$gpr_month,$gpr_year,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){ 
                $this->delete_guard_repayment_when_payroll_is_deleted($comp_id,$gpr_month,$gpr_year);
                return true; 
            }
            return false;
        }
        return false;
    }
    
    public function delete_guard_repayment_when_payroll_is_deleted($comp_id,$month,$year){
        $com_query = "DELETE FROM tbl_guard_loan_repayment 
                        WHERE company_id='$comp_id' AND grd_paid_month='$month' AND grd_paid_year='$year'";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }
    
    // public function update_guard_loan_bal_when_payroll_is_deleted($comp_id, $g_loan_id,$month,$year){
    //     $com_query = "UPDATE tbl_guard_loan SET guard_loan_curr_balance=? WHERE guard_loan_id=? AND company_id=? AND guard_id=?";
    //     $com_obj = $this->conn->prepare($com_query);
    //     $com_obj->bind_param("dsis",$balance,$g_loan_id,$comp_id,$g_id);
    //     if ($com_obj->execute()) {
    //         if ($com_obj->affected_rows > 0) {
    //             return true;
    //         }
    //         return false;
    //     }
    //     return false;
    // }

    public function create_staff_payroll(
        $month,$year,$b_salary,$penChAmt,$penChDays,$monthlyAmt,$repay_id,$salAdv,$stfId,$compId,
        $totOff,$othCred,$othDeb,$totded,$net_pay,$creOn,$upOn
    ){
        $com_query = "INSERT INTO tbl_staff_payroll SET spr_month=?,spr_year=?,staff_salary=?,pen_charge_amt=?,pen_charge_days=?,
                    monthly_loan_amt=?,stf_loan_repay_id=?,salary_advance=?,staff_id=?,company_id=?,total_offense=?,
                    spr_oth_credit=?,spr_oth_debit=?,total_deduct=?,net_pay=?,spr_created_at=?,spr_updated_at=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param(
            "ssddidsdssdddddss",
            $month,$year,$b_salary,$penChAmt,$penChDays,$monthlyAmt,$repay_id,$salAdv,$stfId,$compId,$totOff,
            $othCred,$othDeb,$totded,$net_pay,$creOn,$upOn
        );
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_guard_payroll(
        $month,$year,$b_salary,$penChAmt,$penChDays,$monthlyAmt,$repay_id,$salAdv,$gId,$gName,$gBeatname,$gCommDate,$compId,
        $totOff,$othCred,$othDeb,$agent_fee,$days_worked,$toExDays,$totEx,$totIss,$totAbs,$totIdC,$g_p_credit,$g_p_debit,$totded,$net_pay,$creOn,$upOn
    ){
        $com_query = "INSERT INTO tbl_guard_payroll SET gpr_month=?,gpr_year=?,guard_salary=?,pen_charge_amt=?,pen_charge_days=?,
                    monthly_loan_amt=?,grd_loan_repay_id=?,salary_advance=?,guard_id=?,guard_fullname=?,gd_beat_name=?,gd_bt_date_com=?,company_id=?,total_offense=?,
                    gpr_oth_credit=?,gpr_oth_debit=?,agent_fee=?,days_worked=?,total_extra_days=?,total_extra_duty=?,total_issued_kit=?,total_abs_train=?,
                    total_id_card=?,payroll_credit=?,payroll_debit=?,total_deduct=?,net_pay=?,gpr_created_at=?,gpr_updated_at=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param(
            "ssddidsdsssssddddddddddddddss",
            $month,$year,$b_salary,$penChAmt,$penChDays,$monthlyAmt,$repay_id,$salAdv,$gId,$gName,$gBeatname,$gCommDate,$compId,$totOff,
            $othCred,$othDeb,$agent_fee,$days_worked,$toExDays,$totEx,$totIss,$totAbs,$totIdC,$g_p_credit,$g_p_debit,$totded,$net_pay,$creOn,$upOn
        );
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function check_if_payroll_exist($month,$year,$comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_staff_payroll WHERE spr_month=? AND spr_year=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$month,$year,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function check_if_guard_payroll_exist($month,$year,$comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_guard_payroll WHERE gpr_month=? AND gpr_year=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$month,$year,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function get_payroll_history_details($comp_id,$mon,$year){
        $com_query = "SELECT sp.*,c.*,s.*,cr.* FROM tbl_staff_payroll sp INNER JOIN tbl_company c ON c.company_id=sp.company_id
                        INNER JOIN tbl_staff s ON s.staff_id=sp.staff_id
                        INNER JOIN tbl_company_roles cr ON cr.comp_role_sno=s.staff_role
                        WHERE sp.company_id=? AND sp.spr_month=? AND sp.spr_year=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss", $comp_id,$mon,$year);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    // public function get_guard_payroll_history_details($comp_id,$mon,$year){
    //     $com_query = "SELECT gp.*,c.*,g.guard_firstname,g.guard_middlename,g.guard_lastname,g.guard_id as grd_id,gd.*,b.*
    //                     FROM tbl_guard_payroll gp 
    //                     INNER JOIN tbl_company c ON c.company_id=gp.company_id
    //                     INNER JOIN tbl_guards g ON g.guard_id=gp.guard_id
    //                     LEFT JOIN tbl_guard_deployments gd ON gd.guard_id=gp.guard_id
    //                     LEFT JOIN tbl_beats b ON b.beat_id=gd.beat_id
    //                     WHERE gp.company_id=? AND gp.gpr_month=? AND gp.gpr_year=? ORDER BY g.guard_firstname ASC";
    //     $com_obj = $this->conn->prepare($com_query);
    //     $com_obj->bind_param("sss", $comp_id,$mon,$year);
    //     if ($com_obj->execute()) {
    //         return $com_obj->get_result();
    //     }
    //     return array();
    // }

    public function get_guard_payroll_history_details($comp_id,$mon,$year){
        $month = date("m", strtotime($mon));
        $com_query = "SELECT gp.*,c.*,g.guard_firstname,g.guard_middlename,g.guard_lastname,g.guard_id as grd_id,gd.*,b.*,dh.* 
                        FROM tbl_guard_payroll gp 
                        INNER JOIN tbl_company c ON c.company_id=gp.company_id
                        INNER JOIN tbl_guards g ON g.guard_id=gp.guard_id
                        LEFT JOIN tbl_guard_deployments gd ON gd.guard_id=gp.guard_id
                        LEFT JOIN tbl_deactivated_history dh ON dh.deh_guard_id=gp.guard_id AND MONTH(dh.deactivated_date)='$month' AND YEAR(dh.deactivated_date)='$year' 
                        LEFT JOIN tbl_beats b ON b.beat_id=gd.beat_id 
                        WHERE gp.company_id=? AND gp.gpr_month=? AND gp.gpr_year=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss", $comp_id,$mon,$year);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }
    
    public function get_active_deployment_payroll_details($comp_id,$mon,$year){
        $month = date("m", strtotime($mon));
        $com_query = "SELECT gp.*,c.*,g.guard_firstname,g.guard_middlename,g.guard_lastname,g.guard_id as grd_id,gd.*,b.beat_name
                        FROM tbl_guard_payroll gp 
                        INNER JOIN tbl_company c ON c.company_id=gp.company_id
                        INNER JOIN tbl_guards g ON g.guard_id=gp.guard_id
                        LEFT JOIN tbl_guard_deployments gd ON gd.guard_id=gp.guard_id
                        LEFT JOIN tbl_beats b ON b.beat_id=gd.beat_id 
                        WHERE gp.company_id=? AND gp.gpr_month=? AND gp.gpr_year=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss", $comp_id,$mon,$year);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }
    
    public function get_deployment_deactivation_history($mon,$year,$guard_id){
        $month = date("m", strtotime($mon));
        $com_query = "SELECT dh.*,b.* FROM tbl_deactivated_history dh 
                        INNER JOIN tbl_beats b ON b.beat_id=dh.deh_beat_id 
                        WHERE dh.deh_guard_id=? AND MONTH(dh.deactivated_date)='$month' AND YEAR(dh.deactivated_date)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$guard_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }
    
    public function get_beat_name_by_deh_beat_id($beat_id){
        $com_query = "SELECT beat_name FROM tbl_beats WHERE beat_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $beat_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['beat_name'];
        }
        return array();
    }
    
    public function get_guard_deactivate_history_limit_1($comp_id,$guard_id,$mon,$year){
        $month = date("m", strtotime($mon));
        $com_query = "SELECT dh.*,b.* FROM tbl_deactivated_history dh 
                        INNER JOIN tbl_beats b ON b.beat_id=dh.deh_beat_id 
                        WHERE dh.deh_company_id=? AND dh.deh_guard_id=? 
                        AND MONTH(dh.deactivated_date)='$month' AND YEAR(dh.deactivated_date)='$year' LIMIT 1";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss", $comp_id,$guard_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result()->fetch_assoc();
        }
        return array();
    }
    
    
    public function get_guard_deactivate_history_for_beat_comm($comp_id,$guard_id){
        $com_query = "SELECT dh.*,b.* FROM tbl_deactivated_history dh 
                        INNER JOIN tbl_beats b ON b.beat_id=dh.deh_beat_id 
                        WHERE dh.deh_company_id=? AND dh.deh_guard_id=? ORDER BY dh.deh_sno DESC LIMIT 1";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss", $comp_id,$guard_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_guard_deactivate_history_all($comp_id,$guard_id,$mon,$year){
        $month = date("m", strtotime($mon));
        $com_query = "SELECT dh.*,b.* FROM tbl_deactivated_history dh 
                        INNER JOIN tbl_beats b ON b.beat_id=dh.deh_beat_id 
                        WHERE dh.deh_company_id=? AND dh.deh_guard_id=? 
                        AND MONTH(dh.deactivated_date)='$month' AND YEAR(dh.deactivated_date)='$year' ORDER BY dh.deh_sno DESC";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss", $comp_id,$guard_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function get_staff_payroll_data_settings($comp_id){
        $com_query = "SELECT * FROM tbl_payroll_settings WHERE company_id=? AND (access_type='Both' OR access_type='Staff')";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function get_guard_payroll_data_settings($comp_id){
        $com_query = "SELECT * FROM tbl_payroll_settings WHERE company_id=? AND (access_type='Both' OR access_type='Guard')";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function get_all_company_beats($comp_id){
        $stf_query = "SELECT b.*,cl.* FROM tbl_beats b INNER JOIN tbl_client cl ON cl.client_id=b.client_id WHERE b.company_id=? AND b.beat_status='Active'";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("s",$comp_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_all_company_beats_by_client_id($comp_id,$client_id){
        $stf_query = "SELECT b.*,cl.* FROM tbl_beats b INNER JOIN tbl_client cl ON cl.client_id=b.client_id 
                WHERE b.company_id=? AND b.beat_status='Active' AND cl.client_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("ss",$comp_id,$client_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_company_penalty_by_offense_title($comp_id,$offense_title){
        $pen_query = "SELECT * FROM tbl_company_penalties p WHERE company_id=? AND offense_name=?";
        $pen_obj = $this->conn->prepare($pen_query);
        $pen_obj->bind_param("ss",$comp_id,$offense_title);
        if ($pen_obj->execute()) {
            return $pen_obj->get_result();
        }
        return array();
    }

    public function check_if_client_invoice_exist($inv_month,$inv_year,$client_id,$comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_invoices WHERE invoice_month=? AND invoice_year=? AND client_id=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssss",$inv_month,$inv_year,$client_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function check_invoice_debit_credit($beat_id,$dc_category,$dc_reason,$client_id,$comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_invoice_debit_credit WHERE company_id=? AND client_id=? AND beat_id=? AND dc_category=? AND dc_reason=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sssss",$comp_id,$client_id,$beat_id,$dc_category,$dc_reason);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function create_beat_invoice($invoice_id,$comp_id,$client_id,$inv_month,$inv_year,$inv_amt,$inv_account,$add_to_invoice,$status,$inv_created_on){
        $com_query = "INSERT INTO tbl_invoices SET invoice_id=?,company_id=?,client_id=?,invoice_month=?,invoice_year=?,invoice_amt=?,invoice_acct=?,add_to_invoice=?,invoice_status=?,invoice_date=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sssssddiss",$invoice_id,$comp_id,$client_id,$inv_month,$inv_year,$inv_amt,$inv_account,$add_to_invoice,$status,$inv_created_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_invoice_debit_credit($comp_id,$client_id,$beat_id,$dc_category,$charge_days_amt,$deb_amt,$no_guard,$month,$year,$dc_reason,$dc_created_on){
        $com_query = "INSERT INTO tbl_invoice_debit_credit SET company_id=?,client_id=?,beat_id=?,dc_category=?,
                        chr_days_amt=?,charge_amt=?,num_of_guard=?,dc_month=?,dc_year=?,dc_reason=?,dc_created_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssssddissss",$comp_id,$client_id,$beat_id,$dc_category,$charge_days_amt,$deb_amt,$no_guard,$month,$year,$dc_reason,$dc_created_on);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_all_client_debit_credit($client_id,$comp_id){
        $com_query = "SELECT * FROM tbl_invoice_debit_credit WHERE company_id=? AND client_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss", $comp_id,$client_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function delete_inv_credit_debit($inv_dc_sno,$comp_id){
        $com_query = "DELETE FROM tbl_invoice_debit_credit WHERE company_id=? AND inv_dc_sno=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("si",$comp_id,$inv_dc_sno);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function invoice_credit_amount($comp_id,$beat_id,$client_id,$month,$year){
        $com_query = "SELECT * FROM tbl_invoice_debit_credit WHERE beat_id=? AND company_id=? AND client_id=? AND dc_category='Credit' 
                        AND dc_month='$month' AND dc_year='$year' LIMIT 1";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$beat_id,$comp_id,$client_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return array();
    }

    public function invoice_debit_amount($comp_id,$beat_id,$client_id,$month,$year){
        $com_query = "SELECT * FROM tbl_invoice_debit_credit WHERE beat_id=? AND company_id=? AND client_id=? AND dc_category='Debit' 
                        AND dc_month='$month' AND dc_year='$year' LIMIT 1";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$beat_id,$comp_id,$client_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return array();
    }

//    public function invoice_credit_amount($comp_id,$beat_id,$client_id,$month,$year){
//        $com_query = "SELECT * FROM tbl_invoice_debit_credit WHERE beat_id=? AND company_id=? AND client_id=? AND dc_category='Credit'
//                        AND dc_month='$month' AND dc_year='$year'";
//        $com_obj = $this->conn->prepare($com_query);
//        $com_obj->bind_param("sss",$beat_id,$comp_id,$client_id);
//        if ($com_obj->execute()){
//            $data = $com_obj->get_result()->fetch_assoc();
//            return $data;
//        }
//        return array();
//    }
//
//    public function invoice_debit_amount($comp_id,$beat_id,$client_id,$month,$year){
//        $com_query = "SELECT * FROM tbl_invoice_debit_credit WHERE beat_id=? AND company_id=? AND client_id=? AND dc_category='Debit'
//                        AND dc_month='$month' AND dc_year='$year'";
//        $com_obj = $this->conn->prepare($com_query);
//        $com_obj->bind_param("sss",$beat_id,$comp_id,$client_id);
//        if ($com_obj->execute()){
//            $data = $com_obj->get_result()->fetch_assoc();
//            return $data;
//        }
//        return array();
//    }

    public function get_all_client_beats($beat_id,$company_id,$client_id){
        $stf_query = "SELECT * FROM tbl_beats WHERE beat_id=? AND company_id=? AND client_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("sss",$beat_id,$company_id,$client_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function create_beat_invoice_details
    (
        $invoice_id, $beat_id, $amt_personnel, $no_of_personnel, $total_due, $credit_charges,$debit_charges,$balance
        ,$beat_VAT, $desc, $inv_month, $inv_year, $inv_created_on
    ) {
        $com_query = "INSERT INTO tbl_invoice_history SET invoice_id=?,beat_id=?,amt_personnel=?,no_of_personnel=?,total_due=?,
                        credit_charges=?,debit_charges=?,balance=?,inv_vat=?,description=?,inv_month=?,inv_year=?,inv_created_on=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param(
        "ssdidddddssss",
        $invoice_id,$beat_id,$amt_personnel,$no_of_personnel,$total_due,$credit_charges,$debit_charges,$balance,
            $beat_VAT,$desc,$inv_month,$inv_year,$inv_created_on
        );
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_all_invoice($comp_id){
        $stf_query = "SELECT i.*,cl.* FROM tbl_invoices i INNER JOIN tbl_client cl ON cl.client_id = i.client_id 
                        WHERE i.company_id=? ORDER BY i.invoice_sno DESC";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("s",$comp_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_all_unpaid_invoice($comp_id){
        $stf_query = "SELECT i.*,cl.* FROM tbl_invoices i INNER JOIN tbl_client cl ON cl.client_id = i.client_id 
                        WHERE i.company_id=? i.invoice_status='Pending' ORDER BY i.invoice_sno DESC";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("s",$comp_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_all_invoice_print_details($invoice_id,$comp_id,$client_id){
        $stf_query = "SELECT ih.*,b.*,i.*,cl.*,c.*,ia.* FROM tbl_invoice_history ih 
                        INNER JOIN tbl_invoices i ON i.invoice_id=ih.invoice_id 
                        INNER JOIN tbl_client cl ON cl.client_id = i.client_id 
                        INNER JOIN tbl_company c ON c.company_id = i.company_id 
                        INNER JOIN tbl_beats b ON b.beat_id=ih.beat_id 
                        INNER JOIN tbl_invoice_accounts ia ON ia.inv_acc_sno=i.invoice_acct  
                         WHERE i.invoice_id=? AND i.company_id=? AND i.client_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("sss",$invoice_id,$comp_id,$client_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_all_client_invoice_history($comp_id,$client_id){
        $stf_query = "SELECT ih.*,b.*,i.*,cl.*,c.* FROM tbl_invoice_history ih 
                        INNER JOIN tbl_invoices i ON i.invoice_id=ih.invoice_id 
                        INNER JOIN tbl_client cl ON cl.client_id = i.client_id 
                        INNER JOIN tbl_company c ON c.company_id = i.company_id 
                        INNER JOIN tbl_beats b ON b.beat_id=ih.beat_id 
                         WHERE i.company_id=? AND i.client_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("ss",$comp_id,$client_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function sum_all_amount_due_client($invoice_id){
        $com_query = "SELECT SUM(balance) as net_pay,SUM(total_due) as total_due,SUM(credit_charges) as credit_charges,
                        SUM(debit_charges) as debit_charges, SUM(inv_vat) as inv_vat FROM tbl_invoice_history WHERE invoice_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$invoice_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function get_all_invoice_history_details($invoice_id){
        $stf_query = "SELECT ih.*,b.*,i.*,cl.* FROM tbl_invoice_history ih 
                        INNER JOIN tbl_beats b ON b.beat_id=ih.beat_id 
                        INNER JOIN tbl_invoices i ON i.invoice_id=ih.invoice_id 
                        INNER JOIN tbl_client cl ON cl.client_id = i.client_id 
                        WHERE ih.invoice_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("s",$invoice_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function delete_inv_histories($invoice_id,$comp_id,$client_id,$invoice_amt){
        $c_curr_balance = $this->get_client_wallet_balance($client_id,$comp_id);
        $new_bal = $c_curr_balance + $invoice_amt;

        $com_query = "DELETE FROM tbl_invoice_history WHERE invoice_id=?";
        $com_query_2 = "DELETE FROM tbl_invoices WHERE company_id=? AND invoice_id=?";
        $com_query_3 = "DELETE FROM tbl_client_ledger WHERE company_id=? AND invoice_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj_2 = $this->conn->prepare($com_query_2);
        $com_obj_3 = $this->conn->prepare($com_query_3);
        $com_obj->bind_param("s",$invoice_id);
        $com_obj_2->bind_param("ss",$comp_id,$invoice_id);
        $com_obj_3->bind_param("ss",$comp_id,$invoice_id);
        if ($com_obj_2->execute()) {
            $com_obj_3->execute();
            if ($com_obj->execute()) {
                $this->update_client_wallet_balance($new_bal,$client_id,$comp_id);
                return true;
            }
            return false;
        }
        return false;
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

    public function delete_payment_receipt($receipt_id,$client_id,$pay_amt,$comp_id){
        $c_curr_balance = $this->get_client_wallet_balance($client_id,$comp_id);
        $new_bal = $c_curr_balance - $pay_amt;

        $com_query = "DELETE FROM tbl_client_confirm_payment WHERE company_id=? AND receipt_id=? ";
        $com_query_3 = "DELETE FROM tbl_client_ledger WHERE company_id=? AND receipt_id=?";

        $com_obj = $this->conn->prepare($com_query);
        $com_obj_3 = $this->conn->prepare($com_query_3);

        $com_obj->bind_param("ss",$comp_id,$receipt_id);
         $com_obj_3->bind_param("ss",$comp_id,$receipt_id);
        if ($com_obj->execute()) {
            $com_obj_3->execute();
             $this->update_client_wallet_balance($new_bal,$client_id,$comp_id);
            return true;
        }
        return false;
    }

    public function get_payment_report($comp_id){
        $stf_query = "SELECT cp.*,cl.* FROM tbl_client_confirm_payment cp INNER JOIN tbl_client cl ON cl.client_id = cp.client_id 
                        WHERE cp.company_id=? ORDER BY cp.id DESC";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("s",$comp_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result();
        }
        return array();
    }

    public function get_client_payment_report_by_receipt_id($comp_id,$receipt_id){
        $stf_query = "SELECT cp.*,cl.*,co.* FROM tbl_client_confirm_payment cp INNER JOIN tbl_client cl ON cl.client_id = cp.client_id 
                        INNER JOIN tbl_company co ON co.company_id = cp.company_id WHERE cp.company_id=? AND cp.receipt_id=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("ss",$comp_id,$receipt_id);
        if ($stf_obj->execute()) {
            return $stf_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function create_company_payroll_settings(
        $comp_id,$payroll_title,$payroll_typ,$access_typ,$payment_mode,$mon_month,$mon_year,$fixed_amount,$payroll_amount,
        $payroll_created_on,$payroll_updated_on
    ){
        $com_query = "INSERT INTO tbl_payroll_settings SET company_id=?,payroll_title=?,payroll_type=?,access_type=?,payment_mode=?,mon_month=?,mon_year=?,
                fixed_amount=?,payroll_amount=?,payroll_created_date=?,payroll_updated_date=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param(
            "sssssssssss",
            $comp_id,$payroll_title,$payroll_typ,$access_typ,$payment_mode,$mon_month,$mon_year,$fixed_amount,$payroll_amount,
            $payroll_created_on,$payroll_updated_on
        );
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function update_company_payroll_settings(
        $payroll_title,$payroll_typ,$access_typ,$payment_mode,$mon_month,$mon_year,$fixed_amount,$payroll_amount,$comp_id,
        $edit_payroll_settings_sno,$payroll_settings_updated_on
    ){
        $com_query = "UPDATE tbl_payroll_settings SET payroll_title=?,payroll_type=?,access_type=?,payment_mode=?,mon_month=?,mon_year=?,fixed_amount=?,
                payroll_amount=?,payroll_updated_date=? WHERE payroll_settings_sno=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param(
            "sssssssssss",
            $payroll_title, $payroll_typ,$access_typ,$payment_mode,$mon_month,$mon_year,$fixed_amount,$payroll_amount,
            $payroll_settings_updated_on,$edit_payroll_settings_sno,$comp_id
        );
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function get_all_payroll_settings($comp_id){
        $com_query = "SELECT * FROM tbl_payroll_settings WHERE company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function delete_payroll_data($payroll_sno,$comp_id){
        $com_query = "DELETE FROM tbl_payroll_settings WHERE company_id=? AND payroll_settings_sno=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("si",$comp_id,$payroll_sno);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^a-z0-9\_\-\.]/i', '', $string); // Removes special chars.
    }

    function dateDiffDays($date1, $date2){
        $date1_ts = strtotime($date1);
        $date2_ts = strtotime($date2);
        $diff = $date2_ts - $date1_ts;
        return round($diff / 86400) +1;
    }

    function dateDiffMonth($date1, $date2){
        //get Date diff as intervals
        $d1 = new DateTime($date1);
        $d2 = new DateTime($date2);
        $interval = $d1->diff($d2);

       return $interval->m +1;
    }

    function dateDiffMonthInv($date1, $date2){
        //get Date diff as intervals
        $d1 = strtotime($date1);
        $d2 = strtotime($date2);
        $totalSecsDiff = abs($d1-$d2);
        $totMonthDiff = $totalSecsDiff/60/60/24/30;
//        $interval = $d1->diff($d2);

       return $totMonthDiff;
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

    public function update_column($table,$column, $value, $id, $unique_column){
        $com_query = "UPDATE $table SET $column=? WHERE $unique_column = ?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("si",$value,$id);

        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return $com_obj->execute();
    }

    public function insert_notifications($comp_id,$n_type,$nf_id,$n_body,$n_urlAction,$n_photo,$n_name){
        $note_body =  array("body"=>$n_body,"actionURL"=>$n_urlAction,"photo"=>$n_photo,"name"=>$n_name);
        $notification = json_encode($note_body);
        $note_date = date("Y-m-d H:i:s");
        $note_id =  rand(100000,999999);

        $com_query = "INSERT INTO tbl_notifications SET company_id=?,note_id=?,note_type=?,notifiable_id=?,note_data=?,note_created_at=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssssss",$comp_id,$note_id,$n_type,$nf_id,$notification,$note_date);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_notifications($comp_id,$limit){
        $com_query = "SELECT * FROM tbl_notifications WHERE company_id=? AND note_status='0' ORDER BY note_sno DESC LIMIT $limit";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function get_all_notifications($comp_id){
        $com_query = "SELECT * FROM tbl_notifications WHERE company_id=? ORDER BY note_sno DESC";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function count_unread_notifications($comp_id){
        $com_query = "SELECT count(*) AS note FROM tbl_notifications WHERE company_id=? AND note_status='0'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['note'];
        }
        return 0;
    }

    public function count_total_client($comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_client WHERE company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_disabled_client($comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_client WHERE company_id=? AND client_status='Deactivate'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_guard($comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_guards WHERE company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_disabled_guard($comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_guards WHERE company_id=? AND guard_status='Deactivate'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_beat($comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_beats WHERE company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_disabled_beat($comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_beats WHERE company_id=? AND beat_status='0'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_staff($comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_staff WHERE company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_disabled_staff($comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_staff WHERE company_id=? AND staff_acc_status='Deactivate'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function update_notification_status($comp_id,$note_id){
        $com_query = "UPDATE tbl_notifications SET note_status='1' WHERE note_id=? AND company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss", $note_id, $comp_id);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_all_company_invoice_account($comp_id){
        $acc_query = "SELECT * FROM tbl_invoice_accounts WHERE company_id=?";
        $acc_obj = $this->conn->prepare($acc_query);
        $acc_obj->bind_param("s", $comp_id);
        if ($acc_obj->execute()) {
            return $acc_obj->get_result();
        }
        return array();
    }

    public function get_active_company_invoice_account($comp_id){
        $acc_query = "SELECT * FROM tbl_invoice_accounts WHERE company_id=? AND inv_account_active='Yes'";
        $acc_obj = $this->conn->prepare($acc_query);
        $acc_obj->bind_param("s", $comp_id);
        if ($acc_obj->execute()) {
            return $acc_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function create_company_invoice_account($c_id,$inv_acc_name,$inv_acc_no,$inv_bank,$inv_created_on){
        $temp_query = "INSERT INTO tbl_invoice_accounts SET company_id=?,inv_account_name=?,inv_account_no=?,inv_bank_name=?,inv_created_on=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssss", $c_id,$inv_acc_name,$inv_acc_no,$inv_bank,$inv_created_on);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function delete_company_invoice_acct_data($inv_acc_sno,$comp_id){
        $acc_query = "DELETE FROM tbl_invoice_accounts WHERE inv_acc_sno=$inv_acc_sno AND company_id='$comp_id'";
        $acc_obj = $this->conn->prepare($acc_query);
        if ($acc_obj->execute()){
            if ($acc_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function update_invoice_account_status($inv_acc_sno,$comp_id){
        $acc_query = "UPDATE tbl_invoice_accounts SET inv_account_active='No' WHERE company_id='$comp_id'";
        $acc_obj = $this->conn->prepare($acc_query);
        if ($acc_obj->execute()){
            // if ($acc_obj->affected_rows > 0){
                $acc_query_2 = "UPDATE tbl_invoice_accounts SET inv_account_active='Yes' WHERE inv_acc_sno=$inv_acc_sno AND company_id='$comp_id'";
                $acc_obj_2 = $this->conn->prepare($acc_query_2);
                if ($acc_obj_2->execute()) {
                    return true;
                } else {
                    return false;
                }
            // }
            // return false;
        }
        return false;
    }

    public function create_beat_personnel_services($c_id,$beat_id,$no_of_personnel,$personnel_type,$personnel_amt){
        $temp_query = "INSERT INTO tbl_beat_personnel_services SET company_id=?,bps_beat=?,no_of_personnel=?,personnel_type=?,amt_per_personnel=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssisd", $c_id,$beat_id,$no_of_personnel,$personnel_type,$personnel_amt);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_beat_personnel_services($comp_id,$beat_id){
        $acc_query = "SELECT * FROM tbl_beat_personnel_services WHERE company_id=? AND bps_beat=?";
        $acc_obj = $this->conn->prepare($acc_query);
        $acc_obj->bind_param("ss", $comp_id,$beat_id);
        if ($acc_obj->execute()) {
            return $acc_obj->get_result();
        }
        return array();
    }
    
    public function get_all_assigned_task($comp_id){
        $acc_query = "SELECT r.*,rs.*,g.*,b.* FROM tbl_guard_routes r 
                        INNER JOIN tbl_routes rs ON rs.route_name=r.g_route_name
                        INNER JOIN tbl_beats b ON b.beat_id=rs.route_beat_id
                        INNER JOIN tbl_guards g ON g.guard_id=r.guard_id WHERE r.company_id=?";
        $acc_obj = $this->conn->prepare($acc_query);
        $acc_obj->bind_param("s", $comp_id);
        if ($acc_obj->execute()) {
            return $acc_obj->get_result();
        }
        return array();
    }

    public function get_all_routes($comp_id){
        $acc_query = "SELECT r.*,b.* FROM tbl_routes r INNER JOIN tbl_beats b ON b.beat_id=r.route_beat_id WHERE r.company_id=?";
        $acc_obj = $this->conn->prepare($acc_query);
        $acc_obj->bind_param("s", $comp_id);
        if ($acc_obj->execute()) {
            return $acc_obj->get_result();
        }
        return array();
    }

    public function get_guard_beat_route_task($comp_id){
        $acc_query = "SELECT r.*,b.* FROM tbl_routes r INNER JOIN tbl_beats b ON b.beat_id=r.route_beat_id WHERE r.company_id=?";
        $acc_obj = $this->conn->prepare($acc_query);
        $acc_obj->bind_param("s", $comp_id);
        if ($acc_obj->execute()) {
            return $acc_obj->get_result();
        }
        return array();
    }

    public function get_route_details($comp_id,$route_name){
        $acc_query = "SELECT * FROM tbl_routes WHERE company_id=? AND route_name=?";
        $acc_obj = $this->conn->prepare($acc_query);
        $acc_obj->bind_param("ss", $comp_id,$route_name);
        if ($acc_obj->execute()) {
            $data = $acc_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function create_beat_route_task($c_id,$guard_id,$routes,$created_at){
        $com_query = "INSERT INTO tbl_guard_routes SET company_id=?,g_route_name=?,guard_id=?,g_route_date=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssss", $c_id,$routes,$guard_id,$created_at);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function delete_assigned_route_task($g_route_sno,$company_id){
        $guard_query = "DELETE FROM tbl_guard_routes WHERE g_route_sno='$g_route_sno' AND company_id='$company_id'";
        $guard_obj = $this->conn->prepare($guard_query);
        if ($guard_obj->execute()){
            if ($guard_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function get_assigned_route_points($route_name,$comp_id){
        $acc_query = "SELECT * FROM tbl_route_points WHERE company_id=? AND route_name=?";
        $acc_obj = $this->conn->prepare($acc_query);
        $acc_obj->bind_param("ss", $comp_id,$route_name);
        if ($acc_obj->execute()) {
            return$acc_obj->get_result();
        }
        return array();
    }
    
    public function get_beat_guard_payroll_history_details($comp_id,$client_id,$beat_id,$mon,$year){
        $com_query = "SELECT gp.*,c.*,g.guard_firstname,g.guard_middlename,g.guard_lastname,g.guard_id as grd_id,gd.*,b.*
                        FROM tbl_guard_payroll gp 
                        INNER JOIN tbl_company c ON c.company_id=gp.company_id
                        INNER JOIN tbl_guards g ON g.guard_id=gp.guard_id
                        LEFT JOIN tbl_guard_deployments gd ON gd.guard_id=gp.guard_id
                        LEFT JOIN tbl_beats b ON b.beat_id=gd.beat_id 
                        WHERE gp.company_id=? AND b.client_id=? AND gd.beat_id=? AND gp.gpr_month=? AND gp.gpr_year=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sssss", $comp_id,$client_id,$beat_id,$mon,$year);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }
    
    public function get_all_company_guard_salary_advance_report_history($comp_id){
        $com_query = "SELECT DISTINCT sa_rh_month,sa_rh_year FROM tbl_gaurd_sa_report_history WHERE sa_rh_company_id=? ORDER BY sa_rh_year desc";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s", $comp_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function check_if_salary_advance_report_exist($month,$year,$comp_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_gaurd_sa_report_history WHERE sa_rh_month=? AND sa_rh_year=? AND sa_rh_company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$month,$year,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function sum_up_guard_sal_adv_amt_per_month_for_report($comp_id,$month,$year){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(salary_adv_amount) as advMonAmt FROM tbl_guard_salary_advance WHERE company_id=? AND MONTH(created_at)='$month' AND YEAR(created_at)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data;
        }
        return 0;
    }

    public function create_salary_advance_report_history($month,$year,$sa_rh_tot_amt,$sa_rh_date,$compId){
        $com_query = "INSERT INTO tbl_gaurd_sa_report_history SET sa_rh_month=?,sa_rh_year=?,sa_rh_tot_amt=?,sa_rh_date=?,sa_rh_company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sssss", $month,$year,$sa_rh_tot_amt,$sa_rh_date,$compId);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function delete_company_guard_sa_report_history($sa_rh_month,$sa_rh_year,$comp_id){
        $com_query = "DELETE FROM tbl_gaurd_sa_report_history WHERE sa_rh_month=? AND sa_rh_year=? AND sa_rh_company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss",$sa_rh_month,$sa_rh_year,$comp_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function get_guard_sa_report_payroll($comp_id,$mon,$year){
        $month = date("m", strtotime($mon));
        $com_query = "SELECT sa.*,c.*,g.*,gd.*,b.* FROM tbl_guard_salary_advance sa 
                        INNER JOIN tbl_company c ON c.company_id=sa.company_id
                        INNER JOIN tbl_guards g ON g.guard_id=sa.guard_id
                        INNER JOIN tbl_guard_deployments gd ON gd.guard_id=sa.guard_id
                        INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id
                        WHERE sa.company_id=? AND MONTH(sa.created_at)=? AND YEAR(sa.created_at)=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sss", $comp_id,$month,$year);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function fetch_guard_in_loan_table($comp_id){
        $com_query = "SELECT gl.*,g.* FROM tbl_guard_loan gl INNER JOIN tbl_guards g ON g.guard_id=gl.guard_id WHERE gl.company_id='$comp_id'";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function fetch_guard_repayment_scheme($comp_id, $g_loan_id,$month,$year){
        $com_query = "SELECT * FROM tbl_guard_loan_repayment 
                    WHERE company_id='$comp_id' AND guard_loan_id='$g_loan_id' AND grd_paid_month='$month' AND grd_paid_year='$year'";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()) {
            return $com_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function fetch_guard_status_table($comp_id,$guard_id){
        $com_query = "SELECT gs.guard_status,gs.guard_id,gs.company_id,gs.remark,gs.created_at AS stat_date,g.*,gd.*,b.* FROM tbl_guard_status gs 
                        INNER JOIN tbl_guard_deployments gd ON gd.guard_id=gs.guard_id 
                        INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id 
                        INNER JOIN tbl_guards g ON g.guard_id=gs.guard_id 
                        WHERE gs.company_id='$comp_id' AND gs.guard_id='$guard_id' ORDER BY gs.id DESC LIMIT 1";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()) {
            return $com_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_inactive_guards($c_id){
        $guard_query = "SELECT * FROM tbl_guards WHERE company_id=? AND guard_status NOT IN('Active')";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("s",$c_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result();
        }
        return array();
    }

    public function get_guard_and_beat_offences($c_id){
        $guard_offence_query = "SELECT gof.*,g.*,op.*,gd.*,b.* FROM tbl_guard_offense gof 
                                INNER JOIN tbl_guard_deployments gd ON gd.guard_id=gof.guard_id 
                                INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id 
                                INNER JOIN tbl_guards g ON g.guard_id=gof.guard_id
                                LEFT JOIN tbl_guard_offense_pardon op ON op.g_par_guard_offense_id=gof.guard_offense_id
                                WHERE gof.company_id=? AND op.g_par_guard_offense_id IS NULL ";
        $guard_offence_obj = $this->conn->prepare($guard_offence_query);
        $guard_offence_obj->bind_param("s", $c_id);
        if ($guard_offence_obj->execute()) {
            return $guard_offence_obj->get_result();
        }
        return array();
    }

    public function get_staff_and_beat_offences($c_id){
        $guard_offence_query = "SELECT sof.*,s.*,op.* FROM tbl_staff_offense sof 
                                INNER JOIN tbl_staff s ON s.staff_id=sof.staff_id
                                LEFT JOIN tbl_staff_offense_pardon op ON op.par_staff_offense_id=sof.staff_offense_id
                                WHERE sof.company_id=? AND op.par_staff_offense_id IS NULL ";
        $guard_offence_obj = $this->conn->prepare($guard_offence_query);
        $guard_offence_obj->bind_param("s", $c_id);
        if ($guard_offence_obj->execute()) {
            return $guard_offence_obj->get_result();
        }
        return array();
    }

    public function get_guard_and_training_abs($c_id){
        $training_abs_query = "SELECT gat.company_id,gat.guard_id,gat.remark_reason,gat.no_of_days,gat.charge_amt,
                                gat.created_at AS abs_date,g.*,gd.*,b.* 
                                FROM tbl_guard_absent_training gat 
                                INNER JOIN tbl_guard_deployments gd ON gd.guard_id=gat.guard_id 
                                INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id 
                                INNER JOIN tbl_guards g ON g.guard_id=gat.guard_id
                                WHERE gat.company_id=?";
        $training_abs_obj = $this->conn->prepare($training_abs_query);
        $training_abs_obj->bind_param("s", $c_id);
        if ($training_abs_obj->execute()) {
            return $training_abs_obj->get_result();
        }
        return array();
    }

    public function get_guard_extra_duty_report($c_id){
        $ext_duty_query = "SELECT ged.company_id,ged.beat_id,ged.guard_id,ged.guard_replace,ged.reason_remark,ged.no_of_days,
                                ged.days_amount,ged.created_at AS exd_date,b.*
                                FROM tbl_guard_extra_duty ged 
                                INNER JOIN tbl_beats b ON b.beat_id=ged.beat_id 
                                WHERE ged.company_id=?";
        $ext_duty_obj = $this->conn->prepare($ext_duty_query);
        $ext_duty_obj->bind_param("s", $c_id);
        if ($ext_duty_obj->execute()) {
            return $ext_duty_obj->get_result();
        }
        return array();
    }

    public function get_guard_name_for_extra_duty($c_id,$g_id){
        $guard_query = "SELECT CONCAT(guard_firstname,' ',guard_middlename,' ',guard_lastname) AS full_name FROM tbl_guards 
                        WHERE company_id=? AND guard_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ss",$c_id,$g_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_payment_confirmation_report($c_id){
        $cl_query = "SELECT c.*,l.* FROM tbl_client_ledger l 
                        INNER JOIN tbl_client c ON c.client_id=l.client_id WHERE l.company_id=? AND l.payment_method !='Invoice'";
        $cl_obj = $this->conn->prepare($cl_query);
        $cl_obj->bind_param("s",$c_id);
        if ($cl_obj->execute()) {
            return $cl_obj->get_result();
        }
        return array();
    }

    public function get_newly_posted_guard_report($c_id){
        $gd_query = "SELECT CONCAT(g.guard_firstname,' ',g.guard_middlename,' ',g.guard_lastname) AS full_name,
                    gd.company_id,gd.guard_id,gd.dop,gd.commencement_date,gd.observation_start ,gd.beat_id,gd.created_at AS gd_date,b.* 
                    FROM tbl_guard_deployments gd 
                    INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id 
                    INNER JOIN tbl_guards g ON g.guard_id=gd.guard_id
                    WHERE gd.company_id=?";
        $gd_obj = $this->conn->prepare($gd_query);
        $gd_obj->bind_param("s", $c_id);
        if ($gd_obj->execute()) {
            return $gd_obj->get_result();
        }
        return array();
    }

    public function get_guard_uniform_deduction_report($c_id,$month,$year){
        $int_mon = date("m", strtotime($month));
        $cl_query = "SELECT 
                       CONCAT(g.guard_firstname,' ',g.guard_middlename,' ',g.guard_lastname) AS full_name,g.guard_id,
                       gd.guard_id AS gd_guard_id,b.beat_name,ik.kit_type,ik.monthly_charge,ik.created_at as kit_dated
                       FROM tbl_issue_guard_kit ik 
                      INNER JOIN tbl_guards g ON g.guard_id=ik.guard_id
                      INNER JOIN tbl_guard_deployments gd ON ik.guard_id=gd.guard_id
                      INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id
                       WHERE ik.company_id=? AND MONTH(ik.created_at)='$int_mon' AND YEAR(ik.created_at)='$year'";
        $cl_obj = $this->conn->prepare($cl_query);
        $cl_obj->bind_param("s",$c_id);
        if ($cl_obj->execute()) {
            return $cl_obj->get_result();
        }
        return array();
    }
    
    public function get_guard_clock_in_out_report($c_id){
//        $int_mon = date("m", strtotime($month));
        $cl_query = "SELECT sa.at_id,sa.company_id,sa.guard_id,sa.clock_in_time,sa.clock_out_time,
                        sa.created_at AS clk_date,gd.*,g.*,b.*,cl.* FROM tbl_send_attendance sa 
                      INNER JOIN tbl_guard_deployments gd ON gd.guard_id=sa.guard_id
                      INNER JOIN tbl_guards g ON g.guard_id=gd.guard_id
                      INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id
                      INNER JOIN tbl_client cl ON cl.client_id=b.client_id
                       WHERE sa.company_id=? ORDER BY sa.created_at DESC";
        $cl_obj = $this->conn->prepare($cl_query);
        $cl_obj->bind_param("s",$c_id);
        if ($cl_obj->execute()) {
            return $cl_obj->get_result();
        }
        return array();
    }

    public function count_total_clock_in_today($c_id){
        $com_query = "SELECT COUNT(DISTINCT guard_id) AS myCount FROM tbl_send_attendance WHERE company_id=? AND 
                            date_format(str_to_date(created_at, '%d-%m-%Y'), '%Y-%m-%d') = CURDATE()";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$c_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_clock_in_this_month($c_id){
        $com_query = "SELECT COUNT(DISTINCT guard_id) AS myCount FROM tbl_send_attendance WHERE company_id=? AND 
                            date_format(str_to_date(created_at, '%d-%m-%Y'), '%m') = MONTH(CURDATE()) 
	                        AND date_format(str_to_date(created_at, '%d-%m-%Y'), '%Y') = YEAR(CURDATE())";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$c_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function get_guard_absentee_report($c_id){
        $cl_query = "SELECT gd.*,g.*,b.*,cl.* FROM tbl_guard_deployments gd 
                      INNER JOIN tbl_guards g ON g.guard_id=gd.guard_id
                      INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id
                      INNER JOIN tbl_client cl ON cl.client_id=b.client_id
                      WHERE gd.company_id=?";
        $cl_obj = $this->conn->prepare($cl_query);
        $cl_obj->bind_param("s",$c_id);
        if ($cl_obj->execute()) {
            return $cl_obj->get_result();
        }
        return array();
    }

    public function check_if_guard_clock_in($guard_id,$selectedDate,$c_id){
        $cl_query = "SELECT * FROM tbl_send_attendance WHERE guard_id=? 
            AND date_format(str_to_date(created_at, '%d-%m-%Y'), '%d-%m-%Y')=? AND company_id=?";
        $cl_obj = $this->conn->prepare($cl_query);
        $cl_obj->bind_param("sss",$guard_id,$selectedDate,$c_id);
        if ($cl_obj->execute()) {
            return $cl_obj->get_result()->fetch_assoc();
        }
        return array();
    }
    
    public function get_guard_by_id_proll($guard_id, $c_id){
        $guard_query = "SELECT g.*,d.guard_id AS g_id,d.g_dep_salary,d.beat_id,d.commencement_date,b.* FROM tbl_guards g 
                        LEFT JOIN tbl_guard_deployments d ON d.guard_id=g.guard_id
                        LEFT JOIN tbl_beats b ON b.beat_id=d.beat_id
                        WHERE g.guard_id=? AND g.company_id=? LIMIT 1";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ss",$guard_id, $c_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result()->fetch_assoc();
        }
        return array();
    }
    
    public function check_if_guard_is_deployed($guard_id,$month,$year,$comp_id){
        $int_mon = date("m", strtotime($month));
        $days_month = cal_days_in_month(CAL_GREGORIAN,date("m",strtotime($month."-".$year)),$year);
        $test_date = $days_month.'-'.$int_mon.'-'.$year;
        $full_date = date("Y-m-d", strtotime($test_date));
        $guard_query = "SELECT * FROM tbl_guard_deployments WHERE guard_id=? AND company_id=? AND commencement_date <= '$full_date' "; 
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ss",$guard_id, $comp_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result()->fetch_assoc();
        }
        return array();
    }
    
    public function check_if_guard_as_deactivate_history($guard_id,$month,$year,$comp_id){
        $int_mon = date("m", strtotime($month)); 
        $guard_query = "SELECT * FROM tbl_deactivated_history WHERE deh_guard_id=? AND deh_company_id=? AND MONTH(deactivated_date)='$int_mon' AND YEAR(deactivated_date)='$year' LIMIT 1";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ss",$guard_id, $comp_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result()->fetch_assoc();
        }
        return array();
    }
    
    public function get_guard_clockin_attempt_logs($comp_id){
        $cl_query = "SELECT cf.*,g.*,b.* FROM tbl_clock_in_failed_attempt cf 
                      INNER JOIN tbl_guards g ON g.guard_id=cf.guard_id
                      INNER JOIN tbl_beats b ON b.beat_id=cf.beat_id
                      WHERE cf.company_id=?";
        $cl_obj = $this->conn->prepare($cl_query);
        $cl_obj->bind_param("s",$comp_id);
        if ($cl_obj->execute()) {
            return $cl_obj->get_result();
        }
        return array();
    }

}

$company = new Company();
?>