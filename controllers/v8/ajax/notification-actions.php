<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Company.class.php');


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (trim($data->action_code) == '101' && !empty(trim($data->comp_id)) && !empty(trim($data->note_id))) {
        if ($company->update_notification_status($data->comp_id,$data->note_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "done"));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update status."));
        }
    }
}