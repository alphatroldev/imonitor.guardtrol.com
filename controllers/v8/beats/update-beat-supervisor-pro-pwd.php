<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Beat.class.php');
include_once(getcwd().'/controllers/classes/Supervisor.class.php');
include_once(getcwd().'/controllers/classes/Company.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $bs_old_pwd = htmlspecialchars(strip_tags($_POST['bs_old_pwd']));
    $bs_pwd = htmlspecialchars(strip_tags($_POST['bs_pwd']));
    $bs_con_pwd = htmlspecialchars(strip_tags($_POST['bs_con_pwd']));
    $bs_id = htmlspecialchars(strip_tags($_POST['bs_id']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));

    if (!empty($bs_old_pwd) &&!empty($bs_pwd) &&!empty($bs_con_pwd) &&!empty($bs_id)) {
        $bsu = $beat->get_beat_supervisor_by_id($bs_id,$comp_id);
        $bSuper = $bsu->fetch_assoc();
        if (password_verify($bs_old_pwd,$bSuper['bsu_password'])) {
            if ($bs_pwd == $bs_con_pwd) {
                $result = $beat->update_beat_supervisor_password($bs_pwd, $bs_id);
                if ($result) {
                    $company->insert_notifications(
                        $comp_id, "General", "1", $bSuper['bsu_firstname']." Update a his supervisor detail: ".$bSuper['bsu_firstname']." ".$bSuper['bsu_lastname'],
                        url_path('/company/edit-beat-supervisor/'.$bs_id, true, true),"null","AVK Security"
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