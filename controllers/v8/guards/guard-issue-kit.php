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
    $guard_id = htmlspecialchars(strip_tags($_POST['guard_id']));
    $guard_kit_type = htmlspecialchars(strip_tags($_POST['guard_kit_type']));
    $guard_kit_remark = htmlspecialchars(strip_tags($_POST['guard_kit_remark']));
    $guard_kit_amt = htmlspecialchars(strip_tags($_POST['guard_kit_amt']));
    $uniform_mode = htmlspecialchars(strip_tags($_POST['uniform_mode']));
    $c_id = htmlspecialchars(strip_tags($_POST['comp_id']));
    $created_at = date("Y-m-d H:i:s", strtotime($_POST['guard_kit_date']));
    $lanyards=NULL;

    if ($uniform_mode=="1 month pay off"){
        $monthly_charge = $guard_kit_amt/1;
        $no_of_month = 1;
    } elseif ($uniform_mode=="2 months pay off"){
        $monthly_charge = $guard_kit_amt/2;
        $no_of_month = 2;
    }elseif ($uniform_mode=="3 months pay off"){
        $monthly_charge = $guard_kit_amt/3;
        $no_of_month = 3;
    }elseif ($uniform_mode=="fixed amount monthly"){
        $monthly_charge = $guard_kit_amt;
        $no_of_month = 0;
    }else{
        $monthly_charge = $guard_kit_amt;
        $no_of_month = 1;
    }

      if (!empty($guard_id) &&!empty($guard_kit_type) &&!empty($guard_kit_remark) &&!empty($guard_kit_amt) &&!empty($c_id)) {
             $month = date("F",strtotime($created_at));
             $year = date("Y",strtotime($created_at));
             $payroll_check = $company->check_if_guard_payroll_exist($month,$year,$c_id);
            if ($payroll_check['myCount'] > 0) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Guard Payroll already exist for ".$month.' - '.$year.". Delete existing payroll  to issue kit"));
                exit();
            } else {
                $listKit = implode(', ', $_POST['kits']);
                if (isset($_SESSION['COMPANY_LOGIN'])){
                    if($no_of_month == 0) {
                        $result = $guard->issue_guard_kit(
                            $c_id,$guard_id,$guard_kit_type,$listKit,$lanyards,$guard_kit_remark,$guard_kit_amt,$monthly_charge,$no_of_month,$created_at,$created_at
                        );
                    } else {
                        // $new_amt = $guard_kit_amt - $monthly_charge;
                        $n = 0;
                        for ($i=0; $i<$no_of_month;$i++){
                            $new_date = date("Y-m-d H:i:s",strtotime($created_at."+$i month"));
                            $n = $i +1;
                            
                            $new_month = $no_of_month - $i;
                            $result = $guard->issue_guard_kit(
                                $c_id,$guard_id,$guard_kit_type,$listKit,$lanyards,$guard_kit_remark,$guard_kit_amt,$monthly_charge,1,$new_date,$created_at
                            );
                        }
                    }
                    if ($result) {
                        foreach ($_POST['kits'] as $key => $value) {
                            $guard->update_kit_inventory($value,$c_id);
                        }
                        $company->create_kit_inventory_history(
                            $c_id,"Info",$guard_id,"Issue Kit"," was issued ".$listKit,$created_at
                        );
                        $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                        $company->insert_notifications(
                            $c['company_id'],"General","1", $c['staff_name']." Issue a kit to guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                            url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                        );
                        $guard->insert_guard_log(
                            $c_id,$guard_id,"Info", "Issued guard kit",$created_at,
                            $g_det['guard_firstname']." ".$g_det['guard_lastname']." was issue kit - amount #".$guard_kit_amt,
                            $guard_kit_remark
                        );
                        http_response_code(200);
                         echo json_encode(array("status" => 1, "message" => "Approved"));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Request Failed"));
                    }
                }else{
                    $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                    $permission_sno = $privileges->get_update_guard_permission_id();
                    $staff_perm_ids = $privileges->staff_perm_ids($staff_id);
            
                    $array = array_map('intval', explode(',',$staff_perm_ids['perm_sno']));
            
                    if(!in_array($permission_sno['perm_sno'], $array)){
                     http_response_code(200);
                     echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                    }else{
                        if($no_of_month == 0) {
                            $result = $guard->issue_guard_kit(
                                $c_id,$guard_id,$guard_kit_type,$listKit,$lanyards,$guard_kit_remark,$guard_kit_amt,$monthly_charge,$no_of_month,$created_at,$created_at
                            );
                        } else {
                            // $new_amt = $guard_kit_amt - $monthly_charge;
                            for ($i=0; $i<$no_of_month;$i++){
                                $n = $i +1;
                                $new_date = date("Y-m-d H:i:s",strtotime($created_at."+$i month"));
                                
                                $new_month = $no_of_month - $i;
                                $result = $guard->issue_guard_kit(
                                    $c_id,$guard_id,$guard_kit_type,$listKit,$lanyards,$guard_kit_remark,$guard_kit_amt,$monthly_charge,1,$new_date,$created_at
                                );
                            }
                        }
                        if ($result) {
                            foreach ($_POST['kits'] as $key => $value) {
                                $guard->update_kit_inventory($value,$c_id);
                            }
                            $company->create_kit_inventory_history(
                                $c_id,"Info",$guard_id,"Issue Kit"," was issued ".$listKit,$created_at
                            );
                            $g_det = $guard->get_guard_details_by_guard_id($guard_id);
                            $company->insert_notifications(
                                $c['company_id'],"General","1", $c['staff_name']." Issue a kit to guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                                url_path('/company/edit-guard/'.$guard_id,true,true), $c['staff_photo'],$c['staff_name']
                            );
                            $guard->insert_guard_log(
                                $c_id,$guard_id,"Info", "Issued guard kit",$created_at,
                                $g_det['guard_firstname']." ".$g_det['guard_lastname']." was issue kit - amount #".$guard_kit_amt,
                                $guard_kit_remark
                            );
                            http_response_code(200);
                             echo json_encode(array("status" => 1, "message" => "Approved"));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Request Failed"));
                        }
                    }
                }
            }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>