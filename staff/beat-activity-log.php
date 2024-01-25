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
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Log Viewer : <?=$row['beat_name'] ;?></h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                        <li><span><?=$row['beat_name'] ;?></span></li>
                        <li><span>Log</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <section class="card">
                <div class="card-body">
                    <table style="font-size:11px;" id="datatable-activity" class="table table-striped table-no-more table-bordered mb-0">
                        <thead>
                        <tr>
                            <th style="width: 10%"><span class="font-weight-normal text-4">Type</span></th>
                            <th style="width: 20%"><span class="font-weight-normal text-4">Date</span></th>
                            <th><span class="font-weight-normal text-4">Message</span></th>
                        </tr>
                        </thead>
                        <tbody class="log-viewer">
                        <?php
                        $res = $beat->get_beat_logs($beat_id);
                        if ($res->num_rows > 0) {$n=0;
                            while ($row = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <?php if ($row['action_type']=="Info"){?>
                                        <td data-title="Type" class="pt-3 pb-3">
                                            <i class="fas fa-info fa-fw text-info text-5 va-middle"></i>
                                            <span class="va-middle">Info</span>
                                        </td>
                                    <?php } elseif ($row['action_type']=="Warning"){?>
                                        <td data-title="Type" class="pt-3 pb-3">
                                            <i class="fas fa-exclamation-triangle fa-fw text-warning text-5 va-middle"></i>
                                            <span class="va-middle">Warning</span>
                                        </td>
                                    <?php } ?>
                                    <td data-title="Date" class="pt-3 pb-3"><?=date('m/d/Y H:i:s', strtotime($row['action_date']))?></td>
                                    <td data-title="Message" class="pt-3 pb-3">
                                        <?=$row['action_title'];?> - <?=$row['action_message'];?>
                                    </td>
                                </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.staff.php"); ?>
<script>
    $('#datatable-activity').dataTable( {
        "lengthChange": false,
        "bSort": false,
        "pageLength": 25
    } );
</script>