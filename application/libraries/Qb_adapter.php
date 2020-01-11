<?php
/**
 * Class ini bertujuan untuk standarisasi interaksi dengan nlp adapter.
 */
class Qb_adapter{
    private $uri;
    private $token;
    private $log_id;
    private $id_user;
    protected $CI;

    public function __construct($config){
        $this->CI =& get_instance();
        $this->CI->load->helper("standardquery_helper");
        $this->CI->load->library("Curl");
        $where = array(
            "module_connetion_category" => "query_builder_adapter",
            "status_aktif_module_connection" =>  1
        );
        $field = array(
            "module_connection_token","module_connection_uri","id_submit_module_connection"
        );
        $result = selectRow("tbl_module_connection",$where,$field);
        if($result->num_rows() > 0){
            $result_array = $result->result_array();
            $this->id_user = $config["id_user"];
            $this->uri = $result_array[0]["module_connection_uri"];
            $this->token = $result_array[0]["module_connection_token"];
            $this->log_id = $result_array[0]["id_submit_module_connection"];

            $msg = "Active <i>query builder adapter</i> module is found. Preparing for <i>intent</i> synchronizing";
            $this->CI->session->set_flashdata("status_qb_adapter","success");
            $this->CI->session->set_flashdata("msg_qb_adapter",$msg);
        }
        else{
            $msg = "Active <i>query builder adapter</i> module is not found";
            $this->CI->session->set_flashdata("status_qb_adapter","error");
            $this->CI->session->set_flashdata("msg_qb_adapter",$msg);
        }
    }
    private function get_log($category){
        $where = array(
            "module_log_id" => $this->log_id,
            "category_loaded" => $category,
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
    private function log_request($status,$msg,$log_category){
        $data = array(
            "module_log_id" => $this->log_id,
            "connection_status"  => strtoupper($status),
            "connection_msg" => strtoupper($msg),
            "tgl_module_connetion_log" => date("Y-m-d H:i:s"),
            "category_loaded" => strtoupper($log_category)
        );
        return insertRow("tbl_module_connection_log",$data);
    }
    private function update_repository($result,$id_log){
        for($a =0; $a<count($result); $a++){
            if(strtoupper($result[$a]["entity_name"]) == "INTENT"){
                $data = array(
                    "id_log" => $id_log,
                    "entity_value" => $result[$a]["entity_value"], 
                    "entity_name" => $result[$a]["entity_name"],
                    "status_aktif_entity" =>1,
                    "tgl_entity_add" => date("Y-m-d H:i:s"),
                    "id_user_entity_add" => $this->id_user
                );
            }
            else{
                $data = array(
                    "id_log" => $id_log,
                    "entity_name" => $result[$a]["entity_value"],
                    "status_aktif_entity" =>1,
                    "tgl_entity_add" => date("Y-m-d H:i:s"),
                    "id_user_entity_add" => $this->id_user
                );
            }
            
            insertRow("tbl_entity",$data);
        }
    }
    public function get_entity(){
        $log_category = "entity";
        $last_log = $this->get_log($log_category);
        $url = $this->uri."endpoint/get_entity/".rawurlencode($last_log);
        $header = array(
            "client-token:".$this->token
        );
        $respond = $this->CI->curl->get($url,$header);
        if($respond){
            if($respond["err"]){
                $msg = $respond["err"];
                $this->session->set_flashdata("status_sync","error");
                $this->session->set_flashdata("msg_sync",$msg);
            }
            else{
                $respond = json_decode($respond["response"],true);
                if(array_key_exists("error",$respond)){
                    $msg = $respond["msg"];
                    $this->session->set_flashdata("status_sync","error");
                    $this->session->set_flashdata("msg_sync",$msg);
                }
                else{
                    $this->update_repository($respond["result"],$this->log_id,$log_category);
                    $msg = $respond["msg"].". Finishing synchronization";
                    $this->session->set_flashdata("status_sync","success");
                    $this->session->set_flashdata("msg_sync",$msg);
                }
                $this->log_request($respond["status"],$respond["msg"],$log_category);
            }
        }
    }
}