<?php
date_default_timezone_set("Asia/Bangkok");
class dataset extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $config = array(
            'cipher' => 'aes-256',
            'mode' => 'cbc',
            'key' => 'THWmuoIc87a4AvugOywNLUJ0yYPD1ggH'
        );
        $this->load->library("encryption",$config);
    }
    public function index(){
        $this->check_session();
        $where = array(
            "status_aktif_dataset <" => 2
        );
        $field = array(
            "id_submit_dataset","dataset_name","dataset_query","db_hostname","db_name","entity","status_aktif_dataset","dataset_key","tgl_dataset_last_modified"
        );
        $result = selectRow("v_endpoint_intent_dataset_mapping",$where,$field);
        $data["dataset"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/form/form-css");
        $this->load->view("plugin/datatable/datatable-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("dataset/v_dataset",$data);
        $this->page_generator->close();
        $this->load->view("plugin/form/form-js");
        $this->load->view("plugin/datatable/datatable-js");
    }
    public function recycle_bin(){
        $this->check_session();
        $where = array(
            "status_aktif_dataset" => 2
        );
        $field = array(
            "id_submit_dataset","dataset_name","dataset_query","status_aktif_dataset","tgl_dataset_last_modified","db_hostname","db_name"
        );
        $result = selectRow("v_detail_dataset",$where,$field);
        $data["dataset"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/form/form-css");
        $this->load->view("plugin/datatable/datatable-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("dataset/v_dataset_recycle_bin",$data);
        $this->page_generator->close();
        $this->load->view("plugin/form/form-js");
        $this->load->view("plugin/datatable/datatable-js");
    }
    public function add(){
        $this->check_session();
        $where = array(
            "status_aktif_entity" => 1,
            "entity_category" => "intent"
        );
        $field = array(
            "id_submit_entity","entity"
        );
        $result = selectRow("tbl_entity",$where,$field);
        $data["intent"] = $result->result_array();
        
        $where = array(
            "status_aktif_entity" => 1,
            "entity_category !=" => "intent"
        );
        $field = array(
            "entity","id_submit_entity"
        );
        $result = selectRow("tbl_entity",$where,$field);
        $entity["entity"] = $result->result_array();

        $where = array(
            "status_aktif_db_connection" => 1
        );
        $field = array(
            "id_submit_db_connection","db_hostname","db_name"
        );
        $result = selectRow("tbl_db_connection",$where,$field);
        $data["database"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/form/form-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("dataset/v_dataset_add",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
        $this->load->view("plugin/form/form-js");
        $this->load->view("dataset/v_dataset_js",$entity);
    }
    public function insert(){
        $this->check_session();
        $config = array(
            array(
                "field" => "intent",
                "label" => "Intention",
                "rules" => "required"
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            $data = array(
                "status_aktif_entity_combination" => 1,
                "tgl_entity_combination_last_modified" => date("Y-m-d H:i:S"),
                "id_user_entity_combination_last_modified" => $this->session->id_user
            );
            $id_combination = insertRow("tbl_entity_combination",$data);
    
            $data = array(
                "id_entity" => $this->input->post("intent"),
                "id_entity_combination" => $id_combination,
                "status_aktif_entity_combination_list" => 1,
                "tgl_entity_combination_list_last_modified" =>date("Y-m-d H:i:s"),
                "id_user_entity_combination_list_last_modified" => $this->session->id_user
            );
            insertRow("tbl_entity_combination_list",$data);
            
            $checks = $this->input->post("checks");
            if($checks != ""){
                foreach($checks as $a){
                    $data = array(
                        "id_entity" => $this->input->post("entity".$a),
                        "id_entity_combination" => $id_combination,
                        "status_aktif_entity_combination_list" => 1,
                        "tgl_entity_combination_list_last_modified" =>date("Y-m-d H:i:s"),
                        "id_user_entity_combination_list_last_modified" => $this->session->id_user
                    );
                    insertRow("tbl_entity_combination_list",$data);
                }
            }
        }
        $config = array(
            array(
                "field" => "dataset_key",
                "label" => "Dataset Key",
                "rules" => "required"
            ),
            array(
                "field" => "dataset_name",
                "label" => "Dataset Name",
                "rules" => "required"
            ),
            array(
                "field" => "dataset_query",
                "label" => "Dataset Query",
                "rules" => "required"
            ),
            array(
                "field" => "id_db_connection",
                "label" => "Database Connection",
                "rules" => "required|greater_than[0]",
                "error" => array(
                    "greater_than[0]" => "Please choose database connection before submitting"
                )
            ),
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            $where = array(
                "dataset_key" => $this->input->post("dataset_key"),
            );
            $field = array(
                "dataset_key"
            );
            $check = selectRow("tbl_dataset",$where,$field);
            $dataset_key = $this->input->post("dataset_key");
            if($check->num_rows() > 0){
                $dataset_key = "[need revision] duplicated dataset key";
            }
            $data = array(
                "dataset_key" => $dataset_key,
                "dataset_name" => $this->input->post("dataset_name"),
                "dataset_query" => $this->input->post("dataset_query"),
                "id_entity_combination" => $id_combination,
                "id_db_connection" => $this->input->post("id_db_connection"),
                "status_aktif_dataset" => 1,
                "tgl_dataset_last_modified" => date("Y-m-d H:i:s"),
                "id_user_dataset_last_modified" => $this->session->id_user
            );
            $id_dataset = insertRow("tbl_dataset",$data);
            $checks = $this->input->post("db_field_checks");
            if($checks != ""){
                foreach($checks as $a){
                    $data = array(
                        "id_dataset" => $id_dataset,
                        "db_field" => $this->input->post("db_field".$a),
                        "tbl_name" => $this->input->post("table_name".$a),
                        "db_field_alias" => $this->input->post("db_field_alias".$a),
                        "status_aktif_dataset_dbfield_mapping" => 1,
                        "tgl_dataset_dbfield_mapping_last_modified" => date("Y-m-d H:i:s"),
                        "id_user_dataset_dbfield_mapping_last_modified" => $this->session->id_user
                    );
                    insertRow("tbl_dataset_dbfield_mapping",$data);
                }
                $msg = "Dataset is successfully updated to database";
                $this->session->set_flashdata("status_dataset","success");
                $this->session->set_flashdata("msg_dataset",$msg);
                redirect("dataset");
            }
            else{
                $where = array(
                    "status_aktif_db_connection" => 1
                );
                $field = array(
                    "id_submit_db_connection","db_hostname","db_name"
                );
                $result = selectRow("tbl_db_connection",$where,$field);
                $data["database"] = $result->result_array();
                $msg = "Please input query fields";
                $this->session->set_flashdata("status_dataset","error");
                $this->session->set_flashdata("msg_dataset",$msg);
                $this->page_generator->req();
                $this->load->view("plugin/form/form-css");
                $this->page_generator->head_close();
                $this->page_generator->content_open();
                $this->load->view("dataset/v_dataset_add",$data);
                $this->page_generator->close();
                $this->load->view("plugin/form/form-js");
                $this->load->view("dataset/v_dataset_js");
            }
        }
        else{
            $msg = validation_errors();
            $this->session->set_flashdata("status_dataset","error");
            $this->session->set_flashdata("msg_dataset",$msg);
            redirect("dataset/add");
        }
    }
    public function delete($id_submit_dataset){
        $this->check_session();
        $where = array(
            "id_submit_dataset" => $id_submit_dataset
        );
        $data = array(
            "status_aktif_dataset" => 2,
            "tgl_dataset_last_modified" => date("Y-m-d H:i:s"),
            "id_user_dataset_last_modified" => $this->session->id_user
        );
        updateRow("tbl_dataset",$data,$where);
        $msg = "Data is successfully deactivated";
        $this->session->set_flashdata("status_dataset","success");
        $this->session->set_flashdata("msg_dataset",$msg);
        redirect("dataset");
    }
    public function deactive($id_submit_dataset){
        $this->check_session();
        $where = array(
            "id_submit_dataset" => $id_submit_dataset
        );
        $data = array(
            "status_aktif_dataset" => 0,
            "tgl_dataset_last_modified" => date("Y-m-d H:i:s"),
            "id_user_dataset_last_modified" => $this->session->id_user
        );
        updateRow("tbl_dataset",$data,$where);
        $msg = "Data is successfully deactivated";
        $this->session->set_flashdata("status_dataset","success");
        $this->session->set_flashdata("msg_dataset",$msg);
        redirect("dataset");
    } 
    public function activate($id_submit_dataset){
        $this->check_session();
        $where = array(
            "id_submit_dataset" => $id_submit_dataset
        );
        $data = array(
            "status_aktif_dataset" => 1,
            "tgl_dataset_last_modified" => date("Y-m-d H:i:s"),
            "id_user_dataset_last_modified" => $this->session->id_user
        );
        updateRow("tbl_dataset",$data,$where);
        $msg = "Data is successfully activated";
        $this->session->set_flashdata("status_dataset","success");
        $this->session->set_flashdata("msg_dataset",$msg);
        redirect("dataset");
    }
    public function edit($id_submit_dataset){
        $this->check_session();
        $where = array(
            "status_aktif_entity" => 1,
            "entity_category" => "intent"
        );
        $field = array(
            "id_submit_entity","entity"
        );
        $result = selectRow("tbl_entity",$where,$field);
        $data["intent"] = $result->result_array();
        
        $where = array(
            "id_submit_dataset" => $id_submit_dataset
        );
        $field = array(
            "dataset_key","dataset_name","dataset_query","id_db_connection","id_submit_dataset","id_entity_combination",
        );
        $result = selectRow("tbl_dataset",$where,$field);
        $data["main"] = $result->result_array();

        $where = array(
            "status_aktif_db_connection" => 1
        );
        $field = array(
            "id_submit_db_connection","db_hostname","db_name"
        );
        $result = selectRow("tbl_db_connection",$where,$field);
        $data["database"] = $result->result_array();

        $where = array(
            "id_dataset" => $id_submit_dataset,
            "status_aktif_dataset_dbfield_mapping" => 1
        );
        $field = array(
            "id_submit_dataset_dbfield_mapping","db_field","db_field_alias","tbl_name"
        );
        $result = selectRow("tbl_dataset_dbfield_mapping",$where,$field);
        $data["dbfield"] = $result->result_array();
        
        $where = array(
            "id_entity_combination" => $data["main"][0]["id_entity_combination"]
        );
        $field = array(
            "id_submit_entity_combination_list","entity","entity_category"
        );
        $result = selectRow("v_detail_entity_mapping",$where,$field);
        $data["registered_entity"] = $result->result_array();

        $where = array(
            "id_entity_combination" => $data["main"][0]["id_entity_combination"],
            "entity_category" => "intent"
        );
        $field = array(
            "id_submit_entity"
        );
        $result = selectRow("v_detail_entity_mapping",$where,$field);
        $data["registered_intent"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/form/form-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("dataset/v_dataset_edit",$data);
        $this->page_generator->close();
        $this->load->view("plugin/form/form-js");
        
        $where = array(
            "status_aktif_entity" => 1,
            "entity_category !=" => "intent"
        );
        $field = array(
            "entity","id_submit_entity"
        );
        $result = selectRow("tbl_entity",$where,$field);
        $entity["entity"] = $result->result_array();

        $this->load->view("dataset/v_dataset_js",$entity);
    }
    public function update(){
        $this->check_session();
        $id_combination = $this->input->post("id_submit_entity_combination");

        $config = array(
            array(
                "field" => "intent",
                "label" => "Intention",
                "rules" => "required"
            ),
            array(
                "field" => "id_submit_entity_combination",
                "label" => "ID Entity Combination",
                "rules" => "required"
            ),
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            /** Menonaktifkan semua entity combination list */
            $checks = $this->input->post("delete_registered_entity_check");
            if($checks !=""){
                foreach($checks as $a){
                    $where = array(
                        "id_submit_entity_combination_list" => $a
                    );
                    $data = array(
                        "status_aktif_entity_combination_list" => 0,
                        "tgl_entity_combination_list_last_modified" => date("Y-m-d H:i:S"),
                        "id_user_entity_combination_list_last_modified" => $this->session->id_user
                    );
                    updateRow("tbl_entity_combination_list",$data,$where);
                }
            }
            /**memasukan intent */
            $where = array(
                "id_entity" => $this->input->post("intent"),
                "id_entity_combination" => $id_combination,
                "status_aktif_entity_combination_list" => 1,
            );
            if(isExistsInTable("tbl_entity_combination_list",$where) == 1){ //kalau ga ad
                $data = array(
                    "id_entity" => $this->input->post("intent"),
                    "id_entity_combination" => $id_combination,
                    "status_aktif_entity_combination_list" => 1,
                    "tgl_entity_combination_list_last_modified" =>date("Y-m-d H:i:s"),
                    "id_user_entity_combination_list_last_modified" => $this->session->id_user
                );
                insertRow("tbl_entity_combination_list",$data);
            }
            /**memasukan entity */
            $checks = $this->input->post("checks");
            if($checks != ""){
                foreach($checks as $a){
                    $where = array(
                        "id_entity" => $this->input->post("entity".$a),
                        "id_entity_combination" => $id_combination,
                        "status_aktif_entity_combination_list" => 1,
                    );
                    if(isExistsInTable("tbl_entity_combination_list",$where) == 1){ //di cek dlu mencegah dobel
                        $data = array(
                            "id_entity" => $this->input->post("entity".$a),
                            "id_entity_combination" => $id_combination,
                            "status_aktif_entity_combination_list" => 1,
                            "tgl_entity_combination_list_last_modified" =>date("Y-m-d H:i:s"),
                            "id_user_entity_combination_list_last_modified" => $this->session->id_user
                        );
                        insertRow("tbl_entity_combination_list",$data);
                    }
                }
            }
        }
        $config = array(
            array(
                "field" => "id_submit_dataset",
                "label" => "ID Dataset",
                "rules" => "required"
            ),
            array(
                "field" => "dataset_key",
                "label" => "Dataset Key",
                "rules" => "required"
            ),
            array(
                "field" => "dataset_name",
                "label" => "Dataset Name",
                "rules" => "required"
            ),
            array(
                "field" => "dataset_query",
                "label" => "Dataset Query",
                "rules" => "required"
            ),
            array(
                "field" => "id_db_connection",
                "label" => "Database Connection",
                "rules" => "required"
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            $where = array(
                "dataset_key" => $this->input->post("dataset_key"),
                "id_submit_dataset !=" => $this->input->post("id_submit_dataset")
            );
            $field = array(
                "dataset_key"
            );
            $check = selectRow("tbl_dataset",$where,$field);
            $dataset_key = $this->input->post("dataset_key");
            if($check->num_rows() > 0){
                $dataset_key = "[need revision] duplicated dataset key";
            }
            $where = array(
                "id_submit_dataset" => $this->input->post("id_submit_dataset")
            );
            $data = array(
                "dataset_name" => $this->input->post("dataset_name"),
                "dataset_key" => $dataset_key,
                "dataset_query" => $this->input->post("dataset_query"),
                "id_db_connection" => $this->input->post("id_db_connection"),
                "tgl_dataset_last_modified" => date("Y-m-d H:i:s"),
                "id_user_dataset_last_modified" => $this->session->id_user
            );
            updateRow("tbl_dataset",$data,$where);
    
            $db_field_last_modified = $this->input->post("db_field_last_modified");
            if($db_field_last_modified != ""){
                foreach($db_field_last_modified as $a){
                    $where = array(
                        "id_submit_dataset_dbfield_mapping" => $a
                    );
                    $data = array(
                        "db_field" => $this->input->post("db_field".$a),
                        "db_field_alias" => $this->input->post("db_field_alias".$a),
                        "tbl_name" => $this->input->post("tbl_name".$a), 
                        "tgl_dataset_dbfield_mapping_last_modified" => date("Y-m-d H:i:s"),
                        "id_user_dataset_dbfield_mapping_last_modified" => $this->session->id_user
                    );
                    updateRow("tbl_dataset_dbfield_mapping",$data,$where);
                }
            }
            $db_field_remove = $this->input->post("db_field_remove");
            if($db_field_remove != ""){
                foreach($db_field_remove as $a){
                    $where = array(
                        "id_submit_dataset_dbfield_mapping" => $a
                    );
                    $data = array(
                        "status_aktif_dataset_dbfield_mapping" => 0,
                        "tgl_dataset_dbfield_mapping_last_modified" => date("Y-m-d H:i:s"),
                        "id_user_dataset_dbfield_mapping_last_modified" => $this->session->id_user
                    );
                    updateRow("tbl_dataset_dbfield_mapping",$data,$where);
                }
            }
            $checks = $this->input->post("db_field_checks");
            if($checks != ""){
                foreach($checks as $a){
                    $data = array(
                        "id_dataset" => $this->input->post("id_submit_dataset"),
                        "db_field" => $this->input->post("db_field".$a),
                        "tbl_name" => $this->input->post("table_name".$a),
                        "db_field_alias" => $this->input->post("db_field_alias".$a),
                        "status_aktif_dataset_dbfield_mapping" => 1,
                        "tgl_dataset_dbfield_mapping_last_modified" => date("Y-m-d H:i:s"),
                        "id_user_dataset_dbfield_mapping_last_modified" => $this->session->id_user
                    );
                    insertRow("tbl_dataset_dbfield_mapping",$data);
                }
            }
            $msg = "Data is successfully updated to database";
            $this->session->set_flashdata("status_dataset","success");
            $this->session->set_flashdata("msg_dataset",$msg);
        }
        else{
            $msg = validation_errors();
            $this->session->set_flashdata("status_dataset","error");
            $this->session->set_flashdata("msg_dataset",$msg);
        }
        redirect("dataset/edit/".$this->input->post("id_submit_dataset"));
        
    }
    public function related($id_submit_dataset){
        $this->check_session();
        $this->session->id_dataset = $id_submit_dataset;
        $where = array(
            "id_dataset" => $id_submit_dataset,
            "status_aktif_dataset_related" => 1,
        );
        $field = array(
            "id_submit_dataset","dataset_key","dataset_name","dataset_query","id_submit_dataset_related"
        );
        $result = selectRow("v_related_dataset",$where,$field);
        $data["registered_intent"] = $result->result_array();

        $where = array(
            "status_aktif_dataset" => 1,
            "id_submit_dataset != " => $id_submit_dataset
        );
        $field = array(
            "dataset_key","dataset_name","id_entity_combination"
        );
        $result = selectRow("tbl_dataset",$where,$field);
        $data["dataset_list"] = $result->result_array();

        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("dataset/v_dataset_related",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
        $this->load->view("dataset/v_dataset_related_js");
    }
    public function remove_related(){
        $this->check_session();
        $checks = $this->input->post("checks");
        if($checks != ""){
            foreach($checks as $a){
                $where = array(
                    "id_submit_dataset_related" => $a
                );
                $data = array(
                    "status_aktif_dataset_related" => 0,
                    "tgl_dataset_related_last_modified" => date("Y-m-d H:i:S"),
                    "id_user_dataset_related_last_modified" => $this->session->id_user
                );
                updateRow("tbl_dataset_related",$data,$where);
            }
        }
        redirect("dataset/related/".$this->session->id_dataset);
    }
    public function insert_related(){
        $this->check_session();
        $checks = $this->input->post("checks");
        if($checks != ""){
            foreach($checks as $a){
                $data = array(
                    "id_dataset" => $this->session->id_dataset,
                    "id_dataset_related" => $this->input->post("dataset_related".$a),
                    "status_aktif_dataset_related" => 1,
                    "tgl_dataset_related_last_modified" => date("Y-m-d H:i:S"),
                    "id_user_dataset_related_last_modified" => $this->session->id_iser
                );
                insertRow("tbl_dataset_related",$data);
            }
        }
        redirect("dataset/related/".$this->session->id_dataset);
    }
    private function check_session(){
		if($this->session->id_user == ""){
			$msg = "Session Expired";	
			$this->session->set_flashdata("status_login","error");
			$this->session->set_flashdata("msg_login",$msg);
			redirect("welcome");
		}
	}
}
?>