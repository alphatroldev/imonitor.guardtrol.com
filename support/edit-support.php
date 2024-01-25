<?php include_once("inc/header.sup.php"); ?>
<?php if (!isset($_SESSION['SUPPORT_LOGIN'])) header("Location: ./"); ?>
<?php if ($_SESSION['SUPPORT_LOGIN']['support_super'] != 'Yes') header("Location: ../dashboard"); ?>
<?php
if (!isset($s_id) || $s_id == NULL ) {echo "<script>window.location = '".url_path('/support/list',true,true)."'; </script>";}
?>
<?php
$res = $support->get_support_by_id($s_id);
if ($res->num_rows > 0) {
while ($row = $res->fetch_assoc()) {
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Edit Support</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?=url_path('/support/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Edit support</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">
                        <a href="<?=url_path('/support/list',true,true);?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Edit Support
                    </h2>
                </header>
                <form name="profile" id="profile">
                    <div class="card-body">
                        <div id="response-alert"></div>
                        <div class="form-group row pb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Full Name <span class="required">*</span></label>
                                    <input type="text" name="fullname" class="form-control" title="Please enter fullname" value="<?=$row['support_name'];?>" />
                                    <input type="hidden" name="support_id" value="<?=$row['support_id'];?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Email address <span class="required">*</span></label>
                                    <input type="email" name="email" class="form-control" title="Please enter email address" value="<?=$row['support_email'];?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Support Type <span class="required">*</span></label>
                                    <select class="form-control mb-3" name="sup_type" title="Please select type">
                                        <option value=""></option>
                                        <option value="No" <?=($row['support_super']=='No')?'selected':'';?>>Normal</option>
                                        <option value="Yes" <?=($row['support_super']=='Yes')?'selected':'';?>>Super</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Status <span class="required">*</span></label>
                                    <select class="form-control mb-3" name="sup_status" title="" required>
                                        <option value="Yes" <?=($row['support_active']=='Yes')?'selected':'';?>>Active</option>
                                        <option value="No" <?=($row['support_active']=='No')?'selected':'';?>>In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <div class="row">
                            <div class="col-sm-9">
                                <input class="btn btn-primary px-5" type="submit" value="Update Profile" />
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </div>
                    </footer>
                </form>
                <form id="profile_password" name="profile_password">
                    <div class="card-body">
                        <label for="" CLASS="my-3 font-weight-bold">UPDATE PROFILE PASSWORD HERE</label>
                        <div id="response-alert-2"></div>
                        <div class="form-group row pb-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Password <span class="required">*</span></label>
                                    <input type="password" name="password" class="form-control" title="Please enter password" required />
                                    <input type="hidden" name="support_id" value="<?=$row['support_id']?>">
                                    <input type="hidden" name="support_email" value="<?=$row['support_email']?>">
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
                                <input class="btn btn-primary px-5" type="submit" value="Update Password" />
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </div>
                    </footer>
                </form>
            </section>
        </div>
    </div>
</section>
<?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.sup.php"); ?>