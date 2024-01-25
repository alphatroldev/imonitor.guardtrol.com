<?php
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Staff.class.php');
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = htmlspecialchars(strip_tags($_POST['c_email']));

    if (!empty($email)) {
        $g_data = $staff->staff_login($email);
        if (!empty($g_data)){
            $email = $g_data['staff_email'];
            if ($g_data['staff_type']=='Owner'){
                $location = url_path('/company/main',true,true);
                $account_arr = array(
                    "company_sno"=>$g_data['company_sno'],"company_id"=>$g_data['company_id'],"company_name"=>$g_data['company_name'],
                    "company_email"=>$g_data['company_email'],"com_created_at"=>$g_data['com_created_at'],
                    "company_description"  => $g_data['company_description'],"company_phone"=>$g_data['company_phone'],
                    "company_status"=>$g_data['company_status'],"company_first_login"=>$g_data['company_first_login'],
                    "company_address"=>$g_data['company_address'], 'company_logo'  => $g_data['company_logo'],
                    "staff_id"=>$g_data['staff_id'],
                );
                http_response_code(200);
                echo json_encode(array(
                    "status"=>1,"company_details"=>$account_arr,"message"=>"Company logged in successfully", "location"=>$location
                ));
                $_SESSION['COMPANY_LOGIN'] = $account_arr;
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Selected email is suspended or does not match any owners account."));
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