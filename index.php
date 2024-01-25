<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


date_default_timezone_set('Africa/Lagos'); // WAT
include_once("controllers/classes/Support.class.php");
include_once("controllers/classes/Company.class.php");
?>
    <!DOCTYPE html>
    <html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Guardtrol - Security Guard System</title>
        <meta name="keywords" content="Guardtrol Template" />
        <meta name="description" content="Guardtrol - Security Guard System">
        <meta name="author" content="Guardtrol">
        <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />
        <link rel="apple-touch-icon" href="assets/images/apple-touch-icon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
        <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="vendor/animate/animate.compat.css">
        <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
        <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
        <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">
        <link rel="stylesheet" href="assets/css/theme.css">
        <link rel="stylesheet" href="assets/css/theme-elements.css">
        <link rel="stylesheet" href="assets/css/theme-blog.css">
        <link rel="stylesheet" href="assets/css/theme-shop.css">
        <link id="skinCSS" rel="stylesheet" href="assets/css/skin-corporate-21.css">
        <link rel="stylesheet" href="assets/css/custom.css">
        <script src="vendor/modernizr/modernizr.min.js"></script>
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
                                        <img alt="Porto" width="" height="48" src="assets/images/logo.png">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="header-column justify-content-end">
                            <div class="header-row">
                                <nav class="header-nav-top">
                                    <ul class="nav nav-pills text-uppercase text-2">
                                        <li class="nav-item nav-item-anim-icon d-none d-md-block">
                                            <a class="nav-link ps-0" href="https://alphatrol.com/guardtrol/" target="_blank"><i class="fas fa-angle-right"></i> About Us</a>
                                        </li>
                                        <li class="nav-item nav-item-anim-icon d-none d-md-block">
                                            <a class="nav-link" href="https://alphatrol.com/contact us/" target="_blank"><i class="fas fa-angle-right"></i> Contact Support</a>
                                        </li>
                                        <li class="nav-item nav-item-anim-icon d-none d-md-block">
                                            <a class="nav-link" href="<?= url_path('/company/entry',true,true)?>"><i class="fas fa-angle-right"></i> Test Entry</a>
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
                            <h1 class="font-weight-bold text-dark">Sign In</h1>
                        </div>
                    </div>
                    <div class="tabs">
                        <div class="tab-content p-lg-5 p-3">
                            <div id="owner_login" class="tab-pane active">
                                <form id="owner_staff_login" name="owner_staff_login">
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
                                    <div class="divider">
                                        <span class="bg-light px-4 position-absolute left-50pct top-50pct transform3dxy-n50">OR</span>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <a href="<?= url_path('/register',true,true)?>" class="btn btn-dark btn-modern w-100 text-uppercase rounded-0 font-weight-bold text-3 py-3">Register</a>
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
                    <p class="pe-1">Guardtrol provides digital security services for businesses and organizations. Our focus is on delivering innovative solutions that help businesses improve their productivity,efficiency, and security.</p>
                </div>
                <div class="col-md-6 col-lg-4 mb-4 mb-md-0">
                    <div class="contact-details">
                        <h5 class="text-3 mb-3">CONTACT US</h5>
                        <ul class="list list-icons list-icons-lg">
                            <li class="mb-1"><i class="far fa-dot-circle text-color-primary"></i><p class="m-0">167 Adetokunbo Ademola Cres, Wuse, Abuja, Nigeria</p></li>
                            <li class="mb-1"><i class="fab fa-whatsapp text-color-primary"></i><p class="m-0"><a href="tel:+234 704-1111-161">+234 704-1111-161</a></p></li>
                            <li class="mb-1"><i class="far fa-envelope text-color-primary"></i><p class="m-0"><a href="mailto:info@alphatrol.com">info@alphatrol.com</a></p></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <h5 class="text-3 mb-3">FOLLOW US</h5>
                    <ul class="social-icons">
                        <li class="social-icons-facebook"><a href="https://www.facebook.com/AlphatrolTech/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li class="social-icons-twitter"><a href="https://www.twitter.com/AlphatrolTech/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                        <li class="social-icons-instagram"><a href="https://www.instagram.com/AlphatrolTech/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container py-2">
                <div class="row py-4">
                    <div class="col-lg-1 d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0">
                        <a href="./" class="logo pe-0 pe-lg-3">
                            <img alt="Porto Website Template" src="assets/images/logo-footer.png" class="opacity-5" width="49" height="22" data-plugin-options="{'appearEffect': 'fadeIn'}">
                        </a>
                    </div>
                    <div class="col-lg-7 d-flex align-items-center justify-content-center justify-content-lg-start mb-4 mb-lg-0">
                        <p>© Copyright 2023. All Rights Reserved.</p>
                    </div>
                    <div class="col-lg-4 d-flex align-items-center justify-content-center justify-content-lg-end">
                        <nav id="sub-menu">
                            <ul>
                                <li><i class="fas fa-angle-right"></i><a href="https://alphatrol.com/guardtrol/" class="ms-1 text-decoration-none" target="_blank"> About Us</a></li>
                                <li><i class="fas fa-angle-right"></i><a href="https://alphatrol.com/contact us/" class="ms-1 text-decoration-none" target="_blank"> Contact Support</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- Vendor -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/jquery.appear/jquery.appear.min.js"></script>
<script src="vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="vendor/jquery.cookie/jquery.cookie.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery.validation/jquery.validate.min.js"></script>
<script src="vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
<script src="vendor/jquery.gmap/jquery.gmap.min.js"></script>
<script src="vendor/lazysizes/lazysizes.min.js"></script>
<script src="vendor/isotope/jquery.isotope.min.js"></script>
<script src="vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="vendor/vide/jquery.vide.min.js"></script>
<script src="vendor/vivus/vivus.min.js"></script>
<!-- Theme Base, Components and Settings -->
<script src="assets/js/theme.js"></script>
<!-- Theme Custom -->
<script src="assets/js/custom.js"></script>
<!-- Theme Initialization Files -->
<script src="assets/js/theme.init.js"></script>
<script src="assets/js/views/view.auth.js"></script>

</body>
</html>
