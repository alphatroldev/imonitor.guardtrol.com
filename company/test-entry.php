<?php include_once("inc/header.com.php"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Create Penalty & Charge</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Test Entry</span></li>
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
                            <a href="<?= url_path('/company/penalties',true,true)?>">
                                <i class="fas fa-arrow-left">&nbsp;&nbsp;</i>
                            </a>Test Entry
                        </h2>
                    </header>
                    <form name="test_entry" id="test_entry">
                        <div class="card-body">
                            <div id="response-alert"></div>
                            <div class="form-group row pb-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">First Name <span class="required">*</span></label>
                                        <input type="text" name="fname" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Last Name <span class="required">*</span></label>
                                        <input type="text" name="lname" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Phone <span class="required">*</span></label>
                                        <input type="text" name="phone" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Email <span class="required">*</span></label>
                                        <input type="text" name="email" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <footer class="card-footer py-3">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input class="btn btn-primary px-5" type="submit" value="Submit" />
                                </div>
                            </div>
                        </footer>
                    </form>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>