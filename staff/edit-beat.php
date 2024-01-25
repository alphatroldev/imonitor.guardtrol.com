<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>

<?php
if (!isset($beat_id) ||$beat_id == NULL ) {echo "<script>window.location = '".url_path('/staff/list-beats',true,true)."'; </script>";}

?>

<?php
$res = $beat->get_beat_by_id($beat_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <?php
        $client_name = $beat->get_client_info($row['client_id']);
        $name = $client_name->fetch_assoc();
        ?>

        <section role="main" class="content-body">
            <header class="page-header">
                <h2><?= $name['client_fullname'];?>: <?=$row['beat_name'] ;?></h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                        <li><span><a href="<?= url_path('/staff/list-beats',true,true)?>">Beats</a></span></li>
                        <li><span>Edit Beat</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <form class="form-horizontal" name="update_beat" id="update_beat">
                <section class="card">
                    <header class="card-header">
                        <h2 class="card-title">Edit Beat</h2>
                    </header>
                    <div class="card-body">
                        <div class="form-group pb-3 row">
                            <div class="col-sm-6">
                                <label class="col-form-label" for="">Client <span class="required">*</span></label>
                                <input type="text" class="form-control"  value="<?= $name['client_fullname'];?>" disabled/>
                                <input type="hidden" name="beat_sno" value="<?=$row['beat_sno'];?>" />
                                <input type="hidden" name="beat_id" value="<?=$row['beat_id'];?>" />
                                <input type="hidden" name="client_id" value="<?=$row['client_id'];?>" />
                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label" for="">Beat Name  <span class="required">*</span></label>
                                <input type="text" name="edit_beat_name" class="form-control" value="<?=$row['beat_name'] ;?>" />
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-12">
                                <label class="control-label pt-1" for="beat-address">Beat Address<span class="required">*</span></label>
                                <input type="text" name="edit_beat_address" class="form-control" value="<?=$row['beat_address'] ;?>" />
                            </div>
                        </div>
                        <div class="listing-more">
                            <?php
                            $ser = $company->get_beat_personnel_services($c['company_id'],$beat_id);
                            if ($ser->num_rows > 0) {$n=0;
                                while ($service = $ser->fetch_assoc()) { $n++;
                                    ?>
                                    <div id="dynamic_field<?=$n;?>">
                                        <div class="form-group row pb-3">
                                            <div class="col-sm-3">
                                                <label class="control-label pt-2" for="no_of_personnel_<?=$n;?>">No of Personnel <?=$n;?> <span class="required">*</span></label>
                                                <input type="number" class="form-control no_person" name="no_of_personnel[]" id="no_of_personnel_<?=$n;?>" value="<?=$service['no_of_personnel']?>" required>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-2" for="personnel_type_<?=$n;?>">Type of Personnel <?=$n;?> <span class="required">*</span></label>
                                                <select class="form-control populate" name="personnel_type[]" id="personnel_type_<?=$n;?>"  required>
                                                    <?php
                                                    $pos = $company->get_all_company_guard_positions($c['company_id']);
                                                    if ($pos->num_rows > 0) {
                                                        while ($position = $pos->fetch_assoc()) {
                                                            ?>
                                                            <option value="<?=$position['pos_title'];?>" <?=($position['pos_title']==$service['personnel_type'])?'selected':'';?>>
                                                                <?=$position['pos_title'];?>
                                                            </option>
                                                        <?php } } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label pt-2" for="personnel_amt_<?=$n;?>">Amount Per Personnel <?=$n;?> <span class="required">*</span></label>
                                                <input type="number" class="form-control person_amt" name="personnel_amt[]" id="personnel_amt_<?=$n;?>" value="<?=$service['amt_per_personnel']?>" required>
                                                <input type="number" class="personnel_tot" style="display:none;" value="<?= $service['no_of_personnel'] * $service['amt_per_personnel'];?>">
                                            </div>
                                            <?php if ($n> 1){?>
                                                <div class="col-sm-1 pt-1"><label class="">&nbsp;</label>
                                                    <a href="javascript:void(0)" style="font-size:9px;" class="btn btn-danger btn-sm py-2 shadow-none btn_remove" id="<?=$n;?>">
                                                        <i class="fa fa-trash-alt"></i> Remove
                                                    </a>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                <?php } } ?>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-default btn-sm add_more_services_info my-3">
                            <i class="fas fa-plus">&nbsp;</i> Add Services
                        </a>
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="beat_vat">V.A.T<span class="required">*</span></label>
                                    <select class="form-control populate" name="edit_beat_vat"  required>
                                        <option value=""></option>
                                        <option value="Inclusive" <?=($row['beat_vat_config']=='Inclusive')?'selected':'';?>>Include V.A.T</option>
                                        <option value="Not Inclusive" <?=($row['beat_vat_config']=='Not Inclusive')?'selected':'';?>>Don't Include  V.A.T</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label" for="beat_monthly_charges">Beat Monthly Charges<span class="required">*</span></label>
                                <input type="text" class="form-control" name="edit_beat_monthly_charges" id="beat_monthly_charges" value="<?=$row['beat_monthly_charges'];?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label" for="date_of_deployment">Date Of Deployment<span class="required">*</span></label>
                                <input type="date" name="edit_date_of_deployment" class="form-control" value="<?=$row['date_of_deployment'];?>" />
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <div class="row float-end">
                            <div class="col-sm-10">
                                <input class="btn btn-primary px-5" type="submit" value="Update" />
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.staff.php"); ?>
<script>
    $('.content-body').on('keyup','.no_person, .person_amt',function() {
        var sum_personnel_tot = 0;

        var tableRow = $(this).closest("div.form-group");
        var no_person = Number(tableRow.find(".no_person").val());
        var person_amt = Number(tableRow.find(".person_amt").val());
        var total = no_person * person_amt;
        tableRow.find(".personnel_tot").val(total);
        $(".personnel_tot").each(function(){
            sum_personnel_tot += +$(this).val();
        });
        $('#beat_monthly_charges').val(sum_personnel_tot);
    });
</script>
<script>
    $(document).ready(function () {
        var count = <?=$n;?>;
        $(".content-body").on('click', '.add_more_services_info', function (e) {
            ++count;
            $('.listing-more').append('<div id="dynamic_field'+count+'">' +
                '<div class="form-group row pb-3">' +
                '<div class="col-sm-3">' +
                '<label class="control-label pt-1" for="no_of_personnel_1">No of Personnel '+count+' <span class="required">*</span></label>' +
                '<input type="number" class="form-control no_person" name="no_of_personnel[]" id="no_of_personnel_1" required>' +
                '</div>' +
                '<div class="col-sm-4">' +
                '<label class="control-label pt-1" for="personnel_type_1">Type of Personnel '+count+' <span class="required">*</span></label>' +
                '<select class="form-control populate" name="personnel_type[]" id="personnel_type_1"  required>' +
                '<option value=""></option>' +
                <?php
                $res = $company->get_all_company_guard_positions($c['company_id']);
                if ($res->num_rows > 0) {$n=0;
                while ($row = $res->fetch_assoc()) {
                ?>
                '<option value="<?=$row['pos_title'];?>"><?=$row['pos_title'];?></option>'+
                <?php } } ?>
                '</select>' +
                '</div>' +
                '<div class="col-sm-4">' +
                '<label class="control-label pt-1" for="personnel_amt_1">Amount Per Personnel '+count+' <span class="required">*</span></label>' +
                '<input type="number" class="form-control person_amt" name="personnel_amt[]" id="personnel_amt_1" required>' +
                '<input type="number" class="personnel_tot" style="display:none;">' +
                '</div><div class="col-sm-1 pt-1"><label class="">&nbsp;</label>' +
                '<a href="javascript:void(0)" style="font-size:9px;" class="btn btn-danger btn-sm py-2 shadow-none btn_remove" id="' + count + '">' +
                '<i class="fa fa-trash-alt"></i> Remove</a>' +
                '</div></div></div>'
            );
        });

        $(".content-body").on('click', '.btn_remove', function () {
            var tableRow = $(this).closest("div.form-group");
            var personnel_amt = Number(tableRow.find(".personnel_tot").val());
            var current_tot = Number($('#beat_monthly_charges').val());
            $('#beat_monthly_charges').val(current_tot - personnel_amt);
            var button_id = $(this).attr("id");$('#dynamic_field'+button_id+'').remove();
            --count;
        });
    });
</script>
