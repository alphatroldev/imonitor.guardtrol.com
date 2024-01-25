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
    $id = htmlspecialchars(strip_tags($_POST['id']));
    $client_photo = htmlspecialchars(strip_tags($_POST['client_photo']));
    $edit_client_id_card_Type = htmlspecialchars(strip_tags($_POST['edit_client_id_card_Type'])); 
    $client_idcard_front = htmlspecialchars(strip_tags($_POST['client_idcard_front'])); 
    $client_idcard_back = htmlspecialchars(strip_tags($_POST['client_idcard_back'])); 
    $updated_at = date("Y-m-d H:i:s");

    $uploadDir = upload_path("uploads/client/");
    $images = $_FILES;
    $data = [];


    $err = 0;
    foreach ($images as $key => $image) {
        $name = strtolower($image['name']);
        $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $targetFilePath = $uploadDir . $name;
        $allowTypes = array('jpg', 'png', 'jpeg', 'pdf');

        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
                $data[$key]['success'] = true;
                $data[$key]['src'] = $name;
            } else {
                $data[$key]['success'] = false;
                $data[$key]['src'] = $name;
                ++$err;
            }
        }
    }


    if (isset($_SESSION['COMPANY_LOGIN'])){
    if ($err == 0) {
        $photo = isset($data['edit_client_photo']['src']) ? $data['edit_client_photo']['src'] : $client_photo;
        $idcard_front = isset($data['edit_client_id_card_front']['src']) ? $data['edit_client_id_card_front']['src'] : $client_idcard_front;
        $idcard_back = isset($data['edit_client_id_card_back']['src']) ? $data['edit_client_id_card_back']['src'] : $client_idcard_back;
        $idcard_type = $edit_client_id_card_Type;

        $result = $client->update_client_official_info($c['company_id'],$id,$photo, $idcard_type, $idcard_front,$idcard_back,$updated_at);
        if ($result) {
            $client_det = $client->get_client_by_id($client_id,$c['company_id']);
             $client_res = $client_det->fetch_assoc();
            $company->insert_notifications(
                $c['company_id'],"General","1", $c['staff_name']." Update client: ".$client_res['client_fullname']." profile",
                url_path('/company/edit-client/'.$client_id,true,true), $c['staff_photo'],$c['staff_name']
            );
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Update successful"));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Update failed, no changes found."));
        }
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
                if ($err == 0) {
                    $photo = isset($data['edit_client_photo']['src']) ? $data['edit_client_photo']['src'] : $client_photo;
                    $idcard_front = isset($data['edit_client_id_card_front']['src']) ? $data['edit_client_id_card_front']['src'] : $client_idcard_front;
                    $idcard_back = isset($data['edit_client_id_card_back']['src']) ? $data['edit_client_id_card_back']['src'] : $client_idcard_back;
                    $idcard_type = $edit_client_id_card_Type;
            
                    $result = $client->update_client_official_info($c['company_id'],$id,$photo, $idcard_type, $idcard_front,$idcard_back,$updated_at);
                    if ($result) {
                        $client_det = $client->get_client_by_id($client_id,$c['company_id']);
                         $client_res = $client_det->fetch_assoc();
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Update client: ".$client_res['client_fullname']." profile",
                            url_path('/company/edit-client/'.$client_id,true,true), $c['staff_photo'],$c['staff_name']
                        );
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Update successful"));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Update failed, no changes found."));
                    }
                }
            }
   }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>