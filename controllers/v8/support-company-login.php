<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Company.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = htmlspecialchars(strip_tags($_POST['c_email']));

    if (!empty($email)) {
        $c_data = $company->login_company($email);

        if (!empty($c_data)){
            if ($c_data['staff_acc_status']=="Deactivate"){
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Your account has been suspended, contact guardtrol support."));
            } else {
                $account_arr = array(
                    "company_sno"=>$c_data['company_sno'],"company_id"=>$c_data['company_id'],"company_name"=>$c_data['company_name'],
                    "company_email"=>$c_data['company_email'],"com_created_at"=>$c_data['com_created_at'],'company_description'  => $c_data['company_description'],
                    "company_phone"=>$c_data['company_phone'],"company_status"=>$c_data['company_status'],"company_first_login"=>$c_data['company_first_login'],
                    'company_address'=>$c_data['company_address'], 'company_logo'  => $c_data['company_logo'],
                );
                http_response_code(200);
                echo json_encode(array("status"=>1,"company_details"=>$account_arr,"message"=>"Company logged in successfully"));
                $_SESSION['COMPANY_LOGIN'] = $account_arr;
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