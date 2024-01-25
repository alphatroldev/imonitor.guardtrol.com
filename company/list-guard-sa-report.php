<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Guard Salary Advance Report History</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Salary Advance Report History</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">Guard Salary Advance Report History</h2>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <a href="<?= url_path('/company/generate-salary-advance-report',true,true)?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Generate Guard S.A Report</a>
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
                        $res = $company->get_all_company_guard_salary_advance_report_history($c['company_id']);
                        if ($res->num_rows > 0) {$n=0;
                        while ($row = $res->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?=++$n;?></td>
                                <td><?= $row['sa_rh_month'].' - '.$row['sa_rh_year'];?></td>
                                <td>
                                    <a href="<?= url_path('/company/guard-salary-advance-report-details/'.$row['sa_rh_month'].'-'.$row['sa_rh_year'],true,true)?>"
                                       class="btn btn-sm btn-default"><i class="fas fa-list-alt">&nbsp;</i>view details</a>
                                </td>
                                <td class="actions">
                                    <button type="button" data-sa_rh_month="<?= $row['sa_rh_month'];?>" data-sa_rh_year="<?= $row['sa_rh_year'];?>"
                                            data-comp_id="<?= $c['company_id'];?>"
                                            class="btn btn-sm btn-danger" id="guardSAReportDeleteBtn"><i class="far fa-trash-alt"></i> delete
                                    </button>
                                </td>
                            </tr>
                        <?php } } else { echo "<tr><td colspan='12' class='text-center'>No guard salary advance report history found</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.com.php"); ?>