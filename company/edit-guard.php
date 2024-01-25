<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>

<?php
if (!isset($guard_id) || $guard_id == NULL ) {echo "<script>window.location = '".url_path('/company/list-guards',true,true)."'; </script>";}
?>
<?php
$res = $guard->get_guard_by_id($guard_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <?php
        $beat_name = $guard->get_beat_name($row['beat_id']);
        $beat = $beat_name->fetch_assoc();

        if (!empty($beat)) {
            $client_name = $guard->get_client_name($beat['client_id']);
            $client = $client_name->fetch_assoc();
        }
        ?>

        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Guard: <?= $row['guard_firstname']." ".$row['guard_lastname'];?></h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                        <li><span><a href="<?= url_path('/company/list-guards',true,true)?>">Guard List</a></span></li>
                        <li><span>Edit Guard Profile</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <div class="row">
                <div class="col-lg-4 col-xl-4 mb-4 mb-xl-0">
                    <section class="card">
                        <div class="card-body">
                            <div class="thumb-info mb-3">
                                <img src="<?=public_path('uploads/guard/'.$row['guard_photo'])?>" class="rounded img-fluid" alt="<?= $row['guard_firstname']." ".$row['guard_lastname'];?>">
                                <div class="thumb-info-title">
                                    <span class="thumb-info-inner"><?=$row['guard_firstname']." ".$row['guard_lastname'];?></span>
                                    <span class="thumb-info-type"><?=$row['nickname'];?></span>
                                    <?=($row['guard_status'] !=='Active')? '<span class="thumb-info-type">(Guard Not Active)</span>': '';?>
                                </div>
                            </div>
                            <hr class="dotted short">
                            <form name="guard_profile_upload" id="guard_profile_upload" enctype="multipart/form-data">
                                <a class="btn btn-primary col-md-12 mb-2 modal-profile-cam btn-large" href="#modalPPCapture">
                                    <i class="fas fa-camera"></i>
                                </a>
                                <input type="file" id="guard_profile_picx_update" accept="image/*" name="guard_profile_picx_update" style="display:none"/>
                                <input type="hidden" name="guard_id" id="guard_id" value="<?= $row['guard_id'] ?>" />
                                <input type="hidden" name="gname" id="gname" value="<?= $row['guard_firstname']." ".$row['guard_lastname'];?>" />
                                <input type="hidden" name="gphone" id="gphone" value="<?= $row['phone'] ?>" />
                                <input type="button" class="btn btn-primary col-md-12" id="propicxUpload" value="Update Photo" />
                            </form>
                        </div>
                    </section>

                    <section class="card">
                        <header class="card-header">
                            <div class="card-actions">
                                <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                            </div>
                            <h2 class="card-title"><span class="va-middle">ACTIONS</span></h2>
                        </header>
                        <div class="card-body">
                            <div class="content">
                                <ul class="simple-user-list">
                                    <li>
                                        <a href="<?= url_path('/company/print-guard-profile/'.$guard_id,true,true);?>">
                                            <figure class="image rounded"><i class="fas fa-print"></i></figure>
                                            <span class="title">Print Profile</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <?php
                                        $deployed_guard = $deploy_guard->get_deployed_guard($row['guard_id']);
                                        $check_guard = $deployed_guard->fetch_assoc();
                                        if($deployed_guard->num_rows == 0){
                                            ?>
                                            <a class="" href="<?= url_path('/company/deploy-guard-in-profile/'.$row['guard_id'],true,true);?>">
                                                <figure class="image rounded">
                                                    <i class="fas fa-reply"></i>
                                                </figure>
                                                <span class="title">Deploy Guard</span>
                                            </a>
                                        <?php }else{?>
                                            <a class="" href="<?= url_path('/company/edit-norminal-roll/'.$row['guard_id'],true,true);?>">
                                                <figure class="image rounded">
                                                    <i class="fas fa-reply"></i>
                                                </figure>
                                                <span class="title">Edit Guard Deployment</span>
                                            </a>
                                        <?php }?>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#issueLoan">
                                            <figure class="image rounded">
                                                <i class='fas fa-money-bill-alt'></i>
                                            </figure>
                                            <span class="title">Issue Loan</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#issueSalaryAdv">
                                            <figure class="image rounded">
                                                <i class="fas fa-money-bill-wave-alt"></i>
                                            </figure>
                                            <span class="title">Issue Salary Advance</span>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#extraDuty">
                                            <figure class="image rounded">
                                                <i class="fas fa-user-alt"></i>
                                            </figure>
                                            <span class="title">Extra Duty</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#changeStatus">
                                            <figure class="image rounded">
                                                <i class="fas fa-user-alt"></i>
                                            </figure>
                                            <span class="title">Change Status</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#guardKit">
                                            <figure class="image rounded">
                                                <i class="fa fa-plus margin"></i>
                                            </figure>
                                            <span class="title">Guard Kit</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#bookGuard">
                                            <figure class="image rounded">
                                                <i class="fas fa-user-times"></i>
                                            </figure>
                                            <span class="title">Book Guard</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#absentOnTraining">
                                            <figure class="image rounded">
                                                <i class="fas fa-user-times"></i>
                                            </figure>
                                            <span class="title">Absent on Training</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <!--<li>-->
                                    <!--    <a class="modal-with-move-anim ws-normal" href="#IDCardCharge">-->
                                    <!--        <figure class="image rounded">-->
                                    <!--            <i class="fas fa-money-bill-wave-alt"></i>-->
                                    <!--        </figure>-->
                                    <!--        <span class="title">ID Card Charge Deduction</span>-->
                                    <!--    </a>-->
                                    <!--</li>-->
                                    <!--<hr class="dotted short">-->
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#DebCredPayroll">
                                            <figure class="image rounded">
                                                <i class="fas fa-credit-card"></i>
                                            </figure>
                                            <span class="title">Debit/Credit on Payroll</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#listActiveDebCre">
                                            <figure class="image rounded">
                                                <i class="fas fa-list-alt"></i>
                                            </figure>
                                            <span class="title">List Guard Payroll Data</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#listUniformDeduct">
                                            <figure class="image rounded">
                                                <i class="far fa-file-alt"></i>
                                            </figure>
                                            <span class="title">List Uniform Deduction Data</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a href="<?= url_path('/company/guard-activity-log/'.$guard_id,true,true);?>">
                                            <figure class="image rounded"><i class="bx bx-book-alt"></i></figure>
                                            <span class="title">Activity Logs</span>
                                        </a>
                                    </li>
                                </ul>
                                <hr class="dotted short">
                            </div>
                        </div>
                    </section>
                    <!-- Issue Loan Animation -->
                    <div id="issueLoan" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="guard_issue_loan" id="guard_issue_loan" class="card">
                            <header class="card-header"><h2 class="card-title">Issue Guard Loan</h2></header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group">
                                        <label for="loanAmount">Loan Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₦</span>
                                            <input type="text" class="form-control" id="loanAmount" name="loan_amount" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="loanAmount">Loan Duration <small class="text-info">(Loan payment duration in months)</small></label>
                                        <input type="text" class="form-control" id="loanDuration" name="loan_duration" value=""/>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <div class="col-lg-6">
                                            <div class="">
                                                <label for="loanMonthlyAmount">Monthly Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₦</span>
                                                    <input type="text" class="form-control" id="loanMonthlyAmount" name="loan_monthly_amount" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="">
                                                <label for="issue_date">Date Issued</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    <input type="text" id="issue_date" name="issue_date" data-plugin-datepicker="" class="form-control"
                                                           value="<?=date('m/d/Y')?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="loanReason">Reason</label>
                                        <textarea name="loan_reason" id="loanReason" cols="30" rows="3" class="form-control"></textarea>
                                        <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Approve">
                                        <button class="btn btn-default modal-dismiss">Close</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>
                    <!-- Issue Salary Advance Animation -->
                    <div id="issueSalaryAdv" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="guard_issue_salary_adv" id="guard_issue_salary_adv" class="card">
                            <header class="card-header">
                                <h2 class="card-title">Issue Salary Advance</h2>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group">
                                        <label for="salaryAdvAmount">Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₦</span>
                                            <input type="text" class="form-control" id="salaryAdvAmount" name="salary_adv_amount" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ded_month">Deduction Month</label>
                                        <select class="form-control" name="ded_month" id="ded_month">
                                            <option value=""></option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="ded_month">Deduction Year</label>
                                        <select class="form-control" name="ded_year" id="ded_year">
                                            <option value=""></option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="salaryAdvReason">Reason</label>
                                        <textarea name="salary_adv_reason" id="salaryAdvReason" cols="30" rows="2" class="form-control"></textarea>
                                        <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Approve" />
                                        <button class="btn btn-default modal-dismiss">Cancel</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>
                    <!-- Change Status Animation -->
                    <div id="changeStatus" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="guardchangeStat" id="guardchangeStat" class="card">
                            <header class="card-header">
                                <h2 class="card-title">Change Status</h2>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group">
                                        <label for="guardStat" >Status</label>
                                        <select class="form-control mb-3" name="guardStatus" id="guardStatus">
                                            <option value="Deactivate">Deactivate</option>
                                        </select>
                                        <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                        <input type="hidden" name="beat_id" value="<?=$row['beat_id'];?>">
                                        <input type="hidden" name="comm_date" value="<?=$row['commencement_date'];?>">
                                    </div>
                                    <div class="form-group row pb-3 eligible_div">
                                        <label class="col-sm-4 control-label pt-1" for="eligible">Eligible for Payment? <span class="required">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="radio-custom">
                                                <input type="radio" id="no" name="pay_eligibility" value="no" checked required>
                                                <label for="no">No</label>
                                            </div>
                                            <div class="radio-custom radio-success">
                                                <input type="radio" id="yes" name="pay_eligibility" value="yes" required>
                                                <label for="yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group pb-2">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="cur_salary">Current Salary (₦)</label>
                                                <input type="text" name="cur_salary" id="cur_salary" value="<?=$row['g_dep_salary'];?>" class="form-control" required readonly />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="days_worked">Days Worked</label>
                                                <input type="number" name="days_worked" id="days_worked" class="form-control" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group pb-2">
                                        <div class="col-lg-6">
                                            <div class="form-group"> 
                                                <label for="new_salary">New Salary (₦) - Optional</label>
                                                <input type="number" name="new_salary" id="new_salary" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="dated_on">Date</label>
                                                <input type="date" name="dated_on" id="dated_on" class="form-control" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group pb-2">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="gpay">Estimated Payment (₦)</label>
                                                <input type="text" name="gpay" id="gpay" class="form-control" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="statusReason" >Remark</label>
                                        <textarea name="statusReason" rows="2" id="statusReason" class="form-control" placeholder="Remark" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                        <button class="btn btn-default modal-dismiss">Cancel</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>
                    <!-- Book Guard -->
                    <div id="bookGuard" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="bookGuard" id="bookGuard" class="card">
                            <header class="card-header">
                                <h2 class="card-title">Book Guard</h2>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group">
                                        <label for="offense_title">Offense Title</label>
                                        <select class="form-control mb-3" name="offense_title" id="offense_title">
                                            <option value=""></option>
                                            <?php
                                            $res = $company->get_all_company_penalties($c['company_id']);
                                            if ($res->num_rows > 0) {$n=0;
                                                while ($row2 = $res->fetch_assoc()) {
                                                    ?>
                                                    <option value="<?= $row2['offense_name'];?>"><?= $row2['offense_name'];?></option>
                                                <?php } } ?>
                                        </select>
                                        <?php
                                        $res = $company->get_all_company_penalties($c['company_id']);
                                        if ($res->num_rows > 0) {
                                            while ($row2 = $res->fetch_assoc()) {
                                                ?>
                                                <input type="hidden" name="offense_charge" value="<?=$row2['offense_charge'];?>">
                                                <input type="hidden" name="charge_amt" value="<?=$row2['charge_amt'];?>">
                                            <?php } } ?>
                                        <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                        <input type="hidden" name="g_salary" value="<?=$row['g_dep_salary'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                    <div id="penaltyRes"></div>
                                    <div class="form-group">
                                        <label for="offense_date">Offense Date</label>
                                        <input type="date" name="offense_date" id ="offense_date" class="form-control mb-3" />
                                    </div>
                                    <div class="form-group">
                                        <label for="guard-offense-remark">Remark/Reason</label>
                                        <textarea name="guard_offense_remark" rows="2" id="guard-offense-remark" class="form-control" placeholder="Remark"></textarea>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Approve" />
                                        <button class="btn btn-default modal-dismiss">Cancel</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>
                    <!-- Extra Duty -->
                    <div id="extraDuty" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="guardExtraDuty" id="guardExtraDuty" class="card">
                            <header class="card-header" style="display:flex;justify-content: space-between;">
                                <h2 class="card-title">Extra Duty</h2>
                                <div>
									<a href="<?= url_path('/company/list-xtra-duties/'.$row['guard_id'],true,true)?>" class="btn btn-primary btn-xs">List Xtra Duties</a>
								</div>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group">
                                        <label for="extra-duty-beat-id">Beat</label>
                                        <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Select Beat", "allowClear": true }' name="extra_duty_beat_id" id="extra-duty-beat-id">
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

                                        <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                        <!--<input type="hidden" name="g_salary" value="">-->
                                    </div>
                                    <div class="form-group">
                                        <label for="extra-duty-guard-replace">Guard to Replace</label>
                                        <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Select Guard to Replace", "allowClear": true }'  name="extra_duty_guard_replace" id="extra-duty-guard-replace">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="extra-duty-No-Of-Days">Number of Days</label>
                                        <input type="number" name="extra_duty_No_Of_Days" class="form-control" id="extra-duty-No-Of-Days" >
                                    </div>
                                    <div class="form-group">
                                        <label for="extra_duty_date">Date</label>
                                        <input type="date" name="extra_duty_date" class="form-control" id="extra_duty_date" >
                                    </div>
                                    <div class="form-group">
                                        <label for="g_salary">Salary</label>
                                        <input type="number" name="g_salary" class="form-control" id="g_salary" >
                                    </div>
                                    <div class="form-group">
                                        <label for="extra-duty-remark">Remark/Reason</label>
                                        <textarea name="extra_duty_remark" rows="2" id="extra-duty-remark" class="form-control" placeholder="Remark"></textarea>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Approve" />
                                        <button class="btn btn-default modal-dismiss">Cancel</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>
                    <!-- Guard Kit -->
                    <div id="guardKit" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                    <form name="guardKit" id="guardKit" class="card">
                    <header class="card-header">
                        <h2 class="card-title">Guard Kit</h2>
                    </header>
                    <div class="card-body">
                        <div class="modal-wrapper py-0">
                            <div class="form-group">
                                <label for="guard-kit-type">Kit Type</label>
                                <select class="form-control mb-3" name="guard_kit_type" id="guard-kit-type">
                                    <option value=""></option>
                                    <option value="Old">Old Kit</option>
                                    <option value="New">New Kit</option>
                                </select>
                            </div>
                            <div class="form-group row pb-2">
                                <label class="col-sm-2 control-label text-sm-end pt-2">Select Kit <span class="required">*</span></label>
                                <div class="col-sm-10">
                                    <?php
                                    $resK = $company->get_all_company_kits_inventory_in_stock($c['company_id']);
                                    if ($resK->num_rows > 0) {
                                    while ($rowK = $resK->fetch_assoc()) {
                                    ?>
                                    <div class="checkbox-custom checkbox-default">
                                        <input id="kit_<?=$rowK['kit_inv_sno'];?>" value="<?=$rowK['kit_name'];?>" type="checkbox" name="kits[]" required>
                                        <label for="kit_<?=$rowK['kit_inv_sno'];?>"><?=$rowK['kit_name'];?></label>
                                    </div>
                                    <?php } } else { echo "<span class='text-danger'>No Available Kit</span>";}?>
                                    <label class="error" for="kits[]"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="guard-kit-amt">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₦</span>
                                    <input type="text" class="form-control" id="guard-kit-amt" name="guard_kit_amt"
                                           value="<?=($c['uniform_fee']!="null"?$c['uniform_fee']:"");?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="uniform_mode">Mode of deduction</label>
                                <select class="form-control mb-3" name="uniform_mode" id="uniform_mode">
                                    <option value="1 month pay off">1 month pay off</option>
                                    <option value="2 months pay off">2 months pay off</option>
                                    <option value="3 months pay off">3 months pay off</option>
                                    <option value="fixed amount monthly">fixed amount monthly</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="guard_kit_date">Date</label>
                                <input type="date" name="guard_kit_date" class="form-control" id="guard_kit_date" >
                            </div>
                            <div class="form-group">
                                <label for="guard-kit-remark">Remark/Reason</label>
                                <textarea name="guard_kit_remark" rows="2" id="guard-kit-remark" class="form-control" placeholder="Remark"></textarea>
                                <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <input type="submit" class="btn btn-primary" value="Approve" />
                                <button class="btn btn-default modal-dismiss">Cancel</button>
                            </div>
                        </div>
                    </footer>
                    </form>
                    </div>
                    <!-- Absent on Training -->
                    <div id="absentOnTraining" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="absentOnTraining" id="absentOnTraining" class="card">
                            <header class="card-header"><h2 class="card-title">Absent on Training</h2></header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group">
                                        <label for="absent-training-No-Of-Days">Number of Days</label>
                                        <div class="input-group">
                                            <input type="number" name="absent_training_No_Of_Days" class="form-control" id="absent-training-No-Of-Days" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="absent-training-remark">Remark/Reason</label>
                                        <textarea name="absent_training_remark" rows="2" id="absent-training-remark" class="form-control" placeholder="Remark"></textarea>
                                        <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                        <input type="hidden" name="g_salary" value="<?=$row['g_dep_salary'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Save" />
                                        <button class="btn btn-default modal-dismiss">Cancel</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>
                    <!-- ID CARD CHARGE -->
                    <div id="IDCardCharge" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="guardIDCardCharge" id="guardIDCardCharge" class="card">
                            <header class="card-header">
                                <h2 class="card-title">ID Card Charge</h2>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group">
                                        <label for="guard-id-card-amt">Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₦</span>
                                            <input type="text" class="form-control" id="guard-id-card-amt" name="guard_id_card_amt" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="guard-id-card-remark">Remark/Reason</label>
                                        <textarea name="guard_id_card_remark" rows="2" id="guard-id-card-remark" class="form-control" placeholder="Remark"></textarea>
                                        <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Approve" />
                                        <button class="btn btn-default modal-dismiss">Cancel</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>
                    <!-- Issue DebCredPayroll -->
                    <div id="DebCredPayroll" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="DebitCreditGuardPayroll" id="DebitCreditGuardPayroll" class="card">
                            <header class="card-header">
                                <h2 class="card-title">Issue Debit/Credit on Guard Payroll</h2>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-row">
                                        <div class="form-group col-md-12 mb-4">
                                            <label for="payroll_title">Payroll Data Title <span class="required">*</span> 
                                            <small><i>will appear as typed on the payroll</i></small> </label>
                                            <input type="text" class="form-control" id="payroll_title" name="payroll_title">
                                            <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 mb-3 form-group border-0">
                                            <label class="col-sm-3 control-label">Payroll Type <span class="required">*</span></label>
                                            <div class="radio-custom radio-primary radio-inline px-4">
                                                <input id="Credit" name="payroll_typ" type="radio" value="Credit" required />
                                                <label for="Credit">Credit</label>
                                            </div>
                                            <div class="radio-custom radio-primary radio-inline mt-md-0">
                                                <input id="Debit" name="payroll_typ" type="radio" value="Debit" />
                                                <label for="Debit">Debit</label>
                                            </div>
                                            <label class="error pl-3" for="payroll_typ"></label>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <div class="col-sm-6 border-0">
                                            <label for="payment_mode">Payment Mode</label>
                                            <select id="payment_mode"  name="payment_mode" class="form-control payment_mode">
                                                <option value=""></option>
                                                <option value="One Time">One-Time</option>
                                                <option value="Monthly">Monthly</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 border-0">
                                            <label for="payroll_amount">Enter Amount <span class="required">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">₦</span>
                                                <input type="text" class="form-control" id="payroll_amount" name="payroll_amount"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row row_mon_year mb-4">
                                        <div class="col-sm-8 form-group border-0">
                                            <label for="mon_month">Select month <span class="required">*</span></label>
                                            <select id="mon_month"  name="mon_month" class="form-control">
                                                <option value=""></option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4 form-group border-0 pt-3 pt-sm-0">
                                            <label for="mon_year">Select year <span class="required">*</span></label>
                                            <select id="mon_year"  name="mon_year" class="form-control">
                                                <option value=""></option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-4">
                                        <label for="pay_data_date">Issue Date <span class="required">*</span></label>
                                        <input type="date" class="form-control" id="pay_data_date" name="pay_data_date">
                                    </div>
                                    <div class="form-group">
                                        <label for="payroll_remark">Description / Reason</label>
                                        <textarea name="payroll_remark" rows="3" id="payroll_remark" class="form-control"></textarea>
                                        <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Approve" />
                                        <button class="btn btn-default modal-dismiss">Cancel</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>
                    <!-- List Active Debit/Credit on Guard Payroll -->
                    <div id="listActiveDebCre" class="zoom-anim-dialog modal-block modal-block-full modal-block-primary mfp-hide">
                        <div class="card">
                            <header class="card-header">
                                <h2 class="card-title">
                                    <?= $row['guard_firstname']." ".$row['guard_lastname'];?> Debit/Credit on Payroll
                                </h2>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <table class="table table-bordered table-no-more mb-0" id="" style="font-size:10px;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Payroll Title</th>
                                            <th>Type</th>
                                            <th>Payment Mode</th>
                                            <th>Amount</th>
                                            <th>Month</th>
                                            <th>Year</th>
                                            <th>Description</th>
                                            <th>Created On</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $res2 = $guard->get_guard_payroll_debit_credit($row['guard_id'],$c['company_id']);
                                        if ($res2->num_rows > 0) {$n=0;
                                            while ($row2 = $res2->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td data-title="sno"><?=++$n;?></td>
                                                    <td data-title="Payroll Title"><?= $row2['gpd_title'];?></td>
                                                    <td data-title="Payroll Type"><?= $row2['gpd_type'];?></td>
                                                    <td data-title="Payment Mode"><?= $row2['gpd_pmode'];?></td>
                                                    <td data-title="Amount"><?= number_format($row2['gpd_amount'],0);?></td>
                                                    <td data-title="Month"><?= $row2['gpd_mon_month'];?></td>
                                                    <td data-title="Year"><?= $row2['gpd_mon_year'];?></td>
                                                    <td data-title="Description"><?= $row2['gpd_desc'];?> on <?= $row2['gpd_date'];?></td>
                                                    <td data-title="Created On"><?= $row2['gpd_issue_date'];?></td>
                                                    <td data-title="Actions" class="actions">
                                                        <a href="javascript:void(0)" data-gpd_sno="<?= $row2['gpd_sno'];?>" data-comp_id="<?=$c['company_id'];?>"
                                                           class="btn btn-danger btn-xs text-white" id="DebCredPayrollDeleteBtn">delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Payroll Credit or Debit found</td></tr>";} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button class="btn btn-default modal-dismiss">Close</button>
                                    </div>
                                </div>
                            </footer>
                        </div>
                    </div>
                    
                    <!-- List Active Uniform Deduct on Guard -->
                    <div id="listUniformDeduct" class="zoom-anim-dialog modal-block modal-block-full modal-block-primary mfp-hide">
                        <div class="card">
                            <header class="card-header">
                                <h2 class="card-title">
                                    <?= $row['guard_firstname']." ".$row['guard_lastname'];?> Active Uniform Deduction
                                </h2>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <table class="table table-bordered table-no-more mb-0" id="" style="font-size:10px;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kit Type</th>
                                            <th>Issued Kit</th>
                                            <th>Amount</th>
                                            <th>Issued Date</th>
                                            <th>Monthly Charge</th>
                                            <th>No of Month(s)</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $res_un_d = $guard->get_guard_uniform_deduct($row['guard_id'],$c['company_id']);
                                        if ($res_un_d->num_rows > 0) {$n=0;
                                            while ($row_un_d = $res_un_d->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td data-title="sno"><?=++$n;?></td>
                                                    <td data-title="Kit Type"><?= $row_un_d['kit_type'];?></td>
                                                    <td data-title="Issued Kit"><?= $row_un_d['issued_kit'];?></td>
                                                    <td data-title="Amount">₦ <?= number_format($row_un_d['amount'],0);?></td>
                                                    <td data-title="Issued Date"><?= date("d-F-Y", strtotime($row_un_d['created_at']));?></td>
                                                    <td data-title="Monthly Charge">₦ <?= number_format($row_un_d['monthly_charge'],0);?></td>
                                                    <td data-title="No of Month"><?= $row_un_d['no_of_month'];?></td>
                                                    <td data-title="Description"><?= $row_un_d['reason_remark'];?></td>
                                                    <td data-title="Actions" class="actions">
                                                        <a href="javascript:void(0)" data-un_id="<?=$row_un_d['id'];?>" data-comp_id="<?=$c['company_id'];?>"
                                                           class="btn btn-danger btn-xs text-white" id="UniformDeductDeleteBtn">delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Uniform Deduction found</td></tr>";} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <button class="btn btn-default modal-dismiss">Close</button>
                                    </div>
                                </div>
                            </footer>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-xl-8">
                    <div class="tabs">
                        <ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link" data-bs-target="#sectionOne" href="#sectionOne" data-bs-toggle="tab">Guard Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#sectionTwo" href="#sectionTwo" data-bs-toggle="tab">Guard Guarantor Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#sectionThree" href="#sectionThree" data-bs-toggle="tab">Bank and Official Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#sectionFour" href="#sectionFour" data-bs-toggle="tab">Guard Files</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!-- section One -->
                            <div id="sectionOne" class="tab-pane active">
                                <form name="guard_update_section_one" id="guard_update_section_one">
                                    <div class="card-body">
                                        <div id="response-alert"></div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Guard First Name <span class="required">*</span></label>
                                                    <input type="text" class="form-control"  value="<?= $row['guard_firstname'];?>" name="guard_fname" id="w1-guard-fname" title="Required"/>
                                                    <input type="hidden" name="id" value="<?=$row['id'];?>" />
                                                    <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                                    <input type="hidden" name="client_id" value="<?=$row['client_id'];?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Guard Middle Name</label>
                                                    <input type="text" class="form-control"  value="<?= $row['guard_middlename'];?>" name="guard_mname" id="w1-guard-mname" title="Required"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Guard Last Name <span class="required">*</span></label>
                                                    <input type="text" class="form-control"  value="<?= $row['guard_lastname'];?>" name="guard_lname" id="w1-guard-lname" title="Required"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Height (ft)  <span class="required">*</span></label>
                                                    <select class="form-control populate" name="guard_height" id="w1-guard-height" title="Required">
                                                        <option value="<?=$row['height'];?>"><?=$row['height'];?></option>
                                                        <option value="5.1">5.1</option>
                                                        <option value="5.2">5.2</option>
                                                        <option value="5.3">5.3</option>
                                                        <option value="5.4">5.4</option>
                                                        <option value="5.5">5.5</option>
                                                        <option value="5.6">5.6</option>
                                                        <option value="5.7">5.7</option>
                                                        <option value="5.8">5.8</option>
                                                        <option value="5.9">5.9</option>
                                                        <option value="5.10">5.10</option>
                                                        <option value="5.11">5.11</option>
                                                        <option value="6.0">6.0</option>
                                                        <option value="6.1">6.1</option>
                                                        <option value="6.2">6.2</option>
                                                        <option value="6.3">6.3</option>
                                                        <option value="6.4">6.4</option>
                                                        <option value="6.5">6.5</option>
                                                        <option value="6.6">6.6</option>
                                                        <option value="6.7">6.7</option>
                                                        <option value="6.8">6.8</option>
                                                        <option value="6.9">6.9</option>
                                                        <option value="6.10">6.10</option>
                                                        <option value="6.11">6.11</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Sex  <span class="required">*</span></label>
                                                    <select class="form-control mb-3" name="guard_sex" title="Required" >
                                                        <option value="M" <?=($row['sex']=='M')?'selected':'';?>>Male</option>
                                                        <option value="F" <?=($row['sex']=='F')?'selected':'';?>>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Phone  <span class="required">*</span></label>
                                                    <input type="text" name="guard_phone" class="form-control" title="Required" value="<?= $row['phone'];?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Phone 2</label>
                                                    <input type="text" name="guard_phone_2" class="form-control" value="<?= $row['phone2'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-3">
                                                <label class="control-label pt-1" for="w1-state-of-origin">State of Origin<span class="required">*</span></label>
                                                <select class="form-control populate" name="guard_state_of_origin" id="w1-state-of-origin" title="Required">
                                                    <option value="<?=$row['state_of_origin'];?>"><?=$row['state_of_origin'];?></option>
                                                    <option value="Abia">Abia State</option>
                                                    <option value="Adamawa">Adamawa State</option>
                                                    <option value="Akwa Ibom">Akwa Ibom State</option>
                                                    <option value="Anambra">Anambra State</option>
                                                    <option value="Bauchi">Bauchi State</option>
                                                    <option value="Bayelsa">Bayelsa State</option>
                                                    <option value="Benue">Benue State</option>
                                                    <option value="Borno">Borno State</option>
                                                    <option value="Cross River">Cross River State</option>
                                                    <option value="Delta">Delta State</option>
                                                    <option value="Ebonyi">Ebonyi State</option>
                                                    <option value="Edo">Edo State</option>
                                                    <option value="Ekiti">Ekiti State</option>
                                                    <option value="Enugu">Enugu State</option>
                                                    <option value="Gombe">Gombe State</option>
                                                    <option value="Imo">Imo State</option>
                                                    <option value="Jigawa">Jigawa State</option>
                                                    <option value="Kaduna">Kaduna State</option>
                                                    <option value="Kano">Kano State</option>
                                                    <option value="Katsina">Katsina State</option>
                                                    <option value="Kebbi">Kebbi State</option>
                                                    <option value="Kogi">Kogi State</option>
                                                    <option value="Kwara">Kwara State</option>
                                                    <option value="Lagos">Lagos State</option>
                                                    <option value="Nasarawa">Nasarawa State</option>
                                                    <option value="Niger">Niger State</option>
                                                    <option value="Ogun">Ogun State</option>
                                                    <option value="Ondo">Ondo State</option>
                                                    <option value="Osun">Osun State</option>
                                                    <option value="Oyo">Oyo State</option>
                                                    <option value="Plateau">Plateau State</option>
                                                    <option value="Rivers">Rivers State</option>
                                                    <option value="Sokoto">Sokoto State</option>
                                                    <option value="Taraba">Taraba State</option>
                                                    <option value="Yobe">Yobe State</option>
                                                    <option value="Zamfara">Zamfara State</option>
                                                    <option value="FCT">Federal Capital territory</option>

                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label pt-1" for="w1-guard-religion">Religion<span class="required">*</span></label>
                                                <select class="form-control populate" name="guard_religion" id="w1-guard-religion" title="Required">
                                                    <option value="<?=$row['religion'];?>"><?=$row['religion'];?></option>
                                                    <option value="Christian">Christian</option>
                                                    <option value="Muslim">Muslim</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label pt-1" for="w1-guard-qualification">Qualification<span class="required">*</span></label>
                                                <select class="form-control populate" name="guard_qualification" id="w1-guard-qualification" title="Required">
                                                    <option value="<?=$row['qualification'];?>"><?=$row['qualification'];?></option>
                                                    <option value='SSCE'>SSCE</option>
                                                    <option value='OND'>OND</option>
                                                    <option value='HND'>HND</option>
                                                    <option value='BSC'>BSC</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label pt-1" for="w1-guard-dob">Date of Birth<span class="required">*</span></label>
                                                <input type="date" class="form-control" name="guard_dob" id="w1-guard-dob" title="Required" value="<?=$row['dob'];?>">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-12">
                                                <label class="control-label pt-1" for="w1-referral">Referral<span class="required">*</span></label>
                                                <select class="form-control populate" name="referral" id="w1-referral" >
                                                    <option value="<?= $row['referral'];?>"><?= $row['referral'];?></option>
                                                    <option value="Agent">Agent</option>
                                                    <option value="Existing Guard">Existing Guard</option>
                                                    <option value="Others">Others</option>
                                                    <option value="Nobody">Nobody</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="GuardReferralDiv">
                                            <div class="form-group row pb-3">
                                                <div class="col-sm-12">
                                                    <label class="control-label text-sm-end pt-1" for="w1-referral-name">Referral Name<span class="required">*</span></label>
                                                    <input type="text" class="form-control"  name="referral_name" id="w1-referral-name" value="<?= $row['referral_name'];?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <div class="col-sm-12">
                                                    <label class="control-label text-sm-end pt-1" for="w1-referral-address">Referral Address<span class="required">*</span></label>
                                                    <input type="text" class="form-control"  name="referral_address" id="w1-referral-address" value="<?= $row['referral_address'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <div class="col-sm-6">
                                                    <label class="control-label pt-1" for="w1-referral-phone">Referral Phone<span class="required">*</span></label>
                                                    <input type="text" class="form-control" name="referral_phone" id="w1-referral-phone" value="<?= $row['referral_phone'];?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="control-label pt-1" for="w1-referral-fee">Referral Fee<span class="required">*</span></label>
                                                    <input type="number" class="form-control" name="referral_fee" id="w1-referral-fee" value="<?= $row['referral_fee'];?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Next of Kin Name <span class="required">*</span></label>
                                                    <input type="text" name="guard_next_of_kin_name" class="form-control" title="Required" value="<?=$row['next_kin_name'] ;?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Next of Kin Phone <span class="required">*</span></label>
                                                    <input type="text" name="guard_next_of_kin_phone" class="form-control" title="Required" value="<?=$row['next_kin_phone'];?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Relationship<span class="required">*</span></label>
                                                    <input type="text" name="guard_next_of_kin_relationship" class="form-control" title="Required" value="<?=$row['next_kin_relationship'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-2">
                                                <label class="control-label pt-1" for="w1-guard-nickname">Nickname</label>
                                                <input type="text" class="form-control" name="guard_nickname" id="w1-guard-nickname" title="Required" value="<?=$row['nickname'];?>">
                                            </div>
                                            <div class="col-sm-10">
                                                <label class="control-label text-sm-end pt-1" for="w1-guard-address">Address<span class="required">*</span></label>
                                                <input type="text" class="form-control"  name="guard_address" id="w1-guard-address" title="Required" value="<?=$row['guard_address'];?>">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-12">
                                                <label class="control-label text-sm-end pt-1" for="w1-vetting">Vetting<span class="required">*</span></label>
                                                <textarea class="form-control" rows="3" id="textareaDefault" name="vetting" id="w1-vetting" ><?=$row['vetting'];?></textarea>
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
                            <!-- section Two -->
                            <div id="sectionTwo" class="tab-pane">
                                <form name="guard_update_section_two" id="guard_update_section_two">
                                    <div class="card-body">
                                        <div id="response-alert"></div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-2">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-title">Title</label>
                                                <select class="form-control populate" name="guarantor_title" id="w1-guarantor-title" >
                                                    <option value="<?=$row['guarantor_title'];?>"><?=$row['guarantor_title'];?></option>
                                                    <option value="Mr">Mr.</option>
                                                    <option value="Miss">Miss</option>
                                                    <option value="Mrs">Mrs.</option>
                                                </select>
                                                <input type="hidden" name="id" value="<?=$row['id'];?>" />
                                                <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-firstname">Guarantor First Name</label>
                                                <input type="text" class="form-control"  name="guarantor_first_name" id="w1-guarantor-firstname" value="<?=$row['guarantor_fname'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-middlename">Middle Name</label>
                                                <input type="text" class="form-control"  name="guarantor_middle_name" id="w1-guarantor-middlename" value="<?=$row['guarantor_mname'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-lastname">Last Name</label>
                                                <input type="text" class="form-control"  name="guarantor_last_name" id="w1-guarantor-lastname" value="<?=$row['guarantor_lname'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-sex">Sex</label>
                                                <select class="form-control mb-3" name="guarantor_sex" title="Required" >
                                                    <option value="M" <?=($row['guarantor_sex']=='M')?'selected':'';?>>Male</option>
                                                    <option value="F" <?=($row['guarantor_sex']=='F')?'selected':'';?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-phone">Phone</label>
                                                <input type="text" class="form-control" name="guarantor_phone" id="w1-guarantor-phone" value="<?=$row['guarantor_phone'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-email">Email</label>
                                                <input type="email" class="form-control" name="guarantor_email" id="w1-guarantor-email" value="<?=$row['guarantor_email'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-12">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-address">Home Address</label>
                                                <input type="text" class="form-control"  name="guarantor_address" id="w1-guarantor-address" value="<?=$row['guarantor_add'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-years-relationship">Years of Relationship</label>
                                                <input type="number" class="form-control" name="guarantor_years_of_relationship" id="w1-guarantor-years-relationship" value="<?=$row['guarantor_yr_or'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-place-of-work">Place of work</label>
                                                <input type="text" class="form-control" name="guarantor_place_of_work" id="w1-guarantor-place-of-work" value="<?=$row['guarantor_wk_pl'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-rank">Rank</label>
                                                <input type="text" class="form-control" name="guarantor_rank" id="w1-guarantor-rank" value="<?=$row['guarantor_rank'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-ID-crd">ID Card Type</label>
                                                <select class="form-control populate" name="guarantor_id_Type" id="w1-guarantor-ID-crd" >
                                                    <option value="International Passport" <?=($row['guarantor_id_type']=='International Passport')?'selected':'';?>>International Passport</option>
                                                    <option value="Drivers License" <?=($row['guarantor_id_type']=='Drivers License')?'selected':'';?>>Driver’s License</option>
                                                    <option value="Voters Card" <?=($row['guarantor_id_type']=='Voters Card')?'selected':'';?>>Voter’s Card</option>
                                                    <option value="National ID Card" <?=($row['guarantor_id_type']=='National ID Card')?'selected':'';?>>National ID Card</option>
                                                    <option value="Valid Work ID Card" <?=($row['guarantor_id_type']=='Valid Work ID Card')?'selected':'';?>>Valid Work ID Card</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-8">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-work-address">Work Address</label>
                                                <input type="text" class="form-control"  name="guarantor_work_address" id="w1-guarantor-work-address" value="<?=$row['guarantor_wk_add'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-4">
                                                <label class="control-label pt-1" for="w1-guarantor-photo">Guarantor Photo</label>
                                                <input type="file" class="form-control" name="edit_guarantor_photo" id="w1-guarantor-photo">
                                                <input type="hidden" name="guarantor_photo" value="<?=$row['guarantor_photo'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorPhoto">View Image</a>
                                                <div id="guarantorPhoto" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/guard/'.$row['guarantor_photo']);?>" alt="" class="img-thumbnail">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <footer class="card-footer">
                                                            <div class="row">
                                                                <div class="col-md-12 text-end">
                                                                    <button class="btn btn-primary modal-dismiss">OK</button>
                                                                </div>
                                                            </div>
                                                        </footer>
                                                    </section>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="control-label pt-1" for="w1-guarantor-ID-card-front">ID Card Front </label>
                                                <input type="file" class="form-control" name="edit_guarantor_id_front" id="w1-guarantor-ID-card-front">
                                                <input type="hidden" name="guarantor_id_front" value="<?=$row['guarantor_id_front'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDFront">View Image</a>
                                                <div id="guarantorIDFront" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/guard/'.$row['guarantor_id_front']);?>" alt="" class="img-thumbnail">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <footer class="card-footer">
                                                            <div class="row">
                                                                <div class="col-md-12 text-end">
                                                                    <button class="btn btn-primary modal-dismiss">OK</button>
                                                                </div>
                                                            </div>
                                                        </footer>
                                                    </section>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="control-label pt-1" for="w1-guarantor-Id-card-back">ID Card Back </label>
                                                <input type="file" class="form-control" name="edit_guarantor_id_back" id="w1-guarantor-Id-card-back">
                                                <input type="hidden" name="guarantor_id_back" value="<?=$row['guarantor_id_back'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDBack">View Image</a>
                                                <div id="guarantorIDBack" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/guard/'.$row['guarantor_id_back']);?>" alt="" class="img-thumbnail">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <footer class="card-footer">
                                                            <div class="row">
                                                                <div class="col-md-12 text-end">
                                                                    <button class="btn btn-primary modal-dismiss">OK</button>
                                                                </div>
                                                            </div>
                                                        </footer>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row pb-3">
                                            <div class="col-sm-2">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-title-2">Title 2</label>
                                                <select class="form-control populate" name="guarantor_title_2" id="w1-guarantor-title-2" >
                                                    <option value="<?=$row['guarantor_title_2'];?>"><?=$row['guarantor_title_2'];?></option>
                                                    <option value="Mr">Mr.</option>
                                                    <option value="Miss">Miss</option>
                                                    <option value="Mrs">Mrs.</option>
                                                </select>
                                                <input type="hidden" name="id" value="<?=$row['id'];?>" />
                                                <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-firstname-2">Guarantor First Name 2</label>
                                                <input type="text" class="form-control"  name="guarantor_first_name_2" id="w1-guarantor-firstname-2" value="<?=$row['guarantor_fname_2'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-middlename-2">Middle Name 2</label>
                                                <input type="text" class="form-control"  name="guarantor_middle_name_2" id="w1-guarantor-middlename-2" value="<?=$row['guarantor_mname_2'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-lastname-2">Last Name 2</label>
                                                <input type="text" class="form-control"  name="guarantor_last_name_2" id="w1-guarantor-lastname-2" value="<?=$row['guarantor_lname_2'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-sex-2">Sex 2</label>
                                                <select class="form-control mb-3" name="guarantor_sex_2" title="Required" >
                                                    <option value="M" <?=($row['guarantor_sex_2']=='M')?'selected':'';?>>Male</option>
                                                    <option value="F" <?=($row['guarantor_sex_2']=='F')?'selected':'';?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-phone-2">Phone 2</label>
                                                <input type="text" class="form-control" name="guarantor_phone_2" id="w1-guarantor-phone-2" value="<?=$row['guarantor_phone_2'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-email-2">Email 2</label>
                                                <input type="email" class="form-control" name="guarantor_email_2" id="w1-guarantor-email-2" value="<?=$row['guarantor_email_2'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-12">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-address-2">Home Address</label>
                                                <input type="text" class="form-control"  name="guarantor_address_2" id="w1-guarantor-address-2" value="<?=$row['guarantor_add_2'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-years-relationship-2">Years of Relationship 2</label>
                                                <input type="number" class="form-control" name="guarantor_years_of_relationship_2" id="w1-guarantor-years-relationship-2" value="<?=$row['guarantor_yr_or_2'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-place-of-work-2">Place of work 2</label>
                                                <input type="text" class="form-control" name="guarantor_place_of_work_2" id="w1-guarantor-place-of-work-2" value="<?=$row['guarantor_wk_pl_2'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-rank-2">Rank 2</label>
                                                <input type="text" class="form-control" name="guarantor_rank_2" id="w1-guarantor-rank-2" value="<?=$row['guarantor_rank_2'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-ID-crd-2">ID Card Type 2</label>
                                                <select class="form-control populate" name="guarantor_id_Type_2" id="w1-guarantor-ID-crd-2" >
                                                    <option value="International Passport" <?=($row['guarantor_id_type_2']=='International Passport')?'selected':'';?>>International Passport</option>
                                                    <option value="Drivers License" <?=($row['guarantor_id_type_2']=='Drivers License')?'selected':'';?>>Driver’s License</option>
                                                    <option value="Voters Card" <?=($row['guarantor_id_type_2']=='Voters Card')?'selected':'';?>>Voter’s Card</option>
                                                    <option value="National ID Card" <?=($row['guarantor_id_type_2']=='National ID Card')?'selected':'';?>>National ID Card</option>
                                                    <option value="Valid Work ID Card" <?=($row['guarantor_id_type_2']=='Valid Work ID Card')?'selected':'';?>>Valid Work ID Card</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-8">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-work-address-2">Work Address 2</label>
                                                <input type="text" class="form-control"  name="guarantor_work_address_2" id="w1-guarantor-work-address-2" value="<?=$row['guarantor_wk_add_2'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-4">
                                                <label class="control-label pt-1" for="w1-guarantor-photo-2">Guarantor Photo 2</label>
                                                <input type="file" class="form-control" name="edit_guarantor_photo_2" id="w1-guarantor-photo-2">
                                                <input type="hidden" name="guarantor_photo_2" value="<?=$row['guarantor_photo_2'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorPhoto-2">View Image</a>
                                                <div id="guarantorPhoto-2" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/guard/'.$row['guarantor_photo_2']);?>" alt="" class="img-thumbnail">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <footer class="card-footer">
                                                            <div class="row">
                                                                <div class="col-md-12 text-end">
                                                                    <button class="btn btn-primary modal-dismiss">OK</button>
                                                                </div>
                                                            </div>
                                                        </footer>
                                                    </section>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="control-label pt-1" for="w1-guarantor-ID-card-front-2">ID Card Front 2</label>
                                                <input type="file" class="form-control" name="edit_guarantor_id_front_2" id="w1-guarantor-ID-card-front-2">
                                                <input type="hidden" name="guarantor_id_front_2" value="<?=$row['guarantor_id_front_2'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDFront-2">View Image</a>
                                                <div id="guarantorIDFront-2" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/guard/'.$row['guarantor_id_front_2']);?>" alt="" class="img-thumbnail">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <footer class="card-footer">
                                                            <div class="row">
                                                                <div class="col-md-12 text-end">
                                                                    <button class="btn btn-primary modal-dismiss">OK</button>
                                                                </div>
                                                            </div>
                                                        </footer>
                                                    </section>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="control-label pt-1" for="w1-guarantor-Id-card-back-2">ID Card Back 2</label>
                                                <input type="file" class="form-control" name="edit_guarantor_id_back_2" id="w1-guarantor-Id-card-back-2">
                                                <input type="hidden" name="guarantor_id_back_2" value="<?=$row['guarantor_id_back_2'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDBack-2">View Image</a>
                                                <div id="guarantorIDBack-2" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/guard/'.$row['guarantor_id_back_2']);?>" alt="" class="img-thumbnail">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <footer class="card-footer">
                                                            <div class="row">
                                                                <div class="col-md-12 text-end">
                                                                    <button class="btn btn-primary modal-dismiss">OK</button>
                                                                </div>
                                                            </div>
                                                        </footer>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row pb-3">
                                            <div class="col-sm-2">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-title-3">Title 3</label>
                                                <select class="form-control populate" name="guarantor_title_3" id="w1-guarantor-title-3" >
                                                    <option value="<?=$row['guarantor_title_3'];?>"><?=$row['guarantor_title_3'];?></option>
                                                    <option value="Mr">Mr.</option>
                                                    <option value="Miss">Miss</option>
                                                    <option value="Mrs">Mrs.</option>
                                                </select>
                                                <input type="hidden" name="id" value="<?=$row['id'];?>" />
                                                <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-firstname-3">Guarantor First Name 3</label>
                                                <input type="text" class="form-control"  name="guarantor_first_name_3" id="w1-guarantor-firstname-3" value="<?=$row['guarantor_fname_3'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-middlename-3">Middle Name 3</label>
                                                <input type="text" class="form-control"  name="guarantor_middle_name_3" id="w1-guarantor-middlename-3" value="<?=$row['guarantor_mname_3'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-lastname-3">Last Name 3</label>
                                                <input type="text" class="form-control"  name="guarantor_last_name_3" id="w1-guarantor-lastname-3" value="<?=$row['guarantor_lname_3'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-sex-3">Sex 3</label>
                                                <select class="form-control mb-3" name="guarantor_sex_3" title="Required" >
                                                    <option value="M" <?=($row['guarantor_sex_3']=='M')?'selected':'';?>>Male</option>
                                                    <option value="F" <?=($row['guarantor_sex_3']=='F')?'selected':'';?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-phone-3">Phone 3</label>
                                                <input type="text" class="form-control" name="guarantor_phone_3" id="w1-guarantor-phone-3" value="<?=$row['guarantor_phone_3'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-email-3">Email 3</label>
                                                <input type="email" class="form-control" name="guarantor_email_3" id="w1-guarantor-email-3" value="<?=$row['guarantor_email_3'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-12">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-address-3">Home Address</label>
                                                <input type="text" class="form-control"  name="guarantor_address_3" id="w1-guarantor-address-3" value="<?=$row['guarantor_add_3'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-years-relationship-3">Years of Relationship 3</label>
                                                <input type="number" class="form-control" name="guarantor_years_of_relationship_3" id="w1-guarantor-years-relationship-3" value="<?=$row['guarantor_yr_or_3'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-place-of-work-3">Place of work 3</label>
                                                <input type="text" class="form-control" name="guarantor_place_of_work_3" id="w1-guarantor-place-of-work-3" value="<?=$row['guarantor_wk_pl_3'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-rank-3">Rank 3</label>
                                                <input type="text" class="form-control" name="guarantor_rank_3" id="w1-guarantor-rank-3" value="<?=$row['guarantor_rank_3'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-ID-crd-3">ID Card Type 3</label>
                                                <select class="form-control populate" name="guarantor_id_Type_3" id="w1-guarantor-ID-crd-3" >
                                                    <option value="International Passport" <?=($row['guarantor_id_type_3']=='International Passport')?'selected':'';?>>International Passport</option>
                                                    <option value="Drivers License" <?=($row['guarantor_id_type_3']=='Drivers License')?'selected':'';?>>Driver’s License</option>
                                                    <option value="Voters Card" <?=($row['guarantor_id_type_3']=='Voters Card')?'selected':'';?>>Voter’s Card</option>
                                                    <option value="National ID Card" <?=($row['guarantor_id_type_3']=='National ID Card')?'selected':'';?>>National ID Card</option>
                                                    <option value="Valid Work ID Card" <?=($row['guarantor_id_type_3']=='Valid Work ID Card')?'selected':'';?>>Valid Work ID Card</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-8">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-work-address-3">Work Address 3</label>
                                                <input type="text" class="form-control"  name="guarantor_work_address_3" id="w1-guarantor-work-address-3" value="<?=$row['guarantor_wk_add_3'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                                <div class="col-lg-4">
                                                    <label class="control-label pt-1" for="w1-guarantor-photo-3">Guarantor Photo 3</label>
                                                    <input type="file" class="form-control" name="edit_guarantor_photo_3" id="w1-guarantor-photo-3">
                                                    <input type="hidden" name="guarantor_photo_3" value="<?=$row['guarantor_photo_3'];?>" />
                                                    <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorPhoto-3">View Image</a>
                                                    <div id="guarantorPhoto-3" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                        <section class="card">
                                                            <div class="card-body">
                                                                <div class="modal-wrapper">
                                                                    <div class="modal-text">
                                                                        <img src="<?=public_path('uploads/guard/'.$row['guarantor_photo_3']);?>" alt="" class="img-thumbnail">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <footer class="card-footer">
                                                                <div class="row">
                                                                    <div class="col-md-12 text-end">
                                                                        <button class="btn btn-primary modal-dismiss">OK</button>
                                                                    </div>
                                                                </div>
                                                            </footer>
                                                        </section>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="control-label pt-1" for="w1-guarantor-ID-card-front-3">ID Card Front 3</label>
                                                    <input type="file" class="form-control" name="edit_guarantor_id_front_3" id="w1-guarantor-ID-card-front-3">
                                                    <input type="hidden" name="guarantor_id_front_3" value="<?=$row['guarantor_id_front_3'];?>" />
                                                    <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDFront-3">View Image</a>
                                                    <div id="guarantorIDFront-3" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                        <section class="card">
                                                            <div class="card-body">
                                                                <div class="modal-wrapper">
                                                                    <div class="modal-text">
                                                                        <img src="<?=public_path('uploads/guard/'.$row['guarantor_id_front_3']);?>" alt="" class="img-thumbnail">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <footer class="card-footer">
                                                                <div class="row">
                                                                    <div class="col-md-12 text-end">
                                                                        <button class="btn btn-primary modal-dismiss">OK</button>
                                                                    </div>
                                                                </div>
                                                            </footer>
                                                        </section>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="control-label pt-1" for="w1-guarantor-Id-card-back-3">ID Card Back 3</label>
                                                    <input type="file" class="form-control" name="edit_guarantor_id_back_3" id="w1-guarantor-Id-card-back-3">
                                                    <input type="hidden" name="guarantor_id_back_3" value="<?=$row['guarantor_id_back_3'];?>" />
                                                    <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDBack-3">View Image</a>
                                                    <div id="guarantorIDBack-3" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                        <section class="card">
                                                            <div class="card-body">
                                                                <div class="modal-wrapper">
                                                                    <div class="modal-text">
                                                                        <img src="<?=public_path('uploads/guard/'.$row['guarantor_id_back_3']);?>" alt="" class="img-thumbnail">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <footer class="card-footer">
                                                                <div class="row">
                                                                    <div class="col-md-12 text-end">
                                                                        <button class="btn btn-primary modal-dismiss">OK</button>
                                                                    </div>
                                                                </div>
                                                            </footer>
                                                        </section>
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
                            <!-- section Three -->
                            <div id="sectionThree" class="tab-pane">
                                <form name="guard_update_section_three" id="guard_update_section_three">
                                    <div class="form-group row pb-3">
                                        <input type="hidden" name="id" value="<?=$row['id'];?>" />
                                        <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />

                                        <div class="col-sm-6">
                                            <label class="control-label pt-2" for="w1-guard-ID-crd">Guard ID Card Type<span class="required">*</span></label>
                                            <select class="form-control populate" name="guard_id_Type" id="w1-guard-ID-crd" >
                                                <option value="International Passport" <?=($row['guard_id_type']=='International Passport')?'selected':'';?>>International Passport</option>
                                                <option value="Drivers License" <?=($row['guard_id_type']=='Drivers License')?'selected':'';?>>Driver’s License</option>
                                                <option value="Voters Card" <?=($row['guard_id_type']=='Voters Card')?'selected':'';?>>Voter’s Card</option>
                                                <option value="National ID Card" <?=($row['guard_id_type']=='National ID Card')?'selected':'';?>>National ID Card</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label pt-2" for="">Blood Group <span class="required">*</span></label>
                                            <select class="form-control" name="guard_blood_group" id="w1-guard-blood-group" title="" required>
                                                <option value="A" <?=($row['blood_group']=='A')?'selected':'';?>>A</option>
                                                <option value="B" <?=($row['blood_group']=='B')?'selected':'';?>>B</option>
                                                <option value="AB" <?=($row['blood_group']=='AB')?'selected':'';?>>AB</option>
                                                <option value="O" <?=($row['blood_group']=='O')?'selected':'';?>>O</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-3">
                                        <div class="col-sm-6">
                                            <label class="control-label pt-1" for="w1-guard-bank"> Bank<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="guard_bank" id="w1-guard-bank" value="<?=$row['bank'];?>" >
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label pt-1" for="w1-guard-acct-number">Account Number<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="guard_acct_number" id="w1-guard-acct-number" value="<?=$row['account_number'];?>" >
                                        </div>
                                    </div>
                                    <div class="form-group row pb-3">
                                        <div class="col-sm-6">
                                            <label class="control-label pt-1" for="w1-guard-acct-name"> Account Name</label>
                                            <input type="text" class="form-control" name="guard_acct_name" id="w1-guard-acct-name" value="<?=$row['account_name'];?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label pt-1" for="w1-beat">Beat</label>
                                            <?php
                                            $guard_beat_info = $deploy_guard->get_guard_beat($row['guard_id']);
                                            $guard_beat = $guard_beat_info->fetch_assoc();
                                            if (!empty($guard_beat)) {
                                                $get_guard_beat_name = $deploy_guard->get_guard_beat_name($guard_beat['beat_id']);
                                                $guard_beat_name = $get_guard_beat_name->fetch_assoc();
                                                $get_guard_client_name = $deploy_guard->get_guard_client_name($guard_beat_name['client_id']);
                                                $guard_client_name = $get_guard_client_name->fetch_assoc();
                                            }
                                            $num_deployed_guard = $deploy_guard->get_num_deployed_guard($row['guard_id']);
                                            ?>
                                            <?php  if($num_deployed_guard->num_rows > 0){?>
                                            <input type="text" class="form-control"  value="<?=$guard_client_name['client_fullname'];?>: <?=$guard_beat_name['beat_name'];?>" readonly>
                                            <?php }else{?>
                                            <input type="text" class="form-control"  value="Not deployed yet" readonly>
                                            <?php }?>
                                        </div>
                                    </div>
                                    <div class="form-group row pb-3">
                                        <label class="control-label pt-1" for="w1-guard-remark">Remark</label>
                                        <div class="col-sm-12">
                                            <textarea name="guard_remark" id="w1-guard-remark" cols="30" class="form-control"><?=$row['remark'];?></textarea>
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
                            <!-- section Four -->
                            <div id="sectionFour" class="tab-pane">

                                <div class="form-group row pb-3">
                                    <div class="col-sm-6">
                                        <form name="guard_id_front_upload" id="guard_id_front_upload" enctype="multipart/form-data">
                                            <label class="control-label pt-1" for="w1-guard-photo">Guard ID Card (front)<span class="required">*</span></label>
                                            <input type="file" style="display:none" name="edit_guard_id_front" id="w1_guard_id_front" accept=".png, .jpg, .jpeg">
                                            <input type="hidden" name="guard_id_front" value="<?=$row['guard_id_front'];?>" />
                                            <input type="button" class="btn up-link shadow-none col-md-12" id="gIDFrontUpload" value="Choose file.." />
                                            <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                            <input type="hidden" name="action_code" value="101" />
                                        </form>
                                        <a class="mb-1 mt-1 me-1 modal-basic" href="#guardIdFront">View Image</a>
                                        <div id="guardIdFront" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                            <section class="card">
                                                <div class="card-body">
                                                    <div class="modal-wrapper">
                                                        <div class="modal-text">
                                                            <img src="<?=public_path('uploads/guard/'.$row['guard_id_front']);?>" alt="" class="img-thumbnail">
                                                        </div>
                                                    </div>
                                                </div>
                                                <footer class="card-footer">
                                                    <div class="row">
                                                        <div class="col-md-12 text-end">
                                                            <button class="btn btn-primary modal-dismiss">OK</button>
                                                        </div>
                                                    </div>
                                                </footer>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <form name="guard_id_back_upload" id="guard_id_back_upload" enctype="multipart/form-data">
                                            <label class="control-label pt-1" for="w1-guard-Id-crd-bck"> Guard ID Card (back)<span class="required">*</span></label>
                                            <input type="file" style="display:none" name="edit_guard_id_back" id="w1_guard_back" accept=".png, .jpg, .jpeg">
                                            <input type="hidden" name="guard_id_back" value="<?=$row['guard_id_back'];?>" />
                                            <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                            <input type="hidden" name="action_code" value="102" />
                                            <input type="button" class="btn up-link shadow-none col-md-12" id="gIDBackUpload" value="Choose file.." />
                                        </form>
                                        <a class="mb-1 mt-1 me-1 modal-basic" href="#guardIdBack">View Image</a>
                                        <div id="guardIdBack" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                            <section class="card">
                                                <div class="card-body">
                                                    <div class="modal-wrapper">
                                                        <div class="modal-text">
                                                            <img src="<?=public_path('uploads/guard/'.$row['guard_id_back']);?>" alt="" class="img-thumbnail">
                                                        </div>
                                                    </div>
                                                </div>
                                                <footer class="card-footer">
                                                    <div class="row">
                                                        <div class="col-md-12 text-end">
                                                            <button class="btn btn-primary modal-dismiss">OK</button>
                                                        </div>
                                                    </div>
                                                </footer>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-sm-6">
                                        <form name="guard_signature_upload" id="guard_signature_upload" enctype="multipart/form-data">
                                            <label class="control-label pt-1" for="w1-guard-signature">Guard Signature<span class="required">*</span></label>
                                            <input type="file" style="display:none" name="edit_guard_signature" id="w1_guard_signature" accept=".png, .jpg, .jpeg">
                                            <input type="hidden" name="guard_signature" value="<?=$row['guard_signature'];?>" />
                                            <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                            <input type="hidden" name="action_code" value="103" />
                                            <input type="button" class="btn up-link shadow-none col-md-12" id="gSignatureUpload" value="Choose file.." />
                                        </form>
                                        <a class="mb-1 mt-1 me-1 modal-basic" href="#guardSignature">View Image</a>
                                        <div id="guardSignature" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                            <section class="card">
                                                <div class="card-body">
                                                    <div class="modal-wrapper">
                                                        <div class="modal-text">
                                                            <img src="<?=public_path('uploads/guard/'.$row['guard_signature']);?>" alt="" class="img-thumbnail">
                                                        </div>
                                                    </div>
                                                </div>
                                                <footer class="card-footer">
                                                    <div class="row">
                                                        <div class="col-md-12 text-end">
                                                            <button class="btn btn-primary modal-dismiss">OK</button>
                                                        </div>
                                                    </div>
                                                </footer>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: page -->
            <div id="modalPPCapture" class="modal-block modal-block-sm mfp-hide">
                <section class="card">
                    <header class="card-header"><h2 class="card-title">Profile Picture & Click Capture</h2></header>
                    <div class="card-body">
                        <div id="camera" style="height:auto;text-align:center;margin:0 auto;"></div>
                        <div id="cameraCaptured" style="display: none;"></div>
                        <form id="guard_photo_cam_update" name="guard_photo_cam_update">
                            <input type="hidden" name="dataurl" id="dataurl" required/>
                            <input type="hidden" name="guard_id" id="guard_id" value="<?= $row['guard_id'] ?>" />
                            <input type="hidden" name="sname" id="sname" value="<?= $row['guard_firstname']." ".$row['guard_lastname'];?>" />
                            <input type="hidden" name="sphone" id="sphone" value="<?= $row['phone'] ?>" />
                        </form>
                        <div class="text-center mt-2">
                            <button class="btn btn-xs btn-default" id="captureBtn" onclick="addCamPicture()">Capture</button>
                            <button class="btn btn-xs btn-danger pl-3" id="resetBtn">Clear&reset</button>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button class="btn btn-primary" id="guard_savePP_Profile">Save Photo</button>
                                <button class="btn btn-default modal-dismiss">Close</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </div>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>
<script src="<?= public_path("js/examples/examples.modals.js"); ?>"></script>
<script src="<?= public_path("js/webcam.js"); ?>"></script>
<script>$('#propicxUpload').click(function(){ $('#guard_profile_picx_update').trigger('click'); });</script>
<script>$('#gIDFrontUpload').click(function(){ $('#w1_guard_id_front').trigger('click'); });</script>
<script>$('#gIDBackUpload').click(function(){ $('#w1_guard_back').trigger('click'); });</script>
<script>$('#gSignatureUpload').click(function(){ $('#w1_guard_signature').trigger('click'); });</script>
<script>
    $(function() {
        $("input[name='loan_amount']").on('input', function(e) {$(this).val($(this).val().replace(/[^0-9]/g, ''));});
        $("input[name='loan_duration']").on('input', function(e) {$(this).val($(this).val().replace(/[^0-9]/g, ''));});
    });
</script>
<script>
    var inputs = $('#guard_issue_loan').find('input[name="loan_duration"]');
    inputs.keyup(function() {
        let loanAmount = $("#loanAmount").val();
        let loanDuration = $("#loanDuration").val();

        if ($(this).val() ==='' || $(this).val()==='0'){
            loanDuration = 1;
            $('#loanMonthlyAmount').val(loanAmount.toFixed(2));
            return;
        } else {
            let repaymentAmount = parseFloat(loanAmount)/parseFloat(loanDuration);
            $('#loanMonthlyAmount').val(repaymentAmount.toFixed(2));
        }
    });

    var inputs = $('#guard_issue_loan').find('input[name="loan_amount"]');
    inputs.keyup(function() {
        let loanAmount = $("#loanAmount").val();
        let loanDuration = $("#loanDuration").val();

        let repaymentAmount = parseFloat(loanAmount)/parseFloat(loanDuration);
        $('#loanMonthlyAmount').val(repaymentAmount.toFixed(2));
    });
</script>
<script>
    $('select[name="offense_title"]').change(function(){
        var selected = $(this).val();
        $.ajax({
            url: "penalty-info", type: "POST", data: {offense_title:selected},
            success: function (data) { $("#penaltyRes").html(data); }
        });
    });

    $('select[name="extra_duty_beat_id"]').change(function(){
        var selected = $(this).val();
        $.ajax({
            url: "guard-beat-info", type: "POST", data: {beat_id:selected},
            success: function (data) {
                $("#extra-duty-guard-replace").html(data);
            }
        });
    });

    if ($("#guardStatus").val() === 'Deactivate') { $(".eligible_div").show(); }
    else { $(".eligible_div").hide(); }
    $('select[name="guardStatus"]').change(function(){
        var selected = $(this).val();
        if (selected === 'Deactivate'){
            $(".eligible_div").show();
        } else {
            $(".eligible_div").hide();
        }
    });
</script>
<script>
    $("#guard-kit-type").change(function() {
        if ($(this).val() == "New") {
            $('#lanyards').show();
        } else {
            $('#lanyards').hide();
        }
    });
    $("#guard-kit-type").trigger("change");

</script>
<script>
    $('.modal-profile-cam').magnificPopup({type: 'inline', preloader: false, modal: true});
    $(document).on('click', '.modal-dismiss', function (e) {e.preventDefault();Webcam.reset();$.magnificPopup.close();});

    $(".content-body").on("click", ".modal-profile-cam", ()=>{
        Webcam.set({width: 300, height: 280, image_format: 'jpeg', jpeg_quality: 100});
        Webcam.attach('#camera');
        $("#resetBtn").hide();
        addCamPicture = function () {
            Webcam.snap(function (data_uri) {
                document.getElementById('dataurl').value = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                $("#camera").hide();
                $("#cameraCaptured").show();
                $("#captureBtn").hide();
                $("#resetBtn").show();
                const img = document.getElementById("cameraCaptured");
                img.innerHTML = '<img src="' + data_uri + '" id="" width="100%" height="250px" />';
            });
        };
    });
    $("#resetBtn").click(()=>{
        $("#camera").show();
        $("#cameraCaptured").hide();
        $("#captureBtn").show();
        $("#resetBtn").hide();
    });
</script>
<script>
    $(function($) {
        'use strict';
        $('.row_mon_year').hide();
        $('.row_mon_year_2').hide();
        $('.payment_mode').change(function(){
            if($(this).val() === 'One Time') {
                $('.row_mon_year').show();
                $('.row_mon_year_2').show();
            }  else {
                $('.row_mon_year').hide();
                $('.row_mon_year_2').hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        function daysInMonth (month, year) {
            return new Date(year, month, 0).getDate();
        }

        let gPay = 0;
        $("#days_worked, #new_salary, #dated_on").keyup(function() {
            var DaysWorked =$("input[name='days_worked']").val();

            var CurrSalary = $("input[name='cur_salary']").val();
            var NewSalaryPay = $("input[name='new_salary']").val();
            var ReDate = $("input[name='dated_on']").val();
            const d = new Date(ReDate);
            let month = d.getMonth() + 1;
            let year = d.getFullYear();
            var DaysInMonth = daysInMonth(month, year);
            
            if (ReDate !== '') {
                if (NewSalaryPay !== '') {
                    gPay = (DaysWorked / DaysInMonth) * NewSalaryPay;
                } else {
                    gPay = (DaysWorked / DaysInMonth) * CurrSalary;
                }
            }
            var FPay = Number(gPay).toFixed(2);
            $("input[name='gpay']").val(FPay);
        });
        $("#dated_on").change(function() {
            var DaysWorked =$("input[name='days_worked']").val();

            var CurrSalary = $("input[name='cur_salary']").val();
            var NewSalaryPay = $("input[name='new_salary']").val();
            var ReDate = $("input[name='dated_on']").val();
            const d = new Date(ReDate);
            let month = d.getMonth() + 1;
            let year = d.getFullYear();
            var DaysInMonth = daysInMonth(month, year);

            if (ReDate !== '') {
                if (NewSalaryPay !== '') {
                    gPay = (DaysWorked / DaysInMonth) * NewSalaryPay;
                } else {
                    gPay = (DaysWorked / DaysInMonth) * CurrSalary;
                }
            }
            var FPay = Number(gPay).toFixed(2);
            $("input[name='gpay']").val(FPay);
        });
    });
</script>




