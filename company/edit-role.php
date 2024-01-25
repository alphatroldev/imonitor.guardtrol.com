<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>

<?php
if (!isset($role_sno) || $role_sno == NULL ) {echo "<script>window.location = '".url_path('/company/roles',true,true)."'; </script>";}
?>
<?php
$res = $company->get_company_role_by_id($role_sno,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Edit Role</h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                        <li><span>Edit Role</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <section class="card">
                        <header class="card-header">
                            <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                            <h2 class="card-title"><a href="<?= url_path('/company/roles',true,true)?>"><i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a> Edit Role</h2>
                        </header>
                        <form name="update_company_role" id="update_company_role">
                            <div class="card-body">
                                <div id="response-alert"></div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Role Name <span class="required">*</span></label>
                                            <input type="text" name="role_name" class="form-control" title="Please enter role_name" value="<?=$row['company_role_name'] ;?>" />
                                            <input type="hidden" name="comp_role_sno" value="<?=$row['comp_role_sno'];?>" />
                                            <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row pb-3">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">Role Level/Alias <span class="required">*</span></label>
                                            <select class="form-control mb-3" name="role_sno" title="Please select role level/alias">
                                                <option value=""></option>
                                                <?php
                                                $res2 = $company->get_all_roles();
                                                if ($res2->num_rows > 0) {
                                                while ($row2 = $res2->fetch_assoc()) {
                                                ?>
                                                <option value="<?=$row2['role_sno'];?>" <?=($row2['role_sno']==$row['role_sno'])?'selected':'';?>>
                                                    <?=$row2['role_level'];?> (<?=$row2['role_alias'];?>)
                                                </option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <footer class="card-footer">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <input class="btn btn-primary px-5" type="submit" value="Update Role" />
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