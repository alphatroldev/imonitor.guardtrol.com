<?php ob_start(); session_status()?null:session_start();
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');
date_default_timezone_set('Africa/Lagos'); // WAT
class Supervisor {
    public $conn;
    private $tbl_supervisor;

    //constructor
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
        $this->tbl_supervisor = "tbl_supervisor";
    }

    public function check_beat_supervisor_email($email){
        $email_query = "SELECT * FROM tbl_beat_supervisor WHERE bsu_email=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function login_supervisor($s_email) {
        $sup_query = "SELECT * FROM tbl_beat_supervisor WHERE bsu_email=?";
        $sup_obj = $this->conn->prepare($sup_query);
        $sup_obj->bind_param("s",$s_email);
        if ($sup_obj->execute()){
            return $sup_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_supervisor_by_id($bsu_id){
        $com_query = "SELECT * FROM tbl_beat_supervisor WHERE bsu_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("i",$bsu_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result();
        }
        return array();
    }

    public function update_beat_supervisor($bs_email,$bs_firstname,$bs_lastname,$bs_id){
        $bsu_query = "UPDATE tbl_beat_supervisor SET bsu_email=?,bsu_firstname=?,bsu_lastname=? WHERE bsu_id=?";
        $bsu_obj = $this->conn->prepare($bsu_query);
        $bsu_obj->bind_param("ssss",$bs_email,$bs_firstname,$bs_lastname,$bs_id);
        if ($bsu_obj->execute()) {
            if ($bsu_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }
    

    public function count_supervisor_total_guard($comp_id, $beat_str){
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

    public function count_supervisor_total_clock_in_today($c_id, $beat_str){
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
    
    public function count_supervisor_total_complete_route_today($c_id, $beat_str){
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
    
     public function count_supervisor_total_incomplete_route_today($c_id, $beat_str){
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

    public function count_supervisor_total_clock_in_this_month($c_id, $beat_str){
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

    public function get_company_by_id($company_id){
        $com_query = "SELECT * FROM tbl_company WHERE company_id=?";
        $com_obj = $this->conn->prepare($com_query);
        $com_obj->bind_param("s",$company_id);
        if ($com_obj->execute()) {
            return $com_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function get_supervisor_guard_clock_in_out_report($c_id, $beat_str){
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
    
     public function get_guard_clockout_request($c_id, $beat_str){
        $array=array_map('intval', explode(',', $beat_str));
        $array = implode("','",$array);
        $cl_query = "SELECT cr.*,g.*,b.*,cl.* FROM tbl_beat_supervisor_guard_clockout_request cr 
                      INNER JOIN tbl_guards g ON g.guard_id=cr.guard_id
                      INNER JOIN tbl_beats b ON b.beat_id=cr.beat_id
                      INNER JOIN tbl_client cl ON cl.client_id=b.client_id
                      WHERE cr.company_id=? AND cr.beat_id IN ('".$array."') ORDER BY cr.created_on DESC";
        $cl_obj = $this->conn->prepare($cl_query);
        $cl_obj->bind_param("s",$c_id);
        if ($cl_obj->execute()) {
            return $cl_obj->get_result();
        }
        return array();
    }

    public function get_supervisor_guard_routing_report($c_id, $beat_str) {
        $array=array_map('intval', explode(',', $beat_str));
        $array = implode("','",$array);

        // GROUP BY brt.guard_id,brt.start_time,brt.route_id 
        $cl_query = "SELECT brt.cr_sno,brt.company_id,brt.route_id,brt.guard_id,brt.route_status,brt.start_time,
                        brt.end_time,brt.cp_created_on,r.route_name,gd.*,g.*,b.*,cl.* FROM tbl_beat_routing_task brt 
                        INNER JOIN tbl_routes r ON r.route_id=brt.route_id
                        INNER JOIN tbl_guard_deployments gd ON gd.guard_id=brt.guard_id
                        INNER JOIN tbl_guards g ON g.guard_id=gd.guard_id
                        INNER JOIN tbl_beats b ON b.beat_id=gd.beat_id
                        INNER JOIN tbl_client cl ON cl.client_id=b.client_id 
                        
                        WHERE brt.company_id=? AND gd.beat_id IN ('".$array."') ORDER BY brt.start_time DESC";
        $cl_obj = $this->conn->prepare($cl_query);
        $cl_obj->bind_param("s",$c_id);
        if ($cl_obj->execute()) {
            return $cl_obj->get_result();
        }
        return array();
    }
    
    

    public function update_guard_clockout_request_status($request_id,$request_status){
        $bsu_query = "UPDATE tbl_beat_supervisor_guard_clockout_request SET request_status=? WHERE request_id=?";
        $bsu_obj = $this->conn->prepare($bsu_query);
        $bsu_obj->bind_param("ss",$request_status,$request_id);
        if ($bsu_obj->execute()) {
            if ($bsu_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

}

$supervisor = new Supervisor();
?>