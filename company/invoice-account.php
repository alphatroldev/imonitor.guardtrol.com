<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<?php
$res = $company->get_company_config_by_c_id($c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <section role="main" class="content-body">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="mb-3">
                        <a href="#modalInvoiceAccount" class="btn btn-primary add-invAcct-modal">Add Account</a>
                        <div id="modalInvoiceAccount" class="modal-block modal-block-primary mfp-hide">
                            <form name="create_inv_new_account" id="create_inv_new_account" class="card">
                                <header class="card-header">
                                    <h2 class="card-title">Add New Account</h2>
                                </header>
                                <div class="card-body">
                                    <div id="response-alert"></div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12 mb-4">
                                            <label for="inv_acc_name" class="mb-2 font-weight-bold">Account Name</label>
                                            <input type="text" class="form-control shadow-none" id="inv_acc_name" name="inv_acc_name">
                                            <input type="hidden" name="comp_id" id="comp_id" value="<?=$c['company_id'];?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12 mb-4">
                                            <label for="inv_acc_no" class="mb-2 font-weight-bold">Account No</label>
                                            <input type="text" class="form-control shadow-none" id="inv_acc_no" name="inv_acc_no" maxlength="12">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12 mb-4">
                                            <label for="inv_bank_name" class="mb-2 font-weight-bold">Bank Name</label>
                                            <input type="text" class="form-control shadow-none" id="inv_bank_name" name="inv_bank_name">
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
                    </div>
                </div>
            </div>
            <header class="page-header">
                <h2>Invoice Accounts List</h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                        <li><span>List Accounts</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <section class="card">
                        <header class="card-header">
                            <h2 class="card-title">Invoice Account List</h2>
                        </header>
                        <div class="card-body">
                            <table class="table table-bordered table-no-more mb-0" id=>
                                <thead>
                                <tr>
                                    <th width="10"></th>
                                    <th>Account Name</th>
                                    <th>Account No</th>
                                    <th>Bank Name</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $res = $company->get_all_company_invoice_account($c['company_id']);
                                if ($res->num_rows > 0) {$n=0;
                                    while ($row = $res->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="radio-custom radio-success">
                                                    <input id="inv_active_<?=$row['inv_acc_sno'];?>" name="inv_active" type="radio" class="inv_account_active"
                                                           value="<?=$row['inv_acc_sno'];?>" <?=($row['inv_account_active']=='Yes')?'checked':'';?>>
                                                    <label for="inv_active_<?=$row['inv_acc_sno'];?>"></label>
                                                </div>
                                            </td>
                                            <td data-title="Acct name"><?= $row['inv_account_name'];?></td>
                                            <td data-title="Acct no"><?= $row['inv_account_no'];?></td>
                                            <td data-title="Bank name"><?= $row['inv_bank_name'];?></td>
                                            <td data-title="Bank Status"><?= ($row['inv_account_active']=='Yes')
                                                    ?'<span class="badge badge-success px-2">Active</span>':'<span class="badge badge-dark px-2">Inactive</span>';?></td>
                                            <td data-title="Actions" class="actions">
                                                <a href="javascript:void(0)" data-inv_acc_sno="<?= $row['inv_acc_sno'];?>" data-comp_id="<?=$c['company_id'];?>" class="on-default text-danger" id="InvAcctDeleteBtn">
                                                    <i class="far fa-trash-alt"></i> delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Invoice account found</td></tr>";} ?>
                                </tbody>
                            </table>
                        </div>
                        <footer class="card-footer py-3">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input class="btn btn-info px-3" type="submit" value="Save" id="updateActiveInvAcct"/>
                                </div>
                            </div>
                        </footer>
                    </section>
                </div>
            </div>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>
<script>
    (function($) {
        'use strict';
        $('.add-invAcct-modal').magnificPopup({
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
            callbacks: {
                beforeOpen: function() {
                    if($(window).width() < 700) {this.st.focus = false;}
                    else {this.st.focus = '#inv_acc_name';}
                }
            }
        });
    }).apply(this, [jQuery]);
</script>
