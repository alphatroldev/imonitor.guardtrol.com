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
    // Client Basic Info
    $client_full_name = htmlspecialchars(strip_tags($_POST['client_full_name']));
    $client_office_address = htmlspecialchars(strip_tags($_POST['client_office_address']));
    $client_office_phone = htmlspecialchars(strip_tags($_POST['client_office_phone']));
    $client_email = htmlspecialchars(strip_tags($_POST['client_email']));
    //Client Contact's Info
//    $client_contact_full_name = htmlspecialchars(strip_tags($_POST['client_contact_full_name']));
//    $client_contact_phone = htmlspecialchars(strip_tags($_POST['client_contact_phone']));
//    $client_contact_email = htmlspecialchars(strip_tags($_POST['client_contact_email']));
//    $client_contact_full_name_2 = htmlspecialchars(strip_tags($_POST['client_contact_full_name_2']));
//    $client_contact_phone_2 = htmlspecialchars(strip_tags($_POST['client_contact_phone_2']));
//    $client_contact_email_2 = htmlspecialchars(strip_tags($_POST['client_contact_email_2']));
    $client_id_card_Type = htmlspecialchars(strip_tags($_POST['client_id_card_Type']));

    $client_contact_number = count($_POST["client_contact_full_name"]);
    $data_cc = [];

    $c_id = htmlspecialchars(strip_tags($c['company_id']));
    $created_at = date("Y-m-d H:i:s");


    if (!empty($client_full_name) &&!empty($client_office_address) &&!empty($client_office_phone) && !empty($client_email)) {

        $check_client_name = $client->check_client_name($client_full_name,$c_id);
        if (!empty($check_client_name)) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "$client_full_name already exist"));
        } else {
            $email_data = $client->check_client_email($client_email,$c_id);
            $client_status = "Active";
            if (!empty($email_data)) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Email ($client_email) already in use"));
            } else {
                if (!preg_match("/(0)[0-9]{10}/", $client_office_phone)) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Client Office Phone Number($client_office_phone) Invalid"));
                } else {
                $client_id = rand(1000000, 9999999);
                if (isset($_FILES['client_photo'])) {
                    $client_photo = upload_file($_FILES['client_photo'], upload_path('uploads/client/'), 'client_photo_'.str_replace(' ','',substr($client_full_name.$client_office_phone, 0, 5)), 'image', 500000000);
                    if($client_photo['status'] == 0) {
                        $client_photo['message'] = "null";
                    }
                }
                if (isset($_FILES['client_id_card_front'])) {
                    $client_id_card_front = upload_file($_FILES['client_id_card_front'], upload_path('uploads/client/'), 'client_id_card_front_'.str_replace(' ','',substr($client_full_name.$client_office_phone, 0, 5)), 'image', 500000000);
                    if($client_id_card_front['status'] == 0) {
                        $client_id_card_front['message'] = "null";
                    }
                }
                if (isset($_FILES['client_id_card_back'])) {
                    $client_id_card_back = upload_file($_FILES['client_id_card_back'], upload_path('uploads/client/'), 'client_id_card_back_'.str_replace(' ','',substr($client_full_name.$client_office_phone, 0, 5)), 'image', 500000000);
                    if($client_id_card_back['status'] == 0) {
                        $client_id_card_back['message'] = "null";
                    }
                }

                if ($client_contact_number > 0) {
                    $error = 0;
                    for ($i = 0; $i < $client_contact_number; $i++) {
                        if ($_POST["client_contact_full_name"][$i]=='' || $_POST["client_contact_position"][$i]==''
                            || $_POST["client_contact_phone"][$i]=='' || $_POST["client_contact_email"][$i]=='') {
                            $error = $error + 1;
                        } else {
                            $data_cc[$i]['client_contact_full_name'] = $_POST["client_contact_full_name"][$i];
                            $data_cc[$i]['client_contact_position'] = $_POST["client_contact_position"][$i];
                            $data_cc[$i]['client_contact_phone'] = $_POST["client_contact_phone"][$i];
                            $data_cc[$i]['client_contact_email'] = $_POST["client_contact_email"][$i];
                        }
                    }
                }

                if ($error == 0) {
                    $cc_fn_1 = isset($data_cc[0]['client_contact_full_name']) ? $data_cc[0]['client_contact_full_name'] : "null";
                    $cc_po_1 = isset($data_cc[0]['client_contact_position']) ? $data_cc[0]['client_contact_position'] : "null";
                    $cc_ph_1 = isset($data_cc[0]['client_contact_phone']) ? $data_cc[0]['client_contact_phone'] : "null";
                    $cc_ce_1 = isset($data_cc[0]['client_contact_email']) ? $data_cc[0]['client_contact_email'] : "null";

                    $cc_fn_2 = isset($data_cc[1]['client_contact_full_name']) ? $data_cc[1]['client_contact_full_name'] : "null";
                    $cc_po_2 = isset($data_cc[1]['client_contact_position']) ? $data_cc[1]['client_contact_position'] : "null";
                    $cc_ph_2 = isset($data_cc[1]['client_contact_phone']) ? $data_cc[1]['client_contact_phone'] : "null";
                    $cc_ce_2 = isset($data_cc[1]['client_contact_email']) ? $data_cc[1]['client_contact_email'] : "null";

                    $cc_fn_3 = isset($data_cc[2]['client_contact_full_name']) ? $data_cc[2]['client_contact_full_name'] : "null";
                    $cc_po_3 = isset($data_cc[2]['client_contact_position']) ? $data_cc[2]['client_contact_position'] : "null";
                    $cc_ph_3 = isset($data_cc[2]['client_contact_phone']) ? $data_cc[2]['client_contact_phone'] : "null";
                    $cc_ce_3 = isset($data_cc[2]['client_contact_email']) ? $data_cc[2]['client_contact_email'] : "null";

                    if (isset($_SESSION['COMPANY_LOGIN'])) {
                        if (!empty($c_id)) {
                            $result = $client->register_client($c_id, $client_id, $client_full_name, $client_office_address, $client_office_phone, $client_email,
                                $cc_fn_1, $cc_po_1, $cc_ph_1, $cc_ce_1,$cc_fn_2,$cc_po_2,$cc_ph_2,$cc_ce_2,
                                $cc_fn_3, $cc_po_3,$cc_ph_3, $cc_ce_3, $client_photo['message'], $client_status, $client_id_card_Type,
                                $client_id_card_front['message'], $client_id_card_back['message'], $created_at);
                            if ($result) {
                                 $company->insert_notifications(
                                    $c['company_id'], "General", "1", $c['staff_name'] . " Create a new client: ".$client_full_name,
                                    url_path('/company/edit-client/' . $client_id, true, true), $c['staff_photo'], $c['staff_name']
                                );
                                http_response_code(200);
                                echo json_encode(array("status" => 1, "message" => "Client Registered"));
                            } else {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "Client not registered"));
                            }
                        }
                    } else {
                        $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                        $permission_sno = $privileges->get_create_client_permission_id();
                        $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                        $array = array_map('intval', explode(',', $staff_perm_ids['perm_sno']));

                        if (!in_array($permission_sno['perm_sno'], $array)) {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                        } else {

                            if (!empty($c_id)) {
                                $result = $client->register_client($c_id, $client_id, $client_full_name, $client_office_address, $client_office_phone, $client_email,
                                    $cc_fn_1, $cc_po_1, $cc_ph_1, $cc_ce_1,$cc_fn_2,$cc_po_2,$cc_ph_2,$cc_ce_2,
                                    $cc_fn_3, $cc_po_3,$cc_ph_3, $cc_ce_3, $client_photo['message'], $client_status, $client_id_card_Type,
                                    $client_id_card_front['message'], $client_id_card_back['message'], $created_at);
                                if ($result) {
                                    $company->insert_notifications(
                                        $c['company_id'], "General", "1", $c['staff_name'] . " Create a new client: ".$client_full_name,
                                        url_path('/company/edit-client/' . $client_id, true, true), $c['staff_photo'], $c['staff_name']
                                    );
                                    http_response_code(200);
                                    echo json_encode(array("status" => 1, "message" => "Client Registered"));
                                } else {
                                    http_response_code(200);
                                    echo json_encode(array("status" => 0, "message" => "Client not registered"));
                                }
                            }
                        }
                    }
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Fill all required field"));
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