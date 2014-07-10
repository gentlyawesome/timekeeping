<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_and_events extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session_checker->open_semester();
		$this->session_checker->secure_page('all');
	}
	
	public function index()
	{
		$this->load->model(array('M_announcements','M_events'));
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		$filter = 'announcements.to_all = 1';
		$filter2 = 'events.to_all = 1';
		if(strtolower($this->session->userdata['userType']) == "student")
		{
			$filter .= ' OR announcements.to_student = 1 ';
		}else{
			$filter .=  ' OR announcements.to_employee = 1 ';
		}
		
		$this->view_data['news'] = $news = $this->M_announcements->find(0,30, $filter, false);
		
		$this->view_data['events'] = $news = $this->M_events->find(0,30, $filter2, false);
	}
	

}