<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<?php
if (!isset($client_id) || $client_id == NULL ) {echo "<script>window.location = '".url_path('/company/list-clients',true,true)."'; </script>";}
?>
<?php
$res = $client->get_client_by_id($client_id,$c['company_id']);
if ($res->num_rows > 0) {
while ($row = $res->fetch_assoc()) {
$bal = $client->get_client_wallet_balance($client_id,$c['company_id'])
?>
<style>
    .success_bg{background: #dff0d8;}
    .error_bg{background: #f2dede;}
</style>
<section role="main" class="content-body">
    <header class="page-header">
        <h2><?=$row['client_fullname'];?>: Debtors Ledger</h2>
        <input type="hidden" id="client_name" value="<?=$row['client_fullname'];?>" />
        <input type="hidden" id="gen_date" value="<?=date("d_M_Y_H_i_s");?>" />
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Ledger Book</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-lg-12">
            <h3 class="mt-0 pt-0">Wallet Balance: <span class="font-weight-extra-bold text-success"><?= ($bal=="no_wallet")?"₦ 0.00":"₦".number_format($bal,2);?></span></h3>
        </div>
        <div class="col-lg-12">
            <section class="card card-featured card-featured-info mb-4">
                <div class="card-body">
                    <table class="table table-bordered table-hover mb-0" id="datatable-tabletools" style="font-size: 11px;border:1px solid #f4f4f4;">
                        <thead>
                        <tr>
                            <th>s/n</th>
                            <th>Date</th>
                            <th>Transaction Type</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                            <th>Remark</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $led = $client->get_client_ledger_history($client_id,$c['company_id']);
                        if ($led->num_rows > 0) { $n=0;
                        while ($ledger = $led->fetch_assoc()) {
                        ?>
                            <tr class="<?=($ledger['trans_type']=="Credit")?"success_bg":"error_bg";?>">
                                <td><?=++$n;?></td>
                                <td data-title="Trans. Date"><?=date("d-m-Y",strtotime($ledger['created_on']));?></td>
                                <td data-title="Transaction Type"><?= $ledger['trans_type'].'-'.$ledger['payment_method'];?></td>
                                <td data-title="Debit" class="text-end"><?= ($ledger['debit']==0)?'':"₦".number_format($ledger['debit'],0);?></td>
                                <td data-title="Credit" class="text-end"><?= ($ledger['credit']==0)?'':"₦".number_format($ledger['credit'],0);?></td>
                                <td data-title="Balance" class="font-weight-bold text-end">₦ <?= number_format($ledger['balance'],2);?></td>
                                <td data-title="Comment"><?= $ledger['comment'];?></td>
                            </tr>
                        <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Ledger history found</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<?php } } ?>
<?php include_once("inc/footer.com.php"); ?>
<script>
    (function($) {

        'use strict';

        var datatableInit = function() {
            var $table = $('#datatable-tabletools');
            var genDate = $('#gen_date').val();
            var clientName = $('#client_name').val();

            var table = $table.dataTable({
                pageLength: 100,
                sDom: '<"text-right mb-md"T><"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>p',
                buttons: [
                    {
                        extend: 'print',
                        text: 'Print',
                        title: 'Debtors_Ledger_'+clientName+'_'+genDate
                    },
                    {
                        extend: 'excel',
                        text: 'Excel'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        title: 'Debtors_Ledger_'+clientName+'_'+genDate,
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
                ]
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