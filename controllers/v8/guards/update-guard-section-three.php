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
    $guard_id = htmlspecialchars(strip_tags($_POST['guard_id']));
    $client_id = NULL;
    $guard_id_Type = htmlspecialchars(strip_tags($_POST['guard_id_Type']));
    $guard_bank = htmlspecialchars(strip_tags($_POST['guard_bank']));
    $guard_acct_number = htmlspecialchars(strip_tags($_POST['guard_acct_number']));
    $guard_acct_name = htmlspecialchars(strip_tags($_POST['guard_acct_name']));
    $beat = '';
    $guard_blood_group = htmlspecialchars(strip_tags($_POST['guard_blood_group']));
    $guard_remark = htmlspecialchars(strip_tags($_POST['guard_remark']));

    $updated_at = date("Y-m-d H:i:s");
//    $guard_photo = htmlspecialchars(strip_tags($_POST['guard_photo']));
//    $guard_id_front = htmlspecialchars(strip_tags($_POST['guard_id_front']));
//    $guard_id_back = htmlspecialchars(strip_tags($_POST['guard_id_back']));
//    $guard_signature = htmlspecialchars(strip_tags($_POST['guard_signature']));



//        $uploadDir = upload_path("uploads/guard/");
//        $images = $_FILES;
//        $data = [];
//
//        $err = 0;
//        foreach ($images as $key => $image) {
//            $name = strtolower($image['name']);
//            $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
//            $targetFilePath = $uploadDir . $name;
//            $allowTypes = array('jpg', 'png', 'jpeg', 'pdf');
//
//            if (in_array($fileType, $allowTypes)) {
//                if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
//                    $data[$key]['success'] = true;
//                    $data[$key]['src'] = $name;
//                } else {
//                    $data[$key]['success'] = false;
//                    $data[$key]['src'] = $name;
//                    ++$err;
//                }
//            }
//        }

    
    if (!empty($id)&&!empty($guard_id_Type)&&!empty($guard_bank)&&!empty($guard_acct_number)&&!empty($guard_acct_name)&&!empty($guard_blood_group)) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            $result = $guard->update_guard_section_three($c['company_id'],
                $id,$client_id,$guard_id_Type,$guard_bank,$guard_acct_number,$guard_acct_name,$beat,$guard_blood_group,$guard_remark,$updated_at
            );

            if ($result==true) {
                $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                    url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                );
                $guard->insert_guard_log(
                    $c['company_id'],$guard_id,"Info", "Update Guard Profile",$updated_at,
                    $g_det['guard_firstname']." ".$g_det['guard_lastname']." profile was updated on ".$updated_at,null
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
            $permission_sno = $privileges->get_update_guard_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
             http_response_code(200);
             echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            }else{
                $result = $guard->update_guard_section_three($c['company_id'],
                    $id,$client_id,$guard_id_Type,$guard_bank,$guard_acct_number,$guard_acct_name,$beat,$guard_blood_group,$guard_remark,$updated_at
                );

                if ($result==true){
                    $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                        url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    $guard->insert_guard_log(
                        $c['company_id'],$guard_id,"Info", "Update Guard Profile",$updated_at,
                        $g_det['guard_firstname']." ".$g_det['guard_lastname']." profile was updated on ".$updated_at,null
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