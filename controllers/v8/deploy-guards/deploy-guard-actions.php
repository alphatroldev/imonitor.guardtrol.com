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
    $beat_id = htmlspecialchars(strip_tags($_POST['beat_id']));
    $date_of_deploy = htmlspecialchars(strip_tags($_POST['date_of_deploy']));
    $observe_start = htmlspecialchars(strip_tags($_POST['observe_start']));
    $observe_end = htmlspecialchars(strip_tags($_POST['observe_end']));
    $commence_date = htmlspecialchars(strip_tags($_POST['commence_date']));
    $paid_observe = htmlspecialchars(strip_tags($_POST['paid_observe']));
    $guard_position = htmlspecialchars(strip_tags($_POST['guard_position']));
    $guard_shift = htmlspecialchars(strip_tags($_POST['guard_shift']));
    $guard_salary = htmlspecialchars(strip_tags($_POST['guard_salary']));
    $num_days_worked = htmlspecialchars(strip_tags($_POST['num_days_worked']));
    $status = "Active";

    $created_at = date("Y-m-d H:i:s");
          if (!empty($guard_id) &&!empty($beat_id) &&!empty($date_of_deploy) &&!empty($observe_start) && !empty($observe_end) && !empty($commence_date)
              && !empty($paid_observe) &&!empty($guard_position) &&!empty($guard_shift) &&!empty($guard_salary)) {
              $guard_active = $deploy_guard->count_guard_deploy_beat_active($beat_id,$c['company_id']);
              $beat_det = $deploy_guard->get_beat_by_id($beat_id,$c['company_id']);
              $beat_personnel = $beat->get_beat_personnel($c['company_id'],$beat_id);
              if ($guard_active < $beat_personnel) {
                  if (isset($_SESSION['COMPANY_LOGIN'])) {
                      $c_id = htmlspecialchars(strip_tags($_SESSION['COMPANY_LOGIN']['company_id']));
                      if (!empty($c_id)) {
                          $result = $deploy_guard->deploy_guard($c_id, $guard_id, $beat_id, $date_of_deploy, $observe_start, $observe_end, $commence_date,
                              $paid_observe, $guard_position, $guard_shift, $guard_salary, $num_days_worked, $status, $created_at);
                          if ($result) {
                             $g_det = $beat->get_guard_details_by_id($guard_id, $beat_id);
                              $company->insert_notifications(
                                  $c['company_id'], "General", "1", $c['staff_name'] . " Deploy a guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                                  url_path('/company/edit-norminal-roll/' . $guard_id, true, true), $c['staff_photo'], $c['staff_name']
                              );
                              $beat->insert_beat_log(
                                  $beat_id, $c_id, $g_det['client_id'], "Info", "Deployed Guard",
                                  $created_at, $g_det['guard_firstname'] . " " . $g_det['guard_lastname'] . " was deployed to " . $g_det['beat_name']. ". Commence: ".$commence_date,
                                  NULL
                              );
                              $guard->insert_guard_log(
                                  $c_id, $guard_id, "Info", "Deployed Guard",
                                  $created_at, $g_det['guard_firstname'] . " " . $g_det['guard_lastname'] . " was deployed to " . $g_det['beat_name']. ". Commence: ".$commence_date,
                                  NULL
                              );
                              http_response_code(200);
                              echo json_encode(array("status" => 1, "message" => "Guard Deployed"));
                          } else {
                              http_response_code(200);
                              echo json_encode(array("status" => 0, "message" => "Guard not Deployed"));
                          }
                      }
                  } else {
                      $staff_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['staff_id']));
                      $c_id = htmlspecialchars(strip_tags($_SESSION['STAFF_LOGIN']['company_id']));
                      $permission_sno = $privileges->get_deploy_guard_permission_id();
                      $staff_perm_ids = $privileges->staff_perm_ids($staff_id);

                      $array = array_map('intval', explode(',', $staff_perm_ids['perm_sno']));

                      if (!in_array($permission_sno['perm_sno'], $array)) {
                          http_response_code(200);
                          echo json_encode(array("status" => 0, "message" => "Access denied as you do not have sufficient privileges"));
                      } else {
                          if (!empty($c_id)) {
                              $result = $deploy_guard->deploy_guard($c_id, $guard_id, $beat_id, $date_of_deploy, $observe_start, $observe_end, $commence_date,
                                  $paid_observe, $guard_position, $guard_shift, $guard_salary, $num_days_worked, $status, $created_at);
                              $g_det = $beat->get_guard_details_by_id($guard_id, $beat_id);
                              if ($result) {
                                  $company->insert_notifications(
                                      $c['company_id'], "General", "1", $c['staff_name'] . " Deploy a guard: ".$g_det['guard_firstname']." ".$g_det['guard_lastname'],
                                      url_path('/company/edit-norminal-roll/' . $guard_id, true, true), $c['staff_photo'], $c['staff_name']
                                  );
                                  $beat->insert_beat_log(
                                      $beat_id, $c_id, $g_det['client_id'], "Info", "Deployed Guard",
                                      $created_at, $g_det['guard_firstname'] . " " . $g_det['guard_lastname'] . " was deployed to " . $g_det['beat_name']. ". Commence: ".$commence_date,
                                      NULL
                                  );
                                  $guard->insert_guard_log(
                                      $c_id, $guard_id, "Info", "Deployed Guard",
                                      $created_at, $g_det['guard_firstname'] . " " . $g_det['guard_lastname'] . " was deployed to " . $g_det['beat_name']. ". Commence: ".$commence_date,
                                      NULL
                                  );
                                  http_response_code(200);
                                  echo json_encode(array("status" => 1, "message" => "Guard Deployed"));
                              } else {
                                  http_response_code(200);
                                  echo json_encode(array("status" => 0, "message" => "Guard not Deployed"));
                              }
                          }
                      }
                  }
              } else {
                  http_response_code(200);
                  echo json_encode(array("status" => 0, "message" => "Beat maximum number of guard exceeded, contact supervisor."));
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