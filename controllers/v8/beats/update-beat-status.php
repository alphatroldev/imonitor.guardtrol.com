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
    $bt_st_status = htmlspecialchars(strip_tags($_POST['bt_st_status']));
    $bt_st_beat_id = htmlspecialchars(strip_tags($_POST['bt_st_beat_id']));
    $bt_st_comp_id = htmlspecialchars(strip_tags($_POST['bt_st_comp_id']));
    $bt_st_remark = htmlspecialchars(strip_tags($_POST['bt_st_remark']));
    $st_date = htmlspecialchars(strip_tags($_POST['bt_st_date']));
    $bt_st_date = date("Y-m-d H:i:s",strtotime($st_date));


    if (!empty($bt_st_status) && !empty($bt_st_beat_id) && !empty($bt_st_comp_id) && !empty($bt_st_remark) && !empty($bt_st_date)) {
        if (isset($_SESSION['COMPANY_LOGIN'])) {
            if ($beat->update_beat_status($bt_st_status,$bt_st_beat_id,$bt_st_comp_id,$bt_st_remark,$bt_st_date)) {
                if ($bt_st_status == "Deactivate") {
                    $beat->delete_all_deployments_by_beat_id($c['company_id'], $bt_st_beat_id);
                }
                $g_det = $beat->get_beat_details_by_id($bt_st_beat_id);
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Updated beat: ".$g_det['beat_name']." status",
                    url_path('/company/list-beats',true,true), $c['staff_photo'],$c['staff_name']
                );

                $beat->insert_beat_log(
                    $bt_st_beat_id,$c['company_id'],$g_det['client_id'],"Info", "Beat Status",
                    $bt_st_date,$g_det['beat_name']." status was change to ".$bt_st_status,$bt_st_remark
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Beat status updated.",
                    "location"=>url_path('/company/list-beats',true,true),
                    "location2"=>url_path('/company/inactive-beats',true,true)
                ));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Unable to update beat status."));
            }
        } else {
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_update_beat_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            } else {
                if ($beat->update_beat_status($bt_st_status,$bt_st_beat_id,$bt_st_comp_id,$bt_st_remark,$bt_st_date)) {
                    if ($bt_st_status == "Deactivate") {
                        $beat->delete_all_deployments_by_beat_id($c['company_id'], $bt_st_beat_id);
                    }
                    $g_det = $beat->get_beat_details_by_id($bt_st_beat_id);
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Updated beat: ".$g_det['beat_name']." status",
                        url_path('/company/list-beats',true,true), $c['staff_photo'],$c['staff_name']
                    );
                    $beat->insert_beat_log(
                        $bt_st_beat_id,$c['company_id'],$g_det['client_id'],"Info", "Beat Status",
                        $bt_st_date,$g_det['beat_name']." status was change to ".$bt_st_status,$bt_st_remark
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Beat status updated.",
                        "location"=>url_path('/staff/list-beats',true,true),
                        "location2"=>url_path('/staff/inactive-beats',true,true)
                    ));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Unable to update beat status."));
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