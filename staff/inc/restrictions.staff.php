        <?php
        $location_redirect ="./staff/main";
        $perm_sno = $privileges->staff_perm_ids($_SESSION['STAFF_LOGIN']['staff_id']);
        $array = array_map('intval', explode(',',$perm_sno['perm_sno']));

        $create_client_permission_sno = $privileges->get_create_client_permission_id();
        $list_client_permission_sno = $privileges->get_view_client_permission_id();

        $add_new_staff_permission_sno = $privileges->get_create_staff_permission_id();
        $view_staff_permission_sno = $privileges->get_view_staff_permission_id();
        $add_new_guard_permission_sno = $privileges->get_register_guard_permission_id();
        $view_guard_permission_sno = $privileges->get_view_guard_permission_id();
        $deploy_guard_permission_sno = $privileges->get_deploy_guard_permission_id();
        $redeploy_guard_permission_sno = $privileges->get_redeploy_guard_permission_id();
        $norminal_row_permission_sno = $privileges->get_norminal_roll_permission_id();

        $create_incident_rep_permission_sno = $privileges->get_create_incident_rep_permission_id();
        $incident_rep_permission_sno = $privileges->get_incident_rep_permission_id();
        $staff_off_permission_sno = $privileges->get_staff_off_permission_id();
        $guard_off_permission_sno = $privileges->get_guard_off_permission_id();

        $generate_inv_permission_sno = $privileges->get_generate_inv_permission_id();
        $inv_history_permission_sno = $privileges->get_inv_history_permission_id();
        $pay_report_permission_sno = $privileges->get_pay_report_permission_id();
        $gen_payroll_permission_sno = $privileges->get_generate_payroll_permission_id();
        $payroll_his_permission_sno = $privileges->get_payroll_history_permission_id();
        $kit_inventory_permission_sno = $privileges->get_kit_inventory_permission_id();
        $loan_history_permission_sno = $privileges->get_loan_history_permission_id();
        $rep_preview_generate_permission_sno = $privileges->get_report_preview_permission_id();

        if(in_array($create_client_permission_sno['perm_sno'], $array)){
            $add_new_client_nav = "<li><a class='nav-link' href='".url_path('/staff/create-client',true,true)."'>Add New Client</a></li>";
        }else{$add_new_client_nav="";}

        if(in_array($list_client_permission_sno['perm_sno'], $array)){
            $list_clients_nav = "<li><a class='nav-link' href='".url_path('/staff/list-clients',true,true)."'>List Clients</a></li>";
        }else{$list_clients_nav="";}

        if(in_array($list_client_permission_sno['perm_sno'], $array)){
            $list_beats_nav = "<li><a class='nav-link' href='".url_path('/staff/list-beats',true,true)."'>List Beats</a></li>";
        }else{$list_beats_nav="";}

       


        if(in_array($add_new_staff_permission_sno['perm_sno'], $array)){
            $add_new_staff_nav = "<li><a class='nav-link' href='".url_path('/staff/add-staff',true,true)."'>Add New Staff</a></li>";
        }else{$add_new_staff_nav="";}

        if(in_array($view_staff_permission_sno['perm_sno'], $array)){
            $list_staff_nav = "<li><a class='nav-link' href='".url_path('/staff/list-staffs',true,true)."'>List Staffs</a></li>";
        }else{$list_staff_nav="";}

        if(in_array($add_new_guard_permission_sno['perm_sno'], $array)){
            $add_new_guard_nav = "<li><a class='nav-link' href='".url_path('/staff/create-guard',true,true)."'>Add New Guard</a></li>";
        }else{$add_new_guard_nav="";}

        if(in_array($view_guard_permission_sno['perm_sno'], $array)){
            $list_guards_nav = "<li><a class='nav-link' href='".url_path('/staff/list-guards',true,true)."'>List Guards</a></li>";
        }else{$list_guards_nav="";}

        if(in_array($deploy_guard_permission_sno['perm_sno'], $array)){
            $deploy_guard_nav = "<li><a class='nav-link' href='".url_path('/staff/deploy-guard',true,true)."'>Deploy Guard</a></li>";
        }else{$deploy_guard_nav="";}

        if(in_array($norminal_row_permission_sno['perm_sno'], $array)){
            $norminal_row_nav = "<li><a class='nav-link' href='".url_path('/staff/list-norminal-rolls',true,true)."'>Norminal rolls</a></li>";
        }else{$norminal_row_nav="";}
        
        if(in_array($view_guard_permission_sno['perm_sno'], $array)){
            $guard_payroll_data_history_nav = "<li><a class='nav-link' href='".url_path('/staff/guard-payroll-data-history',true,true)."'>Guards Payroll Data History
            </a></li>";
        }else{$guard_payroll_data_history_nav="";}


        if(in_array($create_incident_rep_permission_sno['perm_sno'], $array)){
            $create_incident_rep_nav = "<li><a class='nav-link' href='".url_path('/staff/incident',true,true)."'>Report Incident</a></li>";
        }else{$create_incident_rep_nav="";}

        if(in_array($incident_rep_permission_sno['perm_sno'], $array)){
            $incident_rep_nav = "<li><a class='nav-link' href='".url_path('/staff/all-incident',true,true)."'>All Incident</a></li>";
        }else{$incident_rep_nav="";}

        if(in_array($staff_off_permission_sno['perm_sno'], $array)){
            $staff_off_nav = "<li><a class='nav-link' href='".url_path('/staff/staff-offenses',true,true)."'>Staff Offence</a></li>
                              <li><a class='nav-link' href='".url_path('/staff/staff-pardon-history',true,true)."'>Staff Pardon History</a></li>";
        }else{$staff_off_nav="";}

        if(in_array($guard_off_permission_sno['perm_sno'], $array)){
            $guard_off_nav = "<li><a class='nav-link' href='".url_path('/staff/guard-offenses',true,true)."'>Guard Offence</a></li>
                              <li><a class='nav-link' href='".url_path('/staff/guard-pardon-history',true,true)."'>Guard Pardon History</a></li>
                              <li><a class='nav-link' href='".url_path('/staff/guard-route-task',true,true)."'>Route Task</a></li>";
        }else{$guard_off_nav="";}



        if(in_array($generate_inv_permission_sno['perm_sno'], $array)){
            $generate_inv_nav = "<li><a class='nav-link' href='".url_path('/staff/generate-invoice',true,true)."'>Generate Invoice</a></li>";
        }else{$generate_inv_nav="";}

        if(in_array($inv_history_permission_sno['perm_sno'], $array)){
            $inv_history_nav = "<li><a class='nav-link' href='".url_path('/staff/invoice-history',true,true)."'>Invoice History</a></li>";
        }else{$inv_history_nav="";}

        if(in_array($pay_report_permission_sno['perm_sno'], $array)){
            $pay_report_nav = "<li><a class='nav-link' href='".url_path('/staff/payment-report',true,true)."'>Payment Report</a></li>";
        }else{$pay_report_nav="";}

        if(in_array($gen_payroll_permission_sno['perm_sno'], $array)){
            $gen_payroll_nav = "";
            $gen_payroll_nav .= "<li><a class='nav-link' href='".url_path('/staff/create-staff-payroll',true,true)."'>For Staffs</a></li>";
            $gen_payroll_nav .= "<li><a class='nav-link' href='".url_path('/staff/create-guard-payroll',true,true)."'>For Guards</a></li>";
        }else{$gen_payroll_nav="";}

        if(in_array($payroll_his_permission_sno['perm_sno'], $array)){
            $payroll_his_nav = "";
            $payroll_his_nav .= "<li><a class='nav-link' href='".url_path('/staff/staff-payroll-history',true,true)."'>For Staffs</a></li>";
            $payroll_his_nav .= "<li><a class='nav-link' href='".url_path('/staff/guard-payroll-history',true,true)."'>For Guards</a></li>";
        }else{$payroll_his_nav="";}

        if(in_array($kit_inventory_permission_sno['perm_sno'], $array)){
            $kit_inventory_nav = "";
            $kit_inventory_nav .= "<li><a class='nav-link' href='".url_path('/staff/kit-inventory',true,true)."'>List</a></li>";
            $kit_inventory_nav .= "<li><a class='nav-link' href='".url_path('/staff/kit-history',true,true)."'>History</a></li>";
        }else{$kit_inventory_nav="";}

        if(in_array($loan_history_permission_sno['perm_sno'], $array)){
            $loan_history_nav = "<li><a class='nav-link' href='".url_path('/staff/staff-loan',true,true)."'>Loan Report</a></li>";
        }else{$loan_history_nav="";}
        
        if(in_array($rep_preview_generate_permission_sno['perm_sno'], $array)){
            $report_nav = "";
            $report_nav .= "<li><a class='nav-link' href='".url_path('/staff/beat-guard-payroll-history',true,true)."'>Beat Payroll History</a></li>";
            $report_nav .= "<li class='nav-parent'>
                    <a class='nav-link' href='javascript:void'><span>Guard Report</span></a>
                    <ul class='nav nav-children'>
                        <li><a href='". url_path('/staff/list-guard-sa-report',true,true)."'>I.O.U (Salary Advance)</a></li>
                        <li><a href='". url_path('/staff/generate-guard-loan-report',true,true)."'>Loan</a></li>
                        <li><a href='". url_path('/staff/generate-stopped-guard-report',true,true)."'>Stopped/Awol</a></li>
                        <li><a href='". url_path('/staff/generate-guard-penalties-report',true,true)."'>Bookings (Penalties)</a></li>
                        <li><a href='". url_path('/staff/generate-guard-training-abs-report',true,true)."'>Training Absentee</a></li>
                        <li><a href='". url_path('/staff/generate-guard-extra-duty-report',true,true)."'>Extra Duties</a></li>
                        <li><a href='". url_path('/staff/generate-uniform-deduction-report',true,true)."'>Uniform Deduction</a></li>
                    </ul>
                </li>
                <li class='nav-parent'>
                    <a class='nav-link' href='javascript:void'><span>Staff Report</span></a>
                    <ul class='nav nav-children'>
                        <li><a href='".url_path('/staff/generate-staff-penalties-report',true,true)."'>Bookings (Penalties)</a></li>
                    </ul>
                </li>
                <li><a class='nav-link' href='". url_path('/staff/generate-payment-confirm-report',true,true)."'>Payment Confirmation Report</a></li>
                <li><a class='nav-link' href='". url_path('/staff/generate-posted-guard-report',true,true)."'>Newly Posted Guard Report</a></li>
                <li class='nav-parent'>
                    <a class='nav-link' href='javascript:void'><span>Attendance Report</span></a>
                    <ul class='nav nav-children'>
                        <li><a href='". url_path('/staff/generate-guard-clock-in-out-report',true,true)."'>Clock In</a></li>
                        <li><a href='". url_path('/staff/generate-guards-absentee-report',true,true)."'>Absentee Guards</a></li>
                    </ul>
                </li>
            ";
        }else{$report_nav="";}
        
        ?>
            