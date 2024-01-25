<?php include_once("inc/header.sup.php"); ?>
<?php if (!isset($_SESSION['SUPPORT_LOGIN'])) header("Location: ./"); ?>
<?php
$res = $support->get_support_by_sno($_SESSION['SUPPORT_LOGIN']['support_sno']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Account Settings</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?=url_path('/support/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
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
                            <span class="thumb-info-inner"><?= $row['support_name'];?></span>
                            <span class="thumb-info-type"><?= ($row['support_super']=='Yes')?'Super':'Normal';?></span>
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
                        <form class="py-0 px-3" id="update_support_profile" name="update_support_profile">
                            <h4 class="mb-3 font-weight-semibold text-dark">Personal Information</h4>
                            <div id="response-alert"></div>
                            <div class="row mb-4">
                                <div class="form-group col">
                                    <label for="sup_name">Full Name</label>
                                    <input type="text" class="form-control" name="sup_name" id="sup_name" value="<?=$row['support_name'];?>">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="form-group col">
                                    <label for="sup_email">Email Address</label>
                                    <input readonly type="text" class="form-control" name="sup_email" id="sup_email" value="<?=$row['support_email'];?>">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="form-group col">
                                    <label for="sup_type">User Type</label>
                                    <input readonly type="text" class="form-control" name="sup_type" id="sup_type" value="<?=($row['support_super']=='Yes')?'Super':'Normal';?>">
                                    <input type="hidden" name="sup_super" value="<?=$row['support_super'];?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-start mt-3"><input type="submit" class="btn btn-primary modal-confirm" value="Save" /></div>
                            </div>
                        </form>
                        <hr class="dotted tall my-4">
                        <form class="py-0 px-3" id="update_support_password" name="update_support_password">
                            <h4 class="mb-3 font-weight-semibold text-dark">Change Password</h4>
                            <div id="response-alert-2"></div>
                            <div class="row mb-4">
                                <div class="form-group col">
                                    <input type="password" class="form-control" name="old_password" title="" placeholder="Enter Current Password">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="form-group col">
                                    <input type="password" class="form-control" name="password" title="" placeholder="Enter New Password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <input type="password" class="form-control" name="con_password" title="" placeholder="Repeat New Password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-start mt-3"><input type="submit" class="btn btn-primary modal-confirm" value="Save" /></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } } ?>
<?php include_once("inc/footer.sup.php"); ?>