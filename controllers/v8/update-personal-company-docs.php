<?php ob_start(); session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Company.class.php');
include_once(getcwd().'/company/inc/helpers.php');
$c = get_company();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $c_op = htmlspecialchars(strip_tags($_POST['c_op']));
    $c_no_op = htmlspecialchars(strip_tags($_POST['c_no_op']));
    $c_rc_no = htmlspecialchars(strip_tags($_POST['c_rc_no']));
    $c_tax_id = htmlspecialchars(strip_tags($_POST['c_tax_id']));
    $cac_file_txt = htmlspecialchars(strip_tags($_POST['cac_file_txt']));
    $c_license_txt = htmlspecialchars(strip_tags($_POST['c_license_txt']));

    $uploadDir = upload_path("uploads/company/");
    $images = $_FILES;
    $data = [];

    $err = 0;
    foreach ($images as $key => $image) {
        $name = strtolower($image['name']);
        $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $targetFilePath = $uploadDir . $name;
        $allowTypes = array('jpg', 'png', 'jpeg', 'pdf');

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
        $cac_file = isset($data['cac_file']['src']) ? $data['cac_file']['src'] : $cac_file_txt;
        $c_license = isset($data['c_license']['src']) ? $data['c_license']['src'] : $c_license_txt;


        $result = $company->update_company_profile_doc($c['company_id'],$c_op,$c_no_op,$c_rc_no,$c_tax_id,$cac_file,$c_license);
        if ($result) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Document info updated successfully"));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update profile, try again or contact support if error persist."));
        }
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>