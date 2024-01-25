<?php include_once("inc/header.client.php"); ?>
<?php if (!isset($_SESSION['CLIENT_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Dashboard</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?=url_path('/client/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Dashboard</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-secondary">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-secondary">
                                        <i class="fas fa-user-lock"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Guard</h4>
                                        <strong class="amount"><?= $client->count_client_total_guard($comp_id,$cli_beats);?></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-tertiary mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-tertiary">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">TOTAL CLOCK-IN TODAY</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $client->count_client_total_clock_in_today($comp_id,$cli_beats); ?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-dark" href="javascript:void(0)">Today's Date: <b><?=date("d/M/Y");?></b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-primary mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-primary">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">TOTAL CLOCK-IN THIS MONTH</h4>
                                        <div class="info">
                                            <strong class="amount"><?= $client->count_client_total_clock_in_this_month($comp_id,$cli_beats)?></strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-dark" href="javascript:void(0)">Month: <b><?=date("F, Y");?></b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <section class="card card-featured card-featured-info mb-4">
                        <div class="card-body">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                <div>
                                    <i class="fas fa-comments fa-2x"></i>
                                    <span style="font-size: 18px">Route Notifications</span>
                                </div>
                                <div>
                                    <a href="<?= url_path('/client/routing-clock',true,true)?>" class="btn btn-default btn-sm">Filter with date</a>
                                </div>
                            </div>
                            <div>
                                <table class="table table-borderless mb-0" id="datatable-company">
                                    <thead>
                                    <tr>
                                        <th>s/n</th>
                                        <th>Guard Name</th>
                                        <th>Beat Name</th>
                                        <th>Route Name</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Route Status</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                    <tbody class="notification-menu">
                                    <?php
                                    $res = $client->get_client_guard_routing_report($comp_id,$cli_beats);
                                    if ($res->num_rows > 0) { $n=0;
                                        while ($row = $res->fetch_assoc()) {
                                            $clock_date = date("d-m-Y",strtotime($row['cp_created_on']));
                                            ?>
                                            <tr>
                                                <td><?=++$n;?></td>
                                                <td><b><?=$row['guard_firstname']." ".$row['guard_middlename']." ".$row['guard_lastname'];?></b></td>
                                                <td><?=$row['beat_name'] ." (".$row['client_fullname'].")";?></td>
                                                <td><?=$row['route_id'];?></td>
                                                <td><b><?= date("H:i:s",strtotime($row['start_time']));?></b></td>
                                                <td><b><?= date("H:i:s",strtotime($row['end_time']));?></b></td>
                                                <td><?=($row['route_status']=="Complete")?'<span class="badge badge-success">Completed</span>':
                                                        '<span class="badge badge-danger">Not completed</span>';?></td>
                                                <td><b><?=date("d/M/Y",strtotime($row['cp_created_on']));?></b></td>
                                            </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once("inc/footer.client.php"); ?>
<script>
    setTimeout(function(){window.location.reload(1);}, 30000);
</script>
