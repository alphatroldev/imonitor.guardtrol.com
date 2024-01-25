<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Registered Kits</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Registered Kits</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Registered Kits</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?= url_path('/company/add-kit',true,true);?>" class="btn btn-primary pr-3"><i class="fas fa-plus">&nbsp;&nbsp;</i>Add Kit</a>
                                    <a href="#modalRegisterKit" class="btn btn-primary reg-kit-modal"><i class="fas fa-plus">&nbsp;&nbsp;</i>Register New Kits</a>
                                    <a href="<?= url_path('/staff/list-registered-kit',true,true);?>" class="btn btn-success"><i class="fas fa-plus">&nbsp;&nbsp;</i>List Registered Kits</a>

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
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_company_kits_by_id($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Kit Name"><?= $row['kit_name'];?></td>
                                        <td data-title="Created Date"><?= date("d/m/Y H:i", strtotime($row['kit_created_on']));?></td>
                                        <td data-title="Actions" class="actions">
                                            <a href="javascript:void(0)" data-kit_sno="<?= $row['kit_sno'];?>" data-comp_id="<?=$c['company_id'];?>" class="on-default text-danger" id="regKitDeleteBtn">
                                                <i class="far fa-trash-alt"></i> delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No registered kits found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.staff.php"); ?>
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
