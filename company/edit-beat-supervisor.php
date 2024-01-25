<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>
    <style>
        a.no_style {
            text-decoration: none;
            background-color: transparent;
        }
        .card-title {
            font-size: 25px !important;
            line-height: 33px !important;
        }
    </style>
<?php
if (!isset($bsu_id) ||$bsu_id == NULL ) {echo "<script>window.location = '".url_path('/company/manage-beat-supervisor',true,true)."'; </script>";}
?>

<?php
$res = $beat->get_beat_supervisor_by_id($bsu_id,$c['company_id']);
if ($res->num_rows > 0) {
while ($bsu = $res->fetch_assoc()) {
?>
<section role="main" class="content-body">
        <header class="page-header">
            <h2>Edit Beat Supervisor: <?=$bsu_id;?></h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Edit Beat Supervisor</span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <form class="form-horizontal" name="update_beat_supervisor" id="update_beat_supervisor">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <section class="card">
                        <header class="card-header">
                            <h2 class="card-title">
                                <a style="float: left;" href="<?= url_path('/company/manage-beat-supervisor',true,true)?>" class="no_style ">
                                    <img src="back.63df8891.svg" alt="back" />
                                </a>
                                <span class="ms-3">Update Beat Supervisor</span>
                            </h2>
                        </header>
                        <div class="card-body">
                            <div class="form-group row pb-3">
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="bs_firstname">Beat Supervisor Firstname<span class="required">*</span></label>
                                    <input type="text" class="form-control shadow-none" name="bs_firstname" id="bs_firstname" value="<?=$bsu['bsu_firstname'];?>">
                                    <input type="hidden" name="bs_id" id="bs_id" value="<?=$bsu['bsu_id'];?>">
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="bs_lastname">Beat Supervisor Lastname<span class="required">*</span></label>
                                    <input type="text" class="form-control shadow-none" name="bs_lastname" id="bs_lastname" value="<?=$bsu['bsu_lastname'];?>">
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
                                            $arrBsu = explode(",", $bsu['bsu_beats']);
                                            ?>
                                            <option value="<?=$row['beat_id'];?>" <?=in_array($row['beat_id'],$arrBsu)?'selected':'';?>><?=$row['beat_name'];?></option>
                                            <?php } } ?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="bs_email">B.S Email Address<span class="required">*</span></label>
                                    <input type="email" class="form-control shadow-none" name="bs_email" id="bs_email" value="<?=$bsu['bsu_email'];?>">
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-12">
                                    <input type="submit" value="Save" class="btn btn-primary px-5">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </form>
        <div class="row"><div class="col-sm-12 my-4"></div></div>
        <form class="form-horizontal" name="update_beat_supervisor_pwd" id="update_beat_supervisor_pwd">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <section class="card">
                        <header class="card-header">
                            <h2 class="card-title">Update Beat Supervisor Password</h2>
                        </header>
                        <div class="card-body">
                            <div class="form-group row pb-3">
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="bs_old_pwd">B.S Old Password<span class="required">*</span></label>
                                    <input type="password" class="form-control shadow-none" name="bs_old_pwd" id="bs_old_pwd">
                                    <input type="hidden" name="bs_id" id="bs_id" value="<?=$bsu['bsu_id'];?>">
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="bs_pwd">B.S New Password<span class="required">*</span></label>
                                    <input type="password" class="form-control shadow-none" name="bs_pwd" id="bs_pwd">
                                    <input type="hidden" name="bs_id" id="bs_id" value="<?=$bsu['bsu_id'];?>">
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label pt-1" for="bs_con_pwd">B.S Confirm Password<span class="required">*</span></label>
                                    <input type="password" class="form-control shadow-none" name="bs_con_pwd" id="bs_con_pwd">
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-sm-12">
                                    <input type="submit" value="Save" class="btn btn-primary px-5">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </form>
    </section>
<?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>