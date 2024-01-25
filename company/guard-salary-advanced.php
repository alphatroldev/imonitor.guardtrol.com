<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Guard Salary Advance</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Guard Salary Advance History</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">List Guard Salary Advance</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <a href="<?= url_path('/company/staff-loan',true,true)?>" class="btn btn-primary"><i class="fas fa-list">&nbsp;&nbsp;</i>Staff Loan</a>
                                <a href="<?= url_path('/company/guard-loan',true,true)?>" class="btn btn-success"><i class="fas fa-list-alt">&nbsp;&nbsp;</i>Guard Loan</a>
                                <a href="<?= url_path('/company/staff-salary-advanced',true,true)?>" class="btn btn-primary"><i class="fas fa-list">&nbsp;&nbsp;</i>Staff Salary Advanced</a>
                                <a href="<?= url_path('/company/guard-salary-advanced',true,true)?>" class="btn btn-success"><i class="fas fa-list-alt">&nbsp;&nbsp;</i>Guard Salary Advanced</a>
                            </div>
                        </div>
                        
                        <table class="table table-bordered table-no-more table-striped mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Guard ID</th>
                                <th>Firstname</th>
                                <th>Othernames</th>
                                <th>Loan Reason</th>
                                <th>Salary Advance Amt</th>
                                <th>Issued Date</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_guard_salary_advance($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($guard_sa = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Guard ID"><?= $guard_sa['guard_id'];?></td>
                                        <td data-title="Fullname"><?= $guard_sa['guard_firstname'];?></td>
                                        <td data-title="Othernames"><?= $guard_sa['guard_middlename']." ".$guard_sa['guard_lastname'];?></td>
                                        <td data-title="Loan Reason"><?= $guard_sa['salary_adv_reason'];?></td>
                                        <td data-title="Salary Advance Amount">₦<?= number_format($guard_sa['salary_adv_amount'],0);?></td>
                                        <td data-title="Date issued"><?=  date("d/m/Y h:i a", strtotime($guard_sa['created_at']));?></td>
                                        <td data-title="Status">
                                            <?= ($guard_sa['ga_status'] =='Completed')?
                                                '<span class="badge badge-success">Completed</span>':
                                                '<span class="badge badge-danger">Pending</span>';?>
                                        </td>
                                       
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No guard salary advance found</td></tr>";} ?>
                            </tbody>
                        </table>

                    </div>
                </section>
                   
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>
<script src=<?= public_path("js/examples/examples.modals.js"); ?>></script>

