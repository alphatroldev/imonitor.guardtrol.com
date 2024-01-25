<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Client Login Profile</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Client Login Profile</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Client Login Details</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <a href="<?= url_path('/company/create-client-login',true,true)?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Create New Client Login</a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped mb-0" id="datatable-company" style="font-size: 11px">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Client ID</th>
                                <th>Client FullName</th>
                                <th>Client Phone</th>
                                <th>Client Email</th>
                                <th>Created On</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $client->get_all_client_login_profile($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><?= $row['clp_client_id'];?></td>
                                        <td><?= $row['client_fullname'];?></td>
                                        <td><?= $row['client_office_phone'];?></td>
                                        <td><?= $row['client_email'];?></td>
                                        <td><?= date("d/m/Y H:i", strtotime($row['clp_created_on']));?></td>
                                        <td>
                                            <a href="<?= url_path('/company/edit-client-login-profile/'.$row['clp_client_id'],true,true)?>"
                                               class="btn btn-xs btn-default"><i class="fas fa-pencil-alt">&nbsp;</i>
                                            </a>
                                            <a href="javascript:void(0)" data-clp_client_id="<?= $row['clp_client_id'];?>" class="btn btn-xs btn-danger" id="clpDeleteBtn">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Client Login Details Found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>