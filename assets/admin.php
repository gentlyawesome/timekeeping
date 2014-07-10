<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session_checker->open_semester();
		$this->session_checker->secure_page(array('admin'));
		$this->load->helper(array('url_encrypt'));
	}

	public function index(){
		// $this->load->model('M_users');
		// $this->load->library(array('form_validation'));
		// $this->load->helper(array('url','form'));
		// $this->load->library(array('form_validation','login'));		
		
		// $password = "angkulitmotlga";
		// $hash_salt = sha1(md5(rand(100000,999999)).rand(100000,999999).time());
		// $hash_password = $this->login->_generate_password($password);
		// $this->dump($this->login->get_password());
		// $this->dump($this->login->get_salt());
		// vp($this->user_menus);
	}
	
	public function fix_users_table()
	{
		//FIX THE USERS : UPDATE DEPARTMENT FIELD
		$this->load->model('M_users');
		$rs = $this->M_users->fix_users_table();
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		if($rs)
		{
			$this->session->set_flashdata('system_message', '<div class="alert alert-success">Table successfully updated.</div>');
			redirect('admin');
		}
		else
		{
			$this->session->set_flashdata('system_message', '<div class="alert alert-success">No affected rows.</div>');
		}
	}
	
}
?>
