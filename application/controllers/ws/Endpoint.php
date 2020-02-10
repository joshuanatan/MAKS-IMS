<?php
class Endpoint extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $config = array(
            'cipher' => 'aes-256',
            'mode' => 'cbc',
            'key' => 'THWmuoIc87a4AvugOywNLUJ0yYPD1ggH'
        );
        $this->load->library("encryption",$config);
    }
    public function get_dataset(){
        $headers = getallheaders();
        if(array_key_exists("client-token",$headers)){
            $where = array(
                "token" => $headers["client-token"],
                "status_aktif_token" => 1
            );
            $field = array(
                "token"            
            );
            $result = selectRow("tbl_token",$where,$field);
            if($result->num_rows() > 0){
                
                $extracted_data = $this->input->post("text_entity_list");
                $extracted_data = json_decode($extracted_data,true);
                $replace_array = array();
                $check_mapping[0] = $extracted_data["intent"]; //masukin ke array intentnya
                $b = 1;
                if(array_key_exists("entity",$extracted_data)){
                    foreach($extracted_data["entity"] as $key => $value){
                        //1 key entity bisa megang 2 value
                        $key_structure = $key;
                        for($a = 1; $a<=count($value); $a++){
                            $replace_array["&".$key_structure.$a] = $value[($a-1)];
                            $check_mapping[$b] = $key; //masukin ke array entitynya. Biar kalau valuenya ada 2 biji, kemasuknya sebagai 2 entity key
                            $b++;
                        }
                        
                    }
                }
                sort($check_mapping); //di sort ASC (dari yang terkecil)
                $check_mapping = implode(",",$check_mapping);//dijadiin string dengan delimiter ','. untuk menyesuaikan dengan yang didatabase
                $where = array(
                    "entity" => $check_mapping
                );
                $field = array(
                    "dataset_name","dataset_key","dataset_query","id_db_connection","id_submit_dataset"
                );
                $result = selectRow("v_endpoint_intent_dataset_mapping",$where,$field);
                if($result->num_rows() > 0){
                    $control = array();
                    $dataset_detail["main"] = $result->result_array();
                    //print_r($dataset_detail["main"]);
                    
                    $dataset_detail["support"] = array();
                    for($a = 0; $a<count($dataset_detail["main"]); $a++){
                        if(!in_array($dataset_detail["main"][$a]["dataset_key"],$control)){
                            //kalau di array control gak ada, masukin aja.
                            array_push($control,$dataset_detail["main"][$a]["dataset_key"]);
                            
                        }
                        else{
                            //kalau ternyata udah ada somewhere(maybe kedobel atau dari support udah ada gitu, hilangin dari yang udah kedaftar di key main)
                            unset($dataset_detail["main"][$a]); 
                            continue;
                        }
                        $where = array(
                            "id_dataset" => $dataset_detail["main"][$a]["id_submit_dataset"],
                            "status_aktif_dataset_related" => 1,
                            "status_aktif_dataset" => 1
                        );
                        $field = array(
                            "dataset_name","dataset_key","dataset_query","id_db_connection","id_submit_dataset"
                        );
                        $support_dataset = selectRow("v_related_dataset",$where,$field);
                        if($support_dataset->num_rows() > 0){
                            
                            $support_dataset = $support_dataset->result_array();
                            for($b = 0; $b<count($support_dataset); $b++){
                                if(!in_array($support_dataset[$b],$control)){
                                    array_push($control,$support_dataset[$b]["dataset_key"]);
                                    array_push($dataset_detail["support"],$support_dataset[$b]);
                                }
                            }
                        }
                    }
                    $dataset_result_list = array();
                    for($a = 0; $a<count($dataset_detail["main"]); $a++){
                        $query = $dataset_detail["main"][$a]["dataset_query"];
                        foreach($replace_array as $key=>$value){
                            $query = str_replace($key,$value,$query);
                        }
                        //echo $query."\n";
                        $where = array(
                            "id_submit_db_connection" => $dataset_detail["main"][$a]["id_db_connection"]
                        );
                        $field = array(
                            "db_hostname","db_username","db_password","db_name"
                        );
                        $result = selectRow("tbl_db_connection",$where,$field)->row();
                        $servername = $result->db_hostname;
                        $username = $result->db_username;
                        $password = $this->encryption->decrypt($result->db_password);
                        
                        // Create connection
                        $conn = new mysqli($servername, $username, $password);
                        
                        // Check connection
                        if ($conn->connect_error) {
                        }
                        else{
                            $config = array(
                                "hostname" => $result->db_hostname,
                                "username" => $result->db_username,
                                "password" => $this->encryption->decrypt($result->db_password),
                                "database" => $result->db_name,
                                "dbdriver" => "mysqli"
                            );
                            $db1 = $this->load->database($config,true);
                            $query_result = $db1->query($query);
                            
                            if($query_result){
                                if($query_result->num_rows() > 0){
                                    $query_result = $query_result->result_array();
                                    $where = array(
                                        "id_dataset" => $dataset_detail["main"][$a]["id_submit_dataset"],
                                        "status_aktif_dataset_dbfield_mapping" => 1
                                    );
                                    $field = array(
                                        "db_field","db_field_alias"
                                    );
                                    $db_field = selectRow("tbl_dataset_dbfield_mapping",$where,$field)->result_array();
                                    $dataset_result = array(
                                        "dataset_name" => $dataset_detail["main"][$a]["dataset_key"],
                                        "dataset_desc" => $dataset_detail["main"][$a]["dataset_name"],
                                        "is_answer" => "true",
                                        "value" => array(
                                            "header" => $db_field,
                                            "content" => $query_result,
                                        )
                                    );
                                    array_push($dataset_result_list,$dataset_result);
                                }
                            }
                            else{
                            }
                        }
                    }
                    
                    for($a = 0; $a<count($dataset_detail["support"]); $a++){
                        $query = $dataset_detail["support"][$a]["dataset_query"];
                        foreach($replace_array as $key=>$value){
                            $query = str_replace($key,$value,$query);
                        }
                        $where = array(
                            "id_submit_db_connection" => $dataset_detail["support"][$a]["id_db_connection"]
                        );
                        $field = array(
                            "db_hostname","db_username","db_password","db_name"
                        );
                        $result = selectRow("tbl_db_connection",$where,$field)->row();
                        
                        $servername = $result->db_hostname;
                        $username = $result->db_username;
                        $password = $this->encryption->decrypt($result->db_password);
                        
                        // Create connection
                        $conn = new mysqli($servername, $username, $password);
                        
                        // Check connection
                        if ($conn->connect_error) {
                        }
                        else{
                            $conn->close();
                            $config = array(
                                "hostname" => $result->db_hostname,
                                "username" => $result->db_username,
                                "password" => $this->encryption->decrypt($result->db_password),
                                "database" => $result->db_name,
                                "dbdriver" => "mysqli",
                            );
                            $db1 = $this->load->database($config,true);
                            $query_result = $db1->query($query);
                            if($query_result){
                                if($query_result->num_rows() > 0){
                                    $query_result = $query_result->result_array();
                                    $where = array(
                                        "id_dataset" => $dataset_detail["support"][$a]["id_submit_dataset"],
                                        "status_aktif_dataset_dbfield_mapping" => 1
                                    );
                                    $field = array(
                                        "db_field","db_field_alias"
                                    );
                                    $db_field = selectRow("tbl_dataset_dbfield_mapping",$where,$field);
                                    $db_field = $db_field->result_array();
                                    $dataset_result = array(
                                        "dataset_name" => $dataset_detail["support"][$a]["dataset_key"],
                                        "dataset_desc" => $dataset_detail["support"][$a]["dataset_name"],
                                        "value" => array(
                                            "header" => $db_field,
                                            "content" => $query_result,
                                        )
                                    );
                                    array_push($dataset_result_list,$dataset_result);
                                }
                            }
                            else{
                            }
                        }
                        
                    }
                    $data = array(
                        "status" => "success",
                        "msg" => "Datasets Found",
                        "dataset_result" => $dataset_result_list
                    );
                }
                else{
                    $data = array(
                        "error" => "true",
                        "status" => "error",
                        "msg" => "Datasets Not Found",
                        "dataset_result" => $check_mapping
                    );
                }
                
            }
            else{ 
                $data = array(
                    "error" => "true",
                    "status" => 'error',
                    "msg" => "TOKEN IS NOT ACTIVE / UNABLE TO RECOGNIZE TOKEN",
                    "dataset_result" => "-"
                );
            }
        }
        else{
            $data = array(
                "error" => "true",
                "status" => 'error',
                "msg" => "TOKEN IS REQUIRED",
                "dataset_result" => "-"
            );
        }
        header("Content-type:application/json");
        echo json_encode($data);
    }
    public function get_dataset_list(){
        $where = array(
            "status_aktif_dataset" => 1
        );
        $field = array(
            "dataset_key"
        );
        $result = selectRow("tbl_dataset",$where,$field);
        if($result->num_rows() > 0){
            $data = array(
                "status" => "SUCCESS",
                "msg" => "Dataset List Found",
                "data" => $result->result_array()
            );
        }
        else{
            $data = array(
                "error" => "true",
                "status" => "ERROR",
                "msg" => "Dataset List Not Found"
            );
        }
        echo json_encode($data);
    }
}
?>