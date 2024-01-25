<?php ob_start(); session_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . "/../controllers/classes/Company.class.php");
include_once($filepath . "/../../controllers/classes/Staff.class.php");
include_once($filepath . "/../../controllers/classes/Beat.class.php");
include_once($filepath . "/../../company/inc/helpers.php");
include_once($filepath . "/../../staff/inc/helpers.php");
date_default_timezone_set('Africa/Lagos'); // WAT
if (isset($_SESSION['COMPANY_LOGIN'])){
    $c = get_company();
}else{
    $c = get_staff();
}
?>
<?php
if (!isset($invoice_id) || $invoice_id == NULL || !isset($client_id) || $client_id == NULL ) {
    echo "<script>window.location = '".url_path('/staff/invoice-history',true,true)."'; </script>";
}
?>
<html>
<head>
    <title><?=$c['company_name'];?> - Invoice Print</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/invoice-print.css" />
    <style>
        .container_img {position: relative;width: 100%;}
        .sticker_img{position: absolute;top:0;left:20%;width:120px;}
        .break{page-break-before:always;}
    </style>
</head>
<body>
<div class="invoice">
    <?php $inv = $company->get_all_invoice_print_details($invoice_id,$c['company_id'],$client_id); ?>
    <header class="clearfix container_img">
        <div class="row">
            <div class="col-sm-6 mt-3" style="font-size: 10px;">
                <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">INVOICE</h2>
                <h4 class="h4 m-0 text-dark font-weight-bold">#<?=$invoice_id;?></h4>
            </div>
            <div class="col-sm-6 text-end mt-3 mb-0" style="display: flex;text-align: right;justify-content: flex-end;font-size: 10px;">
                <address class="ib me-5">
                    <?=$inv['company_name'];?><br/>
                    <?=$inv['company_address'];?><br/>
                    Phone: <?=$inv['company_phone'];?><br/>
                    <?=$inv['company_email'];?>
                </address>
                <div class="ib">
                    <?php if ($inv['company_logo'] != null && $inv['company_logo'] != ""){?>
                        <img src="<?=public_path('uploads/company/'.$inv['company_logo']);?>" style="max-width: 174px" alt="<?=$inv['company_name'];?> Logo" />
                    <?php } ?>
                    <?php if ($inv['invoice_status'] == "Paid"){?>
                        <img src="<?=public_path('img/paid_stamp_sticker.png');?>" class="sticker_img" alt="Paid Sticker" />
                    <?php } else { ?>
                        <img src="<?=public_path('img/unpaid-stamp-sticker.png');?>" class="sticker_img" alt="Unpaid Sticker" />
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>
    <div class="bill-info" style="font-size: 10px;">
        <div class="row">
            <div class="col-md-6">
                <div class="bill-to">
                    <p class="h5 mb-1 text-dark font-weight-semibold">Billing To:</p>
                    <address>
                        <?=$inv['client_fullname'];?>
                        <br/>
                        <?=$inv['client_office_address'];?>
                        <br/>
                    </address>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bill-data text-end">
                    <p class="mb-0">
                        <span class="text-dark">Invoice Date:</span>
                        <span class="value" style="width: 150px;"><?= date("jS F Y",strtotime($inv['invoice_date']));?></span>
                    </p>
                    <p class="mb-0">
                        <span class="text-dark">Amount Due:</span>
                        <span class="value" style="width: 150px; font-weight: bolder">
                            <?php
                            $a_due = $company->sum_all_amount_due_client($invoice_id);
                            echo "₦ ".number_format($a_due['net_pay']+$a_due['inv_vat'],2);
                            ?>
                        </span>
                    </p>
                    <p class="mb-0">
                        <span class="text-dark">TIN No:</span>
                        <span class="value" style="width: 150px;"><?=$inv['company_tax_id_no'];?></span>
                    </p>
                    <p class="mb-0">
                        <span class="text-dark">Status:</span>
                        <span class="value" style="width: 150px;font-weight: bolder">
                            <?=($inv['invoice_status']=='Paid')?"<span class='text-success'>Paid</span>":"<span class='text-danger'>Pending</span>";?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-responsive-md invoice-items" style="font-size: 10px;">
        <thead>
        <tr class="text-dark">
            <th id="cell-id"     class="font-weight-semibold" style="width: 3%">s/n</th>
            <th id="cell-price"   class="font-weight-semibold" style="width:11%">Beat Name</th>
            <th id="cell-desc"   class="font-weight-semibold" style="width:40%">Description</th>
            <th id="cell-price"  class="text-center font-weight-semibold">No. of Personnel</th>
            <th id="cell-total"  class="text-center font-weight-semibold">V.A.T</th>
            <th id="cell-total"  class="text-center font-weight-semibold">Total Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $det = $company->get_all_invoice_history_details($invoice_id);
        if ($det->num_rows > 0) {$n=0;
            while ($detail = $det->fetch_assoc()) {
                ?>
                <tr>
                    <td><?=++$n;?></td>
                    <td class="font-weight-semibold text-dark"><?=$detail['beat_name'];?></td>
                    <td><?=$detail['description'];?>
                        <ul>
                            <?php
                            $per = $beat->get_all_beat_personnel($c['company_id'],$detail['beat_id']);
                            if ($per->num_rows > 0) {
                                while ($personnel = $per->fetch_assoc()) {
                                    ?>
                                    <li><?=$personnel['personnel_type'];?> Qty - <?=$personnel['no_of_personnel'];?> (₦<?=number_format($personnel['amt_per_personnel'],0);?>)</li>
                                <?php } } ?>
                        </ul>
                    </td>
                    <td class="text-center"><?=$detail['no_of_personnel'];?></td>
                    <td class="text-center">₦<?=number_format($detail['inv_vat'],2); ?></td>
                    <td class="text-center">₦<?=number_format($detail['total_due'],2); ?></td>
                </tr>
            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No invoice history found</td></tr>";} ?>
        </tbody>
    </table>
    <div class="invoice-summary" style="font-size: 10px;">
        <div class="row justify-content-end">
            <div class="col-sm-5">
                <table class="table text-dark">
                    <tbody>
                    <tr class="b-top-0">
                        <td colspan="2">Subtotal</td>
                        <td class="text-left">
                            <?php
                            $a_due = $company->sum_all_amount_due_client($invoice_id);
                            echo "₦ ".number_format($a_due['total_due'],1);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Invoice Credit</td>
                        <td class="text-left">
                            <?php
                            $a_due = $company->sum_all_amount_due_client($invoice_id);
                            echo "₦ ".number_format($a_due['credit_charges'],2);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Invoice Debit</td>
                        <td class="text-left">
                            <?php
                            $a_due = $company->sum_all_amount_due_client($invoice_id);
                            echo "₦ ".number_format($a_due['debit_charges'],2);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">V.A.T Total</td> 
                        <td class="text-left">
                            <?php
                            $a_due = $company->sum_all_amount_due_client($invoice_id);
                            echo "₦ ".number_format($a_due['inv_vat'],2);
                            ?>
                        </td>
                    </tr>
                    <tr class="font-weight-bold">
                        <td colspan="2">Balance Due</td>
                        <td class="text-left">
                            <?php
                            $a_due = $company->sum_all_amount_due_client($invoice_id);
                            echo "₦ ".number_format(($a_due['net_pay']+$a_due['inv_vat']),2);
                            ?>
                        </td>
                    </tr>
                    <tr class="font-weight-bold">
                        <td colspan="2">Outstanding Balance</td>
                        <td class="text-left">
                            <?php echo "₦ ".number_format($inv['add_to_invoice'],2); ?>
                        </td>
                    </tr>
                    <tr class="font-weight-bold">
                        <td colspan="2">Balance Due + Outstanding</td>
                        <td class="text-left">
                            <?php echo "₦ ".number_format(($a_due['net_pay']+$a_due['inv_vat']+$inv['add_to_invoice']),2); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="invoice-summary" style="font-size: 13px;">
        <?php
        $res = $company->get_active_company_invoice_account($c['company_id']);
        if (!empty($res)){
        ?>
        <div class="col-sm-6 px-5">
            <span class="text-uppercase font-weight-bold">A/C NO</span><br/>
            <span class="text-uppercase font-weight-bold"><?=$inv['inv_account_name'];?></span><br/>
            <span class="text-uppercase font-weight-bold"><?=$inv['inv_bank_name'];?>,</span><br/>
            <span class="text-uppercase font-weight-bold"><?=$inv['inv_account_no'];?></span>
            <br/><br/>
            For <?=$inv['company_name'];?>
            <br/>
        </div>
         <?php } else {?>
        <div class="col-sm-6 px-5"><span class="text-uppercase font-weight-bold">No Active Data</span></div>
        <?php } ?>
    </div>
</div>
<script>window.print();</script>
</body>
</html>