<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<?php
if (!isset($guard_id) || $guard_id == NULL ) {echo "<script>window.location = '".url_path('/company/list-guards',true,true)."'; </script>";}
?>
<?php
$res = $guard->get_guard_by_id($guard_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Deploy Guard</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><a href="<?= url_path('/company/list-guards',true,true)?>">Guard List</a></li>
                    <li><a href="<?= url_path('/company/edit-guard/'.$guard_id,true,true)?>">
                            <?= $row['guard_firstname']." ".$row['guard_lastname'];?></a></li>
                    <li><span>Deploy Guard</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Guard Deployment</h2>
            </header>
            <div class="card-body card-body-nopadding">
                <div class="wizard-tabs">
                    <ul class="nav wizard-steps">
                        <li class="nav-item active">
                            <a data-bs-target="#w1-step-one" data-bs-toggle="tab" class="nav-link text-center"></a>
                        </li>
                    </ul>
                </div>
               
                <form class="form-horizontal" name="deploy_guard" id="deploy_guard">
                    <div class="tab-content">
                        <div id="response-alert"></div>
                         <!-- step one-->
                        <div id="w1-step-one" class="tab-pane p-3 active">
                           <div class="form-group row pb-3">
                               <div class="col-sm-6">
                                   <div class="form-group">
                                       <label class="control-label pt-1" for="w1-guard">Guard</label>
                                       <input type="text" class="form-control"
                                              value="<?=$row['guard_firstname']." ".$row['guard_middlename']." ".$row['guard_lastname'];?>" readonly>
                                      <input type="hidden" class="form-control" name="guard_id" id="w1-guard" value="<?= $guard_id;?>">
                                    </div>
                               </div>
                               <div class="col-sm-6">
                                   <div class="form-group">
                                       <label class="control-label pt-1" for="w1-beat">Beat</label>
                                      <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Select Beat", "allowClear": true }' name="beat_id" id="w1-beat-id" required>
                                            <option value=""></option>
                                           <?php
                                             $all_clients = $guard->get_all_company_clients($c['company_id']);
                                             while ($row_client = $all_clients->fetch_assoc()) {
                                            ?>
                                            <optgroup label="<?= $row_client['client_fullname'];?>">
                                              <?php
                                                $beats = $guard->get_all_client_beats($row_client['client_id']);
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
                                        <input type="date" class="form-control" name="date_of_deploy" id="w1-date-of-deploy" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label pt-1" for="w1-observe-start">Date observation Starts<span class="required">*</span></label>
                                        <input type="date" class="form-control" name="observe_start" id="w1-observe-start" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label pt-1" for="w1-observe-end">Date observation Ends<span class="required">*</span></label>
                                        <input type="date" class="form-control" name="observe_end" id="w1-observe-end" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label pt-1" for="w1-commence-date">Commencement Date<span class="required">*</span></label>
                                        <input type="date" class="form-control" name="commence_date" id="w1-commence-date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label pt-1" for="w1-paid-obervation">Paid Observation?<span class="required">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="radio-custom radio-success">
                                                <input type="radio" id="yes" name="paid_observe" value="yes" required>
                                                <label for="yes">Yes</label>
                                            </div>
                                            <div class="radio-custom">
                                                <input type="radio" id="no" name="paid_observe" value="no" required>
                                                <label for="no">No</label>
                                            </div>
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
                                            <option value="<?=$row_pos['pos_sno'];?>"><?=$row_pos['pos_title'];?></option>
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
                                            <option value="<?=$row_shift['shift_id'];?>"><?=$row_shift['shift_title'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="w5-guard-salary">Guard Salary<span class="required">*</span></label>
                                    <input type="number" class="form-control" name="guard_salary" id="w5-guard-salary" required>
                                </div>
                                <div class="col-sm-6 row_chr_days">
                                    <div class="form-group">
                                        <label class="control-label pt-1" for="w1-num-days-worked">No of Observation Days Worked<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="num_days_worked" id="w1-num-days-worked">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-12" style="text-align: right;">
                                    <input type="submit" value="Deploy" id="deploy_guard_button" style="display: inline-block;padding: 5px 14px; background-color: #fff;border: 1px solid #ddd;border-radius: 15px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>
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
