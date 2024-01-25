<?php include_once("inc/header.super.php"); ?>
<?php if (!isset($_SESSION['SUPERVISOR_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Guard Attendance Logs</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/supervisor/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Guard Miscellenous Logs</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12 pt-4">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <h2 class="card-title">Guard Attendance Unverified Logs</h2>
                </header>
                <div class="card-body">
                    <table style="font-size:11px;" id="datatable-activity" class="table table-striped table-no-more table-bordered mb-0">
                <thead>
                <tr>
                    <th style="width: 10%"><span class="font-weight-bold text-4">S/NO</span></th>
                    <th style="width: 20%"><span class="font-weight-bold text-4">GUARD NAME</span></th>
                    <th style="width: 20%"><span class="font-weight-bold text-4">BEAT NAME</span></th>
                    <th><span class="font-weight-bold text-4">ATTEMPT TIME</span></th> 
                </tr>
                </thead>
                <tbody class="log-viewer">
                <?php
                $res = $company->get_guard_clockin_attempt_logs($comp_id);
                if ($res->num_rows > 0) {$n=0;
                while ($row = $res->fetch_assoc()) {
                ?>
                <tr>
                    <td data-title="sno" class="pt-3 pb-3"><?=++$n;?></td>
                    <td data-title="Guard Name" class="pt-3 pb-3"><?= $row['guard_firstname']." ".$row['guard_middlename']." ".$row['guard_lastname'];?></td>
                    <td data-title="Beat Name" class="pt-3 pb-3"><?= $row['beat_name'];?></td>
                    <td data-title="Date" class="pt-3 pb-3"><?=date('d/M/Y H:i:s', strtotime($row['date_time']))?></td>
                </tr>
                <?php } } ?>
                </tbody>
            </table>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.super.php"); ?>
<script>
    $('#datatable-activity').dataTable( {
        "lengthChange": false,
        "bSort": false,
        "pageLength": 50
    } );
</script>