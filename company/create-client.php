<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Create Client</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="./"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Create Client</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <section class="card form-wizard" id="w2">
            <header class="card-header">
                <h2 class="card-title">New Client</h2>
            </header>
            <div class="card-body card-body-nopadding">
                <div class="wizard-tabs">
                    <ul class="nav wizard-steps">
                        <li class="nav-item active">
                            <a data-bs-target="#w2-basic-info" data-bs-toggle="tab" class="nav-link text-center">
                                <span class="badge">1</span>
                                Client Info.
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-target="#w2-guarantor-info" data-bs-toggle="tab" class="nav-link text-center">
                                <span class="badge">2</span>
                                Client Contact Info.
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-bs-target="#w2-next-of-kin-info" data-bs-toggle="tab" class="nav-link text-center">
                                <span class="badge">3</span>
                                Client official Info.
                            </a>
                        </li>
                    </ul>
                </div>

                <form class="form-horizontal" name="register_client" id="register_client">
                    <div class="tab-content">
                        <div id="response-alert"></div>
                        <!-- Client Basic Info -->
                        <div id="w2-basic-info" class="tab-pane p-3 active">
                            <div class="form-group row pb-3">
                                <div class="col-sm-12">
                                    <label class="control-label text-sm-end pt-1" for="w2-fullname">Client Fullname<span class="required">*</span></label>
                                    <input type="text" class="form-control"  name="client_full_name" id="w2-fullname" required>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-12">
                                    <label class="control-label pt-1" for="w2-client-office-address">Office Address<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="client_office_address" id="w2-client-office-address" required>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="w2-office-phone">Office Phone<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="client_office_phone" id="w2-office-phone" minlength="11" maxlength="11" required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="w2-client_email">Email<span class="required">*</span></label>
                                    <input type="email" class="form-control" name="client_email" id="w2-client_email">
                                </div>
                            </div>
                        </div>

                        <!-- Client Contact's Info -->
                        <div id="w2-guarantor-info" class="tab-pane p-3">
                            <div class="listing-more">
                                <div>
                                    <div class="form-group row pb-3">
                                        <div class="col-sm-8">
                                            <label class="control-label pt-1" for="w2-Contact-fullname-1">Client Representative Fullname<span class="required">*</span></label>
                                            <input type="text" class="form-control cc_fullname"  name="client_contact_full_name[]" id="w2-Contact-fullname-1" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label pt-1" for="w2-contact-position-1">Client Representative Position<span class="required">*</span></label>
                                            <input class="form-control cc_position" name="client_contact_position[]" id="w2-contact-position-1" required />
                                        </div>
                                    </div>
                                    <div class="form-group row pb-3">
                                        <div class="col-sm-6">
                                            <label class="control-label pt-1" for="w2-contact-phone-1">Client Representative Phone<span class="required">*</span></label>
                                            <input type="text" class="form-control cc_phone" name="client_contact_phone[]" id="w2-contact-phone-1" minlength="11" maxlength="11" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label pt-1" for="w2-contact-email-1">Client Representative Email<span class="required">*</span></label>
                                            <input type="email" class="form-control cc_email" name="client_contact_email[]" id="w2-contact-email-1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-default btn-xs add_more_contact_info mt-2">
                                <i class="fas fa-plus">&nbsp;</i> add more contact
                            </a>

                        </div>
                        <!-- Client NOK Info -->
                        <div id="w2-next-of-kin-info" class="tab-pane p-3">
                            <div class="form-group row pb-3">
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="w2-client-photo">Client Photo</label>
                                    <input type="file" class="form-control" name="client_photo" id="w2-client-photo">
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label pt-2" for="w2-client-ID-crd">ID Card Type</label>
                                    <select class="form-control populate" name="client_id_card_Type" id="w2-client-ID-crd">
                                        <option value=""></option>
                                        <option value="International Passport">International Passport</option>
                                        <option value="Drivers License">Driver’s License</option>
                                        <option value="Voters Card">Voter’s Card</option>
                                        <option value="National ID Card">National ID Card</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="w2-client-ID-card-front">ID Card Front</label>
                                    <input type="file" class="form-control" name="client_id_card_front" id="w2-client-ID-card-front">
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="w2-client-Id-card-back">ID Card Back</label>
                                    <input type="file" class="form-control" name="client_id_card_back" id="w2-client-Id-card-back">
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
<?php include_once("inc/footer.com.php"); ?>
<script>
    $(document).ready(function () {
        var count = 1;
        $(".content-body").on('click', '.add_more_contact_info', function (e) {
            ++count;
            if (count >3){
                return false;
            } else {
                $('.listing-more').append('<div id="dynamic_field' + count + '">' +
                    '<div class="form-group row pb-3">' +
                    '<div class="col-sm-8">' +
                    '<label class="control-label pt-1" for="w2-Contact-fullname-' + count + '">Client Representative Fullname ' + count + '<span class="required">*</span></label>' +
                    '<input type="text" class="form-control cc_fullname"  name="client_contact_full_name[]" id="w2-Contact-fullname-' + count + '" required>' +
                    '</div><div class="col-sm-4">\n' +
                    '<label class="control-label pt-1" for="w2-contact-position-' + count + '">Client Representative Position ' + count + '<span class="required">*</span></label>' +
                    '<input class="form-control cc_position" name="client_contact_position[]" id="w2-contact-position-' + count + '" required />' +
                    '</div></div><div class="form-group row pb-3"><div class="col-sm-6">' +
                    '<label class="control-label pt-1" for="w2-contact-phone-' + count + '">Client Representative Phone ' + count + '<span class="required">*</span></label>' +
                    '<input type="text" class="form-control cc_phone" name="client_contact_phone[]" id="w2-contact-phone-' + count + '" minlength="11" maxlength="11" required>' +
                    '</div><div class="col-sm-6">' +
                    '<label class="control-label pt-1" for="w2-contact-email-' + count + '">Client Representative Email ' + count + '<span class="required">*</span></label>' +
                    '<input type="email" class="form-control cc_email" name="client_contact_email[]" id="w2-contact-email-' + count + '">' +
                    '</div></div>' +
                    '<span><button class="btn btn-danger btn-xs btn_remove" id="' + count + '"><i class="fa fa-trash"></i> Remove</button></span>' +
                    '</div>'
                );
            }
        });

        $(".content-body").on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");$('#dynamic_field'+button_id+'').remove();
        });

    });
</script>
