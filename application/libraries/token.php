<?php

class token
{
	private $ci;
	public function __construct()
	{
		$this->ci =& get_instance();
	}
	
	public function set_token()
	{	
		
		if($this->get_token() == NULL OR $this->get_token() == FALSE OR $this->get_token() == '')
		{
			$this->ci->session->set_userdata('form_token',$this->random_hash());
		}
	}
	
	public function random_hash()
	{
		$string = time().rand(1000,9999).sha1(rand(1000,9999)); 
		return hash('sha256',$string).sha1($string).sha1($string);
	}
	
	public function get_token()
	{
		return $this->ci->session->userdata('form_token');
	}
	
	
	public function validate_token($token)
	{
		return $this->ci->session->userdata('form_token') == $token ? TRUE : FALSE;
		
	}

	public function destroy_token()
	{
		$this->ci->session->set_userdata('form_token','');
	}
}