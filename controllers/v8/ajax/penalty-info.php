<?php ob_start(); session_start();

include_once(getcwd().'/controllers/classes/Company.class.php');
include_once(getcwd().'/controllers/classes/Staff.class.php');
include_once(getcwd().'/company/inc/helpers.php');
include_once(getcwd().'/staff/inc/helpers.php');
if (isset($_SESSION['COMPANY_LOGIN'])){
    $c = get_company();
}else{
    $c = get_staff();
}

$offense_title = isset($_POST['offense_title'])?$_POST['offense_title']:"";
$res = $company->get_company_penalty_by_offense_title($c['company_id'],$offense_title);
$data="";
if ($res->num_rows > 0) {
    $n = 0;
    while ($row = $res->fetch_assoc()) {
        $data .= '
            <div class="form-group  mb-3">
                <label for="charge_mode">Charges Mode</label>
                <input type="text" name="charge_mode" class="form-control" id="charge_mode" value="' . $row['offense_charge'] . '" readonly>
            </div>';
        if ($row['charge_amt'] == 0 && $row['offense_charge'] !== 'Permanent dismissal') {
            $data .= '
            <div class="form-group">
                <label for="charge_days">Charge No of Days</label>
                <input type="number" name="charge_days" class="form-control" id="charge_days" min="1" value="' . $row['days_deduct'] . '" readonly>
            </div>
            <div class="form-group mb-3">
                <input type="hidden" name="charge_amt" class="form-control" id="charge_amt" value="' . $row['charge_amt'] . '" readonly>
            </div>';
        } elseif ($row['days_deduct'] == 0 && $row['offense_charge'] !== 'Permanent dismissal') {
            $data .= '
            <div class="form-group mb-3">
                <label for="charge_amt">Charge Amount</label>
                <input type="number" name="charge_amt" class="form-control" id="charge_amt" value="' . $row['charge_amt'] . '" readonly>
            </div>
            <div class="form-group">
                <input type="hidden" name="charge_days" class="form-control" id="charge_days" min="1" value="' . $row['days_deduct'] . '" readonly>
            </div>';
        }
    }
}
echo $data;
?>

