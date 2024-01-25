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
                <a href="<?= url_path('/company/configuration',true,true)?>" class="btn btn-success">General Settings</a>
                <a href="<?= url_path('/company/shifts',true,true)?>" class="btn btn-primary">Manage Shift</a>
                <a href="<?= url_path('/company/penalties',true,true)?>" class="btn btn-primary">Penalties & Charges</a>
                <a href="<?= url_path('/company/guard-positions',true,true)?>" class="btn btn-primary">Guard Positions</a>
                <a href="<?= url_path('/company/payroll-settings',true,true)?>" class="btn btn-primary">Payroll Config</a>
                <a href="<?= url_path('/company/roles',true,true)?>" class="btn btn-primary">Roles</a>
            </div>
        </div>
    </div>
    <header class="page-header">
        <h2>Configuration Settings</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Configuration</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12 mx-auto">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">Configuration Settings</h2>
                </header>
                <form name="update_configuration" id="update_configuration">
                    <div class="card-body">
                        <div id="response-alert"></div>
                        <div class="form-group row pb-2">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="uniform_charge">Kit</label>
                                    <small class="text-info"> (Do you charge for kit?)</small>
                                    <select class="form-control mb-3" name="uniform_charge" id="uniform_charge">
                                        <option value="Yes" <?=($row['uniform_charge']=="Yes")?'selected':'';?>>Yes</option>
                                        <option value="No" <?=($row['uniform_charge']=="No")?'selected':'';?>>No</option>
                                    </select>
                                    <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="uniform_charge_amt">Kit Charge Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₦</span>
                                        <input name="uniform_charge_amt" type="number" class="form-control" id="uniform_charge_amt" value="<?=$row['uniform_fee'];?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label for="uni_mode">Mode of deduction</label>
                                    <select class="form-control mb-3" name="uni_mode" id="uni_mode">
                                        <option value=""></option>
                                        <option value="1 month pay off" <?=($row['uniform_mode']=="1 month pay off")?'selected':'';?>>1 month pay off</option>
                                        <option value="2 months pay off" <?=($row['uniform_mode']=="2 months pay off")?'selected':'';?>>2 months pay off</option>
                                        <option value="3 months pay off" <?=($row['uniform_mode']=="3 months pay off")?'selected':'';?>>3 months pay off</option>
                                        <option value="fixed amount monthly" <?=($row['uniform_mode']=="fixed amount monthly")?'selected':'';?>>fixed amount monthly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="agent">Agents</label>
                                    <small class="text-info">Do you accept agents?</small>
                                    <select class="form-control mb-3" name="agent"  id="agent" >
                                        <option value="Yes" <?=($row['agent']=="Yes")?'selected':'';?>>Yes</option>
                                        <option value="No" <?=($row['agent']=="No")?'selected':'';?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="agent_fee">Agent Fee</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₦</span>
                                        <input name="agent_fee" type="number" class="form-control" id="agent_fee" value="<?=$row['agent_fee'];?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="agent_mode">Mode of deduction</label>
                                    <select class="form-control mb-3" name="agent_mode" id="agent_mode">
                                        <option value=""></option>
                                        <option value="1 month pay off" <?=($row['agent_mode']=="1 month pay off")?'selected':'';?>>1 month pay off</option>
                                        <option value="2 months pay off" <?=($row['agent_mode']=="2 months pay off")?'selected':'';?>>2 months pay off</option>
                                        <option value="3 months pay off" <?=($row['agent_mode']=="3 months pay off")?'selected':'';?>>3 months pay off</option>
                                        <option value="fixed amount monthly" <?=($row['agent_mode']=="fixed amount monthly")?'selected':'';?>>fixed amount monthly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group pb-2">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="act_date">Activation Date</label>
                                    <small class="text-info">When will your guard start earning?</small>
                                    <select class="form-control mb-3" name="act_date" id="act_date">
                                        <option value=""></option>
                                        <option value="immediately" <?=($row['activation_date']=="immediately")?'selected':'';?>>Immediately</option>
                                        <option value="2 days" <?=($row['activation_date']=="2 days")?'selected':'';?>>2 Days</option>
                                        <option value="1 week" <?=($row['activation_date']=="1 week")?'selected':'';?>>1 Week</option>
                                        <option value="2 weeks" <?=($row['activation_date']=="2 weeks")?'selected':'';?>>2 Weeks</option>
                                        <option value="1 month" <?=($row['activation_date']=="1 month")?'selected':'';?>>1 Month</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="loan_type">Loan Config Type</label>
                                    <small class="text-info">do your loan payment roll over to next year?</small>
                                    <select class="form-control mb-3" name="loan_type" id="loan_type">
                                        <option value=""></option>
                                        <option value="yearly loan repayment type" <?=($row['loan_config_type']=="yearly loan repayment type")?'selected':'';?>>Yearly bound loan repayment type</option>
                                        <option value="indefinite loan repayment type" <?=($row['loan_config_type']=="indefinite loan repayment type")?'selected':'';?>>indefinite loan repayment type</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer py-3">
                        <div class="row">
                            <div class="col-sm-9">
                                <input class="btn btn-primary px-5" type="submit" value="Save Configuration" />
                            </div>
                        </div>
                    </footer>
                </form>
            </section>
        </div>
    </div>
</section>
<?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>