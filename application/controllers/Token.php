<?php
date_default_timezone_set("Asia/Bangkok");
class Token extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $this->check_session();
        $randomString = $this->generate_token();
        $data["new_token"] = md5($randomString);
        $where = array(
            "status_aktif_token < " => 2
        );
        $field = array(
            "token","nama_client","status_aktif_token","tgl_token_last_modified","id_submit_token"
        );
        $result = selectRow("tbl_token",$where,$field);
        $data["token"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("master/v_token",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
    }
    public function recycle_bin(){
        $this->check_session();
        $randomString = $this->generate_token();
        $data["new_token"] = md5($randomString);
        $where = array(
            "status_aktif_token" => 2
        );
        $field = array(
            "token","nama_client","status_aktif_token","tgl_token_last_modified","id_submit_token"
        );
        $result = selectRow("tbl_token",$where,$field);
        $data["token"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("master/v_token_recycle_bin",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
    }
    public function generate_token(){
        $this->check_session();
        /**
         * Fungsi ini hanya untuk generate random token untuk diassign kepada 'client'
         */
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%^&*(!@#$%^&*('; 
        $randomString = ''; 
        $n = rand(10,100);
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
        return $randomString;
    }
    public function insert(){
        $this->check_session();
        $config = array(
            array(
                "field" => "token",
                "label" => "Token",
                "rules" => "required|is_unique[tbl_token.token]"
            ),
            array(
                "field" => "nama_client",
                "label" => "Nama Client",
                "rules" => "required|is_unique[tbl_token.nama_client]"
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            $data = array(
                "token" => $this->input->post("token"),
                "nama_client" => $this->input->post("nama_client"),
                "status_aktif_token" => 1,
                "tgl_token_last_modified" => date("Y-m-d H:i:s"),
                "id_user_token_last_modified" => $this->session->id_user,
            );
            insertRow("tbl_token",$data);
            $this->session->set_flashdata("status","success");
            $this->session->set_flashdata("msg","Data is successfully added");
            redirect("token");
        }
        else{
            $this->page_generator->req();
            $this->page_generator->head_close();
            $this->page_generator->content_open();
            $this->load->view("master/v_token_reinsert");
            $this->page_generator->close();
        }
    }
    public function deactive($id_submit_token){
        $this->check_session();
        $where = array(
            "id_submit_token" => $id_submit_token
        );
        $data = array(
            "status_aktif_token" => 0,
            "tgl_token_last_modified" => date("Y-m-d H:i:s"),
        );
        updateRow("tbl_token",$data,$where);
        $this->session->set_flashdata("status","error");
        $this->session->set_flashdata("msg","Data is successfully deactivated");
        redirect("token");
    }
    public function delete($id_submit_token){
        $this->check_session();
        $where = array(
            "id_submit_token" => $id_submit_token
        );
        $data = array(
            "status_aktif_token" => 2,
            "tgl_token_last_modified" => date("Y-m-d H:i:s"),
        );
        updateRow("tbl_token",$data,$where);
        $this->session->set_flashdata("status","error");
        $this->session->set_flashdata("msg","Data is successfully deleted");
        redirect("token");
    }
    public function activate($id_submit_token){
        $this->check_session();
        $where = array(
            "id_submit_token" => $id_submit_token
        );
        $data = array(
            "status_aktif_token" => 1,
            "tgl_token_last_modified" => date("Y-m-d H:i:s"),
        );
        updateRow("tbl_token",$data,$where);
        $this->session->set_flashdata("status","success");
        $this->session->set_flashdata("msg","Data is successfully activated");
        redirect("token");
    }
    public function update(){
        $this->check_session();
        $config = array(
            array(
                "field" => "token",
                "label" => "Token",
                "rules" => "required"
            ),
            array(
                "field" => "nama_client",
                "label" => "Nama Client",
                "rules" => "required"
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            $where = array(
                "id_submit_token" => $this->input->post("id_submit_token")
            );
            $data = array(
                "token" => $this->input->post("token"),
                "nama_client" => $this->input->post("nama_client"),
                "tgl_token_last_modified" => date("Y-m-d H:i:s"),
                "id_user_token_last_modified" => $this->session->id_user,
            );
            updateRow("tbl_token",$data,$where);
            $this->session->set_flashdata("status","success");
            $this->session->set_flashdata("msg","Data is successfully updated");
            redirect("token");
        }
        else{
            $this->page_generator->req();
            $this->page_generator->head_close();
            $this->page_generator->content_open();
            $this->load->view("master/v_token_reupdate");
            $this->page_generator->close();
        }
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