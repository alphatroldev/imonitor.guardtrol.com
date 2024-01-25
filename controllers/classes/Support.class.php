<?php ob_start(); session_status()?null:session_start();
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');
date_default_timezone_set('Africa/Lagos'); // WAT
class Support
{
    public $conn;
    private $tbl_support;

    //constructor
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
        $this->tbl_support = "tbl_support";
    }

    public function check_email($email){
        $email_query = "SELECT * FROM tbl_support WHERE support_email=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_company_email($email){
        $email_query = "SELECT * FROM tbl_staff WHERE staff_email=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function create_support_instance($s_id,$s_name,$s_email,$s_type,$s_status,$s_password,$s_created) {
        $pass = password_hash($s_password, PASSWORD_DEFAULT);
        $sup_query_2 = "INSERT INTO tbl_support SET support_id=?,support_name=?,support_email=?,support_super=?,support_active=?,support_password=?,support_created_on=?";
        $sup_obj_2 = $this->conn->prepare($sup_query_2);
        $sup_obj_2->bind_param("sssssss", $s_id,$s_name,$s_email,$s_type,$s_status,$pass,$s_created);
        if ($sup_obj_2->execute()) {
            return true;
        }
        return false;
    }

    public function login_support($s_email) {
        $sup_query = "SELECT * FROM tbl_support WHERE support_email=?";
        $sup_obj = $this->conn->prepare($sup_query);
        $sup_obj->bind_param("s",$s_email);
        if ($sup_obj->execute()){
            return $sup_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_support_by_sno($s_id){
        $com_query = "SELECT * FROM tbl_support WHERE support_sno=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("i",$s_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function get_support_by_id($s_id){
        $com_query = "SELECT * FROM tbl_support WHERE support_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("i",$s_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function update_support_profile($s_id,$sup_name,$sup_email,$sup_super){
        $com_query = "UPDATE tbl_support SET support_name=?,support_email=?,support_super=? WHERE support_sno=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sssi",$sup_name,$sup_email,$sup_super,$s_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_support_password($new_pwd,$s_id){
        $sup_query = "UPDATE tbl_support SET support_password=? WHERE support_sno=?";
        $sup_obj = $this->conn->prepare($sup_query);
        $sup_obj->bind_param("ss",$new_pwd,$s_id);
        if ($sup_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_all_support_account($s_id){
        $sup_query = "SELECT * FROM tbl_support WHERE support_sno <>$s_id AND support_sno<>1";
        $sup_obj = $this->conn->prepare($sup_query);
        if ($sup_obj->execute()) {
            return $sup_obj->get_result();
        }
        return array();
    }

    public function update_support_status($status,$s_id){
        $sup_query = "UPDATE tbl_support SET support_active='$status' WHERE support_id='$s_id'";
        $sup_obj = $this->conn->prepare($sup_query);
        if ($sup_obj->execute()){
            if ($sup_obj->affected_rows > 0){return true;}
            return false;
        }
        return false;
    }

    public function delete_support($s_id){
        $sup_query = "DELETE FROM tbl_support WHERE support_id='$s_id'";
        $sup_obj = $this->conn->prepare($sup_query);
        if ($sup_obj->execute()){
            if ($sup_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function update_support_profile_by_id($sup_id,$sup_name,$sup_email,$sup_super,$sup_active){
        $com_query = "UPDATE tbl_support SET support_name=?,support_email=?,support_super=?,support_active=? WHERE support_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("sssss",$sup_name,$sup_email,$sup_super,$sup_active,$sup_id);
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_support_password_by_id($new_pwd,$s_id){
        $sup_query = "UPDATE tbl_support SET support_password=? WHERE support_id=?";
        $sup_obj = $this->conn->prepare($sup_query);
        $sup_obj->bind_param("ss",$new_pwd,$s_id);
        if ($sup_obj->execute()) {
            return true;
        }
        return false;
    }

    public function create_company_instance(
        $c_id,$c_name,$c_email,$c_address,$c_phone,$c_descr, $c_guard_str,$c_op_state,$c_op_number,
        $c_reg_no,$c_tax_id,$c_password,$c_logo,$c_op_license,$c_created_on
    ) {
        $pass = password_hash($c_password, PASSWORD_DEFAULT);
        $s_id = rand(1000000, 9999999);
        $role = '0';
        $type = 'Owner';
        $sup_query = "INSERT INTO tbl_company SET company_id=?,company_name=?,company_email=?,company_address=?,company_phone=?,
                    company_description=?,company_gd_strg=?,company_op_state=?,company_no_op_state=?,company_rc_no=?,company_tax_id_no=?,
                    company_logo=?,company_op_license=?,com_created_at=?";
        $sup_obj = $this->conn->prepare($sup_query);
        $sup_obj->bind_param(
            "ssssssssssssss",
            $c_id,$c_name,$c_email,$c_address,$c_phone,$c_descr, $c_guard_str,$c_op_state,$c_op_number,
            $c_reg_no,$c_tax_id,$c_logo,$c_op_license,$c_created_on
        );
        if ($sup_obj->execute()) {
            if ($this->create_staff_self($c_id,$s_id,$c_name,$c_phone,$c_email,$pass,$role,$type,'Active')){
                return true;
            }
            return false;
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

    public function get_all_company_account(){
        $sup_query = "SELECT s.*,c.* FROM tbl_company c INNER JOIN tbl_staff s ON c.company_id=s.company_id WHERE s.staff_type='Owner' ORDER BY c.company_sno DESC";
        $sup_obj = $this->conn->prepare($sup_query);
        if ($sup_obj->execute()) {
            return $sup_obj->get_result();
        }
        return array();
    }

    public function get_company_by_id($c_id){
        $com_query = "SELECT s.*,c.* FROM tbl_company c INNER JOIN tbl_staff s ON c.company_id=s.company_id WHERE s.company_id=? AND s.staff_type='Owner'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$c_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
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

    public function update_company_profile_by_id(
        $company_sno,$staff_id,$c_name,$c_email,$c_address,$c_phone,$c_description,$c_guard_str,
        $c_op_state, $c_op_number, $c_reg_no, $c_tax_id
    ){
        $com_query = "UPDATE tbl_company SET company_name=?,company_email=?,company_address=?,company_phone=?,company_description=?,
                company_gd_strg=?,company_op_state=?,company_no_op_state=?,company_rc_no=?,company_tax_id_no=? WHERE company_sno=? ";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param(
            "ssssssssssi",
            $c_name,$c_email,$c_address,$c_phone,$c_description,$c_guard_str,
            $c_op_state, $c_op_number, $c_reg_no, $c_tax_id,$company_sno
        );
        if ($com_obj->execute()) {
            if ($com_obj->affected_rows > 0){
                $this->update_comp_staff_profile_by_id($c_name,$c_phone,$c_email,$staff_id);
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_comp_staff_profile_by_id($s_fname,$s_phone,$s_email,$staff_id){
        $com_query = "UPDATE tbl_staff SET staff_firstname=?,staff_phone=?,staff_email=? WHERE staff_id=? ";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ssss",$s_fname,$s_phone,$s_email,$staff_id);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_company_by_email($c_email){
        $com_query = "SELECT c.*,s.* FROM tbl_company c INNER JOIN tbl_staff s ON c.company_id=s.company_id WHERE c.company_email=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$c_email);
        if ($com_obj->execute()){
            return $com_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function update_company_password_by_id($new_pwd, $staff_id){
        $com_query = "UPDATE tbl_staff SET staff_password=? WHERE staff_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$new_pwd,$staff_id);
        if ($com_obj->execute()) {
            return true;
        }
        return false;
    }

    public function delete_company($c_sno){
        $com_query = "DELETE FROM tbl_company WHERE company_sno=$c_sno";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()){
            if ($com_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function update_company_status($status,$c_sno,$c_id,$s_id){
        $com_query = "UPDATE tbl_company SET company_status='$status' WHERE company_sno=$c_sno";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()){
            if ($com_obj->affected_rows > 0){
                $this->update_company_staff_status($status,$c_id,$s_id);
                return true;
            }
            return false;
        }
        return false;
    }

    public function update_company_staff_status($status,$c_id,$s_id){
        if($status==1){
            $sta = 'Active';
        } else if ($status==0){
            $sta = 'Deactivate';
        }
        $com_query = "UPDATE tbl_staff SET staff_acc_status='$sta' WHERE staff_id='$s_id' AND company_id='$c_id'";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()){
            if ($com_obj->affected_rows > 0){return true;}
            return false;
        }
        return false;
    }

    public function count_total_company(){
        $com_query = "SELECT count(*) AS myCount FROM tbl_company";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_disabled_company(){
        $com_query = "SELECT count(*) AS myCount FROM tbl_company WHERE company_status='0'";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }
    
    public function insert_new_apk_version($apk_file_name,$apk_imp,$apk_version,$apk_file){
        $date = date("Y-m-d H:i:s");
        $temp_query = "INSERT INTO tbl_mobile_app_updates SET app_name=?,apk_importance=?,apk_version=?,apk_file=?,mob_created=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssss", $apk_file_name,$apk_imp,$apk_version,$apk_file,$date);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_all_new_apk_versions(){
        $com_query = "SELECT * FROM tbl_mobile_app_updates";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()){
            return $com_obj->get_result();
        }
        return array();
    } 
    
    public function test_cronjob_entry(){
        $date = date("Y-m-d H:i:s");
        $temp_query = "INSERT INTO cron_test SET name='Test Ayokunle',date='$date'";
        $temp_obj = $this->conn->prepare($temp_query);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

}

$support= new Support();
?>