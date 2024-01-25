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
    $stf_email = htmlspecialchars(strip_tags($_POST['email']));

    $guarantor_title = htmlspecialchars(strip_tags($_POST['guarantor_title']));
    $guarantor_first_name = htmlspecialchars(strip_tags($_POST['guarantor_first_name']));
    $guarantor_middle_name = htmlspecialchars(strip_tags($_POST['guarantor_middle_name']));
    $guarantor_last_name = htmlspecialchars(strip_tags($_POST['guarantor_last_name']));
    $guarantor_sex = htmlspecialchars(strip_tags($_POST['guarantor_sex']));
    $guarantor_phone = htmlspecialchars(strip_tags($_POST['guarantor_phone']));
    $guarantor_email = htmlspecialchars(strip_tags($_POST['guarantor_email']));
    $guarantor_address = htmlspecialchars(strip_tags($_POST['guarantor_address']));
    $guarantor_years_of_relationship = htmlspecialchars(strip_tags($_POST['guarantor_years_of_relationship']));
    $guarantor_place_of_work = htmlspecialchars(strip_tags($_POST['guarantor_place_of_work']));
    $guarantor_rank = htmlspecialchars(strip_tags($_POST['guarantor_rank']));
    $guarantor_work_address = htmlspecialchars(strip_tags($_POST['guarantor_work_address']));
    $guarantor_id_Type = htmlspecialchars(strip_tags($_POST['guarantor_id_Type']));
    $guarantor_photo = htmlspecialchars(strip_tags($_POST['guarantor_photo']));
    $guarantor_id_front = htmlspecialchars(strip_tags($_POST['guarantor_id_front']));
    $guarantor_id_back = htmlspecialchars(strip_tags($_POST['guarantor_id_back']));

    $guarantor_title_2 = htmlspecialchars(strip_tags($_POST['guarantor_title_2']));
    $guarantor_first_name_2 = htmlspecialchars(strip_tags($_POST['guarantor_first_name_2']));
    $guarantor_middle_name_2 = htmlspecialchars(strip_tags($_POST['guarantor_middle_name_2']));
    $guarantor_last_name_2 = htmlspecialchars(strip_tags($_POST['guarantor_last_name_2']));
    $guarantor_sex_2 = htmlspecialchars(strip_tags($_POST['guarantor_sex_2']));
    $guarantor_phone_2 = htmlspecialchars(strip_tags($_POST['guarantor_phone_2']));
    $guarantor_email_2 = htmlspecialchars(strip_tags($_POST['guarantor_email_2']));
    $guarantor_address_2 = htmlspecialchars(strip_tags($_POST['guarantor_address_2']));
    $guarantor_years_of_relationship_2 = htmlspecialchars(strip_tags($_POST['guarantor_years_of_relationship_2']));
    $guarantor_place_of_work_2 = htmlspecialchars(strip_tags($_POST['guarantor_place_of_work_2']));
    $guarantor_rank_2 = htmlspecialchars(strip_tags($_POST['guarantor_rank_2']));
    $guarantor_work_address_2 = htmlspecialchars(strip_tags($_POST['guarantor_work_address_2']));
    $guarantor_id_Type_2 = htmlspecialchars(strip_tags($_POST['guarantor_id_Type_2']));
    $guarantor_photo_2 = htmlspecialchars(strip_tags($_POST['guarantor_photo_2']));
    $guarantor_id_front_2 = htmlspecialchars(strip_tags($_POST['guarantor_id_front_2']));
    $guarantor_id_back_2 = htmlspecialchars(strip_tags($_POST['guarantor_id_back_2']));

    $guarantor_title_3 = htmlspecialchars(strip_tags($_POST['guarantor_title_3']));
    $guarantor_first_name_3 = htmlspecialchars(strip_tags($_POST['guarantor_first_name_3']));
    $guarantor_middle_name_3 = htmlspecialchars(strip_tags($_POST['guarantor_middle_name_3']));
    $guarantor_last_name_3 = htmlspecialchars(strip_tags($_POST['guarantor_last_name_3']));
    $guarantor_sex_3 = htmlspecialchars(strip_tags($_POST['guarantor_sex_3']));
    $guarantor_phone_3 = htmlspecialchars(strip_tags($_POST['guarantor_phone_3']));
    $guarantor_email_3 = htmlspecialchars(strip_tags($_POST['guarantor_email_3']));
    $guarantor_address_3 = htmlspecialchars(strip_tags($_POST['guarantor_address_3']));
    $guarantor_years_of_relationship_3 = htmlspecialchars(strip_tags($_POST['guarantor_years_of_relationship_3']));
    $guarantor_place_of_work_3 = htmlspecialchars(strip_tags($_POST['guarantor_place_of_work_3']));
    $guarantor_rank_3 = htmlspecialchars(strip_tags($_POST['guarantor_rank_3']));
    $guarantor_work_address_3 = htmlspecialchars(strip_tags($_POST['guarantor_work_address_3']));
    $guarantor_id_Type_3 = htmlspecialchars(strip_tags($_POST['guarantor_id_Type_3']));
    $guarantor_photo_3 = htmlspecialchars(strip_tags($_POST['guarantor_photo_3']));
    $guarantor_id_front_3 = htmlspecialchars(strip_tags($_POST['guarantor_id_front_3']));
    $guarantor_id_back_3 = htmlspecialchars(strip_tags($_POST['guarantor_id_back_3']));

    $uploadDir = upload_path("uploads/staff/");
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

    if (!empty($staff_sno)) {
        $user_data = $company->get_staff_details_by_email($stf_email,$c['company_id']);
        if (!empty($user_data)) {
            if (isset($_SESSION['COMPANY_LOGIN'])){
                if ($err == 0) {
                    $guarantor_photo_save = isset($data['edit_guarantor_photo']['src']) ? $data['edit_guarantor_photo']['src'] : $guarantor_photo;
                    $guarantor_idcard_front_save = isset($data['edit_guarantor_id_front']['src']) ? $data['edit_guarantor_id_front']['src'] : $guarantor_id_front;
                    $guarantor_idcard_back_save = isset($data['edit_guarantor_id_back']['src']) ? $data['edit_guarantor_id_back']['src'] : $guarantor_id_back;

                    $guarantor_photo_save_2 = isset($data['edit_guarantor_photo_2']['src']) ? $data['edit_guarantor_photo_2']['src'] : $guarantor_photo_2;
                    $guarantor_idcard_front_save_2 = isset($data['edit_guarantor_id_front_2']['src']) ? $data['edit_guarantor_id_front_2']['src'] : $guarantor_id_front_2;
                    $guarantor_idcard_back_save_2 = isset($data['edit_guarantor_id_back_2']['src']) ? $data['edit_guarantor_id_back_2']['src'] : $guarantor_id_back_2;

                    $guarantor_photo_save_3 = isset($data['edit_guarantor_photo_3']['src']) ? $data['edit_guarantor_photo_3']['src'] : $guarantor_photo_3;
                    $guarantor_idcard_front_save_3 = isset($data['edit_guarantor_id_front_3']['src']) ? $data['edit_guarantor_id_front_3']['src'] : $guarantor_id_front_3;
                    $guarantor_idcard_back_save_3 = isset($data['edit_guarantor_id_back_3']['src']) ? $data['edit_guarantor_id_back_3']['src'] : $guarantor_id_back_3;

                    $result = $company->update_staff_guarantor_info_by_id(
                        $c['company_id'], $staff_sno,
                        $guarantor_title,$guarantor_first_name,$guarantor_middle_name,$guarantor_last_name,$guarantor_sex, $guarantor_phone,
                        $guarantor_email,$guarantor_address,$guarantor_years_of_relationship,$guarantor_place_of_work, $guarantor_rank,
                        $guarantor_work_address, $guarantor_id_Type,
                        $guarantor_title_2,$guarantor_first_name_2,$guarantor_middle_name_2,$guarantor_last_name_2,$guarantor_sex_2, $guarantor_phone_2,
                        $guarantor_email_2,$guarantor_address_2,$guarantor_years_of_relationship_2,$guarantor_place_of_work_2, $guarantor_rank_2,
                        $guarantor_work_address_2, $guarantor_id_Type_2,
                        $guarantor_title_3,$guarantor_first_name_3,$guarantor_middle_name_3,$guarantor_last_name_3,$guarantor_sex_3, $guarantor_phone_3,
                        $guarantor_email_3,$guarantor_address_3,$guarantor_years_of_relationship_3,$guarantor_place_of_work_3, $guarantor_rank_3,
                        $guarantor_work_address_3, $guarantor_id_Type_3,
                        $guarantor_photo_save, $guarantor_idcard_front_save, $guarantor_idcard_back_save,
                        $guarantor_photo_save_2, $guarantor_idcard_front_save_2, $guarantor_idcard_back_save_2,
                        $guarantor_photo_save_3, $guarantor_idcard_front_save_3, $guarantor_idcard_back_save_3
                    );
                    if ($result == true) {
                        $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Update a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." profile",
                            url_path('/company/edit-staff/'.$staff_id,true,true), $c['staff_photo'],$c['staff_name']
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
            }else{
                $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                $permission_sno = $privileges->get_update_staff_permission_id();
                $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

                if(!in_array($permission_sno['perm_sno'], $array)){
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                } else{
                    if ($err == 0) {
                        $guarantor_photo_save = isset($data['edit_guarantor_photo']['src']) ? $data['edit_guarantor_photo']['src'] : $guarantor_photo;
                        $guarantor_idcard_front_save = isset($data['edit_guarantor_id_front']['src']) ? $data['edit_guarantor_id_front']['src'] : $guarantor_id_front;
                        $guarantor_idcard_back_save = isset($data['edit_guarantor_id_back']['src']) ? $data['edit_guarantor_id_back']['src'] : $guarantor_id_back;

                        $guarantor_photo_save_2 = isset($data['edit_guarantor_photo_2']['src']) ? $data['edit_guarantor_photo_2']['src'] : $guarantor_photo_2;
                        $guarantor_idcard_front_save_2 = isset($data['edit_guarantor_id_front_2']['src']) ? $data['edit_guarantor_id_front_2']['src'] : $guarantor_id_front_2;
                        $guarantor_idcard_back_save_2 = isset($data['edit_guarantor_id_back_2']['src']) ? $data['edit_guarantor_id_back_2']['src'] : $guarantor_id_back_2;

                        $guarantor_photo_save_3 = isset($data['edit_guarantor_photo_3']['src']) ? $data['edit_guarantor_photo_3']['src'] : $guarantor_photo_3;
                        $guarantor_idcard_front_save_3 = isset($data['edit_guarantor_id_front_3']['src']) ? $data['edit_guarantor_id_front_3']['src'] : $guarantor_id_front_3;
                        $guarantor_idcard_back_save_3 = isset($data['edit_guarantor_id_back_3']['src']) ? $data['edit_guarantor_id_back_3']['src'] : $guarantor_id_back_3;

                        $result = $company->update_staff_guarantor_info_by_id(
                            $c['company_id'], $staff_sno,
                            $guarantor_title,$guarantor_first_name,$guarantor_middle_name,$guarantor_last_name,$guarantor_sex, $guarantor_phone,
                            $guarantor_email,$guarantor_address,$guarantor_years_of_relationship,$guarantor_place_of_work, $guarantor_rank,
                            $guarantor_work_address, $guarantor_id_Type,
                            $guarantor_title_2,$guarantor_first_name_2,$guarantor_middle_name_2,$guarantor_last_name_2,$guarantor_sex_2, $guarantor_phone_2,
                            $guarantor_email_2,$guarantor_address_2,$guarantor_years_of_relationship_2,$guarantor_place_of_work_2, $guarantor_rank_2,
                            $guarantor_work_address_2, $guarantor_id_Type_2,
                            $guarantor_title_3,$guarantor_first_name_3,$guarantor_middle_name_3,$guarantor_last_name_3,$guarantor_sex_3, $guarantor_phone_3,
                            $guarantor_email_3,$guarantor_address_3,$guarantor_years_of_relationship_3,$guarantor_place_of_work_3, $guarantor_rank_3,
                            $guarantor_work_address_3, $guarantor_id_Type_3,
                            $guarantor_photo_save, $guarantor_idcard_front_save, $guarantor_idcard_back_save,
                            $guarantor_photo_save_2, $guarantor_idcard_front_save_2, $guarantor_idcard_back_save_2,
                            $guarantor_photo_save_3, $guarantor_idcard_front_save_3, $guarantor_idcard_back_save_3
                        );
                        if ($result == true) {
                            $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Update a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." profile",
                                url_path('/company/edit-staff/'.$staff_id,true,true), $c['staff_photo'],$c['staff_name']
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
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Staff profile cannot be retrieve / disabled account."));
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