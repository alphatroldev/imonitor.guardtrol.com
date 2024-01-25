<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ../"); ?>
<?php
if (!isset($invoice_id) || $invoice_id == NULL) {
    echo "<script>window.location = '".url_path('/staff/invoice-history',true,true)."'; </script>";
}
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>
            <a href="<?= url_path('/staff/invoice-history',true,true)?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>
            Invoice Details: <?= $invoice_id;?>
        </h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt">&nbsp;&nbsp;</i></a></li>
                <li><span>Invoice Details </span></li>
                <li><span><?= $invoice_id;?></span></li>
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
                        <a href="<?= url_path('/staff/invoice-history',true,true)?>"><i class="fas fa-arrow-left"></i></a>
                        Invoice Details: <?= $invoice_id;?>
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
                            <th>Amount Paid</th>
                            <th>Dated</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = $company->get_all_invoice_history_details($invoice_id);
                        if ($res->num_rows > 0) {$n=0;
                            while ($row = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?=++$n;?></td>
                                    <td><?= $row['invoice_id'];?></td>
                                    <td><?= $row['client_fullname'];?></td>
                                    <td><?= $row['beat_name'];?></td>
                                    <td><?= date("jS F Y (h:i a)",strtotime($row['invoice_date']));?></td>
                                    <td class="text-success">₦<?=number_format($row['balance'],2);?></td>
                                    <td><?= $company->time_elapsed_string($row['invoice_date']);?></td>
                                    <td>
                                        <a href="<?= url_path('/staff/invoice-preview/'.$row['client_id'].'/'.$row['invoice_id'],true,true)?>"
                                           class="btn btn-xs btn-default"><i class="fas fa-print">&nbsp;</i> print view
                                        </a>
                                    </td>
                                </tr>
                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No invoice details found</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.staff.php"); ?>
