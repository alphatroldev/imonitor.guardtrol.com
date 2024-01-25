<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
//include_once('../classes/Staff.class.php');
include_once(getcwd().'/controllers/classes/Staff.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $curr_pwd = htmlspecialchars(strip_tags(($_POST['old_password'])));
    $np = htmlspecialchars(strip_tags($_POST['password']));
    $r_np = htmlspecialchars(strip_tags($_POST['con_password']));
    $staff_sno = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_sno']));

    if (!empty($curr_pwd) && !empty($np) && !empty($r_np)) {
        $email = $_SESSION['STAFF_LOGIN']['staff_email'];
        $user_data = $staff->staff_login($email);
        if (!empty($user_data)) {
            $email = $user_data['staff_email'];
            $password_used = $user_data['staff_password'];
            if (password_verify($curr_pwd,$password_used)) {
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
                            echo json_encode(array("status" => 0, "message" => "New password already in use."));
                        } else {
                            $new_pwd = password_hash($np, PASSWORD_DEFAULT);
                            if ($staff->update_staff_personal_password($new_pwd, $staff_sno)) {
                                http_response_code(200);
                                echo json_encode(array("status" => 1, "message" => "Successfully Updated, your account password has been updated. logging you out now!"));
                            } else {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "Failed to update user, contact admin via the help line"));
                            }
                        }
                    }
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Invalid (current password) entered."));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Invalid session, try login again."));
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