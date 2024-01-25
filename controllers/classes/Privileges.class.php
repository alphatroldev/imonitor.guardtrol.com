<?php ob_start(); session_status()?null:session_start();
// namespace App;
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/database.php');
date_default_timezone_set('Africa/Lagos'); // WAT
class Privileges
{
    public $conn;
    private $all_privileges;

    //constructor
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function get_hr_admin_guard_details(){
        $permission_query = "SELECT * FROM tbl_permissions WHERE perm_category='HR/ADMIN' AND perm_sub_cat='guard_detail'";
        $permission_obj = $this->conn->prepare($permission_query);

        if ($permission_obj->execute()) {
            return $permission_obj->get_result();
        }
        return array();
    }

    public function get_hr_admin_staff_details(){
        $permission_query = "SELECT * FROM tbl_permissions WHERE perm_category='HR/ADMIN' AND perm_sub_cat='staff_detail'";
        $permission_obj = $this->conn->prepare($permission_query);

        if ($permission_obj->execute()) {
            return $permission_obj->get_result();
        }
        return array();
    }

    public function get_hr_admin_client_beat_details(){
        $permission_query = "SELECT * FROM tbl_permissions WHERE perm_category='HR/ADMIN' AND perm_sub_cat='client_beat_detail'";
        $permission_obj = $this->conn->prepare($permission_query);

        if ($permission_obj->execute()) {
            return $permission_obj->get_result();
        }
        return array();
    }

    public function get_operations_guard_details(){
        $permission_query = "SELECT * FROM tbl_permissions WHERE perm_category='OPERATIONS' AND perm_sub_cat='guard_detail'";
        $permission_obj = $this->conn->prepare($permission_query);

        if ($permission_obj->execute()) {
            return $permission_obj->get_result();
        }
        return array();
    }

    public function get_operations_inventory_details(){
        $permission_query = "SELECT * FROM tbl_permissions WHERE perm_category='OPERATIONS' AND perm_sub_cat='inventory_detail'";
        $permission_obj = $this->conn->prepare($permission_query);

        if ($permission_obj->execute()) {
            return $permission_obj->get_result();
        }
        return array();
    }

    public function get_operations_incident_details(){
        $permission_query = "SELECT * FROM tbl_permissions WHERE perm_category='OPERATIONS' AND perm_sub_cat='incident_detail'";
        $permission_obj = $this->conn->prepare($permission_query);

        if ($permission_obj->execute()) {
            return $permission_obj->get_result();
        }
        return array();
    }

    public function get_accounts_invoice_details(){
        $permission_query = "SELECT * FROM tbl_permissions WHERE perm_category='ACCOUNTS' AND perm_sub_cat='invoice_detail'";
        $permission_obj = $this->conn->prepare($permission_query);

        if ($permission_obj->execute()) {
            return $permission_obj->get_result();
        }
        return array();
    }

    public function get_accounts_payment_details(){
        $permission_query = "SELECT * FROM tbl_permissions WHERE perm_category='ACCOUNTS' AND perm_sub_cat='payment_detail'";
        $permission_obj = $this->conn->prepare($permission_query);

        if ($permission_obj->execute()) {
            return $permission_obj->get_result();
        }
        return array();
    }

    public function get_accounts_payment_history(){
        $permission_query = "SELECT * FROM tbl_permissions WHERE perm_category='ACCOUNTS' AND perm_sub_cat='payment_history'";
        $permission_obj = $this->conn->prepare($permission_query);

        if ($permission_obj->execute()) {
            return $permission_obj->get_result();
        }
        return array();
    }

    public function assign_privilege($privilege, $staff_id, $company_role_sno){
        $assign_privilege_query = "INSERT INTO tbl_company_roles_perm SET perm_sno=?, staff_id=?,comp_role_sno=?";
        $assign_privilege_obj = $this->conn->prepare($assign_privilege_query);
        $assign_privilege_obj->bind_param("sss", $privilege, $staff_id, $company_role_sno);
        if ($assign_privilege_obj->execute()) {
            return true;
        }
        return false;
    }

