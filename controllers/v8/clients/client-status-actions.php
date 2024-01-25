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
    
    $client_id = htmlspecialchars(strip_tags($_POST['client_id']));
    $clientStatus = htmlspecialchars(strip_tags($_POST['clientStatus']));
    $clientStatusRemark = htmlspecialchars(strip_tags($_POST['clientStatusRemark']));
    $c_id = htmlspecialchars(strip_tags($_POST['comp_id']));

    if (isset($_POST['term_date'])){
        $created_at = date("Y-m-d H:i:s",strtotime($_POST['term_date']));
    } else {
        $created_at = date("Y-m-d H:i:s");
    }
          if (!empty($client_id) &&!empty($clientStatus) &&!empty($clientStatusRemark) &&!empty($c_id)) {
            if (isset($_SESSION['COMPANY_LOGIN'])){
                $result = $client->client_status($c_id,$client_id, $clientStatus, $clientStatusRemark, $created_at);
                if ($result) {
                    $client_det = $client->get_client_by_id($client_id,$c['company_id']);
                    $client_res = $client_det->fetch_assoc();
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Update client: ".$client_res['client_fullname']." status",
                        url_path('/company/edit-client/'.$client_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    if($clientStatus=='Active'){
                     echo json_encode(array("status" => 1, "message" => "Client Activated"));
                    }else{
                     echo json_encode(array("status" => 1, "message" => "Client Deactivated"));
                    }
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Client Status not Updated"));
                }
            }else{
                $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                $permission_sno = $privileges->get_update_client_permission_id();
                $staff_perm_ids = $privileges->staff_perm_ids($staff_id);
        
                $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));
        
                if(!in_array($permission_sno['perm_sno'], $array)){
                 http_response_code(200);
                 echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                }else{
                    $result = $client->client_status($c_id,$client_id, $clientStatus, $clientStatusRemark, $created_at);
                    if ($result) {
                       $client_det = $client->get_client_by_id($client_id,$c['company_id']);
                        $client_res = $client_det->fetch_assoc();
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Update client: ".$client_res['client_fullname']." status",
                            url_path('/company/edit-client/'.$client_id,true,true), $c['staff_photo'],$c['staff_name']
                        );
                        http_response_code(200);
                        if($clientStatus=='Active'){
                         echo json_encode(array("status" => 1, "message" => "Client Activated"));
                        }else{
                         echo json_encode(array("status" => 1, "message" => "Client Deactivated"));
                        }
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Client Status not Updated"));
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