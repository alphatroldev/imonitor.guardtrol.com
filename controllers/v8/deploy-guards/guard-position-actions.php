<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/DeployGuard.class.php');


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (trim($data->action_code) == '101' && !empty(trim($data->comp_id)) && !empty(trim($data->pos_sno))) {
        if ($deploy_guard->delete_guard_position($data->comp_id,$data->pos_sno)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Position deleted successfully.","location"=>url_path('/company/guard-positions',true,true)));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete position."));
        }
    }
}