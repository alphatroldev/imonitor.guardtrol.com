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
    $data = json_decode(file_get_contents("php://input"));
    if (isset($_SESSION['COMPANY_LOGIN'])){
        if (trim($data->action_code) == '102' && !empty(trim($data->beat_sno))) {
            if ($beat->delete_beat($data->beat_sno,$data->beat_id)) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Beat deleted successfully."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Unable to delete beat."));
            }
        }
        if (trim($data->action_code) == '204' && !empty(trim($data->bsu_id))) {
            if ($beat->delete_beat_supervisor($data->bsu_id)) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Beat supervisor deleted successfully."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Unable to delete beat supervisor."));
            }
        }
        if (trim($data->action_code) == '304' && !empty(trim($data->client_id))) {
            if ($client->delete_client_login_profile($data->client_id)) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Client login profile deleted successfully."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Unable to delete client login profile."));
            }
        }
    }else{
        $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
        $permission_sno = $privileges->get_update_beat_permission_id();
        $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

        $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

        if(!in_array($permission_sno['perm_sno'], $array)){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Not Allowed"));
        }else{
            if (trim($data->action_code) == '102' && !empty(trim($data->beat_sno) )&& !empty(trim($data->beat_id))) {
                if ($beat->delete_beat($data->beat_sno,$data->beat_id)) {
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Beat deleted successfully."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Unable to delete beat."));
                }
            }
//            if (trim($data->action_code) == '101' && !empty(trim($data->id))) {
//                if ($beat->update_beat_status($data->active,$data->id,$c['company_id'],)){
//                    $company->insert_notifications(
//                        $c['company_id'],"General","1", $c['staff_name']." Update beat status",
//                        url_path('/company/company/list-beats',true,true), $c['staff_photo'],$c['staff_name']
//                    );
//                    http_response_code(200);
//                    echo json_encode(array("status" => 1, "message" => "Beat status updated.",
//                        "location"=>url_path('/staff/list-beats',true,true),
//                        "location2"=>url_path('/staff/inactive-beats',true,true)
//                    ));
//                } else {
//                    http_response_code(200);
//                    echo json_encode(array("status" => 0, "message" => "Unable to update beat status."));
//                }
//            }
        }
    }
}