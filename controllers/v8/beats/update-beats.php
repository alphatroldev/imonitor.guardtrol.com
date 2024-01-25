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


// $_SESSION['COMPANY_LOGIN'] = array("Gooood"=>"Testing mme");
// print_r($_SESSION['COMPANY_LOGIN']); die;


include_once(getcwd().'/company/inc/helpers.php');
include_once(getcwd().'/staff/inc/helpers.php');
if (isset($_SESSION['COMPANY_LOGIN'])){
    $c = get_company();
}else{
    $c = get_staff();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $beat_sno = htmlspecialchars(strip_tags($_POST['beat_sno']));
    $edit_beat_name = htmlspecialchars(strip_tags($_POST['edit_beat_name']));
    $edit_beat_address = htmlspecialchars(strip_tags($_POST['edit_beat_address']));
    $edit_beat_monthly_charges = htmlspecialchars(strip_tags($_POST['edit_beat_monthly_charges']));
    $edit_beat_vat = htmlspecialchars(strip_tags($_POST['edit_beat_vat']));
    $edit_date_of_deployment = htmlspecialchars(strip_tags($_POST['edit_date_of_deployment']));
    $client_id = htmlspecialchars(strip_tags($_POST['client_id']));
    $beat_id = htmlspecialchars(strip_tags($_POST['beat_id']));
    $updated_at = date("Y-m-d H:i:s");

    $personnel_count = count($_POST["no_of_personnel"]);
    $personnel = [];

    if (!empty($beat_sno) && !empty($edit_beat_name) && !empty($edit_beat_address)&& !empty($edit_beat_monthly_charges)  &&
        !empty($edit_beat_vat)  && !empty($edit_date_of_deployment)) {
        if ($personnel_count > 0) {
            $error = 0;
            for ($i = 0; $i < $personnel_count; $i++) {
                if ($_POST["no_of_personnel"][$i]=='' || $_POST["personnel_type"][$i]=='' || $_POST["personnel_amt"][$i]=='') {
                    $error = $error + 1;
                } else {
                    $personnel[$i]['no_of_personnel'] = $_POST["no_of_personnel"][$i];
                    $personnel[$i]['personnel_type'] = $_POST["personnel_type"][$i];
                    $personnel[$i]['personnel_amt'] = $_POST["personnel_amt"][$i];
                }
            }
        }

        if ($error == 0) {
            $check_beat_name = $beat->check_beat_name_for_update($edit_beat_name, $client_id, $c['company_id'], $beat_sno);
            if (!empty($check_beat_name)) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "$edit_beat_name already exist"));
            } else {
                if (isset($_SESSION['COMPANY_LOGIN'])) {
                    $result = $beat->update_beats($c['company_id'], $beat_sno, $edit_beat_name, $edit_beat_address,
                        $edit_beat_monthly_charges, $edit_beat_vat, $edit_date_of_deployment, $updated_at);
                    if ($result == true) {
                        $beat->delete_beat_personnel_services($c['company_id'],$beat_id);
                        foreach ($personnel as $person){
                            $company->create_beat_personnel_services($c['company_id'],$beat_id,$person['no_of_personnel'],$person['personnel_type'],$person['personnel_amt']);
                        }
                         $company->insert_notifications(
                            $c['company_id'], "General", "1", $c['staff_name'] . " Update beat: $edit_beat_name profile",
                            url_path('/company/edit-beat/' . $beat_id, true, true), $c['staff_photo'], $c['staff_name']
                        );
                        $beat->insert_beat_log(
                            $beat_id,$c['company_id'],$client_id,"Info", "Update beat details",
                            $updated_at," update beat info ",NULL
                        );
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Update Successful."));
                    } else if ($result == "no_change") {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Update failed, no changes found."));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Update failed."));
                    }

                } else {
                    $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                    $permission_sno = $privileges->get_update_beat_permission_id();
                    $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                    $array = array_map('intval', explode(',', $staff_perm_ids['perm_sno']));

                    if (!in_array($permission_sno['perm_sno'], $array)) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                    } else {
                        $result = $beat->update_beats($c['company_id'], $beat_sno, $edit_beat_name, $edit_beat_address,
                            $edit_beat_monthly_charges, $edit_beat_vat, $edit_date_of_deployment, $updated_at);
                        if ($result == true) {
                            $beat->delete_beat_personnel_services($c['company_id'],$beat_id);
                            foreach ($personnel as $person){
                                $company->create_beat_personnel_services($c['company_id'],$beat_id,$person['no_of_personnel'],$person['personnel_type'],$person['personnel_amt']);
                            }
                            $company->insert_notifications(
                                $c['company_id'], "General", "1", $c['staff_name'] . "  Update beat: $edit_beat_name profile",
                                url_path('/company/edit-beat/' . $beat_id, true, true), $c['staff_photo'], $c['staff_name']
                            );
                            $beat->insert_beat_log(
                                $beat_id,$c['company_id'],$client_id,"Info", "Update beat details",
                                $updated_at," update beat info ",NULL
                            );
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Update Successful."));
                        } else if ($result == "no_change") {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Update failed, no changes found."));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Update failed."));
                        }
                    }
                }
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "One or more required field empty"));
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