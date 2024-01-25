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
    $password = htmlspecialchars(strip_tags($_POST['password']));
    $client_id = htmlspecialchars(strip_tags($_POST['client_id']));
    $confirm_password = htmlspecialchars(strip_tags($_POST['confirm_password']));

    if (!empty($client_id) &&!empty($password) &&!empty($confirm_password)) {
        if ($password == $confirm_password) {
            if (isset($_SESSION['COMPANY_LOGIN'])) {
                $result = $client->update_client_login_password($password, $client_id);
                if ($result) {
                    $company->insert_notifications(
                        $c['company_id'], "General", "1", $c['staff_name'] . " Update a client login password ID: " . $client_id,
                        url_path('/company/edit-client-login-profile/'.$client_id, true, true), $c['staff_photo'], $c['staff_name']
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Client login updated successfully"));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Client login cannot be updated"));
                }
            } else {
                $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                $permission_sno = $privileges->get_create_beat_permission_id();
                $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                $array = array_map('intval', explode(',', $staff_perm_ids['perm_sno']));

                if (!in_array($permission_sno['perm_sno'], $array)) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                } else {
                    $result = $client->update_client_login_password($password, $client_id);
                    if ($result) {
                        $company->insert_notifications(
                            $c['company_id'], "General", "1", $c['staff_name'] . " Update a client login password ID: " . $client_id,
                            url_path('/company/edit-client-login-profile/'.$client_id, true, true), $c['staff_photo'], $c['staff_name']
                        );
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Client login updated successfully"));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Client login cannot be updated"));
                    }
                }
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