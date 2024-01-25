<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Beat.class.php');
include_once(getcwd().'/controllers/classes/Supervisor.class.php');
include_once(getcwd().'/controllers/classes/Company.class.php');


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $request_id = htmlspecialchars(strip_tags($_POST['request_id']));
    $request_status = htmlspecialchars(strip_tags($_POST['request_status']));

    if (!empty($request_id) && !empty($request_status)) {
        $result = $supervisor->update_guard_clockout_request_status($request_id,$request_status);
        if ($result) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Request status updated successfully"));
        }else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Request status cannot be updated"));
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