<?php include_once("inc/header.profile.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<?php
if (!isset($mon_year) || $mon_year==''){
    echo "<script>window.location = '".url_path('/company/generate-salary-advance-report',true,true)."';</script>";
} else {
    $cal = explode("-",$mon_year);
    $mon = $cal['0'];
    $year = $cal['1'];
}
?>
<section role="main" class="mx-5">
    <div class="d-flex justify-content-center mb">
        <div>
            <a href="<?= url_path('/company/list-guard-sa-report',true,true)?>">
                <img src="<?=public_path('uploads/company/'.$c['company_logo']);?>" class="rounded float-left" width="80" height="80" alt="Company Logo" />
            </a>
        </div>

        <div class="px-3">
            <h2 class="text-center text-uppercase">
                <a href="<?= url_path('/company/list-guard-sa-report',true,true)?>"><?=$c['company_name'];?> GUARD SALARY ADVANCE REPORT (I.O.U)</a>
            </h2>
        </div>
    </div>
    <div class="card mt-2">
        <header class="card-header">
            <h2 class="card-title text-center text-uppercase"><?=$mon.' '.$year;?></h2>
        </header>
        <div class="card-body">
            <table class="table table-responsive-md table-bordered mb-0" style="font-size: 14px;">
                <thead>
                <tr>
                    <th>s/n</th>
                    <th>DATE</th>
                    <th>NAME</th>
                    <th>BEAT</th>
                    <th>AMOUNT</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total = 0;
                $res = $company->get_guard_sa_report_payroll($c['company_id'],$mon,$year);
                if ($res->num_rows > 0) {$n=0;
                while ($sa_rh = $res->fetch_assoc()) {
                $total = $total + $sa_rh['salary_adv_amount'];
                ?>
                    <tr>
                        <td><?=++$n;?></td>
                        <td><?=date("d/m/Y",strtotime($sa_rh['created_at']));?></td>
                        <td><?=$sa_rh['guard_firstname']." ".$sa_rh['guard_middlename']." ".$sa_rh['guard_lastname'];?></td>
                        <td><?=$sa_rh['beat_name'];?></td>
                        <td>₦<?=number_format($sa_rh['salary_adv_amount'],0);?></td>
                    </tr>
                <?php } } else { echo "<tr><td colspan='24' class='text-center'>No record found</td></tr>";} ?>
                </tbody>
            </table>
        </div>
    </div>

</section>
<?php include_once("inc/footer.com.php"); ?>

