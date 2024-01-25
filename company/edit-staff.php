<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>

<?php
if (!isset($staff_id) || $staff_id == NULL ) {echo "<script>window.location = '".url_path('/company/list-staffs',true,true)."'; </script>";}
?>
<?php
$res = $company->get_staff_by_id($staff_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <section role="main" class="content-body">
            <header class="page-header">
                <h2><a href="<?= url_path('/company/list-staffs',true,true)?>"><i class="fas fa-arrow-left">&nbsp;</i></a>Edit Staff</h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li>
                            <a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li><span>Edit Staff</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <div class="row">
                <div class="col-lg-4 col-xl-4 mb-4 mb-xl-0">
                    <section class="card">
                        <div class="card-body">
                            <div class="thumb-info mb-3">
                                <img src="<?=public_path('uploads/staff/'.$row['staff_photo']);?>" class="rounded img-fluid" alt="John Doe">
                                <div class="thumb-info-title">
                                    <span class="thumb-info-inner"><?=$row['staff_firstname'].' '.$row['staff_lastname'] ;?></span>
                                    <span class="thumb-info-type"><?$row['staff_role'];?></span>
                                </div>
                            </div>
                            <hr class="dotted short">
                            <p><span class="fw-bold">Staff ID</span>  <span class="pull-right text-primary staff_id_val"><?=$row['staff_id'];?></span> </p>
                            <p><span class="fw-bold">Sex</span>  <span class="pull-right text-primary"><?=$row['staff_sex'];?></span> </p>
                            <p><span class="fw-bold">Employed On</span>  <span class="pull-right text-primary"><?=$row['staff_created_on'];?></span> </p>
                            <hr class="dotted short">
                            <form name="profile_picx_upload" id="profile_picx_upload" enctype="multipart/form-data">
                                <a type="button" class="btn btn-primary col-md-12 mb-2 modal-profile-cam btn-large" href="#modalPPCapture">
                                    <i class="fas fa-camera"></i>
                                </a>
                                <input type="file" id="staff_profile_picx_update" name="staff_profile_picx_update" style="display:none"/>
                                <input type="hidden" name="staff_id" id="staff_id" value="<?= $row['staff_id'] ?>" />
                                <input type="hidden" name="sname" id="sname" value="<?= $row['staff_firstname'] ?>" />
                                <input type="hidden" name="sphone" id="sphone" value="<?= $row['staff_phone'] ?>" />
                                <input type="button" class="btn btn-primary col-md-12" id="propicxUpload" value="Update Photo" />
                            </form>
                        </div>
                    </section>

                    <section class="card">
                        <header class="card-header">
                            <div class="card-actions">
                                <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                            </div>
                            <h2 class="card-title">
                                <span class="va-middle">ACTIONS</span>
                            </h2>
                        </header>
                        <div class="card-body">
                            <div class="content">
                                <ul class="simple-user-list">
                                    <li>
                                        <a href="<?= url_path('/company/print-staff-profile/'.$row['staff_id'],true,true);?>">
                                            <figure class="image rounded"><i class="fas fa-print"></i></figure>
                                            <span class="title">Print Profile</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#issueLoan">
                                            <figure class="image rounded"><i class='fas fa-money-bill-alt'></i></figure>
                                            <span class="title">Issue Loan</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#issueSalaryAdv">
                                            <figure class="image rounded"><i class="fas fa-money-bill-wave-alt"></i></figure>
                                            <span class="title">Issue Salary Advance</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a href="<?= url_path('/company/staff-privileges/'.$row['staff_id'],true,true);?>">
                                            <figure class="image rounded"><i class="fa fa-key"></i></figure>
                                            <span class="title">Edit Privilege</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">

                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#changeStatus">
                                            <figure class="image rounded"><i class="fas fa-user-alt"></i></figure>
                                            <span class="title">Change Status</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#surchargeStaff">
                                            <figure class="image rounded"><i class="fas fa-user-times"></i></figure>
                                            <span class="title">Surcharge Staff</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a href="<?= url_path('/company/staff-activity-log/'.$staff_id,true,true);?>">
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
                        <form name="stf_issue_loan" id="stf_issue_loan" class="card">
                            <header class="card-header"><h2 class="card-title">Issue Staff Loan</h2></header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group mb-3">
                                        <label for="loanAmount">Loan Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₦</span>
                                            <input type="text" class="form-control" id="loanAmount" name="loan_amount" required/>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
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
                                    <div class="form-group mb-3">
                                        <label for="loanReason">Reason</label>
                                        <textarea name="loan_reason" id="loanReason" cols="30" rows="2" class="form-control"></textarea>
                                        <input type="hidden" name="staff_id" value="<?=$row['staff_id'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Submit">
                                        <button class="btn btn-default modal-dismiss">Close</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>

                    <!-- Issue Salary Advance Animation -->
                    <div id="issueSalaryAdv" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="stf_issue_salary_adv" id="stf_issue_salary_adv" class="card">
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
                                        <label for="salary_adv_reason">Reason</label>
                                        <textarea name="salary_adv_reason" rows="2" id="salary_adv_reason" class="form-control" placeholder="Reason"></textarea>
                                        <input type="hidden" name="staff_id" value="<?=$row['staff_id'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Save" />
                                        <button class="btn btn-default modal-dismiss">Close</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>

                    <!-- Change Status Animation -->
                    <div id="changeStatus" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="changeStat" id="changeStat" class="card">
                            <header class="card-header">
                                <h2 class="card-title">Change Status</h2>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group">
                                        <label for="stfStat">Status</label>
                                        <select class="form-control mb-3" name="stfStat" id="stfStat">
                                            <option value=""></option>
                                            <option value="Active" <?=($row['staff_acc_status']=='Active')?'selected':'';?>>Active</option>
                                            <option value="Deactivate" <?=($row['staff_acc_status']=='Deactivate')?'selected':'';?>>Deactivate</option>
                                        </select>
                                        <input type="hidden" name="staff_id" value="<?=$row['staff_id'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
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
                                    <div class="form-group">
                                        <label for="statusReason" >Remark</label>
                                        <textarea name="statusReason" rows="5" id="statusReason" class="form-control" placeholder="Remark" required></textarea>
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

                    <!-- Surcharge Staff Animation -->
                    <div id="surchargeStaff" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="surchargeStf" id="surchargeStf" class="card">
                            <header class="card-header">
                                <h2 class="card-title">Surcharge Staff</h2>
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
                                        <input type="hidden" name="staff_id" value="<?=$row['staff_id'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                    <div id="penaltyRes"></div>
                                    <div class="form-group">
                                        <label for="offense_date">Offense Date</label>
                                        <input type="date" name="offense_date" id ="offense_date" class="form-control mb-3" />
                                    </div>
                                    <div class="form-group">
                                        <label for="charge_reason">Reason/Remark</label>
                                        <textarea name="charge_reason" rows="2" id="charge_reason" class="form-control" placeholder="Remark"></textarea>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Save" />
                                        <button class="btn btn-default modal-dismiss">Close</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-8">
                    <div class="tabs">
                        <ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link" data-bs-target="#basicInfo" href="#basicInfo" data-bs-toggle="tab">Basic Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#guaranInfo" href="#guaranInfo" data-bs-toggle="tab">Guarantor Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#kinInfo" href="#kinInfo" data-bs-toggle="tab">Next of Kin Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#accInfo" href="#accInfo" data-bs-toggle="tab">Account Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#allFiles" href="#accInfo" data-bs-toggle="tab">Staff Files</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="basicInfo" class="tab-pane active">
                                <form name="update_staff_basic_info" id="update_staff_basic_info">
                                    <div class="card-body">
                                        <div id="response-alert"></div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">First Name <span class="required">*</span></label>
                                                    <input type="text" name="firstname" class="form-control" title="Please enter firstname" value="<?=$row['staff_firstname'] ;?>" />
                                                    <input type="hidden" name="staff_sno" value="<?=$row['staff_sno'];?>" />
                                                    <input type="hidden" name="staff_id" value="<?=$row['staff_id'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Middle Name</label>
                                                    <input type="text" name="middlename" class="form-control" title="Please enter middlename" value="<?=$row['staff_middlename'] ;?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Last Name <span class="required">*</span></label>
                                                    <input type="text" name="lastname" class="form-control" title="Please enter lastname" value="<?=$row['staff_lastname'] ;?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Gender <span class="required">*</span></label>
                                                    <select class="form-control mb-3" name="gender" title="" required>
                                                        <option value="Male" <?=($row['staff_sex']=='Male')?'selected':'';?>>Male</option>
                                                        <option value="Female" <?=($row['staff_sex']=='Female')?'selected':'';?>>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Marital Status <span class="required">*</span></label>
                                                    <select class="form-control mb-3" name="marital_status" title="" required>
                                                        <option value="Single" <?=($row['stf_marital_stat']=='Single')?'selected':'';?>>Single</option>
                                                        <option value="Married" <?=($row['stf_marital_stat']=='Married')?'selected':'';?>>Married</option>
                                                        <option value="Separated" <?=($row['stf_marital_stat']=='Separated')?'selected':'';?>>Separated</option>
                                                        <option value="Divorced" <?=($row['stf_marital_stat']=='Divorced')?'selected':'';?>>Divorced</option>
                                                        <option value="Widowed" <?=($row['stf_marital_stat']=='Widowed')?'selected':'';?>>Widowed</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <label class="col-form-label" for="">Home Address <span class="required">*</span></label>
                                                <input type="text" name="home_address" class="form-control" title="Please enter address" value="<?=$row['stf_home_addr'] ;?>" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="col-form-label" for="">Height (m) <span class="required">*</span></label>
                                                <input type="text" name="height" class="form-control" value="<?=$row['stf_height'];?>" />
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">DOB<span class="required">*</span></label>
                                                    <input type="text" data-plugin-datepicker class="form-control" name="dob" id="w1-dob" value="<?=$row['stf_dob'];?>" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Religion <span class="required">*</span></label>
                                                    <select class="form-control mb-3" name="religion" title="" required>
                                                        <option value="Christianity" <?=($row['stf_religion']=='Christianity')?'selected':'';?>>Christianity</option>
                                                        <option value="Islam" <?=($row['stf_religion']=='Islam')?'selected':'';?>>Islam</option>
                                                        <option value="Other Religions" <?=($row['stf_religion']=='Other Religions')?'selected':'';?>>Other Religions</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Blood Group <span class="required">*</span></label>
                                                    <select class="form-control mb-3" name="blood_grp" title="" required>
                                                        <option value="A" <?=($row['stf_blood_grp']=='A')?'selected':'';?>>A</option>
                                                        <option value="B" <?=($row['stf_blood_grp']=='B')?'selected':'';?>>B</option>
                                                        <option value="AB" <?=($row['stf_blood_grp']=='AB')?'selected':'';?>>AB</option>
                                                        <option value="O" <?=($row['stf_blood_grp']=='O')?'selected':'';?>>O</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Qualifications <span class="required">*</span></label>
                                                    <select class="form-control mb-3" name="qualification" title="" required>
                                                        <option value="SSCE" <?=($row['staff_qualification']=='SSCE')?'selected':'';?>>SSCE</option>
                                                        <option value="NCE" <?=($row['staff_qualification']=='NCE')?'selected':'';?>>NCE</option>
                                                        <option value="OND" <?=($row['staff_qualification']=='OND')?'selected':'';?>>OND</option>
                                                        <option value="HND" <?=($row['staff_qualification']=='HND')?'selected':'';?>>HND</option>
                                                        <option value="BSc" <?=($row['staff_qualification']=='BSc')?'selected':'';?>>BSc</option>
                                                        <option value="MSc" <?=($row['staff_qualification']=='MSc')?'selected':'';?>>MSc</option>
                                                        <option value="PhD" <?=($row['staff_qualification']=='PhD')?'selected':'';?>>PhD</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Email address <span class="required">*</span></label>
                                                    <input type="email" name="email" class="form-control" title="Please enter email address" value="<?=$row['staff_email'];?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Phone number <span class="required">*</span></label>
                                                    <input type="tel" name="phone" class="form-control" title="Please enter phone number" value="<?=$row['staff_phone'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Role <span class="required">*</span></label>
                                                    <select class="form-control mb-3" name="staff_role" title="Please select type">
                                                        <option value=""></option>
                                                        <?php
                                                        $rol = $company->get_all_company_roles($c['company_id']);
                                                        if ($rol->num_rows > 0) {
                                                            while ($row_rol = $rol->fetch_assoc()) {
                                                                ?>
                                                                <option value="<?=$row_rol['comp_role_sno'];?>" <?=($row['staff_role']==$row_rol['comp_role_sno'])?'selected':'';?>>
                                                                    <?=$row_rol['company_role_name'];?> (<?=$row_rol['role_alias'];?>)
                                                                </option>
                                                            <?php } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Status <span class="required">*</span></label>
                                                    <select class="form-control mb-3" name="stf_status" title="" required>
                                                        <option value="Active" <?=($row['staff_acc_status']=='Active')?'selected':'';?>>Active</option>
                                                        <option value="Deactivate" <?=($row['staff_acc_status']=='Deactivate')?'selected':'';?>>Deactivate</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <input class="btn btn-primary px-5" type="submit" value="Update Profile" />
                                            </div>
                                        </div>
                                    </footer>
                                </form>
                            </div>
                            <!-- Guarantor's Info -->
                            <div id="guaranInfo" class="tab-pane">
                                <form name="update_staff_guarantor_info" id="update_staff_guarantor_info">
                                    <div class="card-body">
                                        <div id="response-alert"></div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-2">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-title">Title</label>
                                                <select class="form-control populate" name="guarantor_title" id="w1-guarantor-title" >
                                                    <option value="<?=$row['staff_guarantor_title'];?>"><?=$row['staff_guarantor_title'];?></option>
                                                    <option value="Mr">Mr.</option>
                                                    <option value="Miss">Miss</option>
                                                    <option value="Mrs">Mrs.</option>
                                                </select>
                                                <input type="hidden" name="staff_sno" value="<?=$row['staff_sno'];?>" />
                                                <input type="hidden" name="staff_id" value="<?=$row['staff_id'];?>" />
                                                <input type="hidden" name="email" class="form-control" title="Please enter email address" value="<?=$row['staff_email'];?>" />

                                            </div>
                                            <div class="col-lg-4">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-firstname">Guarantor First Name</label>
                                                <input type="text" class="form-control"  name="guarantor_first_name" id="w1-guarantor-firstname" value="<?=$row['staff_guarantor_fname'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-middlename">Middle Name</label>
                                                <input type="text" class="form-control"  name="guarantor_middle_name" id="w1-guarantor-middlename" value="<?=$row['staff_guarantor_mname'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-lastname">Last Name</label>
                                                <input type="text" class="form-control"  name="guarantor_last_name" id="w1-guarantor-lastname" value="<?=$row['staff_guarantor_lname'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-sex">Sex</label>
                                                <select class="form-control mb-3" name="guarantor_sex" title="Required" >
                                                    <option value=""></option>
                                                    <option value="M" <?=($row['staff_guarantor_sex']=='M')?'selected':'';?>>Male</option>
                                                    <option value="F" <?=($row['staff_guarantor_sex']=='F')?'selected':'';?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-phone">Phone</label>
                                                <input type="text" class="form-control" name="guarantor_phone" id="w1-guarantor-phone" value="<?=$row['staff_guarantor_phone'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-email">Email</label>
                                                <input type="email" class="form-control" name="guarantor_email" id="w1-guarantor-email" value="<?=$row['staff_guarantor_email'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-12">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-address">Home Address</label>
                                                <input type="text" class="form-control"  name="guarantor_address" id="w1-guarantor-address" value="<?=$row['staff_guarantor_add'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-years-relationship">Years of Relationship</label>
                                                <input type="number" class="form-control" name="guarantor_years_of_relationship" id="w1-guarantor-years-relationship" value="<?=$row['staff_guarantor_yr_or'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-place-of-work">Place of work</label>
                                                <input type="text" class="form-control" name="guarantor_place_of_work" id="w1-guarantor-place-of-work" value="<?=$row['staff_guarantor_wk_pl'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-rank">Rank</label>
                                                <input type="text" class="form-control" name="guarantor_rank" id="w1-guarantor-rank" value="<?=$row['staff_guarantor_rank'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-ID-crd">ID Card Type</label>
                                                <select class="form-control populate" name="guarantor_id_Type" id="w1-guarantor-ID-crd" >
                                                    <option value=""></option>
                                                    <option value="International Passport" <?=($row['staff_guarantor_id_type']=='International Passport')?'selected':'';?>>International Passport</option>
                                                    <option value="Drivers License" <?=($row['staff_guarantor_id_type']=='Drivers License')?'selected':'';?>>Driver’s License</option>
                                                    <option value="Voters Card" <?=($row['staff_guarantor_id_type']=='Voters Card')?'selected':'';?>>Voter’s Card</option>
                                                    <option value="National ID Card" <?=($row['staff_guarantor_id_type']=='National ID Card')?'selected':'';?>>National ID Card</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-8">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-work-address">Work Address</label>
                                                <input type="text" class="form-control"  name="guarantor_work_address" id="w1-guarantor-work-address" value="<?=$row['staff_guarantor_wk_add'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-4">
                                                <label class="control-label pt-1" for="w1-guarantor-photo">Guarantor Photo</label>
                                                <input type="file" class="form-control" name="edit_guarantor_photo" id="w1-guarantor-photo">
                                                <input type="hidden" name="guarantor_photo" value="<?=$row['staff_guarantor_id_photo'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorPhoto">View Image</a>
                                                <div id="guarantorPhoto" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/staff/'.$row['staff_guarantor_id_photo']);?>" alt="" class="img-thumbnail">
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
                                                <input type="hidden" name="guarantor_id_front" value="<?=$row['staff_guarantor_id_front'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDFront">View Image</a>
                                                <div id="guarantorIDFront" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/staff/'.$row['staff_guarantor_id_front']);?>" alt="" class="img-thumbnail">
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
                                                <input type="hidden" name="guarantor_id_back" value="<?=$row['staff_guarantor_id_back'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDBack">View Image</a>
                                                <div id="guarantorIDBack" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/staff/'.$row['staff_guarantor_id_back']);?>" alt="" class="img-thumbnail">
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
                                                    <option value="<?=$row['staff_guarantor_title_2'];?>"><?=$row['staff_guarantor_title_2'];?></option>
                                                    <option value="Mr">Mr.</option>
                                                    <option value="Miss">Miss</option>
                                                    <option value="Mrs">Mrs.</option>
                                                </select>
                                                <input type="hidden" name="id" value="<?=$row['id'];?>" />
                                                <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-firstname-2">Guarantor First Name 2</label>
                                                <input type="text" class="form-control"  name="guarantor_first_name_2" id="w1-guarantor-firstname-2" value="<?=$row['staff_guarantor_fname_2'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-middlename-2">Middle Name 2</label>
                                                <input type="text" class="form-control"  name="guarantor_middle_name_2" id="w1-guarantor-middlename-2" value="<?=$row['staff_guarantor_mname_2'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-lastname-2">Last Name 2</label>
                                                <input type="text" class="form-control"  name="guarantor_last_name_2" id="w1-guarantor-lastname-2" value="<?=$row['staff_guarantor_lname_2'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-sex-2">Sex 2</label>
                                                <select class="form-control mb-3" name="guarantor_sex_2" title="Required" >
                                                    <option value=""></option>
                                                    <option value="M" <?=($row['staff_guarantor_sex_2']=='M')?'selected':'';?>>Male</option>
                                                    <option value="F" <?=($row['staff_guarantor_sex_2']=='F')?'selected':'';?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-phone-2">Phone 2</label>
                                                <input type="text" class="form-control" name="guarantor_phone_2" id="w1-guarantor-phone-2" value="<?=$row['staff_guarantor_phone_2'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-email-2">Email 2</label>
                                                <input type="email" class="form-control" name="guarantor_email_2" id="w1-guarantor-email-2" value="<?=$row['staff_guarantor_email_2'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-12">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-address-2">Home Address</label>
                                                <input type="text" class="form-control"  name="guarantor_address_2" id="w1-guarantor-address-2" value="<?=$row['staff_guarantor_add_2'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-years-relationship-2">Years of Relationship 2</label>
                                                <input type="number" class="form-control" name="guarantor_years_of_relationship_2" id="w1-guarantor-years-relationship-2" value="<?=$row['staff_guarantor_yr_or_2'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-place-of-work-2">Place of work 2</label>
                                                <input type="text" class="form-control" name="guarantor_place_of_work_2" id="w1-guarantor-place-of-work-2" value="<?=$row['staff_guarantor_wk_pl_2'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-rank-2">Rank 2</label>
                                                <input type="text" class="form-control" name="guarantor_rank_2" id="w1-guarantor-rank-2" value="<?=$row['staff_guarantor_rank_2'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-ID-crd-2">ID Card Type 2</label>
                                                <select class="form-control populate" name="guarantor_id_Type_2" id="w1-guarantor-ID-crd-2" >
                                                    <option value=""></option>
                                                    <option value="International Passport" <?=($row['staff_guarantor_id_type_2']=='International Passport')?'selected':'';?>>International Passport</option>
                                                    <option value="Drivers License" <?=($row['staff_guarantor_id_type_2']=='Drivers License')?'selected':'';?>>Driver’s License</option>
                                                    <option value="Voters Card" <?=($row['staff_guarantor_id_type_2']=='Voters Card')?'selected':'';?>>Voter’s Card</option>
                                                    <option value="National ID Card" <?=($row['staff_guarantor_id_type_2']=='National ID Card')?'selected':'';?>>National ID Card</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-8">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-work-address-2">Work Address 2</label>
                                                <input type="text" class="form-control"  name="guarantor_work_address_2" id="w1-guarantor-work-address-2" value="<?=$row['staff_guarantor_wk_add_2'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-4">
                                                <label class="control-label pt-1" for="w1-guarantor-photo-2">Guarantor Photo 2</label>
                                                <input type="file" class="form-control" name="edit_guarantor_photo_2" id="w1-guarantor-photo-2">
                                                <input type="hidden" name="guarantor_photo_2" value="<?=$row['staff_guarantor_photo_2'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorPhoto-2">View Image</a>
                                                <div id="guarantorPhoto-2" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/staff/'.$row['staff_guarantor_photo_2']);?>" alt="" class="img-thumbnail">
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
                                                <input type="hidden" name="guarantor_id_front_2" value="<?=$row['staff_guarantor_id_front_2'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDFront-2">View Image</a>
                                                <div id="guarantorIDFront-2" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/staff/'.$row['staff_guarantor_id_front_2']);?>" alt="" class="img-thumbnail">
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
                                                <input type="hidden" name="guarantor_id_back_2" value="<?=$row['staff_guarantor_id_back_2'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDBack-2">View Image</a>
                                                <div id="guarantorIDBack-2" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/staff/'.$row['staff_guarantor_id_back_2']);?>" alt="" class="img-thumbnail">
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
                                                    <option value="<?=$row['staff_guarantor_title_3'];?>"><?=$row['staff_guarantor_title_3'];?></option>
                                                    <option value="Mr">Mr.</option>
                                                    <option value="Miss">Miss</option>
                                                    <option value="Mrs">Mrs.</option>
                                                </select>
                                                <input type="hidden" name="id" value="<?=$row['id'];?>" />
                                                <input type="hidden" name="guard_id" value="<?=$row['guard_id'];?>" />
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-firstname-3">Guarantor First Name 3</label>
                                                <input type="text" class="form-control"  name="guarantor_first_name_3" id="w1-guarantor-firstname-3" value="<?=$row['staff_guarantor_fname_3'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-middlename-3">Middle Name 3</label>
                                                <input type="text" class="form-control"  name="guarantor_middle_name_3" id="w1-guarantor-middlename-3" value="<?=$row['staff_guarantor_mname_3'];?>" >
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-lastname-3">Last Name 3</label>
                                                <input type="text" class="form-control"  name="guarantor_last_name_3" id="w1-guarantor-lastname-3" value="<?=$row['staff_guarantor_lname_3'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-sex-3">Sex 3</label>
                                                <select class="form-control mb-3" name="guarantor_sex_3" title="Required" >
                                                    <option value=""></option>
                                                    <option value="M" <?=($row['staff_guarantor_sex_3']=='M')?'selected':'';?>>Male</option>
                                                    <option value="F" <?=($row['staff_guarantor_sex_3']=='F')?'selected':'';?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-phone-3">Phone 3</label>
                                                <input type="text" class="form-control" name="guarantor_phone_3" id="w1-guarantor-phone-3" value="<?=$row['staff_guarantor_phone_3'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-email-3">Email 3</label>
                                                <input type="email" class="form-control" name="guarantor_email_3" id="w1-guarantor-email-3" value="<?=$row['staff_guarantor_email_3'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-12">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-address-3">Home Address</label>
                                                <input type="text" class="form-control"  name="guarantor_address_3" id="w1-guarantor-address-3" value="<?=$row['staff_guarantor_add_3'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-years-relationship-3">Years of Relationship 3</label>
                                                <input type="number" class="form-control" name="guarantor_years_of_relationship_3" id="w1-guarantor-years-relationship-3" value="<?=$row['staff_guarantor_yr_or_3'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-place-of-work-3">Place of work 3</label>
                                                <input type="text" class="form-control" name="guarantor_place_of_work_3" id="w1-guarantor-place-of-work-3" value="<?=$row['staff_guarantor_wk_pl_3'];?>" >
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-rank-3">Rank 3</label>
                                                <input type="text" class="form-control" name="guarantor_rank_3" id="w1-guarantor-rank-3" value="<?=$row['staff_guarantor_rank_3'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-4">
                                                <label class="control-label pt-1" for="w1-guarantor-ID-crd-3">ID Card Type 3</label>
                                                <select class="form-control populate" name="guarantor_id_Type_3" id="w1-guarantor-ID-crd-3" >
                                                    <option value=""></option>
                                                    <option value="International Passport" <?=($row['staff_guarantor_id_type_3']=='International Passport')?'selected':'';?>>International Passport</option>
                                                    <option value="Drivers License" <?=($row['staff_guarantor_id_type_3']=='Drivers License')?'selected':'';?>>Driver’s License</option>
                                                    <option value="Voters Card" <?=($row['staff_guarantor_id_type_3']=='Voters Card')?'selected':'';?>>Voter’s Card</option>
                                                    <option value="National ID Card" <?=($row['staff_guarantor_id_type_3']=='National ID Card')?'selected':'';?>>National ID Card</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-8">
                                                <label class="control-label text-sm-end pt-1" for="w1-guarantor-work-address-3">Work Address 3</label>
                                                <input type="text" class="form-control"  name="guarantor_work_address_3" id="w1-guarantor-work-address-3" value="<?=$row['staff_guarantor_wk_add_3'];?>" >
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-4">
                                                <label class="control-label pt-1" for="w1-guarantor-photo-3">Guarantor Photo 3</label>
                                                <input type="file" class="form-control" name="edit_guarantor_photo_3" id="w1-guarantor-photo-3">
                                                <input type="hidden" name="guarantor_photo_3" value="<?=$row['staff_guarantor_photo_3'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorPhoto-3">View Image</a>
                                                <div id="guarantorPhoto-3" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/staff/'.$row['staff_guarantor_photo_3']);?>" alt="" class="img-thumbnail">
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
                                                <input type="hidden" name="guarantor_id_front_3" value="<?=$row['staff_guarantor_id_front_3'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDFront-3">View Image</a>
                                                <div id="guarantorIDFront-3" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/staff/'.$row['staff_guarantor_id_front_3']);?>" alt="" class="img-thumbnail">
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
                                                <input type="hidden" name="guarantor_id_back_3" value="<?=$row['staff_guarantor_id_back_3'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#guarantorIDBack-3">View Image</a>
                                                <div id="guarantorIDBack-3" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/staff/'.$row['staff_guarantor_id_back_3']);?>" alt="" class="img-thumbnail">
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
                                                <input class="btn btn-primary px-5" type="submit" value="Update Profile" />
                                            </div>
                                        </div>
                                    </footer>
                                </form>
                            </div>
                            <!-- Next of Kin -->
                            <div id="kinInfo" class="tab-pane">
                                <form name="update_staff_next_of_kin_info" id="update_staff_next_of_kin_info">
                                    <div class="card-body">
                                        <div id="response-alert"></div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">First Name <span class="required">*</span></label>
                                                    <input type="text" name="kinfirstname" class="form-control" title="Please enter firstname" value="<?=$row['next_kin_firstname'] ;?>" />
                                                    <input type="hidden" name="staff_sno" value="<?=$row['staff_sno'];?>" />
                                                    <input type="hidden" name="staff_id" value="<?=$row['staff_id'];?>" />
                                                    <input type="hidden" name="email" class="form-control" title="Please enter email address" value="<?=$row['staff_email'];?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Middle Name</label>
                                                    <input type="text" name="kinMiddlename" class="form-control" title="Please enter middlename" value="<?=$row['next_kin_middlename'] ;?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Last Name <span class="required">*</span></label>
                                                    <input type="text" name="kinLastname" class="form-control" title="Please enter lastname" value="<?=$row['next_kin_lastname'] ;?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Gender <span class="required">*</span></label>
                                                    <select class="form-control mb-3" name="kinGender" title="" required>
                                                        <option value="Male" <?=($row['next_kin_gender']=='Male')?'selected':'';?>>Male</option>
                                                        <option value="Female" <?=($row['next_kin_gender']=='Female')?'selected':'';?>>Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group pb-3">

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Phone number <span class="required">*</span></label>
                                                    <input type="tel" name="kinPhone" class="form-control" title="Please enter phone number" value="<?=$row['next_kin_phone'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Relationship <span class="required">*</span></label>
                                                    <input type="text" name="kinRel" class="form-control" title="Please enter relationship" value="<?=$row['next_kin_relationship'] ;?>" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <footer class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <input class="btn btn-primary px-5" type="submit" value="Update Profile" />
                                            </div>
                                        </div>
                                    </footer>
                                </form>
                            </div>
                            <!-- Account Info -->
                            <div id="accInfo" class="tab-pane">
                                <form name="update_staff_acc_info" id="update_staff_acc_info">
                                    <div class="card-body">
                                        <div id="response-alert"></div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Bank <span class="required">*</span></label>
                                                    <input type="text" name="accBnk" class="form-control" title="Please enter bank" value="<?=$row['staff_bank'] ;?>" readonly/>
                                                    <input type="hidden" name="staff_sno" value="<?=$row['staff_sno'];?>" />
                                                    <input type="hidden" name="staff_id" value="<?=$row['staff_id'];?>" />
                                                    <input type="hidden" name="email" class="form-control" title="Please enter email address" value="<?=$row['staff_email'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Account Name <span class="required">*</span></label>
                                                    <input type="text" name="accName" class="form-control" title="Please enter account name" value="<?=$row['staff_firstname'].' '.$row['staff_lastname'] ;?>" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Account Number <span class="required">*</span></label>
                                                    <input type="text" name="accNo" class="form-control" title="Please enter account number" value="<?=$row['staff_account_number'] ;?>" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Salary <span class="required">*</span></label>
                                                    <input type="text" name="salary" class="form-control" title="Please enter salary" value="<?=$row['staff_salary'] ;?>" readonly/>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <footer class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <input class="btn btn-primary px-5" type="submit" value="Update Profile" />
                                            </div>
                                        </div>
                                    </footer>
                                </form>
                            </div>
                            <!-- Files Info -->
                            <div id="allFiles" class="tab-pane">
                                <form name="all_stf_files" id="all_stf_files">
                                    <div class="card-body">
                                        <div id="response-alert"></div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Staff Photo <span class="required">*</span></label>
                                                    <input type="file" name="stf_photo" class="form-control" value="<?=$row['staff_photo'] ;?>" id="w1-photo"/>
                                                    <input type="hidden" name="staff_sno" value="<?=$row['staff_sno'];?>" />
                                                    <input type="hidden" name="staff_id" value="<?=$row['staff_id'];?>" />
                                                    <input type="hidden" name="staff_name" value="<?=$row['staff_firstname'];?>" />
                                                    <input type="hidden" name="staff_photo" value="<?=$row['staff_photo'];?>" />
                                                    <a class="mb-1 mt-1 me-1 modal-basic" href="#staffPhoto">View Image</a>
                                                    <div id="staffPhoto" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                        <section class="card">
                                                            <div class="card-body">
                                                                <div class="modal-wrapper">
                                                                    <div class="modal-text">
                                                                        <img src="<?=public_path('uploads/staff/'.$row['staff_photo']);?>" alt="" class="img-thumbnail">
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
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-12">
                                                <label class="control-label pt-1" for="w1-stf-sign">Staff Signature <span class="required">*</span></label>
                                                <input type="file" class="form-control" name="stf_sgn" id="w1-stf-sign">
                                                <input type="hidden" name="staff_signature" value="<?=$row['staff_signature'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#staffSignature">View Image</a>
                                                <div id="staffSignature" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/staff/'.$row['staff_signature']);?>" alt="" class="img-thumbnail">
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
                                                <input class="btn btn-primary px-5" type="submit" value="Update Profile" />
                                            </div>
                                        </div>
                                    </footer>
                                </form>
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
                        <form id="photo_cam_update" name="photo_cam_update">
                            <input type="hidden" name="dataurl" id="dataurl" required/>
                            <input type="hidden" name="staff_id" id="staff_id" value="<?= $row['staff_id'] ?>" />
                            <input type="hidden" name="sname" id="sname" value="<?= $row['staff_firstname'] ?>" />
                            <input type="hidden" name="sphone" id="sphone" value="<?= $row['staff_phone'] ?>" />
                        </form>
                        <div class="text-center mt-2">
                            <button class="btn btn-xs btn-default" id="captureBtn" onclick="addCamPicture()">Capture</button>
                            <button class="btn btn-xs btn-danger pl-3" id="resetBtn">Clear&reset</button>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button class="btn btn-primary" id="savePP_Profile">Save Photo</button>
                                <button class="btn btn-default modal-dismiss">Close</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </div>

        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>
<script src=<?= public_path("js/examples/examples.modals.js"); ?>></script>
<script src=<?= public_path("js/webcam.js"); ?>></script>
<script>
    $('#propicxUpload').click(function(){ $('#staff_profile_picx_update').trigger('click'); });
</script>
<script>
    $(function() {
        $("input[name='loan_amount']").on('input', function(e) {$(this).val($(this).val().replace(/[^0-9]/g, ''));});
        $("input[name='loan_duration']").on('input', function(e) {$(this).val($(this).val().replace(/[^0-9]/g, ''));});
    });
</script>
<script>
    var inputs = $('#stf_issue_loan').find('input[name="loan_duration"]');
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

    var inputs = $('#stf_issue_loan').find('input[name="loan_amount"]');
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
</script>
<script>
    if ($("#stfStat").val() === 'Deactivate') {
        $(".eligible_div").show();
    } else {
        $(".eligible_div").hide();
    }
    $('select[name="stfStat"]').change(function(){
        var selected = $(this).val();
        if (selected === 'Deactivate'){
            $(".eligible_div").show();
        } else {
            $(".eligible_div").hide();
        }
    });
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