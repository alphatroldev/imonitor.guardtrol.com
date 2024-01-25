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
    // step one
    $client_id = '';
    $guard_first_name = htmlspecialchars(strip_tags($_POST['guard_first_name']));
    $guard_middle_name = htmlspecialchars(strip_tags($_POST['guard_middle_name']));
    $guard_last_name = htmlspecialchars(strip_tags($_POST['guard_last_name']));
    $guard_height = htmlspecialchars(strip_tags($_POST['guard_height']));
    $guard_sex = htmlspecialchars(strip_tags($_POST['guard_sex']));
    $guard_phone = htmlspecialchars(strip_tags($_POST['guard_phone']));
    $guard_alt_phone = htmlspecialchars(strip_tags($_POST['guard_alt_phone']));
    $referral = htmlspecialchars(strip_tags($_POST['referral']));
    $referral_name = htmlspecialchars(strip_tags($_POST['referral_name']));
    $referral_address = htmlspecialchars(strip_tags($_POST['referral_address']));
    $referral_phone = htmlspecialchars(strip_tags($_POST['referral_phone']));
    $referral_fee = htmlspecialchars(strip_tags($_POST['referral_fee']));
    $guard_next_of_kin_name = htmlspecialchars(strip_tags($_POST['guard_next_of_kin_name']));
    $guard_next_of_kin_phone = htmlspecialchars(strip_tags($_POST['guard_next_of_kin_phone']));
    $guard_next_of_kin_relationship = htmlspecialchars(strip_tags($_POST['guard_next_of_kin_relationship']));
    $vetting = htmlspecialchars(strip_tags($_POST['vetting']));
    $guard_state_of_origin = htmlspecialchars(strip_tags($_POST['guard_state_of_origin']));
    $guard_dob = htmlspecialchars(strip_tags($_POST['guard_dob']));
    $guard_religion = htmlspecialchars(strip_tags($_POST['guard_religion']));
    $guard_qualification = htmlspecialchars(strip_tags($_POST['guard_qualification']));
    $guard_nickname = htmlspecialchars(strip_tags($_POST['guard_nickname']));
    $guard_address = htmlspecialchars(strip_tags($_POST['guard_address']));
    //step two
    $guarantor_title_number = count($_POST["guarantor_title"]);
    $data_gi = [];

    // step three
    $guard_id_Type = htmlspecialchars(strip_tags($_POST['guard_id_Type']));
    $guard_bank = htmlspecialchars(strip_tags($_POST['guard_bank']));
    $guard_acct_number = htmlspecialchars(strip_tags($_POST['guard_acct_number']));
    $guard_acct_name = htmlspecialchars(strip_tags($_POST['guard_acct_name']));

    $guard_blood_group = htmlspecialchars(strip_tags($_POST['guard_blood_group']));
    $guard_remark = htmlspecialchars(strip_tags($_POST['guard_remark']));
    $guard_status = 'Active';
    $guard_id = rand(1000000, 9999999);

    $created_at = date("Y-m-d H:i:s");

    if (!empty($guard_first_name) && !empty($guard_last_name) && !empty($guard_height) && !empty($guard_sex) && !empty($guard_phone)
        && !empty($referral) && !empty($guard_dob) && !empty($guard_next_of_kin_name) && !empty($guard_next_of_kin_phone)
        && !empty($guard_next_of_kin_relationship)&& !empty($vetting) && !empty($guard_state_of_origin) && !empty($guard_religion)
        && !empty($guard_qualification) && !empty($guard_address) && !empty($guard_id_Type) && !empty($guard_bank)
        && !empty($guard_acct_number) && !empty($guard_acct_name) && !empty($guard_blood_group)
    ) {
        if (!preg_match("/(0)[0-9]{10}/", $guard_phone)) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Guard Phone Number($guard_phone) Invalid"));
        } elseif (!preg_match("/(0)[0-9]{10}/", $guard_next_of_kin_phone)) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Next of Kin Phone Number($guard_next_of_kin_phone) Invalid"));
        } elseif (!preg_match("/[0-9]{9}/", $guard_acct_number)) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Account number must contain only 10 numbers"));
        }else {

        if ($guarantor_title_number > 0) {
            $error = 0;
            for ($i = 0; $i < $guarantor_title_number; $i++) {
                if ($_POST["guarantor_first_name"][$i]=='' || $_POST["guarantor_last_name"][$i]=='') {
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

                if (isset($_SESSION['COMPANY_LOGIN'])) {
                    $c_id = htmlspecialchars(strip_tags($_SESSION['COMPANY_LOGIN']['company_id']));
                    if (!empty($c_id)) {
                        if ($referral !== "Nobody") {
                            if (!empty($referral_name) && !empty($referral_address) && !empty($referral_phone)) {
                                if(empty($guard->check_if_guard_exist($guard_phone, $c_id))){
                                    $result = $guard->register_guard(
                                        $c_id, $client_id, $guard_id, $guard_first_name, $guard_middle_name, $guard_last_name,
                                        $guard_height, $guard_sex, $guard_phone, $guard_alt_phone, $referral, $referral_name,
                                        $referral_address, $referral_phone, $referral_fee,$guard_next_of_kin_name,
                                        $guard_next_of_kin_phone, $guard_next_of_kin_relationship, $vetting, $guard_state_of_origin,
                                        $guard_religion, $guard_dob, $guard_nickname, $guard_address, $guard_qualification,
                                        $gi_ti_1,$gi_fn_1,$gi_mn_1,$gi_ln_1,$gi_se_1,$gi_ph_1,$gi_em_1,$gi_yor_1,$gi_pow_1,$gi_ra_1,
                                        $gi_add_1,$gi_wad_1,$gi_idt_1,
                                        $gi_ti_2,$gi_fn_2,$gi_mn_2,$gi_ln_2,$gi_se_2,$gi_ph_2,$gi_em_2,$gi_yor_2,$gi_pow_2,$gi_ra_2,
                                        $gi_add_2,$gi_wad_2,$gi_idt_2,
                                        $gi_ti_3,$gi_fn_3,$gi_mn_3,$gi_ln_3,$gi_se_3,$gi_ph_3,$gi_em_3,$gi_yor_3,$gi_pow_3,$gi_ra_3,
                                        $gi_add_3,$gi_wad_3,$gi_idt_3,
                                        $guard_id_Type, $guard_bank, $guard_acct_number, $guard_acct_name,$guard_blood_group, $guard_remark,
                                        $guard_status, $created_at
                                    );
                                } else {
                                    http_response_code(200);
                                    echo json_encode(array("status" => 0, "message" => "Guard with the same phone number already exist."));
                                    exit();
                                }
                            } else {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "Referral Information are required. Select 'Nobody' if there is no referral"));
                            }
                        } else {
                            $referral_name = "";
                            $referral_address = "";
                            $referral_phone = "";
                            $referral_fee = "";
                            
                            if(empty($guard->check_if_guard_exist($guard_phone, $c_id))){
                                $result = $guard->register_guard(
                                    $c_id, $client_id, $guard_id, $guard_first_name, $guard_middle_name, $guard_last_name,
                                    $guard_height, $guard_sex, $guard_phone, $guard_alt_phone, $referral, $referral_name,
                                    $referral_address, $referral_phone, $referral_fee,$guard_next_of_kin_name,
                                    $guard_next_of_kin_phone, $guard_next_of_kin_relationship, $vetting, $guard_state_of_origin,
                                    $guard_religion, $guard_dob, $guard_nickname, $guard_address, $guard_qualification,
                                    $gi_ti_1,$gi_fn_1,$gi_mn_1,$gi_ln_1,$gi_se_1,$gi_ph_1,$gi_em_1,$gi_yor_1,$gi_pow_1,$gi_ra_1,
                                    $gi_add_1,$gi_wad_1,$gi_idt_1,
                                    $gi_ti_2,$gi_fn_2,$gi_mn_2,$gi_ln_2,$gi_se_2,$gi_ph_2,$gi_em_2,$gi_yor_2,$gi_pow_2,$gi_ra_2,
                                    $gi_add_2,$gi_wad_2,$gi_idt_2,
                                    $gi_ti_3,$gi_fn_3,$gi_mn_3,$gi_ln_3,$gi_se_3,$gi_ph_3,$gi_em_3,$gi_yor_3,$gi_pow_3,$gi_ra_3,
                                    $gi_add_3,$gi_wad_3,$gi_idt_3,
                                    $guard_id_Type, $guard_bank, $guard_acct_number, $guard_acct_name,$guard_blood_group, $guard_remark,
                                    $guard_status, $created_at
                                );
                            } else {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "Guard with the same phone number already exist."));
                                exit();
                            }
                        }

                        if ($result) {
                            $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                            $company->insert_notifications(
                                $c['company_id'], "General", "1", $c['staff_name'] . " Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                                url_path('/company/edit-guard/' . $guard_id, true, true), $c['staff_photo'], $c['staff_name']
                            );
                            $guard->insert_guard_log(
                                $c_id,$guard_id,"Info", "Add Guard",$created_at,
                                $g_det['guard_firstname']." ".$g_det['guard_lastname']." was Added to pool of guard",null
                            );
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Guard Registered"));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Guard not registered"));
                        }

                    }

                } else {
                    $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                    $c_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['company_id']));
                    $permission_sno = $privileges->get_register_guard_permission_id();
                    $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                    $array = array_map('intval', explode(',', $staff_perm_ids['perm_sno']));

                    if (!in_array($permission_sno['perm_sno'], $array)) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                    } else {
                        if (!empty($c_id)) {
                        if ($referral !== "Nobody") {
                            if (!empty($referral_name) && !empty($referral_address) && !empty($referral_phone)) {
                                if(empty($guard->check_if_guard_exist($guard_phone, $c_id))){
                                    $result = $guard->register_guard(
                                        $c_id, $client_id, $guard_id, $guard_first_name, $guard_middle_name, $guard_last_name,
                                        $guard_height, $guard_sex, $guard_phone, $guard_alt_phone, $referral, $referral_name,
                                        $referral_address, $referral_phone, $referral_fee,$guard_next_of_kin_name,
                                        $guard_next_of_kin_phone, $guard_next_of_kin_relationship, $vetting, $guard_state_of_origin,
                                        $guard_religion, $guard_dob, $guard_nickname, $guard_address, $guard_qualification,
                                        $gi_ti_1,$gi_fn_1,$gi_mn_1,$gi_ln_1,$gi_se_1,$gi_ph_1,$gi_em_1,$gi_yor_1,$gi_pow_1,$gi_ra_1,
                                        $gi_add_1,$gi_wad_1,$gi_idt_1,
                                        $gi_ti_2,$gi_fn_2,$gi_mn_2,$gi_ln_2,$gi_se_2,$gi_ph_2,$gi_em_2,$gi_yor_2,$gi_pow_2,$gi_ra_2,
                                        $gi_add_2,$gi_wad_2,$gi_idt_2,
                                        $gi_ti_3,$gi_fn_3,$gi_mn_3,$gi_ln_3,$gi_se_3,$gi_ph_3,$gi_em_3,$gi_yor_3,$gi_pow_3,$gi_ra_3,
                                        $gi_add_3,$gi_wad_3,$gi_idt_3,
                                        $guard_id_Type, $guard_bank, $guard_acct_number, $guard_acct_name,$guard_blood_group, $guard_remark,
                                        $guard_status, $created_at
                                    );
                                } else {
                                    http_response_code(200);
                                    echo json_encode(array("status" => 0, "message" => "Guard with the same phone number already exist."));
                                    exit();
                                }
                            } else {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "Referral Information are required. Select 'Nobody' if there is no referral"));
                            }
                        } else {
                            $referral_name = "";
                            $referral_address = "";
                            $referral_phone = "";
                            $referral_fee = "";
                            
                            if(empty($guard->check_if_guard_exist($guard_phone, $c_id))){
                                $result = $guard->register_guard(
                                    $c_id, $client_id, $guard_id, $guard_first_name, $guard_middle_name, $guard_last_name,
                                    $guard_height, $guard_sex, $guard_phone, $guard_alt_phone, $referral, $referral_name,
                                    $referral_address, $referral_phone, $referral_fee,$guard_next_of_kin_name,
                                    $guard_next_of_kin_phone, $guard_next_of_kin_relationship, $vetting, $guard_state_of_origin,
                                    $guard_religion, $guard_dob, $guard_nickname, $guard_address, $guard_qualification,
                                    $gi_ti_1,$gi_fn_1,$gi_mn_1,$gi_ln_1,$gi_se_1,$gi_ph_1,$gi_em_1,$gi_yor_1,$gi_pow_1,$gi_ra_1,
                                    $gi_add_1,$gi_wad_1,$gi_idt_1,
                                    $gi_ti_2,$gi_fn_2,$gi_mn_2,$gi_ln_2,$gi_se_2,$gi_ph_2,$gi_em_2,$gi_yor_2,$gi_pow_2,$gi_ra_2,
                                    $gi_add_2,$gi_wad_2,$gi_idt_2,
                                    $gi_ti_3,$gi_fn_3,$gi_mn_3,$gi_ln_3,$gi_se_3,$gi_ph_3,$gi_em_3,$gi_yor_3,$gi_pow_3,$gi_ra_3,
                                    $gi_add_3,$gi_wad_3,$gi_idt_3,
                                    $guard_id_Type, $guard_bank, $guard_acct_number, $guard_acct_name,$guard_blood_group, $guard_remark,
                                    $guard_status, $created_at
                                );
                            } else {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "Guard with the same phone number already exist."));
                                exit();
                            }
                        }

                        if ($result) {
                            $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                            $company->insert_notifications(
                                $c['company_id'], "General", "1", $c['staff_name'] . " Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                                url_path('/staff/edit-guard/' . $guard_id, true, true), $c['staff_photo'], $c['staff_name']
                            );
                            $guard->insert_guard_log(
                                $c_id,$guard_id,"Info", "Add Guard",$created_at,
                                $g_det['guard_firstname']." ".$g_det['guard_lastname']." was Added to pool of guard",null
                            );
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Guard Registered"));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Guard not registered"));
                        }
                        }
                    }
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "At least one guarantor Information required (fill required field)"));
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
                       