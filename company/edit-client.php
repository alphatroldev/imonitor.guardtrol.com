<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>

<?php
if (!isset($client_id) || $client_id == NULL ) {echo "<script>window.location = '".url_path('/company/list-clients',true,true)."'; </script>";}
?>

<?php
$res = $client->get_client_by_id($client_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <section role="main" class="content-body">
            <header class="page-header">
                <h2><?=$row['client_fullname'] ;?></h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                        <li><span><a href="<?= url_path('/company/list-clients',true,true)?>">Clients</a></span></li>
                        <li><span>Edit Client</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <div class="row">
                <div class="col-lg-4 col-xl-4 mb-4 mb-xl-0">
                    <section class="card">
                        <div class="card-body">
                            <div class="thumb-info mb-3">
                                <img src="<?=public_path('uploads/client/'.$row['client_photo']);?>" class="rounded img-fluid" alt="<?=$row['client_fullname'];?>">
                                <div class="thumb-info-title">
                                    <span class="thumb-info-inner"><?=$row['client_fullname'];?></span>
                                    <span class="thumb-info-type"></span>
                                    <?=($row['client_status'] !=='Active')? '<span class="thumb-info-type">(Client Not Active)</span>': '';?>
                                </div>
                            </div>

                            <hr class="dotted short">
                            <p><span class="fw-bold">Client ID</span>  <span class="pull-right text-primary staff_id_val"><?=$client_id;?></span> </p>
                            <p><span class="fw-bold">Client Since</span>  <span class="pull-right text-primary"><?= $client->time_elapsed_string($row['created_at']);?></span> </p>
                            <hr class="dotted short">
                            <form name="client_profile_upload" id="client_profile_upload" enctype="multipart/form-data">

                                <input type="file" id="client_profile_picx_update" name="client_profile_picx_update" style="display:none"/>
                                <input type="hidden" name="client_id" id="client_id" value="<?= $row['client_id'] ?>" />
                                <input type="hidden" name="cname" id="gname" value="<?= $row['client_fullname'] ?>" />
                                <input type="hidden" name="cphone" id="gphone" value="<?= $row['client_office_phone'] ?>" />
                                <input type="button" class="btn btn-primary col-md-12" id="propicxUpload" value="Update Photo" />
                            </form>
                        </div>
                    </section>

                    <section class="card">
                        <header class="card-header">
                            <div class="card-actions">
                                <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                            </div>
                            <h2 class="card-title">
                                <span class="va-middle">ACTIONS</span>
                            </h2>
                        </header>
                        <div class="card-body">
                            <div class="content">
                                <ul class="simple-user-list">
                                    <li>
                                        <a href="<?= url_path('/company/print-client-profile/'.$row['client_id'],true,true);?>">
                                            <figure class="image rounded"><i class="fas fa-print"></i></figure>
                                            <span class="title">Print Profile</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="" href="<?= url_path('/company/create-beat/'.$row['client_id'],true,true);?>">
                                            <figure class="image rounded">
                                                <i class="fas fa-plus"></i>
                                            </figure>
                                            <span class="title">Add Beat</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a data-client_id="<?= $row['client_id'];?>" class="modal-with-move-anim ws-normal" href="#changeStatus" id="clientStatusBtn">
                                            <figure class="image rounded">
                                                <i class="fas fa-user-alt"></i>
                                            </figure>
                                            <span class="title">Change Client Status</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#clientConfirmPayment">
                                            <figure class="image rounded">
                                                <i class="fas fa-money-bill-wave-alt"></i>
                                            </figure>
                                            <span class="title">Confirm Payment</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="invCreditModal" href="#clientInvoiceDebCre">
                                            <figure class="image rounded">
                                                <i class="fas fa-credit-card"></i>
                                            </figure>
                                            <span class="title">Invoice Debit/Credit</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a class="modal-with-move-anim ws-normal" href="#listActiveDebCre">
                                            <figure class="image rounded">
                                                <i class="fas fa-list-alt"></i>
                                            </figure>
                                            <span class="title">List Active Debit/Credit</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a href="<?= url_path('/company/client-debtors-ledger/'.$client_id,true,true)?>">
                                            <figure class="image rounded">
                                                <i class="fas fa-money-check-alt"></i>
                                            </figure>
                                            <span class="title">View Debtors Ledger</span>
                                        </a>
                                    </li>
                                    <hr class="dotted short">
                                    <li>
                                        <a href="<?= url_path('/company/client-invoice-history/'.$client_id,true,true)?>">
                                            <figure class="image rounded"><i class="fas fa-users"></i></figure>
                                            <span class="title">View Invoice History</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </section>
                    <!-- Issue Loan Animation -->
                    <div id="issueLoan" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="guard_issue_loan" id="guard_issue_loan" class="card">
                            <header class="card-header"><h2 class="card-title">Issue Guard Loan</h2></header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group">
                                        <label for="loanAmount">Loan Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₦</span>
                                            <input type="text" class="form-control" id="loanAmount" name="loan_amount" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="loanAmount">Loan Duration <small class="text-info">(Loan payment duration in months)</small></label>
                                        <input type="text" class="form-control" id="loanDuration" name="loan_duration" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <label for="loanMonthlyAmount">Monthly Repayment Amount</label>
                                        <small class="text-info"> (amount must be whole number)</small>
                                        <div class="input-group">
                                            <span class="input-group-text">₦</span>
                                            <input type="text" class="form-control" id="loanMonthlyAmount" name="loan_monthly_amount" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="loanReason">Reason</label>
                                        <textarea name="loan_reason" id="loanReason" cols="30" rows="3" class="form-control"></textarea>
                                        <input type="hidden" name="client_id" value="<?=$row['client_id'];?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Submit">
                                        <button class="btn btn-default modal-dismiss">Close</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>

                    <!-- Confirm Payment -->
                    <div id="clientConfirmPayment" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="clientConfirmPayment" id="clientConfirmPayment" class="card">
                            <header class="card-header">
                                <h2 class="card-title">Confirm Client Payment</h2>
                            </header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group mb-4">
                                        <label for="con-client-pay-amt">Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₦</span>
                                            <input type="text" class="form-control" id="con-client-pay-amt" name="con_client_pay_amt" />
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="con-client-pay-method">Payment Method</label>
                                        <select class="form-control con_client_pay_method" id ="con-client-pay-method" name="con_client_pay_method">
                                            <option value=""></option>
                                            <option value="Bank Draft">Bank Draft</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Cash">Cash</option>
                                        </select>
                                    </div>
                                    <div class="form-group row_pay_met row mb-4">
                                        <div class="col-sm-6 form-group border-0">
                                            <label for="cheque_no">Cheque Number</label>
                                            <input type="text" class="form-control" id="cheque_no" name="cheque_no">
                                        </div>
                                        <div class="col-sm-6 form-group border-0 pt-3 pt-sm-0">
                                            <label for="bank_name">Bank</label>
                                            <input type="text" class="form-control" id="bank_name" name="bank_name">
                                        </div>
                                    </div>
                                    <div class="form-group row_pay_met pt-3 pt-sm-0 border-0">
                                        <label for="receive_name">Name of Receiver</label>
                                        <input type="text" class="form-control" id="receive_name" name="receive_name">
                                    </div>
                                    <div class="form-group row_pay_met_name pt-3 pt-sm-0 border-0">
                                        <label for="receive_name_2">Name of Receiver</label>
                                        <input type="text" class="form-control" id="receive_name_2" name="receive_name_2">
                                    </div>
                                    <div class="form-group ">
                                        <label for="con-client-pay-date">Date</label>
                                        <input type="date" class="form-control" id="con_client_pay_date" name="con_client_pay_date">
                                    </div>
                                    <div class="form-group">
                                        <label for="con-client-pay-remark">Comment / Remark</label>
                                        <textarea name="con_client_pay_remark" rows="2" id="con-client-pay-remark"
                                                  class="form-control" placeholder="Comment / Remark"></textarea>
                                        <input type="hidden" name="client_id" id="client_id" value="<?=$row['client_id'];?>" />
                                        <input type="hidden" name="comp_id" id="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Confirm" />
                                        <button class="btn btn-default modal-dismiss">Cancel</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>

                    <!-- Invoice Debit/Credit -->
                    <div id="clientInvoiceDebCre" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="InvoiceDebitCredit" id="InvoiceDebitCredit" class="card">
                            <header class="card-header"><h2 class="card-title">Issue Invoice Debit/Credit</h2></header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group border-0">
                                        <label class="control-label pt-1" for="beat_id">Select Beat <span class="required">*</span></label>
                                        <select data-plugin-selectTwo class="form-control populate" name="beat_id" id="beat_id">
                                            <option value=""></option>
                                            <?php
                                            $res3 = $company->get_all_company_beats($c['company_id']);
                                            if ($res3->num_rows > 0) {$n=0;
                                            while ($row3 = $res3->fetch_assoc()) {
                                            ?>
                                            <option value="<?= $row3['beat_id']?>"><?= $row3['beat_name'];?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                    <div class="form-group border-0">
                                        <label for="">D/C Category <span class="required">*</span></label>
                                        <div class="col-lg-6">
                                            <div class="radio-custom radio-success">
                                                <input type="radio" id="radioCt1" name="dc_category" value="Credit" checked>
                                                <label for="radioCt1">Credit</label>
                                            </div>
                                            <div class="radio-custom radio-warning">
                                                <input type="radio" id="radioCt2" name="dc_category" value="Debit">
                                                <label for="radioCt2">Debit</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row border-0">
                                        <div class="col-sm-6 row_chr_days">
                                            <div class="form-group border-0">
                                                <label class="col-form-label" for="cred_amt">Credit Amount</label>
                                                <input type="text" name="cred_amt" id="cred_amt" class="form-control" value="0" title="Enter Amount" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6 row_chr_amt">
                                            <div class="form-group border-0">
                                                <label class="col-form-label" for="deb_amt">Debit Amount</label>
                                                <input type="text" name="deb_amt" id="deb_amt" class="form-control" value="0" title="Enter Amount" />
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6 border-0">
                                            <label class="col-form-label" for="no_guard">No of guard</label>
                                            <input type="text" name="no_guard" id="no_guard" class="form-control" title="number of guard" value="1" />
                                        </div>
                                    </div>
                                    <div class="form-group border-0">
                                        <label class="control-label pt-1" for="">Charge Date Range<span class="required">*</span></label>
                                        <div class="input-daterange input-group" data-plugin-datepicker="">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="text" class="form-control" name="start" placeholder="From" aria-label="">
                                            <span class="input-group-text border-start-0 border-end-0 rounded-0">to</span>
                                            <input type="text" class="form-control" name="end" aria-label="">
                                        </div>
                                    </div>
                                    <div class="form-group border-0">
                                        <label for="dc_reason"><span class="Cate"></span> Reason/Comment</label>
                                        <textarea name="dc_reason" rows="5" id="dc_reason" class="form-control" maxlength="25" placeholder="Reason/comment"></textarea>
                                        <input type="hidden" name="client_id" value="<?=$client_id;?>" />
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Save" />
                                        <button class="btn btn-default modal-dismiss">Close</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>

                    <!-- List Active Debit/Credit -->
                    <div id="listActiveDebCre" class="zoom-anim-dialog modal-block modal-block-full modal-block-primary mfp-hide">
                        <div class="card">
                            <header class="card-header"><h2 class="card-title">List <?=$row['client_fullname'];?> Debit/Credit</h2></header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <table class="table table-bordered table-no-more mb-0" id="">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Beat ID</th>
                                            <th>Category</th>
                                            <th>Reason</th>
                                            <th>Amount</th>
                                            <th>Guard No</th>
                                            <th>Month</th>
                                            <th>Year</th>
                                            <th>Create Date</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $res2 = $company->get_all_client_debit_credit($client_id,$c['company_id']);
                                        if ($res2->num_rows > 0) {$n=0;
                                            while ($row2 = $res2->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td data-title="sno">#<?=++$n;?></td>
                                                    <td data-title="Beat ID"><?= $row2['beat_id'];?></td>
                                                    <td data-title="Category"><?= $row2['dc_category'];?></td>
                                                    <td data-title="Reason"><?= $row2['dc_reason'];?></td>
                                                    <td data-title="Amount">₦<?= ( $row2['dc_category'] == 'Debit')? number_format($row2['charge_amt'],0):number_format($row2['chr_days_amt'],0);?></td>
                                                    <td data-title="Guard No"><?= $row2['num_of_guard'];?></td>
                                                    <td data-title="Month"><?= $row2['dc_month'];?></td>
                                                    <td data-title="Year"><?= $row2['dc_year'];?></td>
                                                    <td data-title="Create Date"><?= $row2['dc_created_on'];?></td>
                                                    <td data-title="Actions" class="actions">
                                                        <a href="javascript:void(0)" data-inv_dc_sno="<?= $row2['inv_dc_sno'];?>" data-comp_id="<?=$c['company_id'];?>"
                                                           class="btn btn-danger text-white" id="DebCredDeleteBtn">delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Credit/Debit found</td></tr>";} ?>
                                        </tbody>
                                    </table>
                                </div>
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

                    <!-- Change Status -->
                    <div id="changeStatus" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                        <form name="changeClientStatus" id="changeClientStatus" class="card">
                            <header class="card-header"><h2 class="card-title">Change Status</h2></header>
                            <div class="card-body">
                                <div class="modal-wrapper py-0">
                                    <div class="form-group">
                                        <label for="clientStatus">Status</label>
                                        <select class="form-control" name="clientStatus" id="clientStatus">
                                            <?php if($row['client_status']=="Active"){?>
                                                <option value="<?=$row['client_status'];?>">Active</option>
                                            <?php }else{?>
                                                <option value="<?=$row['client_status'];?>">Deactivated</option>
                                            <?php }?>

                                            <?php if($row['client_status']=="Active"){?>
                                                <option value="Deactivate">Deactivate</option>
                                            <?php }else{?>
                                                <option value="Active">Reactivate</option>
                                            <?php }?>
                                        </select>
                                        <input type="hidden" name="client_id" id="client_id_mod" value="<?=$row['client_id'];?>" /><br>
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Contract <?=($row['client_status']=="Active"?"Terminated":"Re-activated");?> On</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="text" data-plugin-datepicker="" name="term_date" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="clientStatusRemark">Remark/Reason</label>
                                        <textarea name="clientStatusRemark" rows="2" id="clientStatusRemark" class="form-control" placeholder="Remark" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <input type="submit" class="btn btn-primary" value="Update">
                                        <button class="btn btn-default modal-dismiss">Cancel</button>
                                    </div>
                                </div>
                            </footer>
                        </form>
                    </div>

                </div>
                <div class="col-lg-8">
                    <div class="tabs">
                        <ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link" data-bs-target="#clientInfo" href="#clientInfo" data-bs-toggle="tab">Client Info.</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#clientContactInfo" href="#clientContactInfo" data-bs-toggle="tab">Client Contact Info.</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#clientOfficialInfo" href="#clientOfficialInfo" data-bs-toggle="tab">Client official Info.</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-target="#clientBeats" href="#clientBeats" data-bs-toggle="tab">Client Beats</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="clientInfo" class="tab-pane active">
                                <form name="update_client_info" id="update_client_info">
                                    <div class="card-body">
                                        <div id="response-alert"></div>

                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Full Name <span class="required">*</span></label>
                                                    <input type="text" name="edit_client_full_name" class="form-control" title="Please enter client name" value="<?=$row['client_fullname'] ;?>" />
                                                    <input type="hidden" name="id" value="<?=$row['id'];?>" />
                                                    <input type="hidden" name="client_id" value="<?=$row['client_id'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Office Address  <span class="required">*</span></label>
                                                    <input type="text" name="edit_client_office_address" class="form-control" title="Please enter client office address" value="<?=$row['client_office_address'] ;?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Office Phone <span class="required">*</span></label>
                                                    <input type="number" name="edit_client_office_phone" class="form-control" title="Please enter phone number" value="<?=$row['client_office_phone'];?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Email address <span class="required">*</span></label>
                                                    <input type="email" name="edit_client_email" class="form-control" title="Please enter email address" value="<?=$row['client_email'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer class="card-footer">
                                        <div class="row mt-2">
                                            <div class="col-sm-9">
                                                <input class="btn btn-primary px-5" type="submit" value="Update Profile" />
                                            </div>
                                        </div>
                                    </footer>
                                </form>
                            </div>
                            <!-- Client Contact's Info -->
                            <div id="clientContactInfo" class="tab-pane">
                                <form name="update_client_contact_info" id="update_client_contact_info">
                                    <div class="card-body">
                                        <div id="response-alert"></div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Client Representative Fullname <span class="required">*</span></label>
                                                    <input type="text" name="edit_client_contact_full_name" class="form-control" title="Required" value="<?=$row['client_contact_fullname'] ;?>" />
                                                    <input type="hidden" name="id" value="<?=$row['id'];?>" />
                                                    <input type="hidden" name="client_id" value="<?=$row['client_id'];?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Client Representative Position<span class="required">*</span></label>
                                                    <input class="form-control" name="edit_client_contact_position" title="Position 1" value="<?= $row['client_contact_position'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Client Representative Phone <span class="required">*</span></label>
                                                    <input type="number" name="edit_client_contact_phone" class="form-control" title="Required" value="<?=$row['client_contact_phone'];?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Client Representative Email<span class="required">*</span></label>
                                                    <input type="email" name="edit_client_contact_email" class="form-control" title="Required" value="<?=$row['client_contact_email'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Client Contact's Fullname 2</label>
                                                    <input type="text" name="edit_client_contact_full_name_2" class="form-control" title="Required" value="<?=$row['client_contact_fullname_2'];?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="col-form-label" for="">Client Contact's Position 2<span class="required">*</span></label>
                                                <input class="form-control" name="edit_client_contact_position_2" title="" value="<?= $row['client_contact_position_2'];?>" />
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Client Representative Phone 2</label>
                                                    <input type="number" name="edit_client_contact_phone_2" class="form-control" title="Required" value="<?=$row['client_contact_phone_2'];?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Client Representative Email 2</label>
                                                    <input type="email" name="edit_client_contact_email_2" class="form-control" title="Required" value="<?=$row['client_contact_email_2'];?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Client Representative Fullname 3</label>
                                                    <input type="text" name="edit_client_contact_full_name_3" class="form-control" title="Required" value="<?=($row['client_contact_fullname_3']!="null")?$row['client_contact_fullname_3']:"";?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <label class="col-form-label" for="">Client Representative Position 3<span class="required">*</span></label>
                                                <input class="form-control" name="edit_client_contact_position_3" value="<?= $row['client_contact_position_3'];?>" />
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Client Representative Phone 3</label>
                                                    <input type="number" name="edit_client_contact_phone_3" class="form-control" title="Required" value="<?=($row['client_contact_phone_3']!="null")?$row['client_contact_phone_3']:"";?>" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Client Representative Email 3</label>
                                                    <input type="email" name="edit_client_contact_email_3" class="form-control" title="Required" value="<?=($row['client_contact_email_3']!="null")?$row['client_contact_email_3']:"";?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <footer class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <input class="btn btn-primary px-5" type="submit" value="Update Profile" />
                                            </div>
                                        </div>
                                    </footer>
                                </form>
                            </div>
                            <!-- Client Official Info -->
                            <div id="clientOfficialInfo" class="tab-pane">
                                <form name="update_client_official_info" id="update_client_official_info">
                                    <div class="card-body">
                                        <div id="response-alert"></div>
                                        <div class="form-group row pb-3">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">Client Photo <span class="required">*</span></label>
                                                    <input type="file" name="edit_client_photo" class="form-control" value="<?=$row['client_photo'] ;?>" id="w1-photo"/>
                                                    <input type="hidden" name="id" value="<?=$row['id'];?>" />
                                                    <input type="hidden" name="client_id" value="<?=$row['client_id'];?>" />
                                                    <input type="hidden" name="client_fullname" value="<?=$row['client_fullname'];?>" />
                                                    <input type="hidden" name="client_photo" value="<?=$row['client_photo'];?>" />
                                                    <a class="mb-1 mt-1 me-1 modal-basic" href="#clientPhoto">View Image</a>
                                                    <div id="clientPhoto" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                        <section class="card">
                                                            <div class="card-body">
                                                                <div class="modal-wrapper">
                                                                    <div class="modal-text">
                                                                        <img src="<?=public_path('uploads/client/'.$row['client_photo']);?>" alt="" class="img-thumbnail">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <footer class="card-footer">
                                                                <div class="row">
                                                                    <div class="col-md-12 text-end">
                                                                        <button class="btn btn-primary modal-dismiss">OK</button>
                                                                    </div>
                                                                </div>
                                                            </footer>
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="">ID Card Type <span class="required">*</span></label>
                                                    <select class="form-control mb-3" name="edit_client_id_card_Type" title="Please select type" required>
                                                        <option value=""></option>
                                                        <option value="International Passport" <?=($row['client_idcard_type']=='International Passport')?'selected':'';?>>International Passport</option>
                                                        <option value="Drivers License" <?=($row['client_idcard_type']=='Drivers License')?'selected':'';?>>Driver’s License</option>
                                                        <option value="Voters Card" <?=($row['client_idcard_type']=='Voters Card')?'selected':'';?>>Voter’s Card</option>
                                                        <option value="National ID Card" <?=($row['client_idcard_type']=='National ID Card')?'selected':'';?>>National ID Card</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row pb-3">
                                            <div class="col-sm-6">
                                                <label class="control-label pt-1" for="w1-client-ID-card-front">ID Card Front <span class="required">*</span></label>
                                                <input type="file" class="form-control" name="edit_client_id_card_front" id="w1-client-ID-card-front">
                                                <input type="hidden" name="client_idcard_front" value="<?=$row['client_idcard_front'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#clientIDFront">View Image</a>
                                                <div id="clientIDFront" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/client/'.$row['client_idcard_front']);?>" alt="" class="img-thumbnail">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <footer class="card-footer">
                                                            <div class="row">
                                                                <div class="col-md-12 text-end">
                                                                    <button class="btn btn-primary modal-dismiss">OK</button>
                                                                </div>
                                                            </div>
                                                        </footer>
                                                    </section>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="control-label pt-1" for="w1-client-Id-card-back">ID Card Back <span class="required">*</span></label>
                                                <input type="file" class="form-control" name="edit_client_id_card_back" id="w1-client-Id-card-back">
                                                <input type="hidden" name="client_idcard_back" value="<?=$row['client_idcard_back'];?>" />
                                                <a class="mb-1 mt-1 me-1 modal-basic" href="#clientIDBack">View Image</a>
                                                <div id="clientIDBack" class="modal-block modal-header-color modal-block-primary mfp-hide">
                                                    <section class="card">
                                                        <div class="card-body">
                                                            <div class="modal-wrapper">
                                                                <div class="modal-text">
                                                                    <img src="<?=public_path('uploads/client/'.$row['client_idcard_back']);?>" alt="" class="img-thumbnail">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <footer class="card-footer">
                                                            <div class="row">
                                                                <div class="col-md-12 text-end">
                                                                    <button class="btn btn-primary modal-dismiss">OK</button>
                                                                </div>
                                                            </div>
                                                        </footer>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <footer class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <input class="btn btn-primary px-5" type="submit" value="Update Profile" />
                                            </div>
                                        </div>
                                    </footer>
                                </form>
                            </div>
                            <!-- Client beat-->
                            <div id="clientBeats" class="tab-pane">
                                <table class="table table-bordered table-striped mb-0" id="datatable-company">
                                    <thead>
                                    <tr>
                                        <th>s/n</th>
                                        <th>Beat Name</th>
                                        <th>No of Guards</th>
                                        <th>Status</th>
                                        <th>Log</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $res = $beat->get_all_beats($c['company_id'],$client_id);
                                    if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                            $client_info = $beat->get_client_info($row['client_id']);
                                            $client = $client_info->fetch_assoc();
                                            
                                            $act_guard = $beat->get_active_beat_with_guard($c['company_id'], $row['beat_id']);
                                            $act_super = $beat->get_active_beat_with_super($c['company_id'], $row['beat_id']);
                                            ?>
                                            <tr>
                                                <td><?=++$n;?></td>
                                                <td><?= $row['beat_name'];?></td>
                                                <td><?= ($act_guard+$act_super);?></td>
                                                <td>
                                                    <?=($row['beat_status'] =='Active')?
                                                        '<span class="badge badge-success">Active</span>':
                                                        '<span class="badge badge-danger">In-active</span>';?>
                                                </td>
                                                <td>
                                                    <a href="<?= url_path('/company/beat-activity-log/'.$row['beat_id'],true,true);?>"
                                                       style="font-size: 11px" class="btn btn-xm btn-default px-2 py-1"> <i class="bx bx-book-alt">&nbsp;</i>view log
                                                    </a>
                                                </td>
                                                <td class="actions">
                                                    <a href="<?= url_path('/company/edit-beat/'.$row['beat_id'],true,true);?>" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)" data-beat_sno="<?= $row['beat_sno'];?>" data-beat_id="<?= $row['beat_id'];?>" class="on-default remove-row" id="beatDeleteBtn">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                    <?php if ($row['beat_status'] =='Active'){ ?>
                                                        <a style="font-size: 11px" data-beat_id="<?= $row['beat_id'];?>" title="Deactivate beat"
                                                           data-active="Deactivate" class="btn btn-xm btn-danger text-white modal-with-move-anim ws-normal px-1 py-0" id="beatStatusBtn" href="#changeBeatStatus">
                                                            Disable
                                                        </a>
                                                    <?php } else { ?>
                                                        <a style="font-size: 11px" data-beat_id = "<?= $row['beat_id'];?>" title="Activate beat"
                                                           data-active="Active" class="btn btn-xm btn-success text-white modal-with-move-anim ws-normal px-1 py-0" id="beatStatusBtn" href="#changeBeatStatus">
                                                            Activate
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Beat found</td></tr>";} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Change Status Animation -->
            <div id="changeBeatStatus" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                <form name="changeBeatStat" id="changeBeatStat" class="card">
                    <header class="card-header">
                        <h2 class="card-title">Change Status <small>(This will also disable/enable all guards attached to this beat)</small> </h2>
                    </header>
                    <div class="card-body">
                        <div class="modal-wrapper py-0">
                            <div class="form-group mb-3">
                                <label for="bt_st_status">Status</label>
                                <select class="form-control" name="bt_st_status" id="bt_st_status">
                                    <option value=""></option>
                                    <option value="Deactivate">Deactivate</option>
                                    <option value="Active">Re-activate</option>
                                </select>
                                <input type="hidden" name="bt_st_beat_id" id="bt_st_beat_id" />
                                <input type="hidden" name="bt_st_comp_id" id="bt_st_comp_id" value="<?=$c['company_id'];?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="bt_st_date">Date</label>
                                <input type="date" name="bt_st_date" id="bt_st_date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="bt_st_remark">Remark</label>
                                <textarea name="bt_st_remark" rows="3" id="bt_st_remark" class="form-control" placeholder="Remark" required></textarea>
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <input type="submit" class="btn btn-primary" value="Update">
                                <button class="btn btn-default modal-dismiss">Cancel</button>
                            </div>
                        </div>
                    </footer>
                </form>
            </div>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>
<script src="<?= public_path("js/examples/examples.modals.js"); ?>"></script>

<script>
    (function($) {
        'use strict';
        $('.invCreditModal').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#name',
            modal: true,
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in',
            callbacks: {
                beforeOpen: function() {
                    if($(window).width() < 700) {this.st.focus = false;}
                    else {this.st.focus = '#name';}
                }
            }
        });
    }).apply(this, [jQuery]);
</script>

<script>
    $('#propicxUpload').click(function(){ $('#client_profile_picx_update').trigger('click'); });
</script>

<script>
    $(function($) {
        'use strict';
        $(".Cate").html("Credit");
        $('.row_chr_days').show();
        $('.row_chr_amt').hide();

        $('.row_pay_met').hide();
        $('.row_pay_met_name').hide();
        $('input[name="dc_category"]').change(function(){
            if( $(this).is(":checked") ){
                if ($(this).val() === "Credit"){
                    $(".Cate").html("Credit");
                    $('.row_chr_amt').hide();
                    $('.row_chr_days').show();
                    $('#cred_amt').val('0');
                } else {
                    $(".Cate").html("Debit");
                    $('.row_chr_amt').show();
                    $('.row_chr_days').hide();
                    $('#deb_amt').val('0');
                }
            }
        });

        $('select[name=""]').change(function(){
            if( $(this).is(":checked") ){
                alert($(this).val());
                if ($(this).val() === "Cheque"){
                    $('.row_pay_met').show();
                } else {
                    $('.row_pay_met').hide();
                }
            }
        });
        $('.con_client_pay_method').change(function(){
            if($(this).val() === 'Cheque') {
                $('.row_pay_met').show();
                $('.row_pay_met_name').hide();
            }  else if($(this).val() === 'Cash') {
                $('.row_pay_met').hide();
                $('.row_pay_met_name').show();
            }  else {
                $('.row_pay_met').hide();
                $('.row_pay_met_name').hide();
            }
        });
    });
</script>