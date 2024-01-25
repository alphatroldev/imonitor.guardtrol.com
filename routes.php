<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once("{$_SERVER['DOCUMENT_ROOT']}/router.php");


// ##################################################
// ##################################################
// ##################################################

// Static GET
// In the URL -> http://localhost
// The output -> Index
// decode($_SERVER['REQUEST_URI']);

// Dynamic GET. Example with 1 variable
// The $id will be available in user.php
// get('/', 'index.php');
// get( gd_encode('/company'), 'company/index.php');
// get('/login', 'login.php');

// get('/404', 'company/404.php');
//Main Routes
get(gd_encode('/about'), 'about-us.php', true);
get(gd_encode('/contact'), 'contact-us.php', true);
get(gd_encode('/register'), 'register.php', true);
get(gd_encode('/services'), 'services.php', true);

//COMPANY  ROUTES
get(gd_encode('/company/404'), 'company/404.php',true);
get(gd_encode('/company/main'), 'company/index.php', true);
get(gd_encode('/company/add-staff'), 'company/create-staff.php', true);
get(gd_encode('/company/list-staffs'), 'company/list-staffs.php', true);
get(gd_encode('/company/edit-staff/$staff_id'), 'company/edit-staff.php', true);
get(gd_encode('/company/incident'), 'company/report-incident.php', true);
get(gd_encode('/company/all-incident'), 'company/list-incident.php', true);
get(gd_encode('/company/incidents/$incident_id'), 'company/incident.php', true);
get(gd_encode('/company/staff-offenses'), 'company/staff-offense.php', true);
get(gd_encode('/company/guard-offenses'), 'company/guard-offense.php', true);
get(gd_encode('/company/kit-inventory'), 'company/kits-inventory.php', true);
get(gd_encode('/company/roles'), 'company/list-roles.php', true);
get(gd_encode('/company/add-role'), 'company/create-role.php', true);
get(gd_encode('/company/edit-role/$role_sno'), 'company/edit-role.php', true);
get(gd_encode('/company/configuration'), 'company/configurations.php', true);
get(gd_encode('/company/penalties'), 'company/list-penalties.php', true);
get(gd_encode('/company/add-penalty'), 'company/create-penalty.php', true);
get(gd_encode('/company/edit-penalty/$offense_id'), 'company/edit-penalty.php', true);
get(gd_encode('/company/shifts'), 'company/shift-management.php', true);
get(gd_encode('/company/add-shift'), 'company/create-shift.php', true);
get(gd_encode('/company/edit-shift/$shift_id'), 'company/edit-shift.php', true);
get(gd_encode('/company/settings'), 'company/profile-settings.php', true);
get(gd_encode('/company/logout'), 'company/logout.php', true);
get(gd_encode('/company/create-guard'), 'company/create-guard.php', true);
get(gd_encode('/company/create-client'), 'company/create-client.php', true);
get(gd_encode('/company/list-clients'), 'company/list-clients.php', true);
get(gd_encode('/company/inactive-clients'), 'company/inactive-clients.php', true);
get(gd_encode('/company/edit-client/$client_id'), 'company/edit-client.php', true);
get(gd_encode('/company/create-beat/$client_id'), 'company/create-beat.php', true);
get(gd_encode('/company/list-beats'), 'company/list-beats.php', true);
get(gd_encode('/company/inactive-beats'), 'company/inactive-beats.php', true);
get(gd_encode('/company/edit-beat/$beat_id'), 'company/edit-beat.php', true);
get(gd_encode('/company/create-guard'), 'company/create-guard.php', true);
get(gd_encode('/company/list-guards'), 'company/list-guards.php', true);
get(gd_encode('/company/inactive-guards'), 'company/inactive-guards.php', true);
get(gd_encode('/company/edit-guard/$guard_id'), 'company/edit-guard.php', true);
get(gd_encode('/company/deploy-guard'), 'company/deploy-guard.php', true);
get(gd_encode('/company/deploy-guard-in-profile/$guard_id'), 'company/deploy-guard-in-profile.php', true);
get(gd_encode('/company/guard-positions'), 'company/guard-positions.php', true);
get(gd_encode('/company/staff-loan'), 'company/staff-loan.php', true);
get(gd_encode('/company/staff-salary-advanced'), 'company/staff-salary-advanced.php', true);
get(gd_encode('/company/guard-loan'), 'company/guard-loan.php', true);
get(gd_encode('/company/guard-salary-advanced'), 'company/guard-salary-advanced.php', true);
get(gd_encode('/company/create-staff-payroll'), 'company/create-staff-payroll.php', true);
get(gd_encode('/company/create-guard-payroll'), 'company/create-guard-payroll.php', true);
get(gd_encode('/company/staff-payroll/$mon_year'), 'company/staff-payroll.php', true);
get(gd_encode('/company/guard-payroll/$mon_year'), 'company/guard-payroll.php', true);
get(gd_encode('/company/staff-payroll-history'), 'company/staff-payroll-history.php', true);
get(gd_encode('/company/guard-payroll-history'), 'company/guard-payroll-history.php', true);
get(gd_encode('/company/staff-privileges/$staff_id'), 'company/staff-privileges.php', true);
get(gd_encode('/company/print-staff-profile/$staff_id'), 'company/print-staff-profile.php', true);
get(gd_encode('/company/generate-invoice'), 'company/generate-invoice.php', true);
get(gd_encode('/company/invoice-history'), 'company/invoice-history.php', true);
get(gd_encode('/company/payment-report'), 'company/payment-report.php', true);
get(gd_encode('/company/list-norminal-rolls'), 'company/norminal-rolls.php', true);
get(gd_encode('/company/edit-norminal-roll/$guard_id'), 'company/edit-norminal-roll.php', true);

