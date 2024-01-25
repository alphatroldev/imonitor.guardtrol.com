<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Staff Offence History</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Staff Offence History</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">List Staff Offences</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <a href="<?= url_path('/company/staff-offenses',true,true)?>" class="btn btn-success"><i class="fas fa-list">&nbsp;&nbsp;</i>Staff Offence</a>
                                <a href="<?= url_path('/company/staff-pardon-history',true,true)?>" class="btn btn-primary"><i class="fas fa-list-alt">&nbsp;&nbsp;</i>Staff Pardon History</a>
                            </div>
                        </div>
                        <table class="table table-bordered table-no-more table-striped mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Staff ID</th>
                                <th>Fullname</th>
                                <th>Offence Name</th>
                                <th>Charge/Penalties</th>
                                <th>Amt</th>
                                <th>Days</th>
                                <th>Reason</th>
                                <th>issued on</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_staff_offences($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($stf_offence = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Staff ID"><?= $stf_offence['staff_id'];?></td>
                                        <td data-title="Fullname"><?= $stf_offence['staff_firstname'].' '.$stf_offence['staff_middlename'].' '.$stf_offence['staff_lastname'];?></td>
                                        <td data-title="Offence Name"><?= $stf_offence['offense_name'];?></td>
                                        <td data-title="Charge/Penalties"><?= $stf_offence['charge_mode'];?></td>
                                        <td data-title="Charge Amt">₦<?= number_format($stf_offence['charge_amt'],0);?></td>
                                        <td data-title="No of days"><?= $stf_offence['no_of_days'];?></td>
                                        <td data-title="Remark"><?= $stf_offence['offense_remark'];?></td>
                                        <td data-title="Date issued"><?=  date("d/m/Y H:i", strtotime($stf_offence['stf_created_at']));?></td>
                                        <td data-title="Actions" class="actions">
                                            <a data-offense_id="<?= $stf_offence['staff_offense_id'];?>"
                                               class="btn btn-xs btn-primary text-white modal-with-move-anim ws-normal pardon_off"
                                               href="#offensePardon">
                                               <i class="fas fa-edit">&nbsp;</i>pardon
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No staff offence found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<div id="offensePardon" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
    <form name="pardonOffense" id="pardonOffense" class="card">
        <header class="card-header">
            <h2 class="card-title">Offense Pardon</h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper py-0">
                <input type="hidden" name="offense_id" id="offense_id" value="" />
                <div class="form-group">
                    <label for="pardon_reason" >Reason/Remark</label>
                    <textarea name="pardon_reason" rows="5" id="pardon_reason" class="form-control" placeholder="Remark" required></textarea>
                </div>
            </div>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <input type="submit" class="btn btn-primary" value="Update">
                    <button class="btn btn-default modal-dismiss">Close</button>
                </div>
            </div>
        </footer>
    </form>
</div>
<?php include_once("inc/footer.com.php"); ?>
<script src=<?= public_path("js/examples/examples.modals.js"); ?>></script>

