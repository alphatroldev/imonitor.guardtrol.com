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
    if (isset($_POST['guard_id']) AND !empty($_POST['guard_id']) AND !empty($_POST['action_code'])) {
        $result = null;
        $guard_id = htmlspecialchars(strip_tags($_POST['guard_id']));
        $created_at = date("Y-m-d H:i:s");
        if (isset($_SESSION['COMPANY_LOGIN'])) {
            if (isset($_FILES['edit_guard_id_front']) && $_POST['action_code']=='101') {
                $guard_id_f = upload_file($_FILES['edit_guard_id_front'], upload_path('uploads/guard/'), 'id_frt_' . str_replace(' ', '', substr($guard_id, 0, 5)), 'image', 100000000);
                if ($guard_id_f['status'] == 0) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => $guard_id_f['message']));
                } else {
                    $result = $company->update_column('tbl_guards', 'guard_id_front', $guard_id_f['message'], $_POST['guard_id'], 'guard_id');
                    if ($result == true) {
                        $g_det = $guard->get_guard_details_by_guard_id($_POST['guard_id']);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                            url_path('/company/edit-guard/'.$_POST['guard_id'],true,true), $c['staff_photo'],$c['staff_name']
                        );
                        $guard->insert_guard_log(
                            $c['company_id'],$guard_id,"Info", "Update Guard Profile",$created_at,
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
                }
            } else if (isset($_FILES['edit_guard_id_back']) && $_POST['action_code']=='102'){
                $guard_id_bk = upload_file($_FILES['edit_guard_id_back'], upload_path('uploads/guard/'), 'id_bck_' . str_replace(' ', '', substr($guard_id, 0, 5)), 'image', 100000000);
                if ($guard_id_bk['status'] == 0) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => $guard_id_bk['message']));
                } else {
                    $result = $company->update_column('tbl_guards', 'guard_id_back', $guard_id_bk['message'], $_POST['guard_id'], 'guard_id');
                    if ($result == true) {
                        $g_det = $guard->get_guard_details_by_guard_id($_POST['guard_id']);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                            url_path('/company/edit-guard/'.$_POST['guard_id'],true,true), $c['staff_photo'],$c['staff_name']
                        );
                        $guard->insert_guard_log(
                            $c['company_id'],$guard_id,"Info", "Update Guard Profile",$created_at,
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
                }
            } else if (isset($_FILES['edit_guard_signature']) && $_POST['action_code']=='103'){
                $guard_id_sgn = upload_file($_FILES['edit_guard_signature'], upload_path('uploads/guard/'), 'id_bck_' . str_replace(' ', '', substr($guard_id, 0, 5)), 'image', 100000000);
                if ($guard_id_sgn['status'] == 0) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => $guard_id_sgn['message']));
                } else {
                    $result = $company->update_column('tbl_guards', 'guard_signature', $guard_id_sgn['message'], $_POST['guard_id'], 'guard_id');
                    if ($result == true) {
                        $g_det = $guard->get_guard_details_by_guard_id($_POST['guard_id']);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                            url_path('/company/edit-guard/'.$_POST['guard_id'],true,true), $c['staff_photo'],$c['staff_name']
                        );
                        $guard->insert_guard_log(
                            $c['company_id'],$guard_id,"Info", "Update Guard Profile",$created_at,
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
                }
            }
        } else {
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_update_guard_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            } else{
                if (isset($_FILES['edit_guard_id_front']) && $_POST['action_code']=='101') {
                    $guard_id_f = upload_file($_FILES['edit_guard_id_front'], upload_path('uploads/guard/'), 'id_frt_' . str_replace(' ', '', substr($guard_id, 0, 5)), 'image', 100000000);
                    if ($guard_id_f['status'] == 0) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => $guard_id_f['message']));
                    } else {
                        $result = $company->update_column('tbl_guards', 'guard_id_front', $guard_id_f['message'], $_POST['guard_id'], 'guard_id');
                        if ($result == true) {
                            $g_det = $guard->get_guard_details_by_guard_id($_POST['guard_id']);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                                url_path('/company/edit-guard/'.$_POST['guard_id'],true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $guard->insert_guard_log(
                                $c['company_id'],$guard_id,"Info", "Update Guard Profile",$created_at,
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
                    }
                } else if (isset($_FILES['edit_guard_id_back']) && $_POST['action_code']=='102'){
                    $guard_id_bk = upload_file($_FILES['edit_guard_id_back'], upload_path('uploads/guard/'), 'id_bck_' . str_replace(' ', '', substr($guard_id, 0, 5)), 'image', 100000000);
                    if ($guard_id_bk['status'] == 0) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => $guard_id_bk['message']));
                    } else {
                        $result = $company->update_column('tbl_guards', 'guard_id_front', $guard_id_bk['message'], $_POST['guard_id'], 'guard_id');
                        if ($result == true) {
                            $g_det = $guard->get_guard_details_by_guard_id($_POST['guard_id']);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                                url_path('/company/edit-guard/'.$_POST['guard_id'],true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $guard->insert_guard_log(
                                $c['company_id'],$guard_id,"Info", "Update Guard Profile",$created_at,
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
                    }
                } else if (isset($_FILES['edit_guard_signature']) && $_POST['action_code']=='103'){
                    $guard_id_sgn = upload_file($_FILES['edit_guard_signature'], upload_path('uploads/guard/'), 'id_bck_' . str_replace(' ', '', substr($guard_id, 0, 5)), 'image', 100000000);
                    if ($guard_id_sgn['status'] == 0) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => $guard_id_sgn['message']));
                    } else {
                        $result = $company->update_column('tbl_guards', 'guard_id_front', $guard_id_sgn['message'], $_POST['guard_id'], 'guard_id');
                        if ($result == true) {
                            $g_det = $guard->get_guard_details_by_guard_id($_POST['guard_id']);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                                url_path('/company/edit-guard/'.$_POST['guard_id'],true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $guard->insert_guard_log(
                                $c['company_id'],$guard_id,"Info", "Update Guard Profile",$created_at,
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
                    }
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