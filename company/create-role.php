<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Create Role</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Add Role</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                    <h2 class="card-title">
                        <a href="<?= url_path('/company/roles',true,true)?>">
                            <i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Add new role
                    </h2>
                </header>
                <form name="create_role" id="create_role">
                    <div class="card-body">
                        <div id="response-alert"></div>
                        <div class="form-group row pb-2">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Role Name <span class="required">*</span></label>
                                    <input type="text" name="role_name" class="form-control" title="Please enter role_name" required />
                                    <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pb-2">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Role Level/Alias <span class="required">*</span></label>
                                    <select class="form-control" name="role_sno" title="Please select type" required>
                                        <option value=""></option>
                                        <?php
                                        $res = $company->get_all_roles();
                                        if ($res->num_rows > 0) {
                                        while ($row = $res->fetch_assoc()) {
                                        ?>
                                        <option value="<?=$row['role_sno'];?>"><?=$row['role_level'];?> (<?=$row['role_alias'];?>)</option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer py-3">
                        <div class="row">
                            <div class="col-sm-9">
                                <input class="btn btn-primary px-5" type="submit" value="Create Role" />
                            </div>
                        </div>
                    </footer>
                </form>
            </section>
        </div>
    </div>
</section>
<?php include_once("inc/footer.com.php"); ?>