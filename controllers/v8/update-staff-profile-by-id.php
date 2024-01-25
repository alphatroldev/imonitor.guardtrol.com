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
} else {
    $c = get_staff();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $staff_sno = htmlspecialchars(strip_tags($_POST['staff_sno']));
    $stf_fname = htmlspecialchars(strip_tags($_POST['firstname']));
    $stf_lname = htmlspecialchars(strip_tags($_POST['lastname']));
    $stf_email = htmlspecialchars(strip_tags($_POST['email']));
    $stf_role = htmlspecialchars(strip_tags($_POST['staff_role']));
    $stf_status = htmlspecialchars(strip_tags($_POST['stf_status']));

    $c_id = htmlspecialchars(strip_tags($_SESSION['COMPANY_LOGIN']['company_id']));


    if (!empty($staff_sno) && !empty($stf_fname) && !empty($stf_lname) && !empty($stf_email) && !empty($stf_role) && !empty($stf_status)) {
        $user_data = $company->get_staff_details_by_email($stf_email,$c_id);
        if (!empty($user_data)) {
            $result = $company->update_staff_profile_by_id($staff_sno,$stf_fname,$stf_lname,$stf_email,$stf_role,$stf_status);
            if ($result==true) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Your account profile has been successfully updated."));
            } else if ($result=="no_change"){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Failed to update profile, no changes found."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Failed to update profile."));
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