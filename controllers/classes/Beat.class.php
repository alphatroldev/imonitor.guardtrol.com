<?php ob_start(); session_status()?null:session_start();
// namespace App;
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');
date_default_timezone_set('Africa/Lagos'); // WAT
class Beat
{
    public $conn;
    private $tbl_beats;

    //constructor
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function get_all_company_clients($c_id){
        $role_query = "SELECT * FROM tbl_client
                        WHERE company_id=? AND client_status ='Active'";;
        $role_obj = $this->conn->prepare($role_query);
        $role_obj->bind_param("s", $c_id);
        if ($role_obj->execute()) {
            return $role_obj->get_result();
        }
        return array();
    }

    public function check_beat_name($beat_name,$client_id,$c_id){
        $check_name_query = "SELECT * FROM tbl_beats WHERE beat_name=? AND client_id=? AND company_id=?";
        $beat_obj = $this->conn->prepare($check_name_query);
        $beat_obj->bind_param("sss", $beat_name,$client_id,$c_id);
        if ($beat_obj->execute()) {
            $data = $beat_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_beat_name_for_update($beat_name,$client_id, $c_id, $beat_sno){
        $check_beat_name_query = "SELECT * FROM tbl_beats WHERE beat_name=? AND client_id=? AND company_id=? AND beat_sno NOT IN('$beat_sno')";
        $user_obj = $this->conn->prepare($check_beat_name_query);
        $user_obj->bind_param("sss", $beat_name,$client_id, $c_id);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function create_beat(
        $beat_id, $c_id, $client_id, $beat_name, $beat_address,$beat_monthly_charges, $beat_status, $beat_vat,
        $date_of_deployment, $created_at
    ){
        $temp_query = "INSERT INTO tbl_beats SET beat_id=?,company_id=?,client_id=?,beat_name=?,beat_address=?,
                        beat_monthly_charges=?,beat_status=?,beat_vat_config=?,date_of_deployment=?,created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssssssssss", $beat_id, $c_id, $client_id, $beat_name, $beat_address,
            $beat_monthly_charges, $beat_status, $beat_vat,$date_of_deployment,$created_at);
        if ($temp_obj->execute()) {
            $this->beat_status_on_beat_create($c_id,$beat_id,"Active","Newly created beat",$date_of_deployment);
            return true;
        }
        return false;
    }

    public function beat_status_on_beat_create($c_id,$beat_id,$status,$remark,$created_at){
        $temp_query = "INSERT INTO tbl_beat_status SET company_id=?,beat_id=?,beat_status=?,bt_remark=?,bt_st_created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssss", $c_id,$beat_id, $status, $remark, $created_at);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
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

    public function get_active_beat_with_guard($c_id, $beat_id){
        $beat_query = "SELECT COUNT(*) AS myCount FROM tbl_guard_deployments gd
                    INNER JOIN tbl_guard_positions gp ON gp.pos_sno = gd.g_position
                    INNER JOIN tbl_guards g ON g.guard_id = gd.guard_id
                    WHERE gd.company_id=? AND gd.gd_status='Active' AND g.guard_status='Active' AND gd.beat_id =?
                    AND gp.pos_type ='Guard'";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("ss",$c_id, $beat_id);
        if ($beat_obj->execute()) {
            $data = $beat_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function get_beat_personnel($c_id, $beat_id){
        $beat_query = "SELECT SUM(no_of_personnel) AS mySum FROM tbl_beat_personnel_services WHERE company_id=? AND bps_beat =?";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("ss",$c_id, $beat_id);
        if ($beat_obj->execute()) {
            $data = $beat_obj->get_result()->fetch_assoc();
            return $data['mySum'];
        }
        return 0;
    }

    public function get_beat_personnel_details($beat_id, $comp_id){
        $beat_query = "SELECT beat_monthly_charges AS mySum FROM tbl_beats WHERE company_id=? AND beat_id=?";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("ss",$comp_id, $beat_id);
        if ($beat_obj->execute()) {
            $data = $beat_obj->get_result()->fetch_assoc();
            return $data['mySum'];
        }
        return 0;
    }

    public function get_active_beat_with_super($c_id, $beat_id){
        $beat_query = "SELECT COUNT(*) AS myCount FROM tbl_guard_deployments gd
                    INNER JOIN tbl_guard_positions gp ON gp.pos_sno = gd.g_position
                    INNER JOIN tbl_guards g ON g.guard_id = gd.guard_id
                    WHERE gd.company_id=? AND gd.gd_status='Active' AND g.guard_status='Active' AND gd.beat_id =?
                    AND gp.pos_type ='Head Guard'";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("ss",$c_id, $beat_id);
        if ($beat_obj->execute()) {
            $data = $beat_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function get_inactive_beats($c_id){
        $beat_query = "SELECT * FROM tbl_beats WHERE company_id=? AND beat_status NOT IN('Active')";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("s",$c_id);
        if ($beat_obj->execute()) {
            return $beat_obj->get_result();
        }
        return array();
    }

    public function get_client_info($client_id){
        $client_name_query = "SELECT * FROM tbl_client WHERE client_id=?";
        $client_name_obj = $this->conn->prepare($client_name_query);
        $client_name_obj->bind_param("s",$client_id);
        if ($client_name_obj->execute()) {
            return $client_name_obj->get_result();
        }
        return array();
    }

    public function update_beat_status($status,$beat_id,$c_id,$remark,$created){
        $temp_query = "INSERT INTO tbl_beat_status SET company_id=?,beat_id=?,beat_status=?,bt_remark=?,bt_st_created_at=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("sssss", $c_id,$beat_id, $status, $remark, $created);
        if ($temp_obj->execute()) {
            $beat_status_query = "UPDATE tbl_beats SET beat_status='$status' WHERE beat_id='$beat_id'";
            $beat_status_obj = $this->conn->prepare($beat_status_query);
            if ($beat_status_obj->execute()) {
                if ($beat_status_obj->affected_rows > 0) {
                    $get_beat_id_query = "SELECT beat_id FROM tbl_beats WHERE beat_id='$beat_id'";
                    $beat_id_obj = $this->conn->prepare($get_beat_id_query);
                    $beat_id_obj->execute();
                    $beat_id_obj->Store_result();
                    $beat_id_obj->bind_result($beat_id);
                    $beat_id_obj->fetch();

                    // $guard_status_update_query = "UPDATE tbl_guards SET guard_status='$status' WHERE beat_id='$beat_id'";
                    // $guard_obj = $this->conn->prepare($guard_status_update_query);
                    // $guard_obj->execute();

                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    public function delete_beat($b_sno,$beat_id) {
        $client_query = "DELETE FROM tbl_beats WHERE beat_sno=$b_sno";
        $client_query_2 = "DELETE FROM tbl_beat_personnel_services WHERE bps_beat='$beat_id'";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj_2 = $this->conn->prepare($client_query_2);
        if ($client_obj->execute()){
            if ($client_obj->affected_rows > 0){
                $client_obj_2->execute();
                return true;
            }
            return false;
        }
        return false;
    }

    public function get_beat_by_id($beat_id, $c_id){
        $client_query = "SELECT * FROM tbl_beats WHERE beat_id=? AND company_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("ss",$beat_id, $c_id);
        if ($client_obj->execute()) {
            return $client_obj->get_result();
        }
        return array();
    }

    public function update_beats(
        $c_id,$beat_sno,$edit_beat_name,$edit_beat_address,$edit_beat_monthly_charges, $edit_beat_vat,$edit_date_of_deployment, $updated_at){

        $client_query = "UPDATE tbl_beats SET beat_name=?,beat_address=?,beat_monthly_charges=?, beat_vat_config=?,
                                date_of_deployment=?,updated_at=? WHERE beat_sno=? AND company_id=?";
        $client_obj = $this->conn->prepare($client_query);
        $client_obj->bind_param("ssssssis",$edit_beat_name, $edit_beat_address, $edit_beat_monthly_charges, $edit_beat_vat,
            $edit_date_of_deployment,$updated_at, $beat_sno, $c_id);
        if ($client_obj->execute()) {
            if ($client_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function get_all_beats($c_id,$client_id){
        $beat_query = "SELECT * FROM tbl_beats WHERE company_id=? AND client_id=?";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("ss",$c_id,$client_id);
        if ($beat_obj->execute()) {
            return $beat_obj->get_result();
        }
        return array();
    }

    public function insert_beat_log($beat_id,$c_id,$client_id,$act_type,$action_title,$act_date,$act_msg,$act_rea){
        $temp_query = "INSERT INTO tbl_beat_logs SET 
                beat_id=?,company_id=?,client_id=?,action_type=?,action_title=?,action_date=?,action_message=?,action_reason=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssssssss", $beat_id,$c_id,$client_id,$act_type,$action_title,$act_date,$act_msg,$act_rea);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_guard_details_by_id($guard_id,$beat_id){
        $g_query = "SELECT g.*,b.*,gd.* FROM tbl_guards g 
                    INNER JOIN tbl_guard_deployments gd ON gd.guard_id=g.guard_id
                    INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id
                    WHERE g.guard_id=? AND gd.beat_id=?";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("ss",$guard_id,$beat_id);
        if ($g_obj->execute()) {
            $data = $g_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_beat_details_by_id($beat_id){
        $g_query = "SELECT * FROM tbl_beats WHERE beat_id=?";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("s",$beat_id);
        if ($g_obj->execute()) {
            $data = $g_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_guard_details_by_deploy_id($deploy_id){
        $g_query = "SELECT g.*,b.*,gd.* FROM tbl_guard_deployments gd 
                    INNER JOIN tbl_guards g ON gd.guard_id=g.guard_id
                    INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id
                    WHERE gd.gd_id=?";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("s",$deploy_id);
        if ($g_obj->execute()) {
            $data = $g_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_beat_logs($beat_id){
        $g_query = "SELECT * FROM tbl_beat_logs WHERE beat_id=?";
        $g_obj = $this->conn->prepare($g_query);
        $g_obj->bind_param("s",$beat_id);
        if ($g_obj->execute()) {
            return $g_obj->get_result();
        }
        return array();
    }

    public function delete_beat_personnel_services($c_id,$beat_id) {
        $client_query_2 = "DELETE FROM tbl_beat_personnel_services WHERE company_id='$c_id' AND bps_beat='$beat_id'";
        $client_obj_2 = $this->conn->prepare($client_query_2);
        if ($client_obj_2->execute()){
            return true;
        }
        return false;
    }

    public function get_all_beat_personnel($c_id, $beat_id) {
        $beat_query = "SELECT * FROM tbl_beat_personnel_services WHERE company_id=? AND bps_beat =?";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("ss",$c_id, $beat_id);
        if ($beat_obj->execute()) {
            return $beat_obj->get_result();
        }
        return array();
    }
    
    public function delete_all_deployments_by_beat_id($c_id,$beat_id) {
        $client_query_2 = "DELETE FROM tbl_guard_deployments WHERE company_id='$c_id' AND beat_id='$beat_id'";
        $client_obj_2 = $this->conn->prepare($client_query_2);
        if ($client_obj_2->execute()){
            return true;
        }
        return false;
    }

    public function get_beats_long_lat($c_id){
        $beat_query = "SELECT br.*,b.* FROM tbl_beat_loc_reg br INNER JOIN tbl_beats b ON b.beat_id=br.bl_beat_id WHERE br.company_id=?";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("s",$c_id);
        if ($beat_obj->execute()) {
            return $beat_obj->get_result();
        }
        return array();
    }

    public function get_beats_first_long_lat($c_id){
        $beat_query = "SELECT beat_loc_long,beat_loc_lati FROM tbl_beat_loc_reg WHERE company_id=? LIMIT 1";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("s",$c_id);
        if ($beat_obj->execute()) {
            return $beat_obj->get_result()->fetch_assoc();
        }
        return array();
    }
    
    public function get_all_beat_supervisors($c_id){
        $beat_query = "SELECT * FROM tbl_beat_supervisor WHERE bsu_company_id=?";
        $beat_obj = $this->conn->prepare($beat_query);
        $beat_obj->bind_param("s",$c_id);
        if ($beat_obj->execute()) {
            return $beat_obj->get_result();
        }
        return array();
    }

    public function create_beat_supervisor($bsu_id,$comp_id,$bs_email,$bs_firstname,$bs_lastname,$bs_beat_str,$bs_pwd,$created_on){
        $pwd = password_hash($bs_pwd, PASSWORD_DEFAULT);
        $bsu_query = "INSERT INTO tbl_beat_supervisor SET bsu_id=?,bsu_company_id=?,bsu_email=?,bsu_firstname=?,bsu_lastname=?,
                        bsu_beats=?,bsu_password=?,bsu_created_at=?";
        $bsu_obj = $this->conn->prepare($bsu_query);
        $bsu_obj->bind_param("ssssssss", $bsu_id,$comp_id,$bs_email,$bs_firstname,$bs_lastname,$bs_beat_str,$pwd,$created_on);
        if ($bsu_obj->execute()) {
            return true;
        }
        return false;
    }

    public function delete_beat_supervisor($bsu_id) {
        $bsu_query = "DELETE FROM tbl_beat_supervisor WHERE bsu_id='$bsu_id'";
        $bsu_obj = $this->conn->prepare($bsu_query);
        if ($bsu_obj->execute()){
            if ($bsu_obj->affected_rows > 0){
                return true;
            }
            return false;
        }
        return false;
    }

    public function get_beat_supervisor_by_id($bsu_id,$c_id){
        $bsu_query = "SELECT * FROM tbl_beat_supervisor WHERE bsu_id=? AND bsu_company_id=?";
        $bsu_obj = $this->conn->prepare($bsu_query);
        $bsu_obj->bind_param("ss",$bsu_id, $c_id);
        if ($bsu_obj->execute()) {
            return $bsu_obj->get_result();
        }
        return array();
    }

    public function update_beat_supervisor($bs_email,$bs_firstname,$bs_lastname,$bs_beat_str,$bs_id){
        $bsu_query = "UPDATE tbl_beat_supervisor SET bsu_email=?,bsu_firstname=?,bsu_lastname=?, bsu_beats=? WHERE bsu_id=?";
        $bsu_obj = $this->conn->prepare($bsu_query);
        $bsu_obj->bind_param("sssss",$bs_email,$bs_firstname,$bs_lastname,$bs_beat_str,$bs_id);
        if ($bsu_obj->execute()) {
            if ($bsu_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_beat_supervisor_password($bs_pwd,$bs_id){
        $pwd = password_hash($bs_pwd, PASSWORD_DEFAULT);
        $bsu_query = "UPDATE tbl_beat_supervisor SET bsu_password=? WHERE bsu_id=?";
        $bsu_obj = $this->conn->prepare($bsu_query);
        $bsu_obj->bind_param("ss",$pwd,$bs_id);
        if ($bsu_obj->execute()) {
            if ($bsu_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

}

$beat = new Beat();
?>