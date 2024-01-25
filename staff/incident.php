<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>

<?php
if (!isset($incident_id) || $incident_id == NULL ) {echo "<script>window.location = '".url_path('/staff/incident',true, true)."'; </script>";}
?>
<?php
$res = $company->get_company_incident_by_id($incident_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <section role="main" class="content-body">
            <header class="page-header">
                <h2><a href="<?= url_path('/staff/all-incident',true, true);?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Incident Details</h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li><a href="<?= url_path('/staff/main',true, true);?>"><i class="bx bx-home-alt"></i></a></li>
                        <li><span>Incident report details</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <section class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-xl-3 mb-4 mb-xl-0">
                                <section class="card">
                                    <header class="card-header">
                                        <div class="card-actions">
                                            <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                                        </div>
                                        <h4 class="card-title">Menu</h4>
                                    </header>
                                    <div class="card-body">
                                        <div><a class="" href="<?= url_path('/staff/all-incident',true, true);?>"><i class="fas fa-list-alt">&nbsp;</i>All Incidents</a></div>
                                    </div>
                                </section>
                                <section class="card">
                                    <header class="card-header">
                                        <div class="card-actions">
                                            <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                                        </div>
                                        <h4 class="card-title">Useful Links</h4>
                                    </header>
                                    <div class="card-body">
                                        <div class="mb-2"><a href="<?= url_path('/staff/main',true, true);?>"><i class="fas fa-home">&nbsp;</i>Dashboard</a></div>
                                        <div class="mb-2"><a href="<?= url_path('/staff/list-staffs',true, true);?>"><i class="fas fa-user-friends">&nbsp;</i>Clients</a></div>
                                        <div class="mb-2"><a href="<?= url_path('/staff/list-staffs',true, true);?>"><i class="fas fa-user-check">&nbsp;</i>Staffs</a></div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-lg-8 col-xl-9">
                                <section class="card card-featured card-featured-primary mb-4">
                                    <div class="card-body">
                                        <hr class="dotted short">
                                        <div>
                                            <div><h4><?=$row['report_title'];?></h4></div>
                                            <div style="display: flex; justify-content: space-between">
                                                <p class="small m-0">From: <?= $row['staff_firstname'].' '.$row['staff_lastname'];?></p>
                                                <p class="small m-0">Occurrence Date: <?= date("d/m/Y H:i", strtotime($row['report_occ_date']));?></p>
                                            </div>
                                            <div style="display: flex; justify-content: space-between">
                                                <p class="small m-0">Submitted On: <?= date("d/m/Y H:i", strtotime($row['report_created_on']));?></p>
                                                <p class="small m-0">Beat: <?= $row['report_beat'];?></p>
                                            </div>
                                        </div>
                                        <hr class="dotted short">
                                        <div>
                                            <div><h5>Description</h5></div>
                                            <div><p><?=$row['report_describe'];?></p></div>
                                        </div>
                                    </div>
                                </section>
                                <section class="card card-featured card-featured-dark mb-4">
                                    <div class="card-body">
                                        <div><h5>Photo(s) From Incident</h5></div>
                                        <hr class="dotted short">
                                        <div class="card-body">
                                            <div class="popup-gallery row">
                                                <?php if ($row['report_photo_1'] != 'null' && $row['report_photo_1'] !=''){?>
                                                <a class="col-xs-2 col-auto mb-1 me-1" href="<?=public_path('uploads/reports/'.$row['report_photo_1']);?>"
                                                   title="<?= $row['report_title'].' '.$row['report_photo_1']; ?>">
                                                    <div class="img-fluid">
                                                        <img src="<?=public_path('uploads/reports/'.$row['report_photo_1']);?>" width="105">
                                                    </div>
                                                </a>
                                                <?php } ?>
                                                <?php if ($row['report_photo_2'] != 'null' && $row['report_photo_2'] !=''){?>
                                                <a class="col-xs-2 col-auto mb-1 me-1" href="<?=public_path('uploads/reports/'.$row['report_photo_2']);?>"
                                                   title="<?= $row['report_title'].' '.$row['report_photo_2']; ?>">
                                                    <div class="img-fluid">
                                                        <img src="<?=public_path('uploads/reports/'.$row['report_photo_2']);?>" width="105">
                                                    </div>
                                                </a>
                                                <?php } ?>
                                                <?php if ($row['report_photo_3'] != 'null' && $row['report_photo_3'] !=''){?>
                                                <a class="col-xs-2 col-auto mb-1 me-1" href="<?=public_path('uploads/reports/'.$row['report_photo_3']);?>"
                                                   title="<?= $row['report_title'].' '.$row['report_photo_3']; ?>">
                                                    <div class="img-fluid">
                                                        <img src="<?=public_path('uploads/reports/'.$row['report_photo_3']);?>" width="105">
                                                    </div>
                                                </a>
                                                <?php } ?>
                                                <?php if ($row['report_photo_4'] != 'null' && $row['report_photo_4'] !=''){?>
                                                <a class="col-xs-2 col-auto mb-1 me-1" href="<?=public_path('uploads/reports/'.$row['report_photo_4']);?>"
                                                   title="<?= $row['report_title'].' '.$row['report_photo_4']; ?>">
                                                    <div class="img-fluid">
                                                        <img src="<?=public_path('uploads/reports/'.$row['report_photo_4']);?>" width="105">
                                                    </div>
                                                </a>
                                                <?php } ?>
                                                <?php if ($row['report_photo_5'] != 'null' && $row['report_photo_5'] !=''){?>
                                                <a class="col-xs-2 col-auto mb-1 me-1" href="<?=public_path('uploads/reports/'.$row['report_photo_5']);?>"
                                                   title="<?= $row['report_title'].' '.$row['report_photo_5']; ?>">
                                                    <div class="img-fluid">
                                                        <img src="<?=public_path('uploads/reports/'.$row['report_photo_5']);?>" width="105">
                                                    </div>
                                                </a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <hr class="dotted short">
                                    </div>
                                </section>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.staff.php"); ?>
<script>
    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
        }
    });
</script>