    public function update_privilege($privilege, $staff_id){
        $assign_privilege_query = "UPDATE tbl_company_roles_perm SET perm_sno=? WHERE staff_id=?";
        $assign_privilege_obj = $this->conn->prepare($assign_privilege_query);
        $assign_privilege_obj->bind_param("ss",$privilege, $staff_id);
        if ($assign_privilege_obj->execute()) {
            if ($assign_privilege_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function check_staff_duplicate($staff_id){
        $query = "SELECT * FROM tbl_company_roles_perm WHERE staff_id=?";
        $obj = $this->conn->prepare($query);
        $obj->bind_param("s", $staff_id);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_staff_permission_sno($staff_id){
        $permission_query = "SELECT * FROM tbl_company_roles_perm WHERE staff_id='$staff_id'";
        $permission_obj = $this->conn->prepare($permission_query);

        if ($permission_obj->execute()) {
            return $permission_obj->get_result();
        }
        return array();
    }

    public function staff_perm_ids($staff_id){
        $query = "SELECT * FROM tbl_company_roles_perm WHERE staff_id='$staff_id'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();

        }
        return array();
    }

    public function get_deploy_guard_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Deploy Guard' AND perm_category='HR/ADMIN' AND perm_sub_cat='guard_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_register_guard_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Create Guard' AND perm_category='HR/ADMIN' AND perm_sub_cat='guard_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_redeploy_guard_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Redeploy Guard' AND perm_category='HR/ADMIN' AND perm_sub_cat='guard_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_update_guard_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Update Guards Information' AND perm_category='HR/ADMIN' AND perm_sub_cat='guard_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_create_client_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Create Clients' AND perm_category='HR/ADMIN' AND perm_sub_cat='client_beat_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_update_client_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Update Clients Information' AND perm_category='HR/ADMIN' AND perm_sub_cat='client_beat_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_create_beat_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Create Beats' AND perm_category='HR/ADMIN' AND perm_sub_cat='client_beat_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_update_beat_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Update Beats Information' AND perm_category='HR/ADMIN' AND perm_sub_cat='client_beat_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_norminal_roll_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Norminal Row' AND perm_category='HR/ADMIN' AND perm_sub_cat='guard_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_create_incident_rep_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Incident Report' AND perm_category='OPERATIONS' AND perm_sub_cat='incident_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_incident_rep_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'View Incident Report' AND perm_category='OPERATIONS' AND perm_sub_cat='incident_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_staff_off_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Staff Offense' AND perm_category='HR/ADMIN' AND perm_sub_cat='staff_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_book_staff_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Book a Staff' AND perm_category='HR/ADMIN' AND perm_sub_cat='staff_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_staff_pardon_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Pardon Staff' AND perm_category='HR/ADMIN' AND perm_sub_cat='staff_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_guard_off_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Guard Offense' AND perm_category='OPERATIONS' AND perm_sub_cat='guard_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_book_guard_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Book a Guard' AND perm_category='OPERATIONS' AND perm_sub_cat='guard_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_guard_pardon_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Pardon Guard' AND perm_category='OPERATIONS' AND perm_sub_cat='guard_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_generate_inv_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Generate Invoice' AND perm_category='ACCOUNTS' AND perm_sub_cat='invoice_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_confirm_inv_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Confirm Invoice' AND perm_category='ACCOUNTS' AND perm_sub_cat='invoice_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_generate_payroll_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Generate Payroll' AND perm_category='ACCOUNTS' AND perm_sub_cat='payment_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_payroll_history_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Payroll Actions/History' AND perm_category='ACCOUNTS' AND perm_sub_cat='payment_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_create_loan_req_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Create Loan Request' AND perm_category='ACCOUNTS' AND perm_sub_cat='payment_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_inv_history_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Invoice History' AND perm_category='ACCOUNTS' AND perm_sub_cat='payment_history'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_pay_report_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Payment Report' AND perm_category='ACCOUNTS' AND perm_sub_cat='payment_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_loan_history_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Loan History' AND perm_category='ACCOUNTS' AND perm_sub_cat='payment_history'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_report_preview_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Generate Report & Preview' AND perm_category='OPERATIONS' AND perm_sub_cat='guard_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }


    public function get_kit_inventory_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'View Inventory' AND perm_category='OPERATIONS' AND perm_sub_cat='inventory_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_manage_kit_inventory_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Manage Kit Inventory' AND perm_category='OPERATIONS' AND perm_sub_cat='inventory_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_salary_history_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Salary History' AND perm_category='ACCOUNTS' AND perm_sub_cat='payment_history'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_salary_advance_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Salary Advance' AND perm_category='ACCOUNTS' AND perm_sub_cat='payment_history'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_view_guard_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'View Guard' AND perm_category='HR/ADMIN' AND perm_sub_cat='guard_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_view_client_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'View Clients' AND perm_category='HR/ADMIN' AND perm_sub_cat='client_beat_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_create_staff_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Create Staff' AND perm_category='HR/ADMIN' AND perm_sub_cat='staff_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_view_staff_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'View Staff' AND perm_category='HR/ADMIN' AND perm_sub_cat='staff_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function get_update_staff_permission_id(){
        $query = "SELECT * FROM tbl_permissions WHERE perm_description = 'Update Staff Information' AND perm_category='HR/ADMIN' AND perm_sub_cat='staff_detail'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            $data = $obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

}

$privileges = new Privileges();
?>