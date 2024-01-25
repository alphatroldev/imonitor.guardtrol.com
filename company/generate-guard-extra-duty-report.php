<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Generate Guard Extra Duty Report</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Generate Guard Extra Duty Report</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <h2 class="card-title">Generate Guard Extra Duty Report</h2>
                </header>
                <div class="card-body">
                    <form action="Z2VuZXJhdGUtZ3VhcmQtZXh0cmEtZHV0eS1yZXBvcnQ=" method="post">
                        <div class="col-sm-7">
                            <div class="form-group row pb-4">
                                <div class="col-sm-7">
                                    <label class="control-label pt-1">Select Month (From)<span class="required">*</span></label>
                                    <select class="form-control" id="from_sel_month" name="from_sel_month" aria-label="" required>
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
                                <div class="col-sm-5 ">
                                    <label class="control-label pt-1">Select Year (From)<span class="required">*</span></label>
                                    <select class="form-control" id="from_sel_year" name="from_sel_year" aria-label="" required>
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
                            <div class="form-group row mb-3">
                                <div class="col-sm-7">
                                    <label class="control-label pt-1">Select Month (To)<span class="required">*</span></label>
                                    <select class="form-control" id="to_sel_month" name="to_sel_month" aria-label="" required>
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
                                <div class="col-sm-5">
                                    <label class="control-label pt-1">Select Year (To)<span class="required">*</span></label>
                                    <select class="form-control" id="to_sel_year" name="to_sel_year" aria-label="" required>
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
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-primary px-4" value="Proceed">
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
