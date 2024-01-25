<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="mb-3">
                    <a href="<?= url_path('/company/configuration',true,true)?>" class="btn btn-primary">General Settings</a>
                    <a href="<?= url_path('/company/shifts',true,true)?>" class="btn btn-primary">Manage Shift</a>
                    <a href="<?= url_path('/company/penalties',true,true)?>" class="btn btn-success">Penalties & Charges</a>
                    <a href="<?= url_path('/company/guard-positions',true,true)?>" class="btn btn-primary">Guard Positions</a>
                    <a href="<?= url_path('/company/payroll-settings',true,true)?>" class="btn btn-primary">Payroll Config</a>
                </div>
            </div>
        </div>
        <header class="page-header">
            <h2>Penalties & Charges</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Penalties & Charges</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">List Penalties/Charges</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?= url_path('/company/add-penalty',true,true)?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Add New Penalty</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-no-more table-striped mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Offense Name</th>
                                <th>Charge/Penalties</th>
                                <th>Charge Amount</th>
                                <th>Deduct Days</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_company_penalties($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Offense Name"><?= $row['offense_name'];?></td>
                                        <td data-title="Charge/Penalties"><?= $row['offense_charge'];?></td>
                                        <td data-title="Charge Amount">₦<?= number_format($row['charge_amt'],0);?></td>
                                        <td data-title="Deduct Days"><?= $row['days_deduct'];?></td>
                                        <td data-title="Date Created"><?= date("d/m/Y h:i a", strtotime($row['off_created_on']));?></td>
                                        <td data-title="Actions" class="actions">
                                            <a href="<?= url_path('/company/edit-penalty/'.$row['offense_id'],true,true)?>" class="on-default edit-row text-success mr-3"><i class="fas fa-pencil-alt"></i> edit</a>
                                            <a href="javascript:void(0)" data-offense_id="<?= $row['offense_id'];?>" data-comp_id="<?=$c['company_id'];?>" class="on-default text-danger remove-row" id="penaltyDeleteBtn">
                                                <i class="far fa-trash-alt"></i> delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No penalties found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>