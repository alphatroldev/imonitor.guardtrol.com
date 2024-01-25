<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="mb-3">
                    <a href="<?= url_path('/company/configuration',true,true)?>" class="btn btn-primary">General Settings</a>
                    <a href="<?= url_path('/company/shifts',true,true)?>" class="btn btn-primary">Manage Shift</a>
                    <a href="<?= url_path('/company/penalties',true,true)?>" class="btn btn-primary">Penalties & Charges</a>
                    <a href="<?= url_path('/company/guard-positions',true,true)?>" class="btn btn-success">Guard Positions</a>
                    <a href="<?= url_path('/company/payroll-settings',true,true)?>" class="btn btn-primary">Payroll Config</a>
                </div>
            </div>
        </div>
        <header class="page-header">
            <h2>Manage Deployment Positions</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>List Positions</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="javascript:void " class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Manage Positions</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="#modalAddPositions" class="btn btn-primary add-position-modal pr-3"><i class="fas fa-plus">&nbsp;&nbsp;</i>Add New Position</a>
                                    <div id="modalAddPositions" class="modal-block modal-block-primary mfp-hide">
                                        <form name="add_guard_positions" id="add_guard_positions" class="card">
                                            <header class="card-header">
                                                <h2 class="card-title">Add New Guard Position</h2>
                                            </header>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12 mb-4">
                                                        <label for="pos_title">Position Alias</label>
                                                        <select class="form-control" name="pos_type" id="pos_type">
                                                            <option value="Guard">Guard</option>
                                                            <option value="Head Guard">Head Guard</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12 mb-4">
                                                        <label for="pos_title">Position Name</label>
                                                        <input type="text" class="form-control" id="pos_title" name="pos_title">
                                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <footer class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-12 text-end">
                                                        <input type="submit" class="btn btn-primary modal-confirm" value="Save" />
                                                        <button class="btn btn-default modal-dismiss">Close</button>
                                                    </div>
                                                </div>
                                            </footer>
                                        </form>
                                    </div>

                                    <div id="modalUpdatePosition" class="modal-block modal-block-primary mfp-hide">
                                        <form name="update_guard_positions" id="update_guard_positions" class="card">
                                            <header class="card-header">
                                                <h2 class="card-title">Update Guard Position</h2>
                                            </header>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12 mb-4">
                                                        <label for="edit_pos_type">Position Alias</label>
                                                        <select class="form-control" name="edit_pos_type" id="edit_pos_type">
                                                            <option value="Guard">Guard</option>
                                                            <option value="Head Guard">Head Guard</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12 mb-4">
                                                        <label for="edit_pos_title">Position Name</label>
                                                        <input type="text" class="form-control" id="edit_pos_title" name="edit_pos_title">
                                                        <input type="hidden" id="edit_comp_id" name="edit_comp_id">
                                                        <input type="hidden" id="edit_pos_sno" name="edit_pos_sno">
                                                    </div>
                                                </div>
                                            </div>
                                            <footer class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-12 text-end">
                                                        <input type="submit" class="btn btn-primary modal-confirm" value="Save" />
                                                        <button class="btn btn-default modal-dismiss">Close</button>
                                                    </div>
                                                </div>
                                            </footer>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-no-more table-striped mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Position Title</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_company_guard_positions($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Shift Title"><?= $row['pos_title'];?></td>
                                        <td data-title="Created On"><?= date("d/m/Y h:i a", strtotime($row['pos_created_on']));?></td>
                                        <td data-title="Actions" class="actions">
                                            <a href="#modalUpdatePosition" data-comp_id="<?=$c['company_id'];?>" data-pos_sno="<?=$row['pos_sno'];?>"
                                               data-pos_type="<?=$row['pos_type'];?>" data-pos_title="<?=$row['pos_title'];?>"
                                               class="text-success edit-row mr-3 add-position-modal">
                                                <i class="fas fa-pencil-alt"></i> edit
                                            </a>
                                            <a href="javascript:void(0)" data-comp_id="<?=$c['company_id'];?>" data-pos_sno="<?=$row['pos_sno'];?>" class="text-danger remove-row" id="posDeleteBtn">
                                                <i class="far fa-trash-alt"></i> delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No positions found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>
<script>
    (function($) {
        'use strict';
        $('.add-position-modal').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#pos_title',
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
                    else {this.st.focus = '#pos_title';}
                }
            }
        });
    }).apply(this, [jQuery]);

    (function($) {
        'use strict';
        $('.add-position-modal').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#edit_pos_title',
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
                    else {this.st.focus = '#pos_title';}
                }
            }
        });
    }).apply(this, [jQuery]);
</script>