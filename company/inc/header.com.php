<?php ob_start(); session_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . "/../../controllers/classes/Company.class.php");
include_once($filepath . "/../../controllers/classes/Client.class.php");
include_once($filepath . "/../../controllers/classes/Beat.class.php");
include_once($filepath . "/../../controllers/classes/Guard.class.php");
include_once($filepath . "/../../controllers/classes/Staff.class.php");
include_once($filepath . "/../../controllers/classes/DeployGuard.class.php");
include_once($filepath . "/../../controllers/classes/Privileges.class.php");
include_once($filepath . "/../../company/inc/helpers.php");
date_default_timezone_set('Africa/Lagos'); // WAT
$c = get_company();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
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
    <base href="https://imonitor.guardtrol.com/company/">
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
            <a href="./" class="logo"><img src="<?= public_path("img/logo.png"); ?>"  height="35" alt="Guardtrol Logo" /></a>
            <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>
        <div class="header-right">
            <ul class="notifications">
                <li>
                    <a href="javascript:void" class="dropdown-toggle notification-icon" data-bs-toggle="dropdown">
                        <i class="bx bx-bell"></i>
                        <?php if ($company->count_unread_notifications($c['company_id']) > 0){?>
                        <span class="badge">
                            <?=$company->count_unread_notifications($c['company_id']);?>
                        </span>
                        <?php } ?>
                    </a>
                    <div class="dropdown-menu notification-menu">
                        <div class="notification-title">
                            <?php if ($company->count_unread_notifications($c['company_id']) > 0){?>
                            <span class="float-end badge badge-default">
                                <?=$company->count_unread_notifications($c['company_id']);?>
                            </span>
                            <?php } ?>
                            Notifications
                        </div>
                        <div class="content">
                            <ul>
                                <?php
                                $not = $company->get_notifications($c['company_id'],4);
                                if ($not->num_rows > 0) {
                                while ($note = $not->fetch_assoc()) {
                                $note_arr = json_decode($note['note_data']);
                                ?>
                                <li>
                                    <a href="javascript:void" data-note_id="<?=$note['note_id'];?>" data-note_url="<?=$note_arr->actionURL;?>"
                                       data-comp_id="<?=$note['company_id'];?>" id="notificationStatusBtn" class="clearfix">
                                        <div class="image"><i class="fas fa-comment-alt bg-success text-light"></i></div>
                                        <span class="title"><?=substr($note_arr->body,0,23)."..";?></span>
                                        <span class="message"><?=$company->time_elapsed_string($note['note_created_at']);?></span>
                                    </a>
                                </li>
                                <?php } } else { echo "<li><span class='message'>No Notifications</span></li>"; }?>
                            </ul>
                            <hr>
                            <div class="text-end">
                                <a href="<?= url_path('/company/all-notifications',true,true)?>" class="view-more">View All</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <span class="separator"></span>
            <div id="userbox" class="userbox">
                <a href="javascript:void(0)" data-bs-toggle="dropdown">
                    <figure class="profile-picture">
                        <img src="<?= public_path('uploads/company/').$c['company_logo'];  ?>" alt="" class="rounded-circle" data-lock-picture="<?= public_path('uploads/company/').$c['company_logo'];  ?>" />
                    </figure>
                    <div class="profile-info" data-lock-name="John Doe" data-lock-email="test@test.com">
                        <span class="name"><?=$_SESSION['COMPANY_LOGIN']['company_name'];?> (Owner)</span>
                        <span class="role"><?=$_SESSION['COMPANY_LOGIN']['company_email'];?></span>
                    </div>
                    <i class="fa custom-caret"></i>
                </a>
                <div class="dropdown-menu">
                    <ul class="list-unstyled mb-2">
                        <li class="divider"></li>
                        <li><a role="menuitem" tabindex="-1" href="<?= url_path('/company/settings',true,true)?>"><i class="bx bx-user-circle"></i> My Profile</a></li>
                        <li><a role="menuitem" tabindex="-1" href="<?= url_path('/company/logout',true,true)?>"><i class="bx bx-power-off"></i> Logout</a></li>
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
                                <a class="nav-link" href="<?= url_path('/company/main',true,true)?>">
                                    <i class="bx bx-home-alt" aria-hidden="true"></i><span>Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-parent">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-key" aria-hidden="true"></i><span>Client Management</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li><a class="nav-link" href="<?= url_path('/company/create-client',true,true)?>">Add New Client</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/list-clients',true,true)?>">List Clients</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/list-beats',true,true)?>">List Beats</a></li>
                                </ul>
                            </li>
                            <li class="nav-parent
                            <?php if (basename($_SERVER['PHP_SELF']) == 'create-staff.php' || basename($_SERVER['PHP_SELF']) == 'list-staffs.php'
                                        || basename($_SERVER['PHP_SELF']) == 'edit-staff.php') echo "nav-active";?>">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-user-detail" aria-hidden="true"></i><span>Human Resource</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li><a class="nav-link" href="<?= url_path('/company/add-staff',true,true)?>">Add New Staff</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/list-staffs',true,true)?>">List Staffs</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/create-guard',true,true)?>">Add New Guard</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/list-guards',true,true)?>">List Guards</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/list-norminal-rolls',true,true)?>">Norminal rolls </a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/staff-offenses',true,true)?>">Staff Offense</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/staff-pardon-history',true,true)?>">Staff Pardon History</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/guard-payroll-data-history',true,true)?>">Guards Payroll Data History</a></li>
                                </ul>
                            </li>
                            <li class="nav-parent"
                                <?php if (basename($_SERVER['PHP_SELF']) == 'report-incident.php' || basename($_SERVER['PHP_SELF']) == 'list-incident.php'
                                    || basename($_SERVER['PHP_SELF']) == 'incident.php') echo "nav-active";?>>
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-extension" aria-hidden="true"></i><span>Operations</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li><a class="nav-link" href="<?= url_path('/company/incident',true,true)?>">Report Incident</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/all-incident',true,true)?>">All Incident</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/deploy-guard',true,true)?>">Deploy Guard</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/guard-offenses',true,true)?>">Guard Offense</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/guard-pardon-history',true,true)?>">Guard Pardon History</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/guard-route-task',true,true)?>">Route Task</a></li>
                                </ul>
                            </li>
                            <li class="nav-parent">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-book-bookmark" aria-hidden="true"></i><span>Accounts</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li><a class="nav-link" href="<?= url_path('/company/generate-invoice',true,true)?>">Generate Invoice</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/invoice-history',true,true)?>">Invoice History</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/payment-report',true,true)?>">Payment Report</a></li>
                                    <li class="nav-parent">
                                        <a class="nav-link" href="javascript:void"><span>Generate Payroll</span></a>
                                        <ul class="nav nav-children">
                                            <li><a href="<?= url_path('/company/create-staff-payroll',true,true)?>">For Staffs</a></li>
                                            <li><a href="<?= url_path('/company/create-guard-payroll',true,true)?>">For Guards</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-parent">
                                        <a class="nav-link" href="javascript:void"><span>Payroll History</span></a>
                                        <ul class="nav nav-children">
                                            <li><a href="<?= url_path('/company/staff-payroll-history',true,true)?>">For Staffs</a></li>
                                            <li><a href="<?= url_path('/company/guard-payroll-history',true,true)?>">For Guards</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-parent">
                                        <a class="nav-link" href="javascript:void"><span>Kits Inventory</span></a>
                                        <ul class="nav nav-children">
                                            <li><a href="<?= url_path('/company/kit-inventory',true,true)?>">List</a></li>
                                            <li><a href="<?= url_path('/company/kit-history',true,true)?>">History</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="nav-link" href="<?= url_path('/company/staff-loan',true,true)?>">Loan Report</a></li>
                                </ul>
                            </li>
                            <li class="nav-parent">
                                <a class="nav-link" href="javascript:void">
                                    <i class="bx bxs-bar-chart-square" aria-hidden="true"></i><span>Reports</span>
                                </a>
                                <ul class="nav nav-children">
                                    <li><a class="nav-link" href="<?= url_path('/company/beat-guard-payroll-history',true,true)?>">Beat Payroll History</a></li>
                                    <li class="nav-parent">
                                        <a class="nav-link" href="javascript:void"><span>Guard Report</span></a>
                                        <ul class="nav nav-children">
                                            <li><a href="<?= url_path('/company/list-guard-sa-report',true,true)?>">I.O.U (Salary Advance)</a></li>
                                            <li><a href="<?= url_path('/company/generate-guard-loan-report',true,true)?>">Loan</a></li>
                                            <li><a href="<?= url_path('/company/generate-stopped-guard-report',true,true)?>">Stopped/Awol</a></li>
                                            <li><a href="<?= url_path('/company/generate-guard-penalties-report',true,true)?>">Bookings (Penalties)</a></li>
                                            <li><a href="<?= url_path('/company/generate-guard-training-abs-report',true,true)?>">Training Absentee</a></li>
                                            <li><a href="<?= url_path('/company/generate-guard-extra-duty-report',true,true)?>">Extra Duties</a></li>
                                            <li><a href="<?= url_path('/company/generate-uniform-deduction-report',true,true)?>">Uniform Deduction</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-parent">
                                        <a class="nav-link" href="javascript:void"><span>Staff Report</span></a>
                                        <ul class="nav nav-children">
                                            <li><a href="<?= url_path('/company/generate-staff-penalties-report',true,true)?>">Bookings (Penalties)</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="nav-link" href="<?= url_path('/company/generate-payment-confirm-report',true,true)?>">Payment Confirmation Report</a></li>
                                    <li><a class="nav-link" href="<?= url_path('/company/generate-posted-guard-report',true,true)?>">Newly Posted Guard Report</a></li>
                                    
                                    <li class="nav-parent">
                                        <a class="nav-link" href="javascript:void"><span>Attendance Report</span></a>
                                        <ul class="nav nav-children">
                                            <li><a href="<?= url_path('/company/generate-guard-clock-in-out-report',true,true)?>">Clock In</a></li>
                                            <li><a href="<?= url_path('/company/generate-guards-absentee-report',true,true)?>">Absentee Guards</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <hr class="separator" />
                    <div class="sidebar-widget widget-tasks">
                        <div class="widget-header">
                            <h6>Manage Roles</h6>
                            <div class="widget-toggle">+</div>
                        </div>
                        <div class="widget-content">
                            <ul class="list-unstyled m-0">
                                 <li><a href="<?= url_path('/company/manage-beat-supervisor',true,true)?>">Beat Supervisor</a></li>
                                 <li><a href="<?= url_path('/company/manage-client-profile',true,true)?>">Client Login Profile</a></li>
                            </ul>
                        </div>
                    </div>
                    <hr class="separator" />

                    <div class="sidebar-widget widget-tasks">
                        <div class="widget-header">
                            <h6>Settings</h6>
                            <div class="widget-toggle">+</div>
                        </div>
                        <div class="widget-content">
                            <ul class="list-unstyled m-0">
                                <li><a href="<?= url_path('/company/configuration',true,true)?>">Configuration Settings</a></li>
                                <li><a href="<?= url_path('/company/invoice-account',true,true)?>">Configure Invoice Account</a></li>
                            </ul>
                        </div>
                    </div>
                    <hr class="separator" />
                </div>
            </div>
        </aside>
        <!-- end: sidebar -->