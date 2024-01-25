<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../");
$f_login = $company->get_company_first_login($c['company_id']); ?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<style>#map { width: 100%;height:780px;}</style>
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>Dashboard: <?=$_SESSION['COMPANY_LOGIN']['company_name'];?></h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Dashboard</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row pt-4">
        <div class="col-lg-12 mb-4 mb-lg-0">
            <div class="row">
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-primary mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-primary">
                                        <i class="fas fa-globe-africa"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Client</h4>
                                        <div class="info">
                                            <strong class="amount"><?=$company->count_total_client($c['company_id'])?></strong>
                                            <span class="text-primary">(<?=$company->count_total_disabled_client($c['company_id'])?> In-active)</span>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="<?= url_path('/company/list-clients',true,true)?>">(view clients)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-secondary">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-secondary">
                                        <i class="fas fa-user-lock"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Guard</h4>
                                        <strong class="amount"><?=$company->count_total_guard($c['company_id'])?></strong>
                                        <span class="text-primary">(<?=$company->count_total_disabled_guard($c['company_id'])?> In-active)</span>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="<?= url_path('/company/list-guardss',true,true)?>">(view guards)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-tertiary mb-3">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-tertiary">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Beat</h4>
                                        <div class="info">
                                            <strong class="amount"><?=$company->count_total_beat($c['company_id'])?></strong>
                                            <span class="text-primary">(<?=$company->count_total_disabled_beat($c['company_id'])?> In-active)</span>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="<?= url_path('/company/list-beats',true,true)?>">(view beats)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-xl-4">
                    <section class="card card-featured-left card-featured-quaternary">
                        <div class="card-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-quaternary">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Staff</h4>
                                        <div class="info">
                                            <strong class="amount"><?=$company->count_total_staff($c['company_id'])?></strong>
                                            <span class="text-primary">(<?=$company->count_total_disabled_staff($c['company_id'])?> In-active)</span>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="<?= url_path('/company/list-staffs',true,true)?>">(view staffs)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <section class="card card-featured card-featured-quaternary mb-4">
                        <div class="card-body">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                <div>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span style="font-size: 16px"><b>Beats Location</b></span>
                                </div>
                            </div>
                            <div id="map"></div>
                            <script>
                                <?php
                                $first_data = $beat->get_beats_first_long_lat($c['company_id']);
                                $lat = $first_data['beat_loc_lati'];
                                $lon = $first_data['beat_loc_long'];
                                ?>
                                var mapOptions = {zoom: 6, center: new google.maps.LatLng(<?=$lat;?>,<?=$lon;?>)};
                                map = new google.maps.Map(document.getElementById('map'), mapOptions);
                                var pinz = [
                                    <?php
                                    $res = $beat->get_beats_long_lat($c['company_id']);
                                    if ($res->num_rows > 0) { while ($row = $res->fetch_assoc()) {
                                    ?>
                                    {
                                        'location':{lat: <?=$row['beat_loc_lati'];?>,lon: <?=$row['beat_loc_long'];?>},
                                        'label' : "<?=substr($row['beat_name'],0,15)?>"
                                    },
                                    <?php } } ?>
                                ];

                                for(var i = 0; i <= pinz.length; i++){
                                    var image = 'data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2238%22%20height%3D%2238%22%20viewBox%3D%220%200%2038%2038%22%3E%3Cpath%20fill%3D%22%23D2312D%22%20stroke%3D%22%23ccc%22%20stroke-width%3D%22.5%22%20d%3D%22M34.305%2016.234c0%208.83-15.148%2019.158-15.148%2019.158S3.507%2025.065%203.507%2016.1c0-8.505%206.894-14.304%2015.4-14.304%208.504%200%2015.398%205.933%2015.398%2014.438z%22%2F%3E%3Ctext%20transform%3D%22translate%2819%2018.5%29%22%20fill%3D%22%23fff%22%20style%3D%22font-family%3A%20Arial%2C%20sans-serif%3Bfont-weight%3Abold%3Btext-align%3Acenter%3B%22%20font-size%3D%2212%22%20text-anchor%3D%22middle%22%3E' + pinz[i].label + '%3C%2Ftext%3E%3C%2Fsvg%3E';
                                    var myLatLng = new google.maps.LatLng(pinz[i].location.lat, pinz[i].location.lon);
                                    var marker = new google.maps.Marker({
                                        position: myLatLng,
                                        map: map,
                                        icon: image
                                    });
                                }
                            </script>
                        </div>
                    </section>
                </div>
                <div class="col-lg-12">
                    <section class="card card-featured card-featured-info mb-4">
                        <div class="card-body">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                <div>
                                    <i class="fas fa-comments"></i>
                                    <span style="font-size: 16px">Recent Activity</span>
                                </div>
                                <div>
                                    <a href="<?= url_path('/company/all-notifications',true,true)?>" class="btn btn-default btn-sm">View All</a>
                                </div>
                            </div>
                            <div>
                                <table class="table table-borderless mb-0" id="datatable-company">
                                    <tbody class="notification-menu">
                                    <?php
                                    $res = $company->get_notifications($c['company_id'],10);
                                    if ($res->num_rows > 0) {
                                    while ($row = $res->fetch_assoc()) {
                                    $note_arr = json_decode($row['note_data']);
                                    ?>
                                    <tr>
                                        <td>
                                            <ul>
                                                <li>
                                                    <a href="javascript:void" data-note_id="<?=$row['note_id'];?>" data-note_url="<?=$note_arr->actionURL;?>"
                                                       data-comp_id="<?=$row['company_id'];?>" id="notificationStatusBtn" class="clearfix">
                                                        <div class="image">
                                                            <img class="rounded-circle" width="40" src="<?=!empty($note_arr->photo)
                                                                ?public_path("uploads/staff/".$note_arr->photo):public_path("img/!logged-user.jpg");?>" alt="">
                                                        </div>
                                                        <span class="title text-success font-weight-bold"><?=$note_arr->name;?></span>
                                                        <span class="message text-dark"><?=$note_arr->body;?></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                        <td style="text-align: right">
                                            <span class="message"><?=$company->time_elapsed_string($row['note_created_at']);?></span>
                                        </td>
                                    </tr>
                                    <?php } } else { echo "<tr><td colspan='12' class='text-center'>No Notifications found</td></tr>";} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <input type="hidden" id="F_Login" value="<?= $f_login->num_rows > 0 ?'YES':'NO';?>">
    </div>
