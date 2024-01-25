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
    $report_title = htmlspecialchars(strip_tags($_POST['report_title']));
    $report_beat = htmlspecialchars(strip_tags($_POST['report_beat']));
    $report_occ_date = htmlspecialchars(strip_tags($_POST['report_occ_date']));
    $report_describe = htmlspecialchars(strip_tags($_POST['report_describe']));

    $r_id = 'RP'.rand(100000, 999999);
    $r_created_on = date("Y-m-d H:i:s");

    $files_number = count($_FILES["photo"]["name"]);
    $data = [];

    if (!empty($report_title) && !empty($report_beat) && !empty($report_occ_date) && !empty($report_describe) && !empty($r_created_on)) {
        if (isset($_SESSION['COMPANY_LOGIN'])){
            if ($files_number > 0) {
                $error = 0;
                for ($i = 0; $i < $files_number; $i++) {
                    $target_path = upload_path("uploads/reports/");
                    $ext = explode('.', basename( $_FILES['photo']['name'][$i]));
                    $new_name = "ph_".substr(md5(uniqid()),0,6) . "." . $ext[count($ext)-1];
                    $target_path = $target_path . $new_name;
                    if(move_uploaded_file($_FILES['photo']['tmp_name'][$i], $target_path)) {
                        $data[$i]['src'] = $new_name;
                    } else{
                        $error++;
                    }
                }

                if ($error == 0) {
                    $ph_1 = isset($data[0]['src']) ? $data[0]['src'] : "null";
                    $ph_2 = isset($data[1]['src']) ? $data[1]['src'] : "null";
                    $ph_3 = isset($data[2]['src']) ? $data[2]['src'] : "null";
                    $ph_4 = isset($data[3]['src']) ? $data[3]['src'] : "null";
                    $ph_5 = isset($data[4]['src']) ? $data[4]['src'] : "null";

                    $result = $company->create_report_incident($r_id,$c['company_id'],$c['staff_id'],$report_title,$report_beat,$report_occ_date,$report_describe,$ph_1,$ph_2,$ph_3,$ph_4,$ph_5,$r_created_on);
                    if ($result) {
                        $g_det = $beat->get_beat_details_by_id($report_beat);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Report an incident: ".$g_det['beat_name'],
                            url_path('/company/incidents/'.$r_id,true,true), $c['staff_photo'],$c['staff_name']
                        );
                        $beat->insert_beat_log(
                            $report_beat,$c['company_id'],$g_det['client_id'],"Info", "Incident Report: ",
                            $r_created_on," An incident was reported at ".$g_det['beat_name']." on ".$r_created_on." by staff: ".$c['staff_name'],
                            NULL
                        );
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Incident report submitted successfully"));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Failed to submit report, try again later."));
                    }
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Photo cannot be empty, kindly remove un wanted photo files",));
            }
        }else{
            $staff_id = htmlspecialchars(strip_tags($c['staff_id']));
            $permission_sno = $privileges->get_create_incident_rep_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            } else{
                if ($files_number > 0) {
                    $error = 0;
                    for ($i = 0; $i < $files_number; $i++) {
                        $target_path = upload_path("uploads/reports/");
                        $ext = explode('.', basename( $_FILES['photo']['name'][$i]));
                        $new_name = "ph_".substr(md5(uniqid()),0,6) . "." . $ext[count($ext)-1];
                        $target_path = $target_path . $new_name;
                        if(move_uploaded_file($_FILES['photo']['tmp_name'][$i], $target_path)) {
                            $data[$i]['src'] = $new_name;
                        } else{
                            $error++;
                        }
                    }

                    if ($error == 0) {
                        $ph_1 = isset($data[0]['src']) ? $data[0]['src'] : "null";
                        $ph_2 = isset($data[1]['src']) ? $data[1]['src'] : "null";
                        $ph_3 = isset($data[2]['src']) ? $data[2]['src'] : "null";
                        $ph_4 = isset($data[3]['src']) ? $data[3]['src'] : "null";
                        $ph_5 = isset($data[4]['src']) ? $data[4]['src'] : "null";

                        $result = $company->create_report_incident($r_id,$c['company_id'],$c['staff_id'],$report_title,$report_beat,$report_occ_date,$report_describe,$ph_1,$ph_2,$ph_3,$ph_4,$ph_5,$r_created_on);
                        if ($result) {
                            $g_det = $beat->get_beat_details_by_id($report_beat);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Report an incident: ".$g_det['beat_name'],
                                url_path('/company/incidents/'.$r_id,true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $beat->insert_beat_log(
                                $report_beat,$c['company_id'],$g_det['client_id'],"Info", "Incident Report: ",
                                $r_created_on," An incident was reported at ".$g_det['beat_name']." on ".$r_created_on." by staff: ".$c['staff_name'],
                                NULL
                            );
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Incident report submitted successfully"));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Failed to submit report, try again later."));
                        }
                    }
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Photo cannot be empty, kindly remove un wanted photo files",));
                }
            }
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Fill all required field",));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
