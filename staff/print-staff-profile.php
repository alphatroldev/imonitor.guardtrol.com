<?php include_once("inc/header.profile.php"); ?>
<?php if (!isset($_SESSION['STAFF_LOGIN'])) header("Location: ../"); ?>

<?php
if (!isset($staff_id) || $staff_id == NULL ) {echo "<script>window.location = '".url_path('/staff/list-staffs',true,true)."'; </script>";}
?>
<?php
$res = $company->get_staff_profile_by_id($staff_id,$c['company_id']);
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
                            <img src="<?=public_path('uploads/staff/'.$row['staff_photo']);?>" class="rounded float-right" width="150" height="200" alt="Staff Photo" />
                        </div>
                    </div>
                    <h2 class="h2 mt-0 mb-3 text-dark text-center font-weight-bold">STAFF INFORMATION SLIP</h2>                
                    <h2 class="h2 mt-0 mb-3 text-dark text-center font-weight-bold">BARCODE</h2>                
                </header>

                <div class="personal_details">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Personal Details</p>                
                        <tbody>
                            <tr class="font-weight-semibold"><td>Staff ID: </td><td><?=$row['staff_id'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Fullname:</td><td><?=$row['staff_firstname'] . ' '.$row['staff_middlename']. ' '.$row['staff_lastname'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Gender</td><td><?=$row['staff_sex'];?></td></tr>
                            <tr class="font-weight-semibold"><td>DOB</td><td><?=$row['stf_dob'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Home Address</td><td><?=$row['stf_home_addr'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Email</td><td><?=$row['staff_email'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Height</td><td><?=$row['stf_height'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Blood Group</td><td><?=$row['stf_blood_grp'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Religion</td><td><?=$row['stf_religion'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Marital Status</td><td><?=$row['stf_marital_stat'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Phone Number</td><td><?=$row['staff_phone'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Role</td><td><?=$row['company_role_name'];?></td></tr>                            
                            <tr class="font-weight-semibold"><td>Qualification</td><td><?=$row['staff_qualification'];?></td></tr>                                                
                        </tbody>                        
                    </table>
                </div>
                <div class="guarantor_details">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Guarantor Details</p>                
                        <tbody>
                        <div class="text-end">
                            <img src="<?=public_path('uploads/staff/'.$row['staff_guarantor_photo']);?>" class="rounded float-right" width="150" height="200" alt="Guarantor's Photo" />
                        </div>
                            <tr class="font-weight-semibold"><td>Title </td><td><?=$row['staff_guarantor_title'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Fullname:</td><td><?=$row['staff_guarantor_firstname'] . ' '.$row['staff_guarantor_middlename']. ' '.$row['staff_guarantor_lastname'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Gender</td><td><?=$row['staff_guarantor_sex'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Email</td><td><?=$row['staff_guarantor_email'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Phone Number</td><td><?=$row['staff_guarantor_phone'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Home Address</td><td><?=$row['staff_guarantor_address'];?></td></tr>                            
                            <tr class="font-weight-semibold"><td>Years of Relationship</td><td><?=$row['staff_guarantor_year_of_relationship'];?></td></tr>                            
                            <tr class="font-weight-semibold"><td>Place of Work</td><td><?=$row['staff_guarantor_place_work'];?></td></tr>                                                
                            <tr class="font-weight-semibold"><td>Rank</td><td><?=$row['staff_guarantor_rank'];?></td></tr>                                                
                        </tbody>                        
                    </table>
                </div>
                <div class="next_of_kin_details">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Next of Kin Details</p>                
                        <tbody>
                            <tr class="font-weight-semibold"><td>Fullname:</td><td><?=$row['next_kin_firstname'] . ' '.$row['next_kin_middlename']. ' '.$row['next_kin_lastname'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Gender</td><td><?=$row['next_kin_gender'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Home Address</td><td><?=$row['next_kin_home_addr'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Phone Number</td><td><?=$row['next_kin_phone'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Relationship</td><td><?=$row['next_kin_relationship'];?></td></tr>                            
                        </tbody>                        
                    </table>
                </div>

                <div class="account_details">
                    <table class="table table-responsive-md">
                        <p class="h5 mb-1 text-dark font-weight-semibold pb-3">Account Details</p>                
                        <tbody>
                            <tr class="font-weight-semibold"><td>Bank: </td><td><?=$row['staff_bank'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Account Name: </td><td><?=$row['staff_account_name'];?></td></tr>
                            <tr class="font-weight-semibold"><td>Account Number: </td><td><?=$row['staff_account_number'];?></td></tr>                                                                          
                        </tbody>                        
                    </table>
                </div>
                <div class="text-end">
                    <?php if ($row['staff_signature']==NULL || $row['staff_signature']=="") {?>
                        <div>No signature found</div>
                <?php } else{?>
                    <img src="<?=public_path('uploads/staff/'.$row['staff_signature']);?>" class="rounded float-right" width="150" height="200"/>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.staff.php"); ?>
<script>
    window.print();
</script>
