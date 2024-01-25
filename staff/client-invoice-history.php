<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ../"); ?>
<?php
if (!isset($client_id) || $client_id == NULL ) {
    echo "<script>window.location = '".url_path('/staff/list-clients',true,true)."'; </script>";
}
?>
<?php
$clients = $client->get_client_by_id($client_id,$c['company_id']);
if ($clients->num_rows > 0) {
while ($client = $clients->fetch_assoc()) {
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>
            <a href="<?= url_path('/staff/edit-client/'.$client_id,true,true)?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>
            Invoice History
        </h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Invoice History</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">
                        <a href="<?= url_path('/staff/edit-client/'.$client_id,true,true)?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>
                        <?=$client['client_fullname'];?>
                    </h2>
                </header>
                <div class="card-body">
                    <table class="table table-bordered table-striped mb-0" id="datatable-company">
                        <thead>
                        <tr>
                            <th>s/n</th>
                            <th>Invoice ID</th>
                            <th>Client Name</th>
                            <th>Beat Name</th>
                            <th>Invoice Generated On</th>
                            <th>Dated</th>
                            <th>Invoice</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $history = $company->get_all_client_invoice_history($c['company_id'],$client_id);
                        if ($history->num_rows > 0) {$n=0;
                            while ($his = $history->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?=++$n;?></td>
                                    <td><?= $his['invoice_id'];?></td>
                                    <td><?= $his['client_fullname'];?></td>
                                    <td><?= $his['beat_name'];?></td>
                                    <td><?= date("jS F Y (h:i a)",strtotime($his['invoice_date']));?></td>
                                    <td><?= $company->time_elapsed_string($his['invoice_date']);?></td>
                                    <td>
                                        <a href="<?= url_path('/staff/invoice-preview/'.$his['client_id'].'/'.$his['invoice_id'],true,true)?>"
                                           class="btn btn-xs btn-default"><i class="fas fa-print">&nbsp;</i>print view
                                        </a>
                                    </td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" data-invoice_id="<?= $his['invoice_id'];?>" data-comp_id="<?= $c['company_id'];?>"
                                            data-client_id="<?= $his['client_id'];?>" data-invoice_amt="<?= $his['invoice_amt'];?>"
                                           class="btn btn-xs btn-danger text-white" id="invoiceDeleteBtn">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No client invoice history found</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.staff.php"); ?>
