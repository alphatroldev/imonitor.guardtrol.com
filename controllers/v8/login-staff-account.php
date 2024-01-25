<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../classes/Staff.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    if (!empty($email) && !empty($password)) {
        $g_data = $staff->staff_login($email);
        if (!empty($g_data)){
            $email = $g_data['staff_email'];
            $guard_password = $g_data['staff_password'];

            if (password_verify($password,$guard_password)) {
                $account_arr = array(
                    "staff_sno"=>$g_data['staff_sno'],
                    "staff_id"=>$g_data['staff_id'],
                    "staff_firstname"=>$g_data['staff_firstname'],
                    "staff_middlename"=>$g_data['staff_middlename'],
                    "staff_lastname"=>$g_data['staff_lastname'],
                    "staff_sex"=>$g_data['staff_sex'],
                    "staff_phone"=>$g_data['staff_phone'],
                    "staff_email"=>$g_data['staff_email'],
                    "staff_role"=>$g_data['staff_role'],
                    "company_role_name"=>$g_data['company_role_name'],
                    "staff_photo"=>$g_data['staff_photo'],
                    "staff_acc_status"=>$g_data['staff_acc_status']
                );
                http_response_code(200);
                echo json_encode(array("status"=>1,"staff_details"=>$account_arr,"message"=>"Staff logged in successfully"));
                $_SESSION['STAFF_LOGIN'] = $account_arr;
            } else {
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Password incorrect. contact your supervisor."));
            }

        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Email does not match any staff record."));
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