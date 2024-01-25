<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Register Guard</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Register Guard</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card form-wizard" id="w5">
        <header class="card-header">
            <h2 class="card-title">Guard Registration</h2>
        </header>
        <div class="card-body card-body-nopadding">
            <div class="wizard-tabs">
                <ul class="nav wizard-steps">
                    <li class="nav-item active">
                        <a data-bs-target="#w5-step-one" data-bs-toggle="tab" class="nav-link text-center">
                            <span class="badge">1</span>
                            Basic Info.
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-bs-target="#w5-step-two" data-bs-toggle="tab" class="nav-link text-center">
                            <span class="badge">2</span>
                            Guarantor's Info.
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-bs-target="#w5-step-three" data-bs-toggle="tab" class="nav-link text-center">
                            <span class="badge">3</span>
                            ID's & Account Info.
                        </a>
                    </li>

                </ul>
            </div>

            <form class="form-horizontal" name="register_guard" id="register_guard">
                <div class="tab-content">
                    <div id="response-alert"></div>
                    <!-- step one-->
                    <div id="w5-step-one" class="tab-pane p-3 active">
                        <div class="form-group row pb-3">
                            <div class="col-sm-4">
                                <label class="control-label text-sm-end pt-1" for="w5-guard_firstname">Guard Firstname<span class="required">*</span></label>
                                <input type="text" class="form-control"  name="guard_first_name" id="w5-guard_firstname" required>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label text-sm-end pt-1" for="w5-guard_middlename">Guard Middlename</label>
                                <input type="text" class="form-control"  name="guard_middle_name" id="w5-guard_middlename">
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label text-sm-end pt-1" for="w5-guard_lastname">Guard Lastname<span class="required">*</span></label>
                                <input type="text" class="form-control"  name="guard_last_name" id="w5-guard_lastname" required>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-3">
                                <label class="control-label pt-1" for="w5-guard-height">Height (ft)<span class="required">*</span></label>
                                <select class="form-control populate" name="guard_height" id="w5-guard-height" required>
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
                            <div class="col-sm-3">
                                <label class="control-label pt-1" for="w5-guard-sex">Sex<span class="required">*</span></label>
                                <select class="form-control populate" name="guard_sex" id="w5-guard-sex" required>
                                    <option value=""></option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label pt-1" for="w5-guard-phone">Phone<span class="required">*</span></label>
                                <input type="text" class="form-control" name="guard_phone" id="w5-guard-phone" minlength="11" maxlength="11" required>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label pt-1" for="w5-guard-alt-phone">Alternate Phone</label>
                                <input type="text" class="form-control" name="guard_alt_phone" id="w5-guard-alt-phone" minlength="11" maxlength="11">
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-3">
                                <label class="control-label pt-1" for="w5-state-of-origin">State of Origin<span class="required">*</span></label>
                                <select class="form-control populate" name="guard_state_of_origin" id="w5-state-of-origin" required>
                                    <option value="">State of Origin</option>
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
                                <label class="control-label pt-1" for="w5-guard-religion">Religion<span class="required">*</span></label>
                                <select class="form-control populate" name="guard_religion" id="w5-guard-religion" required>
                                    <option value=""></option>
                                    <option value="Christian">Christian</option>
                                    <option value="Muslim">Muslim</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label pt-1" for="w5-guard-qualification">Qualification<span class="required">*</span></label>
                                <select class="form-control populate" name="guard_qualification" id="w5-guard-qualification" required>
                                    <option value=""></option>
                                    <option value='SSCE'>SSCE</option>
                                    <option value='OND'>OND</option>
                                    <option value='HND'>HND</option>
                                    <option value='BSC'>BSC</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label pt-1" for="w5-guard-dob">Date of Birth<span class="required">*</span></label>
                                <input type="date" class="form-control" name="guard_dob" id="w5-guard-dob" required>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-12">
                                <label class="control-label pt-1" for="w5-referral">Referral<span class="required">*</span></label>
                                <select class="form-control populate" name="referral" id="w5-referral" required>
                                    <option value="">Who Referred You ?</option>
                                    <option value="Agent">Agent</option>
                                    <option value="Existing Guard">Existing Guard</option>
                                    <option value="Others">Others</option>
                                    <option value="Nobody">Nobody</option>
                                </select>
                            </div>
                        </div>
                        <div class="GuardReferralDiv">
                            <div class="form-group row pb-3">
                                <div class="col-sm-12">
                                    <label class="control-label text-sm-end pt-1" for="w5-referral-name">Referral Name<span class="required">*</span></label>
                                    <input type="text" class="form-control"  name="referral_name" id="w5-referral-name"/>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-12">
                                    <label class="control-label text-sm-end pt-1" for="w5-referral-address">Referral Address<span class="required">*</span></label>
                                    <input type="text" class="form-control"  name="referral_address" id="w5-referral-address">
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-6 GuardReferralDiv">
                                    <label class="control-label pt-1" for="w5-referral-phone">Referral Phone<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="referral_phone" id="w5-referral-phone" minlength="11" maxlength="11">
                                </div>
                                <div class="col-sm-6 AgentGuardReferralDiv">
                                    <label class="control-label pt-1" for="w5-referral-fee">Referral Fee<span class="required">*</span></label>
                                    <input type="number" class="form-control" name="referral_fee" id="w5-referral-fee">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-12">
                                <label class="control-label text-sm-end pt-1" for="w5-kin-fullname">Next of Kin Name<span class="required">*</span></label>
                                <input type="text" class="form-control"  name="guard_next_of_kin_name" id="w5-kin-fullname" required>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w5-kin-phone">Next of Kin Phone<span class="required">*</span></label>
                                <input type="text" class="form-control" name="guard_next_of_kin_phone" id="w5-kin-phone" minlength="11" maxlength="11" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w5-kin-relationship">Relationship<span class="required">*</span></label>
                                <input type="text" class="form-control" name="guard_next_of_kin_relationship" id="w5-kin-relationship" required>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-2">
                                <label class="control-label pt-1" for="w5-guard-nickname">Nickname</label>
                                <input type="text" class="form-control" name="guard_nickname" id="w5-guard-nickname">
                            </div>
                            <div class="col-sm-10">
                                <label class="control-label text-sm-end pt-1" for="w5-guard-address">Address<span class="required">*</span></label>
                                <input type="text" class="form-control"  name="guard_address" id="w5-guard-address" required>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-12">
                                <label class="control-label text-sm-end pt-1" for="w5-vetting">Vetting<span class="required">*</span></label>
                                <textarea class="form-control" rows="3" name="vetting" id="w5-vetting" required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- step 2 -->
                    <div id="w5-step-two" class="tab-pane p-3">
                        <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 10px;" class="listing-more">
                            <div>
                                <div class="form-group row pb-3">
                                    <div class="col-sm-2">
                                        <label class="control-label text-sm-end pt-1" for="w5-guarantor-title-1">Guarantor Title</label>
                                        <select class="form-control populate" name="guarantor_title[]" id="w5-guarantor-title-1">
                                            <option value=""></option>
                                            <option value="Mr">Mr.</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Mrs">Mrs.</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label text-sm-end pt-1" for="w5-guarantor-firstname-1">Guarantor Firstname</label>
                                        <input type="text" class="form-control"  name="guarantor_first_name[]" id="w5-guarantor-firstname-1">
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label text-sm-end pt-1" for="w5-guarantor-middlename-1">Guarantor Middlename</label>
                                        <input type="text" class="form-control"  name="guarantor_middle_name[]" id="w5-guarantor-middlename-1">
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label text-sm-end pt-1" for="w5-guarantor-lastname-1">Guarantor Lastname</label>
                                        <input type="text" class="form-control"  name="guarantor_last_name[]" id="w5-guarantor-lastname-1">
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-sm-2">
                                        <label class="control-label pt-1" for="w5-guarantor-sex-1">Sex</label>
                                        <select class="form-control populate" name="guarantor_sex[]" id="w5-guarantor-sex-1" >
                                            <option value=""></option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label pt-1" for="w5-guarantor-phone-1">Phone</label>
                                        <input type="text" class="form-control" name="guarantor_phone[]" id="w5-guarantor-phone-1" minlength="11" maxlength="11">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="control-label pt-1" for="w5-guarantor-email-1">Email</label>
                                        <input type="email" class="form-control" name="guarantor_email[]" id="w5-guarantor-email-1" >
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="control-label pt-1" for="w5-guarantor-years-relationship-1">Years of Relationship</label>
                                        <input type="number" class="form-control" name="guarantor_years_of_relationship[]" id="w5-guarantor-years-relationship-1" >
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-sm-3">
                                        <label class="control-label pt-1" for="w5-guarantor-place-of-work-1">Place of work</label>
                                        <input type="text" class="form-control" name="guarantor_place_of_work[]" id="w5-guarantor-place-of-work-1" >
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label pt-1" for="w5-guarantor-rank-1">Rank</label>
                                        <input type="text" class="form-control" name="guarantor_rank[]" id="w5-guarantor-rank-1" >
                                    </div>
                                    <div class="col-sm-7">
                                        <label class="control-label text-sm-end pt-1" for="w5-guarantor-address-1">Home Address</label>
                                        <input type="text" class="form-control"  name="guarantor_address[]" id="w5-guarantor-address-1" >
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-sm-4">
                                        <label class="control-label pt-1" for="w5-guarantor-ID-crd-1">ID Card Type</label>
                                        <select class="form-control populate" name="guarantor_id_Type[]" id="w5-guarantor-ID-crd-1" >
                                            <option value=""></option>
                                            <option value="International Passport">International Passport</option>
                                            <option value="Drivers License">Driver’s License</option>
                                            <option value="Voters Card">Voter’s Card</option>
                                            <option value="National ID Card">National ID Card</option>
                                            <option value="Valid Work ID Card">Valid Work ID Card</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-8">
                                        <label class="control-label text-sm-end pt-1" for="w5-guarantor-work-address-1">Work Address</label>
                                        <input type="text" class="form-control"  name="guarantor_work_address[]" id="w5-guarantor-work-address-1" >
                                    </div>
                                </div>
                                <div class="form-group row pb-3">

                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-default btn-xs add_more_guarantor_info">
                            <i class="fas fa-plus">&nbsp;</i> Add more guarantor
                        </a>
                    </div>
                    <!-- step 3 -->
                    <div id="w5-step-three" class="tab-pane p-3">
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label pt-2" for="w5-guard-ID-crd">Guard ID Card Type<span class="required">*</span></label>
                                <select class="form-control populate" name="guard_id_Type" id="w5-guard-ID-crd" required>
                                    <option value=""></option>
                                    <option value="International Passport">International Passport</option>
                                    <option value="Drivers License">Driver’s License</option>
                                    <option value="Voters Card">Voter’s Card</option>
                                    <option value="National ID Card">National ID Card</option>
                                    <option value="Valid Work ID Card">Valid Work ID Card</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="w5-guard-blood-group">Blood Group<span class="required">*</span></label>
                                <select class="form-control mb-3" name="guard_blood_group" id="w5-guard-blood-group" title="" required>
                                    <option value="A">A</option>
                                    <option value="B" >B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-4">
                                <label class="control-label pt-1" for="w5-guard-bank"> Bank<span class="required">*</span></label>
                                <input type="text" class="form-control" name="guard_bank" id="w5-guard-bank" required>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label pt-1" for="w5-guard-acct-number">Account Number<span class="required">*</span></label>
                                <input type="number" class="form-control" name="guard_acct_number" id="w5-guard-acct-number" minlength="10" maxlength="10" required>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label pt-1" for="w5-guard-acct-name"> Account Name</label>
                                <input type="text" class="form-control" name="guard_acct_name" id="w5-guard-acct-name" required readonly>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <label class="control-label pt-1" for="w5-guard-remark">Remark</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" rows="3" name="guard_remark" id="w5-guard-remark"></textarea>
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
                    <input type="submit" value="Register" id="register_guard_button" style="display: inline-block;padding: 5px 14px; background-color: #fff;border: 1px solid #ddd;border-radius: 15px;">
                </li>
                <li class="next"><a>Next <i class="fas fa-angle-right"></i></a></li>
            </ul>
        </div>
    </section>
