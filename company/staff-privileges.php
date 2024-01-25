<?php include_once("inc/header.com.php"); ?>
<?php if (!isset($_SESSION['COMPANY_LOGIN'])) header("Location: ../"); ?>

<?php
if (!isset($staff_id) || $staff_id == NULL ) {echo "<script>window.location = '".url_path('/company/list-staffs',true,true)."'; </script>";}
?>
<?php
$res = $company->get_staff_privileges_by_id($staff_id,$c['company_id']);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $staff_perm = $privileges->get_staff_permission_sno($staff_id);
        $perm_sno = $staff_perm->fetch_assoc();
        if (!empty($perm_sno)) {
            $array = array_map('intval', explode(',', $perm_sno['perm_sno']));
        } else {
            $array = [];
        }
        ?>
        <section role="main" class="content-body">
            <header class="page-header">
                <h2><a href="<?= url_path('/company/edit-staff/'.$row['staff_id'],true,true);?>"><i class="fas fa-arrow-left">&nbsp;</i></a>Staff Privileges</h2>
                <div class="right-wrapper text-end">
                    <ol class="breadcrumbs">
                        <li>
                            <a href="<?= url_path('/company/main',true,true)?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li><span>Staff Privileges</span></li>
                    </ol>
                    <a class="sidebar-right-toggle"></a>
                </div>
            </header>
            <div class="col-lg-12">
                <form id="assign_staff_privileges" name="assign_staff_privileges">
                    <section class="card">
                        <header class="card-header">
                            <div class="card-actions"></div>
                            <h2 class="card-title pb-3"><span class="fw-bold">Full name: </span>  <span class="text-primary"><?=$row['staff_firstname'].' '.$row['staff_lastname'] ;?></span> </h2>
                            <h2 class="card-title pb-3"><span class="fw-bold">Staff ID: </span>  <span class="text-primary"><?=$row['staff_id'];?></span> </h2>
                            <h2 class="card-title pb-5"><span class="fw-bold">Role: </span>  <span class="text-primary"><?=$row['company_role_name'];?></span> </h2>
                            <input type="hidden" name="staff_id" value="<?=$row['staff_id'];?>"/>
                            <input type="hidden" name="company_role_sno" value="<?=$row['comp_role_sno'];?>"/>

                            <a class="btn btn-xs btn-default" onclick='selectAll()'><i class="fas fa fa-check">&nbsp;</i>Select All</a>
                            <a class="btn btn-xs btn-default" onclick='deSelectAll()'><i class="fas fa fa-times">&nbsp;</i>Deselect All</a>

                        </header>
                        <div class="card-body">
                            <div class="form-group row pb-2">
                                <h3 class="fw-bold">HR/ADMIN </span> </h3>
                                <hr>
                                <div class="row">
                                    <!-- Guards Details -->
                                    <div class="col-sm-4">
                                    
                                        <label class="pb-3 control-label text-sm-end pt-2">Guard Details</label>
                                        <?php 
                                          $res = $privileges->get_hr_admin_guard_details();
                                            while ($row = $res->fetch_assoc()) {
                                            if(in_array($row['perm_sno'], $array)){
                                        ?>                                       
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="hr_admin_guard_details[]" checked/>
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }else{?>
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="hr_admin_guard_details[]" />
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }}?>
                                        <label class="error" for="dd"></label>
                                    </div>

                                    <!-- Staff Details -->
                                    <div class="col-sm-4">
                                        <label class="pb-3 control-label text-sm-end pt-2">Staff Details</label>
                                        <?php 
                                          $res = $privileges->get_hr_admin_staff_details();
                                            while ($row = $res->fetch_assoc()) {
                                            if(in_array($row['perm_sno'], $array)){    
                                        ?>    
                                         <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="hr_admin_staff_details[]" checked/>
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }else{?>
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="hr_admin_staff_details[]" />
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }}?>
                                        <label class="error" for="dd"></label>
                                    </div>

                                    <!-- Clients/Beats Details -->
                                    <div class="col-sm-4">
                                        <label class="pb-3 control-label text-sm-end pt-2">Clients/Beats Details</label>
                                        <?php 
                                          $res = $privileges->get_hr_admin_client_beat_details();
                                            while ($row = $res->fetch_assoc()) {
                                            if(in_array($row['perm_sno'], $array)){     
                                        ?>   
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="hr_admin_client_beat_details[]" checked/>
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }else{?>
                                            <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="hr_admin_client_beat_details[]" />
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }}?>
                                        <label class="error" for="dd"></label>
                                    </div>
                                    
                                </div>
                               
                            </div>
                            <hr>
                            <!-- Operations -->
                            <div class="form-group row pb-2">
                                <h3 class="fw-bold">OPERATIONS </h3>
                                <hr>
                                <div class="row">
                                    <!-- Guards Details -->
                                    <div class="col-sm-4">
                                        <label class="pb-3 control-label text-sm-end pt-2">Guard Details</label>
                                        <?php 
                                          $res = $privileges->get_operations_guard_details();
                                            while ($row = $res->fetch_assoc()) {
                                            if(in_array($row['perm_sno'], $array)){    
                                        ?>                                       
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="operations_guard_details[]" checked/>
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }else{?> 
                                            <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="operations_guard_details[]"/>
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php } }?>            
                                        <label class="error" for="dd"></label>
                                    </div>

                                    <!-- Inventory Details -->
                                    <div class="col-sm-4">
                                        <label class="pb-3 control-label text-sm-end pt-2">Inventory Details</label>
                                        <?php 
                                          $res = $privileges->get_operations_inventory_details();
                                            while ($row = $res->fetch_assoc()) {
                                            if(in_array($row['perm_sno'], $array)){    
                                        ?>
                                         <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="operations_inventory_details[]" checked/>
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }else{?> 
                                            <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="operations_inventory_details[]" />
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }}?> 
                                        <label class="error" for="dd"></label>
                                    </div>

                                    <!--Incident Reports -->
                                    <div class="col-sm-4">
                                        <label class="pb-3 control-label text-sm-end pt-2">Incident Details</label>
                                        <?php 
                                          $res = $privileges->get_operations_incident_details();
                                            while ($row = $res->fetch_assoc()) {
                                            if(in_array($row['perm_sno'], $array)){     
                                        ?>
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="operations_incident_details[]" checked/>
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }else{?>
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="operations_incident_details[]" />
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>  
                                        <?php }}?>                                    
                                        <label class="error" for="dd"></label>
                                    </div>                                    
                                </div>
                            </div>
                            <hr>
                            <!-- Accounts -->
                            <div class="form-group row pb-2">
                                <h3 class="fw-bold">ACCOUNTS</span> </h3>
                                <hr>
                                <div class="row">
                                    <!-- Invoice Details -->
                                    <div class="col-sm-4">
                                        <label class="pb-3 control-label text-sm-end pt-2">Invoice Details</label>
                                        <?php 
                                            $res = $privileges->get_accounts_invoice_details();
                                            while ($row = $res->fetch_assoc()) {
                                            if(in_array($row['perm_sno'], $array)){
                                        ?>                                       
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="accounts_invoice_details[]" checked/>
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }else{?>
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="accounts_invoice_details[]" />
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }}?>              
                                        <label class="error" for="dd"></label>
                                    </div>

                                    <!-- Paymnent Details -->
                                    <div class="col-sm-4">
                                        <label class="pb-3 control-label text-sm-end pt-2">Payment Details</label>
                                        <?php 
                                          $res = $privileges->get_accounts_payment_details();
                                            while ($row = $res->fetch_assoc()) {
                                            if(in_array($row['perm_sno'], $array)){    
                                        ?>
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="accounts_payment_details[]" checked/>
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }else{?>
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="accounts_payment_details[]" />
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }}?>
                                        <label class="error" for="dd"></label>
                                    </div>

                                    <!--Payment History -->
                                    <div class="col-sm-4">
                                        <label class="pb-3 control-label text-sm-end pt-2">Payment History</label>
                                        <?php 
                                          $res = $privileges->get_accounts_payment_history();
                                            while ($row = $res->fetch_assoc()) {
                                            if(in_array($row['perm_sno'], $array)){    
                                        ?>
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="accounts_payment_history[]" checked/>
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>
                                        <?php }else{?>
                                        <div class="checkbox-custom chekbox-primary">
                                            <input id="for-website-<?= $row['perm_sno'];?>" value="<?= $row['perm_sno'];?>" type="checkbox" name="accounts_payment_history[]" />
                                            <label for="for-website-<?= $row['perm_sno'];?>"><?= $row['perm_description'];?></label>
                                        </div>  
                                        <?php }}?>                                    
                                        <label class="error" for="dd"></label>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <footer class="card-footer">
                            <div class="row justify-content-start">
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="<?= url_path('/company/edit-staff/'.$row['staff_id'],true,true);?>" type="reset" class="btn btn-default">Back</a>
                                </div>
                            </div>
                        </footer>
                    </section>
                </form>
            </div>
            <!-- end: page -->
        </section>
    <?php } } else { include_once("404.php"); } ?>
