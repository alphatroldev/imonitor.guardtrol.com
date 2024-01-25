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
$updated_at = date("Y-m-d H:i:s");


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    // if (trim($data->action_code) == '101' && !empty(trim($data->id))) {
    //     if ($guard->update_guard_status($data->active,$data->id)) {
    //         http_response_code(200);
    //         echo json_encode(array("status" => 1, "message" => "Guard status updated.",
    //             "location"=>url_path('/company/list-guards',true,true),
    //             "location2"=>url_path('/company/inactive-guards',true,true)));
    //     } else {
    //         http_response_code(200);
    //         echo json_encode(array("status" => 0, "message" => "Unable to update Guard status."));
    //     }
    // }

    if (trim($data->action_code) == '102' && !empty(trim($data->id))) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $g_det = $beat->get_guard_details_by_deploy_id($data->id);
            $beat->insert_beat_log(
                $g_det['beat_id'],$c['company_id'],$g_det['client_id'],"Warning", "Back to Pool",
                $updated_at,$g_det['guard_firstname']." ".$g_det['guard_lastname']." was return to pool from ".$g_det['beat_name'],NULL
            );
            $guard->insert_guard_log(
                $c['company_id'],$g_det['guard_id'],"Warning", "Back to Pool",
                $updated_at,$g_det['guard_firstname']." ".$g_det['guard_lastname']." was return to pool from ".$g_det['beat_name'],
                NULL
            );
            if ($deploy_guard->delete_nominal_roll($data->id)) {
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Return guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." to pool",
                    url_path('/company/list-guards',true,true), $c['staff_photo'],$c['staff_name']
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Norminal Roll deleted successfully.",
                    "location"=>url_path('/company/list-norminal-rolls',true,true)
                ));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Unable to delete Roll."));
            }
        }else{
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_norminal_roll_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            } else{
                $g_det = $beat->get_guard_details_by_deploy_id($data->id);
                $beat->insert_beat_log(
                    $g_det['beat_id'],$c['company_id'],$g_det['client_id'],"Warning", "Back to Pool",
                    $updated_at,$g_det['guard_firstname']." ".$g_det['guard_lastname']." was return to pool from ".$g_det['beat_name'],NULL
                );
                $guard->insert_guard_log(
                    $c['company_id'],$g_det['guard_id'],"Warning", "Back to Pool",
                    $updated_at,$g_det['guard_firstname']." ".$g_det['guard_lastname']." was return to pool from ".$g_det['beat_name'],
                    NULL
                );
                if ($deploy_guard->delete_nominal_roll($data->id)) {
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Return guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." to pool",
                        url_path('/company/list-guards',true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Norminal Roll deleted successfully.",
                        "location"=>url_path('/staff/list-norminal-rolls',true,true)
                    ));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Unable to delete Roll."));
                }
            }
        }
    }
}