<?php include_once("inc/header.sup.php"); ?>
<?php if (!isset($_SESSION['SUPPORT_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?=url_path('/support/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Dashboard</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row pt-4">
        <div class="col-lg-12 mb-4 mb-lg-0">
            <div class="row">
                <div class="col-xl-6">
                    <section class="card card-featured-left card-featured-success mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-success">
                                        <i class="bx bxs-user-account"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Company</h4>
                                        <div class="info">
                                            <strong class="amount"><?=$support->count_total_company()?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="<?= url_path('/support/list-company',true,true)?>">(All Companies)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-6">
                    <section class="card card-featured-left card-featured-danger">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-danger">
                                        <i class="bx bxs-user-account"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Inactive Company</h4>
                                        <strong class="amount"><?=$support->count_total_disabled_company()?></strong>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="<?= url_path('/support/list-company',true,true)?>">(All Companies)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
<!--                <div class="col-xl-6">-->
<!--                    <section class="card card-featured-left card-featured-info mb-3">-->
<!--                        <div class="card-body">-->
<!--                            <div class="widget-summary">-->
<!--                                <div class="widget-summary-col widget-summary-col-icon">-->
<!--                                    <div class="summary-icon bg-info">-->
<!--                                        <i class="bx bxs-coin-stack"></i>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="widget-summary-col">-->
<!--                                    <div class="summary">-->
<!--                                        <h3 class="title">Total Amount Paid</h3>-->
<!--                                        <div class="info">-->
<!--                                            <strong class="amount">--><?//= number_format(0,0)?><!--</strong>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </section>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</section>
<?php include_once("inc/footer.sup.php"); ?>