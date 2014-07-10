<?php 

class enrollment_session
{
	private $ci;
	
	public function __construct()
	{
		$this->ci =& get_instance();
	}
	
	public function start($string = false)
	{
		// Start enrollment session
		$token = $this->ci->token->random_hash();
		$this->ci->session->set_userdata('enrollment_type',$string);
		$this->ci->session->set_userdata('enrollment_token',$token);
	}
	
	public function end()
	{
		// end enrollment sessions
		$this->ci->session->set_userdata('enrollment_type','');
		$this->ci->session->set_userdata('enrollment_token','');
	}
	
	public function get_esession()
	{
		// return enrollment session type
		return $this->ci->session->userdata('enrollment_type');
	}
	
	public function get_etoken()
	{
		// return token for enrollment 
		return $this->ci->session->userdata('enrollment_token');
	}
	
	public function validate_etoken($token)
	{
		// validate enrollment token session 
		$salt = $this->ci->config->item('encryption_key');
		return hash('sha256',$token.$salt) == hash('sha256',$this->ci->session->userdata('etoken').$salt);
	}
	
	public function check_enrollment()
	{
		//if enrollment token and enrollment type is not set
		if($this->get_etoken()== false AND $this->get_esession() == false)
		{
			// check if we are on the main page enrollment/main
			
			if(($this->ci->uri->segment(1) == 'enrollment' AND $this->ci->uri->segment(2) == NULL) OR ($this->ci->uri->segment(1) == 'enrollment' AND $this->ci->uri->segment(2) == 'main'))
			{
				// make sure that enrollment session and enrollment token is empty
				$this->end();	
			}else{
				// if not on the mainpage redirect to main page
				redirect('enrollment');
			}
		}else{
			/*
			*	if not false get_etoken and get_esession then enrollment has began
			*	Redirect user to enrollment type
			*/
			if($this->ci->uri->segment(1) == 'enrollment' AND $this->ci->uri->segment(2) == $this->get_esession())
			{
			}else{
				redirect('enrollment/'.$this->get_esession());
			}
		}
	}
}