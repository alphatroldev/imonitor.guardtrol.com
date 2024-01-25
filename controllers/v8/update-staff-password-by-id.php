<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once(getcwd().'/controllers/classes/Beat.class.php');
include_once(getcwd().'/controllers/classes/Client.class.php');
include_once(getcwd().'/controllers/classes/DeployGuard.class.php');
include_once(getcwd().'/controllers/classes/Guard.class.php');
include_once(getcwd().'/controllers/classes/Company.class.php');
include_once(getcwd().'/controllers/classes/Staff.class.php');
include_once(getcwd().'/controllers/classes/Privileges.class.php');
include_once(getcwd().'/company/inc/helpers.php');
include_once(getcwd().'/staff/inc/helpers.php');
if (isset($_SESSION['COMPANY_LOGIN'])){
    $c = get_company();
}else{
    $c = get_staff();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $np = htmlspecialchars(strip_tags($_POST['password']));
    $r_np = htmlspecialchars(strip_tags($_POST['confirm_password']));
    $staff_sno = htmlspecialchars(strip_tags($_POST['staff_sno']));
    $staff_id = htmlspecialchars(strip_tags($_POST['staff_id']));
    $s_email = htmlspecialchars(strip_tags($_POST['staff_email']));

    $c_id = htmlspecialchars(strip_tags($_SESSION['COMPANY_LOGIN']['company_id']));


    if (!empty($np) && !empty($r_np) && !empty($staff_sno)) {
        $user_data = $company->get_staff_details_by_email($s_email, $c_id);
        if (!empty($user_data)) {
            $email = $user_data['staff_email'];
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
                        if ($company->update_staff_password_by_id($new_pwd, $staff_sno)) {
                            $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Update a staff: ".$s_det['staff_firstname']." ".$s_det['staff_lastname']." profile",
                                url_path('/company/edit-staff/'.$staff_id,true,true), $c['staff_photo'],$c['staff_name']
                            );
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Staff password has been updated. N.B. Password change takes effect on your next login."));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Failed to update user, contact admin via the help line"));
                        }
                    }
                }
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Staff profile cannot be retrieve / disabled account."));
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