</section>
<div id="ConfigurationModal" class="zoom-anim-dialog modal-block modal-block-lg modal-header-color modal-block-primary mfp-hide">
    <section class="card">
        <header class="card-header">
            <h2 class="card-title">Quick setup wizard</h2>
        </header>
        <div class="card-body">
            <div class="modal-wrapper py-3">
                <form id="company_configuration" name="company_configuration">
                    <div id="response-alert"></div>
                    <input type="hidden" name="comp_id" id="comp_id" value="<?= $c['company_id']; ?>" />
                    <div class="row form-group">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="uniform_charge">Uniform</label>
                                <small class="text-info"> (Do you charge for uniform?)</small>
                                <select class="form-control mb-3" name="uniform_charge" id="uniform_charge">
                                    <option value=""></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 row_uniform">
                            <div class="form-group">
                                <label for="uniform_charge_amt">Uniform Charge Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₦</span>
                                    <input name="uniform_charge_amt" type="number" class="form-control" id="uniform_charge_amt" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 row_uniform">
                            <div class="form-group">
                                <label for="uni_mode">Mode of deduction</label>
                                <select class="form-control mb-3" name="uni_mode" id="uni_mode">
                                    <option value=""></option>
                                    <option value="1 month pay off">1 month pay off</option>
                                    <option value="2 months pay off">2 months pay off</option>
                                    <option value="3 months pay off">3 months pay off</option>
                                    <option value="fixed amount monthly">fixed amount monthly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="agent">Agents</label>
                                <small class="text-info">Do you source through agents?</small>
                                <select class="form-control mb-3" name="agent"  id="agent">
                                    <option value=""></option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 row_agent">
                            <div class="form-group">
                                <label for="agent_fee">Agent Fee Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₦</span>
                                    <input name="agent_fee" type="number" class="form-control" id="agent_fee" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 row_agent">
                            <label for="agent_mode">Mode of deduction</label>
                            <select class="form-control mb-3" name="agent_mode" id="agent_mode">
                                <option value=""></option>
                                <option value="1 month pay off">1 month pay off</option>
                                <option value="2 months pay off">2 months pay off</option>
                                <option value="3 months pay off">3 months pay off</option>
                                <option value="fixed amount monthly">fixed amount monthly</option>
                                <option value="Not now">Not now</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
<!--                        <div class="col-lg-6">-->
<!--                            <div class="form-group">-->
<!--                                <label for="shift">Shift Arrangement</label>-->
<!--                                <small class="text-info">Select your shift duty?</small>-->
<!--                                <select class="form-control mb-3" name="shift" id="shift">-->
<!--                                    <option value="12 hours duty">12 hours</option>-->
<!--                                    <option value="24 hours duty">24 hours (1 day in, 1 day out)</option>-->
<!--                                    <option value="Permanent deployment">Permanent deployment</option>-->
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="act_date">Activation Date</label>
                                <small class="text-info">When will your guard start earning?</small>
                                <select class="form-control mb-3" name="act_date" id="act_date">
                                    <option value="immediately">Immediately</option>
                                    <option value="2 days">2 Days</option>
                                    <option value="1 week">1 Week</option>
                                    <option value="2 weeks">2 Weeks</option>
                                    <option value="1 month">1 Month</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="loan_type">Loan Config Type</label>
                                <small class="text-info">do your loan payment roll over to next year?</small>
                                <select class="form-control mb-3" name="loan_type" id="loan_type">
                                    <option value=""></option>
                                    <option value="yearly loan repayment type">Yearly bound loan repayment type</option>
                                    <option value="indefinite loan repayment type">indefinite loan repayment type</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <input type="submit" class="btn btn-primary mt-2 px-3" value="Save Configuration" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php include_once("inc/footer.com.php"); ?>
<script>
    (function($) {
        $(window).on("load", function () {
            if ($("#F_Login").val() ==='YES') {
                $.magnificPopup.open({
                    items: {src: '#ConfigurationModal'},
                    type: 'inline', fixedContentPos: false, fixedBgPos: true, overflowY: 'auto', closeBtnInside: false,
                    preloader: false, midClick: false, removalDelay: 300, mainClass: 'my-mfp-zoom-in', modal: true
                }, 0);
            }
        });

        $(document).on('click', '.modal-dismiss', function (e) {
            e.preventDefault();
            $.magnificPopup.close();
        });

    })(jQuery);
</script>
<script>
    $(function() {
        $('.row_uniform').hide();
        $('.row_agent').hide();
        $('#uniform_charge').change(function(){
            if($('#uniform_charge').val() === 'Yes') { $('.row_uniform').show();}
            else { $('.row_uniform').hide(); }
        });
        $('#agent').change(function(){
            if($('#agent').val() === 'Yes') { $('.row_agent').show();}
            else { $('#row_agent').hide(); }
        });
    });
</script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyAZke8FDnH6ZVMcQEtbCMFn69Mlgulgvfg" type="text/javascript"></script>