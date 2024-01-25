<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>List Xtra Duty</h2>
            <div class="right-wrapper text-end">
                <ol class="breadcrumbs">
                    <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                    <li><span>Xtra Duty: <?= $guard_id; ?></span></li>
                </ol>
                <a class="sidebar-right-toggle"></a>
            </div>
        </header>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions"><a href="#" class="card-action card-action-toggle" data-card-toggle></a></div>
                        <h2 class="card-title">
                            <a href="<?= url_path('/company/edit-guard/'.$guard_id,true,true)?>">
                                <i class="fas fa-arrow-left">&nbsp;&nbsp;</i></a>Xtra Duty - <?= $guard_id; ?></h2>
                    </header>
                    <div class="card-body">
                        
                        <table class="table table-bordered table-no-more mb-0" id="datatable-company">
                            <thead>
                            <tr>
                                <th>s/n</th>
                                <th>Beat Name</th>
                                <th>Replacement Guard</th>
                                <th>Days</th>
                                <th>Days Amount</th>
                                <th>Remark</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $res = $company->get_all_guard_xtraduties($guard_id);
                            if ($res->num_rows > 0) {$n=0;
                                while ($row = $res->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td data-title="sno"><?=++$n;?></td>
                                        <td data-title="Beat Name"><?= $row['beat_name'];?></td>
                                        <td data-title="Replacement Guard">
                                            <?php
                                            if($row['guard_replace'] != "Short Leg"){
                                                $g = $company_>get_guard_name_for_extra_duty($c['company_id'],$guard_id);
                                                echo $g['full_name'];
                                            } else { echo $row['guard_replace']; }
                                            ?>
                                        </td>
                                        <td data-title="Days"><?= $row['no_of_days'];?></td>
                                        <td data-title="Days Amount"><?= $row['days_amount'];?></td>
                                        <td data-title="Remark"><?= $row['reason_remark'];?></td>
                                        <td data-title="Created Date"><?= date("d/m/Y H:i", strtotime($row['created_at']));?></td>
                                        <td data-title="Actions" class="actions">
                                            <a href="javascript:void(0)" data-xtraduty_id="<?= $row['id'];?>" data-comp_id="<?=$c['company_id'];?>" class="on-default text-danger" id="xtraDutyDeleteBtn">
                                                <i class="far fa-trash-alt"></i> delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php } } else { echo "<tr><td colspan='12' class='text-center'>No xtra duties found</td></tr>";} ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </section>
<?php include_once("inc/footer.com.php"); ?>
<script>
    (function($) {
        'use strict';
        $('.add-kit-modal').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#name',
            modal: true,
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in',
            callbacks: {
                beforeOpen: function() {
                    if($(window).width() < 700) {this.st.focus = false;}
                    else {this.st.focus = '#name';}
                }
            }
        });
    }).apply(this, [jQuery]);
</script>
<script>
    (function($) {
        'use strict';
        $('.reg-kit-modal').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#kit_type',
            modal: true,
            fixedContentPos: false,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in',
            callbacks: {
                beforeOpen: function() {
                    if($(window).width() < 700) {this.st.focus = false;}
                    else {this.st.focus = '#kit_type';}
                }
            }
        });
    }).apply(this, [jQuery]);
</script>
