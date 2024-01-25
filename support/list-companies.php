<?php include_once("inc/header.sup.php"); ?>
<?php if (!isset($_SESSION['SUPPORT_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Company List</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?=url_path('/support/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>List Company's</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">List Company's</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?=url_path('/support/create-company',true,true);?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Create New Company</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped mb-0" id="datatable-support">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>iMtr</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $support->get_all_company_account();
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><?= $row['company_name'];?></td>
                                        <td><?= $row['company_email'];?></td>
                                        <td><?= $row['company_phone'];?></td>
                                        <td><?= $row['company_address'];?></td>
                                        <td style="vertical-align:middle;text-align:center;">
                                            <button class="btn p-0 bg-transparent" id="supCompanyDashboardLogin" data-c_email="<?=$row['company_email'];?>">
                                                <img src="../public/img/favicon.png" style="width:20px;height:20px;" alt="Dashboard">
                                            </button>
                                        </td>
                                        <td>
                                            <?=($row['company_status'] =='1')?
                                                '<span class="badge badge-success">Active</span>':
                                                '<span class="badge badge-danger">In-Active</span>';?>
                                        </td>
                                        <td><?= date("d/m/Y h:i a",strtotime($row['com_created_at']));?></td>
                                        <td class="actions">
                                            <a href="<?= url_path('/support/edit-company/'.$row['company_id'],true,true);?>" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="javascript:void(0)" data-c_sno="<?= $row['company_sno'];?>" data-c_name="<?= $row['company_name'];?>" class="on-default remove-row" id="companyDeleteBtn">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                            <?php if ($row['company_status'] =='1'){ ?>
                                                <button data-c_sno="<?=$row['company_sno'];?>" data-c_id="<?=$row['company_id'];?>" data-s_id="<?=$row['staff_id'];?>" data-c_name="<?= $row['company_name'];?>" title="Suspend company account" data-active="0" class="btn btn-xm btn-danger px-1 py-0" id="companyStatusBtn">
                                                    Suspend
                                                </button>
                                            <?php } else { ?>
                                                <button data-c_sno="<?=$row['company_sno'];?>" data-c_id="<?=$row['company_id'];?>" data-s_id="<?=$row['staff_id'];?>" data-c_name="<?= $row['company_name'];?>" title="Activate company account" data-active="1" class="btn btn-xm btn-success px-1 py-0" id="companyStatusBtn">
                                                    Activate
                                                </button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No company found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.sup.php"); ?>