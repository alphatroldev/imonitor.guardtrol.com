<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>
<?php if(!in_array($list_client_permission_sno['perm_sno'], $array))header("Location:".$location_redirect);?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Client List</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>List Clients</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Clients</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 pb-3">
                                <a href="<?= url_path('/staff/create-client',true,true)?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Register Client</a>
                                <a href="<?= url_path('/staff/inactive-clients',true,true)?>" class="btn btn-danger ml-2">Inactive Clients</a>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped mb-0" id="datatable-staff">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Number of Beats</th>
                                <th>Status</th>
                                <th>Actions</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $client->get_all_active_clients($c['company_id']);
                            $staff_type = $client->get_staff_type($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <?php
                                    $check_client_beats = $client->check_client_beats($c['company_id'],$row['client_id']);
                                    $number_of_beats  =  $check_client_beats->num_rows;


                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><?= $row['client_fullname'];?></td>
                                        <td><?= $row['client_email'];?></td>
                                        <td><?= $row['client_office_phone'];?></td>
                                        <td><?= $number_of_beats;?></td>
                                        <td>
                                            <?=($row['client_status'] =='Active')?
                                                '<span class="badge badge-success">Active</span>':
                                                '<span class="badge badge-danger">In-active</span>';?>
                                        </td>
                                        <td class="actions">
                                            <a href="<?= url_path('/staff/edit-client/'.$row['client_id'],true,true)?>"
                                               class="btn btn-xs btn-default"><i class="fas fa-pencil-alt">&nbsp;</i>view more
                                            </a>
                                        </td>
                                        
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Client found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.staff.php"); ?>