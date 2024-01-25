<?php include_once("inc/header.profile.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>

<?php
if (!isset($guard_id) || $guard_id == NULL ) {echo "<script>window.location = '".url_path('/company/list-guards',true,true)."'; </script>";}
?>
<?php
$res = $company->get_guard_profile_by_id($guard_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        ?>
        <section role="main" class="card m-5">
            <div class="Profile">
                <header class="clearfix">
                    <div class="header-container">
                        <img src="<?=public_path('uploads/company/'.$row['company_logo']);?>" class="rounded float-left" width="75" height="35" alt="Company Logo" />
                        <h4 class="font-weight-bold"><?=$row['company_name'];?></h4>
                        <div class="text-end">
                            <img src="<?=public_path('uploads/guard/'.$row['guard_photo']);?>" class="rounded float-right" width="100" height="100" alt="Guard Photo" />
                        </div>
                    </div>
                    <h2 class="h2 mt-0 mb-3 text-dark text-center font-weight-bold">GUARD INFORMATION SLIP</h2>
                </header>
                <div class="personal_details">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Personal Details</p>
                        <tbody>
                        <tr class="font-weight-semibold"><td>Guard ID: </td><td><?=$row['guard_id'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Full Name:</td>
                            <td><?=$row['guard_firstname']." ".$row['guard_middlename']." ".$row['guard_lastname'];?></td>
                        </tr>
                        <tr class="font-weight-semibold"><td>Gender</td><td><?=$row['sex'];?></td></tr>
                        <tr class="font-weight-semibold"><td>DOB</td><td><?=$row['dob'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Home Address</td><td><?=$row['guard_address'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Height</td><td><?=$row['height'];?></td></tr>
                        <tr class="font-weight-semibold"><td>State Of Origin</td><td><?=$row['state_of_origin'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Blood Group</td><td><?=$row['blood_group'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Religion</td><td><?=$row['religion'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Phone Number</td><td><?=$row['phone'].' '.$row['phone2'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Qualification</td><td><?=$row['qualification'];?></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="referral_details">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Referral Details</p>
                        <tbody>
                        <tr class="font-weight-semibold"><td>Referral </td><td><?=$row['referral'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Referral Name</td><td><?=$row['referral_name'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Referral Phone</td><td><?=$row['referral_phone'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Referral Address</td><td><?=$row['referral_address'];?></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="guarantor_details">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Guarantor Details</p>
                        <tbody>
                        <div class="text-end">
                            <img src="<?=public_path('uploads/guard/'.$row['guarantor_photo']);?>" class="rounded float-right" width="100" height="100" alt="Guarantor's Photo" />
                        </div>
                        <tr class="font-weight-semibold"><td>Title </td><td><?=$row['guarantor_title'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Fullname:</td>
                            <td><?=$row['guarantor_fname']." ".$row['guarantor_mname']." ".$row['guarantor_lname'];?></td>
                        </tr>
                        <tr class="font-weight-semibold"><td>Gender</td><td><?=$row['guarantor_sex'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Email</td><td><?=$row['guarantor_email'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Phone Number</td><td><?=$row['guarantor_phone'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Home Address</td><td><?=$row['guarantor_add'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Years of Relationship</td><td><?=$row['guarantor_yr_or'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Place of Work</td><td><?=$row['guarantor_wk_add'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Rank</td><td><?=$row['guarantor_rank'];?></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="next_of_kin_details">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Next of Kin Details</p>
                        <tbody>
                        <tr class="font-weight-semibold"><td>Fullname:</td><td><?=$row['next_kin_name'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Phone Number</td><td><?=$row['next_kin_phone'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Relationship</td><td><?=$row['next_kin_relationship'];?></td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="account_details">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Account Details</p>
                        <tbody>
                        <tr class="font-weight-semibold"><td>Bank: </td><td><?=$row['bank'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Account Name: </td><td><?=$row['account_name'];?></td></tr>
                        <tr class="font-weight-semibold"><td>Account Number: </td><td><?=$row['account_number'];?></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-end">
                    <?php if ($row['guard_signature']==NULL || $row['guard_signature']=="") {?>
                        <div>No signature found</div>
                    <?php } else{?>
                        <img src="<?=public_path('uploads/guard/'.$row['guard_signature']);?>" class="rounded float-right" width="100" height="50"/>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>
<script>
    window.print();
</script>
