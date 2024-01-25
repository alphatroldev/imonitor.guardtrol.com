<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Generate Invoice</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Generate Invoice</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <h2 class="card-title">Generate Invoice</h2>
                </header>
                <div class="card-body">
                    <form name="generate_beat_invoice" id="generate_beat_invoice" class="row">
                        <div class="col-sm-7">
                            <div class="form-group row pb-4">
                                <div class="col-sm-12 form-group">
                                    <label class="control-label pt-1" for="w4-client-id">Select Client <span class="required">*</span></label>
                                    <select data-plugin-selectTwo class="form-control populate" name="client_id" id="w4-client-id" required>
                                        <option value=""></option>
                                        <?php
                                        $res = $beat->get_all_company_clients($c['company_id']);
                                        while ($row = $res->fetch_assoc()) {
                                            ?>
                                            <option value="<?= $row['client_id'];?>"><?= $row['client_fullname'];?></option>
                                        <?php }  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 form-group">
                                    <table class="table table-bordered table-hover mb-0" id="datatable-company">
                                        <thead class="bg-de">
                                        <tr>
                                            <th>Select Beat</th>
                                            <th>Client</th>
                                            <th>
                                                <div class="checkbox-custom checkbox-default pull-right text-primary">
                                                    <input type="checkbox" id="selAllCheck" onClick="check_uncheck_stf(this.checked);">
                                                    <label for="selAllCheck">Select All</label>
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="show_beat_table">
                                        <tr><td colspan='12' class='text-center'>Select a client to view active beat</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12">
                                    <p class="ps-md-5">
                                        <span class="" style="color:#000000;font-weight:bold;font-size: 17px;">Wallet Balance: </span>
                                        <span style="color:#000000;font-weight:bold;font-size: 17px;" id="clientWalletBal"></span>
                                    </p>
                                    <div class="ps-md-5" style="display: flex">
                                        <div class="" style="color:#000000;font-weight:bold;font-size: 15px;">
                                            Wallet Balance <br />to add to invoice
                                        </div>
                                        <div style="align-content:baseline">
                                            <input type="number" name="add_to_inv" style="border-color: black;height: 35px;margin-left: 15px;width: 200px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group row pb-4">
                                <div class="col-sm-12 form-group">
                                    <label class="control-label pt-1">Select Month <span class="required">*</span></label>
                                    <select class="form-control" id="sel_month" name="sel_month" aria-label="">
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
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-12 form-group">
                                    <label class="control-label pt-1">Select Year <span class="required">*</span></label>
                                    <select class="form-control" id="sel_year" name="sel_year" aria-label="">
                                        <option value=""></option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-12 form-group">
                                    <label class="control-label pt-1">Select Account <span class="required">*</span></label>
                                    <select class="form-control" id="sel_acct" name="sel_acct" aria-label="">
                                        <?php
                                        $res = $company->get_all_company_invoice_account($c['company_id']);
                                        if ($res->num_rows > 0) {$n=0;
                                        while ($row = $res->fetch_assoc()) {
                                        ?>
                                        <option value="<?=$row['inv_acc_sno'];?>"><?=$row['inv_account_name'];?> (<?=$row['inv_bank_name'];?>)</option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-primary col-12" value="Proceed">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.com.php"); ?>
<script>
    function check_uncheck_stf(isChecked) {
        if (isChecked){
            $('input[name="beat_check[]"]').each(function(){
                this.checked = true;
                $("label[for='selAllCheck']").html("Unselect All")
            });
        } else {
            $('input[name="beat_check[]"]').each(function(){
                this.checked = false;
                $("label[for='selAllCheck']").html("Select All");
            });
        }
    }

    $('select[name="client_id"]').change(function(){
        var selected = $(this).val();
        // load("beat-info/"+selected);
        $.ajax({
            url: "beat-info", type: "POST", data: {client_id:selected},
            success: function (data) {
                $("#show_beat_table").html(data);
            }
        });
        
        $.ajax({
            url: "client-wallet-info", type: "POST", data: {client_id:selected},
            success: function (data) {
                $("#clientWalletBal").html(data);
            }
        });
    });
</script>
