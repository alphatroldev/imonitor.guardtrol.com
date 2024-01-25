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

$res = $company->get_assigned_route_points($route_name,$c['company_id']);
$data ='<div class="table-responsive"><table class="table">
    <thead>
    <tr>
      <th scope="col">Alias</th>
      <th scope="col">Point Code</th>
      <th scope="col">Longitude</th>
      <th scope="col">Latitude</th>
    </tr>
    </thead>
    <tbody>';
if ($res->num_rows > 0) {$n=0;
    while ($row = $res->fetch_assoc()) {
        $data .= '
            <tr>
              <th scope="row">Point '.++$n.'</th>
              <td>'.$row['point_code'].'</td>
              <td>'.$row['point_long'].'</td>
              <td>'.$row['point_lati'].'</td>
            </tr>
        ';
    }
} else {
    $data .= '<tr><td colspan="4">Unable to fetch route point, internet error!</td></tr>';
}
$data .='</tbody></table></div>';
echo $data;
?>