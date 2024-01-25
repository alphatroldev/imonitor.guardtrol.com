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
    $bs_email = htmlspecialchars(strip_tags($_POST['bs_email']));
    $bs_firstname = htmlspecialchars(strip_tags($_POST['bs_firstname']));
    $bs_lastname = htmlspecialchars(strip_tags($_POST['bs_lastname']));
    $bs_pwd = htmlspecialchars(strip_tags($_POST['bs_pwd']));
    $bs_con_pwd = htmlspecialchars(strip_tags($_POST['bs_con_pwd']));

    $bsu_id = rand(100000,999999);
    $comp_id = $c['company_id'];
    $created_on = date("Y-m-d H:i:s");

    $bs_super_count = count($_POST["bs_beats"]);
    $bs_super = [];

    if (!empty($bs_email) &&!empty($bs_firstname) &&!empty($bs_lastname) &&!empty($bs_pwd)) {
        if ($bs_pwd == $bs_con_pwd) {
            if ($bs_super_count > 0) {
                $bs_beat_str = implode(',', $_POST['bs_beats']);

                if (isset($_SESSION['COMPANY_LOGIN'])){
                    $result = $beat->create_beat_supervisor($bsu_id,$comp_id,$bs_email,$bs_firstname,$bs_lastname,$bs_beat_str,$bs_pwd,$created_on);
                    
                    if ($result) {
                        $company->insert_notifications(
                            $comp_id,"General","1", $c['staff_name']." Create a new beat supervisor: ".$bs_firstname." ".$bs_lastname,
                            url_path('/company/edit-beat-supervisor/'.$bsu_id,true,true), $c['staff_photo'],$c['staff_name']
                        );
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Beat supervisor created successfully"));
                    }else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Beat supervisor cannot be created"));
                    }
                } else {
                    $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                    $permission_sno = $privileges->get_create_beat_permission_id();
                    $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                    $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

                    if(!in_array($permission_sno['perm_sno'], $array)){
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                    } else {
                        $result = $beat->create_beat_supervisor($bsu_id,$comp_id,$bs_email,$bs_firstname,$bs_lastname,$bs_beat_str,$bs_pwd,$created_on);
                        if ($result) {
                            $company->insert_notifications(
                                $comp_id,"General","1", $c['staff_name']." Create a new beat supervisor: ".$bs_firstname." ".$bs_lastname,
                                url_path('/company/edit-beat-supervisor/'.$bsu_id,true,true), $c['staff_photo'],$c['staff_name']
                            );
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Beat supervisor created successfully"));
                        }else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Beat supervisor cannot be created"));
                        }
                    }
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Select at least one beat, and try again"));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Password combination do not matched, try new password"));
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