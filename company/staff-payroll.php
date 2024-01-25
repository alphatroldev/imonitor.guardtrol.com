<?php include_once("inc/header.profile.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<?php
    if (!isset($mon_year) || $mon_year==''){
        echo "<script>window.location = '".url_path('/company/create-staff-payroll',true,true)."';</script>";
    } else {
        $cal = explode("-",$mon_year);
        $mon = $cal['0'];
        $year = $cal['1'];
    }
?>
<section role="main" class="mx-5">
    <div class="d-flex justify-content-center mb">
        <div>
            <a href="<?= url_path('/company/staff-payroll-history',true,true)?>">
            <img src="<?=public_path('uploads/company/'.$c['company_logo']);?>" class="rounded float-left" width="80" height="80" alt="Company Logo" />
            </a>
        </div>
        <div class="px-3">
            <h3 class="text-center text-uppercase">
                <a href="<?= url_path('/company/staff-payroll-history',true,true)?>"><?=$c['company_name'];?> STAFF PAYROLL </a>
            </h3>
        </div>
    </div>
    <div class="card mt-2">
        <header class="card-header">
            <h2 class="card-title text-center text-uppercase"><?=$mon.' '.$year;?></h2>
        </header>
        <div class="card-body">
            <table class="table table-responsive-md table-bordered mb-0" style="font-size: 11px;">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="2" class="text-center">SUBCHARGES</th>
                    <th></th>
                    <?php
                    $spd = $company->get_staff_payroll_data_settings($c['company_id']);
                    if ($spd->num_rows > 0) {
                    while ($spd_s = $spd->fetch_assoc()) {
                    ?>
                    <th></th>
                    <?php } } ?>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th>s/n</th>
                    <th>NAME</th>
                    <th>ROLE</th>
                    <th>GROSS INCOME</th>
                    <th>TRANSPORT</th>
                    <th>HOUSING</th>
                    <th>TOTAL GROSS</th>
                    <th>NO OF DAYS</th>
                    <th>PENALTY</th>
                    <th>TOTAL OFFENSES</th>
                    <?php
                    $spd2 = $company->get_staff_payroll_data_settings($c['company_id']);
                    if ($spd2->num_rows > 0) {
                    while ($spd_s2 = $spd2->fetch_assoc()) {
                    ?>
                    <th class="text-uppercase"><?=$spd_s2['payroll_title'];?></th>
                    <?php } } ?>
                    <th>LOAN</th>
                    <th>S/ADV</th>
                    <th>T.DED</th>
                    <th>NET PAY</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $res = $company->get_payroll_history_details($c['company_id'],$mon,$year);
                if ($res->num_rows > 0) {$n=0;
                while ($spr = $res->fetch_assoc()) {
                    $tot_gross = $spr['staff_salary']+$spr['transport']+$spr['housing'];
                ?>
                <tr>
                    <td><?=++$n;?></td>
                    <td><?=$spr['staff_firstname']." ".$spr['staff_middlename']." ".$spr['staff_lastname'];?></td>
                    <td><?=$spr['company_role_name'];?></td>
                    <td>₦<?=number_format($spr['staff_salary'],0);?></td>
                    <td><?=($spr['transport']==null || $spr['transport']==0 || $spr['transport']=='')?0:'₦'.number_format($spr['transport'],0);?></td>
                    <td><?=($spr['housing']==null || $spr['housing']==0 || $spr['housing']=='')?0:'₦'.number_format($spr['housing'],0);?></td>
                    <td>₦<?=number_format($tot_gross,0);?></td>
                    <td><?=$spr['pen_charge_days'];?></td>
                    <td><?=($spr['pen_charge_amt']==0)?0:'₦'.number_format($spr['pen_charge_amt'],0);?></td>
                    <td><?=($spr['total_offense']==0)?0:'₦'.number_format($spr['total_offense'],0);?></td>
                    <?php
                    $spd3 = $company->get_staff_payroll_data_settings($c['company_id']);
                    if ($spd3->num_rows > 0) {
                    while ($spd_s3 = $spd3->fetch_assoc()) {
                    if ($spd_s3['payment_mode']=="Monthly"){
                    echo "<td>₦".number_format($spd_s3['payroll_amount'],0)."</td>";
                    } else if ($spd_s3['payment_mode']=="One Time"){
                        if ($spd_s3['mon_month']==$mon && $spd_s3['mon_year']==$year){
                        echo "<td>₦".number_format($spd_s3['payroll_amount'],0)."</td>";
                        } else {
                        echo "<td>0</td>";
                        }
                    }
                    ?>
                    <?php } } ?>
                    <td><?=($spr['monthly_loan_amt']==0)?0:'₦'.number_format($spr['monthly_loan_amt'],0);?></td>
                    <td><?=($spr['salary_advance']==0)?0:'₦'.number_format($spr['salary_advance'],0);?></td>
                    <td><?=($spr['total_deduct']==0)?0:'₦'.number_format($spr['total_deduct'],0);?></td>
                    <td><?=($spr['net_pay']==0)?0:'₦'.number_format($spr['net_pay'],0);?></td>
                </tr>
                <?php } } else { echo "<tr><td colspan='24' class='text-center'>No record found</td></tr>";} ?>
                </tbody>
            </table>
        </div>
    </div>

</section>
<?php include_once("inc/footer.com.php"); ?>

