<?php

class Login
{
	private $ci;
	private $sitekey = ''; //global site salt
	private $stretch = 1;  // number of times salt and hashed will be digested or mixed
	
	private $salt; //holder for hashed salt
	private $password; // holder for hashed password
	
	public function __construct()
	{
		$this->ci =& get_instance();
	}
	
	// create a hashed salt called from generate_password
	private function _hash_salt()
	{
		return sha1(md5(rand(100000,999999)).rand(100000,999999).time());
	}
	
	// creates hashed password called from generate_password
	// algorithm derived from restul authentication
	private function _hash_password($password,$salt)
	{
		return $this->pwcrypt($password,$salt,$this->sitekey,$this->stretch);
	}
	
	private function pwcrypt($password, $salt, $sitekey,$stretch)
	{
	  $digest = $sitekey;
	  $i = 0;
	  while ($i < $stretch)
	  {
		$digest = sha1($digest.'--'.$salt.'--'.$password.'--'.$sitekey);
		$i++;
	  }
	  return $digest;
	}
	
	//generates password when registering or enrolling
	public function _generate_password($password)
	{
		$this->salt = $this->_hash_salt();
		$this->password = $this->_hash_password($password,$this->salt);
	}
	
	
	//returns the hashed password after calling _generate_password
	public function get_password()
	{
		return $this->password;
	}
	
	//returns the hashed salt after calling _generate_password
	public function get_salt()
	{
		return $this->salt;
	}
	
	//validates login user name and password
	public function _validate_password($loginName,$password)
	{
		 // load model
		$this->ci->load->model('m_login','l');
		 
		 //returns crypted_password and salt from database
		$data = $this->ci->l->get_login_credentials($loginName);
		//if crytped_password is == entered password return user_id else false
		if($data !== false)
		{
			return $data->crypted_password == $this->_hash_password($password,$data->salt) ? $data->id : FALSE;
		}else{
			return FALSE;
		}
	}
}