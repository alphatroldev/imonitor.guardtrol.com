<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>

<section role="main" class="content-body">
    <header class="page-header">
            <h2>Guards Payroll Data History</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Guards Payroll Data</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">List Guards Payroll Data</h2>
                </header>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-no-more mb-0" id="datatable-tabletools">
                        <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Guard Name</th>
                                <th>Payroll Title</th>
                                <th>Payroll Type</th>
                                <th>Payment Mode</th>
                                <th>Amount</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Description</th>
                                <th>Payroll Created On</th>
                                <th class="no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $res = $guard->get_all_guards_payroll_data($c['company_id']);
                        if ($res->num_rows > 0) {$n=0;
                            while ($row = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td data-title="sno"><?=++$n;?></td>
                                    <td data-title="Guard Name"><?=$row['guard_firstname']. ' ' .$row['guard_lastname'];?></td>
                                    <td data-title="Payroll Title"><?= $row['gpd_title'];?></td>
                                    <td data-title="Payroll Type"><?= $row['gpd_type'];?></td>
                                    <td data-title="Payment Mode"><?= $row['gpd_pmode'];?></td>
                                    <td data-title="Amount"><?= $row['gpd_amount'];?></td>
                                    <td data-title="Month"><?= $row['gpd_mon_month'];?></td>
                                    <td data-title="Year"><?= $row['gpd_mon_year'];?></td>
                                    <td data-title="Description"><?= $row['gpd_desc'];?></td>
                                    <td data-title="Payroll Created On"><?= date("d/m/Y H:i", strtotime($row['gpd_issue_date']));?></td>
                                    <td data-title="Actions" class="actions no-print">
                                        <a href="javascript:void(0)" data-payroll_data_sno="<?= $row['gpd_sno'];?>" data-comp_id="<?=$c['company_id'];?>" class="on-default text-danger" id="G_PayrollDataBtn">
                                            <i class="far fa-trash-alt"></i> delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No guard payroll data found</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
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
                sDom: '<"text-right mb-md"T><"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>p',
                buttons: [
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
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
