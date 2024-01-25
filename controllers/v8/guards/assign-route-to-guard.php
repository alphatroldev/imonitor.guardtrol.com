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
    $routes = htmlspecialchars(strip_tags($_POST['routes']));
    $guard_id = htmlspecialchars(strip_tags($_POST['guard_id']));
    $c_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $created_at = date("Y-m-d H:i:s");

    if (!empty($routes) &&!empty($guard_id) &&!empty($c_id) &&!empty($created_at)) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $result = $company->create_beat_route_task($c_id,$guard_id,$routes,$created_at);
            if ($result) {
                $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." assign a beat route task to guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                    url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                );
                $guard->insert_guard_log(
                    $c_id,$guard_id,"Info", "Route Task",$created_at,
                    $g_det['guard_firstname']." ".$g_det['guard_lastname']." was assigned a route task", "Duty"
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Route task assigned successfully"));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Request Failed"));
            }
        }else{
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_update_guard_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            }else{
                $result = $company->create_beat_route_task($c_id,$guard_id,$routes,$created_at);
                if ($result) {
                    $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." assign a beat route task to guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                        url_path('/staff/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    $guard->insert_guard_log(
                        $c_id,$guard_id,"Info", "Route Task",$created_at,
                        $g_det['guard_firstname']." ".$g_det['guard_lastname']." was assigned a route task", "Duty"
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Route task assigned successfully"));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Request Failed"));
                }
            }
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>