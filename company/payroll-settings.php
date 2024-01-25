<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <div class="row">
            <div class="col-md-12 mx-auto mt-sm-2">
                <div class="mb-3 pt-3 pt-sm-0">
                    <a href="<?= url_path('/company/configuration',true,true)?>" class="btn btn-primary">General Settings</a>
                    <a href="<?= url_path('/company/shifts',true,true)?>" class="btn btn-primary">Manage Shift</a>
                    <a href="<?= url_path('/company/penalties',true,true)?>" class="btn btn-primary">Penalties & Charges</a>
                    <a href="<?= url_path('/company/guard-positions',true,true)?>" class="btn btn-primary">Guard Positions</a>
                    <a href="<?= url_path('/company/payroll-settings',true,true)?>" class="btn btn-success">Payroll Config</a>
                </div>
            </div>
        </div>
        <header class="page-header">
            <h2>Add Payroll Data</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Add Payroll Data</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">Add Payroll Data</h2>
                    </header>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <a href="#modalAddPayrollSettings" class="btn btn-primary add_payroll_settings pr-3"><i class="fas fa-plus">&nbsp;&nbsp;</i>Add Payroll Data</a>
                                    <div id="modalAddPayrollSettings" class="modal-block modal-block-primary mfp-hide">
                                        <form name="add_payroll_settings" id="add_payroll_settings" class="card">
                                            <header class="card-header">
                                                <h2 class="card-title">Add Payroll Data</h2>
                                            </header>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12 mb-4">
                                                        <label for="payroll_title">Payroll Data Title<span class="required">*</span></label>
                                                        <input type="text" class="form-control" id="payroll_title" name="payroll_title">
                                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12 mb-3 form-group border-0">
                                                        <label class="col-sm-3 control-label">Payroll Type <span class="required">*</span></label>
                                                        <div class="radio-custom radio-primary radio-inline px-4">
                                                            <input id="Credit" name="payroll_typ" type="radio" value="Credit" required />
                                                            <label for="Credit">Credit</label>
                                                        </div>
                                                        <div class="radio-custom radio-primary radio-inline">
                                                            <input id="Debit" name="payroll_typ" type="radio" value="Debit" />
                                                            <label for="Debit">Debit</label>
                                                        </div>
                                                        <label class="error pl-3" for="payroll_typ"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12 mb-3 form-group border-0">
                                                        <label class="col-sm-3 control-label">Access Type <span class="required">*</span></label>
                                                        <div class="radio-custom radio-primary radio-inline px-4">
                                                            <input id="Guard" name="access_typ" type="radio" value="Guard" required />
                                                            <label for="Guard">Guard</label>
                                                        </div>
                                                        <div class="radio-custom radio-primary radio-inline  px-4">
                                                            <input id="Staff" name="access_typ" type="radio" value="Staff" />
                                                            <label for="Staff">Staff</label>
                                                        </div>
                                                        <div class="radio-custom radio-primary radio-inline mt-0 px-4">
                                                            <input id="Both" name="access_typ" type="radio" value="Both" />
                                                            <label for="Both">Both</label>
                                                        </div>
                                                        <label class="error pl-3" for="access_typ"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <div class="col-sm-6 form-group border-0">
                                                        <label for="payment_mode">Select Payment Mode</label>
                                                        <select id="payment_mode"  name="payment_mode" class="form-control payment_mode">
                                                            <option value=""></option>
                                                            <option value="One Time">One-Time</option>
                                                            <option value="Monthly">Monthly</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 form-group border-0 pt-3 pt-sm-0">
                                                        <label for="fixed_amount">Is it a fixed amount? <span class="required">*</span></label>
                                                        <select id="fixed_amount"  name="fixed_amount" class="form-control fixed_amount">
                                                            <option value=""></option>
                                                            <option value="Yes">Yes</option>
