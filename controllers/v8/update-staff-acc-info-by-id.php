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
    $staff_sno = htmlspecialchars(strip_tags($_POST['staff_sno'])); 
    $staff_id = htmlspecialchars(strip_tags($_POST['staff_id']));
    $stf_email = htmlspecialchars(strip_tags($_POST['email']));
    $stf_accBnk = htmlspecialchars(strip_tags($_POST['accBnk']));
    $stf_accName = htmlspecialchars(strip_tags($_POST['accName']));
    $stf_accNo = htmlspecialchars(strip_tags($_POST['accNo']));
    $stf_salary = htmlspecialchars(strip_tags($_POST['salary']));

    if (!empty($staff_sno) && !empty($stf_accBnk) && !empty($stf_accName) && !empty($stf_accNo) && !empty($stf_salary)) {
        $user_data = $company->get_staff_details_by_email($stf_email,$c['company_id']);
        if (!empty($user_data)) {
            if (isset($_SESSION['COMPANY_LOGIN'])){
                $result = $company->update_staff_acc_info_by_id($c['company_id'],$staff_sno,$stf_accBnk,$stf_accName,$stf_accNo,$stf_salary);
                if ($result==true) {
                    $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Update a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." profile",
                        url_path('/company/edit-staff/'.$staff_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Your account profile has been successfully updated."));
                } else if ($result=="no_change"){
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update profile, no changes found."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update profile."));
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
                    $result = $company->update_staff_acc_info_by_id($c['company_id'],$staff_sno,$stf_accBnk,$stf_accName,$stf_accNo,$stf_salary);
                    if ($result==true) {
                        $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Update a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." profile",
                            url_path('/company/edit-staff/'.$staff_id,true,true), $c['staff_photo'],$c['staff_name']
                        );
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Your account profile has been successfully updated."));
                    } else if ($result=="no_change"){
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Failed to update profile, no changes found."));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Failed to update profile."));
                    }
                }
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Staff profile cannot be retrieve / disabled account."));
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