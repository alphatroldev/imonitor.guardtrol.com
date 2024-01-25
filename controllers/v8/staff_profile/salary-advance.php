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
    $sa_amt = htmlspecialchars(strip_tags($_POST['salary_adv_amount']));
    $sa_reason = htmlspecialchars(strip_tags($_POST['salary_adv_reason']));


    $staff_id = htmlspecialchars(strip_tags($_POST['staff_id']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));

    $sa_created_on = date("Y-m-d H:i:s");

    if (!empty($sa_amt) && !empty($sa_reason) && !empty($sa_created_on)) {
        $res = $company->check_salary_adv_not_exceed_basic_salary($comp_id,$staff_id,$sa_amt);
        if ($res) {
            if (isset($_SESSION['COMPANY_LOGIN'])){
                $s_data = $company->create_staff_salary_advance($comp_id, $staff_id, $sa_reason, $sa_amt, $sa_created_on, $sa_created_on);
                if ($s_data) {
                    $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Issue a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." salary advance",
                        url_path('/company/salary-advance',true,true), $c['staff_photo'],$c['staff_name']
                    );
                    $staff->insert_staff_log(
                        $comp_id,$staff_id,"Info", "Issue Salary Adv.",$sa_created_on,
                        $s_det['staff_firstname']." ".$s_det['staff_lastname']." was issue a salary advance of #".$sa_amt,$sa_reason
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Salary advance has been successfully saved."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Server error, could not save salary advance"));
                }
            }else{
                $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                $permission_sno = $privileges->get_update_staff_permission_id();
                $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

                if(!in_array($permission_sno['perm_sno'], $array)){
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                } else{
                    $s_data = $company->create_staff_salary_advance($comp_id, $staff_id, $sa_reason, $sa_amt, $sa_created_on, $sa_created_on);
                    if ($s_data) {
                        $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Issue a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." salary advance",
                            url_path('/company/salary-advance',true,true), $c['staff_photo'],$c['staff_name']
                        );
            
                        $staff->insert_staff_log(
                            $comp_id,$staff_id,"Info", "Issue Salary Adv.",$sa_created_on,
                            $s_det['staff_firstname']." ".$s_det['staff_lastname']." was issue a salary advance of #".$sa_amt,$sa_reason
                        );
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Salary advance has been successfully saved."));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Server error, could not save salary advance"));
                    }
                }
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"You salary advance has exceeded your monthly basic salary."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>