<?php include_once("inc/footer.com.php"); ?>
<script type="text/javascript">  
            function selectAll(){  
                var hr_admin_guard_details=document.getElementsByName('hr_admin_guard_details[]');  
                for(var i=0; i<hr_admin_guard_details.length; i++){  
                    if(hr_admin_guard_details[i].type=='checkbox')  
                    hr_admin_guard_details[i].checked=true;  
                }

                var hr_admin_staff_details=document.getElementsByName('hr_admin_staff_details[]');  
                for(var i=0; i<hr_admin_staff_details.length; i++){  
                    if(hr_admin_staff_details[i].type=='checkbox')  
                    hr_admin_staff_details[i].checked=true;  
                }
                
                var hr_admin_client_beat_details=document.getElementsByName('hr_admin_client_beat_details[]');  
                for(var i=0; i<hr_admin_client_beat_details.length; i++){  
                    if(hr_admin_client_beat_details[i].type=='checkbox')  
                    hr_admin_client_beat_details[i].checked=true;  
                }
                var operations_guard_details=document.getElementsByName('operations_guard_details[]');  
                for(var i=0; i<operations_guard_details.length; i++){  
                    if(operations_guard_details[i].type=='checkbox')  
                    operations_guard_details[i].checked=true;  
                }
                var operations_inventory_details=document.getElementsByName('operations_inventory_details[]');  
                for(var i=0; i<operations_inventory_details.length; i++){  
                    if(operations_inventory_details[i].type=='checkbox')  
                    operations_inventory_details[i].checked=true;  
                }
                var operations_incident_details=document.getElementsByName('operations_incident_details[]');  
                for(var i=0; i<operations_incident_details.length; i++){  
                    if(operations_incident_details[i].type=='checkbox')  
                    operations_incident_details[i].checked=true;  
                }
                var accounts_invoice_details=document.getElementsByName('accounts_invoice_details[]');  
                for(var i=0; i<accounts_invoice_details.length; i++){  
                    if(accounts_invoice_details[i].type=='checkbox')  
                    accounts_invoice_details[i].checked=true;  
                }
                var accounts_payment_details=document.getElementsByName('accounts_payment_details[]');  
                for(var i=0; i<accounts_payment_details.length; i++){  
                    if(accounts_payment_details[i].type=='checkbox')  
                    accounts_payment_details[i].checked=true;  
                }
                var accounts_payment_history=document.getElementsByName('accounts_payment_history[]');  
                for(var i=0; i<accounts_payment_history.length; i++){  
                    if(accounts_payment_history[i].type=='checkbox')  
                    accounts_payment_history[i].checked=true;  
                }
            }  
            function deSelectAll(){  
                var hr_admin_guard_details=document.getElementsByName('hr_admin_guard_details[]');  
                for(var i=0; i<hr_admin_guard_details.length; i++){  
                    if(hr_admin_guard_details[i].type=='checkbox')  
                    hr_admin_guard_details[i].checked=false;  
                      
                }
                var hr_admin_staff_details=document.getElementsByName('hr_admin_staff_details[]');  
                for(var i=0; i<hr_admin_staff_details.length; i++){  
                    if(hr_admin_staff_details[i].type=='checkbox')  
                    hr_admin_staff_details[i].checked=false;  
                      
                }
                var hr_admin_client_beat_details=document.getElementsByName('hr_admin_client_beat_details[]');  
                for(var i=0; i<hr_admin_client_beat_details.length; i++){  
                    if(hr_admin_client_beat_details[i].type=='checkbox')  
                    hr_admin_client_beat_details[i].checked=false;  
                      
                }
                var operations_guard_details=document.getElementsByName('operations_guard_details[]');  
                for(var i=0; i<operations_guard_details.length; i++){  
                    if(operations_guard_details[i].type=='checkbox')  
                    operations_guard_details[i].checked=false;  
                      
                }
                var operations_inventory_details=document.getElementsByName('operations_inventory_details[]');  
                for(var i=0; i<operations_inventory_details.length; i++){  
                    if(operations_inventory_details[i].type=='checkbox')  
                    operations_inventory_details[i].checked=false;  
                      
                }
                var operations_incident_details=document.getElementsByName('operations_incident_details[]');  
                for(var i=0; i<operations_incident_details.length; i++){  
                    if(operations_incident_details[i].type=='checkbox')  
                    operations_incident_details[i].checked=false;  
                      
                }
                var accounts_invoice_details=document.getElementsByName('accounts_invoice_details[]');  
                for(var i=0; i<accounts_invoice_details.length; i++){  
                    if(accounts_invoice_details[i].type=='checkbox')  
                    accounts_invoice_details[i].checked=false;  
                      
                }
                var accounts_payment_details=document.getElementsByName('accounts_payment_details[]');  
                for(var i=0; i<accounts_payment_details.length; i++){  
                    if(accounts_payment_details[i].type=='checkbox')  
                    accounts_payment_details[i].checked=false;  
                      
                }
                var accounts_payment_history=document.getElementsByName('accounts_payment_history[]');  
                for(var i=0; i<accounts_payment_history.length; i++){  
                    if(accounts_payment_history[i].type=='checkbox')  
                    accounts_payment_history[i].checked=false;  
                      
                }
            }             
</script>
