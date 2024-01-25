<?php
function getBetweenDates($startDate, $endDate){
    $rangArray = [];
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);
    for ($currentDate = $startDate; $currentDate <= $endDate;
         $currentDate += (86400)) {
        $date = date('d-m-Y', $currentDate);
        $rangArray[] = $date;
    }
    return $rangArray;
}
$dates = getBetweenDates($_POST['start'], $_POST['end']);
$all_dates = array();
foreach ($dates as $date) { array_push($all_dates, $date); }
?>
<?php include_once("inc/header-min.client.php"); ?>
<?php
$c = $client->get_client_company_details($cli_id,$comp_id);
?>
<?php if (!isset($_SESSION['CLIENT_LOGIN'])) header("Location: ./"); ?>
<?php
if (empty($_POST['beat_check']) || empty($dates)){
    echo "<script>window.location = '".url_path('/client/clock-in-out',true,true)."';</script>";
} else {
?>
    <section role="main" class="mx-5">
        <div class="d-flex justify-content-center mb">
            <div>
                <a href="<?= url_path('/client/clock-in-out',true,true)?>">
                    <img src="<?=public_path('uploads/company/'.$c['company_logo']);?>" class="rounded float-left" width="80" height="80" alt="Company Logo" />
                </a>
            </div>
            <div class="px-3">
                <h3 class="text-center text-uppercase">
                    <a href="<?= url_path('/client/clock-in-out',true,true)?>">GUARD ATTENDANCE REPORT</a>
                </h3>
            </div>
        </div>
        <div class="card mt-2">
            <header class="card-header">
                <h2 class="card-title text-center text-uppercase">
                    <a style="float: left;" href="<?= url_path('/client/clock-in-out',true,true)?>" class="no_style">
                        <img src="back.63df8891.svg" alt="back" />
                    </a>
                    <?=date('d-M Y', strtotime($_POST['start'])).' to '.date('d-M Y', strtotime($_POST['end']));?>
                </h2>
            </header>
            <div class="card-body">
                <table class="table table-responsive-md table-bordered mb-0" id="datatable-tabletools" style="font-size: 12px;">
                    <thead>
                    <tr>
                        <th>s/n</th>
                        <th>Att. Mode</th>
                        <th>Beat Name</th>
                        <th>Guard Name</th>
                        <th>Clock In Time</th>
                        <th>Clock Out Time</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $res = $client->get_client_guard_clock_in_out_report($comp_id,$cli_beats);
                    if ($res->num_rows > 0) { $n=0;
                        while ($row = $res->fetch_assoc()) {
                            $clock_date = date("d-m-Y",strtotime($row['clk_date']));
                            if (in_array($clock_date, $all_dates)){
                                if (in_array($row['beat_id'], $_POST['beat_check'])){
                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><b><?= !empty($row['clock_in_time']) ? '<span class="text-primary">Clock In</span>':
                                                    '<span class="text-danger">Clock Out</span>'; ?></b></td>
                                        <td><?=$row['beat_name'] ." (".$row['client_fullname'].")";?></td>
                                        <td><?=$row['guard_firstname']." ".$row['guard_middlename']." ".$row['guard_lastname'];?></td>
                                        <td><b><?= $row['clock_in_time'] != "0000-00-00 00:00:00"?$row['clock_in_time']:'0000-00-00 00:00:00';?></b></td>
                                        <td><b><?= $row['clock_out_time'] != "0000-00-00 00:00:00"?$row['clock_out_time']:'0000-00-00 00:00:00';?></b></td>
                                        <td><b><?=date("d/M/Y",strtotime($row['clk_date']));?></b></td>
                                    </tr>
                    <?php }  } } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
<?php } ?>
<?php include_once("inc/footer.client.php"); ?>
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