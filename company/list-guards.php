<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Guard List</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Guard List</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Guards</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?= url_path('/company/create-guard',true,true)?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Register Guard</a>
                                    <a href="<?= url_path('/company/inactive-guards',true,true)?>" class="btn btn-danger">Inactive Guards</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>First Name</th>
                                <th>Other Names</th>
                                <th>Phone</th>
                                <th>Client</th>
                                <th>Beat</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $guard->get_all_active_guards($c['company_id']);
                            $staff_type = $client->get_staff_type($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <?php
                                    // $guard_beat_info = $deploy_guard->get_guard_beat($row['guard_id']);
                                    

                                    // if ($guard_beat_info->num_rows > 0) {
                                    //     $guard_beat = $guard_beat_info->fetch_assoc();
                                    // }
                                    
                                    // $get_guard_beat_name = $deploy_guard->get_guard_beat_name($guard_beat['beat_id']);
                                    // $beat = $get_guard_beat_name->fetch_assoc();

                                    // $get_guard_client_name = $deploy_guard->get_guard_client_name($beat['client_id']);
                                    // $client = $get_guard_client_name->fetch_assoc();

                                    // $num_deployed_guard = $deploy_guard->get_num_deployed_guard($row['guard_id']);
                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><?= $row['guard_firstname'];?></td>
                                        <td><?= $row['guard_middlename']." ".$row['guard_lastname'];?></td>
                                        <td><?= $row['phone'];?></td>
                                        <?php  if($row['client_fullname'] != NULL && !empty($row['client_fullname'])){?>
                                            <td><?= $row['client_fullname'];?></td>
                                        <?php }else{?>
                                            <td class="font-weight-bold text-warning">Not Deployed Yet</td>
                                        <?php }?>
                                        <?php  if($row['beat_name'] != NULL && !empty($row['beat_name'])){?>
                                            <td><?= $row['beat_name'];?></td>
                                        <?php }else{?>
                                            <td class="font-weight-bold text-warning">Not Deployed Yet</td>
                                        <?php }?>
                                        <td>
                                            <?=($row['guard_status'] =='Active')?
                                                '<span class="badge badge-success">Active</span>':
                                                '<span class="badge badge-danger">In-active</span>';?>
                                        </td>
                                        <td class="actions">
                                            <a href="<?= url_path('/company/edit-guard/'.$row['guard_id'],true,true);?>" class="btn btn-xs btn-default"><i class="fas fa-pencil-alt"></i> View</a>
                                            <a href="javascript:void(0)" data-guard_id="<?= $row['guard_id'];?>" class="on-default remove-row" id="guardDeleteBtn">
                                                <?php if ($staff_type['staff_type'] == 'Owner'){?>
                                                    <i class="far fa-trash-alt"></i>
                                                <?php }?>
                                            </a>
                                            <a href="<?= url_path('/company/guard-activity-log/'.$row['guard_id'],true,true);?>" class="on-default remove-row">
                                                <i class="fas fa-book"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Guard found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>