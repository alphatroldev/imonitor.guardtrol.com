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
    $id = htmlspecialchars(strip_tags($_POST['id']));
    $guard_id = htmlspecialchars(strip_tags($_POST['guard_id']));
    $guard_fname = htmlspecialchars(strip_tags($_POST['guard_fname']));
    $guard_mname = htmlspecialchars(strip_tags($_POST['guard_mname']));
    $guard_lname = htmlspecialchars(strip_tags($_POST['guard_lname']));
    $guard_height = htmlspecialchars(strip_tags($_POST['guard_height']));
    $guard_sex = htmlspecialchars(strip_tags($_POST['guard_sex']));
    $guard_phone = htmlspecialchars(strip_tags($_POST['guard_phone']));
    $guard_phone_2 = htmlspecialchars(strip_tags($_POST['guard_phone_2']));
    $referral = htmlspecialchars(strip_tags($_POST['referral']));
    $referral_name = htmlspecialchars(strip_tags($_POST['referral_name']));
    $referral_address = htmlspecialchars(strip_tags($_POST['referral_address']));
    $referral_fee = htmlspecialchars(strip_tags($_POST['referral_fee']));
    $referral_phone = htmlspecialchars(strip_tags($_POST['referral_phone']));
    $guard_next_of_kin_name = htmlspecialchars(strip_tags($_POST['guard_next_of_kin_name']));
    $guard_next_of_kin_phone = htmlspecialchars(strip_tags($_POST['guard_next_of_kin_phone']));
    $guard_next_of_kin_relationship = htmlspecialchars(strip_tags($_POST['guard_next_of_kin_relationship']));
    $guard_state_of_origin = htmlspecialchars(strip_tags($_POST['guard_state_of_origin']));
    $vetting = htmlspecialchars(strip_tags($_POST['vetting']));
    $guard_religion = htmlspecialchars(strip_tags($_POST['guard_religion']));
    $guard_qualification = htmlspecialchars(strip_tags($_POST['guard_qualification']));
    $guard_dob = htmlspecialchars(strip_tags($_POST['guard_dob']));
    $guard_nickname = htmlspecialchars(strip_tags($_POST['guard_nickname']));
    $guard_address = htmlspecialchars(strip_tags($_POST['guard_address']));
    $client_id = htmlspecialchars(strip_tags($_POST['client_id']));
   

    $updated_at = date("Y-m-d H:i:s");
    
    if (!empty($id) && !empty($guard_fname) && !empty($guard_lname) && !empty($guard_height) && !empty($guard_sex)
       && !empty($guard_phone)  && !empty($referral)
       && !empty($guard_next_of_kin_name) && !empty($guard_next_of_kin_phone) && !empty($guard_next_of_kin_relationship) && !empty($guard_state_of_origin) 
       && !empty($vetting) && !empty($guard_religion) && !empty($guard_qualification) && !empty($guard_dob)
       && !empty($guard_address)) {
       
         
        if (isset($_SESSION['COMPANY_LOGIN'])){

            if($referral!=="Nobody"){
           
            if(!empty($referral_name) && !empty($referral_address)
            && !empty($referral_phone) &&!empty($referral_fee)) {


            $result = $guard->update_guard_section_one(
                $c['company_id'], $id,$guard_fname,$guard_mname,$guard_lname,
            $guard_height,$guard_sex,
            $guard_phone,$guard_phone_2,
            $referral,$referral_name,$referral_address,
            $referral_fee,$referral_phone,
            $guard_next_of_kin_name,$guard_next_of_kin_phone,
            $guard_next_of_kin_relationship,
            $vetting,$guard_state_of_origin,
            $guard_religion,$guard_qualification,
            $guard_dob,$guard_nickname,
            $guard_address,
            $updated_at);


          }else {
            http_response_code(200);
           echo json_encode(array("status" => 0, "message" => "Referral Informations are required. Select 'Nobody' if there is no referral"));
           }
          }else{

                $referral_name="";
                $referral_address="";
                $referral_phone="";
                $referral_fee="";

                $result = $guard->update_guard_section_one(
                    $c['company_id'], $id,$guard_fname,$guard_mname,$guard_lname,
                    $guard_height,$guard_sex,
                    $guard_phone,$guard_phone_2,
                    $referral,$referral_name,$referral_address,
                    $referral_fee,$referral_phone,
                    $guard_next_of_kin_name,$guard_next_of_kin_phone,
                    $guard_next_of_kin_relationship,
                    $vetting,$guard_state_of_origin,
                    $guard_religion,$guard_qualification,
                    $guard_dob,$guard_nickname,
                    $guard_address,
                    $updated_at);

           }

            if ($result==true) {
                $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                $company->insert_notifications(
                    $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                    url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                );
                $guard->insert_guard_log(
                    $c['company_id'],$guard_id,"Info", "Update Guard Profile",$updated_at,
                    $g_det['guard_firstname']." ".$g_det['guard_lastname']." profile was updated on ".$updated_at,null
                );
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "Update Successful."));
            } else if ($result=="no_change"){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Update failed, no changes found."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Update failed."));
            }
        } else {
            $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
            $permission_sno = $privileges->get_update_guard_permission_id();
            $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

            $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));

            if(!in_array($permission_sno['perm_sno'], $array)){
             http_response_code(200);
             echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
            }else{  
                if($referral!=="Nobody"){
                    if(!empty($referral_name) && !empty($referral_address) && !empty($referral_phone) &&!empty($referral_fee)) {
                        $result = $guard->update_guard_section_one(
                            $c['company_id'], $id,$guard_fname,$guard_mname,$guard_lname,
                            $guard_height,$guard_sex,
                            $guard_phone,$guard_phone_2,
                            $referral,$referral_name,$referral_address,
                            $referral_fee,$referral_phone,
                            $guard_next_of_kin_name,$guard_next_of_kin_phone,
                            $guard_next_of_kin_relationship,
                            $vetting,$guard_state_of_origin,
                            $guard_religion,$guard_qualification,
                            $guard_dob,$guard_nickname,
                            $guard_address,
                            $updated_at);
                  } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Referral Informations are required. Select 'Nobody' if there is no referral"));
                    }
                  }else{
        
                        $referral_name="";
                        $referral_address="";
                        $referral_phone="";
                        $referral_fee="";

                    $result = $guard->update_guard_section_one(
                        $c['company_id'], $id,$guard_fname,$guard_mname,$guard_lname,
                        $guard_height,$guard_sex,
                        $guard_phone,$guard_phone_2,
                        $referral,$referral_name,$referral_address,
                        $referral_fee,$referral_phone,
                        $guard_next_of_kin_name,$guard_next_of_kin_phone,
                        $guard_next_of_kin_relationship,
                        $vetting,$guard_state_of_origin,
                        $guard_religion,$guard_qualification,
                        $guard_dob,$guard_nickname,
                        $guard_address,
                        $updated_at);
        
                   }
        
                    if ($result==true) {
                        $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Update guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname']." profile",
                            url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                        );
                        $guard->insert_guard_log(
                            $c['company_id'],$guard_id,"Info", "Update Guard Profile",$updated_at,
                            $g_det['guard_firstname']." ".$g_det['guard_lastname']." profile was updated on ".$updated_at,null
                        );
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Update Successful."));
                    } else if ($result=="no_change"){
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Update failed, no changes found."));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Update failed."));
                    }
            }
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