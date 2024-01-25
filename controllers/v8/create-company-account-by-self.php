<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Company.class.php');
include_once(getcwd().'/company/inc/helpers.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $c_name = htmlspecialchars(strip_tags($_POST['c_name']));
    $c_email = htmlspecialchars(strip_tags($_POST['c_email']));
    $c_address = htmlspecialchars(strip_tags($_POST['c_address']));
    $c_phone = htmlspecialchars(strip_tags($_POST['c_phone']));
    $c_password = htmlspecialchars(strip_tags($_POST['password']));
    $c_c_password = htmlspecialchars(strip_tags($_POST['confirm_password']));
    $c_reg_no = htmlspecialchars(strip_tags($_POST['c_reg_no']));
    $c_logo="";

    $c_id = rand(1000000, 9999999);
    $c_created_on = date("Y-m-d H:i:s");

    $uploadDir = upload_path("uploads/company/");
    $images = $_FILES;
    $data = [];

    $err = 0;
    foreach ($images as $key => $image) {
        $name = strtolower($image['name']);
        $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $targetFilePath = $uploadDir . $name;
        $allowTypes = array('jpg', 'png', 'jpeg');

        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
                $data[$key]['success'] = true;
                $data[$key]['src'] = $name;
            } else {
                $data[$key]['success'] = false;
                $data[$key]['src'] = $name;
                ++$err;
            }
        }
    }

    if ($err == 0) {
        $c_logo = isset($data['c_logo']['src']) ? $data['c_logo']['src'] : "null";
        if (!empty($c_name) && !empty($c_email) && !empty($c_address) && !empty($c_phone) && !empty($c_password) && !empty($c_c_password) && !empty($c_id) && !empty($c_created_on)) {
            if ($c_password !== $c_c_password) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Password not matched."));
            } else {
                $email_data = $company->check_email($c_email);
                if (!empty($email_data)) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "company account with " . $c_email . " already exist. Kindly contact our support"));
                } else {
                    $c_data = $company->create_company_instance_self($c_id,$c_name,$c_email,$c_address,$c_phone,$c_password,$c_logo,$c_reg_no,$c_created_on);

                    if ($c_data) {
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "company account has been successfully created, our customer support will contact you shortly. Thank you"));
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
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Error uploading company logo"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
