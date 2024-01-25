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
$res = $company->get_client_wallet_balance($client_id,$c['company_id']);
//print_r($res);
echo '₦ '.number_format($res,0);
?>

