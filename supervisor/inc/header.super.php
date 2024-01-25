<?php ob_start(); session_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . "/../../controllers/classes/Company.class.php");
include_once($filepath . "/../../controllers/classes/Supervisor.class.php");
include_once($filepath . "/../../controllers/classes/Beat.class.php");
include_once($filepath . "/../../controllers/classes/Guard.class.php");
date_default_timezone_set('Africa/Lagos'); // WAT

$comp_id = isset($_SESSION['SUPERVISOR_LOGIN']['bsu_company_id'])?$_SESSION['SUPERVISOR_LOGIN']['bsu_company_id']:"";
$bsu_id = isset($_SESSION['SUPERVISOR_LOGIN']['bsu_id'])?$_SESSION['SUPERVISOR_LOGIN']['bsu_id']:"";
$bsu_obj = $supervisor->get_supervisor_by_id($bsu_id);
$bsu_arr = $bsu_obj->fetch_assoc();
$bsu_beats = $bsu_arr['bsu_beats'];
?>
<!doctype html>
<html class="fixed">
<head>
    <meta charset="UTF-8">
    <title>Guardtrol Supervisor - Security Guard System</title>
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Guardtrol - Security Guard System">
    <meta name="author" content="Guardtrol">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <base href="https://imonitor.guardtrol.com/supervisor/">
    <link rel="shortcut icon" href="<?= public_path("img/favicon.png"); ?>" type='image/x-icon' />
    <link rel="apple-touch-icon" href="<?= public_path("img/apple-touch-icon.png"); ?>">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href='<?= public_path("vendor/bootstrap/css/bootstrap.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/animate/animate.compat.css"); ?>'>
    <link rel="stylesheet" href='<?= public_path("vendor/font-awesome/css/all.min.css"); ?>' />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href='<?= public_path("vendor/boxicons/css/boxicons.min.css"); ?>' />
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href='<?= public_path("vendor/magnific-popup/magnific-popup.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/select2/css/select2.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/select2-bootstrap-theme/select2-bootstrap.min.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/bootstrap-timepicker/css/bootstrap-timepicker.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/bootstrap-fileupload/bootstrap-fileupload.min.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/morris/morris.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/pnotify/pnotify.custom.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("vendor/jquery-confirm/jquery-confirm.min.css"); ?>'>
    <link rel="stylesheet" href='<?= public_path("vendor/datatables/media/css/dataTables.bootstrap5.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("css/theme.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("css/skins/default.css"); ?>' />
    <link rel="stylesheet" href='<?= public_path("css/custom.css"); ?>'>
    <script src='<?= public_path("vendor/modernizr/modernizr.js"); ?>'></script>
</head>
<body>
<section class="body">
    <header class="header">
        <div class="logo-container">
            <a href="<?=url_path('/supervisor/main',true,true);?>" class="logo"><img src="../public/img/logo.png" width="" height="35" alt="Guardtrol Logo" /></a>
            <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>
        <div class="header-right">
            <span class="separator"></span>
            <div id="userbox" class="userbox">
                <a href="javascript:void(0)" data-bs-toggle="dropdown">
                    <figure class="profile-picture">
                        <img src="../public/img/!logged-user.jpg" alt="Joseph Doe" class="rounded-circle" data-lock-picture="img/!logged-user.jpg" />
                    </figure>
                    <div class="profile-info" data-lock-name="<?=$_SESSION['SUPERVISOR_LOGIN']['bsu_firstname'];?> <?=$_SESSION['SUPERVISOR_LOGIN']['bsu_lastname'];?>"
                         data-lock-email="<?=$_SESSION['SUPERVISOR_LOGIN']['bsu_email'];?>">
                        <span class="name"><?=$_SESSION['SUPERVISOR_LOGIN']['bsu_firstname'];?> <?=$_SESSION['SUPERVISOR_LOGIN']['bsu_lastname'];?></span>
                        <span class="role">Supervisor</span>
                    </div>
                    <i class="fa custom-caret"></i>
                </a>
                <div class="dropdown-menu">
                    <ul class="list-unstyled mb-2">
                        <li class="divider"></li>
                        <li><a role="menuitem" tabindex="-1" href="<?=url_path('/supervisor/settings',true,true);?>"><i class="bx bx-user-circle"></i> My Profile</a></li>
                        <li class="divider"></li>
                        <li><a role="menuitem" tabindex="-1" href="<?=url_path('/supervisor/attendance-logs',true,true);?>"><i class="bx bx-line-chart"></i> Attendance Logs</a></li>
                        <li class="divider"></li>
                        <li><a role="menuitem" tabindex="-1" href="<?=url_path('/supervisor/logout',true,true);?>"><i class="bx bx-power-off"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- end: header -->
    <div class="inner-wrapper">
        <!-- start: sidebar -->
        <aside id="sidebar-left" class="sidebar-left">
            <div class="sidebar-header">
                <div class="sidebar-title">Navigation</div>
                <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                    <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
                </div>
            </div>
            <div class="nano">
                <div class="nano-content">
                    <nav id="menu" class="nav-main" role="navigation">
                        <ul class="nav nav-main">
                            <li>
                                <a class="nav-link" href="<?=url_path('/supervisor/main',true,true);?>">
                                    <i class="bx bx-home-alt" aria-hidden="true"></i><span>Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-parent nav-expanded">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-compass" aria-hidden="true"></i><span>Actions</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li><a class="nav-link" href="<?=url_path('/supervisor/clock-in-out',true,true);?>">Guard Clock In/Out</a></li>
                                    <li><a class="nav-link" href="<?=url_path('/supervisor/routing-clock',true,true);?>">Guard Routes</a></li>
                                </ul>
                            </li>
                            <li class="nav-parent nav-expanded">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bx-git-pull-request" aria-hidden="true"></i><span>Request</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li><a class="nav-link" href="<?=url_path('/supervisor/guard-clock-out-request',true,true);?>">Guard ClockOut Request</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </aside>
        <!-- end: sidebar -->
