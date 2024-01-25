<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./");
?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Company | <?= $_SESSION['COMPANY_LOGIN']['company_name']; ?></h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Profile</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>

        <div class="row">
            <div class="col-lg-4 col-xl-4 mb-4 mb-xl-0">
                <section class="card">
                    <div class="card-body">
                        <div class="thumb-info mb-3">
                            <img src="<?= public_path('uploads/company/').$c['company_logo'];  ?>" class="rounded img-fluid" alt="<?=$c['company_name']?>">
                            <div class="thumb-info-title">
                                <span class="thumb-info-inner"><?= $_SESSION['COMPANY_LOGIN']['company_name'] ?? 'Name Required' ?></span>
                                <span class="thumb-info-type"><?= $_SESSION['COMPANY_LOGIN']['company_id'] ?></span>
                            </div>
                        </div>

                        <div class="widget-toggle-expand mb-3">
                            <div class="widget-header">
                                <h5 class="mb-2 font-weight-semibold text-dark">Profile Completion</h5>
                                <div class="widget-toggle">+</div>
                            </div>
                            <div class="widget-content-collapsed">
                                <div class="progress progress-xs light">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                        60%
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content-expanded">
                                <ul class="simple-todo-list mt-3">
                                    <li class="<?= (!empty($_SESSION['COMPANY_LOGIN']['company_logo']))?"completed":"" ?>">Update Profile Picture</li>
                                    <li class="<?= (!empty($_SESSION['COMPANY_LOGIN']['company_name']))?"completed":"" ?>">Change Personal Information</li>
                                    <li>Complete Configuration</li>
                                </ul>
                            </div>
                        </div>


                        <hr class="dotted short">

                        <h5 class="mb-2 mt-3">About</h5>
                        <p class="text-2"><?= $c['company_description'] ?? 'Enter Description' ?></p>
                        <div class="clearfix"></div>

                        <hr class="dotted short">

                        <div class="social-icons-list">
                            <a rel="tooltip" data-bs-placement="bottom" target="_blank" href="http://www.facebook.com" data-original-title="Facebook"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
                            <a rel="tooltip" data-bs-placement="bottom" href="http://www.twitter.com" data-original-title="Twitter"><i class="fab fa-twitter"></i><span>Twitter</span></a>
                            <a rel="tooltip" data-bs-placement="bottom" href="http://www.linkedin.com" data-original-title="Linkedin"><i class="fab fa-linkedin-in"></i><span>Linkedin</span></a>
                        </div>

                    </div>
                </section>
            </div>
            <div class="col-lg-8 col-xl-8">
                <div class="tabs">
                    <ul class="nav nav-tabs tabs-primary">
                        <li class="nav-item active">
                            <button class="nav-link" data-bs-target="#edit" data-bs-toggle="tab">Info</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-target="#documents" data-bs-toggle="tab">Documents</button>
                        </li>
                    </ul>
                    <div class="tab-content ">
                        <div id="edit" class="tab-pane active">
                            <form class="p-3" id="update_company_per_profile" name="update_company_per_profile">
                                <h4 class="mb-3 font-weight-semibold text-dark">Company Information</h4>
                                <div id="response-alert"></div>
                                <div class="form-group mb-3">
                                    <label for="c_name">Company Name</label>
                                    <div class="input-group">
                                        <input name="c_name" type="text" class="form-control form-control" id="c_name" value="<?= $c['company_name'] ?>" />
                                        <input type="hidden" name="c_info" value="1" />
                                        <span class="input-group-text"><i class="bx bx-user text-4"></i></span>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="c_email">Company Email</label>
                                    <div class="input-group">
                                        <input name="c_email" type="text" class="form-control form-control" id="c_email" value="<?= $c['company_email'] ?>" />
                                        <span class="input-group-text"><i class="bx bx-mail-send text-4"></i></span>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="c_address">Company Address</label>
                                    <div class="input-group">
                                        <input name="c_address" type="text" class="form-control form-control" id="c_address" value="<?= $c['company_address'] ?>" />
                                        <span class="input-group-text"><i class="bx bx-current-location text-4"></i></span>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="c_phone">Company Phone</label>
                                    <div class="input-group">
                                        <input name="c_phone" type="text" class="form-control form-control" id="c_phone" value="<?= $c['company_phone'] ?>" />
                                        <span class="input-group-text"><i class="bx bx-phone-call text-4"></i></span>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="c_description">Company Description</label>
                                    <div class="input-group">
                                        <textarea name="c_description" type="text" class="form-control form-control"><?= $c['company_description'] ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <input type="submit" class="btn btn-primary mt-2 px-4" value="Submit" />
                                    </div>
                                </div>
                            </form>

                            <hr class="dotted">
                            <form class="p-3" name="update_company_per_password" id="update_company_per_password">
                                <h4 class="mb-3 font-weight-semibold text-dark">Change Password</h4>
                                <div id="response-alert-2"></div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-3">
                                        <label for="old_password">Current Password</label>
                                        <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Password">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="password">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="con_password">Repeat New Password</label>
                                        <input type="password" class="form-control" id="con_password" name="con_password" placeholder=" Repeat Password">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <button class="btn btn-primary modal-confirm px-4">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="documents" class="tab-pane ">
                            <form class="p-3" id="update_company_doc" name="update_company_doc">
                                <h4 class="mb-3 font-weight-semibold text-dark">Documents Information</h4>
                                <div class="form-group row pb-2">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="c_op">Operational State</label>
                                            <div class="input-group">
                                                <input name="c_op" type="text" class="form-control" id="c_op" value="<?= $c['company_op_state'] ?>" />
                                                <span class="input-group-text"><i class="bx bx-home-alt text-4"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="c_no_op">No of Operational State</label>
                                            <div class="input-group">
                                                <input name="c_no_op" type="text" class="form-control" id="c_no_op" value="<?= $c['company_no_op_state'] ?>" />
                                                <span class="input-group-text"><i class="bx bxs-school text-4"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pb-2">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="c_rc_no">C.A.C (RC No.)</label>
                                            <div class="input-group">
                                                <input name="c_rc_no" type="text" class="form-control" id="c_rc_no" value="<?= $c['company_rc_no'] ?>" />
                                                <span class="input-group-text"><i class="bx bx-hotel text-4"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="c_tax_id">Tax ID No</label>
                                            <div class="input-group">
                                                <input name="c_tax_id" type="text" class="form-control" id="c_tax_id" value="<?= $c['company_tax_id_no'] ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="c_reg_no">C.A.C (<small class="text-info">scanned copy</small>)</label>
                                    <input name="cac_file" type="file" class="form-control" id="cac_file" value="" />
                                    <input type="hidden" name="cac_file_txt" value="<?=$c['company_cac_file'];?>" />
                                    <a class="mb-1 mt-1 me-1" href="<?= public_path('uploads/company/'.$c['company_cac_file']);?>" target="_blank">view image</a>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="c_license">NSCDC License (<small class="text-info">scanned copy</small>)</label>
                                    <input name="c_license" type="file" class="form-control" id="c_license" value="" />
                                    <input type="hidden" name="c_license_txt" value="<?=$c['company_op_license'];?>" />
                                    <a class="mb-1 mt-1 me-1" href="<?= public_path('uploads/company/'.$c['company_op_license']);?>" target="_blank">view image</a>
                                </div>
                                <div class="row row mb-4">
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <button class="btn btn-primary modal-confirm px-4">Update</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>