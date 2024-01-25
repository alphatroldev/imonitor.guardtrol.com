<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Report Incident</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Incident Report</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">Incident Report</h2>
                </header>
                <form name="create_incident_report" id="create_incident_report">
                    <div class="card-body">
                        <div id="response-alert"></div>
                        <div class="form-group row pb-2">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Title <span class="required">*</span></label>
                                    <input type="text" name="report_title" class="form-control" title="Please enter report title" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Select Beat <span class="required">*</span></label>
                                    <select data-plugin-selectTwo class="form-control populate placeholder" data-plugin-options='{ "placeholder": "Select Beat", "allowClear": true }' name="report_beat" title="Please select beat" required>
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Date of Occurrence <span class="required">*</span></label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="report_occ_date">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row row_chr_amt pb-2">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Describe Incident <span class="required">*</span></label>
                                    <textarea class="form-control" rows="5" name="report_describe" title="Please describe the incident" data-plugin-textarea-autosize></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row row_chr_days pb-2">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Photo From Incident <span class="required">*</span></label>
                                    <small class="text-info">(upload at least one photo)</small>
                                    <a href="javascript:void(0)" class="btn btn-default float-end btn-xs add_more_photo">
                                        <i class="fas fa-plus">&nbsp;</i>more photo
                                    </a>
                                    <div class="listing-more">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input">
                                                    <i class="fas fa-file fileupload-exists"></i><span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileupload-exists">Change</span><span class="fileupload-new">Select file</span>
                                                    <input type="file" class="report_photo" name="photo[]" id="photo_1" />
                                                </span>
                                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Clear</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer py-3">
                        <div class="row">
                            <div class="col-sm-9">
                                <input class="btn btn-primary px-5" type="submit" value="Submit Report" />
                            </div>
                        </div>
                    </footer>
                </form>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.staff.php"); ?>
<script>
    $(document).ready(function () {
        var count = 1;
        $(".content-body").on('click', '.add_more_photo', function (e) {
            ++count;
            $('.listing-more').append('<div id="dynamic_field'+count+'" class="fileupload fileupload-new pt-3" data-provides="fileupload">' +
                '<div class="input-append">' +
                '  <div class="uneditable-input">' +
                '    <i class="fas fa-file fileupload-exists"></i><span class="fileupload-preview"></span>' +
                '  </div>' +
                '  <span class="btn btn-default btn-file">' +
                '    <span class="fileupload-exists">Change</span><span class="fileupload-new">Select file</span>' +
                '    <input type="file" class="report_photo" name="photo[]" id="photo_'+count+'" />' +
                '  </span>' +
                '  <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Clear</a>' +
                '<span><button class="btn btn-danger btn_remove" id="'+count+'"><i class="fa fa-trash"></i></button></span>' +
                '</div></div>'
            );
        });

        $(".content-body").on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");$('#dynamic_field'+button_id+'').remove();
        });
    });
</script>
