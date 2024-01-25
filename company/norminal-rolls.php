<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Norminal Roll</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="index"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Norminal Roll</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Norminal Roll</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?= url_path('/company/deploy-guard',true,true)?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Deploy Guard</a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3 text-end">
                                    <a href="<?= url_path('/company/norminal-inactive',true,true)?>" class="btn btn-danger">
                                        <i class="fas fa-archive">&nbsp;&nbsp;</i>Inactive norminal rolls</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped mb-0" id="datatable-tabletools">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Guard Fullname</th>
                                <th>Beat</th>
                                <th>Position</th>
                                <th>Phone</th>
                                <th>D. of D.</th>
                                <th>Salary</th>
                                <th>Shift</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $deploy_guard->get_norminal_roll($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {

                                    $guard_info = $deploy_guard->get_guard_info($row['guard_id']);
                                    $guard = $guard_info->fetch_assoc();

                                    $beat_info = $deploy_guard->get_beat_info($row['beat_id']);
                                    $beat = $beat_info->fetch_assoc();

                                    $client_info = $deploy_guard->get_client_info($beat['client_id']);
                                    $client = $client_info->fetch_assoc();

                                    $guard_position_info = $deploy_guard->get_guard_position_info($row['g_position']);
                                    $guard_position = $guard_position_info->fetch_assoc();

                                    $shift_info = $deploy_guard->get_shift_info($row['g_shift']);
                                    $shift = $shift_info->fetch_assoc();
                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><?= $guard['guard_firstname']." ".$guard['guard_middlename']." ".$guard['guard_lastname'];?>
                                            <?=($guard['guard_status'] !=='Active')?
                                                '<span class="fas fa-times-circle text-danger"></span>':
                                                '';?>
                                        </td>

                                        <td><?= $beat['beat_name'];?>

                                            <?=($beat['beat_status'] !=='Active')?
                                                '<span class="fas fa-times-circle text-danger"></span>':
                                                '';?>

                                        </td>
                                        <td><?= $guard_position['pos_title'];?></td>
                                        <td><?= $guard['phone'];?></td>
                                        <td><?= date("d-m-Y",strtotime($row['dop']));?></td>
                                        <td>₦<?= number_format($row['g_dep_salary'],0);?></td>
                                        <td><?= $shift['shift_title'];?></td>

                                        <td class="actions">
                                            <a href="<?= url_path('/company/edit-norminal-roll/'.$row['guard_id'],true,true)?>" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="javascript:void(0)" data-id="<?= $row['gd_id'];?>" class="on-default remove-row" id="norminalRollDeleteBtn">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No guard deployed</td></tr>";} ?>
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
                pageLength: 100,
                sDom: '<"text-right mb-md"T><"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>p',
                buttons: [
                    {
                        extend: 'print',
                        text: 'Print'
                    },
                    {
                        extend: 'excel',
                        text: 'Excel'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
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
