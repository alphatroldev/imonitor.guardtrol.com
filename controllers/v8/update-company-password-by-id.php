<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Support.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $np = htmlspecialchars(strip_tags($_POST['password']));
    $r_np = htmlspecialchars(strip_tags($_POST['confirm_password']));
    $c_email = htmlspecialchars(strip_tags($_POST['company_email']));
    $staff_id = htmlspecialchars(strip_tags($_POST['staff_id']));

    if (!empty($np) && !empty($r_np) && !empty($staff_id) && !empty($c_email)) {
        $user_data = $support->get_company_by_email($c_email);
        if (!empty($user_data)) {
            if (empty(trim($r_np)) || strlen($np) < 6) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "New/Repeat password must be at least six(6) character"));
            } else {
                if (trim($np) !== trim($r_np)) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "New password combination did not match, try again."));
                } else {
                    if (password_verify($np, $user_data['staff_password'])) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "New password already in use. Try another password"));
                    } else {
                        $new_pwd = password_hash($np, PASSWORD_DEFAULT);
                        if ($support->update_company_password_by_id($new_pwd,$staff_id)) {
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Company password has been updated. N.B. Password change takes effect on their next login."));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Failed to update company password, contact admin via the help line"));
                        }
                    }
                }
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Company profile cannot be retrieve."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Kindly fill the required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>