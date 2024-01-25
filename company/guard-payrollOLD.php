<?php include_once("inc/header.profile.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<?php
if (!isset($mon_year) || $mon_year==''){
    echo "<script>window.location = '".url_path('/company/create-guard-payroll',true,true)."';</script>";
} else {
    $cal = explode("-",$mon_year);
    $mon = $cal['0'];
    $year = $cal['1'];
}
?>
<section role="main" class="mx-5">
    <div class="d-flex justify-content-center mb">
        <div>
            <a href="<?= url_path('/company/guard-payroll-history',true,true)?>">
                <img src="<?=public_path('uploads/company/'.$c['company_logo']);?>" class="rounded float-left" width="80" height="80" alt="Company Logo" />
            </a>
        </div>
        <div class="px-3">
            <h3 class="text-center text-uppercase">
                <a href="<?= url_path('/company/guard-payroll-history',true,true)?>"><?=$c['company_name'];?> GUARD PAYROLL </a>
            </h3>
        </div>
    </div>
    <div class="card mt-2">
        <header class="card-header">
            <h2 class="card-title text-center text-uppercase"><?=$mon.' '.$year;?></h2>
        </header>
        <div class="card-body">
            <table class="table table-responsive-md table-bordered mb-0" style="font-size: 9px;">
                <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="2" class="text-center">SUBCHARGES</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <?php
                    $gpd = $company->get_guard_payroll_data_settings($c['company_id']);
                    if ($gpd->num_rows > 0) {
                        while ($gpd_s = $gpd->fetch_assoc()) {
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
                    <th>BEAT</th>
                    <th>D.O.C</th>
                    <th>DAYS WORKED</th>
                    <th>GROSS INCOME</th>
                    <th>RE. AMT</th>
                    <th>RE. DAYS</th>
                    <th>TRANSPORT</th>
                    <th>HOUSING</th>
                    <th>TOTAL GROSS</th>
                    <th>PEN. DAYS</th>
                    <th>PEN. AMT</th>
                    <th>TOTAL OFFENSES</th>
                    <th>AGENT</th>
                    <th>EX. DUTY</th>
                    <th>ISS. KIT</th>
                    <th>ABS. TRAINING</th>
                    <th>ID. CHARGE</th>
                    <th>PAYROLL CR.</th>
                    <th>PAYROLL DB.</th>
                    <?php
                    $gpd2 = $company->get_guard_payroll_data_settings($c['company_id']);
                    if ($gpd2->num_rows > 0) {
                        while ($gpd_s2 = $gpd2->fetch_assoc()) {
                            ?>
                            <th class="text-uppercase"><?=$gpd_s2['payroll_title'];?>(<?=substr($gpd_s2['payroll_type'],0,1);?>)</th>
                        <?php } } ?>
                    <th>LOAN</th>
                    <th>S/ADV</th>
                    <th>T.DED</th>
                    <th>NET PAY</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $res = $company->get_guard_payroll_history_details($c['company_id'],$mon,$year);
                if ($res->num_rows > 0) {$n=0;
                    while ($gpr = $res->fetch_assoc()) {
                        $tot_gross = $gpr['guard_salary']+$gpr['transport']+$gpr['housing'];
                        $tot_re_amount = $deploy_guard->sum_up_guard_redeployment_amt_per_month($gpr['guard_id'],$mon,$year,$c['company_id']);
                        $tot_re_days = $deploy_guard->sum_up_guard_redeployment_days_per_month($gpr['guard_id'],$mon,$year,$c['company_id']);
                        ?>
                        <tr>
                            <td><?=++$n;?></td>
                            <td><?=$gpr['guard_firstname']." ".$gpr['guard_middlename']." ".$gpr['guard_lastname'];?></td>
                            <td><?=$gpr['beat_name'];?></td>
                            <td><?=date("d/m/Y",strtotime($gpr['commencement_date']));?></td>
                            <td><?=$gpr['days_worked'];?></td>
                            <td>₦<?=number_format($gpr['guard_salary'],0);?></td>
                            <td><?=($tot_re_amount==0)?0:'<a target="_blank" href="'.url_path("/company/guard-redeployment-details/".$gpr['guard_id']."/".$mon_year,true,true).'">₦'.number_format($tot_re_amount,0).'</a>';?></td>
                            <td><?=($tot_re_days==0)?0:$tot_re_days;?></td>
                            <td><?=($gpr['transport']==null || $gpr['transport']==0 || $gpr['transport']=='')?0:'₦'.number_format($gpr['transport'],0);?></td>
                            <td><?=($gpr['housing']==null || $gpr['housing']==0 || $gpr['housing']=='')?0:'₦'.number_format($gpr['housing'],0);?></td>
                            <td>₦<?=number_format($tot_gross,0);?></td>
                            <td><?=$gpr['pen_charge_days'];?></td>
                            <td><?=($gpr['pen_charge_amt']==0)?0:'₦'.number_format($gpr['pen_charge_amt'],0);?></td>
                            <td><?=($gpr['total_offense']==0)?0:'₦'.number_format($gpr['total_offense'],0);?></td>
                            <td><?=($gpr['agent_fee']==0)?0:'₦'.number_format($gpr['agent_fee'],0);?></td>
                            <td><?=($gpr['total_extra_duty']==0)?0:'₦'.number_format($gpr['total_extra_duty'],0);?></td>
                            <td><?=($gpr['total_issued_kit']==0)?0:'₦'.number_format($gpr['total_issued_kit'],0);?></td>
                            <td><?=($gpr['total_abs_train']==0)?0:'₦'.number_format($gpr['total_abs_train'],0);?></td>
                            <td><?=($gpr['total_id_card']==0)?0:'₦'.number_format($gpr['total_id_card'],0);?></td>
                            <td><?=($gpr['payroll_credit']==0)?0:'₦'.number_format($gpr['payroll_credit'],0);?></td>
                            <td><?=($gpr['payroll_debit']==0)?0:'₦'.number_format($gpr['payroll_debit'],0);?></td>
                            <?php
                            $spd3 = $company->get_guard_payroll_data_settings($c['company_id']);
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
                            <td><?=($gpr['monthly_loan_amt']==0)?0:'₦'.number_format($gpr['monthly_loan_amt'],0);?></td>
                            <td><?=($gpr['salary_advance']==0)?0:'₦'.number_format($gpr['salary_advance'],0);?></td>
                            <td><?=($gpr['total_deduct']==0)?0:'₦'.number_format($gpr['total_deduct'],0);?></td>
                            <td><?=($gpr['net_pay']==0)?0:'₦'.number_format($gpr['net_pay'],0);?></td>
                        </tr>
                    <?php } } else { echo "<tr><td colspan='24' class='text-center'>No record found</td></tr>";} ?>
                </tbody>
            </table>
        </div>
    </div>

</section>
<?php include_once("inc/footer.com.php"); ?>