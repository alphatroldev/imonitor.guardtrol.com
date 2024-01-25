<?php
if(!session_id()) { session_start(); }

if(!function_exists('asset_path')){
    function asset_path($src){
        return __DIR__.'/../../assets/'.$src;
    }
}

if(!function_exists('public_path')){
    function public_path($src){
        return '/imonitor.guardtrol.com/public/'.$src;
    }
}

if(!function_exists('get_staff')){
    function get_staff($id = null){
       
        // if(isset($_SESSION['STAFF_LOGIN'])){
        // print_r($id);die;
        // print_r($_SESSION['STAFF_LOGIN']); die;
        
        $staff = new Staff();
        $g_data = $staff->get_staff_by_sno($id ??$_SESSION['STAFF_LOGIN']['staff_sno'])->fetch_assoc();
        $comp = null;

        return array(
            "staff_sno"=>$g_data['staff_sno'],
            "staff_id"=>$g_data['staff_id'],
            "staff_firstname"=>$g_data['staff_firstname'],
            "staff_middlename"=>$g_data['staff_middlename'],
            "staff_lastname"=>$g_data['staff_lastname'],
            "staff_sex"=>$g_data['staff_sex'],
            "staff_phone"=>$g_data['staff_phone'],
            "staff_email"=>$g_data['staff_email'],
            "staff_role"=>$g_data['staff_role'],
            "company_role_name"=>$g_data['company_role_name'],
            "staff_photo"=>$g_data['staff_photo'],
            "staff_acc_status"=>$g_data['staff_acc_status'],
            "company_id"=>$g_data['company_id'],
            "company_sno"=>$g_data['company_sno'],
            "company_name"=>$g_data['company_name'],
            "company_email"=>$g_data['company_email'],
            "com_created_at"=>$g_data['com_created_at'],
            "company_phone"=>$g_data['company_phone'],"company_status"=>$g_data['company_status'],
            'company_address'=>$g_data['company_address'],
            'company_logo'  => $g_data['company_logo'],

            "staff_name"=>$g_data['staff_firstname']." ".$g_data['staff_lastname'],
            //config
            'config_id'  => isset($g_data['config_sno'])?$g_data['config_sno']: null,
            'uniform_charge'  => isset($g_data['uniform_charge'])?$g_data['uniform_charge']: null,
            'uniform_fee'  => isset($g_data['uniform_fee'])?$g_data['uniform_fee']: null,
            'uniform_mode'  => isset($g_data['uniform_mode'])?$g_data['uniform_mode']: null,
            'take_agent'  => isset($g_data['agent'])?$g_data['agent']:null,
            'agent_fee'  => isset($g_data['agent_fee'])?$g_data['agent_fee']:null,
            'agent_mode'  => isset($g_data['agent_mode'])?$g_data['agent_mode']:null,
            'activation'  => isset($g_data['activation_date'])?$g_data['activation_date']:null,
            'loan_config_type'  => isset($g_data['loan_config_type'])?$g_data['loan_config_type']:null,
        );
        // }

    }
}
