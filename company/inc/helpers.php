<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath.'/../../controllers/config/app.config.php');

if(!function_exists('url_path')){
    function url_path($url, $setProtocol = true, $encode = false){
        global $_config;
        $url = $encode ? '/'.gd_encode($url): $url;
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $protocol = $setProtocol? $protocol:"";
        return $protocol . $_SERVER['HTTP_HOST'] . $url;
    }
}

if(!function_exists('asset_path')){
    function asset_path($src){
        return __DIR__.'/../../assets/'.$src;
    }
}

if(!function_exists('public_path')){
    function public_path($src){
        return  url_path('/public/').$src;
    }
}
// var_dump(url_path('/public/'));
if(!function_exists('upload_path')){
    function upload_path($src){
        return __DIR__ .'/../../public/'.$src;
    }
}

if(!function_exists('get_company')){
    function get_company($id = null){
        $comp = new Company();
        $c_data = $comp->get_company_by_sno($id ?? $_SESSION['COMPANY_LOGIN']['company_sno'])->fetch_assoc();
        $comp = null;

        return array(
            "company_sno"=>$c_data['company_sno'],"company_id"=>$c_data['company_id'],"company_name"=>$c_data['company_name'],
            "company_email"=>$c_data['company_email'],"com_created_at"=>$c_data['com_created_at'],
            "company_phone"=>$c_data['company_phone'],"company_status"=>$c_data['company_status'],
            'company_address'=>$c_data['company_address'],
            'company_description'=>$c_data['company_description'],
            'company_logo'  => $c_data['company_logo'],
            'company_gd_strg'  => $c_data['company_gd_strg'],
            "staff_id"=>$c_data['staff_id'],
            "staff_name"=>$c_data['staff_firstname']."".$c_data['staff_lastname'],
            "staff_photo"=>$c_data['staff_photo'],
            "company_op_state"=>$c_data['company_op_state'],
            "company_no_op_state"=>$c_data['company_no_op_state'],
            "company_rc_no"=>$c_data['company_rc_no'],
            'company_tax_id_no'  => $c_data['company_tax_id_no'],
            "company_cac_file"=>$c_data['company_cac_file'],
            'company_op_license'  => $c_data['company_op_license'],
            //config
            'config_id'  => isset($c_data['config_sno'])?$c_data['config_sno']: null,
            'uniform_charge'  => isset($c_data['uniform_charge'])?$c_data['uniform_charge']: null,
            'uniform_fee'  => isset($c_data['uniform_fee'])?$c_data['uniform_fee']: null,
            'uniform_mode'  => isset($c_data['uniform_mode'])?$c_data['uniform_mode']: null,
            'take_agent'  => isset($c_data['agent'])?$c_data['agent']:null,
            'agent_fee'  => isset($c_data['agent_fee'])?$c_data['agent_fee']:null,
            'agent_mode'  => isset($c_data['agent_mode'])?$c_data['agent_mode']:null,
            'activation'  => isset($c_data['activation_date'])?$c_data['activation_date']:null,
            'loan_config_type'  => isset($c_data['loan_config_type'])?$c_data['loan_config_type']:null,
        );

    }
}

if(!function_exists('upload_file')){
    function upload_file($file,$path,$name = null,$filetype = 'image', $expected_filesize = 0, $delete_existing_file = false){
        $actual_type = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
        $target_file = $path . $name.'.'.$actual_type ?? basename($file["name"]); //it takes the name given or of the file

        $_config = gt_config();
        //expected file
        if($expected_filesize != 0){
            if($file['size'] > $expected_filesize){
                // http_response_code(200);
                return array("status" => 0, "message" => "File Larger than expected size.");
            }
        }
        //handle image file type
        if($filetype == 'image'){
            //get the configuration
            if(!in_array($actual_type,$_config['allowed_image_types'])){
                return array("status" => 0, "message" => "Not Allowed Images Type.");
            }
        }
        //handle document file type
        if($filetype == 'doc'){
            //get the configuration
            if(!in_array($actual_type,$_config['allowed_doc_types'])){
                // echo json_encode();
                return array("status" => 0, "message" => "Not Allowed Doc types.");
            }
        }

        //delete file if permited and it already exist
        if(file_exists($target_file) && $delete_existing_file == true){
            // echo json_encode(array("status" => 1, "message" => "deleted."));
            unlink($target_file);
        }

        //move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            return array("status" => 1, "message" =>  $name.'.'.$actual_type);
        }

        return array("status" => 0, "message" => "Unable to upload.");
    }
}

if(!function_exists('gt_config')){
    function gt_config(){
        global $_config;
        return $_config;
    }
}

if(!function_exists('gd_encode')){
    function gd_encode($url){
        // $pre = base64_encode(rand(000000,999999));
        // $post = base64_encode(rand(000000,999999));
        $mid  = base64_encode($url);
        return  $mid;
    }
}

if(!function_exists('gd_decode')){
    function gd_decode($url){
        // $str = explode('--',$url);
        return base64_decode($url);
    }
}
