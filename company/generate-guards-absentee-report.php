<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Guards Absentee Report</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Generate Guards Absentee Report</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
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
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="<?= url_path('/company/list-guardss',true,true)?>">(view guards)</a>
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
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">TOTAL CLOCK-IN TODAY</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $company->count_total_clock_in_today($c['company_id']); ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-dark" href="javascript:void(0)">Today's Date: <b><?=date("d/M/Y");?></b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-primary mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-primary">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">TOTAL CLOCK-IN THIS MONTH</h4>
                                        <div class="info">
                                            <strong class="amount"><?=$company->count_total_clock_in_this_month($c['company_id'])?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-dark" href="javascript:void(0)">Month: <b><?=date("F, Y");?></b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row pt-4">
                <div class="col-lg-12">
                    <section class="card card-featured card-featured-primary mb-4">
                        <header class="card-header">
                            <h2 class="card-title">Guards Absentee Report</h2>
                        </header>
                        <div class="card-body">
                            <form action="Z2VuZXJhdGUtZ3VhcmRzLWFic2VudGVlLXJlcG9ydC1maWx0ZXI=" method="post" class="row">
                                <div class="col-md-7 col-12">
                                    <table class="table table-bordered table-hover mb-0" id="datatable-company">
                                        <thead class="bg-de">
                                        <tr>
                                            <th>Select Beat</th>
                                            <th>
                                                <div class="checkbox-custom checkbox-default pull-right text-primary">
                                                    <input type="checkbox" id="selAllCheck" onClick="check_uncheck_grd(this.checked);">
                                                    <label for="selAllCheck">Select All</label>
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $res = $company->get_all_company_beats($c['company_id']);
                                        if ($res->num_rows > 0) {$n=0;
                                            while ($row = $res->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td class="text-primary">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <?= $row['beat_name']." (".$row['client_fullname'].")";?>
                                                    </td>
                                                    <td>
                                                        <div class="checkbox-custom checkbox-default pull-right">
                                                            <input type="checkbox" class="beat_check" id="beat_check_<?= $row['beat_id']?>" name="beat_check[]" value="<?= $row['beat_id']?>">
                                                            <label for="beat_check_<?= $row['beat_id']?>"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Beat Found</td></tr>";} ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-5 col-12">
                                    <div class="form-group row mb-3">
                                        <div class="col-sm-12 form-group">
                                            <label class="control-label text-lg-end pt-5 pb-2">Date Filter</label>
                                            <div class="input-daterange input-group" data-plugin-datepicker="">
<!--                                                <span class="input-group-text">From</span>-->
                                                <input type="text" class="form-control" name="start">
<!--                                                <span class="input-group-text border-start-0 border-end-0 rounded-0">To</span>-->
<!--                                                <input type="text" class="form-control" name="end">-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input type="submit" class="btn btn-primary col-12" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once("inc/footer.com.php"); ?>
<script>
    function check_uncheck_grd(isChecked) {
        if (isChecked){
            $('input[name="beat_check[]"]').each(function(){
                this.checked = true;
                $("label[for='selAllCheck']").html("Unselect All")
            });
        } else {
            $('input[name="beat_check[]"]').each(function(){
                this.checked = false;
                $("label[for='selAllCheck']").html("Select All");
            });
        }
    }
</script>
