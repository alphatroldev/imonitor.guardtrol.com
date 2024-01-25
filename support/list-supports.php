<?php include_once("inc/header.sup.php"); ?>
<?php if (!isset($_SESSION['SUPPORT_LOGIN'])) header("Location: ./"); ?>
<?php if ($_SESSION['SUPPORT_LOGIN']['support_super'] != 'Yes') header("Location: dashboard"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Support List</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?=url_path('/support/main',true,true);?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>List supports</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">List Supports</h2>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <a href="<?=url_path('/support/create',true,true);?>" class="btn btn-primary"><i class="fas fa-plus">&nbsp;&nbsp;</i>Add New Support</a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped mb-0" id="datatable-support">
                        <thead>
                        <tr>
                            <th>s/n</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Account Type</th>
                            <th>Status</th>
                            <th>Created On</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = $support->get_all_support_account($_SESSION['SUPPORT_LOGIN']['support_sno']);
                            if ($res->num_rows > 0) {$n=0;
                            while ($row = $res->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?=++$n;?></td>
                                <td><?= $row['support_name'];?></td>
                                <td><?= $row['support_email'];?></td>
                                <td>
                                    <?=($row['support_super'] =='Yes')?'Super':'Normal';?>
                                </td>
                                <td>
                                    <?=($row['support_active'] =='Yes')?
                                        '<span class="badge badge-success">Active</span>':
                                        '<span class="badge badge-danger">In-Active</span>';?>
                                </td>
                                <td><?= date("d/m/Y h:i a",strtotime($row['support_created_on']));?></td>
                                <td class="actions">
                                    <a href="<?= url_path('/support/edit/'.$row['support_id'],true,true);?>" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="#" data-s_id="<?= $row['support_id'];?>" class="on-default remove-row" id="supportDeleteBtn">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                                    <?php if ($row['support_active'] =='Yes'){ ?>
                                        <button data-s_id="<?=$row['support_id'];?>" title="Deactivate support account" data-active="No" class="btn btn-xm btn-danger px-1 py-0" id="supportStatusBtn">
                                            Disable
                                        </button>
                                    <?php } else { ?>
                                        <button data-s_id="<?=$row['support_id'];?>" title="Activate support account" data-active="Yes" class="btn btn-xm btn-success px-1 py-0" id="supportStatusBtn">
                                            Activate
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No support found</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.sup.php"); ?>