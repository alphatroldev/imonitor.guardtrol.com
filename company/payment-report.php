<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Payment History</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Payment History</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="javascript:void" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">Payment History</h2>
                </header>
                <div class="card-body">
                    <table class="table table-bordered table-striped mb-0" id="datatable-company">
                        <thead>
                        <tr>
                            <th>s/n</th>
                            <th>Receipt ID</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Client</th>
                            <th>Receipt</th>
                            <th>View</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $res = $company->get_payment_report($c['company_id']);
                        if ($res->num_rows > 0) {$n=0;
                            while ($row = $res->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?=++$n;?></td>
                                    <td><?= $row['receipt_id'];?></td>
                                    <td><?= date("jS M Y",strtotime($row['date']));?></td>
                                    <td>₦ <?= number_format($row['amount'],0);?></td>
                                    <td><?= $row['client_fullname'];?></td>
                                    <td>
                                        <a href="<?= url_path('/company/payment-receipt/'.$row['receipt_id'],true,true)?>"
                                           class="btn btn-xs btn-default"><i class="fas fa-print">&nbsp;</i>print receipt
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#modalClientPayment" data-rep_amt="<?= $row['amount'];?>" data-rep_client="<?= $row['client_fullname'];?>"
                                           data-rep_pay_met="<?= $row['payment_method'];?>" data-rep_receipt="<?= $row['receipt_id'];?>"
                                           data-rep_desc="<?= $row['remark'];?>" data-rep_date="<?= $row['date'];?>"
                                           class="btn btn-xs btn-info client_payment_details">view details</a>
                                    </td>
                                    <td class="actions">
                                        <a href="javascript:void(0)" data-receipt_id="<?= $row['receipt_id'];?>" data-comp_id="<?= $c['company_id'];?>"
                                             data-client_id="<?= $row['client_id'];?>" data-pay_amt="<?= $row['amount'];?>"
                                           class="btn btn-xs btn-danger text-white" id="payReceiptDeleteBtn">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No payment report found</td></tr>";} ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>
<div id="modalClientPayment" class="modal-block modal-block-primary mfp-hide">
    <div class="card">
        <header class="card-header">
            <h2 class="card-title">Payment Detail</h2>
        </header>
        <div class="card-body">
            <b>
                Amount : ₦ <span id="rep_amt"></span> <hr>
                Paid by : <span id="rep_client"></span> <hr>
                Payment Method: <span id="rep_pay_met"></span> <hr>
                Receipt ID: <span id="rep_receipt"></span> <hr>
                Description: <span id="rep_desc"></span> <hr>
                Transactions Date: <span id="rep_date"></span>
            </b>
        </div>
        <footer class="card-footer">
            <div class="row">
                <div class="col-md-12 text-end">
                    <button class="btn btn-default modal-dismiss">Close</button>
                </div>
            </div>
        </footer>
    </div>
</div>
<?php include_once("inc/footer.com.php"); ?>
<script src=<?= public_path("js/examples/examples.modals.js"); ?>></script>
<script>
    (function($) {
        'use strict';
        $('.client_payment_details').magnificPopup({
            type: 'inline',
            preloader: false,
            modal: true,
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in',
        });
    }).apply(this, [jQuery]);
</script>