get(gd_encode('/company/client-invoice-history/$client_id'), 'company/client-invoice-history.php', true);
get(gd_encode('/company/payment-receipt-preview/$receipt_id'), 'company/payment-receipt-preview.php', true);
get(gd_encode('/company/print-invoice-report'), 'company/invoice-preview.php', true);
get(gd_encode('/company/invoice-preview/$client_id/$invoice_id'), 'company/invoice-preview.php', true);
get(gd_encode('/company/printed-invoice-report/$client_id/$invoice_id'), 'company/printed-invoice-report.php', true);
get(gd_encode('/company/invoice-history-details/$invoice_id'), 'company/invoice-history-details.php', true);
get(gd_encode('/company/payment-receipt/$receipt_id'), 'company/payment-receipt.php', true);

get(gd_encode('/company/payroll-settings'), 'company/payroll-settings.php', true);
get(gd_encode('/company/all-notifications'), 'company/all-notifications.php', true);
get(gd_encode('/company/print-guard-profile/$guard_id'), 'company/print-guard-profile.php', true);
get(gd_encode('/company/client-debtors-ledger/$client_id'), 'company/client-debtors-ledger.php', true);
get(gd_encode('/company/print-client-profile/$client_id'), 'company/print-client-profile.php', true);

get(gd_encode('/company/beat-activity-log/$beat_id'), 'company/beat-activity-log.php', true);
get(gd_encode('/company/staff-activity-log/$staff_id'), 'company/staff-activity-log.php', true);
get(gd_encode('/company/guard-activity-log/$guard_id'), 'company/guard-activity-log.php', true);
get(gd_encode('/company/norminal-inactive'), 'company/norminal-inactive.php', true);

get(gd_encode('/company/staff-pardon-history'), 'company/staff-pardon-history.php', true);
get(gd_encode('/company/guard-pardon-history'), 'company/guard-pardon-history.php', true);
get(gd_encode('/company/add-kit'), 'company/add-kit.php', true);
get(gd_encode('/company/kit-history'), 'company/kit-history.php', true);
get(gd_encode('/company/list-registered-kit'), 'company/list-registered-kit.php', true);

get(gd_encode('/company/invoice-account'), 'company/invoice-account.php', true);
get(gd_encode('/company/list-active-beat-guard/$beat_id'), 'company/list-active-beat-guard.php', true);

get(gd_encode('/company/guard-payroll-data-history'), 'company/guard-payroll-data-history.php', true);
get(gd_encode('/company/guard-route-task'), 'company/guard-route-task.php', true);

get(gd_encode('/company/beat-guard-payroll/$mon_year'), 'company/beat-guard-payroll.php', true);
get(gd_encode('/company/beat-guard-payroll-history'), 'company/beat-guard-payroll-history.php', true);
get(gd_encode('/company/list-guard-sa-report'), 'company/list-guard-sa-report.php', true);
get(gd_encode('/company/generate-salary-advance-report'), 'company/generate-salary-advance-report.php', true);
get(gd_encode('/company/guard-salary-advance-report-details/$mon_year'), 'company/guard-salary-advance-report-details.php', true);
get(gd_encode('/company/generate-guard-loan-report'), 'company/generate-guard-loan-report.php', true);
get(gd_encode('/company/generate-stopped-guard-report'), 'company/generate-stopped-guard-report.php', true);
get(gd_encode('/company/generate-guard-penalties-report'), 'company/generate-guard-penalties-report.php', true);
get(gd_encode('/company/generate-staff-penalties-report'), 'company/generate-staff-penalties-report.php', true);
get(gd_encode('/company/generate-guard-training-abs-report'), 'company/generate-guard-training-abs-report.php', true);
get(gd_encode('/company/generate-guard-extra-duty-report'), 'company/generate-guard-extra-duty-report.php', true);
get(gd_encode('/company/generate-payment-confirm-report'), 'company/generate-payment-confirm-report.php', true);
get(gd_encode('/company/generate-posted-guard-report'), 'company/generate-posted-guard-report.php', true);
get(gd_encode('/company/generate-uniform-deduction-report'), 'company/generate-uniform-deduction-report.php', true);
get(gd_encode('/company/generate-guard-clock-in-out-report'), 'company/generate-guard-clock-in-out-report.php', true);
get(gd_encode('/company/generate-guards-absentee-report'), 'company/generate-guards-absentee-report.php', true);

get(gd_encode('/company/manage-beat-supervisor'), 'company/manage-beat-supervisor.php', true);
get(gd_encode('/company/create-beat-supervisor'), 'company/create-beat-supervisor.php', true);
get(gd_encode('/company/edit-beat-supervisor/$bsu_id'), 'company/edit-beat-supervisor.php', true);

get(gd_encode('/company/manage-client-profile'), 'company/manage-client-profile.php', true);
get(gd_encode('/company/create-client-login'), 'company/create-client-login.php', true);
get(gd_encode('/company/edit-client-login-profile/$client_id'), 'company/edit-client-login-profile.php', true);

get(gd_encode('/company/guard-redeployment-details/$guard_id/$mon_year'), 'company/guard-redeployment-details.php', true);

get(gd_encode('/company/entry'), 'company/test-entry.php', true);
get(gd_encode('/company/list-xtra-duties/$guard_id'), 'company/list-xtra-duties.php', true);

post('/login-company','controllers/v8/login-cs-central.php');
post('/create-company-account-by-self','controllers/v8/create-company-account-by-self.php');


