<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Support.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $np = htmlspecialchars(strip_tags($_POST['password']));
    $r_np = htmlspecialchars(strip_tags($_POST['confirm_password']));
    $s_id = htmlspecialchars(strip_tags($_POST['support_id']));
    $s_email = htmlspecialchars(strip_tags($_POST['support_email']));

    if (!empty($np) && !empty($r_np) && !empty($s_id)) {
        $user_data = $support->login_support($s_email);
        if (!empty($user_data)) {
            $email = $user_data['support_email'];
            if (empty(trim($r_np)) || strlen($np) < 6) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "New/Repeat password must be at least six(6) character"));
            } else {
                if (trim($np) !== trim($r_np)) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "New password combination did not match, try again."));
                } else {
                    if (password_verify($np, $user_data['support_password'])) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "New password already in use. Try another password"));
                    } else {
                        $new_pwd = password_hash($np, PASSWORD_DEFAULT);
                        if ($support->update_support_password_by_id($new_pwd, $s_id)) {
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Support password has been updated. N.B. Password change takes effect on your next login."));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Failed to update user, contact admin via the help line"));
                        }
                    }
                }
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Support profile cannot be retrieve."));
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