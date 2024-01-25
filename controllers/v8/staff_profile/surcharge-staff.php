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
    $offense_title = htmlspecialchars(strip_tags($_POST['offense_title']));
    $charge_mode = htmlspecialchars(strip_tags($_POST['charge_mode']));
    $charge_days = htmlspecialchars(strip_tags($_POST['charge_days']));
    $charge_amt = htmlspecialchars(strip_tags($_POST['charge_amt']));
    $charge_reason = htmlspecialchars(strip_tags($_POST['charge_reason']));
    
    $d = new DateTime($_POST['offense_date']);
    $calendar_days = cal_days_in_month(CAL_GREGORIAN, $d->format('m'), $d->format('Y'));

    $staff_id = htmlspecialchars(strip_tags($_POST['staff_id']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $su_created_on = date("Y-m-d H:i:s", strtotime($_POST['offense_date']));

    if (!empty($offense_title) && !empty($charge_mode) && !empty($charge_reason) && !empty($su_created_on)) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $s_data = $company->create_staff_surcharge($offense_title,$charge_mode,$charge_days,$charge_amt,$charge_reason,$staff_id,$comp_id,$su_created_on);
            if ($s_data) {
                $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Surcharge a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname'],
                    url_path('/company/edit-staff/'.$staff_id,true,true), $c['staff_photo'],$c['staff_name']
                );
                $staff->insert_staff_log(
                    $comp_id,$staff_id,"Info", "Surcharge Staff",$su_created_on,
                    $s_det['staff_firstname']." ".$s_det['staff_lastname']." was surcharge for ".$offense_title,$charge_reason
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Surcharge has been successfully saved."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Server error, could not save surcharge"));
            }
        }else{
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_book_staff_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            } else{
                $s_data = $company->create_staff_surcharge($offense_title,$charge_mode,$charge_days,$charge_amt,$charge_reason,$staff_id,$comp_id,$su_created_on);
                if ($s_data) {
                $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Surcharge a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname'],
                    url_path('/company/edit-staff/'.$staff_id,true,true), $c['staff_photo'],$c['staff_name']
                );
                $staff->insert_staff_log(
                    $comp_id,$staff_id,"Info", "Surcharge Staff",$su_created_on,
                    $s_det['staff_firstname']." ".$s_det['staff_lastname']." was surcharge for ".$offense_title,$charge_reason
                );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Surcharge has been successfully saved."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Server error, could not save surcharge"));
                }
            }
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