</section>
<?php include_once("inc/footer.com.php"); ?>
<script>
    var inputs = $('#register_guard').find('.tab-content');
    inputs.keyup(function() {
        let guard_firstname = $("#w5-guard_firstname").val();
        let guard_middlename = $("#w5-guard_middlename").val();
        let guard_lastname = $("#w5-guard_lastname").val();
        $('#w5-guard-acct-name').val(guard_firstname+' '+guard_middlename+' '+guard_lastname);
    });
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
                    '<label class="control-label text-sm-end pt-1" for="w5-guarantor-title-'+count+'">Guarantor Title '+count+'</label>' +
                    '<select class="form-control populate" name="guarantor_title[]" id="w5-guarantor-title-'+count+'">' +
                    '<option value=""></option><option value="Mr">Mr.</option><option value="Miss">Miss</option>' +
                    '<option value="Mrs">Mrs.</option></select></div><div class="col-sm-4">' +
                    '<label class="control-label text-sm-end pt-1" for="w5-guarantor-firstname-'+count+'">Guarantor Firstname '+count+'</label>' +
                    '<input type="text" class="form-control"  name="guarantor_first_name[]" id="w5-guarantor-firstname-'+count+'">' +
                    '</div><div class="col-sm-3">' +
                    '<label class="control-label text-sm-end pt-1" for="w5-guarantor-middlename-'+count+'">Guarantor Middlename '+count+'</label>' +
                    '<input type="text" class="form-control"  name="guarantor_middle_name[]" id="w5-guarantor-middlename-'+count+'">' +
                    '</div><div class="col-sm-3">' +
                    '<label class="control-label text-sm-end pt-1" for="w5-guarantor-lastname-'+count+'">Guarantor Lastname '+count+'</label>' +
                    '<input type="text" class="form-control"  name="guarantor_last_name[]" id="w5-guarantor-lastname-'+count+'">' +
                    '</div></div><div class="form-group row pb-3"><div class="col-sm-2">' +
                    '<label class="control-label pt-1" for="w5-guarantor-sex-'+count+'">Sex</label>' +
                    '<select class="form-control populate" name="guarantor_sex[]" id="w5-guarantor-sex-'+count+'" >' +
                    '<option value=""></option><option value="M">Male</option><option value="F">Female</option></select>' +
                    '</div><div class="col-sm-3"><label class="control-label pt-1" for="w5-guarantor-phone-'+count+'">Phone '+count+'</label>' +
                    '<input type="text" class="form-control" name="guarantor_phone[]" id="w5-guarantor-phone-'+count+'" minlength="11" maxlength="11">' +
                    '</div><div class="col-sm-4"><label class="control-label pt-1" for="w5-guarantor-email-'+count+'">Email '+count+'</label>' +
                    '<input type="email" class="form-control" name="guarantor_email[]" id="w5-guarantor-email-'+count+'" ></div>' +
                    '<div class="col-sm-3"><label class="control-label pt-1" for="w5-guarantor-years-relationship-'+count+'">Years of Relationship '+count+'</label>' +
                    '<input type="number" class="form-control" name="guarantor_years_of_relationship[]" id="w5-guarantor-years-relationship-'+count+'" >' +
                    '</div></div><div class="form-group row pb-3"><div class="col-sm-3">' +
                    '<label class="control-label pt-1" for="w5-guarantor-place-of-work-'+count+'">Place of work '+count+'</label>' +
                    '<input type="text" class="form-control" name="guarantor_place_of_work[]" id="w5-guarantor-place-of-work-'+count+'" >' +
                    '</div><div class="col-sm-2"><label class="control-label pt-1" for="w5-guarantor-rank-'+count+'">Rank</label>' +
                    '<input type="text" class="form-control" name="guarantor_rank[]" id="w5-guarantor-rank-'+count+'" >' +
                    '</div><div class="col-sm-7"><label class="control-label text-sm-end pt-1" for="w5-guarantor-address-'+count+'">Home Address '+count+'</label>' +
                    '<input type="text" class="form-control"  name="guarantor_address[]" id="w5-guarantor-address-'+count+'" >' +
                    '</div></div><div class="form-group row pb-3"><div class="col-sm-4">' +
                    '<label class="control-label pt-1" for="w5-guarantor-ID-crd-'+count+'">ID Card Type '+count+'</label>' +
                    '<select class="form-control populate" name="guarantor_id_Type[]" id="w5-guarantor-ID-crd-'+count+'" >' +
                    '<option value=""></option><option value="International Passport">International Passport</option>' +
                    '<option value="Drivers License">Driver’s License</option><option value="Voters Card">Voter’s Card</option>' +
                    '<option value="National ID Card">National ID Card</option><option value="Valid Work ID Card">Valid Work ID Card</option></select>'+
                    '</div><div class="col-sm-8"><label class="control-label text-sm-end pt-1" for="w5-guarantor-work-address-'+count+'">Work Address '+count+'</label>' +
                    '<input type="text" class="form-control"  name="guarantor_work_address[]" id="w5-guarantor-work-address-'+count+'">' +
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
