<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Inactive Clients</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span><a href="<?= url_path('/company/list-clients',true,true)?>">List Clients</a></span></li>
                    <li><span>Inactive Clients</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Inactive Clients</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?= url_path('/company/list-clients',true,true)?>" class="btn btn-success">Active Clients</a>
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
                                <th>Number of Beats</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $client->get_inactive_clients($c['company_id']);
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
                                            <a href="<?= url_path('/company/edit-client/'.$row['client_id'],true,true)?>" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="javascript:void(0)" data-id="<?= $row['id'];?>" class="on-default remove-row" id="clientDeleteBtn">
                                                <?php if ($staff_type['staff_type'] == 'Owner'){?>
                                                    <i class="far fa-trash-alt"></i>
                                                <?php }?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No inactive Client</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
        <!-- Disabled Client Modal -->
        <div id="changeStatus" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
            <form name="changeClientStatus" id="changeClientStatus" class="card">
                <header class="card-header"><h2 class="card-title">Change Status</h2></header>
                <div class="card-body">
                    <div class="modal-wrapper py-0">
                        <div class="form-group">
                            <label for="clientStatus">Status</label>
                            <select class="form-control" name="clientStatus" id="clientStatus">
                                <option value="Deactivated">Deactivated</option>
                                <option value="Active">Active/Reactivate</option>
                            </select>
                            <input type="hidden" name="client_id" id="client_id_mod" /><br>
                            <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                        </div>
                        <div class="form-group">
                            <label for="">Contract Enabled On</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input type="text" data-plugin-datepicker="" name="term_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="clientStatusRemark">Remark/Reason</label>
                            <textarea name="clientStatusRemark" rows="2" id="clientStatusRemark" class="form-control" placeholder="Remark" required></textarea>
                        </div>
                    </div>
                </div>
                <footer class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <input type="submit" class="btn btn-primary" value="Update">
                            <button class="btn btn-default modal-dismiss">Cancel</button>
                        </div>
                    </div>
                </footer>
            </form>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>
<script src=<?= public_path("js/examples/examples.modals.js"); ?>></script>
