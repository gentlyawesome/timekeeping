<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_password extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->session_checker->open_semester();
		$this->load->model('M_users');
		$this->load->library(array('form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->model(array('M_users'));
	}

	public function index($userId = false)
	{
		$this->session_checker->secure_page('student');
		
		if($userId == false)
		{
			show_404();
		}
		else
		{
			$this->load->library('login');
			
			$this->view_data['system_message'] = $this->session->flashdata('system_message');
			
			$users = $this->M_users->get_login_by_id($userId);
			
			$cur_pass = trim($this->input->post('currentpassword'));
			$new_pass = trim($this->input->post('newpassword'));
			$ver_pass = trim($this->input->post('verifypassword'));
			
			if($_POST)
			{
				
				if($this->login->_validate_password($users->login,$cur_pass))
				{
					//DOUBLE CHECK
					if($new_pass == $ver_pass)
					{
						$this->login->_generate_password($new_pass);
						$data['crypted_password'] = $this->login->get_password();
						$data['salt'] = $this->login->get_salt();
						$data['updated_at'] = NOW;
						
						$result = $this->M_users->update_users($data, $userId);
						
						if($result['status']){
							log_message('error','Password updated by: '.$this->user.'Success; Users Id: '.$userId);
							$this->session->set_flashdata('system_message','<div class="alert alert-danger">You password was successfully changed, this will take effect on your next login.</div>');
						}else{
							$this->session->set_flashdata('system_message','<div class="alert alert-danger">Something went wrong, please try again or contact the administrator.</div>');
						}
						redirect(current_url());
					}
					else
					{
						$this->session->set_flashdata('system_message','<div class="alert alert-danger">Your current password is wrong.</div>');
					}
				}
				else
				{
					$this->session->set_flashdata('system_message','<div class="alert alert-danger">Your current password is wrong.</div>');
					redirect(current_url());
				}
			}
		}
	}
	
	public function reset($employee_id = false)
	{
		$this->session_checker->secure_page('admin');
		
		if($employee_id == false)
		{
			show_404();
		}
		else
		{
			$this->load->library('login');
			
			$this->view_data['system_message'] = $this->session->flashdata('system_message');
			
			$users = $this->M_users->get_user_by_login($employee_id);
			
			$new_pass = trim($this->input->post('newpassword'));
			$ver_pass = trim($this->input->post('verifypassword'));
			
			if($_POST)
			{
				if($users)
				{
					//DOUBLE CHECK
					if($new_pass == $ver_pass)
					{
						$this->login->_generate_password($new_pass);
						$data['crypted_password'] = $this->login->get_password();
						$data['salt'] = $this->login->get_salt();
						$data['updated_at'] = NOW;
						
						$result = $this->M_users->update_users($data, $users->id);
						
						if($result['status']){
							log_message('error','Password updated by: '.$this->user.'Success; Users Id: '.$users->id);
							$this->session->set_flashdata('system_message','<div class="alert alert-danger">Password was successfully updated.</div>');
						}else{
							$this->session->set_flashdata('system_message','<div class="alert alert-danger">Something went wrong, please try again or contact the administrator.</div>');
						}
						redirect(current_url());
					}
					else
					{
						$this->session->set_flashdata('system_message','<div class="alert alert-danger">Your current password is wrong.</div>');
					}
				}
				else
				{
					$this->session->set_flashdata('system_message','<div class="alert alert-danger">User Id is not valid.</div>');
					redirect(current_url());
				}
			}
		}
	}
	
	
	
}