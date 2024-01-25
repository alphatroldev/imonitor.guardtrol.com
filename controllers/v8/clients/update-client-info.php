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
    $edit_client_full_name = htmlspecialchars(strip_tags($_POST['edit_client_full_name']));
    $edit_client_office_address = htmlspecialchars(strip_tags($_POST['edit_client_office_address']));
    $edit_client_office_phone = htmlspecialchars(strip_tags($_POST['edit_client_office_phone']));
    $edit_client_email = htmlspecialchars(strip_tags($_POST['edit_client_email']));

    $updated_at = date("Y-m-d H:i:s");
    
    if (!empty($id) && !empty($edit_client_full_name) && !empty($edit_client_office_address) && !empty($edit_client_office_phone) && !empty($edit_client_email)) {
       
           $check_client_name = $client->check_client_name_for_update($edit_client_full_name, $c['company_id'], $id);

           if (!empty($check_client_name)) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "$edit_client_full_name already exist"));
           } else {

            $check_email = $client->check_client_email_for_update($edit_client_email, $c['company_id'], $id);

            if (!empty($check_email)) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "$edit_client_email already in use"));
            } else {

         $client_data = $client->check_client_details($id,$c['company_id']);
        if (!empty($client_data)) {
            if (isset($_SESSION['COMPANY_LOGIN'])){
                $result = $client->update_client_info($c['company_id'],$id,$edit_client_full_name,$edit_client_office_address,$edit_client_office_phone,$edit_client_email,$updated_at);
                if ($result==true) {
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Update client: $edit_client_full_name profile",
                        url_path('/company/edit-client/'.$client_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Client profile successfully updated."));
                } else if ($result=="no_change"){
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update, no changes found."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update profile."));
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
                $result = $client->update_client_info($c['company_id'],$id,$edit_client_full_name,$edit_client_office_address,$edit_client_office_phone,$edit_client_email,$updated_at);
                if ($result==true) {
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Update client: $edit_client_full_name profile",
                        url_path('/company/edit-client/'.$client_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Client profile successfully updated."));
                } else if ($result=="no_change"){
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update, no changes found."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update profile."));
                }
            }

           }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Client profile cannot be retrieve or account deactivated."));
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