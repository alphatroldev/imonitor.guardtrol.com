<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once(getcwd().'/controllers/classes/Company.class.php');


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (trim($data->action_code) == '101' && !empty(trim($data->staff_sno))) {
        if ($company->update_staff_status($data->active,$data->staff_sno)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Staff status updated."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update Staff status."));
        }
    }

    if (trim($data->action_code) == '102' && !empty(trim($data->staff_sno))) {
        if ($company->delete_staff($data->staff_sno)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Staff deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete Staff."));
        }
    }

    if (trim($data->action_code) == '103' && !empty(trim($data->comp_role_sno)) && !empty(trim($data->comp_id))) {
        if ($company->delete_company_role($data->comp_role_sno,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Role deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete role."));
        }
    }

    if (trim($data->action_code) == '104' && !empty(trim($data->comp_id)) && !empty(trim($data->shift_id))) {
        if ($company->delete_company_shift($data->shift_id,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Shift deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete shift."));
        }
    }

    if (trim($data->action_code) == '105' && !empty(trim($data->comp_id)) && !empty(trim($data->offense_id))) {
        if ($company->delete_company_penalty($data->offense_id,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Penalty deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete penalty."));
        }
    }

    if (trim($data->action_code) == '106' && !empty(trim($data->comp_id)) && !empty(trim($data->incident_id))) {
        if ($company->delete_company_incident($data->incident_id,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Incident report deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete incident report."));
        }
    }

    if (trim($data->action_code) == '107' && !empty(trim($data->comp_id)) && !empty(trim($data->kit_inv_sno))) {
        if ($company->delete_company_kit_inventory($data->kit_inv_sno,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Kit inventory deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete kit inventory."));
        }
    }

    if (trim($data->action_code) == '909' && !empty(trim($data->comp_id)) && !empty(trim($data->kit_sno))) {
        if ($company->delete_company_registered_kit($data->kit_sno,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Registered Kit deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete registered kit."));
        }
    }

    if (trim($data->action_code) == '908' && !empty(trim($data->comp_id)) && !empty(trim($data->xtraduty_id))) {
        if ($company->delete_guard_xtraduty_entry($data->xtraduty_id,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Extra duty deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete registered kit."));
        }
    }

    if (trim($data->action_code) == '109' && !empty(trim($data->spr_month)) && !empty(trim($data->spr_year)) && !empty(trim($data->comp_id))) {
        if ($company->delete_company_staff_payroll($data->spr_month,$data->spr_year,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Staff payroll deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete staff payroll."));
        }
    }

    if (trim($data->action_code) == '129' && !empty(trim($data->gpr_month)) && !empty(trim($data->gpr_year)) && !empty(trim($data->comp_id))) {
        if ($company->delete_company_guard_payroll($data->gpr_month,$data->gpr_year,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Guard payroll deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete guard payroll."));
        }
    }

    if (trim($data->action_code) == '202' && !empty(trim($data->payroll_sno)) && !empty(trim($data->comp_id))) {
        if ($company->delete_payroll_data($data->payroll_sno,$data->comp_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Payroll config data deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete payroll data."));
        }
    }
}