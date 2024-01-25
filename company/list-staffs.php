<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Staff List</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>List staff</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">List staff</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?= url_path('/company/add-staff',true,true)?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Add New Staff</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_company_staff_account($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><?= $row['staff_firstname'].' '.$row['staff_middlename'].' '.$row['staff_lastname'];?></td>
                                        <td><?= $row['staff_email'];?></td>
                                        <td><?= $row['staff_phone'];?></td>
                                        <td><?= $row['company_role_name'];?></td>
                                        <td>
                                            <?=($row['staff_acc_status'] =='Active')?
                                                '<span class="badge badge-success">Active</span>':
                                                '<span class="badge badge-danger">In-active</span>';?>
                                        </td>
                                        <td>
                                            <a href="<?= url_path('/company/edit-staff/'.$row['staff_id'],true,true)?>" class="btn btn-xs btn-default"><i class="fas fa-pencil-alt">&nbsp;</i>view more</a>
                                            <a href="<?= url_path('/company/staff-activity-log/'.$row['staff_id'],true,true);?>" class="on-default remove-row ml-2">
                                                <i class="fas fa-book"></i>
                                            </a>
                                        </td>
                                        <td class="actions">
                                            <a href="javascript:void(0)" data-staff_sno="<?= $row['staff_sno'];?>" class="on-default text-danger remove-row" id="staffDeleteBtn">
                                                <i class="far fa-trash-alt"></i> delete
                                            </a>
                                            <?php if ($row['staff_acc_status'] =='Active'){ ?>
                                                <button data-staff_sno="<?=$row['staff_sno'];?>" title="Deactivate staff account" data-active="Deactivate" class="btn btn-xm btn-danger px-1 py-0" id="staffStatusBtn">
                                                    Disable
                                                </button>
                                            <?php } else { ?>
                                                <button data-staff_sno="<?=$row['staff_sno'];?>" title="Activate staff account" data-active="Active" class="btn btn-xm btn-success px-1 py-0" id="staffStatusBtn">
                                                    Activate
                                                </button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No staff found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>