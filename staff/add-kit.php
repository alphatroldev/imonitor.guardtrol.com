<?php include_once("inc/header.staff.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Add Kit to Inventory</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/staff/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Add Kit to Inventory</span></li>
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
                            <a href="<?= url_path('/staff/kit-inventory',true,true)?>">
                                <i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Add Kit to Inventory
                        </h2>
                    </header>
                    <form name="add_kit_inventory" id="add_kit_inventory">
                        <div class="card-body">
                            <div id="response-alert"></div>
                            <div class="listing-more">
                                <div class="form-row row">
                                    <div class="col-sm-3 mb-4">
                                        <select id="kit_type_1"  name="kit_type[]" class="form-control" required>
                                            <option value="">Choose kit type</option>
                                            <option value="New">New</option>
                                            <option value="Old">Old</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 mb-4">
                                        <select id="kit_id_1"  name="kit_id[]" class="form-control" required>
                                            <option value="">Choose kit</option>
                                            <?php
                                            $res = $company->get_company_kits_by_id($c['company_id']);
                                            if ($res->num_rows > 0) {
                                                while ($row = $res->fetch_assoc()) {
                                                    ?>
                                                    <option value="<?=$row['kit_name'];?>"><?=$row['kit_name'];?></option>
                                                <?php } } ?>
                                        </select>
                                        <input type="hidden" name="kit_name[]" value="<?=$row['kit_name'];?>">
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <input type="number" class="form-control" id="kit_num_1" name="kit_num[]" placeholder="Kit Quantity" required>
                                        <input type="hidden" name="comp_id" value="<?=$c['company_id'];?>">
                                    </div>
                                    <div class="col-md-2 mb-4">
                                        <a href="javascript:void(0)" class="btn btn-default add_more_kit shadow-none btn-sm p-2">
                                            <i class="fas fa-plus">&nbsp;</i>Add more
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="card-footer py-3">
                            <div class="row">
                                <div class="col-sm-9">
                                    <input class="btn btn-primary px-5" type="submit" value="Add Kit" />
                                </div>
                            </div>
                        </footer>
                    </form>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.staff.php"); ?>
<script>
    $(document).ready(function () {
        var count = 1;
        $(".content-body").on('click', '.add_more_kit', function (e) {
            ++count;
            $('.listing-more').append('<div id="dynamic_field' + count + '" class="form-row row">'+
                '<div class="col-sm-3 mb-4">'+
                '<select id="kit_type_'+count+'"  name="kit_type[]" class="form-control" required>'+
                '<option value="">Choose kit type</option><option value="New">New</option><option value="Old">Old</option>'+
                '</select></div><div class="col-sm-4 mb-4">'+
                '<select id="kit_id_'+count+'"  name="kit_id[]" class="form-control" required>'+
                '<option value="">Choose kit</option>'+
                <?php
                    $res = $company->get_company_kits_by_id($c['company_id']);
                    if ($res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                    ?>
                    '<option value="<?=$row['kit_sno'];?>"><?=$row['kit_name'];?></option>'+
                    <?php } } ?>
                '</select><input type="hidden" name="kit_name[]" value="<?=$row['kit_name'];?>"></div><div class="col-md-3 mb-4">'+
                '<input type="number" class="form-control" id="kit_num_'+count+'" name="kit_num[]" placeholder="Kit Quantity" required>'+
                '</div><div class="col-md-2 mb-4">'+
                '<a href="javascript:void(0)" class="btn btn-danger btn_remove shadow-none btn-sm p-2" id="' + count + '">'+
                '<i class="fas fa-trash-alt">&nbsp;</i>Remove</a></div></div>'
            );
        });

        $(".content-body").on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");$('#dynamic_field'+button_id+'').remove();
            --count;
        });
    });
</script>