post('/company/create-penalty','controllers/v8/create-company-penalty.php');
post('/company/update-penalty','controllers/v8/update-company-penalty.php');
post('/company/company-actions','controllers/v8/company-actions.php');
post('/company/create-shift','controllers/v8/create-company-shift.php');
post('/company/update-shift','controllers/v8/update-company-shift.php');
post('/company/create-configuration','controllers/v8/company-configuration.php');
post('/company/update-configuration','controllers/v8/update-company-configuration.php');
post('/company/create-role','controllers/v8/create-company-role.php');
post('/company/update-role','controllers/v8/update-company-role.php');

post('/company/add-kit','controllers/v8/add-kits.php');
post('/company/register-kit','controllers/v8/register-new-kit.php');
post('/company/update-kit','controllers/v8/update-kit-inventory.php');
post('/company/create-incident','controllers/v8/create-report-incident.php');

post('/company/create-staff','controllers/v8/create-staff-account.php');
post('/company/update-staff-basic-info','controllers/v8/update-staff-basic-info-by-id.php');
post('/company/update-staff-guarantor-info','controllers/v8/update-staff-guarantor-info-by-id.php');
post('/company/update-staff-next-of-kin','controllers/v8/update-staff-next-of-kin-by-id.php');
post('/company/update-staff-acc-info','controllers/v8/update-staff-acc-info-by-id.php');
post('/company/update-staff-files','controllers/v8/update-staff-files.php');

post('/company/update-company-profile','controllers/v8/update-personal-company-profile.php');
post('/company/update-company-password','controllers/v8/update-personal-company-password.php');
post('/company/update-company-document','controllers/v8/update-personal-company-docs.php');
post('/company/create-staff-loan','controllers/v8/issue-staff-loan.php');

post('/company/create-client','controllers/v8/clients/register-client-actions.php');
post('/company/update-client-official-info','controllers/v8/clients/update-client-official-info.php');
post('/company/update-client-info','controllers/v8/clients/update-client-info.php');
post('/company/update-client-contact-info','controllers/v8/clients/update-client-contact-info.php');
post('/company/list-clients-actions','controllers/v8/clients/list-clients-actions.php');
post('/company/client-confirm-payment','controllers/v8/clients/client-confirm-payment.php');
post('/company/client-status-actions','controllers/v8/clients/client-status-actions.php');

post('/company/create-beat','controllers/v8/beats/create-beat-actions.php');
post('/company/list-beats-actions','controllers/v8/beats/list-beats-actions.php');
post('/company/update-beat','controllers/v8/beats/update-beats.php');

post('/company/register-guard-actions','controllers/v8/guards/register-guard-actions.php');
post('/company/list-guards-actions','controllers/v8/guards/list-guards-actions.php');
post('/company/update-guard-section-one','controllers/v8/guards/update-guard-section-one.php');
post('/company/update-guard-section-two','controllers/v8/guards/update-guard-section-two.php');
post('/company/update-guard-section-three','controllers/v8/guards/update-guard-section-three.php');

post('/company/guard-status-actions','controllers/v8/guards/guard-status-actions.php');
post('/company/guard-issue-salary-adv','controllers/v8/guards/guard-issue-salary-adv.php');
post('/company/issue-guard-loan','controllers/v8/guards/issue-guard-loan.php');
post('/company/book-guard-offense','controllers/v8/guards/book-guard-offense.php');
post('/company/guard-extra-duty','controllers/v8/guards/guard-extra-duty.php');
post('/company/guard-absent-training','controllers/v8/guards/guard-absent-training.php');
post('/company/guard-id-card-charge','controllers/v8/guards/guard-id-card-charge.php');
post('/company/guard-issue-kit','controllers/v8/guards/guard-issue-kit.php');
post('/company/create_guard_offense_pardon','controllers/v8/guards/create_guard_offense_pardon.php');

post('/company/deploy-guard-actions','controllers/v8/deploy-guards/deploy-guard-actions.php');
post('/company/update-guard-deployment','controllers/v8/deploy-guards/update-guard-deployment.php');
post('/company/norminal-roll-actions','controllers/v8/deploy-guards/norminal-roll-actions.php');
post('/company/guard-position-actions','controllers/v8/deploy-guards/guard-position-actions.php');
post('/company/create-guard-position','controllers/v8/deploy-guards/create-guard-position.php');
post('/company/update-guard-position','controllers/v8/deploy-guards/update-guard-position.php');

post('/company/surcharge-staff','controllers/v8/staff_profile/surcharge-staff.php');
post('/company/salary-advance','controllers/v8/staff_profile/salary-advance.php');
post('/company/update_stf_stat','controllers/v8/update-staff-status.php');
post('/company/update-staff-pp-by-id','controllers/v8/staff_profile/update-staff-pp-by-id.php');
post('/company/update-staff-pp_cam-by-id','controllers/v8/staff_profile/update-staff-pp_cam-by-id.php');

post('/company/generate-staff-payroll','controllers/v8/staff_profile/generate-staff-payroll.php');
post('/company/generate-guard-payroll','controllers/v8/guards/generate-guard-payroll.php');
post('/company/create_offense_pardon','controllers/v8/staff_profile/create_offense_pardon.php');
post('/company/generate-beat-invoice','controllers/v8/beats/generate-beat-invoice.php');
post('/company/create-invoice-debit-credit','controllers/v8/beats/create-invoice-debit-credit.php');

post('/company/update-beat-status','controllers/v8/beats/update-beat-status.php');

post('/company/beat-info','controllers/v8/ajax/beat-info.php');
post('/company/client-wallet-info','controllers/v8/ajax/client-wallet-info.php');
post('/company/penalty-info','controllers/v8/ajax/penalty-info.php');
post('/company/guard-beat-info','controllers/v8/ajax/guard-beat-info.php');
post('/company/add-payment-setting','controllers/v8/add-payment-setting.php');
post('/company/update-payment-setting','controllers/v8/update-payment-setting.php');

