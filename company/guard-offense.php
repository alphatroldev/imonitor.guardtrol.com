<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Guard Offence History</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Staff Offence History</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">List Guard Offences</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <a href="<?= url_path('/company/guard-offenses',true,true)?>" class="btn btn-success"><i class="fas fa-list-alt">&nbsp;&nbsp;</i>Guard Offence</a>
                                <a href="<?= url_path('/company/guard-pardon-history',true,true)?>" class="btn btn-primary"><i class="fas fa-list">&nbsp;&nbsp;</i>Guard Pardon History</a>
                            </div>
                        </div>
                        <table class="table table-bordered table-no-more table-striped mb-0" id="datatable-tabletools">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Guard ID</th>
                                <th>Full Name</th>
                                <th>Other Names</th>
                                <th>Offence Name</th>
                                <th>No of days</th>
                                <th>Charge Amount</th>
                                <th>Remark</th>
                                <th>Date issued</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_guard_offences($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($grd_offence = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Guard ID"><?= $grd_offence['guard_id'];?></td>
                                        <td data-title="Fullname"><?= $grd_offence['guard_firstname'];?></td>
                                        <td data-title="Othernames"><?= $grd_offence['guard_middlename']." ".$grd_offence['guard_lastname'];?></td>
                                        <td data-title="Offence Name"><?= $grd_offence['offense_name'];?></td>
                                        <td data-title="Number of days"><?= $grd_offence['no_of_days'];?></td>
                                        <td data-title="Charge Amount">₦<?= number_format($grd_offence['charge_amt'], 0);?></td>
                                        <td data-title="Remark"><?= $grd_offence['offense_reason'];?></td>
                                        <td data-title="Date issued"><?=  date("d/m/Y", strtotime($grd_offence['g_off_created_at']));?></td>
                                        <td data-title="Actions" class="actions">
                                            <a data-offense_id="<?= $grd_offence['guard_offense_id'];?>" data-guard_id="<?= $grd_offence['guard_id'];?>"
                                               class="btn btn-xs btn-primary text-white modal-with-move-anim ws-normal pardon_guard_off"
                                               href="#guardPardonOffense">
                                                <i class="fas fa-edit">&nbsp;</i>pardon
                                            </a>
                                            <a data-offense_id="<?= $grd_offence['guard_offense_id'];?>" data-guard_id="<?= $grd_offence['guard_id'];?>"
                                               class="btn btn-xs btn-danger text-white " id="delGuardOffense">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Guard offence found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
                <div id="guardPardonOffense" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                    <form name="guardOffensePardon" id="guardOffensePardon" class="card">
                        <header class="card-header">
                            <h2 class="card-title">Offense Pardon</h2>
                        </header>
                        <div class="card-body">
                            <div class="modal-wrapper py-0">
                                <input type="hidden" name="offense_id" id="offense_id" value="" />
                                <input type="hidden" name="guard_id" id="guard_id" value="" />
                                <div class="form-group">
                                    <label for="pardon_reason" >Reason/Remark</label>
                                    <textarea name="pardon_reason" rows="5" id="pardon_reason" class="form-control" placeholder="Remark" required></textarea>
                                </div>
                            </div>
                        </div>
                        <footer class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <input type="submit" class="btn btn-primary" value="Update">
                                    <button class="btn btn-default modal-dismiss">Close</button>
                                </div>
                            </div>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>
<script src=<?= public_path("js/examples/examples.modals.js"); ?>></script>
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
