<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Create Penalty & Charge</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Add Penalty & Charge</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">
                            <a href="<?= url_path('/company/penalties',true,true)?>">
                                <i class="fas fa-arrow-left">&nbsp;&nbsp;</i>
                            </a>Add new penalty
                        </h2>
                    </header>
                    <form name="create_penalty" id="create_penalty">
                        <div class="card-body">
                            <div id="response-alert"></div>
                            <div class="form-group row pb-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Offense Name <span class="required">*</span></label>
                                        <input type="text" name="offense_name" class="form-control" title="Please enter offense name" required />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Offense Charge/Penalty <span class="required">*</span></label>
                                        <select class="form-control" name="off_charge" id="off_charge" title="Please select penalty" required>
                                            <option value=""></option>
                                            <option value="Deduct days worked">Deduct days worked</option>
                                            <option value="Flat Amount">Flat Amount</option>
                                            <option value="Permanent dismissal">Permanent dismissal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row row_chr_amt pb-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Charge amount </label>
                                        <small class="text-info">(amount to deduct) </small><span class="required">*</span>
                                        <input type="text" name="charge_amt" class="form-control" title="Please enter charge amount" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row row_chr_days pb-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">Charge days </label>
                                        <small class="text-info">(no of deduction days) </small><span class="required">*</span>
                                        <input type="text" name="days_deduct" class="form-control" title="Please enter charged days" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="card-footer py-3">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input class="btn btn-primary px-5" type="submit" value="Create Penalty" />
                                </div>
                            </div>
                        </footer>
                    </form>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>
<script>
    $(function() {
        $('.row_chr_amt').hide();
        $('.row_chr_days').hide();
        $('#off_charge').change(function(){
            if($('#off_charge').val() === 'Flat Amount') {
                $('.row_chr_amt').show();
                $('.row_chr_days').hide();
            } else if ($('#off_charge').val() === 'Deduct days worked') {
                $('.row_chr_days').show();
                $('.row_chr_amt').hide();
            } else {
                $('.row_chr_amt').hide();
                $('.row_chr_days').hide();
            }
        });
    });
</script>
