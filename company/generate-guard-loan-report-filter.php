<?php
    $from_month = isset($_POST['from_sel_month'])?$_POST['from_sel_month']:'';
    $from_year = isset($_POST['from_sel_year'])?$_POST['from_sel_year']:'';

    $to_month = isset($_POST['to_sel_month'])?$_POST['to_sel_month']:'';
    $to_year = isset($_POST['to_sel_year'])?$_POST['to_sel_year']:'';
?>
<?php include_once("inc/header.profile.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<?php
if ($from_month=='' || $from_year=='' || $to_month=='' || $to_year==''){
    echo "<script>window.location = '".url_path('/company/generate-guard-loan-report',true,true)."';</script>";
} else {
    $new_from_date = date("Y-m-d", strtotime($from_month.'-'.$from_year.'-15'));
    $new_to_date = date("Y-m-d", strtotime($to_month.'-'.$to_year.'-15'));
    $begin = new DateTime("$new_from_date");
    $end = new DateTime( "$new_to_date");
    $end = $end->modify( 'first day of next month' );
    $interval = DateInterval::createFromDateString('first day of next month');
    $period = new DatePeriod($begin, $interval, $end);
    $all_months = array();
?>
<section role="main" class="mx-5">
    <div class="d-flex justify-content-center mb">
        <div>
            <a href="<?= url_path('/company/generate-guard-loan-report',true,true)?>">
                <img src="<?=public_path('uploads/company/'.$c['company_logo']);?>" class="rounded float-left" width="80" height="80" alt="Company Logo" />
            </a>
        </div>
        <div class="px-3">
            <h3 class="text-center text-uppercase">
                <a href="<?= url_path('/company/generate-guard-loan-report',true,true)?>">
                    <?=$c['company_name'];?> GUARD LOAN REPORT
                </a>
            </h3>
        </div>
    </div>
    <div class="card mt-2">
        <header class="card-header">
            <a style="float: left;" href="<?= url_path('/company/generate-guard-loan-report',true,true)?>" class="no_style">
                <img src="back.63df8891.svg" alt="back" />
            </a>
            <h2 class="card-title text-center text-uppercase"><?=$from_month.'-'.$from_year.' to '.$to_month.'-'.$to_year;?></h2>
        </header>
        <div class="card-body">
            <table class="table table-responsive-md table-bordered mb-0" id="datatable-tabletools" style="font-size: 9px;">
                <thead>
                <tr>
                    <th>s/n</th>
                    <th>NAME</th>
                    <th>LOAN ID</th>
                    <th>DATE ISSUED</th>
                    <th>LOAN AMOUNT</th>
                    <th>START DATE</th>
                    <th>LOAN BALANCE</th>
                    <?php
                    foreach($period as $key => $dt) {
                        array_push($all_months, $dt->format( "Y" ).'-'.$dt->format( "m"));
                    ?>
                    <th><?= $dt->format( "M" ).' '.$dt->format( "Y" );?></th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $res = $company->fetch_guard_in_loan_table($c['company_id']);
                if ($res->num_rows > 0) {$n=0;
                while ($row = $res->fetch_assoc()) {
                    $mon_year = date("Y-m",strtotime($row['guard_loan_date']));
                    if (in_array($mon_year, $all_months)){
                ?>
                    <tr>
                        <td><?=++$n;?></td>
                        <td><?=$row['guard_firstname']." ".$row['guard_middlename']." ".$row['guard_lastname'];?></td>
                        <td><b><?=$row['guard_loan_id'];?></b></td>
                        <td><?=date("d/m/Y",strtotime($row['guard_loan_date']));?></td>
                        <td>₦<?=number_format($row['guard_loan_amount'],0);?></td>
                        <td><?=date("d/m/Y",strtotime($row['guard_loan_date']));?></td>
                        <td>₦<?=number_format($row['guard_loan_curr_balance'],0);?></td>
                        <?php
                        foreach($period as $dt) {
                        $repay = $company->fetch_guard_repayment_scheme($c['company_id'],$row['guard_loan_id'],$dt->format( "F" ),$dt->format( "Y" ));
                        if (!empty($repay)){
                        ?>
                        <td>₦<?=number_format($repay['guard_loan_balance'],0);?></td>
                        <?php } else { ?>
                        <td>0</td>
                        <?php } } ?>
                    </tr>
                <?php } } } else { echo "<tr><td colspan='20'></td></tr>"; } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php } ?>
<?php include_once("inc/footer.com.php"); ?>
<script>
    (function($) {

        'use strict';

        var datatableInit = function() {
            var $table = $('#datatable-tabletools');

            var table = $table.dataTable({
                "aLengthMenu": [[ 500, 1000, 1500, -1], [500, 1000, 1500, "All"]],
                sDom: '<"text-right mb-md"T><"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>p',
                buttons: [
                    {extend: 'print', text: 'Print'},
                    {extend: 'excel', text: 'Excel'},
                    {extend: 'pdf', text: 'PDF',
                        customize : function(doc){
                            var colCount = new Array();
                            $('#datatable-tabletools').find('tbody tr:first-child td').each(function(){
                                if($(this).attr('colspan')){
                                    for(var i=1;i<=$(this).attr('colspan');$i++){
                                        colCount.push('*');
                                    }
                                }else{ colCount.push('*'); }
                            });
                            doc.content[1].table.widths = colCount;
                        }
                    }
                ],
                bSort:false,
                searching: false,
                bLengthChange: false
            });

            $('<div />').addClass('dt-buttons mb-2 pb-1 text-end').prependTo('#datatable-tabletools_wrapper');

            $table.DataTable().buttons().container().prependTo( '#datatable-tabletools_wrapper .dt-buttons' );

            $('#datatable-tabletools_wrapper').find('.btn-secondary').removeClass('btn-secondary').addClass('btn-default');
        };

        $(function() {
            datatableInit();
        });

    }).apply(this, [jQuery]);
</script>

