<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Support.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $apk_file_name = htmlspecialchars(strip_tags(strtoupper($_POST['apk_file_name'])));
    $apk_imp = htmlspecialchars(strip_tags($_POST['apk_imp']));
    $apk_version = htmlspecialchars(strip_tags($_POST['apk_version']));
    $s_id = htmlspecialchars(strip_tags($_SESSION['SUPPORT_LOGIN']['support_sno']));

    $uploadDir = upload_path("uploads/apkVersion/");
    $images = $_FILES;
    $data = [];

    $err = 0;

    if (!empty($apk_file_name) && !empty($apk_version)) {
        foreach ($images as $key => $image) {
            $name = strtolower($image['name']);
            $fileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $targetFilePath = $uploadDir . $name;
            $allowTypes = array('apk');

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
            $apk_file = isset($data['apk_file']['src']) ? $data['apk_file']['src'] : "";
            $result = $support->insert_new_apk_version($apk_file_name,$apk_imp,$apk_version,$apk_file);
            if ($result) {
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "APK Version successfully updated."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Failed to upload new version."));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Error occurred, while uploading (check APK). Try again later"));
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