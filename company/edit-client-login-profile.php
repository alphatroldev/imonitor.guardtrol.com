<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<?php
if (!isset($client_id) ||$client_id == NULL ) {echo "<script>window.location = '".url_path('/company/manage-client-profile',true,true)."'; </script>";}
?>

<?php
$res = $client->get_client_login_by_id($client_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($cl = $res->fetch_assoc()) {
?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Edit Client Login</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><a href="<?= url_path('/company/list-clients',true,true)?>">Clients</a></li>
                    <li><span>Edit Client Login</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <form class="form-horizontal" name="update_client_login_pwd" id="update_client_login_pwd">
            <div class="row">
                <div class="col-sm-8 mx-auto">
                    <section class="card">
                        <header class="card-header">
                            <h2 class="card-title">Edit Client Login Profile</h2>
                        </header>
                        <div class="card-body">
                            <div class="row pb-3">
                                <div class="col-sm-12 form-group">
                                    <label class="control-label pt-2" for="client_id">Select Client Profile <span class="required">*</span></label>
                                    <input type="text" name="" class="form-control" value="<?=$cl['client_fullname'];?> (<?=$cl['client_email'];?>)" readonly>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col-sm-12 form-group">
                                    <label class="control-label pt-1" for="password">Password</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                    <input type="hidden" name="client_id" id="client_id" value="<?=$client_id;?>">
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
                                    <input type="submit" value="Update Profile" class="btn btn-primary px-4">
                                </div>
                            </div>
                        </footer>
                    </section>
                </div>
            </div>
        </form>
    </section>
<?php } } ?>
<?php include_once("inc/footer.com.php"); ?>