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
    $staff_firstname = htmlspecialchars(strip_tags($_POST['stf_f_name']));
    $staff_middlename = htmlspecialchars(strip_tags($_POST['stf_m_name']));
    $staff_lastname = htmlspecialchars(strip_tags($_POST['stf_l_name']));
    $staff_sex = htmlspecialchars(strip_tags($_POST['stf_gender']));
    $staff_dob = htmlspecialchars(strip_tags($_POST['stf_dob']));
    $staff_home_addr = htmlspecialchars(strip_tags($_POST['stf_home_addr']));
    $staff_height = htmlspecialchars(strip_tags($_POST['stf_height']));
    $staff_blood_grp = htmlspecialchars(strip_tags($_POST['stf_blood_grp']));
    $staff_religion = htmlspecialchars(strip_tags($_POST['stf_religion']));
    $staff_marital_stat = htmlspecialchars(strip_tags($_POST['stf_marital_stat']));
    $staff_phone = htmlspecialchars(strip_tags($_POST['stf_phone']));
    $staff_email = htmlspecialchars(strip_tags($_POST['stf_email']));
    $staff_qualification = htmlspecialchars(strip_tags($_POST['stf_qualification']));
    $staff_password = htmlspecialchars(strip_tags($_POST['stf_password']));
    $stf_r_password = htmlspecialchars(strip_tags($_POST['stf_r_password']));
    $staff_role = htmlspecialchars(strip_tags($_POST['stf_role']));

    // Guarantor's Info
    $guarantor_title_number = count($_POST["guarantor_title"]);
    $data_gi = [];

    // Kin's Info
    $next_kin_firstname = htmlspecialchars(strip_tags($_POST['kin_f_name']));
    $next_kin_middlename = htmlspecialchars(strip_tags($_POST['kin_m_name']));
    $next_kin_lastname = htmlspecialchars(strip_tags($_POST['kin_l_name']));
    $next_kin_gender = htmlspecialchars(strip_tags($_POST['kin_gender']));
    $next_home_addr = htmlspecialchars(strip_tags($_POST['kin_home_addr']));
    $next_kin_phone = htmlspecialchars(strip_tags($_POST['kin_phone']));
    $next_kin_relationship = htmlspecialchars(strip_tags($_POST['kin_rel']));

    // Account Info
    $staff_bank = htmlspecialchars(strip_tags($_POST['stf_bank']));
    $staff_account_name = htmlspecialchars(strip_tags($_POST['stf_acc_name']));
    $staff_account_number = htmlspecialchars(strip_tags($_POST['stf_acc_no']));
    $staff_salary = htmlspecialchars(strip_tags($_POST['stf_salary']));

    $c_id = htmlspecialchars(strip_tags($c['company_id']));


    if (!empty($staff_firstname) &&!empty($staff_lastname) &&!empty($staff_sex) && !empty($staff_email) && !empty($staff_password)
        && !empty($staff_role) && !empty($next_kin_firstname) && !empty($next_kin_lastname) && !empty($next_kin_gender) && !empty($next_kin_phone)
        && !empty($staff_bank) && !empty($staff_account_name) && !empty($staff_account_number) && !empty($staff_salary)) {

        if ($stf_r_password != $staff_password) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Password not match"));
        } else {
            $email_data = $company->check_company_staff_email($staff_email,$c_id);
            if (!empty($email_data)) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Email ($staff_email) already in use"));
            } else {
                $staff_id = rand(1000000, 9999999);
                if (isset($_SESSION['COMPANY_LOGIN'])){
                    if (isset($_FILES['stf_photo'])) {
                        $staff_photo = upload_file($_FILES['stf_photo'], upload_path('uploads/staff/'), 'stf_photo_'.rand(10000,99999), 'image', 500000000);
                        if($staff_photo['status'] == 0) {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => $staff_photo['message']));
                            return;
                        }
                    }
                    if (isset($_FILES['stf_sgn'])) {
                        $staff_signature = upload_file($_FILES['stf_sgn'], upload_path('uploads/staff/'), 'stf_sgn_'.rand(10000,99999), 'image', 500000000);
                        if($staff_signature['status'] == 0) {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => $staff_signature['message']));
                            return;
                        }
                    }

                    if ($guarantor_title_number > 0) {
                        $error = 0;
                        for ($i = 0; $i < $guarantor_title_number; $i++) {
                            if ($_POST["guarantor_first_name"][$i]=='' || $_POST["guarantor_middle_name"][$i]=='' || $_POST["guarantor_last_name"][$i]=='') {
                                $error = $error + 1;
                            } else {
                                $data_gi[$i]['guarantor_title'] = $_POST["guarantor_title"][$i];
                                $data_gi[$i]['guarantor_first_name'] = $_POST["guarantor_first_name"][$i];
                                $data_gi[$i]['guarantor_middle_name'] = $_POST["guarantor_middle_name"][$i];
                                $data_gi[$i]['guarantor_last_name'] = $_POST["guarantor_last_name"][$i];

                                $data_gi[$i]['guarantor_sex'] = $_POST["guarantor_sex"][$i];
                                $data_gi[$i]['guarantor_phone'] = $_POST["guarantor_phone"][$i];
                                $data_gi[$i]['guarantor_email'] = $_POST["guarantor_email"][$i];
                                $data_gi[$i]['guarantor_years_of_relationship'] = $_POST["guarantor_years_of_relationship"][$i];

                                $data_gi[$i]['guarantor_place_of_work'] = $_POST["guarantor_place_of_work"][$i];
                                $data_gi[$i]['guarantor_rank'] = $_POST["guarantor_rank"][$i];
                                $data_gi[$i]['guarantor_address'] = $_POST["guarantor_address"][$i];

                                $data_gi[$i]['guarantor_work_address'] = $_POST["guarantor_work_address"][$i];
                                $data_gi[$i]['guarantor_id_Type'] = $_POST["guarantor_id_Type"][$i];
                            }

                            $upload_path = upload_path("uploads/staff/");
                            $ext = explode('.', basename( $_FILES['guarantor_photo']['name'][$i]));
                            $new_name = "gua_photo_".substr(md5(uniqid()),0,6) . "." . $ext[count($ext)-1];
                            $target_path = $upload_path . $new_name;
                            if(move_uploaded_file($_FILES['guarantor_photo']['tmp_name'][$i], $target_path)) {$data_gi[$i]['src_g_ph'] = $new_name;}
                            else{ $error++; }

                            $ext2 = explode('.', basename( $_FILES['guarantor_crd_frnt']['name'][$i]));
                            $new_name2 = "gua_id_frt_".substr(md5(uniqid()),0,6) . "." . $ext2[count($ext2)-1];
                            $target_path2 = $upload_path . $new_name2;
                            if(move_uploaded_file($_FILES['guarantor_crd_frnt']['tmp_name'][$i], $target_path2)) {$data_gi[$i]['src_g_idf'] = $new_name2;}
                            else{$error++;}

                            $ext3 = explode('.', basename( $_FILES['guarantor_crd_bck']['name'][$i]));
                            $new_name3 = "gua_id_bck_".substr(md5(uniqid()),0,6) . "." . $ext3[count($ext3)-1];
                            $target_path3 = $upload_path . $new_name3;
                            if(move_uploaded_file($_FILES['guarantor_crd_bck']['tmp_name'][$i], $target_path3)) {$data_gi[$i]['src_g_idb'] = $new_name3;}
                            else{$error++;}
                        }
                    }

                    if ($error == 0) {
                        $gi_ti_1 = isset($data_gi[0]['guarantor_title']) ? $data_gi[0]['guarantor_title'] : "";
                        $gi_fn_1 = isset($data_gi[0]['guarantor_first_name']) ? $data_gi[0]['guarantor_first_name'] : "";
                        $gi_mn_1 = isset($data_gi[0]['guarantor_middle_name']) ? $data_gi[0]['guarantor_middle_name'] : "";
                        $gi_ln_1 = isset($data_gi[0]['guarantor_last_name']) ? $data_gi[0]['guarantor_last_name'] : "";
                        $gi_se_1 = isset($data_gi[0]['guarantor_sex']) ? $data_gi[0]['guarantor_sex'] : "";
                        $gi_ph_1 = isset($data_gi[0]['guarantor_phone']) ? $data_gi[0]['guarantor_phone'] : "";
                        $gi_em_1 = isset($data_gi[0]['guarantor_email']) ? $data_gi[0]['guarantor_email'] : "";
                        $gi_yor_1 = isset($data_gi[0]['guarantor_years_of_relationship']) ? $data_gi[0]['guarantor_years_of_relationship'] : "";
                        $gi_pow_1 = isset($data_gi[0]['guarantor_place_of_work']) ? $data_gi[0]['guarantor_place_of_work'] : "";
                        $gi_ra_1 = isset($data_gi[0]['guarantor_rank']) ? $data_gi[0]['guarantor_rank'] : "";
                        $gi_add_1 = isset($data_gi[0]['guarantor_address']) ? $data_gi[0]['guarantor_address'] : "";
                        $gi_wad_1 = isset($data_gi[0]['guarantor_work_address']) ? $data_gi[0]['guarantor_work_address'] : "";
                        $gi_idt_1 = isset($data_gi[0]['guarantor_id_Type']) ? $data_gi[0]['guarantor_id_Type'] : "";

                        $gi_ti_2 = isset($data_gi[1]['guarantor_title']) ? $data_gi[1]['guarantor_title'] : "";
                        $gi_fn_2 = isset($data_gi[1]['guarantor_first_name']) ? $data_gi[1]['guarantor_first_name'] : "";
                        $gi_mn_2 = isset($data_gi[1]['guarantor_middle_name']) ? $data_gi[1]['guarantor_middle_name'] : "";
                        $gi_ln_2 = isset($data_gi[1]['guarantor_last_name']) ? $data_gi[1]['guarantor_last_name'] : "";
                        $gi_se_2 = isset($data_gi[1]['guarantor_sex']) ? $data_gi[1]['guarantor_sex'] : "";
                        $gi_ph_2 = isset($data_gi[1]['guarantor_phone']) ? $data_gi[1]['guarantor_phone'] : "";
                        $gi_em_2 = isset($data_gi[1]['guarantor_email']) ? $data_gi[1]['guarantor_email'] : "";
                        $gi_yor_2 = isset($data_gi[1]['guarantor_years_of_relationship']) ? $data_gi[1]['guarantor_years_of_relationship'] : "";
                        $gi_pow_2 = isset($data_gi[1]['guarantor_place_of_work']) ? $data_gi[1]['guarantor_place_of_work'] : "";
                        $gi_ra_2 = isset($data_gi[1]['guarantor_rank']) ? $data_gi[1]['guarantor_rank'] : "";
                        $gi_add_2 = isset($data_gi[1]['guarantor_address']) ? $data_gi[1]['guarantor_address'] : "";
                        $gi_wad_2 = isset($data_gi[1]['guarantor_work_address']) ? $data_gi[1]['guarantor_work_address'] : "";
                        $gi_idt_2 = isset($data_gi[1]['guarantor_id_Type']) ? $data_gi[1]['guarantor_id_Type'] : "";

                        $gi_ti_3 = isset($data_gi[2]['guarantor_title']) ? $data_gi[2]['guarantor_title'] : "";
                        $gi_fn_3 = isset($data_gi[2]['guarantor_first_name']) ? $data_gi[2]['guarantor_first_name'] : "";
                        $gi_mn_3 = isset($data_gi[2]['guarantor_middle_name']) ? $data_gi[2]['guarantor_middle_name'] : "";
                        $gi_ln_3 = isset($data_gi[2]['guarantor_last_name']) ? $data_gi[2]['guarantor_last_name'] : "";
                        $gi_se_3 = isset($data_gi[2]['guarantor_sex']) ? $data_gi[2]['guarantor_sex'] : "";
                        $gi_ph_3 = isset($data_gi[2]['guarantor_phone']) ? $data_gi[2]['guarantor_phone'] : "";
                        $gi_em_3 = isset($data_gi[2]['guarantor_email']) ? $data_gi[2]['guarantor_email'] : "";
                        $gi_yor_3 = isset($data_gi[2]['guarantor_years_of_relationship']) ? $data_gi[2]['guarantor_years_of_relationship'] : "";
                        $gi_pow_3 = isset($data_gi[2]['guarantor_place_of_work']) ? $data_gi[2]['guarantor_place_of_work'] : "";
                        $gi_ra_3 = isset($data_gi[2]['guarantor_rank']) ? $data_gi[2]['guarantor_rank'] : "";
                        $gi_add_3 = isset($data_gi[2]['guarantor_address']) ? $data_gi[2]['guarantor_address'] : "";
                        $gi_wad_3 = isset($data_gi[2]['guarantor_work_address']) ? $data_gi[2]['guarantor_work_address'] : "";
                        $gi_idt_3 = isset($data_gi[2]['guarantor_id_Type']) ? $data_gi[2]['guarantor_id_Type'] : "";

                        $g_ph_1 = isset($data_gi[0]['src_g_ph']) ? $data_gi[0]['src_g_ph'] : "";
                        $g_ph_2 = isset($data_gi[1]['src_g_ph']) ? $data_gi[1]['src_g_ph'] : "";
                        $g_ph_3 = isset($data_gi[2]['src_g_ph']) ? $data_gi[2]['src_g_ph'] : "";

                        $g_id_f_1 = isset($data_gi[0]['src_g_idf']) ? $data_gi[0]['src_g_idf'] : "";
                        $g_id_f_2 = isset($data_gi[1]['src_g_idf']) ? $data_gi[1]['src_g_idf'] : "";
                        $g_id_f_3 = isset($data_gi[2]['src_g_idf']) ? $data_gi[2]['src_g_idf'] : "";

                        $g_id_b_1 = isset($data_gi[0]['src_g_idb']) ? $data_gi[0]['src_g_idb'] : "";
                        $g_id_b_2 = isset($data_gi[1]['src_g_idb']) ? $data_gi[1]['src_g_idb'] : "";
                        $g_id_b_3 = isset($data_gi[2]['src_g_idb']) ? $data_gi[2]['src_g_idb'] : "";

                        $result = $company->create_staff(
                            $c_id, $staff_id, $staff_firstname, $staff_middlename, $staff_lastname, $staff_sex, $staff_dob, $staff_home_addr, $staff_height,
                            $staff_blood_grp,$staff_religion,$staff_marital_stat,$staff_phone,$staff_email,$staff_qualification,$staff_password,$staff_role,
                            $gi_ti_1,$gi_fn_1,$gi_mn_1,$gi_ln_1,$gi_se_1,$gi_ph_1,$gi_em_1,$gi_yor_1,$gi_pow_1,$gi_ra_1,
                            $gi_add_1,$gi_wad_1,$gi_idt_1,$g_ph_1,$g_id_f_1,$g_id_b_1,
                            $gi_ti_2,$gi_fn_2,$gi_mn_2,$gi_ln_2,$gi_se_2,$gi_ph_2,$gi_em_2,$gi_yor_2,$gi_pow_2,$gi_ra_2,
                            $gi_add_2,$gi_wad_2,$gi_idt_2,$g_ph_2,$g_id_f_2,$g_id_b_2,
                            $gi_ti_3,$gi_fn_3,$gi_mn_3,$gi_ln_3,$gi_se_3,$gi_ph_3,$gi_em_3,$gi_yor_3,$gi_pow_3,$gi_ra_3,
                            $gi_add_3,$gi_wad_3,$gi_idt_3,$g_ph_3,$g_id_f_3,$g_id_b_3,
                            $next_kin_firstname,$next_kin_middlename,
                            $next_kin_lastname,$next_kin_gender,$next_home_addr,$next_kin_phone,$next_kin_relationship,$staff_bank,$staff_account_name,
                            $staff_account_number,$staff_salary,$staff_photo['message'],$staff_signature['message']);
                        if ($result) {
                            $company->insert_notifications(
                                $c['company_id'], "General", "1", $c['staff_name'] . " Add a new staff: $staff_firstname $staff_lastname",
                                url_path('/company/edit-staff/' . $staff_id, true, true), $c['staff_photo'], $c['staff_name']
                            );

                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Staff account has been successfully created."));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Staff Account not created"));
                        }
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "One or more require field is empty"));
                    }
                } else{
                    $staff_id_p = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                    $permission_sno = $privileges->get_create_staff_permission_id();
                    $staff_perm_ids = $privileges->staff_perm_ids($staff_id_p);

                    $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

                    if(!in_array($permission_sno['perm_sno'], $array)){
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Not Allowed"));
                    } else{
                        if (isset($_FILES['stf_photo'])) {
                            $staff_photo = upload_file($_FILES['stf_photo'], upload_path('uploads/staff/'), 'stf_photo_'.str_replace(' ','',substr($staff_firstname.$staff_phone, 0, 5)), 'image', 500000000);
                            if($staff_photo['status'] == 0) {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => $staff_photo['message']));
                                return;
                            }
                        }
                        if (isset($_FILES['stf_sgn'])) {
                            $staff_signature = upload_file($_FILES['stf_sgn'], upload_path('uploads/staff/'), 'stf_sgn_'.str_replace(' ','',substr($staff_firstname.$staff_phone, 0, 5)), 'image', 500000000);
                            if($staff_signature['status'] == 0) {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => $staff_signature['message']));
                                return;
                            }
                        }

                        if ($guarantor_title_number > 0) {
                            $error = 0;
                            for ($i = 0; $i < $guarantor_title_number; $i++) {
                                if ($_POST["guarantor_first_name"][$i]=='' || $_POST["guarantor_middle_name"][$i]=='' || $_POST["guarantor_last_name"][$i]=='') {
                                    $error = $error + 1;
                                } else {
                                    $data_gi[$i]['guarantor_title'] = $_POST["guarantor_title"][$i];
                                    $data_gi[$i]['guarantor_first_name'] = $_POST["guarantor_first_name"][$i];
                                    $data_gi[$i]['guarantor_middle_name'] = $_POST["guarantor_middle_name"][$i];
                                    $data_gi[$i]['guarantor_last_name'] = $_POST["guarantor_last_name"][$i];

                                    $data_gi[$i]['guarantor_sex'] = $_POST["guarantor_sex"][$i];
                                    $data_gi[$i]['guarantor_phone'] = $_POST["guarantor_phone"][$i];
                                    $data_gi[$i]['guarantor_email'] = $_POST["guarantor_email"][$i];
                                    $data_gi[$i]['guarantor_years_of_relationship'] = $_POST["guarantor_years_of_relationship"][$i];

                                    $data_gi[$i]['guarantor_place_of_work'] = $_POST["guarantor_place_of_work"][$i];
                                    $data_gi[$i]['guarantor_rank'] = $_POST["guarantor_rank"][$i];
                                    $data_gi[$i]['guarantor_address'] = $_POST["guarantor_address"][$i];

                                    $data_gi[$i]['guarantor_work_address'] = $_POST["guarantor_work_address"][$i];
                                    $data_gi[$i]['guarantor_id_Type'] = $_POST["guarantor_id_Type"][$i];
                                }

                                $upload_path = upload_path("uploads/staff/");
                                $ext = explode('.', basename( $_FILES['guarantor_photo']['name'][$i]));
                                $new_name = "gua_photo_".substr(md5(uniqid()),0,6) . "." . $ext[count($ext)-1];
                                $target_path = $upload_path . $new_name;
                                if(move_uploaded_file($_FILES['guarantor_photo']['tmp_name'][$i], $target_path)) {$data_gi[$i]['src_g_ph'] = $new_name;}
                                else{ $error++; }

                                $ext2 = explode('.', basename( $_FILES['guarantor_crd_frnt']['name'][$i]));
                                $new_name2 = "gua_id_frt_".substr(md5(uniqid()),0,6) . "." . $ext2[count($ext2)-1];
                                $target_path2 = $upload_path . $new_name2;
                                if(move_uploaded_file($_FILES['guarantor_crd_frnt']['tmp_name'][$i], $target_path2)) {$data_gi[$i]['src_g_idf'] = $new_name2;}
                                else{$error++;}

                                $ext3 = explode('.', basename( $_FILES['guarantor_crd_bck']['name'][$i]));
                                $new_name3 = "gua_id_bck_".substr(md5(uniqid()),0,6) . "." . $ext3[count($ext3)-1];
                                $target_path3 = $upload_path . $new_name3;
                                if(move_uploaded_file($_FILES['guarantor_crd_bck']['tmp_name'][$i], $target_path3)) {$data_gi[$i]['src_g_idb'] = $new_name3;}
                                else{$error++;}
                            }
                        }

                        if ($error == 0) {
                            $gi_ti_1 = isset($data_gi[0]['guarantor_title']) ? $data_gi[0]['guarantor_title'] : "";
                            $gi_fn_1 = isset($data_gi[0]['guarantor_first_name']) ? $data_gi[0]['guarantor_first_name'] : "";
                            $gi_mn_1 = isset($data_gi[0]['guarantor_middle_name']) ? $data_gi[0]['guarantor_middle_name'] : "";
                            $gi_ln_1 = isset($data_gi[0]['guarantor_last_name']) ? $data_gi[0]['guarantor_last_name'] : "";
                            $gi_se_1 = isset($data_gi[0]['guarantor_sex']) ? $data_gi[0]['guarantor_sex'] : "";
                            $gi_ph_1 = isset($data_gi[0]['guarantor_phone']) ? $data_gi[0]['guarantor_phone'] : "";
                            $gi_em_1 = isset($data_gi[0]['guarantor_email']) ? $data_gi[0]['guarantor_email'] : "";
                            $gi_yor_1 = isset($data_gi[0]['guarantor_years_of_relationship']) ? $data_gi[0]['guarantor_years_of_relationship'] : "";
                            $gi_pow_1 = isset($data_gi[0]['guarantor_place_of_work']) ? $data_gi[0]['guarantor_place_of_work'] : "";
                            $gi_ra_1 = isset($data_gi[0]['guarantor_rank']) ? $data_gi[0]['guarantor_rank'] : "";
                            $gi_add_1 = isset($data_gi[0]['guarantor_address']) ? $data_gi[0]['guarantor_address'] : "";
                            $gi_wad_1 = isset($data_gi[0]['guarantor_work_address']) ? $data_gi[0]['guarantor_work_address'] : "";
                            $gi_idt_1 = isset($data_gi[0]['guarantor_id_Type']) ? $data_gi[0]['guarantor_id_Type'] : "";

                            $gi_ti_2 = isset($data_gi[1]['guarantor_title']) ? $data_gi[1]['guarantor_title'] : "";
                            $gi_fn_2 = isset($data_gi[1]['guarantor_first_name']) ? $data_gi[1]['guarantor_first_name'] : "";
                            $gi_mn_2 = isset($data_gi[1]['guarantor_middle_name']) ? $data_gi[1]['guarantor_middle_name'] : "";
                            $gi_ln_2 = isset($data_gi[1]['guarantor_last_name']) ? $data_gi[1]['guarantor_last_name'] : "";
                            $gi_se_2 = isset($data_gi[1]['guarantor_sex']) ? $data_gi[1]['guarantor_sex'] : "";
                            $gi_ph_2 = isset($data_gi[1]['guarantor_phone']) ? $data_gi[1]['guarantor_phone'] : "";
                            $gi_em_2 = isset($data_gi[1]['guarantor_email']) ? $data_gi[1]['guarantor_email'] : "";
                            $gi_yor_2 = isset($data_gi[1]['guarantor_years_of_relationship']) ? $data_gi[1]['guarantor_years_of_relationship'] : "";
                            $gi_pow_2 = isset($data_gi[1]['guarantor_place_of_work']) ? $data_gi[1]['guarantor_place_of_work'] : "";
                            $gi_ra_2 = isset($data_gi[1]['guarantor_rank']) ? $data_gi[1]['guarantor_rank'] : "";
                            $gi_add_2 = isset($data_gi[1]['guarantor_address']) ? $data_gi[1]['guarantor_address'] : "";
                            $gi_wad_2 = isset($data_gi[1]['guarantor_work_address']) ? $data_gi[1]['guarantor_work_address'] : "";
                            $gi_idt_2 = isset($data_gi[1]['guarantor_id_Type']) ? $data_gi[1]['guarantor_id_Type'] : "";

                            $gi_ti_3 = isset($data_gi[2]['guarantor_title']) ? $data_gi[2]['guarantor_title'] : "";
                            $gi_fn_3 = isset($data_gi[2]['guarantor_first_name']) ? $data_gi[2]['guarantor_first_name'] : "";
                            $gi_mn_3 = isset($data_gi[2]['guarantor_middle_name']) ? $data_gi[2]['guarantor_middle_name'] : "";
                            $gi_ln_3 = isset($data_gi[2]['guarantor_last_name']) ? $data_gi[2]['guarantor_last_name'] : "";
                            $gi_se_3 = isset($data_gi[2]['guarantor_sex']) ? $data_gi[2]['guarantor_sex'] : "";
                            $gi_ph_3 = isset($data_gi[2]['guarantor_phone']) ? $data_gi[2]['guarantor_phone'] : "";
                            $gi_em_3 = isset($data_gi[2]['guarantor_email']) ? $data_gi[2]['guarantor_email'] : "";
                            $gi_yor_3 = isset($data_gi[2]['guarantor_years_of_relationship']) ? $data_gi[2]['guarantor_years_of_relationship'] : "";
                            $gi_pow_3 = isset($data_gi[2]['guarantor_place_of_work']) ? $data_gi[2]['guarantor_place_of_work'] : "";
                            $gi_ra_3 = isset($data_gi[2]['guarantor_rank']) ? $data_gi[2]['guarantor_rank'] : "";
                            $gi_add_3 = isset($data_gi[2]['guarantor_address']) ? $data_gi[2]['guarantor_address'] : "";
                            $gi_wad_3 = isset($data_gi[2]['guarantor_work_address']) ? $data_gi[2]['guarantor_work_address'] : "";
                            $gi_idt_3 = isset($data_gi[2]['guarantor_id_Type']) ? $data_gi[2]['guarantor_id_Type'] : "";

                            $g_ph_1 = isset($data_gi[0]['src_g_ph']) ? $data_gi[0]['src_g_ph'] : "";
                            $g_ph_2 = isset($data_gi[1]['src_g_ph']) ? $data_gi[1]['src_g_ph'] : "";
                            $g_ph_3 = isset($data_gi[2]['src_g_ph']) ? $data_gi[2]['src_g_ph'] : "";

                            $g_id_f_1 = isset($data_gi[0]['src_g_idf']) ? $data_gi[0]['src_g_idf'] : "";
                            $g_id_f_2 = isset($data_gi[1]['src_g_idf']) ? $data_gi[1]['src_g_idf'] : "";
                            $g_id_f_3 = isset($data_gi[2]['src_g_idf']) ? $data_gi[2]['src_g_idf'] : "";

                            $g_id_b_1 = isset($data_gi[0]['src_g_idb']) ? $data_gi[0]['src_g_idb'] : "";
                            $g_id_b_2 = isset($data_gi[1]['src_g_idb']) ? $data_gi[1]['src_g_idb'] : "";
                            $g_id_b_3 = isset($data_gi[2]['src_g_idb']) ? $data_gi[2]['src_g_idb'] : "";

                            $result = $company->create_staff(
                                $c_id, $staff_id, $staff_firstname, $staff_middlename, $staff_lastname, $staff_sex, $staff_dob, $staff_home_addr, $staff_height,
                                $staff_blood_grp,$staff_religion,$staff_marital_stat,$staff_phone,$staff_email,$staff_qualification,$staff_password,$staff_role,
                                $gi_ti_1,$gi_fn_1,$gi_mn_1,$gi_ln_1,$gi_se_1,$gi_ph_1,$gi_em_1,$gi_yor_1,$gi_pow_1,$gi_ra_1,
                                $gi_add_1,$gi_wad_1,$gi_idt_1,$g_ph_1,$g_id_f_1,$g_id_b_1,
                                $gi_ti_2,$gi_fn_2,$gi_mn_2,$gi_ln_2,$gi_se_2,$gi_ph_2,$gi_em_2,$gi_yor_2,$gi_pow_2,$gi_ra_2,
                                $gi_add_2,$gi_wad_2,$gi_idt_2,$g_ph_2,$g_id_f_2,$g_id_b_2,
                                $gi_ti_3,$gi_fn_3,$gi_mn_3,$gi_ln_3,$gi_se_3,$gi_ph_3,$gi_em_3,$gi_yor_3,$gi_pow_3,$gi_ra_3,
                                $gi_add_3,$gi_wad_3,$gi_idt_3,$g_ph_3,$g_id_f_3,$g_id_b_3,
                                $next_kin_firstname,$next_kin_middlename,
                                $next_kin_lastname,$next_kin_gender,$next_home_addr,$next_kin_phone,$next_kin_relationship,$staff_bank,$staff_account_name,
                                $staff_account_number,$staff_salary,$staff_photo['message'],$staff_signature['message']);
                            if ($result) {
                                $company->insert_notifications(
                                    $c['company_id'], "General", "1", $c['staff_name'] . " Add a new staff: $staff_firstname $staff_lastname",
                                    url_path('/company/edit-staff/' . $staff_id, true, true), $c['staff_photo'], $c['staff_name']
                                );

                                http_response_code(200);
                                echo json_encode(array("status" => 1, "message" => "Staff account has been successfully created."));
                            } else {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "Staff Account not created"));
                            }
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "One or more require field is empty"));
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