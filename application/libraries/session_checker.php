<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
checks and validates session
*/
class Session_checker
{
	private $ci;
	
	public function __construct()
	{

		$this->ci =& get_instance();
	}
	
	
	public function open_semester()
	{
		$this->ci->load->model('M_open_semesters');
		if(isset($this->ci->session->userdata['userid']) || !empty($this->ci->session->userdata['userid']))
		{
			$id = $this->ci->session->userdata['userid'];
		}	
	}
	
	public function verify_user($id)
	{
		if(empty($id) or ctype_digit($id) == FALSE)
		{
			redirect(base_url());
		}else{
			$this->ci->load->model('M_users');
			$user = $this->ci->M_users->get_profile($id);

			if($user){
				redirect('home');
			}else{
				redirect(base_url());
			}
		}	
	}
	
	
	public function check_if_alive($check = false)
	{
		if($check == false)
		{
			if(!isset($this->ci->session->userdata['userid']) || empty($this->ci->session->userdata['userid']))
			{
				redirect('auth/logout');
			}
		}else{
			if(!isset($this->ci->session->userdata['userid']) || empty($this->ci->session->userdata['userid']))
			{
				return FALSE;
			}else{
				return TRUE;
			}
		}
	}
	
	/*
	* secure_page
	* secure specific controller or method by letting only specific usertypes access it
	* usertype : admin/user
	*/
	public function secure_page($usertype)
	{
		if($this->check_if_alive(true))
		{
			if($usertype == "admin"){
				if($this->ci->session->userdata('is_admin') == 0){

					$this->ci->_msg('e','You are not allowed to access that page.','home');
				}
			}

			if($usertype == 'user'){
				if($this->ci->session->userdata('is_admin') == 1){
					$this->ci->_msg('e','You are not allowed to access that page.','home');
				}	
			}
			
			return TRUE;
		}
		else
		{
			show_404();
		}
	}
	









}
