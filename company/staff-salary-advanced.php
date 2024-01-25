<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Staff Salary Advance History</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Staff Salary Advance History</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">List Staff Salary Advance</h2>
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
                                <th>Staff ID</th>
                                <th>Fullname</th>
                                <th>Loan Reason</th>
                                <th>Advance Salary Amount</th>
                                <th>Issued Date</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_staff_salary_advance($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($stf_salary_adv = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Staff ID"><?= $stf_salary_adv['staff_id'];?></td>
                                        <td data-title="Fullname"><?= $stf_salary_adv['staff_firstname'].' '.$stf_salary_adv['staff_middlename'].' '.$stf_salary_adv['staff_lastname'];?></td>
                                        <td data-title="Loan Reason"><?= $stf_salary_adv['salary_adv_reason'];?></td>
                                        <td data-title="Advance Salary Amount">₦<?= number_format($stf_salary_adv['salary_adv_amount'],0);?></td>
                                        <td data-title="Date issued"><?=  date("d/m/Y h:i a", strtotime($stf_salary_adv['created_at']));?></td>
                                        <td data-title="Status">
                                            <?= ($stf_salary_adv['sa_status'] =='Paid')?
                                                '<span class="badge badge-success">Completed</span>':
                                                '<span class="badge badge-danger">Pending</span>';?>
                                        </td>
                                       
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No staff salary advance found</td></tr>";} ?>
                            </tbody>
                        </table>

                    </div>
                </section>
                   
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>