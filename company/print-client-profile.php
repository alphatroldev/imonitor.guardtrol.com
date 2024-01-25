<?php include_once("inc/header.profile.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>

<?php
if (!isset($client_id) || $client_id == NULL ) {echo "<script>window.location = '".url_path('/company/list-clients',true,true)."'; </script>";}
?>
<?php
$res = $company->get_client_profile_by_id($client_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <section role="main" class="card m-5">
            <div class="Profile">
                <header class="clearfix">
                    <div class="header-container">
                        <img src="<?=public_path('uploads/company/'.$row['company_logo']);?>" class="rounded float-left" height="35" alt="Company Logo" />
                        <h4 class="font-weight-bold"><?=$row['company_name'];?></h4>  
                        <div class="text-end">
                            <img src="<?=public_path('uploads/client/'.$row['client_photo']);?>" class="rounded float-right"
                                 style="max-width: 150px; max-height: 170px" alt="Client Photo" />
                        </div>
                    </div>
                    <h2 class="h2 mt-0 mb-3 text-dark text-center font-weight-bold">CLIENT INFORMATION SLIP</h2>                
                </header>

                <div class="personal_details">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Personal Details</p>                
                        <tbody>
                            <tr class="font-weight-semibold"><td>Client ID: </td><td><?=$row['client_id'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Fullname:</td><td><?=$row['client_fullname'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Phone Number:</td><td><?=$row['client_office_phone'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Email:</td><td><?=$row['client_email'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Office Address:</td><td><?=$row['client_office_address'];?></td></tr>
                    </table>
                </div>
               
                <div class="contact_address_details">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Contact Address</p>                
                        <tbody>
                            <tr class="font-weight-semibold"><td>Fullname:</td><td><?=$row['client_contact_fullname'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Phone: </td><td><?=$row['client_contact_phone'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Email: </td><td><?=$row['client_contact_email'];?></td></tr>                            
                        </tbody>                        
                    </table>
                </div>

                <div class="alternative_contact_address_detail">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Alternative Contact Address</p>                
                        <tbody>
                            <tr class="font-weight-semibold"><td>Fullname:</td><td><?=$row['client_contact_fullname_2'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Phone: </td><td><?=$row['client_contact_phone_2'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Email: </td><td><?=$row['client_contact_email_2'];?></td></tr>                            
                        </tbody>                        
                    </table>
                </div>
               
            </div>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>
<script>
    window.print();
</script>
