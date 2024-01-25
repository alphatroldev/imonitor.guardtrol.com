<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Staff Registration</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Staff Registration</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card form-wizard" id="w1">
        <header class="card-header">
            <h2 class="card-title">New Staff</h2>
        </header>
        <div class="card-body card-body-nopadding">
            <div class="wizard-tabs">
                <ul class="nav wizard-steps">
                    <li class="nav-item active">
                        <a data-bs-target="#w1-basic-info" data-bs-toggle="tab" class="nav-link text-center">
                            <span class="badge">1</span>
                            Basic Info.
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-bs-target="#w1-guarantor-info" data-bs-toggle="tab" class="nav-link text-center">
                            <span class="badge">2</span>
                            Guarantor's Info.
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-bs-target="#w1-next-of-kin-info" data-bs-toggle="tab" class="nav-link text-center">
                            <span class="badge">3</span>
                            Next of Kin Info.
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-bs-target="#w1-confirm" data-bs-toggle="tab" class="nav-link text-center">
                            <span class="badge">4</span>
                            Account Info.
                        </a>
                    </li>
                </ul>
            </div>
            <form class="form-horizontal" name="create_staff" id="create_staff">
                <div class="tab-content">
                    <div id="response-alert"></div>
                    <div id="w1-basic-info" class="tab-pane p-3 active">
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label text-sm-end pt-1" for="w1-firstname">First name</label>
                                <input type="text" class="form-control"  name="stf_f_name" id="w1-firstname" required>
                            </div>

                            <div class="col-sm-6">
                                <label class="control-label text-sm-end pt-1" for="w1-lastname">Last name</label>
                                <input type="text" class="form-control" name="stf_l_name" id="w1-lastname" required>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-4">
                                <label class="control-label text-sm-end pt-1" for="w1-middlename">Middle name</label>
                                <input type="text" class="form-control" name="stf_m_name" id="w1-middlename">
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label pt-1" for="w1-gender">Gender</label>
                                <select class="form-control populate" name="stf_gender" id="w1-gender" required>
                                    <option value=""></option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label pt-1" for="w1-dob">DOB</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="text" data-plugin-datepicker class="form-control" name="stf_dob" id="w1-dob" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w1-home_addr">Home Address</label>
                                <input type="text" class="form-control" name="stf_home_addr" id="w1-home_addr" required>
                            </div>

                            <div class="col-sm-6">
                                <label class="control-label text-sm-end pt-1" for="w1-height">Height (ft)</label>
                                <select class="form-control" name="stf_height" id="w1-height">
                                    <option value=""></option>
                                    <option value="5.1">5.1</option>
                                    <option value="5.2">5.2</option>
                                    <option value="5.3">5.3</option>
                                    <option value="5.4">5.4</option>
                                    <option value="5.5">5.5</option>
                                    <option value="5.6">5.6</option>
                                    <option value="5.7">5.7</option>
                                    <option value="5.8">5.8</option>
                                    <option value="5.9">5.9</option>
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
                                </select>
                            </div>
                        </div>

                        <div class="form-group row pb-3">
                            <div class="col-sm-4">
                                <label class="control-label text-sm-end pt-1" for="w1-blood_group">Blood Group</label>
                                <select class="form-control populate" name="stf_blood_grp" id="w1-blood_group" required>
                                    <option value=""></option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label text-sm-end pt-1" for="w1-religion">Religion</label>
                                <select class="form-control populate" name="stf_religion" id="w1-religion" required>
                                    <option value=""></option>
                                    <option value="Christianity">Christianity</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Other Religions">Other Religions</option>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="control-label pt-1" for="w1-home_addr">Marital Status</label>
                                <select class="form-control populate" name="stf_marital_stat" id="w1-home_addr" required>
                                    <option value=""></option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Separated">Separated</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w1-phone">Phone</label>
                                <input type="text" class="form-control" name="stf_phone" id="w1-phone" minlength="11" maxlength="11" required>
                            </div>

                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w1-role">Role</label>
                                <select class="form-control populate" name="stf_role" id="w1-role" required>
                                    <option value=""></option>
                                    <?php
                                    $res = $company->get_all_company_roles($c['company_id']);
                                    if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                            ?>
                                            <option value="<?= $row['comp_role_sno'];?>"><?= $row['company_role_name'];?> (<?= $row['role_alias'];?>)</option>
                                        <?php } } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w1-email">Email</label>
                                <input type="email" class="form-control" name="stf_email" id="w1-email" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label text-sm-end pt-1" for="w1-qualification">Qualifications</label>
                                <select class="form-control populate" name="stf_qualification" id="w1-qualification">
                                    <option value=""></option>
                                    <option value="SSCE">SSCE</option>
                                    <option value="NCE">NCE</option>
                                    <option value="OND">OND</option>
                                    <option value="HND">HND</option>
                                    <option value="BSc">BSc</option>
                                    <option value="MSc">MSc</option>
                                    <option value="PhD">PhD</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w1-password">Password</label>
                                <input type="password" class="form-control" name="stf_password" id="w1-password" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w1-password2">Repeat Password</label>
                                <input type="password" class="form-control" name="stf_r_password" id="w1-password2" required>
                            </div>
                        </div>

                        <div class="form-group row pb-3">
                            <label class="control-label pt-1" for="w1-photo">Photo</label>
                            <div class="col-sm-12">
                                <input type="file" class="form-control" name="stf_photo" id="w1-photo" required>
                            </div>
                        </div>
                    </div>
                    <!-- Guarantor's Info -->
                    <div id="w1-guarantor-info" class="tab-pane p-3">
                        <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 10px;" class="listing-more">
                            <div>
                                <div class="form-group row pb-3">
                                    <div class="col-sm-2">
                                        <label class="control-label text-sm-end pt-1" for="w1-guarantor-title-1">Guarantor Title</label>
                                        <select class="form-control populate" name="guarantor_title[]" id="w1-guarantor-title-1">
                                            <option value=""></option>
                                            <option value="Mr">Mr.</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Mrs">Mrs.</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label text-sm-end pt-1" for="w1-guarantor-firstname-1">Guarantor Firstname</label>
                                        <input type="text" class="form-control"  name="guarantor_first_name[]" id="w1-guarantor-firstname-1">
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label text-sm-end pt-1" for="w1-guarantor-middlename-1">Guarantor Middlename</label>
                                        <input type="text" class="form-control"  name="guarantor_middle_name[]" id="w1-guarantor-middlename-1">
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label text-sm-end pt-1" for="w1-guarantor-lastname-1">Guarantor Lastname</label>
                                        <input type="text" class="form-control"  name="guarantor_last_name[]" id="w1-guarantor-lastname-1">
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-sm-2">
                                        <label class="control-label pt-1" for="w1-guarantor-sex-1">Sex</label>
                                        <select class="form-control populate" name="guarantor_sex[]" id="w1-guarantor-sex-1" >
                                            <option value=""></option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label pt-1" for="w1-guarantor-phone-1">Phone</label>
                                        <input type="text" class="form-control" name="guarantor_phone[]" id="w1-guarantor-phone-1" minlength="11" maxlength="11">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label pt-1" for="w1-guarantor-email-1">Email</label>
                                        <input type="email" class="form-control" name="guarantor_email[]" id="w1-guarantor-email-1" >
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label pt-1" for="w1-guarantor-years-relationship-1">Years of Relationship</label>
                                        <input type="number" class="form-control" name="guarantor_years_of_relationship[]" id="w1-guarantor-years-relationship-1" >
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-sm-3">
                                        <label class="control-label pt-1" for="w1-guarantor-place-of-work-1">Place of work</label>
                                        <input type="text" class="form-control" name="guarantor_place_of_work[]" id="w1-guarantor-place-of-work-1" >
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label pt-1" for="w1-guarantor-rank-1">Rank</label>
                                        <input type="text" class="form-control" name="guarantor_rank[]" id="w1-guarantor-rank-1" >
                                    </div>
                                    <div class="col-sm-7">
                                        <label class="control-label text-sm-end pt-1" for="w1-guarantor-address-1">Home Address</label>
                                        <input type="text" class="form-control"  name="guarantor_address[]" id="w1-guarantor-address-1" >
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-sm-4">
                                        <label class="control-label pt-1" for="w1-guarantor-photo-1">Guarantor Photo</label>
                                        <input type="file" class="form-control" name="guarantor_photo[]" id="w1-guarantor-photo-1" >
                                    </div>
                                    <div class="col-sm-8">
                                        <label class="control-label text-sm-end pt-1" for="w1-guarantor-work-address-1">Work Address</label>
                                        <input type="text" class="form-control"  name="guarantor_work_address[]" id="w1-guarantor-work-address-1" >
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-sm-4">
                                        <label class="control-label pt-1" for="w1-guarantor-ID-crd-1">ID Card Type</label>
                                        <select class="form-control populate" name="guarantor_id_Type[]" id="w1-guarantor-ID-crd-1" >
                                            <option value=""></option>
                                            <option value="International Passport">International Passport</option>
                                            <option value="Drivers License">Driver’s License</option>
                                            <option value="Voters Card">Voter’s Card</option>
                                            <option value="National ID Card">National ID Card</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label pt-1" for="w1-guarantor-ID-crd-frnt-1">ID Card Front</label>
                                        <input type="file" class="form-control" name="guarantor_crd_frnt[]" id="w1-guarantor-ID-crd-frnt-1" >
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label pt-1" for="w1-guarantor-Id-crd-bck-1">ID Card Back</label>
                                        <input type="file" class="form-control" name="guarantor_crd_bck[]" id="w1-guarantor-Id-crd-bck-1" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-default btn-xs add_more_guarantor_info">
                            <i class="fas fa-plus">&nbsp;</i> Add more guarantor
                        </a>
                    </div>
                    <!-- Next of Kin -->
                    <div id="w1-next-of-kin-info" class="tab-pane p-3">
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label text-sm-end pt-1" for="w1-kin-firstname">First name</label>
                                <input type="text" class="form-control" name="kin_f_name" id="w1-kin-firstname" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label text-sm-end pt-1" for="w1-kin-middlename">Middle name</label>
                                <input type="text" class="form-control" name="kin_m_name" id="w1-kin-middlename">
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label text-sm-end pt-1" for="w1-kin-lastname">Last name</label>
                                <input type="text" class="form-control" name="kin_l_name" id="w1-kin-lastname" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w1-kin-gender">Gender</label>
                                <select class="form-control populate" name="kin_gender" id="w1-kin-gender" required>
                                    <option value=""></option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <label class="control-label pt-1" for="w1-kin_home_addr">Home Address</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="kin_home_addr" id="w1-kin_home_addr" required>
                            </div>
                        </div>

                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w1-kin-phone">Phone</label>
                                <input type="text" class="form-control" name="kin_phone" id="w1-kin-phone" minlength="11" maxlength="11" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pt-2" for="w1-kin-rel">Relationship</label>
                                <input type="text" class="form-control" name="kin_rel" id="w1-kin-rel" required>
                            </div>
                        </div>
                    </div>
                    <!-- Account Details -->
                    <div id="w1-confirm" class="tab-pane p-3">
                        <div class="form-group row pb-3">
                            <label class="control-label pt-1" for="w1-stf-bank">Bank</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="stf_bank" id="w1-stf-bank" required>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <label class="control-label pt-1" for="w1-stf-acc-name">Account Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="stf_acc_name" id="w1-stf-acc-name" readonly required>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <label class="control-label pt-1" for="w1-stf-acc-no">Account Number</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="stf_acc_no" id="w1-stf-acc-no" minlength="10" maxlength="10" required>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w1-stf-salary">Salary</label>
                                <input type="text" class="form-control" name="stf_salary" id="w1-stf-salary" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w1-stf-sign">Staff Signature</label>
                                <input type="file" class="form-control" name="stf_sgn" id="w1-stf-sign" required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <ul class="pager">
                <li class="previous disabled"><a><i class="fas fa-angle-left"></i> Previous</a></li>
                <li class="finish hidden float-end">
                    <input type="submit" value="Register" id="register" style="display: inline-block;padding: 5px 14px; background-color: #fff;border: 1px solid #ddd;border-radius: 15px;">
                </li>
                <li class="next"><a>Next <i class="fas fa-angle-right"></i></a></li>
            </ul>
        </div>
    </section>
