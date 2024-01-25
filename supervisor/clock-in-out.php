<?php include_once("inc/header.super.php"); ?>
<?php if (!isset($_SESSION['SUPERVISOR_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Generate Guard Clock In/Out Report</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/supervisor/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Generate Guard Clock In/Out Report</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xl-4 mx-auto">
                    <section class="card card-featured-left card-featured-info mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-info">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">TOTAL CLOCK-IN TODAY</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $supervisor->count_supervisor_total_clock_in_today($comp_id,$bsu_beats); ?></strong>
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
            </div>
        </div>

        <div class="col-md-12 pt-4">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <h2 class="card-title">Generate Guard Clock In/Out Report</h2>
                </header>
                <div class="card-body">
                    <form action="Y2xvY2staW4tb3V0LWZpbHRlcg==" method="post" class="row">
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
                                $res = $company->get_all_company_beats($comp_id);
                                if ($res->num_rows > 0) {
                                    while ($row = $res->fetch_assoc()) {
                                        $arrBsu = explode(",", $bsu_beats);
                                        if (in_array($row['beat_id'],$arrBsu)){
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
                                        <?php } } } else { echo "<tr><td colspan='12' class='text-center'>No Beat Found</td></tr>";} ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-5 col-12">
                            <div class="form-group row mb-3">
                                <div class="col-sm-12 form-group">
                                    <label class="control-label text-lg-end pb-2">Date Filter</label>
                                    <div class="input-daterange input-group" data-plugin-datepicker="">
                                        <span class="input-group-text">From</span>
                                        <input type="text" class="form-control" name="start">
                                        <span class="input-group-text border-start-0 border-end-0 rounded-0">To</span>
                                        <input type="text" class="form-control" name="end">
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
</section>
<?php include_once("inc/footer.super.php"); ?>
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