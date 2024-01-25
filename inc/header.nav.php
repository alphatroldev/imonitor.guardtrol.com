<?php
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
    <link rel="stylesheet" href="vendor/fontawesome-free/css/all.min.css">
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
                                <nav class="header-nav-top">
                                    <ul class="nav nav-pills text-uppercase text-2">
                                        <li class="nav-item nav-item-anim-icon d-none d-md-block">
                                            <a class="nav-link ps-0" href="<?= url_path('/about',true,true)?>"><i class="fas fa-angle-right"></i> About Us</a>
                                        </li>
                                        <li class="nav-item nav-item-anim-icon d-none d-md-block">
                                            <a class="nav-link" href="<?= url_path('/contact',true,true)?>"><i class="fas fa-angle-right"></i> Contact Us</a>
                                        </li>
                                        
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="header-column justify-content-end">
                            <div class="header-row">
                                <nav class="header-nav-top">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a href="mailto:contact@guardtrol.com">
                                                <i class="far fa-envelope text-4 text-color-primary" style="top: 1px;"></i> contact@guardtrol.com
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="tel:+234 807 700 8000">
                                                <i class="fab fa-whatsapp text-4 text-color-primary" style="top: 0;"></i> +234 807 700 8000
                                            </a>
                                        </li>
<!--                                        <li class="nav-item">-->
<!--                                            <a href="guard-login">-->
<!--                                                <i class="fas fa-user-lock text-4 text-color-primary" style="top: 0;"></i> Guard Area-->
<!--                                            </a>-->
<!--                                        </li>-->
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-container container">
                <div class="header-row">
                    <div class="header-column">
                        <div class="header-row">
                            <div class="header-logo">
                                <a href="./">
                                    <img alt="Porto" width="100" height="48" src="assets/images/logo-default-slim2.png">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="header-column justify-content-end">
                        <div class="header-row">
                            <div class="header-nav header-nav-links order-2 order-lg-1">
                                <div class="header-nav-main header-nav-main-square header-nav-main-effect-2 header-nav-main-sub-effect-1">
                                    <nav class="collapse">
                                        <ul class="nav nav-pills" id="mainNav">
                                            <li class="dropdown"><a class="dropdown-item active current-page-active" href="./">Home</a></li>
                                            <li class="dropdown">
                                                <a class="dropdown-item" href="<?= url_path('/services',true,true)?>">Services</a>
                                            </li>
                                            <li class="dropdown">
                                                <a class="dropdown-item" href="<?= url_path('/about',true,true)?>">About</a>
                                            </li>
                                            <li class="dropdown">
                                                <a class="dropdown-item" href="<?= url_path('/contact',true,true)?>">Contact</a>
                                            </li>
                                            <?php if (isset($_SESSION['GUARD_LOGIN']) && isset($_SESSION['GUARD_LOGIN']['g_id'])){ ?>
                                            <li class="dropdown"><a class="dropdown-item" href="<?=$_SESSION['GUARD_LOGIN']['location']?>"><i class="fas fa-user-circle"></i>&nbsp;Dashboard</a></li>
                                            <?php } else { ?>
                                            <li class="dropdown"><a class="dropdown-item" href=".">SignIn</a></li>
                                            <?php } ?>
                                        </ul>
                                    </nav>
                                </div>
                                <ul class="header-social-icons social-icons d-none d-sm-block">
                                    <li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                </ul>
                                <button class="btn header-btn-collapse-nav" data-bs-toggle="collapse" data-bs-target=".header-nav-main nav">
                                    <i class="fas fa-bars"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
