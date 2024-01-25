<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>

<?php
if (!isset($offense_id) || $offense_id == NULL ) {echo "<script>window.location = '".url_path('/company/penalties',true,true)."'; </script>";}
?>
<?php
$res = $company->get_company_penalty_by_id($offense_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Edit Penalty</h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                        <li><span>Edit Penalty</span></li>
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
                                </a> Edit Penalty
                            </h2>
                        </header>
                        <form name="update_company_penalty" id="update_company_penalty">
                            <div class="card-body">
                                <div id="response-alert"></div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Offense Name  <span class="required">*</span></label>
                                            <input type="text" name="offense_name" class="form-control" title="Please enter offense name" value="<?=$row['offense_name'];?>" required />
                                            <input type="hidden" name="offense_id" value="<?=$row['offense_id'];?>" />
                                            <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pb-2">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Offense Charge/Penalty <span class="required">*</span></label>
                                            <select class="form-control" name="off_charge" id="off_charge" title="Please select penalty" required>
                                                <option value=""></option>
                                                <option value="Deduct days worked" <?=($row['offense_charge']=="Deduct days worked")?'selected':'';?>>Deduct days worked</option>
                                                <option value="Flat Amount" <?=($row['offense_charge']=="Flat Amount")?'selected':'';?>>Flat Amount</option>
                                                <option value="Permanent dismissal" <?=($row['offense_charge']=="Permanent dismissal")?'selected':'';?>>Permanent dismissal</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row row_chr_amt pb-2">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Charge amount </label>
                                            <small class="text-info">(amount to deduct) </small><span class="required">*</span>
                                            <input type="text" name="charge_amt" id="charge_amt" class="form-control" title="Please enter charge amount" value="<?=$row['charge_amt'];?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row row_chr_days pb-2">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Charge days </label>
                                            <small class="text-info">(no of deduction days) </small><span class="required">*</span>
                                            <input type="text" name="days_deduct" id="days_deduct" class="form-control" title="Please enter charged days" value="<?=$row['days_deduct'];?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <input class="btn btn-primary px-5" type="submit" value="Update Penalty" />
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>
<script>
    $(function() {
        if ($('#off_charge').val() === 'Flat Amount') {
            $('.row_chr_days').hide();
            $('.row_chr_amt').show();
        } else {
            $('.row_chr_days').show();
            $('.row_chr_amt').hide();
        }
        $('#off_charge').change(function(){
            if($('#off_charge').val() === 'Flat Amount') {
                $('.row_chr_amt').show();
                $('.row_chr_days').hide();
                $('#days_deduct').val(0)
            } else if ($('#off_charge').val() === 'Deduct days worked') {
                $('.row_chr_days').show();
                $('.row_chr_amt').hide();
                $('#charge_amt').val(0)
            } else {
                $('.row_chr_amt').hide();
                $('.row_chr_days').hide();
                $('#days_deduct').val(0)
                $('#charge_amt').val(0)
            }
        });
    });
</script>