post('/company/staff-privilege-actions','controllers/v8/staff-privileges/staff-privilege-actions.php');
post('/company/notification-actions','controllers/v8/ajax/notification-actions.php');

post('/company/update-guard-pp-by-id','controllers/v8/guards/update-guard-pp-by-id.php');
post('/company/update-guard-pp_cam-by-id','controllers/v8/guards/update-guard-pp_cam-by-id.php');
post('/company/update-client-pp-by-id','controllers/v8/clients/update-client-pp-by-id.php');

post('/company/create-invoice-account','controllers/v8/create-company-invoice-account.php');
post('/company/create-company-invoice-action','controllers/v8/create-company-invoice-action.php');
post('/company/update-guard-files-by-id','controllers/v8/guards/update-guard-files-by-id.php');
post('/company/list-guard-actions','controllers/v8/guards/list-guards-actions.php');

post('/company/create-guard-payroll-data','controllers/v8/guards/create-guard-payroll-data.php');

post('/company/guard-route-task-info','controllers/v8/ajax/guard-route-task-info.php');
post('/company/guard-route-points-info','controllers/v8/ajax/guard-route-points-info.php');
post('/company/assign-route-to-guard','controllers/v8/guards/assign-route-to-guard.php');

post('/company/create-beat-supervisor','controllers/v8/beats/create-beat-supervisor.php');
post('/company/update-beat-supervisor','controllers/v8/beats/update-beat-supervisor.php');
post('/company/update-beat-supervisor-pwd','controllers/v8/beats/update-beat-supervisor-pwd.php');

post('/company/create-client-login','controllers/v8/clients/create-client-login.php');
post('/company/update-client-login-pwd','controllers/v8/clients/update-client-login-pwd.php');

post('/company/enter-test-entry','controllers/v8/enter-test-entry.php');

post('/company/generate-salary-advance-report','controllers/v8/guards/generate-salary-advance-report.php');
post('/company/Z2VuZXJhdGUtZ3VhcmQtbG9hbi1yZXBvcnQ=','company/generate-guard-loan-report-filter.php');
post('/company/Z2VuZXJhdGUtc3RvcHBlZC1ndWFyZC1yZXBvcnQ=','company/generate-stopped-guard-report-filter.php');
post('/company/Z2VuZXJhdGUtZ3VhcmQtcGVuYWx0aWVzLXJlcG9ydA==','company/generate-guard-penalties-report-filter.php');
post('/company/Z2VuZXJhdGUtc3RhZmYtcGVuYWx0aWVzLXJlcG9ydA==','company/generate-staff-penalties-report-filter.php');
post('/company/Z2VuZXJhdGUtZ3VhcmQtdHJhaW5pbmctYWJzLXJlcG9ydA==','company/generate-guard-training-abs-report-filter.php');
post('/company/Z2VuZXJhdGUtZ3VhcmQtZXh0cmEtZHV0eS1yZXBvcnQ=','company/generate-guard-extra-duty-report-filter.php');
post('/company/Z2VuZXJhdGUtcGF5bWVudC1jb25maXJtLXJlcG9ydA==','company/generate-payment-confirm-report-filter.php');
post('/company/Z2VuZXJhdGUtcG9zdGVkLWd1YXJkLXJlcG9ydA==','company/generate-posted-guard-report-filter.php');
post('/company/Z2VuZXJhdGUtdW5pZm9ybS1kZWR1Y3Rpb24tcmVwb3J0','company/generate-uniform-deduction-report-filter.php');
post('/company/Z2VuZXJhdGUtZ3VhcmQtY2xvY2staW4tb3V0LXJlcG9ydC1maWx0ZXI=','company/generate-guard-clock-in-out-report-filter.php');
post('/company/Z2VuZXJhdGUtZ3VhcmRzLWFic2VudGVlLXJlcG9ydC1maWx0ZXI=','company/generate-guards-absentee-report-filter.php');

