<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Beat.class.php');
include_once(getcwd().'/controllers/classes/Client.class.php');
include_once(getcwd().'/controllers/classes/Company.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $cli_old_pwd = htmlspecialchars(strip_tags($_POST['cli_old_pwd']));
    $cli_pwd = htmlspecialchars(strip_tags($_POST['cli_pwd']));
    $cli_con_pwd = htmlspecialchars(strip_tags($_POST['cli_con_pwd']));
    $cli_id = htmlspecialchars(strip_tags($_POST['cli_id']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));

    if (!empty($cli_old_pwd) &&!empty($cli_pwd) &&!empty($cli_con_pwd) &&!empty($cli_id)) {
        $cli = $client->get_client_login_by_id($cli_id,$comp_id);
        $client_o = $cli->fetch_assoc();
        if (password_verify($cli_old_pwd,$client_o['clp_password'])) {
            if ($cli_pwd == $cli_con_pwd) {
                $result = $client->update_client_login_password($cli_pwd, $cli_id);
                if ($result) {
                    $company->insert_notifications(
                        $comp_id, "General", "1", $client_o['client_fullname']." Update a profile detail",
                        url_path('/company/edit-client-login-profile/'.$cli_id, true, true),"null","AVK Security"
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Profile password updated successfully"));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Profile password cannot be updated"));
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Password combination do not matched, try new password"));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Old password entered is incorrect, try again"));
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