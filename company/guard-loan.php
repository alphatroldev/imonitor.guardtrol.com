<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Guard Loan History</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Guard Loan History</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">List Guard Loans</h2>
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
                                <th>Loan ID</th>
                                <th>Firstname</th>
                                <th>Othernames</th>
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
                            $res = $company->get_all_guard_loans($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($guard_loan = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Guard ID"><?= $guard_loan['guard_id'];?></td>
                                        <td data-title="Loan ID"><?= $guard_loan['guard_loan_id'];?></td>
                                        <td data-title="Fullname"><?= $guard_loan['guard_firstname'];?></td>
                                        <td data-title="Othernames"><?= $guard_loan['guard_middlename']." ".$guard_loan['guard_lastname'];?></td>
                                        <td data-title="Loan Reason"><?= $guard_loan['guard_loan_reason'];?></td>
                                        <td data-title="Loan Amount">₦<?= number_format($guard_loan['guard_loan_amount'],0);?></td>
                                        <td data-title="Monthly Amount">₦<?= number_format($guard_loan['guard_loan_monthly_amount'],0);?></td>
                                        <td data-title="Date issued"><?=  date("d/m/Y h:i a", strtotime($guard_loan['guard_loan_created_at']));?></td>
                                        <td data-title="Due Date"><?=$guard_loan['loan_due_month']."-".$guard_loan['loan_due_year'];?></td>
                                        <td data-title=">Loan Balance">₦<?= number_format($guard_loan['guard_loan_curr_balance'],0);?></td>
                                        <td data-title="Status">
                                            <?= ($guard_loan['guard_loan_status'] =='Completed')?
                                                '<span class="badge badge-success">Completed</span>':
                                                '<span class="badge badge-danger">Pending</span>';?>
                                        </td>
                                       
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No guard loan found</td></tr>";} ?>
                            </tbody>
                        </table>

                    </div>
                </section>
                   
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>
<script src=<?= public_path("js/examples/examples.modals.js"); ?>></script>

