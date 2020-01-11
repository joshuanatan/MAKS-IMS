<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index(){
		$this->login();
	}
	public function login(){
		$userdata = array(
			"nama_user",
			"id_user",
			"email_user",
		);
		$this->session->unset_userdata($userdata);
		$this->page_generator->req();
		$this->load->view("plugin/fontawesome/fontawesome-css");
		$this->page_generator->head_close();
		$this->page_generator->content_open();
		$this->load->view("login/v_content_login");
		$this->page_generator->close();
		$this->load->view("req/script");
	}
	public function auth(){
		$config = array(
			array(
				"field" => "email_user",
				"label" => "Email",
				"rules" => "required"
			),
			array(
				"field" => "password_user",
				"label" => "password",
				"rules" => "required"
			)
		);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run()){
			$where = array(
				"email_user" => $this->input->post("email_user"),
				"password_user" => md5($this->input->post("password_user")),
				"status_aktif_user" => 1
			);
			$field = array(
				"nama_user","id_submit_user","email_user"
			);
			$result = selectRow("tbl_user",$where,$field);
			if($result->num_rows() > 0){
				$result_array = $result->result_array();
				$userdata = array(
					"nama_user" => $result_array[0]["nama_user"],
					"id_user" => $result_array[0]["id_submit_user"],
					"email_user" => $result_array[0]["email_user"],
				);
				$this->session->set_userdata($userdata);
				$msg = "User Authenticated";
				$this->session->set_flashdata("status_login","success");
				$this->session->set_flashdata("msg_login",$msg);
				redirect("welcome/dashboard");
			}
			else{
				
				$msg = "Combination Not Found";
				$this->session->set_flashdata("status_login","error");
				$this->session->set_flashdata("msg_login",$msg);
				redirect("welcome");
			}
		}	
		else{
			$msg = validation_errors();
			$this->session->set_flashdata("status_login","error");
			$this->session->set_flashdata("msg_login",$msg);
			redirect("welcome");
		}	
	}
	public function dashboard(){	
		$this->check_session();
		$this->page_generator->req();
		$this->page_generator->head_close();
		$this->page_generator->navbar();
		$this->page_generator->content_open();
		$this->load->view("welcome_message");
		$this->page_generator->close();
	}
	public function logout(){
		redirect("welcome");
	}
	private function check_session(){
		if($this->session->id_user == ""){
			$msg = "Session Expired";	
			$this->session->set_flashdata("status_login","error");
			$this->session->set_flashdata("msg_login",$msg);
			redirect("welcome");
		}
	}
	public function change_password(){
		$config = array(
			array(
				"field" => "password",
				"label" => "Password",
				"rules" => "required"
			)
		);
		$this->form_validation->set_rules($config);
		if($this->form_validation->run()){
			$where = array(
				"id_submit_user" => $this->session->id_user
			);
			$data = array(
				"password_user" => md5($this->input->post("password"))
			);
			updateRow("tbl_user",$data,$where);
			$msg = "Password updated. Session Expired";
			$this->session->set_flashdata("status_login","error");
			$this->session->set_flashdata("msg_login",$msg);
			redirect("welcome");
		}
		else{
			$msg = validation_errors();
			$this->session->set_flashdata("status_login","error");
			$this->session->set_flashdata("msg_login",$msg);
			redirect("welcome/dashboard");
		}
	}
}
