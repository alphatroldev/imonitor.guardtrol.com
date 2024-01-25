<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Pardoned Offense History: Staff</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Staff Offence Pardon</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">Staff Offences Pardoned History</h2>
                </header>
                <div class="card-body">
                    <table class="table table-bordered table-no-more table-striped mb-0" id="datatable-company">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Staff ID</th>
                            <th>Full Name</th>
                            <th>Offence Name</th>
                            <th>No of days</th>
                            <th>Charge Amount</th>
                            <th>Remark</th>
                            <th>Date issued</th>
                            <th>Date pardoned</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = $guard->get_all_company_staff_pardon($c['company_id']);
                        if ($res->num_rows > 0) {$n=0;
                            while ($stf_offence = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td data-title="sno"><?=++$n;?></td>
                                    <td data-title="Guard ID"><?= $stf_offence['staff_id'];?></td>
                                    <td data-title="Fullname"><?= $stf_offence['staff_firstname']." ".$stf_offence['staff_lastname'];?></td>
                                    <td data-title="Offence Name"><?= $stf_offence['offense_name'];?></td>
                                    <td data-title="Number of days"><?= $stf_offence['no_of_days'];?></td>
                                    <td data-title="Charge Amount">₦<?= number_format($stf_offence['charge_amt'], 0);?></td>
                                    <td data-title="Remark"><?= $stf_offence['par_reason'];?></td>
                                    <td data-title="Date issued"><?=  date("d/m/Y h:i a", strtotime($stf_offence['stf_created_at']));?></td>
                                    <td data-title="Date pardoned"><?=  date("d/m/Y h:i a", strtotime($stf_offence['par_created_on']));?></td>
                                    <td data-title="Status"><span class="badge badge-success px-2">pardoned</span></td>
                                </tr>
                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Staff offence pardon</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.staff.php"); ?>
<script src=<?= public_path("js/examples/examples.modals.js"); ?>></script>
