<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Create Client Login</h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><a href="<?= url_path('/company/list-clients',true,true)?>">Clients</a></li>
                <li><span>Create Login Profile</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <form class="form-horizontal" name="create_client_profile" id="create_client_profile">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <section class="card">
                    <header class="card-header">
                        <h2 class="card-title">Create Client Login Profile</h2>
                    </header>
                    <div class="card-body">
                        <div class="row pb-3">
                            <div class="col-sm-12 form-group">
                                <label class="control-label pt-2" for="client_id">Select Client Profile <span class="required">*</span></label>
                                <select class="form-control populate" name="client_id" id="client_id"  required>
                                    <option value=""></option>
                                    <?php
                                    $res = $client->get_all_client_profile($c['company_id']);
                                    if ($res->num_rows > 0) {
                                        while ($row = $res->fetch_assoc()) {
                                            ?>
                                            <option value="<?=$row['client_id'];?>"><?=$row['client_fullname'];?> (<?=$row['client_email'];?>)</option>
                                        <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm-12 form-group">
                                <label class="control-label pt-1" for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm-12 form-group">
                                <label class="control-label pt-1" for="confirm_password">Confirm Password</label>
                                <input type="password" class="form-control"  name="confirm_password" id="confirm_password">
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <div class="row float-start">
                            <div class="col-sm-10">
                                <input type="submit" value="Create Profile" class="btn btn-primary px-4">
                            </div>
                        </div>
                    </footer>
                </section>
            </div>
        </div>
    </form>
</section>
<?php include_once("inc/footer.com.php"); ?>