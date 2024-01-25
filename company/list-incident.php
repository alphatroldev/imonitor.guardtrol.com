<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>List Incident</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>All incident</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">List Incident Reports</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?= url_path('/company/incident',true,true)?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Report Incident</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-no-more mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Inc. ID</th>
                                <th>Reported By</th>
                                <th>Incident Details</th>
                                <th>View</th>
                                <th>Reported Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            $res = $company->get_all_company_incidents($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Inc. ID"><?= $row['inc_rep_id'];?></td>
                                        <td data-title="Reported By"><?= $row['staff_firstname'].' '.$row['staff_lastname'];?></td>
                                        <td data-title="Incident Title"><?= $row['report_title'].' - '.$row['report_describe'];?></td>
                                        <td data-title="View"><a class="btn btn-default btn-xs" href="<?= url_path('/company/incidents/'.$row['inc_rep_id'],true, true);?>">view more</a></td>
                                        <td data-title="Date Created"><?= date("d/m/Y H:i", strtotime($row['report_created_on']));?></td>
                                        <td data-title="Actions" class="actions">
                                            <a href="javascript:void(0)" data-incident_id="<?= $row['inc_rep_id'];?>" data-comp_id="<?=$c['company_id'];?>" class="on-default text-danger" id="incidentDeleteBtn">
                                                <i class="far fa-trash-alt"></i> delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No reports found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>