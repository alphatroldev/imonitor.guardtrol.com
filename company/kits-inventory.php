<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Kits Inventory</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Kits Inventory</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Kits Inventory</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?= url_path('/company/add-kit',true,true);?>" class="btn btn-primary pr-3"><i class="fas fa-plus">&nbsp;&nbsp;</i>Add Kit</a>
                                    <a href="#modalRegisterKit" class="btn btn-success reg-kit-modal"><i class="fas fa-plus">&nbsp;&nbsp;</i>Register New Kits</a>
                                    <a href="<?= url_path('/company/list-registered-kit',true,true);?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>List Registered Kits</a>

                                    <div id="editKitInvModal" class="modal-block modal-block-primary mfp-hide">
                                        <form name="update_kit_inventory" id="update_kit_inventory" class="card">
                                            <header class="card-header">
                                                <h2 class="card-title">Edit Kit Inventory</h2>
                                            </header>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12 mb-4">
                                                        <label for="edit_kit_type">Select Kit Type</label>
                                                        <select id="edit_kit_type"  name="edit_kit_type" class="form-control">
                                                            <option value="">Choose kit type</option>
                                                            <option value="New">New</option>
                                                            <option value="Old">Old</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12 mb-4">
                                                        <label for="edit_kit_id">Select Kit</label>
                                                        <input type="hidden" id="edit_kit_id"  name="edit_kit_id" readonly="">
                                                        <input type="text" id="edit_kit_name" class="form-control" readonly="">
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12 mb-4">
                                                        <label for="edit_kit_num">Kit Number</label>
                                                        <input type="text" class="form-control" id="edit_kit_num" name="edit_kit_num">
                                                        <input type="hidden" name="edit_comp_id" value="<?=$c['company_id'];?>">
                                                        <input type="hidden" name="edit_kit_inv_sno" id="edit_kit_inv_sno" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <footer class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-12 text-end">
                                                        <input type="submit" class="btn btn-primary modal-confirm" value="Update" />
                                                        <button class="btn btn-default modal-dismiss">Close</button>
                                                    </div>
                                                </div>
                                            </footer>
                                        </form>
                                    </div>
                                    <div id="modalRegisterKit" class="modal-block modal-block-primary mfp-hide">
                                        <form name="register_new_kit" id="register_new_kit" class="card">
                                            <header class="card-header">
                                                <h2 class="card-title">Register a New Kit</h2>
                                            </header>
                                            <div class="card-body">
                                                <div id="response-alert"></div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12 my-4">
                                                        <label for="kit_name" class="mb-2 font-weight-bold">Kit Name</label>
                                                        <input type="text" class="form-control shadow-none" id="kit_name" name="kit_name" placeholder="Enter Kit Name">
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
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-no-more mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Kit Name</th>
                                <th>Available Qty</th>
                                <th>Kit Type</th>
                                <th>Last Updated Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_company_kits_inventory($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Kit Name"><?= $row['kit_name'];?></td>
                                        <td data-title="Available Qty"><?= $row['kit_number'];?></td>
                                        <td data-title="Kit Type"><?= $row['kit_type'];?></td>
                                        <td data-title="Last Updated Date"><?= date("d/m/Y H:i", strtotime($row['k_inv_updated']));?></td>
                                        <td data-title="Actions" class="actions">
                                            <a href="#editKitInvModal" class="on-default edit-row edit-kit-modal text-success mr-3" id="edit_kit_inventory"
                                               data-kit_inv_sno="<?= $row['kit_inv_sno'];?>" data-kit_qty="<?= $row['kit_number'];?>" data-kit_type="<?= $row['kit_type'];?>"  data-kit_id="<?= $row['kit_sno'];?>"
                                                data-kit_name="<?= $row['kit_name'];?>">
                                                <i class="fas fa-pencil-alt"></i> edit
                                            </a>
                                            <a href="javascript:void(0)" data-kit_inv_sno="<?= $row['kit_inv_sno'];?>" data-comp_id="<?=$c['company_id'];?>" class="on-default text-danger" id="kitInvDeleteBtn">
                                                <i class="far fa-trash-alt"></i> delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No kit inventory found</td></tr>";} ?>
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
        $('.add-kit-modal').magnificPopup({
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
    (function($) {
        'use strict';
        $('.reg-kit-modal').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#kit_type',
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
                    else {this.st.focus = '#kit_type';}
                }
            }
        });
    }).apply(this, [jQuery]);
</script>
<script>
    (function($) {
        'use strict';
        $('.edit-kit-modal').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#edit_kit_type',
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
                    else {this.st.focus = '#edit_kit_type';}
                }
            }
        });
    }).apply(this, [jQuery]);
</script>
