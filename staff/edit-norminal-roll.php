<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>

<?php
if (!isset($guard_id) ||$guard_id == NULL ) {echo "<script>window.location = '".url_path('/staff/norminal-rolls',true,true)."'; </script>";}

?>

<?php
$res = $deploy_guard->get_guard_deploy_by_guard_id($guard_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <?php
       
        ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Edit Guard Deployment</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="index"><i class="bx bx-home-alt"></i></a></li>
                    <li><span><a href="<?= url_path('/staff/list-norminal-rolls',true,true)?>">Norminal Rolls</a></span></li>
                    <li><span>Edit Guard Deployment</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
                <div class="col-lg-12">
                    <div class="tabs">
                        <ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link" data-bs-target="#sectionOne" href="#sectionOne" data-bs-toggle="tab">Edit Guard Deployment</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- section One -->
                            <div id="sectionOne" class="tab-pane active">
                                <form name="edit_guard_deployment" id="edit_guard_deployment">
                                    <div class="card-body">
                                        <div id="response-alert"></div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Guard</label>
                                                    <?php
                                                    $guard_info = $deploy_guard->get_guard_info($row['guard_id']);
                                                    $gd = $guard_info->fetch_assoc();
                                                    ?>

                                                    <input type="text" class="form-control"
                                                           value="<?=$gd['guard_firstname']." ".$gd['guard_middlename']." ".$gd['guard_lastname'] ;?>"
                                                           disabled />
                                                    <input type="hidden" name="id" value="<?=$row['gd_id'];?>" />
                                                    <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Beat <span class="required">*</span></label>
                                                    <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Select a Beat", "allowClear": true }' name="beat">

                                                        <?php
                                                        $beat_info = $deploy_guard->get_beat_info($row['beat_id']);
                                                        $beat = $beat_info->fetch_assoc();

                                                        $client_info = $deploy_guard->get_client_info($beat['client_id']);
                                                        $client = $client_info->fetch_assoc();

                                                        ?>

                                                        <option value="<?=$row['beat_id'];?>"><?= $client['client_fullname'];?>: <?=$beat['beat_name'] ;?></option>
                                                        <?php


                                                        $all_clients = $deploy_guard->get_all_company_clients($c['company_id']);
                                                        while ($row_client = $all_clients->fetch_assoc()) {
                                                            ?>
                                                            <optgroup label="<?= $row_client['client_fullname'];?>">
                                                                <?php
                                                                $beats = $deploy_guard->get_all_client_beats($row_client['client_id']);
                                                                while ($row_beat = $beats->fetch_assoc()) {
                                                                    ?>
                                                                    <option value="<?= $row_beat['beat_id'];?>"><?= $row_client['client_fullname'];?>: <strong><?= $row_beat['beat_name'];?></strong></option>
                                                                <?php }  ?>
                                                            </optgroup>
                                                        <?php }  ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label pt-1" for="w1-date-of-deploy">Date of Deployment<span class="required">*</span></label>
                                                    <input type="date" class="form-control" name="date_of_deploy" value="<?=$row['dop'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label pt-1" for="w1-observe-start">Date observation Starts<span class="required">*</span></label>
                                                    <input type="date" class="form-control" name="observe_start" value="<?=$row['observation_start'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label pt-1" for="w1-observe-end">Date observation Ends<span class="required">*</span></label>
                                                    <input type="date" class="form-control" name="observe_end" value="<?=$row['observation_end'];?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label pt-1" for="">Commencement Date<span class="required">*</span></label>
                                                    <input type="date" class="form-control" name="commence_date"  value="<?=$row['commencement_date'];?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label pt-1" for="">Paid on Observation?<span class="required">*</span></label>
                                                    <div class="col-sm-8">
                                                        <?php
                                                        if($row['paid_observation']=="yes")
                                                        {
                                                            ?>
                                                            <div class="radio-custom radio-success">
                                                                <input type="radio" id="yes" name="paid_observe" value="yes" checked>
                                                                <label for="yes">Yes</label>
                                                            </div>
                                                            <div class="radio-custom">
                                                                <input type="radio" id="no" name="paid_observe" value="no" >
                                                                <label for="no">No</label>
                                                            </div>
                                                        <?php }else{?>
                                                            <div class="radio-custom radio-success">
                                                                <input type="radio" id="yes" name="paid_observe" value="yes">
                                                                <label for="yes">Yes</label>
                                                            </div>
                                                            <div class="radio-custom">
                                                                <input type="radio" id="no" name="paid_observe" value="no" checked>
                                                                <label for="no">No</label>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w5-guard-position">Guard Position<span class="required">*</span></label>
                                                <select class="form-control populate" name="guard_position" id="w5-guard-position" required>
                                                    <option value=""></option>
                                                    <?php
                                                    $pos = $guard->get_all_company_guard_position($c['company_id']);
                                                    while ($row_pos = $pos->fetch_assoc()) {
                                                        ?>
                                                        <option value="<?=$row_pos['pos_sno'];?>"
                                                            <?=$row_pos['pos_sno']==$row['g_position']?"selected":"";?>><?=$row_pos['pos_title'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-5">
                                                <label class="control-label pt-1" for="w5-guard-shift">Guard Shift<span class="required">*</span></label>
                                                <select class="form-control populate" name="guard_shift" id="w5-guard-shift" required>
                                                    <option value=""></option>
                                                    <?php
                                                    $shift = $guard->get_all_company_shift_arrangement($c['company_id']);
                                                    while ($row_shift = $shift->fetch_assoc()) {
                                                        ?>
                                                        <option value="<?=$row_shift['shift_id'];?>"
                                                            <?=$row_shift['shift_id']==$row['g_shift']?"selected":"";?>><?=$row_shift['shift_title'];?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-6">
                                                <label class="control-label pt-1" for="w5-guard-salary">Guard Salary<span class="required">*</span></label>
                                                <input type="number" class="form-control" name="guard_salary" value="<?=$row['g_dep_salary'];?>">
                                            </div>
                                            <div class="col-sm-6 row_chr_days">
                                                <div class="form-group">
                                                    <label class="control-label pt-1" for="">Number of Days Worked</label>
                                                    <input type="number" class="form-control" name="num_days_worked"  value="<?=$row['number_of_days_worked'];?>">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <footer class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <input class="btn btn-primary px-5" type="submit" value="Update" />
                                            </div>
                                        </div>
                                    </footer>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.staff.php"); ?>
<script>
    $('.row_chr_days').hide();
    $('input[name="paid_observe"]').on('change', function() {
        if (this.value === "yes") {
            $('.row_chr_days').show();
        } else {
            $('.row_chr_days').hide();
        }
    });
</script>
