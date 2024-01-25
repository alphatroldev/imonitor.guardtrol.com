<?php include_once("inc/header.profile.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<?php
if (!isset($mon_year) || $mon_year=='' || !isset($guard_id) || $guard_id==''){
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
            <a href="<?= url_path('/company/guard-payroll/'.$mon_year,true,true)?>">
                <img src="<?=public_path('uploads/company/'.$c['company_logo']);?>" class="rounded float-left" width="80" height="80" alt="Company Logo" />
            </a>
        </div>
        <div class="px-3">
            <h3 class="text-center text-uppercase">
                <a href="<?= url_path('/company/guard-payroll/'.$mon_year,true,true)?>">GUARD (<?=$guard_id;?>) REDEPLOYMENT DETAILS </a>
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
                    <th>s/n</th>
                    <th>Guard ID</th>
                    <th>Guard Name</th>
                    <th>Beat ID</th>
                    <th>Beat Name</th>
                    <th>Days Worked</th>
                    <th>Amt. Paid</th>
                    <th>Redeploy Date</th>
                    <th>Created On</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $res = $deploy_guard->get_guard_redeployment_details($c['company_id'],$guard_id,$mon,$year);
                if ($res->num_rows > 0) {$n=0;
                    while ($grd = $res->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?=++$n;?></td>
                            <td><?=$grd['guard_id'];?></td>
                            <td><?=$grd['guard_firstname']." ".$grd['guard_middlename']." ".$grd['guard_lastname'];?></td>
                            <td><?=$grd['beat_id'];?></td>
                            <td><?=$grd['beat_name'];?></td>
                            <td><?=$grd['re_days_worked'];?></td>
                            <td>₦<?=number_format($grd['paid_amount'],0);?></td>
                            <td><?=date("d/m/Y",strtotime($grd['redeploy_date']));?></td>
                            <td><?=date("d-m-Y H:i:s",strtotime($grd['red_pay_created_on']));?></td>
                        </tr>
                    <?php } } else { echo "<tr><td colspan='24' class='text-center'>No record found</td></tr>";} ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include_once("inc/footer.com.php"); ?>