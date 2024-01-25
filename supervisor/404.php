<?php include_once("inc/header.super.php"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>404</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Pages</span></li>
                <li><span>404</span></li>
            </ol>
            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
        </div>
    </header>
    <section class="body-error error-inside">
        <div class="center-error">
            <div class="row">
                <div class="col-lg-8">
                    <div class="main-error mb-3">
                        <h2 class="error-code text-dark text-center font-weight-semibold m-0">404 <i class="fas fa-file"></i></h2>
                        <p class="error-explanation text-center">We're sorry, but the page you were looking for doesn't exist.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h4 class="text">Here are some useful links</h4>
                    <ul class="nav nav-list flex-column primary">
                        <li class="nav-item"><a class="nav-link" href="<?= url_path('/supervisor/main',true,true)?>"><i class="fas fa-caret-right text-dark"></i> Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</section>
<?php include_once("inc/footer.super.php"); ?>