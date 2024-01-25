<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

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
    // step 1
    $client_id = htmlspecialchars(strip_tags($_POST['client_id']));
    $beat_name = htmlspecialchars(strip_tags($_POST['beat_name']));
    $beat_address = htmlspecialchars(strip_tags($_POST['beat_address']));
    $beat_monthly_charges = htmlspecialchars(strip_tags($_POST['beat_monthly_charges']));
    $beat_vat = htmlspecialchars(strip_tags($_POST['beat_vat']));
    $date_of_deployment = htmlspecialchars(strip_tags($_POST['date_of_deployment']));

    $personnel_count = count($_POST["no_of_personnel"]);
    $personnel = [];
    $c_id = $c['company_id'];

    $created_at = date("d-m-y H:i:s");
    if (!empty($client_id) &&!empty($beat_name) &&!empty($beat_address) &&!empty($beat_monthly_charges) &&!empty($date_of_deployment)) {
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
            $check_beat_name = $beat->check_beat_name($beat_name,$client_id,$c_id);
            if (!empty($check_beat_name)) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "$beat_name already exist"));
            } else {
                $beat_status = "Active";
                $beat_id = rand(1000000, 9999999);

                if (isset($_SESSION['COMPANY_LOGIN'])){
                    if (!empty($c_id)) {
                        $result = $beat->create_beat(
                            $beat_id, $c_id, $client_id, $beat_name, $beat_address,$beat_monthly_charges, $beat_status,
                            $beat_vat,$date_of_deployment,$created_at
                        );
                        if ($result) {
                            foreach ($personnel as $person){
                                $company->create_beat_personnel_services($c_id,$beat_id,$person['no_of_personnel'],$person['personnel_type'],$person['personnel_amt']);
                            }
                            $company->insert_notifications(
                                $c_id,"General","1", $c['staff_name']." Create a new beat: ".$beat_name,
                                url_path('/company/edit-beat/'.$beat_id,true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $g_det = $beat->get_beat_details_by_id($beat_id);
                            $beat->insert_beat_log(
                                $beat_id,$c['company_id'],$g_det['client_id'],"Info", "New beat",
                                $created_at,$g_det['beat_name']." was created and deployed on ".$date_of_deployment." by Staff: ".$c['staff_name'],NULL
                            );
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Beat created"));
                        }else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Beat not created"));
                        }
                    }
                } else {
                    $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                    $permission_sno = $privileges->get_create_beat_permission_id();
                    $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                    $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

                    if(!in_array($permission_sno['perm_sno'], $array)){
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                    } else{
                        if (!empty($c_id)) {
                            $result = $beat->create_beat(
                            $beat_id, $c_id, $client_id, $beat_name, $beat_address,$beat_monthly_charges, $beat_status,
                            $beat_vat,$date_of_deployment,$created_at
                        );
                        if ($result) {
                            foreach ($personnel as $person){
                                $company->create_beat_personnel_services($c_id,$beat_id,$person['no_of_personnel'],$person['personnel_type'],$person['personnel_amt']);
                            }
                            $company->insert_notifications(
                                $c_id,"General","1", $c['staff_name']." Create a new beat: ".$beat_name,
                                url_path('/staff/edit-beat/'.$beat_id,true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $g_det = $beat->get_beat_details_by_id($beat_id);
                            $beat->insert_beat_log(
                                $beat_id,$c['company_id'],$g_det['client_id'],"Info", "New beat",
                                $created_at,$g_det['beat_name']." was created and deployed on ".$date_of_deployment." by Staff: ".$c['staff_name'],NULL
                            );
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Beat created"));
                        }else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Beat not created"));
                        }
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
        echo json_encode(array("status" => 0, "message" => "Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>