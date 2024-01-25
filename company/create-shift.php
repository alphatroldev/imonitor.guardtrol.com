<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Create Shift</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Add Shift</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title"><a href="<?=url_path('/company/shifts',true,true)?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Add new shift</h2>
                    </header>
                    <form name="create_shift" id="create_shift">
                        <div class="card-body">
                            <div id="response-alert"></div>
                            <div class="form-group row pb-2">
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Shift Title <span class="required">*</span></label>
                                        <input type="text" name="shift_title" class="form-control" title="Please enter shift title" required />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Shift Hours
                                            <small class="text-info">(Hrs spent before next shift)</small> <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-clock"></i></span>
                                            <input name="shift_hours" type="text" title="Shift Hours: Total hours before next shift" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Resumption Time <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            <input name="resume_time" type="text" data-plugin-timepicker="" value="12:00 AM" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Closing Time <span class="required">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            <input name="close_time" type="text" data-plugin-timepicker="" value="12:00 PM" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="card-footer py-3">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input class="btn btn-primary px-5" type="submit" value="Create Shift" />
                                </div>
                            </div>
                        </footer>
                    </form>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>