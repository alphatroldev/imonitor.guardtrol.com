<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ../"); ?>
<?php
if (!isset($receipt_id) || $receipt_id == NULL ) {
    echo "<script>window.location = '".url_path('/staff/payment-report',true,true)."'; </script>";
}
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>
            <a href="<?= url_path('/staff/payment-report',true,true)?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>
            Payment Receipt
        </h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Payment Receipt</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
            <div class="invoice">
                <?php
                $receipt = $company->get_client_payment_report_by_receipt_id($c['company_id'],$receipt_id);
                ?>
                <header class="clearfix">
                    <div class="row">
                        <div class="col-sm-6 mt-3">
                            <?php if ($receipt['company_logo'] != null && $receipt['company_logo'] != ""){?>
                                <img src="<?=public_path('uploads/company/'.$receipt['company_logo']);?>" style="max-width: 174px" alt="<?=$receipt['company_name'];?> Logo" />
                            <?php } ?>
                        </div>
                        <div class="col-sm-6 text-end mt-3 mb-3">
                            <address class="ib">
                                <?=$receipt['company_name'];?>. <br>
                                <?=$receipt['company_address'];?>,  <br>
                                <?=$receipt['company_op_state'];?> <br>
                                <?=$receipt['company_phone'];?> <br>
                                Email:<?=$receipt['company_email'];?> <br>
                            </address>
                        </div>
                    </div>
                </header>
                <div class="bill-info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="bill-to">
                                <address>
                                    <?=$receipt['client_fullname'];?>
                                    <br/>
                                    ID: <?=$receipt['client_id'];?>
                                    <br/>
                                    <?=$receipt['client_office_phone'];?>
                                    <br/>
                                    <?=$receipt['client_email'];?>
                                </address>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bill-data text-end">
                                <p class="mb-0"><span class="text-dark">RECEIPT</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive-md invoice-items">
                    <p class="h5 mb-1 font-weight-semibold pb-3 bg-dark text-light p-2">Description</p>
                    <tbody>
                    <tr>
                        <td class="font-weight-bold text-uppercase"><?=$receipt['remark'];?></td>
                    </tr>
                    </tbody>
                </table>
                <div class="invoice-summary">
                    <div class="row justify-content-end">
                        <div class="col-sm-4">
                            <p class="h5 mb-1 text-danger font-weight-semibold pb-3">Amount Paid: ₦ <?=number_format($receipt['amount'],0);?></p>
                            <p class="mb-1 text-dark pb-3 text-sm">SIGNATURE</p>
                        </div>
                    </div>
                </div>
                <div class="payment-report">
                    <div class="row justify-content-start">
                        Thank you for your patronage! <br>
                        Reference ID :<?=$receipt['receipt_id'];?> <br>
                        Date:<?= date("jS F Y", strtotime($receipt['date']));?>
                    </div>
                </div>
                <div class="d-grid gap-3 d-md-flex justify-content-md-end me-4">
                    <a href="<?=url_path('/staff/payment-receipt-preview/'.$receipt['receipt_id'],true,true)?>" target="_blank"
                       class="btn btn-primary ms-3 px-3"><i class="fas fa-print"></i> Print</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once("inc/footer.staff.php"); ?>

