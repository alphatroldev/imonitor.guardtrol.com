<?php ob_start(); session_status()?null:session_start();
// namespace App;
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');
date_default_timezone_set('Africa/Lagos'); // WAT
class DeployGuard
{
    public $conn;
    private $tbl_guard_deployments;

    //constructor
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }




    public function get_deployed_guard($guard_id){
        $role_query = "SELECT * FROM tbl_guard_deployments
                        WHERE guard_id=?";
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("s", $guard_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function get_num_deployed_guard($guard_id){
        $role_query = "SELECT * FROM tbl_guard_deployments
                        WHERE guard_id=?";
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("s", $guard_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();

    }

    public function get_norminal_roll($c_id){
        $roll_query = "SELECT gd.*,g.* FROM tbl_guard_deployments gd INNER JOIN tbl_guards g ON g.guard_id=gd.guard_id 
						WHERE gd.company_id=? AND g.guard_status='Active' ORDER BY gd.beat_id ASC";
        $roll_obj = $this->conn->prepare($roll_query);
        $roll_obj->bind_param("s", $c_id);
        if ($roll_obj->execute()) {
            return $roll_obj->get_result();
        }
        return array();
    }

    public function get_inactive_norminal_roll($c_id){
        $roll_query = "SELECT gd.*,g.* FROM tbl_guard_deployments gd INNER JOIN tbl_guards g ON g.guard_id=gd.guard_id 
						WHERE gd.company_id=? AND g.guard_status='Deactivate' ORDER BY gd.beat_id ASC";
        $roll_obj = $this->conn->prepare($roll_query);
        $roll_obj->bind_param("s", $c_id);
        if ($roll_obj->execute()) {
            return $roll_obj->get_result();
        }
        return array();
    }

    public function get_beat_info($beat_id){
        $beat_query = "SELECT * FROM tbl_beats
                        WHERE beat_id=?";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("s", $beat_id);
        if ($beat_obj->execute()) {
            return $beat_obj->get_result();
        }
        return array();
    }

    public function get_guard_info($guard_id){
        $guard_query = "SELECT * FROM tbl_guards
                        WHERE guard_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("s", $guard_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result();
        }
        return array();
    }


    public function get_client_info($client_id){
        $client_query = "SELECT * FROM tbl_client
                        WHERE client_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("s", $client_id);
        if ($client_obj->execute()) {
            return $client_obj->get_result();
        }
        return array();
    }


    public function get_guard_position_info($guard_position_id){
        $guard_position_query = "SELECT * FROM tbl_guard_positions
                        WHERE pos_sno=?";
        $guard_position_obj = $this->conn->prepare($guard_position_query);
        $guard_position_obj->bind_param("s", $guard_position_id);
        if ($guard_position_obj->execute()) {
            return $guard_position_obj->get_result();
        }
        return array();
    }


    public function get_shift_info($shift_id){
        $shift_query = "SELECT * FROM tbl_company_shifts
                        WHERE shift_id=?";
        $shift_obj = $this->conn->prepare($shift_query);
        $shift_obj->bind_param("s", $shift_id);
        if ($shift_obj->execute()) {
            return $shift_obj->get_result();
        }
        return array();
    }

    public function get_guard_beat($guard_id){
        $guard_beat_query = "SELECT * FROM tbl_guard_deployments WHERE guard_id=?";
        $guard_beat_obj = $this->conn->prepare($guard_beat_query);
        $guard_beat_obj->bind_param("s", $guard_id);
        if ($guard_beat_obj->execute()) {
            return $guard_beat_obj->get_result();
        }
        return array();
    }


    public function get_guard_beat_name($beat_id){
        $guard_beat_query = "SELECT * FROM tbl_beats
                        WHERE beat_id=?";
        $guard_beat_obj = $this->conn->prepare($guard_beat_query);
        $guard_beat_obj->bind_param("s", $beat_id);
        if ($guard_beat_obj->execute()) {
            return $guard_beat_obj->get_result();
        }
        return array();
    }

    public function get_guard_client_name($client_id){
        $guard_client_query = "SELECT * FROM tbl_client
                        WHERE client_id=?";
        $guard_client_obj = $this->conn->prepare($guard_client_query);
        $guard_client_obj->bind_param("s", $client_id);
        if ($guard_client_obj->execute()) {
            return $guard_client_obj->get_result();
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
    
    public function update_guard_status_by_gid($status,$guard_id){
        $guard_status_query = "UPDATE tbl_guards SET guard_status='$status' WHERE guard_id='$guard_id'";
        $guard_status_obj = $this->conn->prepare($guard_status_query);
        if ($guard_status_obj->execute()){
            if ($guard_status_obj->affected_rows > 0){return true;}
            return false;
        }
        return false;
    }

    public function deploy_guard(
        $c_id,$guard, $beat,$date_of_deploy,$observe_start, $observe_end, $commence_date,
         $paid_observe,$guard_position, $guard_shift, $guard_salary,$num_days_worked, $status,$created_at
    ){
        $temp_query = "INSERT INTO tbl_guard_deployments SET
                    company_id=?,guard_id=?,beat_id=?,dop=?,observation_start=?,observation_end=?,commencement_date=?,
                    paid_observation=?,g_position=?,g_shift=?,g_dep_salary=?,gd_status=?,number_of_days_worked=?,created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssssssssssdsis",
            $c_id,$guard, $beat, $date_of_deploy, $observe_start,$observe_end,$commence_date,
            $paid_observe,$guard_position,$guard_shift,$guard_salary,$status,$num_days_worked,$created_at);
        if ($temp_obj->execute()) {
            $this->update_guard_status_by_gid("Active",$guard);
            return true;
        }
        return false;
    }

    public function update_guard_deployment(
        $c_id, $id,$beat,$date_of_deploy,$observe_start,$observe_end,$commence_date,
        $paid_observe,$guard_position, $guard_shift, $guard_salary,$num_days_worked, $updated_at)
    {
        $guard_query = "UPDATE tbl_guard_deployments SET 
            beat_id=?,dop=?,observation_start=?,observation_end=?,commencement_date=?,
            paid_observation=?,g_position=?,g_shift=?,g_dep_salary=?,number_of_days_worked=?,updated_at=? WHERE gd_id=? AND company_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ssssssssdisis",
            $beat,$date_of_deploy,$observe_start,$observe_end,$commence_date,
            $paid_observe,$guard_position,$guard_shift,$guard_salary,$num_days_worked,$updated_at,$id,$c_id);
        if ($guard_obj->execute()) {
            if ($guard_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function delete_nominal_roll($id) {
        $nominal_roll_query = "DELETE FROM tbl_guard_deployments WHERE gd_id=$id";
        $nominal_roll_obj = $this->conn->prepare($nominal_roll_query);
        if ($nominal_roll_obj->execute()){
            if ($nominal_roll_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function get_guard_by_id($guard_id, $c_id){
        $guard_query = "SELECT * FROM tbl_guards WHERE guard_id=? AND company_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ss",$guard_id, $c_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result();
        }
        return array();
    }


    public function get_guard_deploy_by_guard_id($guard_id, $c_id){
        $guard_query = "SELECT * FROM tbl_guard_deployments WHERE guard_id=? AND company_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ss",$guard_id, $c_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result();
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

    public function update_guard_section_one(
        $c_id,
        $id,$guard_name,
        $guard_height,$guard_sex,
        $guard_phone,$guard_phone_2,
        $referral,$referral_name,$referral_address,
        $referral_fee,$referral_phone,
        $guard_next_of_kin_name,$guard_next_of_kin_phone,
        $guard_next_of_kin_relationship,
        $vetting,$guard_state_of_origin,
        $guard_religion,$guard_qualification,
        $guard_dob,$guard_nickname,
        $guard_address,
        $updated_at){
        $guard_query = "UPDATE tbl_guards SET 
        guard_name=?,
        height=?,sex=?,
        phone=?,phone2=?,
        referral=?,referral_name=?,
        referral_phone=?,referral_address=?,
        referral_fee=?,	next_kin_name=?,
        next_kin_phone=?,next_kin_relationship=?,
        vetting=?,state_of_origin=?,
        religion=?, qualification=?,dob=?,
        nickname=?,guard_address=?, updated_at=? WHERE id=? AND company_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("sssssssssssssssssssssis",
            $guard_name,
            $guard_height,$guard_sex,
            $guard_phone,$guard_phone_2,
            $referral,$referral_name,
            $referral_phone, $referral_address,
            $referral_fee,$guard_next_of_kin_name,
            $guard_next_of_kin_phone,$guard_next_of_kin_relationship,
            $vetting,
            $guard_state_of_origin,
            $guard_religion,$guard_qualification,
            $guard_dob,$guard_nickname,
            $guard_address,
            $updated_at, $id, $c_id);
        if ($guard_obj->execute()) {
            if ($guard_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_guard_section_two($c_id,$id,$guarantor_title,
                                             $guarantor_full_name,$guarantor_sex,
                                             $guarantor_phone,$guarantor_email,
                                             $guarantor_address,$guarantor_years_of_relationship,$guarantor_place_of_work,
                                             $guarantor_rank,$guarantor_work_address,
                                             $guarantor_id_Type,
                                             $guarantor_photo_save,
                                             $guarantor_idcard_front_save,
                                             $guarantor_idcard_back_save,
                                             $updated_at){
        $guard_query = "UPDATE tbl_guards SET 
        guarantor_title=?,guarantor_name=?,
        guarantor_sex=?,guarantor_phone=?,
        guarantor_email=?,guarantor_address=?,
        guarantor_year_relationship=?,
        guarantor_work_place=?,guarantor_rank=?,
        guarantor_work_address=?,guarantor_id_type=?,
        guarantor_photo=?,guarantor_id_front=?,
        guarantor_id_back=?,updated_at=? 
        WHERE id=? AND company_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("sssssssssssssssis",$guarantor_title,
            $guarantor_full_name,$guarantor_sex,
            $guarantor_phone,$guarantor_email,
            $guarantor_address,$guarantor_years_of_relationship,$guarantor_place_of_work,
            $guarantor_rank,$guarantor_work_address,
            $guarantor_id_Type,
            $guarantor_photo_save,
            $guarantor_idcard_front_save,
            $guarantor_idcard_back_save,
            $updated_at, $id, $c_id);
        if ($guard_obj->execute()) {
            if ($guard_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_guard_section_three($c_id, $id,$client_id,$guard_id_Type,
                                               $guard_bank,$guard_acct_number,
                                               $guard_acct_name,$guard_position,
                                               $beat,$guard_date_of_deployment,$guard_salary,
                                               $guard_blood_group,$guard_shift,
                                               $guard_remark,
                                               $guard_photo_save,
                                               $guard_id_front_save,
                                               $guard_id_back_save,
                                               $guard_signature_save,
                                               $updated_at){
        $guard_query = "UPDATE tbl_guards SET
        client_id=?, 
        guard_id_type=?,bank=?,
        account_number=?,account_name=?,
        guard_position=?,beat_id=?,
        date_deployment=?,salary=?,
        blood_group=?,shift=?,
        remark=?,guard_photo=?,
        guard_id_front=?,guard_id_back=?,
        guard_signature=?,updated_at=? 
        WHERE id=? AND company_id=?";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("sssssssssssssssssis",
            $client_id,
            $guard_id_Type,
            $guard_bank,$guard_acct_number,
            $guard_acct_name,$guard_position,
            $beat,$guard_date_of_deployment,$guard_salary,
            $guard_blood_group,$guard_shift,
            $guard_remark,
            $guard_photo_save,
            $guard_id_front_save,
            $guard_id_back_save,
            $guard_signature_save,
            $updated_at, $id, $c_id);
        if ($guard_obj->execute()) {
            if ($guard_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function create_guard_position($pos_type,$pos_title,$comp_id,$created_at){
        $temp_query = "INSERT INTO tbl_guard_positions SET company_id=?,pos_type=?,pos_title=?,pos_created_on=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssss",$comp_id,$pos_type,$pos_title,$created_at);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function update_guard_position($edit_pos_type,$edit_pos_title,$edit_comp_id,$edit_pos_sno){
        $temp_query = "UPDATE tbl_guard_positions SET pos_type=?,pos_title=? WHERE company_id=? AND pos_sno=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssss",$edit_pos_type,$edit_pos_title,$edit_comp_id,$edit_pos_sno);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function delete_guard_position($edit_comp_id,$edit_pos_sno){
        $temp_query = "DELETE FROM tbl_guard_positions WHERE company_id=? AND pos_sno=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ss",$edit_comp_id,$edit_pos_sno);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_deployed_guards_by_beat_id($beat_id,$comp_id){
        $guard_query = "SELECT gd.*,g.* FROM tbl_guard_deployments gd 
                        INNER JOIN tbl_guards g ON gd.guard_id=g.guard_id 
                        WHERE gd.beat_id=? AND gd.company_id=? AND g.guard_status='Active'";
        $guard_obj = $this->conn->prepare($guard_query);
        $guard_obj->bind_param("ss",$beat_id, $comp_id);
        if ($guard_obj->execute()) {
            return $guard_obj->get_result();
        }
        return array();
    }

    public function count_guard_deploy_beat_active($beat_id,$comp_id){
        // $g_query = "SELECT count(*) as myCount FROM tbl_guard_deployments INNER JOIN tbl_guard_positions ON 
        //             tbl_guard_positions.pos_sno=tbl_guard_deployments.g_position 
        //             INNER JOIN tbl_guards ON tbl_guard_deployments.guard_id = tbl_guards.guard_id
        //             WHERE tbl_guard_deployments.beat_id=? AND tbl_guard_deployments.company_id=? AND tbl_guards.guard_status='Active'";
        $g_query = "SELECT count(*) as myCount FROM tbl_guard_deployments gd INNER JOIN tbl_guards g ON g.guard_id = gd.guard_id
                    WHERE gd.beat_id=? AND gd.company_id=? AND gd.gd_status='Active' AND g.guard_status='Active'";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("ss",$beat_id,$comp_id);
        if ($g_obj->execute()) {
            $data = $g_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return array();
    }

//    public function

    public function get_beat_by_id($beat_id, $c_id){
        $client_query = "SELECT * FROM tbl_beats WHERE beat_id=? AND company_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("ss",$beat_id, $c_id);
        if ($client_obj->execute()) {
            return $client_obj->get_result()->fetch_assoc();
        }
        return array();
    }
    
    public function sum_up_guard_redeployment_amt_per_month($guard_id,$month,$year,$comp_id){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(paid_amount) as Amt FROM tbl_redeployment_payment WHERE guard_id=? AND company_id=? AND MONTH(redeploy_date)='$month' AND YEAR(redeploy_date)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['Amt'];
        }
        return 0;
    }
    
    public function sum_up_guard_redeployment_days_per_month($guard_id,$month,$year,$comp_id){
        $month = date("m", strtotime($month));
        $com_query = "SELECT SUM(re_days_worked) as days FROM tbl_redeployment_payment WHERE guard_id=? AND company_id=? AND MONTH(redeploy_date)='$month' AND YEAR(redeploy_date)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$guard_id,$comp_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['days'];
        }
        return 0;
    }
    
    public function get_guard_redeployment_details($comp_id,$guard_id,$mon,$year){
        $month = date("m", strtotime($mon));
        $com_query = "SELECT rp.*,g.*,b.* FROM tbl_redeployment_payment rp 
                        INNER JOIN tbl_guards g ON rp.guard_id=g.guard_id 
                        INNER JOIN tbl_beats b ON b.beat_id=rp.beat_id 
                        WHERE rp.company_id=? AND rp.guard_id=? AND  MONTH(rp.redeploy_date)='$month' AND YEAR(rp.redeploy_date)='$year'";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("ss",$comp_id,$guard_id);
        if ($com_obj->execute()){
            $data = $com_obj->get_result();
            return $data;
        }
        return array();
    }
}

$deploy_guard = new DeployGuard();
?>