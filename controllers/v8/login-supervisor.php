<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Supervisor.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    if (!empty($email) && !empty($password)) {
        $s_data = $supervisor->login_supervisor($email);
        if (!empty($s_data)){
            $s_email = $s_data['bsu_email'];
            $s_password = $s_data['bsu_password'];

            if ($s_data['bsu_active'] == "No") {
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Your account has been suspended, contact admin."));
            } else {
                if (password_verify($password,$s_password)) {
                    $account_arr = array(
                        "bsu_sno"=>$s_data['bsu_sno'],"bsu_id"=>$s_data['bsu_id'],"bsu_company_id"=>$s_data['bsu_company_id'],
                        "bsu_email"=>$s_data['bsu_email'],"bsu_firstname"=>$s_data['bsu_firstname'],"bsu_lastname"=>$s_data['bsu_lastname'],
                        "bsu_beats"=>$s_data['bsu_beats'],"bsu_active"=>$s_data['bsu_active'],"bsu_created_at"=>$s_data['bsu_created_at']
                    );
                    http_response_code(200);
                    echo json_encode(
                        array(
                            "status"=>1,"supervisor_details"=>$account_arr,"message"=>"Beat supervisor logged in successfully",
                            "location"=> url_path('/supervisor/main',true,true)
                        )
                    );
                    $_SESSION['SUPERVISOR_LOGIN'] = $account_arr;
                } else {
                    http_response_code(200);
                    echo json_encode(array("status"=>0,"message"=>"Password incorrect. Try forgot password."));
                }
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Email do not match any record."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>