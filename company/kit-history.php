<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Kit History</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Kit History</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <section class="card">
        <div class="card-body">
            <table style="font-size:11px;" id="datatable-activity" class="table table-striped table-no-more table-bordered mb-0">
                <thead>
                <tr>
                    <th style="width: 15%"><span class="font-weight-normal text-4">Type</span></th>
                    <th style="width: 15%"><span class="font-weight-normal text-4">Guard</span></th>
                    <th style="width: 20%"><span class="font-weight-normal text-4">Date</span></th>
                    <th><span class="font-weight-normal text-4">Message</span></th>
                </tr>
                </thead>
                <tbody class="log-viewer">
                <?php
                $res2 = $company->get_kits_inventory_history($c['company_id']);
                if ($res2->num_rows > 0) {$n=0;
                    while ($row2 = $res2->fetch_assoc()) {
                        ?>
                        <tr>
                            <?php if ($row2['kl_type']=="Success"){?>
                                <td data-title="Type" class="pt-3 pb-3">
                                    <i class="fas fa-check-circle fa-fw text-success text-5 va-middle"></i>
                                    <span class="va-middle">Add new</span>
                                </td>
                            <?php } elseif ($row2['kl_type']=="Info"){?>
                                <td data-title="Type" class="pt-3 pb-3">
                                    <i class="fas fa-info fa-fw text-info text-5 va-middle"></i>
                                    <span class="va-middle">Issued Kit</span>
                                </td>
                            <?php } ?>
                            <td data-title="Guard" class="pt-3 pb-3">
                                <?=!empty($row2['guard_id'])?$row2['guard_firstname']." ".$row2['guard_lastname']:'NULL';?>
                            </td>
                            <td data-title="Date" class="pt-3 pb-3"><?=date('m/d/Y H:i:s', strtotime($row2['kl_date']))?></td>
                            <td data-title="Message" class="pt-3 pb-3">
                                <?=$row2['kl_action'];?> - <?=$row2['kl_message'];?>
                            </td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </section>
</section>
<?php include_once("inc/footer.com.php"); ?>
<script>
    $('#datatable-activity').dataTable( {
        "lengthChange": false,
        "bSort": false,
        "pageLength": 25
    } );
</script>
