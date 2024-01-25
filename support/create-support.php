<?php include_once("inc/header.sup.php"); ?>
<?php if (!isset($_SESSION['SUPPORT_LOGIN'])) header("Location: ./"); ?>
<?php if ($_SESSION['SUPPORT_LOGIN']['support_super'] != 'Yes') header("Location: dashboard"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Create Support</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?=url_path('/support/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Add support</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">
                        <a href="<?=url_path('/support/list',true,true);?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Add new support</h2>
                </header>
                <form name="create_support" id="create_support">
                    <div class="card-body">
                        <div id="response-alert"></div>
                        <div class="row pb-3">
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Full Name <span class="required">*</span></label>
                                    <input type="text" name="fullname" class="form-control" title="Please enter fullname" required />
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Support Type <span class="required">*</span></label>
                                    <select class="form-control mb-3" name="sup_type" title="Please select type" required>
                                        <option value=""></option>
                                        <option value="No">Normal</option>
                                        <option value="Yes">Super</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Email address <span class="required">*</span></label>
                                    <input type="email" name="email" class="form-control" title="Please enter email address" required />
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Status <span class="required">*</span></label>
                                    <select class="form-control mb-3" name="sup_status" title="" required>
                                        <option value="Yes">Active</option>
                                        <option value="No">In-Active</option>
                                    </select>
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
                                <input class="btn btn-primary px-5" type="submit" value="Create Support" />
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </div>
                    </footer>
                </form>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.sup.php"); ?>