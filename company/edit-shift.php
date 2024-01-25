<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>

<?php
if (!isset($shift_id) || $shift_id == NULL ) {echo "<script>window.location = '".url_path('/company/shifts',true,true)."'; </script>";}
?>
<?php
$res = $company->get_company_shift_by_id($shift_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Edit Shift</h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                        <li><span>Edit Shift</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <section class="card">
                        <header class="card-header">
                            <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                            <h2 class="card-title"><a href="<?=url_path('/company/shifts',true,true)?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a> Edit Shift</h2>
                        </header>
                        <form name="update_company_shift" id="update_company_shift">
                            <div class="card-body">
                                <div id="response-alert"></div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Shift Title <span class="required">*</span></label>
                                            <input type="text" name="shift_title" class="form-control" title="Please enter shift title" value="<?=$row['shift_title'];?>" required />
                                            <input type="hidden" name="shift_id" value="<?=$row['shift_id'];?>" />
                                            <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Shift Hours
                                                <small class="text-info">(Hrs spent before next shift)</small> <span class="required">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user-clock"></i></span>
                                                <input name="shift_hours" type="text" title="Shift Hours: Total hours before next shift" value="<?=$row['shift_hours'];?>" class="form-control" required />
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
                                                <input name="resume_time" type="text" data-plugin-timepicker="" value="<?=$row['resume_time'];?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Closing Time <span class="required">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                <input name="close_time" type="text" data-plugin-timepicker="" value="<?=$row['close_time'];?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <input class="btn btn-primary px-5" type="submit" value="Update Shift" />
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>