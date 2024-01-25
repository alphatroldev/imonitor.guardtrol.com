<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ../"); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Invoice History</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Invoice History</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">Invoice History</h2>
                </header>
                <div class="card-body">
                    <table class="table table-bordered table-striped mb-0" id="datatable-tabletools">
                        <thead>
                        <tr>
                            <th>s/n</th>
                            <th>Invoice ID</th>
                            <th>Client Name</th>
                            <th>Month Year</th>
                            <th>Invoice Generated On</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Details</th>
                            <th>Invoice</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = $company->get_all_invoice($c['company_id']);
                        if ($res->num_rows > 0) {$n=0;
                            while ($row = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?=++$n;?></td>
                                    <td><?= $row['invoice_id'];?></td>
                                    <td><?= $row['client_fullname'];?></td>
                                    <td><?= $row['invoice_month'].", ".$row['invoice_year'];?></td>
                                    <td><?= date("jS M Y (H:i)",strtotime($row['invoice_date']));?></td>
                                    <td>₦<?= number_format($row['invoice_amt']);?></td>
                                    <td><?= ($row['invoice_status']=="Paid")?"<span class='badge badge-success'>Paid</span>":
                                            "<span class='badge badge-danger'>Pending</span>";?></td>
                                    <td>
                                        <a href="<?= url_path('/staff/invoice-history-details/'.$row['invoice_id'],true,true)?>"
                                           class="btn btn-xs btn-default"><i class="fas fa-pencil-alt">&nbsp;</i>view beats
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= url_path('/staff/invoice-preview/'.$row['client_id'].'/'.$row['invoice_id'],true,true)?>"
                                           class="btn btn-xs btn-default"><i class="fas fa-print">&nbsp;</i>print view
                                        </a>
                                    </td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" data-invoice_id="<?= $row['invoice_id'];?>" data-comp_id="<?= $c['company_id'];?>"
                                           data-client_id="<?= $row['client_id'];?>" data-invoice_amt="<?= $row['invoice_amt'];?>"
                                           class="btn btn-xs btn-danger text-white" id="invoiceDeleteBtn">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No invoice history found</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.staff.php"); ?>
<script>
    (function($) {

        'use strict';

        var datatableInit = function() {
            var $table = $('#datatable-tabletools');

            var table = $table.dataTable({
                sDom: '<"text-right mb-md"T><"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>p',
                buttons: [
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3,4,5,6]
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3,4,5,6]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3,4,5,6]
                        },
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
                lengthMenu: [[50, 100, 150, 200, -1], [50, 100, 150, 200, "All"]],
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