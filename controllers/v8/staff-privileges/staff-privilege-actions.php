<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Privileges.class.php');
include_once(getcwd().'/controllers/classes/Staff.class.php');
include_once(getcwd().'/company/inc/helpers.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    
    $staff_id = htmlspecialchars(strip_tags($_POST['staff_id']));
    $company_role_sno = htmlspecialchars(strip_tags($_POST['company_role_sno']));

    $c_id = htmlspecialchars(strip_tags($_SESSION['COMPANY_LOGIN']['company_id']));

   
    if(!isset($_POST['hr_admin_guard_details'])){
        $_POST['hr_admin_guard_details'] = array();
      }
    if(!isset($_POST['hr_admin_staff_details'])){
        $_POST['hr_admin_staff_details'] = array();
    }
    if(!isset($_POST['hr_admin_client_beat_details'])){
        $_POST['hr_admin_client_beat_details'] = array();
    }
    if(!isset($_POST['operations_guard_details'])){
        $_POST['operations_guard_details'] = array();
    }
    if(!isset($_POST['operations_inventory_details'])){
        $_POST['operations_inventory_details'] = array();
    }
    if(!isset($_POST['operations_incident_details'])){
        $_POST['operations_incident_details'] = array();
    }
    if(!isset($_POST['accounts_invoice_details'])){
        $_POST['accounts_invoice_details'] = array();
    }
    if(!isset($_POST['accounts_payment_details'])){
        $_POST['accounts_payment_details'] = array();
    }
    if(!isset($_POST['accounts_payment_history'])){
        $_POST['accounts_payment_history'] = array();
    }


    $privilege = implode(", ",array_merge($_POST['hr_admin_guard_details'],$_POST['hr_admin_staff_details'],$_POST['hr_admin_client_beat_details'],$_POST['operations_guard_details'],$_POST['operations_inventory_details'],$_POST['operations_incident_details'],$_POST['accounts_invoice_details'],$_POST['accounts_payment_details'],$_POST['accounts_payment_history']));
   
   
    if (!empty($staff_id) &&!empty($company_role_sno)) {
         $check_staff_duplicate = $privileges->check_staff_duplicate($staff_id);
         if (!empty($check_staff_duplicate)) {
                $result = $privileges->update_privilege($privilege, $staff_id);
                if ($result) {
                    $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                    $staff->insert_staff_log(
                        $c_id,$staff_id,"Warning", "Update Privilege",date("Y-m-d H:i:s"),
                        $s_det['staff_firstname']." ".$s_det['staff_lastname']." privileges was updated",null
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Privilege Updated"));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Not Updated"));
                }
         }else {
            if (!empty($privilege)){
                $result = $privileges->assign_privilege($privilege, $staff_id, $company_role_sno);
                if ($result) {
                    $s_det = $staff->get_staff_details_by_staff_id($staff_id);
                    $staff->insert_staff_log(
                        $c_id,$staff_id,"Warning", "Update Privilege",date("Y-m-d H:i:s"),
                        $s_det['staff_firstname']." ".$s_det['staff_lastname']." privilege was updated",null
                    );
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Privilege Created"));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Not Created"));
                }
            }else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "You Must check at least a box"));
            }
         }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Error"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>