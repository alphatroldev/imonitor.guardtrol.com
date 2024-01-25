<?php include_once("inc/header.sup.php"); ?>
<?php if (!isset($_SESSION['SUPPORT_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>APP Version List </h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?=url_path('/support/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>List APP Version</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">List APP Version</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="<?=url_path('/support/add-new-v',true,true);?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Upload New APP Version</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped mb-0" id="datatable-support">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>APP Name</th>
                                <th>Important Level</th>
                                <th>Version</th>
                                <th>APK Link2</th>
                                <th>Created On</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $support->get_all_new_apk_versions();
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    $url = "https://" . $_SERVER['SERVER_NAME']."/public/uploads/apkVersion/".$row['apk_file'];
                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><?= $row['app_name'];?></td>
                                        <td><?= $row['apk_importance'];?></td>
                                        <td><?= $row['apk_version'];?></td>
                                        <td><a href="<?=url_path('/support/download-apk/'.$row['apk_file'],true,true);?>" target="_blank">Click Here: To Download APP</a></td>
                                        <td><?= date("d/m/Y h:i a",strtotime($row['mob_created']));?></td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No APP Version found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.sup.php"); ?>