</section>
<?php include_once("inc/footer.staff.php"); ?>
<script>
    $('.content-body').on('blur', '#w1-lastname',function(){
        const lastname = $('#w1-lastname').val();
        const firstname = $('#w1-firstname').val();
        $('#w1-stf-acc-name').val(lastname + ' ' + firstname);

    })
</script>
<script>
    $(document).ready(function () {
        var count = 1;
        $(".content-body").on('click', '.add_more_guarantor_info', function (e) {
            ++count;
            if (count >3){
                return false;
            } else {
                $('.listing-more').append('<div style="border-top: 1px solid #ccc;margin-top:10px;" id="dynamic_field'+count+'">' +
                    '<div class="form-group row py-3">' +
                    '<div class="col-sm-2">' +
                    '<label class="control-label text-sm-end pt-1" for="w1-guarantor-title-'+count+'">Guarantor Title '+count+'</label>' +
                    '<select class="form-control populate" name="guarantor_title[]" id="w1-guarantor-title-'+count+'">' +
                    '<option value=""></option><option value="Mr">Mr.</option><option value="Miss">Miss</option>' +
                    '<option value="Mrs">Mrs.</option></select></div><div class="col-sm-4">' +
                    '<label class="control-label text-sm-end pt-1" for="w1-guarantor-firstname-'+count+'">Guarantor Firstname '+count+'</label>' +
                    '<input type="text" class="form-control"  name="guarantor_first_name[]" id="w1-guarantor-firstname-'+count+'">' +
                    '</div><div class="col-sm-3">' +
                    '<label class="control-label text-sm-end pt-1" for="w1-guarantor-middlename-'+count+'">Guarantor Middlename '+count+'</label>' +
                    '<input type="text" class="form-control"  name="guarantor_middle_name[]" id="w1-guarantor-middlename-'+count+'">' +
                    '</div><div class="col-sm-3">' +
                    '<label class="control-label text-sm-end pt-1" for="w1-guarantor-lastname-'+count+'">Guarantor Lastname '+count+'</label>' +
                    '<input type="text" class="form-control"  name="guarantor_last_name[]" id="w1-guarantor-lastname-'+count+'">' +
                    '</div></div><div class="form-group row pb-3"><div class="col-sm-2">' +
                    '<label class="control-label pt-1" for="w1-guarantor-sex-'+count+'">Sex</label>' +
                    '<select class="form-control populate" name="guarantor_sex[]" id="w1-guarantor-sex-'+count+'" >' +
                    '<option value=""></option><option value="M">Male</option><option value="F">Female</option></select>' +
                    '</div><div class="col-sm-3"><label class="control-label pt-1" for="w1-guarantor-phone-'+count+'">Phone '+count+'</label>' +
                    '<input type="text" class="form-control" name="guarantor_phone[]" id="w1-guarantor-phone-'+count+'" minlength="11" maxlength="11">' +
                    '</div><div class="col-sm-4"><label class="control-label pt-1" for="w1-guarantor-email-'+count+'">Email '+count+'</label>' +
                    '<input type="email" class="form-control" name="guarantor_email[]" id="w1-guarantor-email-'+count+'" ></div>' +
                    '<div class="col-sm-3"><label class="control-label pt-1" for="w1-guarantor-years-relationship-'+count+'">Years of Relationship '+count+'</label>' +
                    '<input type="number" class="form-control" name="guarantor_years_of_relationship[]" id="w1-guarantor-years-relationship-'+count+'" >' +
                    '</div></div><div class="form-group row pb-3"><div class="col-sm-3">' +
                    '<label class="control-label pt-1" for="w1-guarantor-place-of-work-'+count+'">Place of work '+count+'</label>' +
                    '<input type="text" class="form-control" name="guarantor_place_of_work[]" id="w1-guarantor-place-of-work-'+count+'" >' +
                    '</div><div class="col-sm-2"><label class="control-label pt-1" for="w1-guarantor-rank-'+count+'">Rank</label>' +
                    '<input type="text" class="form-control" name="guarantor_rank[]" id="w1-guarantor-rank-'+count+'" >' +
                    '</div><div class="col-sm-7"><label class="control-label text-sm-end pt-1" for="w1-guarantor-address-'+count+'">Home Address '+count+'</label>' +
                    '<input type="text" class="form-control"  name="guarantor_address[]" id="w1-guarantor-address-'+count+'" >' +
                    '</div></div><div class="form-group row pb-3"><div class="col-sm-4">' +
                    '<label class="control-label pt-1" for="w1-guarantor-photo-'+count+'">Guarantor Photo '+count+'</label>' +
                    '<input type="file" class="form-control" name="guarantor_photo[]" id="w1-guarantor-photo-'+count+'" >' +
                    '</div><div class="col-sm-8"><label class="control-label text-sm-end pt-1" for="w1-guarantor-work-address-'+count+'">Work Address '+count+'</label>' +
                    '<input type="text" class="form-control"  name="guarantor_work_address[]" id="w1-guarantor-work-address-'+count+'">' +
                    '</div></div><div class="form-group row pb-3"><div class="col-sm-4">' +
                    '<label class="control-label pt-1" for="w1-guarantor-ID-crd-'+count+'">ID Card Type '+count+'</label>' +
                    '<select class="form-control populate" name="guarantor_id_Type[]" id="w1-guarantor-ID-crd-'+count+'" >' +
                    '<option value=""></option><option value="International Passport">International Passport</option>' +
                    '<option value="Drivers License">Driver’s License</option><option value="Voters Card">Voter’s Card</option>' +
                    '<option value="National ID Card">National ID Card</option></select></div><div class="col-sm-4">' +
                    '<label class="control-label pt-1" for="w1-guarantor-ID-crd-frnt-'+count+'">ID Card Front '+count+'</label>' +
                    '<input type="file" class="form-control" name="guarantor_crd_frnt[]" id="w1-guarantor-ID-crd-frnt-'+count+'" >' +
                    '</div><div class="col-sm-4"><label class="control-label pt-1" for="w1-guarantor-Id-crd-bck-'+count+'">ID Card Back '+count+'</label>' +
                    '<input type="file" class="form-control" name="guarantor_crd_bck[]" id="w1-guarantor-Id-crd-bck-'+count+'" >' +
                    '</div></div>' +
                    '<span><button class="btn btn-danger btn-xs btn_remove" id="' + count + '"><i class="fa fa-trash"></i> Remove</button></span></div>'
                );
            }
        });

        $(".content-body").on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");$('#dynamic_field'+button_id+'').remove();
            --count;
        });

    });
</script>