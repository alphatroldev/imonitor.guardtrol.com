<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Create Staff Payroll</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Create Staff Payroll</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12">
            <section class="card card-featured card-featured-primary mb-4">
                <header class="card-header">
                    <h2 class="card-title">Generate Staff Payroll</h2>
                </header>
                <div class="card-body">
                    <form name="generate_staff_payroll" id="generate_staff_payroll" class="row">
                        <div class="col-sm-7">
                            <table class="table table-bordered table-hover mb-0" id="datatable-company">
                                <thead class="bg-de">
                                <tr>
                                    <th>Select Staffs</th>
                                    <th>
                                        <div class="checkbox-custom checkbox-default pull-right text-primary">
                                            <input type="checkbox" id="selAllCheck" onClick="check_uncheck_stf(this.checked);">
                                            <label for="selAllCheck">Select All</label>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $res = $company->get_all_company_staff_account($c['company_id']);
                                if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td class="text-primary">
                                            <i class="fas fa-user-check"></i>
                                            <?= $row['staff_firstname']." ".$row['staff_middlename']." ".$row['staff_lastname'];?>
                                        </td>
                                        <td>
                                            <div class="checkbox-custom checkbox-default pull-right">
                                                <input type="checkbox" class="staff_check" id="staff_check_<?= $row['staff_id']?>" name="staff_check[]" value="<?= $row['staff_id']?>">
                                                <label for="staff_check_<?= $row['staff_id']?>"></label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No staff found</td></tr>";} ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group row mb-3">
                                <div class="col-sm-12 form-group">
                                    <select class="form-control" id="sel_month" name="sel_month" aria-label="">
                                        <option value="">-- Select Month --</option>
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
                                    <select class="form-control" id="sel_year" name="sel_year" aria-label="">
                                        <option value="">-- Select Year --</option>
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
<?php include_once("inc/footer.staff.php"); ?>
<script>
    function check_uncheck_stf(isChecked) {
        if (isChecked){
            $('input[name="staff_check[]"]').each(function(){
               this.checked = true;
                $("label[for='selAllCheck']").html("Unselect All")
            });
        } else {
            $('input[name="staff_check[]"]').each(function(){
                this.checked = false;
                $("label[for='selAllCheck']").html("Select All");
            });
        }
    }
</script>
