<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Support.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    if (!empty($email) && !empty($password)) {
        $s_data = $support->login_support($email);
        if (!empty($s_data)){
            $s_email = $s_data['support_email'];
            $s_password = $s_data['support_password'];

            if ($s_data['support_active']=="No"){
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Your account has been suspended, contact your supervisor."));
            } else {
                if (password_verify($password,$s_password)) {
                    $account_arr = array(
                        "support_sno"=>$s_data['support_sno'],"support_id"=>$s_data['support_id'],"support_name"=>$s_data['support_name'],
                        "support_email"=>$s_data['support_email'],"support_created_on"=>$s_data['support_created_on'],
                        "support_super"=>$s_data['support_super'],"support_active"=>$s_data['support_active']
                    );
                    http_response_code(200);
                    echo json_encode(array("status"=>1,"support_details"=>$account_arr,"message"=>"Support logged in successfully","location"=> url_path('/support/main',true,true)));
                    $_SESSION['SUPPORT_LOGIN'] = $account_arr;
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