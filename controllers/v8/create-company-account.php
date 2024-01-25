<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Support.class.php');
include_once(getcwd().'/company/inc/helpers.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $c_name = htmlspecialchars(strip_tags($_POST['c_name']));
    $c_email = htmlspecialchars(strip_tags($_POST['c_email']));
    $c_address = htmlspecialchars(strip_tags($_POST['c_address']));
    $c_phone = htmlspecialchars(strip_tags($_POST['c_phone']));
    $c_descr = htmlspecialchars(strip_tags($_POST['c_descr']));
    $c_guard_str = htmlspecialchars(strip_tags($_POST['c_guard_str']));
    $c_op_state = htmlspecialchars(strip_tags($_POST['c_op_state']));
    $c_op_number = htmlspecialchars(strip_tags($_POST['c_op_number']));
    $c_reg_no = htmlspecialchars(strip_tags($_POST['c_reg_no']));
    $c_tax_id = htmlspecialchars(strip_tags($_POST['c_tax_id']));
    $c_logo="";
    $c_op_license="";
    $c_password = htmlspecialchars(strip_tags($_POST['password']));
    $c_c_password = htmlspecialchars(strip_tags($_POST['confirm_password']));

    $c_id = rand(1000000, 9999999);
    $c_created_on = date("Y-m-d H:i:s");

    if (!empty($c_name) && !empty($c_email) && !empty($c_address) && !empty($c_phone) && !empty($c_password)
        && !empty($c_c_password) && !empty($c_id) && !empty($c_created_on)) {
        if ($c_password != $c_c_password) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Password not matched."));
        } else {
            $email_data = $support->check_company_email($c_email);
            if (!empty($email_data)) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "company account with " . $c_email . " already exist."));
            } else {
                if (isset($_FILES['c_logo'])) {
                $c_logo = upload_file($_FILES['c_logo'], upload_path('uploads/company/'), 'logo_'.str_replace(' ','',substr($c_name.$c_phone, 0, 5)), 'image', 500000000);
                if($c_logo['status'] == 0) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => $c_logo['message']));
                    return;
                }
            }
                if (isset($_FILES['c_op_license'])) {
                    $c_op_license = upload_file($_FILES['c_op_license'], upload_path('uploads/company/'), 'license_'.str_replace(' ','',substr($c_name.$c_phone, 0, 5)), 'doc', 50000000);
                    if ($c_op_license['status'] == 0) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => $c_op_license['message']));
                        return;
                    }
                }

                $c_data = $support->create_company_instance(
                    $c_id,$c_name,$c_email,$c_address,$c_phone,$c_descr, $c_guard_str,$c_op_state,$c_op_number,
                    $c_reg_no,$c_tax_id,$c_password,$c_logo['message'],$c_op_license['message'],$c_created_on
                );
                if ($c_data) {
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "company account has been successfully created."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Server error, could not create company instance"));
                }
            }
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
