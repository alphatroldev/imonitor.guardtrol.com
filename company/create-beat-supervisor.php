<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Create Beat Supervisor</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Create Beat</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <form class="form-horizontal" name="create_beat_supervisor" id="create_beat_supervisor">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <section class="card">
                    <header class="card-header">
                        <h2 class="card-title">Add New Beat Supervisor</h2>
                    </header>
                    <div class="card-body">
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="bs_firstname">Beat Supervisor Firstname<span class="required">*</span></label>
                                <input type="text" class="form-control shadow-none" name="bs_firstname" id="bs_firstname">
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="bs_lastname">Beat Supervisor Lastname<span class="required">*</span></label>
                                <input type="text" class="form-control shadow-none" name="bs_lastname" id="bs_lastname">
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-12">
                                <label class="control-label pt-1" for="">Beats <span class="required">*</span></label>
                                <select multiple data-plugin-selectTwo class="form-control shadow-none populate" name="bs_beats[]" id="">
                                    <optgroup label="All Beats">
                                        <?php
                                        $res = $beat->get_active_beats($c['company_id']);
                                        if ($res->num_rows > 0) {
                                        while ($row = $res->fetch_assoc()) {
                                        ?>
                                        <option value="<?=$row['beat_id'];?>"><?=$row['beat_name'];?></option>
                                        <?php } } ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="bs_pwd">B.S Password<span class="required">*</span></label>
                                <input type="password" class="form-control shadow-none" name="bs_pwd" id="bs_pwd">
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="bs_con_pwd">B.S Confirm Password<span class="required">*</span></label>
                                <input type="password" class="form-control shadow-none" name="bs_con_pwd" id="bs_con_pwd">
                            </div>
                        </div>
                        <div class="form-group row pb-3">
                            <div class="col-sm-6">
                                <label class="control-label pt-1" for="bs_email">B.S Email Address<span class="required">*</span></label>
                                <input type="email" class="form-control shadow-none" name="bs_email" id="bs_email">
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <div class="row">
                            <div class="col-sm-10 py-3">
                                <input type="submit" value="Create Beat Supervisor" class="btn btn-primary">
                            </div>
                        </div>
                    </footer>
                </section>
            </div>
        </div>
    </form>
</section>
<?php include_once("inc/footer.com.php"); ?>