// STAFF ROUTES
get(gd_encode('/staff/main'), 'staff/index.php', true);
get(gd_encode('/staff/404'), 'staff/404.php');
get(gd_encode('/staff/add-staff'), 'staff/create-staff.php', true);
get(gd_encode('/staff/list-staffs'), 'staff/list-staffs.php', true);
get(gd_encode('/staff/edit-staff/$staff_id'), 'staff/edit-staff.php', true);
get(gd_encode('/staff/incident'), 'staff/report-incident.php', true);
get(gd_encode('/staff/all-incident'), 'staff/list-incident.php', true);
get(gd_encode('/staff/incidents/$incident_id'), 'staff/incident.php', true);
get(gd_encode('/staff/staff-offenses'), 'staff/staff-offense.php', true);
get(gd_encode('/staff/guard-offenses'), 'staff/guard-offense.php', true);
get(gd_encode('/staff/kit-inventory'), 'staff/kits-inventory.php', true);
get(gd_encode('/staff/roles'), 'staff/list-roles.php', true);
get(gd_encode('/staff/add-role'), 'staff/create-role.php', true);
get(gd_encode('/staff/edit-role/$role_sno'), 'staff/edit-role.php', true);
get(gd_encode('/staff/configuration'), 'staff/configurations.php', true);
get(gd_encode('/staff/penalties'), 'staff/list-penalties.php', true);
get(gd_encode('/staff/add-penalty'), 'staff/create-penalty.php', true);
get(gd_encode('/staff/edit-penalty/$offense_id'), 'staff/edit-penalty.php', true);
get(gd_encode('/staff/shifts'), 'staff/shift-management.php', true);
get(gd_encode('/staff/add-shift'), 'staff/create-shift.php', true);
get(gd_encode('/staff/edit-shift/$shift_id'), 'staff/edit-shift.php', true);
get(gd_encode('/staff/profile-settings'), 'staff/profile-settings.php', true);
get(gd_encode('/staff/logout'), 'staff/logout.php', true);
get(gd_encode('/staff/create-guard'), 'staff/create-guard.php', true);
get(gd_encode('/staff/create-client'), 'staff/create-client.php', true);
get(gd_encode('/staff/list-clients'), 'staff/list-clients.php', true);
get(gd_encode('/staff/inactive-clients'), 'staff/inactive-clients.php', true);
get(gd_encode('/staff/edit-client/$client_id'), 'staff/edit-client.php', true);
get(gd_encode('/staff/create-beat/$client_id'), 'staff/create-beat.php', true);
get(gd_encode('/staff/list-beats'), 'staff/list-beats.php', true);
get(gd_encode('/staff/inactive-beats'), 'staff/inactive-beats.php', true);
get(gd_encode('/staff/edit-beat/$beat_id'), 'staff/edit-beat.php', true);
get(gd_encode('/staff/create-guard'), 'staff/create-guard.php', true);
get(gd_encode('/staff/list-guards'), 'staff/list-guards.php', true);
get(gd_encode('/staff/inactive-guards'), 'staff/inactive-guards.php', true);
get(gd_encode('/staff/edit-guard/$guard_id'), 'staff/edit-guard.php', true);
get(gd_encode('/staff/deploy-guard'), 'staff/deploy-guard.php', true);
get(gd_encode('/staff/deploy-guard-in-profile/$guard_id'), 'staff/deploy-guard-in-profile.php', true);
get(gd_encode('/staff/guard-positions'), 'staff/guard-positions.php', true);
get(gd_encode('/staff/staff-loan'), 'staff/staff-loan.php', true);
get(gd_encode('/staff/staff-salary-advanced'), 'staff/staff-salary-advanced.php', true);
get(gd_encode('/staff/guard-loan'), 'staff/guard-loan.php', true);
get(gd_encode('/staff/guard-salary-advanced'), 'staff/guard-salary-advanced.php', true);
get(gd_encode('/staff/create-staff-payroll'), 'staff/create-staff-payroll.php', true);
get(gd_encode('/staff/create-guard-payroll'), 'staff/create-guard-payroll.php', true);
get(gd_encode('/staff/staff-payroll/$mon_year'), 'staff/staff-payroll.php', true);
get(gd_encode('/staff/guard-payroll/$mon_year'), 'staff/guard-payroll.php', true);
get(gd_encode('/staff/staff-payroll-history'), 'staff/staff-payroll-history.php', true);
get(gd_encode('/staff/guard-payroll-history'), 'staff/guard-payroll-history.php', true);
get(gd_encode('/staff/staff-privileges/$staff_id'), 'staff/staff-privileges.php', true);
get(gd_encode('/staff/print-staff-profile/$staff_id'), 'staff/print-staff-profile.php', true);
get(gd_encode('/staff/generate-invoice'), 'staff/generate-invoice.php', true);
get(gd_encode('/staff/invoice-history'), 'staff/invoice-history.php', true);
get(gd_encode('/staff/payment-report'), 'staff/payment-report.php', true);
get(gd_encode('/staff/list-norminal-rolls'), 'staff/norminal-rolls.php', true);
get(gd_encode('/staff/edit-norminal-roll/$guard_id'), 'staff/edit-norminal-roll.php', true);

get(gd_encode('/staff/client-invoice-history/$client_id'), 'staff/client-invoice-history.php', true);
get(gd_encode('/staff/payment-receipt-preview/$receipt_id'), 'staff/payment-receipt-preview.php', true);
get(gd_encode('/staff/print-invoice-report'), 'staff/invoice-preview.php', true);
get(gd_encode('/staff/invoice-preview/$client_id/$invoice_id'), 'staff/invoice-preview.php', true);
get(gd_encode('/staff/printed-invoice-report/$client_id/$invoice_id'), 'staff/printed-invoice-report.php', true);
get(gd_encode('/staff/invoice-history-details/$invoice_id'), 'staff/invoice-history-details.php', true);
get(gd_encode('/staff/payment-receipt/$receipt_id'), 'staff/payment-receipt.php', true);

get(gd_encode('/staff/payroll-settings'), 'staff/payroll-settings.php', true);
get(gd_encode('/staff/print-guard-profile/$guard_id'), 'staff/print-guard-profile.php', true);
get(gd_encode('/staff/print-client-profile/$client_id'), 'staff/print-client-profile.php', true);
get(gd_encode('/staff/client-debtors-ledger/$client_id'), 'staff/client-debtors-ledger.php', true);

get(gd_encode('/staff/beat-activity-log/$beat_id'), 'staff/beat-activity-log.php', true);
get(gd_encode('/staff/staff-activity-log/$staff_id'), 'staff/staff-activity-log.php', true);
get(gd_encode('/staff/guard-activity-log/$guard_id'), 'staff/guard-activity-log.php', true);
get(gd_encode('/staff/norminal-inactive'), 'staff/norminal-inactive.php', true);
get(gd_encode('/staff/guard-pardon-history'), 'staff/guard-pardon-history.php', true);
get(gd_encode('/staff/staff-pardon-history'), 'staff/staff-pardon-history.php', true);

get(gd_encode('/staff/add-kit'), 'staff/add-kit.php', true);
get(gd_encode('/staff/kit-history'), 'staff/kit-history.php', true);
get(gd_encode('/staff/list-registered-kit'), 'staff/list-registered-kit.php', true);
get(gd_encode('/staff/list-active-beat-guard/$beat_id'), 'staff/list-active-beat-guard.php', true);

