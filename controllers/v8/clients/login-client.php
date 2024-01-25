<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    if (!empty($email) && !empty($password)) {
        $c_data = $client->login_client($email);
        if (!empty($c_data)){
            $c_email = $c_data['client_email'];
            $c_password = $c_data['clp_password'];

            if ($c_data['clp_status'] == "Inactive") {
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Your account has been suspended, contact admin."));
            } else {
                if (password_verify($password,$c_password)) {
                    $account_arr = array(
                        "cli_id"=>$c_data['client_id'],"cli_company_id"=>$c_data['company_id'],
                        "cli_email"=>$c_data['client_email'],"cli_fullname"=>$c_data['client_fullname'],
                        "cli_status"=>$c_data['clp_status'],"cli_created_at"=>$c_data['clp_created_on']
                    );
                    http_response_code(200);
                    echo json_encode(
                        array(
                            "status"=>1,"client_details"=>$account_arr,"message"=>"Client logged in successfully",
                            "location"=> url_path('/client/main',true,true)
                        )
                    );
                    $_SESSION['CLIENT_LOGIN'] = $account_arr;
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