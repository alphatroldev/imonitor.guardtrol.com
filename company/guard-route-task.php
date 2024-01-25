<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Guard Route Task</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>All Route Task</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" ></a></div>
                        <h2 class="card-title">List Route Task</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a class="btn btn-primary assign-task-modal" href="#AssignRouteTask">Assign Route to Guard</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-no-more mb-0" style="font-size: 12px;" id="datatable-company">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Route Name</th>
                                <th>Guard ID</th>
                                <th>Guard Name</th>
                                <th>Beat Name</th>
                                <th>Route Points</th>
                                <th>Route Status</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_assigned_task($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Route Name"><?= $row['g_route_name'];?></td>
                                        <td data-title="Guard ID"><?= $row['guard_id'];?></td>
                                        <td data-title="Guard Name"><?= $row['guard_firstname'].' '.$row['guard_middlename'].' '.$row['guard_lastname'];?></td>
                                        <td data-title="Beat Name"><?= $row['beat_name'];?></td>
                                        <td data-title="Route Points">
                                            <a class="btn btn-default btn-xs assigned-points-modal" href="#AssignPoints" data-g_route_name="<?= $row['g_route_name'];?>">view point</a>
                                        </td>
                                        <td data-title="Route Status"><?= $row['g_route_status'];?></td>
                                        <td data-title="Date Created"><?= date("d/m/Y H:i", strtotime($row['g_route_date']));?></td>
                                        <td data-title="Actions" class="actions">
                                            <a href="javascript:void(0)" data-g_route_sno="<?= $row['g_route_sno'];?>" data-comp_id="<?=$c['company_id'];?>" class="on-default text-danger" id="gRouteTaskDelBtn">
                                                <i class="far fa-trash-alt"></i> delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No route task found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <div id="AssignRouteTask" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
            <form name="assign_route_to_guard" id="assign_route_to_guard" class="card">
                <header class="card-header"><h2 class="card-title">Assign Route Task to Guard</h2></header>
                <div class="card-body">
                    <div class="modal-wrapper py-0">
                        <div class="form-group mb-4">
                            <label for="routes">Select Routes (Beat ID)</label>
                            <select class="form-control populate" name="routes" id="routes">
                                <option value=""></option>
                                <?php
                                $route = $company->get_all_routes($c['company_id']);
                                if ($route->num_rows > 0) {
                                while ($rou = $route->fetch_assoc()) {
                                ?>
                                <option value="<?=$rou['route_name'];?>"><?=$rou['route_name'];?> (<?=$rou['beat_name'];?>)</option>
                                <?php } } ?>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label for="guard_id">Select Guard <small class="text-info">(Only guard in selected route beat is shown)</small></label>
                            <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Select Guard", "allowClear": true }'  name="guard_id" id="guard_id">
                                <option value=""></option>
                            </select>
                            <input type="hidden" name="comp_id" id="comp_id" value="<?=$c['company_id'];?>">
                        </div>
                    </div>
                </div>
                <footer class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <input type="submit" class="btn btn-primary" value="Save">
                            <button class="btn btn-default modal-dismiss">Close</button>
                        </div>
                    </div>
                </footer>
            </form>
        </div>
        <div id="AssignPoints" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
            <header class="card-header"><h2 class="card-title">Assigned Points</h2></header>
            <div class="card-body">
                <div class="modal-wrapper py-0">
                    <div id="assignedPointsDetails" class="mb-2">
                        Points Here
                    </div>
                </div>
            </div>
            <footer class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button class="btn btn-default modal-dismiss">Close</button>
                    </div>
                </div>
            </footer>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>
<script>
    (function($) {
        'use strict';
        $('.assign-task-modal').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#name',
            modal: true,
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in',
            callbacks: {
                beforeOpen: function() {
                    if($(window).width() < 700) {this.st.focus = false;}
                    else {this.st.focus = '#name';}
                }
            }
        });
        $('.assigned-points-modal').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#name',
            modal: true,
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in',
            callbacks: {
                beforeOpen: function() {
                    if($(window).width() < 700) {this.st.focus = false;}
                    else {this.st.focus = '#name';}
                }
            }
        });
    }).apply(this, [jQuery]);
</script>
<script>
    $('select[name="routes"]').change(function(){
        var route_name = $(this).val();
        $.ajax({
            url: "guard-route-task-info", type: "POST", data: {route_name:route_name},
            success: function (data) {
                $("#guard_id").html(data);
            }
        });
    });

    $('.assigned-points-modal').on("click", function(){
        var g_route_name = $(this).data("g_route_name");
        $.ajax({
            url: "guard-route-points-info", type: "POST", data: {route_name:g_route_name},
            success: function (data) {
                $("#assignedPointsDetails").html(data);
            }
        });
    });
</script>