get(gd_encode('/staff/guard-payroll-data-history'), 'staff/guard-payroll-data-history.php', true);
get(gd_encode('/staff/guard-route-task'), 'staff/guard-route-task.php', true);

get(gd_encode('/staff/beat-guard-payroll/$mon_year'), 'staff/beat-guard-payroll.php', true);
get(gd_encode('/staff/beat-guard-payroll-history'), 'staff/beat-guard-payroll-history.php', true);
get(gd_encode('/staff/list-guard-sa-report'), 'staff/list-guard-sa-report.php', true);
get(gd_encode('/staff/generate-salary-advance-report'), 'staff/generate-salary-advance-report.php', true);
get(gd_encode('/staff/guard-salary-advance-report-details/$mon_year'), 'staff/guard-salary-advance-report-details.php', true);
get(gd_encode('/staff/generate-guard-loan-report'), 'staff/generate-guard-loan-report.php', true);
get(gd_encode('/staff/generate-stopped-guard-report'), 'staff/generate-stopped-guard-report.php', true);
get(gd_encode('/staff/generate-guard-penalties-report'), 'staff/generate-guard-penalties-report.php', true);
get(gd_encode('/staff/generate-staff-penalties-report'), 'staff/generate-staff-penalties-report.php', true);
get(gd_encode('/staff/generate-guard-training-abs-report'), 'staff/generate-guard-training-abs-report.php', true);
get(gd_encode('/staff/generate-guard-extra-duty-report'), 'staff/generate-guard-extra-duty-report.php', true);
get(gd_encode('/staff/generate-payment-confirm-report'), 'staff/generate-payment-confirm-report.php', true);
get(gd_encode('/staff/generate-posted-guard-report'), 'staff/generate-posted-guard-report.php', true);
get(gd_encode('/staff/generate-uniform-deduction-report'), 'staff/generate-uniform-deduction-report.php', true);

get(gd_encode('/staff/generate-guard-clock-in-out-report'), 'staff/generate-guard-clock-in-out-report.php', true);
get(gd_encode('/staff/generate-guards-absentee-report'), 'staff/generate-guards-absentee-report.php', true);

get(gd_encode('/staff/guard-redeployment-details/$guard_id/$mon_year'), 'staff/guard-redeployment-details.php', true);



post('/staff/create-penalty','controllers/v8/create-company-penalty.php');
post('/staff/update-penalty','controllers/v8/update-company-penalty.php');
post('/staff/company-actions','controllers/v8/company-actions.php');
post('/staff/create-shift','controllers/v8/create-company-shift.php');
post('/staff/update-shift','controllers/v8/update-company-shift.php');
post('/staff/create-configuration','controllers/v8/company-configuration.php');
post('/staff/update-configuration','controllers/v8/update-company-configuration.php');
post('/staff/create-role','controllers/v8/create-company-role.php');
post('/staff/update-role','controllers/v8/update-company-role.php');

post('/staff/add-kit','controllers/v8/add-kits.php');
post('/staff/register-kit','controllers/v8/register-new-kit.php');
post('/staff/update-kit','controllers/v8/update-kit-inventory.php');
post('/staff/create-incident','controllers/v8/create-report-incident.php');

post('/staff/create-staff','controllers/v8/create-staff-account.php');
post('/staff/update-staff-personal-password','controllers/v8/update-staff-personal-password.php');
post('/staff/update-staff-personal-profile','controllers/v8/update-staff-personal-profile.php');
post('/staff/update-staff-basic-info','controllers/v8/update-staff-basic-info-by-id.php');
post('/staff/update-staff-guarantor-info','controllers/v8/update-staff-guarantor-info-by-id.php');
post('/staff/update-staff-next-of-kin','controllers/v8/update-staff-next-of-kin-by-id.php');
post('/staff/update-staff-acc-info','controllers/v8/update-staff-acc-info-by-id.php');
post('/staff/update-staff-files','controllers/v8/update-staff-files.php');

post('/staff/update-company-profile','controllers/v8/update-personal-company-profile.php');
post('/staff/update-company-password','controllers/v8/update-personal-company-password.php');
post('/staff/update-company-document','controllers/v8/update-personal-company-docs.php');
post('/staff/create-staff-loan','controllers/v8/issue-staff-loan.php');

post('/staff/create-client','controllers/v8/clients/register-client-actions.php');
post('/staff/update-client-official-info','controllers/v8/clients/update-client-official-info.php');
post('/staff/update-client-info','controllers/v8/clients/update-client-info.php');
post('/staff/update-client-contact-info','controllers/v8/clients/update-client-contact-info.php');
post('/staff/list-clients-actions','controllers/v8/clients/list-clients-actions.php');
post('/staff/client-confirm-payment','controllers/v8/clients/client-confirm-payment.php');
post('/staff/client-status-actions','controllers/v8/clients/client-status-actions.php');

post('/staff/create-beat','controllers/v8/beats/create-beat-actions.php');
post('/staff/list-beats-actions','controllers/v8/beats/list-beats-actions.php');
post('/staff/update-beat','controllers/v8/beats/update-beats.php');

post('/staff/register-guard-actions','controllers/v8/guards/register-guard-actions.php');
post('/staff/list-guards-actions','controllers/v8/guards/list-guards-actions.php');
post('/staff/update-guard-section-one','controllers/v8/guards/update-guard-section-one.php');
post('/staff/update-guard-section-two','controllers/v8/guards/update-guard-section-two.php');
post('/staff/update-guard-section-three','controllers/v8/guards/update-guard-section-three.php');

