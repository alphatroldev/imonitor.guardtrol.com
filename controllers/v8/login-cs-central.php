<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Staff.class.php');
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));

    if (!empty($email) && !empty($password)) {
        $check_s_data = $staff->check_staff_email($email);
        $g_data = $staff->staff_login($email);

        if (!empty($check_s_data)){
            if (!empty($g_data)){
                $email = $g_data['staff_email'];
                $guard_password = $g_data['staff_password'];

                if (password_verify($password,$guard_password)) {

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
                        $_SESSION['COMPANY_LOGIN'] = $account_arr;
                        
                        // print_r( $_SESSION['COMPANY_LOGIN']); die;
                        http_response_code(200);
                        echo json_encode(array("status"=>1,"company_details"=>$account_arr,"message"=>"Company logged in successfully","location"=>$location));
                        
                    } else {
                        $location = url_path('/staff/main',true,true);
                        $account_arr = array(
                            "company_id"=>$g_data['company_id'],
                            "staff_sno"=>$g_data['staff_sno'],
                            "staff_id"=>$g_data['staff_id'],
                            "staff_firstname"=>$g_data['staff_firstname'],
                            "staff_middlename"=>$g_data['staff_middlename'],
                            "staff_lastname"=>$g_data['staff_lastname'],
                            "staff_name"=>$g_data['staff_firstname']." ".$g_data['staff_lastname'],
                            "staff_sex"=>$g_data['staff_sex'],
                            "staff_phone"=>$g_data['staff_phone'],
                            "staff_email"=>$g_data['staff_email'],
                            "staff_role"=>$g_data['staff_role'],
                            "staff_photo"=>$g_data['staff_photo'],
                            "staff_acc_status"=>$g_data['staff_acc_status'],
                            "staff_type"=>$g_data['staff_type'],
                        );
                        $_SESSION['STAFF_LOGIN'] = $account_arr;
                        http_response_code(200);
                        echo json_encode(array("status"=>1,"staff_details"=>$account_arr,"message"=>"Staff logged in successfully","location"=>$location));
                       
                    }
                } else {
                    http_response_code(200);
                    echo json_encode(array("status"=>0,"message"=>"Password incorrect. contact your supervisor / support."));
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Company account/email is in-active and awaiting guardtrol approval, you can contact our support for enquiry"));
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