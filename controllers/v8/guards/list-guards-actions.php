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
    if (trim($data->action_code) == '101' && !empty(trim($data->id))) {
        if ($guard->update_guard_status($data->active,$data->id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Guard status updated.",
                "location"=>url_path('/company/list-guards',true,true),
                "location2"=>url_path('/company/inactive-guards',true,true)));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update Guard status."));
        }
    }

    if (trim($data->action_code) == '102' && !empty(trim($data->guard_id))) {
        if ($guard->delete_guard($data->guard_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Guard deleted successfully.",
            "location"=>url_path('/company/list-guards',true,true)
        ));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete Guard."));
        }
    }

    if (trim($data->action_code) == '402' && !empty(trim($data->offense_id)) && !empty(trim($data->guard_id))) {
        if ($guard->delete_guard_offense($data->offense_id,$data->guard_id)) {
            if (isset($_SESSION['COMPANY_LOGIN'])){
                $url = url_path('/company/list-guards',true,true);
            }else{
                $url = url_path('/staff/list-guards',true,true);
            }
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Guard Offense deleted successfully.", "location"=>$url));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete Guard offense."));
        }
    }

    if (trim($data->action_code) == '502' && !empty(trim($data->gpd_sno)) && !empty(trim($data->comp_id))) {
        if ($guard->delete_guard_payroll_data($data->gpd_sno,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Guard Payroll data deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete Guard payroll data."));
        }
    }
    
    if (trim($data->action_code) == '520' && !empty(trim($data->un_id)) && !empty(trim($data->comp_id))) {
        if ($guard->delete_guard_uniform_ded_data($data->un_id,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Guard Uniform Deduct data deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete Guard Uniform Deduct data."));
        }
    }

    if (trim($data->action_code) == '602' && !empty(trim($data->g_route_sno)) && !empty(trim($data->company_id))) {
        if ($company->delete_assigned_route_task($data->g_route_sno,$data->company_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Guard Payroll data deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete Guard payroll data."));
        }
    }

    if (trim($data->action_code) == '108' && !empty(trim($data->comp_id)) && !empty(trim($data->payroll_data_sno))) {
        if ($guard->delete_guard_report_payroll_data($data->payroll_data_sno, $data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Guard Payroll data deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete guard payroll data."));
        }
    }

}