<?php ob_start(); session_start();

include_once(getcwd().'/controllers/classes/Company.class.php');
include_once(getcwd().'/controllers/classes/Staff.class.php');
include_once(getcwd().'/controllers/classes/DeployGuard.class.php');
include_once(getcwd().'/company/inc/helpers.php');
include_once(getcwd().'/staff/inc/helpers.php');
if (isset($_SESSION['COMPANY_LOGIN'])){
    $c = get_company();
}else{
    $c = get_staff();
}

$route_name = isset($_POST['route_name'])?$_POST['route_name']:"";
$r_det = $company->get_route_details($c['company_id'],$route_name);
$beat_id = $r_det['route_beat_id'];

$res = $deploy_guard->get_deployed_guards_by_beat_id($beat_id,$c['company_id']);
$data ='<option value=""></option>';
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $data .= "<option value='".$row['guard_id']."'>".$row['guard_firstname'].' '.$row['guard_lastname']."</option>";
    }
}
echo $data;
?>

