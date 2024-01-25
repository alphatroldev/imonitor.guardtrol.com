<?php include_once("inc/header.sup.php"); ?>
<?php if (!isset($_SESSION['SUPPORT_LOGIN'])) header("Location: ./"); ?>
<?php if ($_SESSION['SUPPORT_LOGIN']['support_super'] != 'Yes') header("Location: dashboard"); ?>
    <style>
        .fileupload .uneditable-input .fas {
            display: none;
        }
    </style>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Upload New APP Version</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?=url_path('/support/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Upload New Version</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"></div>
                        <h2 class="card-title">
                            <a href="<?=url_path('/support/list-app-v',true,true);?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Upload New APP Version</h2>
                    </header>
                    <form name="upload_new_app_version" id="upload_new_app_version">
                        <div class="card-body">
                            <div id="response-alert"></div>
                            <div class="row pb-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="apk_file_name">APP Name (APK File Name)<span class="required">*</span></label>
                                        <input type="text" name="apk_file_name" id="" class="form-control" title="Please enter APK Filename" required />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">APK Importance <span class="required">*</span></label>
                                        <select class="form-control" id="" name="apk_imp" title="Please select importance level" required>
                                            <option value="1">1</option>
                                            <option value="0">0</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Version <span class="required">*</span></label>
                                        <input class="form-control" id="" name="apk_version" title="Please enter app version" required />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">APP File <span class="required">*</span></label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input">
                                                    <i class="fas fa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileupload-exists">Change</span><span class="fileupload-new">Select file</span>
                                                    <input type="file" name="apk_file" required />
                                                </span>
                                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <footer class="card-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="process" style="display: none;">
                                        <div class="progress mt-3" style="height: 20px;">
                                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100">0%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9 py-3">
                                    <input class="btn btn-primary px-5" type="submit" value="Submit" />
                                </div>
                            </div>
                        </footer>
                    </form>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.sup.php"); ?>