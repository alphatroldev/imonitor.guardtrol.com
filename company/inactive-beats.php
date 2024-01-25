<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Inactve Beats</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span><a href="<?= url_path('/company/list-beats',true,true)?>">Beats</a></span></li>
                    <li><span>Inactive Beats</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Inactive Beats</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?= url_path('/company/list-beats',true,true)?>" class="btn btn-success">Active Beats</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped mb-0" id="datatable-company" style="font-size: 11px">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Client</th>
                                <th>Beat Name</th>
                                <th>No. of Personnel</th>
                                <th>Active Personnel</th>
                                <th>Status
                                <th>Log</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $beat->get_inactive_beats($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    $client_name = $beat->get_client_info($row['client_id']);
                                    $name = $client_name->fetch_assoc();
                                    $beat_personnel = $beat->get_beat_personnel($c['company_id'], $row['beat_id']);
                                    $act_guard = $beat->get_active_beat_with_guard($c['company_id'], $row['beat_id']);
                                    $act_super = $beat->get_active_beat_with_super($c['company_id'], $row['beat_id']);
                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><?= $name['client_fullname'];?></td>
                                        <td><?= $row['beat_name'];?></td>
                                        <td><?= $beat_personnel;?></td>
                                        <td><?= ($beat_personnel <= ($act_guard+$act_super))?
                                                '<a href="'. url_path('/company/list-active-beat-guard/'.$row['beat_id'], true, true).'">
                                                    <span class="text-success font-weight-bold">'.($act_guard+$act_super).'</span></a>':
                                                '<a href="'. url_path('/company/list-active-beat-guard/'.$row['beat_id'], true, true).'">
                                                <span class="text-danger font-weight-bold">'.($act_guard+$act_super).'</span></a>';?>
                                        </td>
                                        <td>
                                            <?=($row['beat_status'] =='Active')?
                                                '<span class="badge badge-success">Active</span>':
                                                '<span class="badge badge-danger">In-active</span>';?>
                                        </td>
                                        <td>
                                            <a href="<?= url_path('/company/beat-activity-log/'.$row['beat_id'],true,true);?>"
                                               style="font-size: 11px" class="btn btn-xm btn-default px-2 py-1"> <i class="bx bx-book-alt">&nbsp;</i>view log
                                            </a>
                                        </td>
                                        <td class="actions">
                                            <a href="<?= url_path('/company/edit-beat/'.$row['beat_id'],true,true);?>" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="javascript:void(0)" data-beat_sno="<?= $row['beat_sno'];?>"  data-beat_id="<?= $row['beat_id'];?>" class="on-default remove-row" id="beatDeleteBtn">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                            <?php if ($row['beat_status'] =='Active'){ ?>
                                                <a style="font-size: 11px" data-beat_id="<?= $row['beat_id'];?>" title="Deactivate beat"
                                                   data-active="Deactivate" class="btn btn-xm btn-danger text-white modal-with-move-anim ws-normal px-1 py-0" id="beatStatusBtn" href="#changeStatus">
                                                    Disable
                                                </a>
                                            <?php } else { ?>
                                                <a style="font-size: 11px" data-beat_id = "<?= $row['beat_id'];?>" title="Activate beat"
                                                   data-active="Active" class="btn btn-xm btn-success text-white modal-with-move-anim ws-normal px-1 py-0" id="beatStatusBtn" href="#changeStatus">
                                                    Activate
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Beat found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
        <!-- Change Status Animation -->
        <div id="changeStatus" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
            <form name="changeBeatStat" id="changeBeatStat" class="card">
                <header class="card-header">
                    <h2 class="card-title">Change Status <small>(Enabling this beat also enable all guards attached to it)</small> </h2>
                </header>
                <div class="card-body">
                    <div class="modal-wrapper py-0">
                        <div class="form-group mb-3">
                            <label for="bt_st_status">Status</label>
                            <select class="form-control" name="bt_st_status" id="bt_st_status">
                                <option value=""></option>
                                <option value="Deactivate">Deactivate</option>
                                <option value="Active">Re-activate</option>
                            </select>
                            <input type="hidden" name="bt_st_beat_id" id="bt_st_beat_id" />
                            <input type="hidden" name="bt_st_comp_id" id="bt_st_comp_id" value="<?=$c['company_id'];?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="bt_st_date">Date</label>
                            <input type="date" name="bt_st_date" id="bt_st_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="bt_st_remark">Remark</label>
                            <textarea name="bt_st_remark" rows="3" id="bt_st_remark" class="form-control" placeholder="Remark" required></textarea>
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
<script src="<?= public_path("js/examples/examples.modals.js"); ?>"></script>