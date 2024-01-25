<?php
//function getBetweenDates($startDate, $endDate){
//    $rangArray = [];
//    $startDate = strtotime($startDate);
//    $endDate = strtotime($endDate);
//    for ($currentDate = $startDate; $currentDate <= $endDate;
//         $currentDate += (86400)) {
//        $date = date('d-m-Y', $currentDate);
//        $rangArray[] = $date;
//    }
//    return $rangArray;
//}
//$dates = getBetweenDates($_POST['start'], $_POST['end']);
//$all_dates = array();
//foreach ($dates as $date) { array_push($all_dates, $date); }
$selectedDate = date('d-m-Y',strtotime($_POST['start']));
?>
<?php include_once("inc/header.profile.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<?php
if (empty($_POST['beat_check']) || empty($selectedDate)){
    echo "<script>window.location = '".url_path('/company/generate-guards-absentee-report',true,true)."';</script>";
}
    ?>
    <section role="main" class="mx-5">
        <div class="d-flex justify-content-center mb">
            <div>
                <a href="<?= url_path('/company/generate-guards-absentee-report',true,true)?>">
                    <img src="<?=public_path('uploads/company/'.$c['company_logo']);?>" class="rounded float-left" width="80" height="80" alt="Company Logo" />
                </a>
            </div>
            <div class="px-3">
                <h3 class="text-center text-uppercase">
                    <a href="<?= url_path('/company/generate-guards-absentee-report',true,true)?>">
                        <?=$c['company_name'];?> GUARD ABSENTEE REPORT
                    </a>
                </h3>
            </div>
        </div>
        <div class="card mt-2">
            <header class="card-header">
                <a style="float:left;" href="<?= url_path('/company/generate-guards-absentee-report',true,true)?>" class="no_style">
                    <img src="back.63df8891.svg" alt="back" />
                </a>
                <h2 class="card-title text-center text-uppercase">
                    <?= date('d, F Y', strtotime($_POST['start']));?>
                </h2>
            </header>
            <div class="card-body">
                <table class="table table-responsive-md table-bordered mb-0" id="datatable-tabletools" style="font-size: 12px;">
                    <thead>
                    <tr>
                        <th>s/n</th>
                        <th>Guard Name</th>
                        <th>Beat Name</th>
                        <th>Client Name</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $res = $company->get_guard_absentee_report($c['company_id']);
                    if ($res->num_rows > 0) { $n=0;
                    while ($row = $res->fetch_assoc()) {
                    if (empty($row_2 = $company->check_if_guard_clock_in($row['guard_id'],$selectedDate,$c['company_id']))){
//                    if (in_array($clock_date, $all_dates)){
                    if (in_array($row['beat_id'], $_POST['beat_check'])){
                    ?>
                        <tr>
                            <td><?=++$n;?></td>
                            <td><?=$row['guard_firstname']." ".$row['guard_middlename']." ".$row['guard_lastname'];?></td>
                            <td><?=$row['beat_name'];?></td>
                            <td><?=$row['client_fullname'];?></td>
                            <td><b><?=date("d/M/Y",strtotime($selectedDate));?></b></td>
                        </tr>
                    <?php } } } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
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
        $(function() {datatableInit();});
    }).apply(this, [jQuery]);
</script>