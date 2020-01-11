<?php

function log_endpoint($client_token,$endpoint_token,$status_auth,$msg=""){
    $CI =& get_instance();
    $CI->load->helper("standardquery_helper");
    $data = array(
        "client_token" => strtoupper($client_token),
        "endpoint_token" => strtoupper($endpoint_token),
        "status_auth" => strtoupper($status_auth),
        "msg_auth" => strtoupper($msg),
        "tgl_endpoint_auth_log_add" => date("Y-m-d H:i:s")
    );
    insertRow("endpoint_auth_log",$data);
}
function log_sync($log_id,$executed_function, $status, $msg){
    $CI =& get_instance();
    $CI->load->helper("standardquery_helper");
    $data = array(
        "module_log_id" => strtoupper($log_id),
        "executed_function" => $executed_function, 
        "connection_status" => strtoupper($status),
        "connection_msg" => strtoupper($msg),
        "tgl_module_connetion_log" => date("Y-m-d H:i:s")
    );
    insertRow("tbl_module_connection_log",$data);
}
function get_log($log_id,$function){
    $CI =& get_instance();
    $CI->load->helper("standardquery_helper");
    $where = array(
        "module_log_id" => strtoupper($log_id),
        "executed_function" => strtoupper($function),
        "connection_status" => "success"
    );
    $field = array(
        "tgl_module_connetion_log"
    );
    $result = selectRow("tbl_module_connection_log",$where,$field,"","","id_submit_module_connection_log","DESC");
    $result_array = $result->result_array();
    if($result->num_rows() > 0){
        $last_log_time = $result_array[0]["tgl_module_connetion_log"];
    }
    else{
        $last_log_time = '0000-00-00 00:00:00';
    }
    return $last_log_time;
}
?>