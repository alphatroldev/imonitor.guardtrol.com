<?php session_start(); 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_SESSION['SUPPORT_LOGIN'])) header("Location: dashboard");
$filepath = realpath(dirname(__FILE__));
include_once($filepath . "/../company/inc/helpers.php"); 

?>
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Guardtrol - Support System</title>
    <meta name="keywords" content="Guardtrol Template" />
    <meta name="description" content="Guardtrol - Security Guard System">
    <meta name="author" content="Guardtrol">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <base href="https://imonitor.guardtrol.com/support/">
    <link rel="shortcut icon" href='<?= public_path("img/favicon.png"); ?>' type="image/x-icon" />
    <link rel="apple-touch-icon" href='<?= public_path("img/apple-touch-icon.png"); ?>'>
    <link id="googleFonts" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800%7CShadows+Into+Light&display=swap" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href='<?= public_path("vendor/bootstrap/css/bootstrap.min.css"); ?>'>
    <link rel="stylesheet" href='<?= public_path("vendor/font-awesome/css/all.min.css"); ?>'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href='<?= public_path("vendor/animate/animate.compat.css"); ?>'>
    <link rel="stylesheet" href='<?= public_path("vendor/boxicons/css/boxicons.min.css"); ?>' />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href='<?= public_path("vendor/magnific-popup/magnific-popup.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/pnotify/pnotify.custom.css"); ?>' />
     <link rel="stylesheet" href='<?= public_path("css/theme.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("css/skins/default.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("css/custom.css"); ?>'>
    <script src='<?= public_path("vendor/modernizr/modernizr.js"); ?>'></script>
    <style>
        form .error {color: #e74c3c;border-color: #e74c3c !important;}
        form label.error{font-size: 0.8rem;}
    </style>
</head>
<body>
<section class="body-sign">
    <div class="center-sign">
        <a href="./" class="logo float-left">
            <img src='<?= public_path("img/logo.png");?>' height="70" alt="Guardtrol Admin" />
        </a>
        <div class="panel card-sign">
            <div class="card-title-sign mt-3 text-end">
                <h2 class="title text-uppercase font-weight-bold m-0">
                    <i class="bx bx-user-circle me-1 text-6 position-relative top-5"></i>Support Sign In
                </h2>
            </div>
            <div class="card-body">
                <form id="support_login" name="support_login">
                    <div id="response-alert"></div>
                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <div class="input-group">
                            <input name="email" type="text" class="form-control form-control-lg" id="email" />
                            <span class="input-group-text"><i class="bx bx-mail-send text-4"></i></span>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input name="password" type="password" class="form-control form-control-lg" id="password" />
                            <span class="input-group-text"><i class="bx bx-lock text-4"></i></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8"></div>
                        <div class="col-sm-4 text-end">
                            <input type="submit" class="btn btn-primary mt-2" value="Sign In" />
                        </div>
                    </div>
                    <span class="mt-3 mb-3 line-thru text-center text-uppercase"><span>NOTE</span></span>
                    <p class="text-center">This page is strictly for guardtrol support</a></p>
                </form>
            </div>
        </div>
        <p class="text-center text-muted mt-3 mb-3">&copy; Copyright 2021. All Rights Reserved.</p>
    </div>
</section>

<script src='<?= public_path("vendor/jquery/jquery.js");?>'></script>
<script src='<?= public_path("vendor/jquery-browser-mobile/jquery.browser.mobile.js");?>'></script>
<script src='<?= public_path("vendor/popper/umd/popper.min.js");?>'></script>
<script src='<?= public_path("vendor/bootstrap/js/bootstrap.bundle.min.js");?>'></script>
<script src='<?= public_path("vendor/bootstrap-datepicker/js/bootstrap-datepicker.js");?>'></script>
<script src='<?= public_path("vendor/common/common.js");?>'></script>
<script src='<?= public_path("vendor/nanoscroller/nanoscroller.js");?>'></script>
<script src='<?= public_path("vendor/magnific-popup/jquery.magnific-popup.js");?>'></script>
<script src='<?= public_path("vendor/jquery-placeholder/jquery.placeholder.js");?>'></script>
<script src='<?= public_path("vendor/jquery-validation/jquery.validate.js");?>'></script>
<script src='<?= public_path("vendor/pnotify/pnotify.custom.js");?>'></script>
<!-- Specific Page Vendor -->
<script src='<?= public_path("js/theme.js");?>'></script>
<script src='<?= public_path("js/custom.js");?>'></script>
<script src='<?= public_path("js/theme.init.js");?>'></script>
<script src='<?= public_path("js/theme.init.js");?>'></script>
<script src='<?= public_path("js/views/view.supports.js");?>'></script>
</body>
</html>