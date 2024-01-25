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

    //ONLY HANDLES FILE UPLOADS
    if (isset($_POST['guard_id']) AND !empty($_POST['guard_id'])) {
        $result = null;
        $sname = htmlspecialchars(strip_tags($_POST['gname']));
        $sphone = htmlspecialchars(strip_tags($_POST['gphone']));
        
        $created_at = date("Y-m-d H:i:s");

        if (isset($_SESSION['COMPANY_LOGIN'])){
            if (isset($_FILES['guard_profile_picx_update'])) {
                //process your files
                $guard_pp = upload_file($_FILES['guard_profile_picx_update'], upload_path('uploads/guard/'), 'pp_' . str_replace(' ', '', substr($sname . $sphone, 0, 5)), 'image', 500000000);
                if ($guard_pp['status'] == 0) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => $guard_pp['message']));
                    return;
                }
                //store in database
                $result = $company->update_column('tbl_guards', 'guard_photo', $guard_pp['message'], $_POST['guard_id'], 'guard_id');
            }

            if ($result == true) {
                $g_det = $guard->get_guard_details_by_guard_id($_POST['guard_id']);
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                    url_path('/company/edit-guard/'.$_POST['guard_id'],true,true), $c['staff_photo'],$c['staff_name']
                );
                $guard->insert_guard_log(
                    $c['company_id'],$_POST['guard_id'],"Info", "Update Guard Profile",$created_at,
                    $g_det['guard_firstname']." ".$g_det['guard_lastname']." profile was updated on ".$created_at,null
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Your account profile has been successfully updated."));
            } else if ($result == "no_change") {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Failed to update profile, no changes found."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Failed to update profile."));
            }
            return;
        }else{
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_update_guard_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            } else{
                if (isset($_FILES['guard_profile_picx_update'])) {
                    //process your files
                    $guard_pp = upload_file($_FILES['guard_profile_picx_update'], upload_path('uploads/guard/'), 'pp_' . str_replace(' ', '', substr($sname . $sphone, 0, 5)), 'image', 500000000);
                    if ($guard_pp['status'] == 0) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => $guard_pp['message']));
                        return;
                    }
                    //store in database
                    $result = $company->update_column('tbl_guards', 'guard_photo', $guard_pp['message'], $_POST['guard_id'], 'guard_id');
                }

                if ($result == true) {
                    $g_det = $guard->get_guard_details_by_guard_id($_POST['guard_id']);
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                        url_path('/company/edit-guard/'.$_POST['guard_id'],true,true), $c['staff_photo'],$c['staff_name']
                    );
                    $guard->insert_guard_log(
                        $c['company_id'],$_POST['guard_id'],"Info", "Update Guard Profile",$created_at,
                        $g_det['guard_firstname']." ".$g_det['guard_lastname']." profile was updated on ".$created_at,null
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Your account profile has been successfully updated."));
                } else if ($result == "no_change") {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update profile, no changes found."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update profile."));
                }
                return;
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