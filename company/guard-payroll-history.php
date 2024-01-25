<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Guard Payroll History</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Guard Payroll History</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Guard Payroll History</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?= url_path('/company/create-guard-payroll',true,true)?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Generate Guard Payroll</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Date (Month - Year)</th>
                                <th>View</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_company_guard_payroll_history($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><?= $row['gpr_month'].' - '.$row['gpr_year'];?></td>
                                        <td>
                                            <a href="<?= url_path('/company/guard-payroll/'.$row['gpr_month'].'-'.$row['gpr_year'],true,true)?>"
                                               class="btn btn-sm btn-default"><i class="fas fa-list-alt">&nbsp;</i>view details</a>
                                        </td>
                                        <td class="actions">
                                            <button type="button" data-gpr_month="<?= $row['gpr_month'];?>" data-gpr_year="<?= $row['gpr_year'];?>"
                                                    data-comp_id="<?= $c['company_id'];?>"
                                                    class="btn btn-sm btn-danger" id="guardPayrollDeleteBtn"><i class="far fa-trash-alt"></i> delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No guard payroll history found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>