<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<?php
if (!isset($beat_id) ||$beat_id == NULL ) {echo "<script>window.location = '".url_path('/company/list-guards',true,true)."'; </script>";}
?>
<?php
$res_b = $beat->get_beat_by_id($beat_id,$c['company_id']);
if ($res_b->num_rows > 0) {
while ($row_b = $res_b->fetch_assoc()) {
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Deployed Guard List | <?=$row_b['beat_name'] ;?></h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Deployed Guard in <?=$row_b['beat_name'] ;?></span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title"><?=$row_b['beat_name'] ;?> Guards</h2>
                </header>
                <div class="card-body">
                    <table class="table table-bordered table-striped mb-0" id="datatable-company">
                        <thead>
                        <tr>
                            <th>s/n</th>
                            <th>First Name</th>
                            <th>Other Names</th>
                            <th>Phone</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = $guard->get_all_active_beat_guards($c['company_id'],$beat_id);
                        $staff_type = $client->get_staff_type($c['company_id']);
                        if ($res->num_rows > 0) {$n=0;
                        while ($row = $res->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?=++$n;?></td>
                                <td><?= $row['guard_firstname'];?></td>
                                <td><?= $row['guard_middlename']." ".$row['guard_lastname'];?></td>
                                <td><?= $row['phone'];?></td>
                                <?php  if($row['client_fullname'] != NULL && !empty($row['client_fullname'])){?>
                                    <td><?= $row['client_fullname'];?></td>
                                <?php }else{?>
                                    <td class="font-weight-bold text-warning">Not Deployed Yet</td>
                                <?php }?>
                                <td>
                                    <?=($row['guard_status'] =='Active')?
                                        '<span class="badge badge-success">Active</span>':
                                        '<span class="badge badge-danger">In-active</span>';?>
                                </td>
                                <td class="actions">
                                    <a href="<?= url_path('/company/edit-guard/'.$row['guard_id'],true,true);?>" class="btn btn-xs btn-default"><i class="fas fa-pencil-alt"></i> View</a>
                                    <a href="javascript:void(0)" data-guard_id="<?= $row['guard_id'];?>" class="on-default remove-row" id="guardDeleteBtn">
                                        <?php if ($staff_type['staff_type'] == 'Owner'){ ?>
                                            <i class="far fa-trash-alt"></i>
                                        <?php }?>
                                    </a>
                                </td>
                            </tr>
                        <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Guard found</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>