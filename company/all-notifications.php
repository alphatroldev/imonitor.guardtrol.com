<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ./"); ?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Notifications: <i class="fas fa-comments"></i>
            <span style="font-size: 16px">Recent Activity</span></h2>
        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li><a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a></li>
                <li><span>Notifications</span></li>
            </ol>
            <a class="sidebar-right-toggle"></a>
        </div>
    </header>
    <div class="row">
        <div class="col-lg-12">
            <section class="card card-featured card-featured-info mb-4">
                <div class="card-body">
                    <div>
                        <table class="table table-borderless mb-0" id="datatable-notification">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="notification-menu">
                            <?php
                            $res = $company->get_all_notifications($c['company_id']);
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
</section>
<?php include_once("inc/footer.com.php"); ?>
<script>
    $('#datatable-notification').dataTable( {
        "lengthChange": false,
        "bSort": false,

    } );
</script>
