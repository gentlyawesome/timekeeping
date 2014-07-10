<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->session_checker->check_if_alive();
	}
	
	public function index()
	{
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */