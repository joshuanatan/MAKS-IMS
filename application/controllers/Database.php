<?php
date_default_timezone_set("Asia/Bangkok");
class Database extends CI_Controller{
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
            "status_aktif_db_connection <" => 2
        );
        $field = array(
            "id_submit_db_connection","db_name","db_hostname","db_username","db_password","status_aktif_db_connection","tgl_db_connection_last_modified"
        );
        $result = selectRow("tbl_db_connection",$where,$field);
        $data["database"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/form/form-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("database/v_database",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
        $this->load->view("plugin/form/form-js");
    }
    public function recycle_bin(){
        $this->check_session();
        $where = array(
            "status_aktif_db_connection" => 2
        );
        $field = array(
            "id_submit_db_connection","db_name","db_hostname","db_username","db_password","status_aktif_db_connection","tgl_db_connection_last_modified"
        );
        $result = selectRow("tbl_db_connection",$where,$field);
        $data["database"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->load->view("plugin/form/form-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("database/v_database_recycle_bin",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
        $this->load->view("plugin/form/form-js");
    }
    public function insert(){
        $this->check_session();
        $config = array(
            array(
                "field" => "db_hostname",
                "label" => "Database Hostname",
                "rules" => "required|valid_ip"
            ),
            array(
                "field" => "db_username",
                "label" => "Database Username",
                "rules" => "required"
            ),
            array(
                "field" => "db_name",
                "label" => "Database Name",
                "rules" => "required"
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            $data = array(
                "db_hostname" => $this->input->post("db_hostname"),
                "db_username" => $this->input->post("db_username"),
                "db_password" => $this->encryption->encrypt($this->input->post("db_password")),
                "db_name" => $this->input->post("db_name"),
                "status_aktif_db_connection" => '1',
                "tgl_db_connection_last_modified" => date("Y-m-d H:i:s"),
                "id_user_db_connection_last_modified" => $this->session->id_user
            );
            insertRow("tbl_db_connection",$data);
            $msg = "Database connection is successfully added to database";             
            $this->session->set_flashdata("status_db","success");
            $this->session->set_flashdata("msg_db",$msg);

            redirect("database");
        }
        else{
            $this->page_generator->req();
            $this->page_generator->head_close();
            $this->page_generator->content_open();
            $this->load->view("database/v_database_reinsert");
            $this->page_generator->close();
        }
    }
    public function delete($id_submit_db_connection){
        $this->check_session();
        $where = array(
            "id_submit_db_connection" => $id_submit_db_connection
        );
        $data = array(
            "status_aktif_db_connection" => 2,
            "tgl_db_connection_last_modified" => date("Y-m-d H:i:s"),
            "id_user_db_connection_last_modified" => $this->session->id_user
        );
        updateRow("tbl_db_connection",$data,$where);
        $msg = "Database connection is successfully deactivated";             
        $this->session->set_flashdata("status_db","success");
        $this->session->set_flashdata("msg_db",$msg);
        redirect("database");
    }
    public function deactive($id_submit_db_connection){
        $this->check_session();
        $where = array(
            "id_submit_db_connection" => $id_submit_db_connection
        );
        $data = array(
            "status_aktif_db_connection" => 0,
            "tgl_db_connection_last_modified" => date("Y-m-d H:i:s"),
            "id_user_db_connection_last_modified" => $this->session->id_user
        );
        updateRow("tbl_db_connection",$data,$where);
        $msg = "Database connection is successfully deactivated";             
        $this->session->set_flashdata("status_db","success");
        $this->session->set_flashdata("msg_db",$msg);
        redirect("database");
    }

    public function activate($id_submit_db_connection){
        $this->check_session();
        $where = array(
            "id_submit_db_connection" => $id_submit_db_connection
        );
        $data = array(
            "status_aktif_db_connection" => 1,
            "tgl_db_connection_last_modified" => date("Y-m-d H:i:s"),
            "id_user_db_connection_last_modified" => $this->session->id_user
        );
        updateRow("tbl_db_connection",$data,$where);
        $msg = "Database connection is successfully activated";             
        $this->session->set_flashdata("status_db","success");
        $this->session->set_flashdata("msg_db",$msg);
        redirect("database");
    }
    public function update(){
        $this->check_session();
        $where = array(
            "id_submit_db_connection" => $this->input->post("id_submit_db_connection")
        );
        $field = array(
            "db_password"
        );
        $result = selectRow("tbl_db_connection",$where,$field);
        $result_array = $result->result_array();

        $current_password = $this->input->post("current_password");

        if($this->encryption->decrypt($result_array[0]["db_password"]) == $current_password){
            $config = array(
                array(
                    "field" => "id_submit_db_connection",
                    "label" => "ID Database Connection",
                    "rules" => "required" 
                ),
                array(
                    "field" => "db_hostname",
                    "label" => "Database Hostname",
                    "rules" => "required|valid_ip"
                ),
                array(
                    "field" => "db_username",
                    "label" => "Database Username",
                    "rules" => "required"
                ),
                array(
                    "field" => "db_name",
                    "label" => "Database Name",
                    "rules" => "required"
                )
            );
            $this->form_validation->set_rules($config);
            if($this->form_validation->run()){
                $where = array(
                    "id_submit_db_connection" => $this->input->post("id_submit_db_connection")
                );
                $data = array(
                    "db_hostname" => $this->input->post("db_hostname"),
                    "db_username" => $this->input->post("db_username"),
                    "db_name" => $this->input->post("db_name"),
                    "tgl_db_connection_last_modified" => date("Y-m-d H:i:s"),
                    "id_user_db_connection_last_modified" => $this->session->id_user
                );
                updateRow("tbl_db_connection",$data,$where);
                $msg = "Database connection is successfully updated to database";
                $this->session->set_flashdata("status_db","success");
                $this->session->set_flashdata("msg_db",$msg);
            }
            else{
                $msg = validation_errors();
                $this->session->set_flashdata("status_db","error");
                $this->session->set_flashdata("msg_db",$msg);

            }
        }
        else{
            $msg = "Current database password is incorrect";
            $this->session->set_flashdata("status_db","error");
            $this->session->set_flashdata("msg_db",$msg);
        }
        redirect("database");
    }
    public function update_password(){
        $this->check_session();
        $where = array(
            "id_submit_db_connection" => $this->input->post("id_submit_db_connection")
        );
        $field = array(
            "db_password"
        );
        $result = selectRow("tbl_db_connection",$where,$field);
        $result_array = $result->result_array();

        $current_password = $this->input->post("current_password");
        $new_password = $this->input->post("new_password");

        if($this->encryption->decrypt($result_array[0]["db_password"]) == $current_password){
            $data = array(
                "db_password" => $this->encryption->encrypt($new_password)
            );
            $where = array(
                "id_submit_db_connection" => $this->input->post("id_submit_db_connection")
            );
            updateRow("tbl_db_connection",$data,$where);
                $this->session->set_flashdata("status_db","success");
                $this->session->set_flashdata("msg_db","Password modified");
            
        }
        else{
            
                $this->session->set_flashdata("status_db","error");
                $this->session->set_flashdata("msg_db","Password Doesnt match");
        }
        redirect("database");
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