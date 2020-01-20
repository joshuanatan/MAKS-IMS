<?php
date_default_timezone_set("Asia/Bangkok");
class Intent_entity extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $this->check_session();
        //$this->get_intent_entity();
        $where = array(
            "entity_category !=" => null,
            "status_aktif_entity <" => 2
        );
        $field = array(
            "id_submit_entity","entity","entity_category","status_aktif_entity","tgl_entity_last_modified"
        );
        $result = selectRow("tbl_entity",$where,$field);
        $data["entity"] = $result->result_array();

        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("intent_entity/v_intent_entity",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
        $this->load->view("intent_entity/v_intent_entity_js");
    }
    public function recycle_bin(){
        $this->check_session();
        $where = array(
            "entity_category !=" => null,
            "status_aktif_entity" => 2
        );
        $field = array(
            "id_submit_entity","entity","entity_category","status_aktif_entity","tgl_entity_last_modified"
        );
        $result = selectRow("tbl_entity",$where,$field);
        $data["entity"] = $result->result_array();

        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("intent_entity/v_intent_entity_recycle_bin",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
        $this->load->view("intent_entity/v_intent_entity_js");
    }
    public function insert_entity(){
        $this->check_session();
        $checks = $this->input->post("checks");
        if($checks != ""){
            foreach($checks as $a){
                if($this->input->post("entity".$a) != ""){
                    $where = array(
                        "entity" => $this->input->post("entity".$a)
                    );
                    $field = array(
                        "entity"
                    );
                    $check = selectRow("tbl_entity",$where,$field);
                    if($check->num_rows() > 0){
                        $this->session->set_flashdata("status_intent_entity","error");
                        $this->session->set_flashdata("msg_intent_entity","Data Exists");
                    }
                    else{
                        $data = array(
                            "entity" => $this->input->post("entity".$a),
                            "entity_category" => $this->input->post("entity_category".$a),
                            "status_aktif_entity" => 1,
                            "tgl_entity_last_modified" => date("Y-m-d H:i:s"),
                            "id_user_entity_last_modified" => $this->session->id_user,
                        );
                        insertRow("tbl_entity",$data);
                        $msg = "Ticked data is successfully added to database";
                        $this->session->set_flashdata("status_intent_entity","success");
                        $this->session->set_flashdata("msg_intent_entity",$msg);
                    }
                }
                else{
                    $msg = validation_errors();
                    $this->session->set_flashdata("status_intent_entity","error");
                    $this->session->set_flashdata("msg_intent_entity",$msg);
                }
            }
        }
        else{
            $msg = "Need to tick the checkbox before submitting";
            $this->session->set_flashdata("status_intent_entity","error");
            $this->session->set_flashdata("msg_intent_entity",$msg);
        }
        redirect("intent_entity");
    }
    public function update_intent_entity(){
        $this->check_session();
        $where = array(
            "id_submit_entity" => $this->input->post("id_submit_entity")
        );
        if($this->input->post("entity") != ""){
            $where = array(
                "entity" => $this->input->post("entity"),
                "id_submit_entity !=" => $this->input->post("id_submit_entity")
            );
            $field = array(
                "entity"
            );
            $check = selectRow("tbl_entity",$where,$field);
            if($check->num_rows() > 0){
                $this->session->set_flashdata("status_intent_entity","error");
                $this->session->set_flashdata("msg_intent_entity","Data Exists");
            }
            else{
                $where = array(
                    "id_submit_entity" => $this->input->post("id_submit_entity")
                );
                $data = array(
                    "entity" => $this->input->post("entity"),
                    "entity_category" => $this->input->post("entity_category"),
                    "tgl_entity_last_modified" => date("Y-m-d H:i:s"),
                    "id_user_entity_last_modified" => $this->session->id_user
                );
                updateRow("tbl_entity",$data,$where);
                $msg = "Data is successfully updated to database";
                $this->session->set_flashdata("status_intent_entity","success");
                $this->session->set_flashdata("msg_intent_entity",$msg);
            }
        }
        else{
            $this->session->set_flashdata("status_intent_entity","error");
            $this->session->set_flashdata("msg_intent_entity",validation_errors());
        }
        redirect("intent_entity");
    }
    public function deactive($id_submit_entity){
        $this->check_session();
        $where = array(
            "id_submit_entity" => $id_submit_entity
        );
        $data = array(
            "status_aktif_entity" => 0,
            "tgl_entity_last_modified" => date("Y-m-d H:i:s"),
            "id_user_entity_last_modified" => $this->session->id_user
        );
        updateRow("tbl_entity",$data,$where);
        $msg = "Data is successfully deactivated";
        $this->session->set_flashdata("status_intent_entity","error");
        $this->session->set_flashdata("msg_intent_entity",$msg);
        redirect("intent_entity");
    }
    public function delete($id_submit_entity){
        $this->check_session();
        $where = array(
            "id_submit_entity" => $id_submit_entity
        );
        $data = array(
            "status_aktif_entity" => 2,
            "tgl_entity_last_modified" => date("Y-m-d H:i:s"),
            "id_user_entity_last_modified" => $this->session->id_user
        );
        updateRow("tbl_entity",$data,$where);
        $msg = "Data is successfully deactivated";
        $this->session->set_flashdata("status_intent_entity","error");
        $this->session->set_flashdata("msg_intent_entity",$msg);
        redirect("intent_entity");
    }
    public function activate($id_submit_entity){
        $this->check_session();
        $where = array(
            "id_submit_entity" => $id_submit_entity
        );
        $data = array(
            "status_aktif_entity" => 1,
            "tgl_entity_last_modified" => date("Y-m-d H:i:s"),
            "id_user_entity_last_modified" => $this->session->id_user
        );
        updateRow("tbl_entity",$data,$where);
        $msg = "Data is successfully activated";
        $this->session->set_flashdata("status_intent_entity","success");
        $this->session->set_flashdata("msg_intent_entity",$msg);
        redirect("intent_entity");
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