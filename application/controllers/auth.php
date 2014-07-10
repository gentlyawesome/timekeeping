<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('M_users','M_captcha'));
		$this->load->library(array('form_validation'));
		$this->load->helper(array('url','form','my_dropdown'));
	}

	function login()
	{
		$this->layout_view = 'welcome';
		$this->load->library(array('form_validation','login'));		
		
		#region CREATE CAPTCHA
		$this->load->helper('random_string');
		$this->load->helper('captcha');
		$vals = array(
			'img_path'	 => 'assets/captcha/',
			'img_url'	 => base_url().'assets/captcha/',
			'font_path'  => 'assets/fonts/comicbd.ttf',
			'font_size'	=> '8',
			'word'  => create_random_string(),
			'img_width'	 => '220',
  			'img_height' => 35,
		);
		$cap = create_captcha($vals);
		
		$data = array(
			'captcha_time'	=> $cap['time'],
			'ip_address'	=> $this->input->ip_address(),
			'word'	 => 	$cap['word'],
			);
		
		$this->load->model('M_captcha');
		$rs = $this->M_captcha->insert($data, true);
		
		$this->view_data['cap_image'] = $cap['image'];
		#endregion
		
		if($_POST)
		{
			$this->view_data['login'] = $this->input->post('login');
			
			$this->form_validation->set_rules('login', 'login', 'required|strip_tags|htmlspecialchars');
			$this->form_validation->set_rules('password', 'password', 'required|strip_tags|htmlspecialchars');
			$this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_validate_captcha');

			if($this->form_validation->run() !== FALSE)
			{
				$val = $this->login->_validate_password($_POST['login'],$_POST['password']);
			
				if($val == FALSE)
				{
					$this->session->set_flashdata('system_message','<div class="alert alert-danger">Invalid employee id / password Combination</div>');
					redirect(current_url());
				}
				else
				{
					$this->session->set_flashdata('system_message','<div class="alert alert-success">You have successfully login.</div>');
					$this->verify_user($val);
				}
			}
		}
	}
	
	public function validate_captcha()
	{
		$cap = $this->input->post('captcha');
		$ip = $this->input->ip_address();
		
		$expiration = time()-7200; // Two hour limit
		$this->M_captcha->delete_recent($expiration);

		$rs = $this->M_captcha->check_captcha($cap, $ip, $expiration);
		
		if($rs == false)
		{
			$this->form_validation->set_message('validate_captcha', 'Wrong captcha code. Please try again.');
			return false;
		}
        return true;
	}

    function logout()
    {
        $this->session->sess_destroy();
		redirect('');
    }
	
	public function verify_user($id=FALSE)
	{
		$this->session_checker->verify_user($id);
	}
}