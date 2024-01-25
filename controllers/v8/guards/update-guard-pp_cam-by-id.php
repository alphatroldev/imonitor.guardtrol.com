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
    if (isset($_POST['dataurl']) AND !empty($_POST['dataurl'])) {
        $result = null;
        $img = $_POST['dataurl'];
        $img = str_replace('data:image/png;base64,','',$img);
        $img = str_replace(' ','+',$img);
        $data = base64_decode($img);
        $file = 'pp_'.rand(10000,99999);
        $dir = getcwd()."/public/uploads/guard/";
        $created_at = date("Y-m-d H:i:s");

        if (isset($_SESSION['COMPANY_LOGIN'])){
            $success = file_put_contents("$dir/$file".".png",$data);

            $sname = htmlspecialchars(strip_tags($_POST['sname']));
            $sphone = htmlspecialchars(strip_tags($_POST['sphone']));

            if ($success) {
                //store in database
                $result = $company->update_column('tbl_guards', 'guard_photo', $file.".png", $_POST['guard_id'], 'guard_id');
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
                $success = file_put_contents("$dir/$file".".png",$data);

                $sname = htmlspecialchars(strip_tags($_POST['sname']));
                $sphone = htmlspecialchars(strip_tags($_POST['sphone']));

                if ($success) {
                    //store in database
                    $result = $company->update_column('tbl_guards', 'guard_photo', $file.".png", $_POST['guard_id'], 'guard_id');
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
        http_response_code(503);
        echo json_encode(array("status" => 503, "message" => "Access Denied"));
    }
}

?>