<!--                                                            <option value="No">No</option>-->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row row_mon_year mb-4">
                                                    <div class="col-sm-8 form-group border-0">
                                                        <label for="mon_month">Select month <span class="required">*</span></label>
                                                        <select id="mon_month"  name="mon_month" class="form-control">
                                                            <option value=""></option>
                                                            <option value="January">January</option>
                                                            <option value="February">February</option>
                                                            <option value="March">March</option>
                                                            <option value="April">April</option>
                                                            <option value="May">May</option>
                                                            <option value="June">June</option>
                                                            <option value="July">July</option>
                                                            <option value="August">August</option>
                                                            <option value="September">September</option>
                                                            <option value="October">October</option>
                                                            <option value="November">November</option>
                                                            <option value="December">December</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4 form-group border-0 pt-3 pt-sm-0">
                                                        <label for="mon_year">Select year <span class="required">*</span></label>
                                                        <select id="mon_year"  name="mon_year" class="form-control">
                                                            <option value=""></option>
                                                            <option value="2021">2021</option>
                                                            <option value="2022">2022</option>
                                                            <option value="2023">2023</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                            <option value="2026">2026</option>
                                                            <option value="2027">2027</option>
                                                            <option value="2028">2028</option>
                                                            <option value="2029">2029</option>
                                                            <option value="2030">2030</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row_pr_amt row mb-4">
                                                    <div class="col-sm-8 col-12 form-group">
                                                        <label for="payroll_amount">Enter Amount <span class="required">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">₦</span>
                                                            <input type="text" class="form-control" id="payroll_amount" name="payroll_amount"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <footer class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-12 text-end">
                                                        <input type="submit" class="btn btn-primary modal-confirm" value="Save" />
                                                        <button class="btn btn-default modal-dismiss">Close</button>
                                                    </div>
                                                </div>
                                            </footer>
                                        </form>
                                    </div>
                                    
                                    <div id="editPayrollSettings" class="modal-block modal-block-primary mfp-hide">
                                        <form name="update_payroll_settings" id="update_payroll_settings" class="card">
                                            <header class="card-header">
                                                <h2 class="card-title">Edit Payroll Settings</h2>
                                            </header>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12 mb-4">
                                                        <label for="payroll_title">Payroll Title<span class="required">*</span></label>
                                                        <input type="text" class="form-control" id="payroll_title" name="payroll_title">
                                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                                        <input type="hidden" name="edit_payroll_settings_sno" id="payroll_settings_sno" >
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12 mb-3 form-group border-0">
                                                        <label class="col-sm-3 control-label">Payroll Type <span class="required">*</span></label>
                                                        <div class="radio-custom radio-primary radio-inline px-4">
                                                            <input id="Credit" name="payroll_typ" type="radio" value="Credit" required />
                                                            <label for="Credit">Credit</label>
                                                        </div>
                                                        <div class="radio-custom radio-primary radio-inline">
                                                            <input id="Debit" name="payroll_typ" type="radio" value="Debit" />
                                                            <label for="Debit">Debit</label>
                                                        </div>
                                                        <label class="error pl-3" for="payroll_typ"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12 mb-3 form-group border-0">
                                                        <label class="col-sm-3 control-label">Access Type <span class="required">*</span></label>
                                                        <div class="radio-custom radio-primary radio-inline px-4">
                                                            <input id="Guard" name="access_typ" type="radio" value="Guard" required />
                                                            <label for="Guard">Guard</label>
                                                        </div>
                                                        <div class="radio-custom radio-primary radio-inline px-4">
                                                            <input id="Staff" name="access_typ" type="radio" value="Staff" />
                                                            <label for="Staff">Staff</label>
                                                        </div>
                                                        <div class="radio-custom radio-primary radio-inline mt-0 px-4">
                                                            <input id="Both" name="access_typ" type="radio" value="Both" />
                                                            <label for="Both">Both</label>
                                                        </div>
                                                        <label class="error pl-3" for="payroll_typ"></label>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-4">
                                                    <div class="col-sm-6 form-group border-0">
                                                        <label for="payment_mode">Select Payment Mode</label>
                                                        <select id="payment_mode"  name="payment_mode" class="form-control payment_mode">
                                                            <option value=""></option>
                                                            <option value="One Time">One-Time</option>
                                                            <option value="Monthly">Monthly</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 form-group border-0 pt-3 pt-sm-0">
                                                        <label for="fixed_amount">Is it a fixed amount? <span class="required">*</span></label>
                                                        <select id="fixed_amount"  name="fixed_amount" class="form-control fixed_amount">
                                                            <option value=""></option>
                                                            <option value="Yes">Yes</option>
