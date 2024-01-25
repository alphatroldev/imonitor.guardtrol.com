<?php ob_start(); session_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . "/../../controllers/classes/Company.class.php");
include_once($filepath . "/../../controllers/classes/Staff.class.php");
include_once($filepath . "/../../controllers/classes/Client.class.php");
include_once($filepath . "/../../controllers/classes/Beat.class.php");
include_once($filepath . "/../../controllers/classes/Guard.class.php");
include_once($filepath . "/../../controllers/classes/DeployGuard.class.php");
include_once($filepath . "/../../controllers/classes/Privileges.class.php");
include_once($filepath . "/../../staff/inc/helpers.php");
include_once("restrictions.staff.php");
date_default_timezone_set('Africa/Lagos'); // WAT

if(isset($_SESSION['COMPANY_LOGIN'])){
    $c = get_company();
} else {
    $c = get_staff();
}

// print_r($c);
?>
<!doctype html>
<html class="fixed">
<head>
    <meta charset="UTF-8">
    <title>Guardtrol - Security Guard System</title>
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Guardtrol - Security Guard System">
    <meta name="author" content="Guardtrol">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="shortcut icon" href="<?= public_path("img/favicon.png"); ?>" type='image/x-icon' />
    <link rel="apple-touch-icon" href="<?= public_path("img/apple-touch-icon.png"); ?>">
    <base href="https://imonitor.guardtrol.com/staff/">
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
            <a href="./" class="logo"><img src="<?= public_path("img/logo.png"); ?>" height="35" alt="Guardtrol Logo" /></a>
            <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>
        <div class="header-right">
            <span class="separator"></span>
            <div id="userbox" class="userbox">
                <a href="javascript:void(0)" data-bs-toggle="dropdown">
                    <figure class="profile-picture">
                        <img src="<?= public_path("img/!logged-user.jpg"); ?>" alt="<?=$_SESSION['STAFF_LOGIN']['staff_name'];?>" class="rounded-circle" data-lock-picture="<?= public_path("img/!logged-user.jpg"); ?>" />
                    </figure>
                    <div class="profile-info" data-lock-name="<?=$_SESSION['STAFF_LOGIN']['staff_name'];?>" data-lock-email="<?=$_SESSION['STAFF_LOGIN']['staff_email'];?>">
                        <span class="name"><?=$_SESSION['STAFF_LOGIN']['staff_firstname'].' '.$_SESSION['STAFF_LOGIN']['staff_middlename'];?> (Staff)</span>
                        <span class="role"><?=$_SESSION['STAFF_LOGIN']['staff_email'];?></span>
                    </div>
                    <i class="fa custom-caret"></i>
                </a>
                <div class="dropdown-menu">
                    <ul class="list-unstyled mb-2">
                        <li class="divider"></li>
                        <li><a role="menuitem" tabindex="-1" href="<?= url_path('/staff/profile-settings',true,true)?>"><i class="bx bx-user-circle"></i> My Profile</a></li>
                        <li><a role="menuitem" tabindex="-1" href="<?= url_path('/staff/logout',true,true)?>"><i class="bx bx-power-off"></i> Logout</a></li>
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
                           <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'index.php') echo "nav-active";?>">
                                <a class="nav-link" href="<?= url_path('/staff/main',true,true)?>">
                                    <i class="bx bx-home-alt" aria-hidden="true"></i><span>Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-parent">
                                <a class="nav-link" href="#">
                                    <i class="bx bxs-key" aria-hidden="true"></i><span>Client Management</span>
                                </a>
                                <ul class="nav nav-children">
                                     <?= $add_new_client_nav;?>
                                     <?= $list_clients_nav;?>
                                     <?= $list_beats_nav;?>
                                </ul>
                            </li>
                            <li class="nav-parent
                              <?php if (basename($_SERVER['PHP_SELF']) == 'create-staff.php' || basename($_SERVER['PHP_SELF']) == 'list-staffs.php'
                                        || basename($_SERVER['PHP_SELF']) == 'edit-staff.php') echo "nav-active";?>">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-user-detail" aria-hidden="true"></i><span>Human Resource</span>
                                </a>
                                <ul class="nav nav-children">
                                    <?= $add_new_staff_nav;?>
                                    <?= $list_staff_nav;?>
                                    <?= $add_new_guard_nav;?>
                                    <?= $list_guards_nav;?>
                                    <?= $norminal_row_nav;?>
                                    <?= $staff_off_nav;?>
                                    <?= $guard_payroll_data_history_nav;?>
                                </ul>
                            </li>
                            <li class="nav-parent"
                                <?php if (basename($_SERVER['PHP_SELF']) == 'report-incident.php' || basename($_SERVER['PHP_SELF']) == 'list-incident.php'
                                    || basename($_SERVER['PHP_SELF']) == 'incident.php') echo "nav-active";?>>
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-extension" aria-hidden="true"></i><span>Operations</span>
                                </a>
                                <ul class="nav nav-children">
                                    <?= $create_incident_rep_nav;?>
                                    <?= $incident_rep_nav;?>
                                    <?= $deploy_guard_nav;?>
                                    <?= $guard_off_nav;?>
                                </ul>
                            </li>
                            <li class="nav-parent">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-book-bookmark" aria-hidden="true"></i><span>Accounts</span>
                                </a>
                                <ul class="nav nav-children">
                                    <?= $generate_inv_nav;?>
                                    <?= $inv_history_nav;?>
                                    <?= $pay_report_nav;?>
                                    <li class="nav-parent">
                                        <a class="nav-link" href="javascript:void"><span>Generate Payroll</span></a>
                                        <ul class="nav nav-children">
                                            <?= $gen_payroll_nav;?>
                                        </ul>
                                    </li>
                                    <li class="nav-parent">
                                        <a class="nav-link" href="javascript:void"><span>Payroll History</span></a>
                                        <ul class="nav nav-children">
                                            <?= $payroll_his_nav;?>
                                        </ul>
                                    </li>
                                    <li class="nav-parent">
                                        <a class="nav-link" href="javascript:void"><span>Kits Inventory</span></a>
                                        <ul class="nav nav-children">
                                            <?= $kit_inventory_nav;?>
                                        </ul>
                                    </li>
                                    <?= $loan_history_nav;?>
                                </ul>
                            </li>
                            <li class="nav-parent">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-bar-chart-square" aria-hidden="true"></i><span>Reports</span>
                                </a>
                                <ul class="nav nav-children">
                                    <?= $report_nav; ?>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <hr class="separator" />
                </div>
            </div>
        </aside>
        <!-- end: sidebar -->