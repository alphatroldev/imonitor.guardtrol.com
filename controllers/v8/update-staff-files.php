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
    $staff_sno = htmlspecialchars(strip_tags($_POST['staff_sno'])); 
    $staff_id = htmlspecialchars(strip_tags($_POST['staff_id']));
    $curr_staff_photo = htmlspecialchars(strip_tags($_POST['staff_photo']));
    $curr_staff_signature = htmlspecialchars(strip_tags($_POST['staff_signature']));

    $uploadDir = upload_path("uploads/staff/");
    $images = $_FILES;
    $data = [];

    $err = 0;
    if (isset($_SESSION['COMPANY_LOGIN'])){
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
        if ($err == 0) {
            $staff_photo = isset($data['stf_photo']['src']) ? $data['stf_photo']['src'] : $curr_staff_photo;
            $staff_signature = isset($data['stf_sgn']['src']) ? $data['stf_sgn']['src'] : $curr_staff_signature;


            $result = $company->update_staff_files($c['company_id'],$staff_sno,$staff_photo,$staff_signature);
            if ($result) {
                $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Update a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." profile",
                    url_path('/company/edit-staff/'.$staff_id,true,true), $c['staff_photo'],$c['staff_name']
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "File updated successfully"));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Failed to update profile, no changes found."));
            }
        }
    }else{
        $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
        $permission_sno = $privileges->get_update_staff_permission_id();
        $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

        $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

        if(!in_array($permission_sno['perm_sno'], $array)){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
        } else{
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
            if ($err == 0) {
                $staff_photo = isset($data['stf_photo']['src']) ? $data['stf_photo']['src'] : $curr_staff_photo;
                $staff_signature = isset($data['stf_sgn']['src']) ? $data['stf_sgn']['src'] : $curr_staff_signature;


                $result = $company->update_staff_files($c['company_id'],$staff_sno,$staff_photo,$staff_signature);
                if ($result) {
                   $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                    $company->insert_notifications(
                        $c['company_id'],"General","1", $c['staff_name']." Update a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." profile",
                        url_path('/company/edit-staff/'.$staff_id,true,true), $c['staff_photo'],$c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "File updated successfully"));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Failed to update profile, no changes found."));
                }
            }
        }
    }

} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>