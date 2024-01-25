<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Beat Supervisors</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>List Beat Supervisors</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">Beat Supervisors</h2>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <a href="<?= url_path('/company/create-beat-supervisor',true,true)?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Add New Beat Supervisor</a>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="">B.S => Beat Supervisor</label>
                            </div>
                        </div>
                        </div>
                    <table class="table table-bordered table-striped mb-0" id="datatable-company" style="font-size: 11px">
                        <thead>
                        <tr>
                            <th>s/n</th>
                            <th>B.S FirstName</th>
                            <th>B.S LastName</th>
                            <th>B.S Email</th>
                            <th>B.S Date</th>
                            <th>B.S Beats</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = $beat->get_all_beat_supervisors($c['company_id']);
                        if ($res->num_rows > 0) {$n=0;
                        while ($row = $res->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?=++$n;?></td>
                                <td><?= $row['bsu_firstname'];?></td>
                                <td><?= $row['bsu_lastname'];?></td>
                                <td><?= $row['bsu_email'];?></td>
                                <td><?= date("d/m/Y H:i", strtotime($row['bsu_created_at']));?></td>
                                <td>
                                <?php
                                $beat_arr = explode(',',$row['bsu_beats']);
                                $s = '';
                                foreach($beat_arr as $beat_id) {
                                    $beat_id = $beat->get_beat_by_id($beat_id,$c['company_id']);
                                    $beatName = $beat_id->fetch_assoc();
                                    echo $s . $beatName['beat_name'];
                                    $s = ', ';
                                }
                                ?>
                                </td>
                                <td>
                                    <a href="<?= url_path('/company/edit-beat-supervisor/'.$row['bsu_id'],true,true)?>"
                                       class="btn btn-xs btn-default"><i class="fas fa-pencil-alt">&nbsp;</i>
                                    </a>
                                    <a href="javascript:void(0)" data-bsu_id="<?= $row['bsu_id'];?>" class="btn btn-xs btn-danger" id="bsuDeleteBtn">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Beat supervisor found</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.com.php"); ?>