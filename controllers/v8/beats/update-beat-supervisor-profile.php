<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Beat.class.php');
include_once(getcwd().'/controllers/classes/Supervisor.class.php');
include_once(getcwd().'/controllers/classes/Company.class.php');


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $bs_firstname = htmlspecialchars(strip_tags($_POST['bs_firstname']));
    $bs_lastname = htmlspecialchars(strip_tags($_POST['bs_lastname']));
    $bs_email = htmlspecialchars(strip_tags($_POST['bs_email']));
    $bs_id = htmlspecialchars(strip_tags($_POST['bs_id']));
    $comp_id = htmlspecialchars(strip_tags($_POST['comp_id']));

    if (!empty($bs_email) &&!empty($bs_firstname) &&!empty($bs_lastname) &&!empty($bs_id)) {
        $result = $supervisor->update_beat_supervisor($bs_email,$bs_firstname,$bs_lastname,$bs_id);
        if ($result) {
            $company->insert_notifications(
                $comp_id,"General","1", $bs_firstname." Update a his supervisor detail: ".$bs_firstname." ".$bs_lastname,
                url_path('/company/edit-beat-supervisor/'.$bs_id,true,true),"null","AVK Security"
            );
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Profile updated successfully"));
        }else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Profile cannot be updated"));
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