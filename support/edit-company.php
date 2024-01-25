<?php include_once("inc/header.sup.php"); ?>
<?php if (!isset($_SESSION['SUPPORT_LOGIN'])) header("Location: ./"); ?>
<?php
if (!isset($c_id) || $c_id == NULL) {
    echo "<script>window.location = '".url_path('/support/list-company',true,true)."'; </script>";
}
?>
<?php
$res = $support->get_company_by_id($c_id);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Edit Company</h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li><a href="<?=url_path('/support/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                        <li><span>Edit Company</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <div class="row">
                <div class="col-lg-4">
                    <section class="card">
                        <header class="card-header bg-primary">
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <?php if (!empty($row['company_logo'])) { ?>
                                    <img src="../public/uploads/company/<?= $row['company_logo'] ?>">
                                    <?php } ?>
                                </div>
                                <div class="profile-info">
                                    <h4 class="name font-weight-semibold mb-0"><?= $row['company_name']; ?></h4>
                                    <h5 class="role mt-0">Administrator</h5>
                                    <div class="profile-footer" style="border-top: none;">
                                        <form name="logo_upload" id="logo_upload" enctype="multipart/form-data">
                                            <input type="file" name="c_logo" id="c_logo_update" />
                                            <input type="hidden" name="file_upload" id="file_upload" value="<?= $row['company_sno'] ?>" />
                                            <input type="hidden" name="cname" id="cname" value="<?= $row['company_name'] ?>" />
                                            <input type="hidden" name="phone" id="phone" value="<?= $row['company_phone'] ?>" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </section>
                    <section class="card">
                        <header class="card-header bg-light ">
                            <div class="widget-profile-info">
                                <form name="license_upload" id="license_upload" method="POST" enctype="multipart/form-data">
                                    <div class="profile-info">
                                        <?php if (empty($row['company_op_license'])) { ?>
                                            <p>Please submit document</p>
                                        <? } else { ?>
                                            <h4 class="text-dark name font-weight-semibold mb-0"><?= str_replace('_', ' ', $row['company_op_license']); ?></h4>
                                        <?php } ?>
                                        <h5 class="role mt-0 text-dark">License File</h5>
                                        <div class="profile-footer">
                                            <input type="file" name="c_op_license" id="c_license_update" />
                                            <input type="hidden" name="file_upload" id="file_upload" value="<?= $row['company_sno'] ?>" />
                                            <input type="hidden" name="cname" id="cname" value="<?= $row['company_name'] ?>" />
                                            <input type="hidden" name="phone" id="phone" value="<?= $row['company_phone'] ?>" />
                                        </div>
                                    </div>
                                    <?php if ($row['company_op_license'] != ''){?>
                                    <a href="../public/uploads/company/<?= $row['company_op_license'] ?>" target="_blank">current licence</a>
                                    <?php }?>
                                </form>
                            </div>
                        </header>
                    </section>
                </div>
                <div class="col">
                    <section class="card">
                        <header class="card-header">
                            <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                            <h2 class="card-title"><a href="<?=url_path('/support/list-company',true,true);?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Edit Company</h2>
                        </header>
                        <form name="update_company_profile_by_id" id="update_company_profile_by_id">
                            <div class="card-body">
                                <div id="response-alert"></div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Company Name <span class="required">*</span></label>
                                            <input type="text" name="c_name" class="form-control" title="Enter company name" value="<?= $row['company_name']; ?>" />
                                            <input type="hidden" name="company_sno" value="<?= $row['company_sno']; ?>">
                                            <input type="hidden" name="staff_id" value="<?= $row['staff_id']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Company Email <span class="required">*</span></label>
                                            <input type="email" name="c_email" class="form-control" title="Enter email address" value="<?= $row['company_email']; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Company Address <span class="required">*</span></label>
                                            <input type="text" name="c_address" class="form-control" title="Enter company address" value="<?= $row['company_address']; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Company Phone <span class="required">*</span></label>
                                            <input type="text" name="c_phone" class="form-control" title="Enter company office number" maxlength="11" value="<?= $row['company_phone']; ?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Company Description</label>
                                            <textarea name="c_description" id="" class="form-control"><?= $row['company_description']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <h3> More Info </h3>
                                <hr>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Company Guard Strength (from 0 to 100) <span class="required">*</span></label>
                                            <input type="number" name="c_guard_str" id="c_guard_str" class="form-control" value="<?= $row['company_gd_strg']; ?>" title="Enter company guard strength" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Company Operation State <span class="required">*</span></label>
                                            <input type="text" name="c_op_state" id="c_op_state" class="form-control" value="<?= $row['company_op_state']; ?>" title="Enter company operation states" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row pb-3">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="col-form-label" for="c_op_state">No of Operation State <span class="required">*</span></label>
                                            <input type="number" name="c_op_number" id="c_op_number" class="form-control" value="<?= $row['company_no_op_state']; ?>" title="Enter company number" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Company RC No <span class="required">*</span></label>
                                            <input type="text" name="c_reg_no" id="c_reg_no" class="form-control" value="<?= $row['company_rc_no']; ?>" title="Enter company registration number" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="col-form-label" for="c_tax_id">Tax ID No <span class="required">*</span></label>
                                            <input type="text" name="c_tax_id" id="c_tax_id" class="form-control" value="<?= $row['company_tax_id_no']; ?>" title="Enter company tac ID" required />
                                        </div>
                                    </div>
                                </div>
                                <footer class="card-footer">
                                    <div class="form-group row">
                                        <div class="col-sm-9 p-0 mt-3">
                                            <input class="btn btn-primary px-5" type="submit" value="Update Profile" />
                                        </div>
                                    </div>
                                </footer>
                            </div>
                        </form>
                    </section>
                    <section class="card">
                        <header class="card-header">
                            <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                            <h2 class="card-title">Update/reset Password Here</h2>
                        </header>
                        <form id="update_company_password" name="update_company_password">
                            <div class="card-body">
                                <div id="response-alert-2"></div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Password <span class="required">*</span></label>
                                            <input type="password" name="password" class="form-control" title="Please enter password" required />
                                            <input type="hidden" name="staff_id" value="<?= $row['staff_id'] ?>">
                                            <input type="hidden" name="company_email" value="<?= $row['company_email'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Confirm Password <span class="required">*</span></label>
                                            <input type="password" name="confirm_password" class="form-control" title="Please confirm new password" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <input class="btn btn-primary px-3" type="submit" value="Update Password" />
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    <?php }
} else {
    include_once("404.php");
} ?>
<?php include_once("inc/footer.sup.php"); ?>