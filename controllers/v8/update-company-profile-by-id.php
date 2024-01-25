<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Support.class.php');
include_once(getcwd().'/controllers/classes/Company.class.php');
include_once(getcwd().'/company/inc/helpers.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    //ONLY HANDLES FILE UPLOADS
    if(isset($_POST['file_upload']) AND !empty($_POST['file_upload'])){
        $result = null;
        $cname = htmlspecialchars(strip_tags($_POST['cname']));
        $cphone = htmlspecialchars(strip_tags($_POST['phone']));

        if (isset($_FILES['c_logo'])) {
            //process your files
            $c_logo = upload_file($_FILES['c_logo'], upload_path('uploads/company/'), 'logo_'.str_replace(' ','',substr($cname.$cphone, 0, 5)), 'image', 500000000);
            if($c_logo['status'] == 0) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => $c_logo['message']));
                return;
            }
            //store in database
            $result = $company->update_column('tbl_company','company_logo',$c_logo['message'],$_POST['file_upload'],'company_sno');
        }

        if (isset($_FILES['c_op_license'])) {
            //process license
            $c_op_license = upload_file($_FILES['c_op_license'], upload_path('uploads/company/'), 'license_'.str_replace(' ','',substr($cname.$cphone, 0, 5)), 'doc', 50000000);
            if ($c_op_license['status'] == 0) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => $c_op_license['message']));
                return;
            }
            $result = $company->update_column('tbl_company','company_op_license',$c_op_license['message'],$_POST['file_upload'],'company_sno');
        }

        if ($result==true) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Your account profile has been successfully updated."));
        } else if ($result=="no_change"){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update profile, no changes found."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update profile." ));
        }
        return;
    } else {
        $c_name = htmlspecialchars(strip_tags(strtoupper($_POST['c_name'])));
        $c_email = htmlspecialchars(strip_tags($_POST['c_email']));
        $c_address = htmlspecialchars(strip_tags($_POST['c_address']));
        $c_phone = htmlspecialchars(strip_tags($_POST['c_phone']));
        $c_description = htmlspecialchars(strip_tags($_POST['c_description']));
        $company_sno = htmlspecialchars(strip_tags($_POST['company_sno']));
        $staff_id = htmlspecialchars(strip_tags($_POST['staff_id']));
        $c_guard_str = htmlspecialchars(strip_tags($_POST['c_guard_str']));
        $c_op_state = htmlspecialchars(strip_tags($_POST['c_op_state']));
        $c_op_number = htmlspecialchars(strip_tags($_POST['c_op_number']));
        $c_reg_no = htmlspecialchars(strip_tags($_POST['c_reg_no']));
        $c_tax_id = htmlspecialchars(strip_tags($_POST['c_tax_id']));
        $c_logo="";
        $c_op_license="";

        if (!empty($c_name) && !empty($c_email) && !empty($c_address) && !empty($c_phone)) {
            $result = $support->update_company_profile_by_id(
                $company_sno,$staff_id,$c_name,$c_email,$c_address,$c_phone,$c_description,$c_guard_str,
                $c_op_state, $c_op_number, $c_reg_no, $c_tax_id
            );
            if ($result==true) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Your account profile has been successfully updated."));
            } else if ($result=="no_change"){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Failed to update profile, no changes found."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Failed to update profile. ;" . $result));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Fill all required field" ));
        }
    }} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}

?>