post('/staff/guard-status-actions','controllers/v8/guards/guard-status-actions.php');
post('/staff/guard-issue-salary-adv','controllers/v8/guards/guard-issue-salary-adv.php');
post('/staff/issue-guard-loan','controllers/v8/guards/issue-guard-loan.php');
post('/staff/book-guard-offense','controllers/v8/guards/book-guard-offense.php');
post('/staff/guard-extra-duty','controllers/v8/guards/guard-extra-duty.php');
post('/staff/guard-absent-training','controllers/v8/guards/guard-absent-training.php');
post('/staff/guard-id-card-charge','controllers/v8/guards/guard-id-card-charge.php');
post('/staff/guard-issue-kit','controllers/v8/guards/guard-issue-kit.php');
post('/staff/create_guard_offense_pardon','controllers/v8/guards/create_guard_offense_pardon.php');

post('/staff/deploy-guard-actions','controllers/v8/deploy-guards/deploy-guard-actions.php');
post('/staff/update-guard-deployment','controllers/v8/deploy-guards/update-guard-deployment.php');
post('/staff/norminal-roll-actions','controllers/v8/deploy-guards/norminal-roll-actions.php');
post('/staff/guard-position-actions','controllers/v8/deploy-guards/guard-position-actions.php');
post('/staff/create-guard-position','controllers/v8/deploy-guards/create-guard-position.php');
post('/staff/update-guard-position','controllers/v8/deploy-guards/update-guard-position.php');


post('/staff/surcharge-staff','controllers/v8/staff_profile/surcharge-staff.php');
post('/staff/salary-advance','controllers/v8/staff_profile/salary-advance.php');
post('/staff/update_stf_stat','controllers/v8/update-staff-status.php');
post('/staff/update-staff-pp-by-id','controllers/v8/staff_profile/update-staff-pp-by-id.php');
post('/staff/update-staff-pp_cam-by-id','controllers/v8/staff_profile/update-staff-pp_cam-by-id.php');

post('/staff/generate-staff-payroll','controllers/v8/staff_profile/generate-staff-payroll.php');
post('/staff/generate-guard-payroll','controllers/v8/guards/generate-guard-payroll.php');
post('/staff/create_offense_pardon','controllers/v8/staff_profile/create_offense_pardon.php');
post('/staff/generate-beat-invoice','controllers/v8/beats/generate-beat-invoice.php');
post('/staff/create-invoice-debit-credit','controllers/v8/beats/create-invoice-debit-credit.php');

post('/staff/update-beat-status','controllers/v8/beats/update-beat-status.php');

post('/staff/beat-info','controllers/v8/ajax/beat-info.php');
post('/staff/client-wallet-info','controllers/v8/ajax/client-wallet-info.php');
post('/staff/penalty-info','controllers/v8/ajax/penalty-info.php');
post('/staff/guard-beat-info','controllers/v8/ajax/guard-beat-info.php');
post('/staff/add-payment-setting','controllers/v8/add-payment-setting.php');
post('/staff/update-payment-setting','controllers/v8/update-payment-setting.php');

post('/staff/staff-privilege-actions','controllers/v8/staff-privileges/staff-privilege-actions.php');

post('/staff/update-guard-pp-by-id','controllers/v8/guards/update-guard-pp-by-id.php');
post('/staff/update-guard-pp_cam-by-id','controllers/v8/guards/update-guard-pp_cam-by-id.php');
post('/staff/update-client-pp-by-id','controllers/v8/clients/update-client-pp-by-id.php');

post('/staff/update-guard-files-by-id','controllers/v8/guards/update-guard-files-by-id.php');
post('/staff/list-guard-actions','controllers/v8/guards/list-guards-actions.php');

post('/staff/create-guard-payroll-data','controllers/v8/guards/create-guard-payroll-data.php');

post('/staff/guard-route-task-info','controllers/v8/ajax/guard-route-task-info.php');
post('/staff/guard-route-points-info','controllers/v8/ajax/guard-route-points-info.php');
post('/staff/assign-route-to-guard','controllers/v8/guards/assign-route-to-guard.php');

post('/staff/generate-salary-advance-report','controllers/v8/guards/generate-salary-advance-report.php');
post('/staff/Z2VuZXJhdGUtZ3VhcmQtbG9hbi1yZXBvcnQ=','staff/generate-guard-loan-report-filter.php');
post('/staff/Z2VuZXJhdGUtc3RvcHBlZC1ndWFyZC1yZXBvcnQ=','staff/generate-stopped-guard-report-filter.php');
post('/staff/Z2VuZXJhdGUtZ3VhcmQtcGVuYWx0aWVzLXJlcG9ydA==','staff/generate-guard-penalties-report-filter.php');
post('/staff/Z2VuZXJhdGUtc3RhZmYtcGVuYWx0aWVzLXJlcG9ydA==','staff/generate-staff-penalties-report-filter.php');
post('/staff/Z2VuZXJhdGUtZ3VhcmQtdHJhaW5pbmctYWJzLXJlcG9ydA==','staff/generate-guard-training-abs-report-filter.php');
post('/staff/Z2VuZXJhdGUtZ3VhcmQtZXh0cmEtZHV0eS1yZXBvcnQ=','staff/generate-guard-extra-duty-report-filter.php');
post('/staff/Z2VuZXJhdGUtcGF5bWVudC1jb25maXJtLXJlcG9ydA==','staff/generate-payment-confirm-report-filter.php');
post('/staff/Z2VuZXJhdGUtcG9zdGVkLWd1YXJkLXJlcG9ydA==','staff/generate-posted-guard-report-filter.php');
post('/staff/Z2VuZXJhdGUtdW5pZm9ybS1kZWR1Y3Rpb24tcmVwb3J0','staff/generate-uniform-deduction-report-filter.php');

