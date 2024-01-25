<?php ob_start(); session_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . "/../../controllers/classes/Company.class.php");
include_once($filepath . "/../../controllers/classes/Client.class.php");
include_once($filepath . "/../../controllers/classes/Beat.class.php");
date_default_timezone_set('Africa/Lagos'); // WAT

$comp_id = isset($_SESSION['CLIENT_LOGIN']['cli_company_id'])?$_SESSION['CLIENT_LOGIN']['cli_company_id']:"";
$cli_id = isset($_SESSION['CLIENT_LOGIN']['cli_id'])?$_SESSION['CLIENT_LOGIN']['cli_id']:"";
$cli_obj = $client->get_client_beats_by_id($cli_id);
$cli = "";
if ($cli_obj->num_rows > 0) { while ($row = $cli_obj->fetch_assoc()) {
    $cli .= $row['beat_id'].",";
} }
$cli_beats = rtrim($cli, ",");
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
    <base href="https://imonitor.guardtrol.com/client/">
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
    <style>
        a.no_style {
            text-decoration: none;
            background-color: transparent;
        }
        .card-title {
            font-size: 25px !important;
            line-height: 33px !important;
        }
    </style>
</head>
<body>
<section class="body">

    <!-- end: header -->
    <div class="inner-wrapper" style="padding-top: 70px;">
