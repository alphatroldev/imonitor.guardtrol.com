<?php include_once("inc/header.sup.php"); ?>
<?php if (!isset($_SESSION['SUPPORT_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Create Company</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?=url_path('/support/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Add Company</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Create New Company</h2>
                    </header>
                    <form name="create_company" id="create_company" enctype="multipart/form-data">
                        <div class="card-body">
                            <div id="response-alert"></div>
                            <div class="form-group row pb-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Company Name <span class="required">*</span></label>
                                        <input type="text" name="c_name" class="form-control" title="Enter company name" required />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Company Logo <span class="required">*</span></label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input">
                                                    <i class="fas fa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileupload-exists">Change</span>
                                                    <span class="fileupload-new">Select file</span>
                                                        <input type="file" name="c_logo" id="c_logo" />
                                                </span>
                                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Company Email <span class="required">*</span></label>
                                        <input type="email" name="c_email" class="form-control" title="Enter email address" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Company Address <span class="required">*</span></label>
                                        <input type="text" name="c_address" class="form-control" title="Enter company address" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Company Phone <span class="required">*</span></label>
                                        <input type="text" name="c_phone" class="form-control" title="Enter company office number" maxlength="11" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label text-lg-end pt-2" for="c_descr">Company Description</label>
                                        <textarea class="form-control" rows="3" id="c_descr" name="c_descr"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h3> More Info </h3>
                            <hr>
                            <div class="form-group row pb-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Company Guard Strength <span class="required">*</span></label>
                                        <input type="text" name="c_guard_str" id="c_guard_str" class="form-control" title="Enter company guard strength" required />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Company Operation State <span class="required">*</span></label>
                                        <input type="text" name="c_op_state" id="c_op_state" class="form-control" title="Enter company operation states" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="c_op_state">No of Operation State <span class="required">*</span></label>
                                        <input type="number" name="c_op_number" id="c_op_number" class="form-control" title="Enter company number" required />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Company RC No <span class="required">*</span></label>
                                        <input type="text" name="c_reg_no" id="c_reg_no" class="form-control" title="Enter company RC No number" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="c_tax_id">Tax ID No<span class="required">*</span></label>
                                        <input type="text" name="c_tax_id" id="c_tax_id" class="form-control" title="Enter company tax ID" required />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Company Operation License <span class="required">*</span></label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input">
                                                    <i class="fas fa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileupload-exists">Change</span>
                                                    <span class="fileupload-new">Select file</span>
                                                    <input type="file" name="c_op_license" id="c_op_license" />
                                                </span>
                                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Password <span class="required">*</span></label>
                                        <input type="password" name="password" class="form-control" title="Please enter password" required />
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
                                    <input class="btn btn-primary px-3" type="submit" value="Create Company Instance" />
                                </div>
                            </div>
                        </footer>
                    </form>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.sup.php"); ?>