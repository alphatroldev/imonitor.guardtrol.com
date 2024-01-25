<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>
<?php
if (count($c) > 0) {
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Account Settings</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="index"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Profile</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-lg-4 col-xl-3 mb-4 mb-xl-0">
            <section class="card">
                <div class="card-body">
                    <div class="thumb-info mb-3">
                        <img src="../public/img/!logged-user.jpg" class="rounded img-fluid" alt="John Doe">
                        <div class="thumb-info-title">
                            <span class="thumb-info-inner"><?= $c['staff_firstname'].' '.$c['staff_middlename'];?></span>
                            <span class="thumb-info-type"><?= $c['company_role_name'];?></span>
                        </div>
                    </div>
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
                        <button class="nav-link" data-bs-target="#overview" data-bs-toggle="tab">Account Overview</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="overview" class="tab-pane active">
                        <form class="py-0 px-3" id="update_staff_per_profile" name="update_staff_per_profile">
                            <h4 class="mb-3 font-weight-semibold text-dark">Personal Information</h4>
                            <div id="response-alert"></div>
                            <div class="row form-group mb-4">
                                <div class="col-sm-6">
                                    <label for="stf_fname">First Name</label>
                                    <input type="text" class="form-control" name="stf_fname" id="stf_fname" value="<?=$c['staff_firstname'];?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="stf_mname">Middle Name</label>
                                    <input type="text" class="form-control" name="stf_mname" id="stf_mname" value="<?=$c['staff_middlename'];?>">
                                </div>
                            </div>
                            <div class="row form-group mb-4">
                                <div class="col-sm-6">
                                    <label for="stf_lname">Last Name</label>
                                    <input type="text" class="form-control" name="stf_lname" id="stf_lname" value="<?=$c['staff_lastname'];?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="stf_phone">Phone</label>
                                    <input type="text" class="form-control" name="stf_phone" id="stf_phone" value="<?=$c['staff_phone'];?>">
                                </div>
                            </div>
                            <div class="row form-group mb-4">
                                <div class="col">
                                    <label for="stf_email">Email Address</label>
                                    <input readonly type="text" class="form-control" name="stf_email" id="stf_email" value="<?=$c['staff_email'];?>">
                                </div>
                            </div>
<!--                            <div class="row form-group mb-4">-->
<!--                                <div class="col">-->
<!--                                    <label for="stf_role">Staff Role</label>-->
<!--                                    <input type="hidden" class="form-control" name="stf_role" id="stf_role" value="--><?//=$c['staff_role'];?><!--">-->
<!--                                    <input readonly type="text" class="form-control" name="stf_role_name" id="stf_role_name" value="--><?//=$c['staff_alias'];?><!--">-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="row">
                                <div class="col-md-12 text-start mt-3"><input type="submit" class="btn btn-primary modal-confirm px-4" value="Save" /></div>
                            </div>
                        </form>
                        <hr class="dotted tall my-4">
                        <form class="py-0 px-3" id="update_staff_per_password" name="update_staff_per_password">
                            <h4 class="mb-3 font-weight-semibold text-dark">Change Password</h4>
                            <div id="response-alert-2"></div>
                            <div class="row mb-2">
                                <div class="form-group col">
                                    <input type="password" class="form-control" name="old_password" title="" placeholder="Enter Current Password">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="form-group col">
                                    <input type="password" class="form-control" name="password" title="" placeholder="Enter New Password">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="form-group col">
                                    <input type="password" class="form-control" name="con_password" title="" placeholder="Repeat New Password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-start mt-3"><input type="submit" class="btn btn-primary modal-confirm px-4" value="Save" /></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<?php include_once("inc/footer.staff.php"); ?>