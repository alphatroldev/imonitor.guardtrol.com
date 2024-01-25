<?php include_once("inc/header.super.php"); ?>
<?php if (!isset($_SESSION['SUPERVISOR_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?=url_path('/supervisor/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Dashboard</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
            <div class="col">
                <?php echo $comp_id; ?>
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Guard Pending ClockOut Request</h2>
                    </header>
                    <div class="card-body">
                        <table class="table table-bordered table-striped mb-0" id="datatable-company" style="font-size: 11px">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Request ID</th>
                                <th>Client Name</th>
                                <th>Beat Name</th>
                                <th>ClkOut Required Guard</th>
                                <th>Requesting Guard</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $supervisor->get_guard_clockout_request($comp_id,$bsu_beats);
                            if ($res->num_rows > 0) {$n=0;
                            while ($row = $res->fetch_assoc()) {
                                $clk_guard = $guard->get_guard_by_id_new($row['clockout_guard'],$comp_id);
                                ?>
                                <tr>
                                    <td><?=++$n;?></td>
                                    <td><?= $row['request_id'];?></td>
                                    <td><?= $row['client_fullname'];?></td>
                                    <td><?= $row['beat_name'];?></td>
                                    <td><?= $clk_guard['guard_firstname']." ".$clk_guard['guard_middlename']." ".$clk_guard['guard_lastname']; ?></td>
                                    <td><?= $row['guard_firstname']." ".$row['guard_middlename']." ".$row['guard_lastname'];?></td>
                                    <td>
                                        <?php if($row['request_status'] == "Pending") { ?>
                                        <span class="badge badge-warning">Pending</span>
                                        <?php } elseif($row['request_status'] == "Declined") { ?>
                                        <span class="badge badge-danger">Declined</span>
                                        <?php } elseif($row['request_status'] == "Approved") { ?>
                                        <span class="badge badge-success">Approved</span>
                                        <?php } ?>
                                    </td>
                                    <td><?= $row['created_on'];?></td>
                                    <td>
                                        <?php if($row['request_status'] == "Pending"){ ?>
                                        <a href="javascript:void(0)" data-request_id="<?= $row['request_id'];?>" data-request_status="Approved" class="btn btn-sm btn-success clkOutRequestStatusBtn" id="">
                                            <i class="far fa-check-circle"></i> Approved
                                        </a>
                                        <a href="javascript:void(0)" data-request_id="<?= $row['request_id'];?>" data-request_status="Declined" class="btn btn-sm btn-danger clkOutRequestStatusBtn" id="">
                                            <i class="far fa-trash-alt"></i> Reject
                                        </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Request found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
</section>
<?php include_once("inc/footer.super.php"); ?>
<script>
setTimeout(function(){window.location.reload(1);}, 30000);
</script>