<!--                                                            <option value="No">No</option>-->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row_mon_year_2 row mb-4">
                                                    <div class="col-sm-8 form-group border-0">
                                                        <label for="mon_month">Select month <span class="required">*</span></label>
                                                        <select id="mon_month"  name="mon_month" class="form-control">
                                                            <option value=""></option>
                                                            <option value="January">January</option>
                                                            <option value="February">February</option>
                                                            <option value="March">March</option>
                                                            <option value="April">April</option>
                                                            <option value="May">May</option>
                                                            <option value="June">June</option>
                                                            <option value="July">July</option>
                                                            <option value="August">August</option>
                                                            <option value="September">September</option>
                                                            <option value="October">October</option>
                                                            <option value="November">November</option>
                                                            <option value="December">December</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4 form-group border-0 pt-3 pt-sm-0">
                                                        <label for="mon_year">Select year <span class="required">*</span></label>
                                                        <select id="mon_year"  name="mon_year" class="form-control">
                                                            <option value=""></option>
                                                            <option value="2021">2021</option>
                                                            <option value="2022">2022</option>
                                                            <option value="2023">2023</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                            <option value="2026">2026</option>
                                                            <option value="2027">2027</option>
                                                            <option value="2028">2028</option>
                                                            <option value="2029">2029</option>
                                                            <option value="2030">2030</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row_pr_amt_2 row mb-4">
                                                    <div class="col-sm-8 col-12 form-group">
                                                        <label for="payroll_amount">Enter Amount <span class="required">*</span></label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">₦</span>
                                                            <input type="text" class="form-control" id="payroll_amount" name="payroll_amount"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <footer class="card-footer">
                                                <div class="row">
                                                    <div class="col-md-12 text-end">
                                                        <input type="submit" class="btn btn-primary modal-confirm" value="Update" />
                                                        <button class="btn btn-default modal-dismiss">Close</button>
                                                    </div>
                                                </div>
                                            </footer>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-no-more mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Payroll Title</th>
                                <th>Type</th>
                                <th>AccessBy</th>
                                <th>Mode</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>isFixedAmt</th>
                                <th>Amount</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_payroll_settings($c['company_id']);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Payroll Title"><?= $row['payroll_title'];?></td>
                                        <td data-title="Type"><?= $row['payroll_type'];?></td>
                                        <td data-title="Access By"><?= $row['access_type'];?></td>
                                        <td data-title="Mode"><?= $row['payment_mode'];?></td>
                                        <td data-title="Mode"><?= $row['mon_month'];?></td>
                                        <td data-title="Mode"><?= $row['mon_year'];?></td>
                                        <td data-title="isFixedAmt"><?= $row['fixed_amount'];?></td>
                                        <td data-title="Amount">
                                            <?= ($row['payroll_amount']!=''?'₦'.number_format($row['payroll_amount'],0):'N/A');?>
                                        </td>
                                        <td data-title="Last Updated"><?= date("d/m/Y H:i", strtotime($row['payroll_updated_date']));?></td>
                                        <td data-title="Actions" class="actions">
                                            <a href="#editPayrollSettings" class="on-default edit-row edit-payroll-settings text-success mr-3" id="edit_payroll-settings"
                                               data-payroll_settings_sno="<?= $row['payroll_settings_sno'];?>" data-payroll_title="<?= $row['payroll_title'];?>" 
                                               data-payroll_type="<?= $row['payroll_type'];?>" data-payment_mode="<?= $row['payment_mode'];?>"
                                               data-fixed_amount="<?= $row['fixed_amount'];?>" data-payroll_amount="<?= $row['payroll_amount'];?>"
                                               data-mon_month="<?= $row['mon_month'];?>" data-mon_year="<?= $row['mon_year'];?>"
                                               data-access_type="<?= $row['access_type'];?>">
                                                <i class="fas fa-pencil-alt"></i> edit
                                            </a>
                                            <a href="javascript:void" class="text-danger" id="payrollDataDeleteBtn"
                                               data-payroll_sno="<?= $row['payroll_settings_sno'];?>" data-comp_id="<?= $c['company_id'];?>">
                                                <i class="fas fa-trash-alt"></i> delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Payroll Settings</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
            
        </div>
    </section>
<?php include_once("inc/footer.com.php");?>
<script>
    (function($) {

        $('.add_payroll_settings').magnificPopup({
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
    (function($) {
        'use strict';
        $('.edit-payroll-settings').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#edit_kit_type',
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
                    else {this.st.focus = '#edit_kit_type';}
                }
            }
        });
    }).apply(this, [jQuery]);
</script>
<script>
    $(function($) {
        'use strict';
        $('.row_mon_year').hide();
        $('.row_pr_amt').hide();
        $('.row_mon_year_2').hide();
        $('.row_pr_amt_2').hide();
        $('.payment_mode').change(function(){
            if($(this).val() === 'One Time') {
                $('.row_mon_year').show();
                $('.row_mon_year_2').show();
            }  else {
                $('.row_mon_year').hide();
                $('.row_mon_year_2').hide();
            }
        });
        $('.fixed_amount').change(function(){
            if($(this).val() === 'Yes') {
                $('.row_pr_amt').show();
                $('.row_pr_amt_2').show();
            }  else {
                $('.row_pr_amt').hide();
                $('.row_pr_amt_2').hide();
            }
        });
    });
</script>
