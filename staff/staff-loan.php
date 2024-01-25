<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>

    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Staff Loan History</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Staff Loan History</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">List Staff Loan</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <a href="<?= url_path('/staff/staff-loan',true,true)?>" class="btn btn-primary"><i class="fas fa-list">&nbsp;&nbsp;</i>Staff Loan</a>
                                <a href="<?= url_path('/staff/guard-loan',true,true)?>" class="btn btn-success"><i class="fas fa-list-alt">&nbsp;&nbsp;</i>Guard Loan</a>
                                <a href="<?= url_path('/staff/staff-salary-advanced',true,true)?>" class="btn btn-primary"><i class="fas fa-list">&nbsp;&nbsp;</i>Staff Salary Advanced</a>
                                <a href="<?= url_path('/staff/guard-salary-advanced',true,true)?>" class="btn btn-success"><i class="fas fa-list-alt">&nbsp;&nbsp;</i>Guard Salary Advanced</a>
                            </div>
                        </div>
                        <table class="table table-bordered table-no-more table-striped mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Loan ID</th>
                                <th>Fullname</th>
                                <th>Loan Reason</th>
                                <th>Loan Amount</th>
                                <th>Monthly Amount</th>
                                <th>Issued Date</th>
                                <th>Due Date</th>
                                <th>Loan Balance</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_staff_loans($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($stf_loan = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Loan ID"><?= $stf_loan['staff_loan_id'];?></td>
                                        <td data-title="Fullname"><?= $stf_loan['staff_firstname'].' '.$stf_loan['staff_middlename'].' '.$stf_loan['staff_lastname'];?></td>
                                        <td data-title="Loan Reason"><?= $stf_loan['staff_loan_reason'];?></td>
                                        <td data-title="Loan Amount">₦<?= number_format($stf_loan['staff_loan_amount'],0);?></td>
                                        <td data-title="Monthly Amount">₦<?= number_format($stf_loan['staff_loan_monthly_amount'],0);?></td>
                                        <td data-title="Date issued"><?=  $stf_loan['staff_loan_date'];?></td>
                                        <td data-title="Due Date"><?= $stf_loan['loan_due_date'];?></td>
                                        <td data-title=">Loan Balance">₦<?= number_format($stf_loan['staff_loan_curr_balance'],0);?></td>
                                        <td data-title="Status">
                                            <?= ($stf_loan['staff_loan_status'] =='Completed')?
                                                '<span class="badge badge-success">Completed</span>':
                                                '<span class="badge badge-danger">Pending</span>';?>
                                        </td>
                                       
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No staff loan found</td></tr>";} ?>
                            </tbody>
                        </table>

                    </div>
                </section>
                   
            </div>
        </div>
    </section>
    
<?php include_once("inc/footer.staff.php"); ?>
