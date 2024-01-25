<?php include_once("inc/header.client.php"); ?>
<?php if (!isset($_SESSION['CLIENT_LOGIN'])) header("Location: ./"); ?>

<?php
$res = $client->get_client_by_id($_SESSION['CLIENT_LOGIN']['cli_id'],$_SESSION['CLIENT_LOGIN']['cli_company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Account Settings</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?=url_path('/client/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
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
                        <img src="../public/img/!logged-user.jpg" class="rounded img-fluid" alt="">
                        <div class="thumb-info-title">
                            <span class="thumb-info-inner"><?=$row['client_email'];?></span>
                            <span class="thumb-info-inner"><?=$row['client_id'];?></span>
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
                        <form class="py-0 px-3" id="" name="">
                            <h4 class="mb-3 font-weight-semibold text-dark">Personal Information</h4>
                            <div class="row mb-4">
                                <div class="form-group col">
                                    <label for="bs_email">Email Address</label>
                                    <input readonly type="text" class="form-control" name="bs_email" id="bs_email" value="<?=$row['client_email'];?>">
                                    <input readonly type="hidden" class="form-control" name="bs_beats" id="bs_beats" value="<?=$row['client_id'];?>">
                                </div>
                            </div>
                        </form>
                        <hr class="dotted tall my-4">
                        <form class="py-0 px-3" id="update_client_pwd" name="update_client_pwd">
                            <h4 class="mb-3 font-weight-semibold text-dark">Change Password</h4>
                            <div id="response-alert-2"></div>
                            <div class="row mb-4">
                                <div class="form-group col">
                                    <input type="password" class="form-control" name="cli_old_pwd" title="" placeholder="Enter Current Password">
                                    <input type="hidden" name="cli_id" id="cli_id" value="<?=$row['client_id'];?>">
                                    <input type="hidden" name="comp_id" id="comp_id" value="<?=$comp_id;?>">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="form-group col">
                                    <input type="password" class="form-control" name="cli_pwd" title="" placeholder="Enter New Password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <input type="password" class="form-control" name="cli_con_pwd" title="" placeholder="Repeat New Password">
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
<?php include_once("inc/footer.client.php"); ?>
<script>
     $("form[name='update_client_pwd']").validate({
        rules: {
            cli_old_pwd: "required",
            cli_pwd: {required: true, minlength: 6},
            cli_con_pwd: {required: true, equalTo: '[name="cli_pwd"]'}
        },
        messages: {
            cli_email: "Old password is required",
            cli_pwd: {required: "Enter a password", minlength: "Password must be at least six(6) characters"},
            cli_con_pwd: {required: "Required", equalTo: "Password not matched"}
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "update-client-pro-pwd", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse('Success',data.message);
                        $.alert({
                            title: 'Success!', content: data.message, type: 'green', typeAnimated: true,
                            buttons: {ok: function () {window.location.reload();}}
                        });
                    } else {
                        sendErrorResponse('Error', data.message);
                        $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                    }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });
</script>