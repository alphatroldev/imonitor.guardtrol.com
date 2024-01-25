<?php ob_start(); session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

include_once(getcwd().'/controllers/classes/Company.class.php');
include_once(getcwd().'/controllers/classes/Staff.class.php');
include_once(getcwd().'/company/inc/helpers.php');
include_once(getcwd().'/staff/inc/helpers.php');
if (isset($_SESSION['COMPANY_LOGIN'])){
    $c = get_company();
}else{
    $c = get_staff();
}

$client_id = isset($_POST['client_id'])?$_POST['client_id']:"";
$res = $company->get_all_company_beats_by_client_id($c['company_id'],$client_id);
$data="";
if ($res->num_rows > 0) {$n=0;
while ($row = $res->fetch_assoc()) {
    $data .= '
    <tr>
        <td class="text-primary">
            <i class="fas fa-map-marker-alt">&nbsp;</i>'. $row['beat_name'] .'
        </td>
        <td>'.$row['client_fullname'].'</td>
        <td>
            <div class="checkbox-custom checkbox-default pull-right">
                <input type="checkbox" class="beat_check" id="beat_check_'.$row['beat_id'].'" name="beat_check[]" value="'. $row['beat_id'].'">
                <label for="beat_check_'.$row['beat_id'].'"></label>
            </div>
        </td>
    </tr>';
 }} else { $data .= "<tr><td colspan='12' class='text-center'>Selected client has no beat</td></tr>";}
 echo $data;
 ?>

