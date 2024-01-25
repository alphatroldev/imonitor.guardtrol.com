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
    $id = htmlspecialchars(strip_tags($_POST['id']));
    $client_id = htmlspecialchars(strip_tags($_POST['client_id']));
    $edit_client_contact_full_name = htmlspecialchars(strip_tags($_POST['edit_client_contact_full_name']));
    $edit_client_contact_position = htmlspecialchars(strip_tags($_POST['edit_client_contact_position']));
    $edit_client_contact_phone = htmlspecialchars(strip_tags($_POST['edit_client_contact_phone']));
    $edit_client_contact_email = htmlspecialchars(strip_tags($_POST['edit_client_contact_email']));
    $edit_client_contact_full_name_2 = htmlspecialchars(strip_tags($_POST['edit_client_contact_full_name_2']));
    $edit_client_contact_position_2 = htmlspecialchars(strip_tags($_POST['edit_client_contact_position_2']));
    $edit_client_contact_phone_2 = htmlspecialchars(strip_tags($_POST['edit_client_contact_phone_2']));
    $edit_client_contact_email_2 = htmlspecialchars(strip_tags($_POST['edit_client_contact_email_2']));
    $edit_client_contact_full_name_3 = htmlspecialchars(strip_tags($_POST['edit_client_contact_full_name_3']));
    $edit_client_contact_position_3 = htmlspecialchars(strip_tags($_POST['edit_client_contact_position_3']));
    $edit_client_contact_phone_3 = htmlspecialchars(strip_tags($_POST['edit_client_contact_phone_3']));
    $edit_client_contact_email_3 = htmlspecialchars(strip_tags($_POST['edit_client_contact_email_3']));
    $updated_at = date("Y-m-d H:i:s");
    
    if (!empty($id) && !empty($edit_client_contact_full_name) && !empty($edit_client_contact_phone) && !empty($edit_client_contact_email)) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $result = $client->update_client_contact_info(
                $c['company_id'],$id,
                $edit_client_contact_full_name,$edit_client_contact_position,$edit_client_contact_phone,$edit_client_contact_email,
                $edit_client_contact_full_name_2,$edit_client_contact_position_2, $edit_client_contact_phone_2,$edit_client_contact_email_2,
                $edit_client_contact_full_name_3, $edit_client_contact_position_3,$edit_client_contact_phone_3,$edit_client_contact_email_3, $updated_at
            );
            if ($result==true) {
               $client_det = $client->get_client_by_id($client_id,$c['company_id']);
                $client_res = $client_det->fetch_assoc();
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Update client: ".$client_res['client_fullname']." profile",
                    url_path('/company/edit-client/'.$client_id,true,true), $c['staff_photo'],$c['staff_name']
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Update Successful."));
            } else if ($result=="no_change"){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Update failed, no changes found."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Update failed."));
            }
        } else {
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_update_client_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);
    
            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));
    
            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            }else{
                $result = $client->update_client_contact_info(
                    $c['company_id'],$id,
                    $edit_client_contact_full_name,$edit_client_contact_position,$edit_client_contact_phone,$edit_client_contact_email,
                    $edit_client_contact_full_name_2,$edit_client_contact_position_2, $edit_client_contact_phone_2,$edit_client_contact_email_2,
                    $edit_client_contact_full_name_3, $edit_client_contact_position_3,$edit_client_contact_phone_3,$edit_client_contact_email_3, $updated_at
                );
                if ($result==true) {
                   $client_det = $client->get_client_by_id($client_id,$c['company_id']);
                    $client_res = $client_det->fetch_assoc();
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Update client: ".$client_res['client_fullname']." profile",
                        url_path('/company/edit-client/'.$client_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Update Successful."));
                } else if ($result=="no_change"){
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Update failed, no changes found."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Update failed."));
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