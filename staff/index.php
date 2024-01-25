<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Staff Dashboard: <?=$_SESSION['STAFF_LOGIN']['staff_name'];?></h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></a></li>
                <li><span> Staff Dashboard</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row pt-4">
        <div class="col-lg-12 mb-4 mb-lg-0">
            <div class="row">
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-primary mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-primary">
                                        <i class="fas fa-globe-africa"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Client</h4>
                                        <div class="info">
                                            <strong class="amount"><?=$company->count_total_client($c['company_id'])?></strong>
                                            <span class="text-primary">(<?=$company->count_total_disabled_client($c['company_id'])?> In-active)</span>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-secondary">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-secondary">
                                        <i class="fas fa-user-lock"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Guard</h4>
                                        <strong class="amount"><?=$company->count_total_guard($c['company_id'])?></strong>
                                        <span class="text-primary">(<?=$company->count_total_disabled_guard($c['company_id'])?> In-active)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-tertiary mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-tertiary">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Beat</h4>
                                        <div class="info">
                                            <strong class="amount"><?=$company->count_total_beat($c['company_id'])?></strong>
                                            <span class="text-primary">(<?=$company->count_total_disabled_beat($c['company_id'])?> In-active)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-quaternary">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-quaternary">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Staff</h4>
                                        <div class="info">
                                            <strong class="amount"><?=$company->count_total_staff($c['company_id'])?></strong>
                                            <span class="text-primary">(<?=$company->count_total_disabled_staff($c['company_id'])?> In-active)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once("inc/footer.staff.php"); ?>