post('/staff/Z2VuZXJhdGUtZ3VhcmQtY2xvY2staW4tb3V0LXJlcG9ydC1maWx0ZXI=','staff/generate-guard-clock-in-out-report-filter.php');
post('/staff/Z2VuZXJhdGUtZ3VhcmRzLWFic2VudGVlLXJlcG9ydC1maWx0ZXI=','staff/generate-guards-absentee-report-filter.php');

//SUPERVISOR ROUTES
get('/supervisor', 'supervisor/index.php');
get(gd_encode('/supervisor/404'), 'supervisor/404.php', true);
get(gd_encode('/supervisor/main'), 'supervisor/dashboard.php', true);
get(gd_encode('/supervisor/settings'), 'supervisor/settings.php', true);
get(gd_encode('/supervisor/logout'), 'supervisor/logout.php', true);
get(gd_encode('/supervisor/routing-clock'), 'supervisor/routing-clock.php', true);
get(gd_encode('/supervisor/clock-in-out'), 'supervisor/clock-in-out.php', true);
get(gd_encode('/supervisor/attendance-logs'), 'supervisor/attendance-logs.php', true);
get(gd_encode('/supervisor/guard-clock-out-request'), 'supervisor/guard-clockout-request.php', true);

post('/supervisor/login-supervisor','controllers/v8/login-supervisor.php');
post('/supervisor/update-beat-supervisor-profile','controllers/v8/beats/update-beat-supervisor-profile.php');
post('/supervisor/update-beat-supervisor-pro-pwd','controllers/v8/beats/update-beat-supervisor-pro-pwd.php');
post('/supervisor/update-guard-clockout-request-status','controllers/v8/beats/update-guard-clockout-request-status.php');
post('/supervisor/Y2xvY2staW4tb3V0LWZpbHRlcg==','supervisor/clock-in-out-filter.php');
post('/supervisor/cm91dGluZy1jbG9jay1maWx0ZXI=','supervisor/routing-clock-filter.php');

//CLIENT ROUTES
get('/client', 'client/index.php');
get(gd_encode('/client/404'), 'client/404.php', true);
get(gd_encode('/client/main'), 'client/dashboard.php', true);
get(gd_encode('/client/settings'), 'client/settings.php', true);
get(gd_encode('/client/logout'), 'client/logout.php', true);
get(gd_encode('/client/routing-clock'), 'client/routing-clock.php', true);
get(gd_encode('/client/clock-in-out'), 'client/clock-in-out.php', true);

post('/client/login-client-account','controllers/v8/clients/login-client.php');
post('/client/update-client-pro-pwd','controllers/v8/clients/update-client-pro-pwd.php');
post('/client/Y2xvY2staW4tb3V0LWZpbHRlcg==','client/clock-in-out-filter.php');
post('/client/cm91dGluZy1jbG9jay1maWx0ZXI=','client/routing-clock-filter.php');

//SUPPORT ROUTES
get('/support', 'support/index.php');
get(gd_encode('/support/main'), 'support/dashboard.php', true);
get(gd_encode('/support/settings'), 'support/settings.php', true);
get(gd_encode('/support/create-company'), 'support/create-company.php', true);
get(gd_encode('/support/list-company'), 'support/list-companies.php', true);
get(gd_encode('/support/edit-company/$c_id'), 'support/edit-company.php', true);
get(gd_encode('/support/create'), 'support/create-support.php', true);
get(gd_encode('/support/list'), 'support/list-supports.php', true);
get(gd_encode('/support/edit/$s_id'), 'support/edit-support.php', true);
get(gd_encode('/support/logout'), 'support/logout.php', true);
get(gd_encode('/support/add-new-v'), 'support/add-new-v.php', true);
get(gd_encode('/support/list-app-v'), 'support/list-app-v.php', true);

get(gd_encode('/support/download-apk/$v_file_name'), 'support/download-new-version.php', true);


post('/support/login-support','controllers/v8/login-support-account.php');
post('/support/create-support','controllers/v8/create-support-account.php');
post('/support/update-support','controllers/v8/update-sup-profile-by-id.php');
post('/support/update-support-password','controllers/v8/update-sup-password-by-id.php');
post('/support/update-support-status','controllers/v8/support-actions.php');
post('/support/login-sup-company-account','controllers/v8/login-sup-company-account.php');
post('/support/update-support-profile','controllers/v8/update-support-profile.php');
post('/support/update-support-profile-password','controllers/v8/update-support-password.php');
post('/support/create-company','controllers/v8/create-company-account.php');
post('/support/update-com-pro-by-id','controllers/v8/update-company-profile-by-id.php');
post('/support/update-com-pwd-by-id','controllers/v8/update-company-password-by-id.php');
post('/support/upload-new-apk-version','controllers/v8/upload-new-apk-version.php');

//post('/support/create-support','controllers/v8/create-support-account.php');

// Dynamic GET. Example with 2 variables
// The $name will be available in user.php
// The $last_name will be available in user.php
// get('/user/$name/$last_name', 'user.php');

// Dynamic GET. Example with 2 variables with static
// In the URL -> http://localhost/product/shoes/color/blue
// The $type will be available in product.php
// The $color will be available in product.php
// get('/product/$type/color/:color', 'product.php');

// Dynamic GET. Example with 1 variable and 1 query string
// In the URL -> http://localhost/item/car?price=10
// The $name will be available in items.php which is inside the views folder
// get('/item/$name', 'views/items.php');


// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
// any('404','404.php');
