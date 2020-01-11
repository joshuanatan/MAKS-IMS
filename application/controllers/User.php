<?php
date_default_timezone_set("Asia/Bangkok");
class User extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $this->check_session();
        $where = array(
            "statuS_aktif_user < " => 2 
        );
        $field = array(
            "id_submit_user","nama_user","email_user","status_aktif_user","tgl_user_last_modified",
        );
        $result = selectRow("tbl_user",$where,$field);
        $data["user"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("master/v_user",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
    }
    public function recycle_bin(){
        $this->check_session();
        $where = array(
            "id_submit_user != " => $this->session->id_user,
            "statuS_aktif_user" => 2
        );
        $field = array(
            "id_submit_user","nama_user","email_user","status_aktif_user","tgl_user_last_modified"
        );
        $result = selectRow("tbl_user",$where,$field);
        $data["user"] = $result->result_array();
        $this->page_generator->req();
        $this->load->view("plugin/datatable/datatable-css");
        $this->page_generator->head_close();
        $this->page_generator->navbar();
        $this->page_generator->content_open();
        $this->load->view("master/v_user_recycle_bin",$data);
        $this->page_generator->close();
        $this->load->view("plugin/datatable/datatable-js");
    }
    public function insert(){
        $this->check_session();
        $config = array(
            array(
                "field" => "nama_user",
                "label" => ucwords(str_replace("_"," ","nama_user")),
                "rules" => "required"
            ),
            array(
                "field" => "password_user",
                "label" => ucwords(str_replace("_"," ","password_user")),
                "rules" => "required"
            ),
            array(
                "field" => "email_user",
                "label" => ucwords(str_replace("_"," ","email_user")),
                "rules" => "required|is_unique[tbl_user.email_user]|valid_email"
            ),
        );
        $this->form_validation->set_rules($config);    
        if($this->form_validation->run()){
            $data = array(
                "nama_user" => $this->input->post("nama_user") ,
                "password_user" => md5($this->input->post("password_user")),
                "status_aktif_user" => 1,
                "tgl_user_last_modified" => date("Y-m-d H:i:s"),
                "id_user_user_last_modified" => $this->session->id_user,
                "email_user" => $this->input->post("email_user")
            );
            insertRow("tbl_user",$data);
            $this->session->set_flashdata("status","success");
            $this->session->set_flashdata("msg","Data is successfully added");
            redirect("user");
        }
        else{
            $this->page_generator->req();
            $this->page_generator->head_close();
            $this->page_generator->content_open();
            $this->load->view("master/v_user_reinsert");
            $this->page_generator->close();
        }
    }
    public function update(){
        $this->check_session();
        $config = array(
            array(
                "field" => "nama_user",
                "label" => ucwords(str_replace("_"," ","nama_user")),
                "rules" => "required"
            ),
            array(
                "field" => "email_user",
                "label" => ucwords(str_replace("_"," ","email_user")),
                "rules" => "required|valid_email"
            ),
        );
        $this->form_validation->set_rules($config);    
        if($this->form_validation->run()){
            $where = array(
                "id_submit_user" => $this->input->post("id_submit_user")
            );
            $field = array(
                "email_user"
            );
            $result = selectRow("tbl_user",$where,$field)->row(); //pasti ada
            if($result->email_user == $this->input->post("email_user")){
                $data = array(
                    "nama_user" => $this->input->post("nama_user"),
                    "tgl_user_last_modified" => date("Y-m-d H:i:s"),
                    "id_user_user_last_modified" => $this->session->id_user,
                    "email_user" => $this->input->post("email_user")
                );
                updateRow("tbl_user",$data,$where);
                $this->session->set_flashdata("status","success");
                $this->session->set_flashdata("msg","Data is successfully updated");
            }
            else{
                //ganti email
                $where = array(
                    "email_user" => $this->input->post("email_user")
                );
                $field = array(
                    "id_submit_user",
                );
                $result = selectRow("tbl_user",$where,$field);
                if($result->num_rows() > 0){
                    $this->session->set_flashdata("status","error");
                    $this->session->set_flashdata("msg","Email is taken. Request Denied");
                }
                else{
                    $where = array(
                        "id_submit_user" => $this->input->post("id_submit_user")
                    );
                    $data = array(
                        "nama_user" => $this->input->post("nama_user"),
                        "tgl_user_last_modified" => date("Y-m-d H:i:s"),
                        "id_user_user_last_modified" => $this->session->id_user,
                        "email_user" => $this->input->post("email_user")
                    );
                    updateRow("tbl_user",$data,$where);
                    $this->session->set_flashdata("status","success");
                    $this->session->set_flashdata("msg","Data is successfully updated");
                }
            }
            redirect("user");
        }
        else{
            $this->page_generator->req();
            $this->page_generator->head_close();
            $this->page_generator->content_open();
            $this->load->view("master/v_user_reupdate");
            $this->page_generator->close();
        }
    }
    public function update_password(){
        $this->check_session();
        $config = array(
            array(
                "field" => "password_user",
                "label" => "Password User",
                "rules" => "required" 
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()){
            $where = array(
                "id_submit_user" => $this->input->post("id_submit_user")
            );
            $data = array(
                "password_user" => md5($this->input->post("password_user")),
                "tgl_user_last_modified" => date("Y-m-d H:i:s"),
                "id_user_user_last_modified" => $this->session->id_user,
            );
            updateRow("tbl_user",$data,$where);
            $this->session->set_flashdata("status","success");
            $this->session->set_flashdata("msg","Password is successfully updated");
            redirect("user");
        }
        else{
            $this->session->set_flashdata("status","error");
            $this->session->set_flashdata("msg","Password field is required");
            redirect("user");
        }
    }
    public function deactive($id_submit_user){
        $this->check_session();
        $where = array(
            "id_submit_user" => $id_submit_user
        );
        $data = array(
            "status_aktif_user" => 0,
            "tgl_user_last_modified" => date("Y-m-d H:i:s"),
        );
        updateRow("tbl_user",$data,$where);
    
        $this->session->set_flashdata("status","success");
        $this->session->set_flashdata("msg","Data is successfully deactivated");
        redirect("user");
    }
    public function delete($id_submit_user){
        $this->check_session();
        $where = array(
            "id_submit_user" => $id_submit_user
        );
        $data = array(
            "status_aktif_user" => 2,
            "tgl_user_last_modified" => date("Y-m-d H:i:s"),
        );
        updateRow("tbl_user",$data,$where);
    
        $this->session->set_flashdata("status","success");
        $this->session->set_flashdata("msg","Data is successfully deactivated");
        redirect("user");
    }
    public function activate($id_submit_user){
        $this->check_session();
        $where = array(
            "id_submit_user" => $id_submit_user
        );
        $data = array(
            "status_aktif_user" => 1,
            "tgl_user_last_modified" => date("Y-m-d H:i:s"),
        );
        updateRow("tbl_user",$data,$where);
    
        $this->session->set_flashdata("status","success");
        $this->session->set_flashdata("msg","Data is successfully activated");
        redirect("user");
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