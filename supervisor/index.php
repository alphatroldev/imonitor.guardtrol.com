<?php
date_default_timezone_set('Africa/Lagos'); // WAT
include_once("controllers/classes/Supervisor.class.php");
include_once("controllers/classes/Company.class.php");
?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Guardtrol Supervisor - Security Guard System</title>
    <meta name="keywords" content="Guardtrol Template" />
    <meta name="description" content="Guardtrol - Security Guard System">
    <meta name="author" content="Guardtrol">
    <base href="https://imonitor.guardtrol.com/supervisor/">
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="../assets/images/apple-touch-icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/animate/animate.compat.css">
    <link rel="stylesheet" href="../vendor/simple-line-icons/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="../vendor/owl.carousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../vendor/owl.carousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="../vendor/magnific-popup/magnific-popup.min.css">
    <link rel="stylesheet" href="../assets/css/theme.css">
    <link rel="stylesheet" href="../assets/css/theme-elements.css">
    <link rel="stylesheet" href="../assets/css/theme-blog.css">
    <link rel="stylesheet" href="../assets/css/theme-shop.css">
    <link id="skinCSS" rel="stylesheet" href="../assets/css/skin-corporate-21.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <script src="../vendor/modernizr/modernizr.min.js"></script>
</head>
<body data-plugin-page-transition>
<div class="body">
    <header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': false, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 70}">
        <div class="header-body border-color-primary header-body-bottom-border">
            <div class="header-top header-top-default border-bottom-0">
                <div class="container">
                    <div class="header-row py-2">
                        <div class="header-column justify-content-start">
                            <div class="header-row">
                                <div class="header-logo">
                                    <a href="./">
                                        <img alt="Porto" width="" height="48" src="../assets/images/logo.png">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="header-column justify-content-end">
                            <div class="header-row">
                                <nav class="header-nav-top">
                                    <ul class="nav nav-pills text-uppercase text-2">
                                        <li class="nav-item nav-item-anim-icon d-none d-md-block">
                                            <a class="nav-link ps-0" href="<?= url_path('/about',true,true)?>"><i class="fas fa-angle-right"></i> About Us</a>
                                        </li>
                                        <li class="nav-item nav-item-anim-icon d-none d-md-block">
                                            <a class="nav-link" href="<?= url_path('/contact',true,true)?>"><i class="fas fa-angle-right"></i> Contact Support</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div role="main" class="main">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6">
                    <div class="row">
                        <div class="col-md-12 align-self-center p-static order-2 text-center">
                            <h1 class="font-weight-bold text-dark">Beat Supervisor Sign In</h1>
                        </div>
                    </div>
                    <div class="tabs">
                        <div class="tab-content p-lg-5 p-3">
                            <div id="owner_login" class="tab-pane active">
                                <form id="supervisor_login" name="supervisor_login">
                                    <div id="response-alert"></div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="form-label text-color-dark text-3">Email address <span class="text-color-danger">*</span></label>
                                            <input type="email" class="form-control shadow-none text-4" name="email"  required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label class="form-label text-color-dark text-3">Password <span class="text-color-danger">*</span></label>
                                            <input type="password" class="form-control shadow-none text-4" name="password"  required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col mt-3">
                                            <input type="submit" value="Login" class="btn btn-primary-scale-2 btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3" data-loading-text="Please wait..." />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer">
        <div class="container">
            <div class="footer-ribbon">
                <span>Get in Touch</span>
            </div>
            <div class="row py-5 my-4">
                <div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-3 mb-3">About Guardtrol</h5>
                    <p class="pe-1">Keep up on our always evolving product features and technology. Enter your e-mail address and subscribe to our newsletter.</p>
                </div>
                <div class="col-md-6 col-lg-4 mb-4 mb-md-0">
                    <div class="contact-details">
                        <h5 class="text-3 mb-3">CONTACT US</h5>
                        <ul class="list list-icons list-icons-lg">
                            <li class="mb-1"><i class="far fa-dot-circle text-color-primary"></i><p class="m-0">234 Street Name, City Name</p></li>
                            <li class="mb-1"><i class="fab fa-whatsapp text-color-primary"></i><p class="m-0"><a href="tel:8001234567">+234 807 700 8000</a></p></li>
                            <li class="mb-1"><i class="far fa-envelope text-color-primary"></i><p class="m-0"><a href="mailto:contact@guardtrol.com">contact@guardtrol.com</a></p></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <h5 class="text-3 mb-3">FOLLOW US</h5>
                    <ul class="social-icons">
                        <li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container py-2">
                <div class="row py-4">
                    <div class="col-lg-1 d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0">
                        <a href="./" class="logo pe-0 pe-lg-3">
                            <img alt="Porto Website Template" src="../assets/images/logo-footer.png" class="opacity-5" width="49" height="22" data-plugin-options="{'appearEffect': 'fadeIn'}">
                        </a>
                    </div>
                    <div class="col-lg-7 d-flex align-items-center justify-content-center justify-content-lg-start mb-4 mb-lg-0">
                        <p>© Copyright 2021. All Rights Reserved.</p>
                    </div>
                    <div class="col-lg-4 d-flex align-items-center justify-content-center justify-content-lg-end">
                        <nav id="sub-menu">
                            <ul>
                                <li><i class="fas fa-angle-right"></i><a href="<?= url_path('/about',true,true)?>" class="ms-1 text-decoration-none"> About Us</a></li>
                                <li><i class="fas fa-angle-right"></i><a href="<?= url_path('/contact',true,true)?>" class="ms-1 text-decoration-none"> Contact Support</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- Vendor -->
<script src="../public/vendor/jquery/jquery.js"></script>
<script src="../public/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="../public/vendor/popper/umd/popper.min.js"></script>
<script src="../public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../public/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../public/vendor/common/common.js"></script>
<script src="../public/vendor/nanoscroller/nanoscroller.js"></script>
<script src="../public/vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="../public/vendor/jquery-placeholder/jquery.placeholder.js"></script>
<script src="../public/vendor/jquery-validation/jquery.validate.js"></script>
<script src="../public/vendor/pnotify/pnotify.custom.js"></script>
<!-- Theme Base, Components and Settings -->
<script src="../assets/js/theme.js"></script>
<!-- Theme Custom -->
<script src="../assets/js/custom.js"></script>
<!-- Theme Initialization Files -->
<script src="../assets/js/theme.init.js"></script>
<script src=<?= public_path("js/views/view.supervisor.js"); ?>></script>
<script>
    $("form[name='supervisor_login']").validate({
        rules: {
            email: {required: true,email:true},
            password: "required"
        },
        messages: {
            email: "Enter a valid email address",
            password: "Enter you password"
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
                url: "login-supervisor", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('supervisor_login').reset();
                        sendSuccessResponse('Success',data.message);
                        setTimeout(()=>window.location.replace(data.location),1000);
                    } else { sendErrorResponse('Error', data.message); }
                },
                error: function (errData) {},
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });
</script>

</body>
</html>
