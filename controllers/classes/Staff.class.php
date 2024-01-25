<?php ob_start(); session_status()?null:session_start();
// namespace App;
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');
date_default_timezone_set('Africa/Lagos'); // WAT

class Staff {
    public $conn;
    private $tbl_company;

    //constructor
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function staff_login($email) {
        $email_query = "SELECT s.*,c.* FROM tbl_staff s INNER JOIN tbl_company c ON c.company_id=s.company_id WHERE s.staff_email=? AND s.staff_acc_status='Active'";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s",$email);
        if ($user_obj->execute()){
            return $user_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function check_staff_email($email){
        $email_query = "SELECT * FROM tbl_staff WHERE staff_email=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_staff_by_sno($s_sno){
        $email_query = "SELECT s.*,r.*,con.*,c.* FROM tbl_staff s INNER JOIN tbl_company c ON c.company_id=s.company_id
                        INNER JOIN tbl_company_roles r ON r.comp_role_sno=s.staff_role 
                        INNER JOIN tbl_company_config con ON con.con_company_id=r.company_id 
                        WHERE s.staff_sno=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("i", $s_sno);
        if ($user_obj->execute()) {
            return $user_obj->get_result();
        }
        return array();
    }

    public function update_staff_personal_profile($s_sno,$stf_fname,$stf_mname,$stf_lname,$stf_phone,$stf_email){
        $stf_query = "UPDATE tbl_staff SET staff_firstname=?,staff_middlename=?,staff_lastname=?,staff_phone=? ,staff_email=? WHERE staff_sno=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("sssssi",$stf_fname,$stf_mname,$stf_lname,$stf_phone,$stf_email,$s_sno);
        if ($stf_obj->execute()) {
            if ($stf_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_staff_personal_password($new_pwd,$staff_sno){
        $stf_query = "UPDATE tbl_staff SET staff_password=? WHERE staff_sno=?";
        $stf_obj = $this->conn->prepare($stf_query);
        $stf_obj->bind_param("si",$new_pwd,$staff_sno);
        if ($stf_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_staff_details_by_staff_id($staff_id){
        $s_query = "SELECT * FROM tbl_staff WHERE staff_id=?";
        $s_obj = $this->conn->prepare($s_query);
        $s_obj->bind_param("s",$staff_id);
        if ($s_obj->execute()) {
            $data = $s_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function insert_staff_log($c_id,$staff_id,$act_type,$action_title,$act_date,$act_msg,$act_rea){
        $temp_query = "INSERT INTO tbl_staff_logs SET company_id=?,staff_id=?,action_type=?,action_title=?,action_date=?,action_message=?,action_reason=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssssss", $c_id,$staff_id,$act_type,$action_title,$act_date,$act_msg,$act_rea);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_staff_logs($staff_id){
        $s_query = "SELECT * FROM tbl_staff_logs WHERE staff_id=?";
        $s_obj = $this->conn->prepare($s_query);
        $s_obj->bind_param("s",$staff_id);
        if ($s_obj->execute()) {
            return $s_obj->get_result();
        }
        return array();
    }

}

$staff = new Staff();