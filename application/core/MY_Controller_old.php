<?php

class MY_Controller Extends CI_Controller
{
	
	protected $layout_view = 'application';
	protected $content_view ='';
	protected $view_data = array();
	protected $user;
	protected $userid;
	protected $student;
	protected $current_grading_period;
	protected $user_menus = array();
	protected $disable_layout = FALSE;
	protected $disable_menus = FALSE;
	protected $disable_views = FALSE; //DISABLE THE LOADING OF VIEW - FOR AJAX PURPOSE DEC 11 2013
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->output->enable_profiler(TRUE);
		$this->load->model(array('M_settings','M_menus','M_users','M_open_semesters','M_grading_periods'));
		$this->user = $this->session->userdata('userType');
		$this->userid = $this->session->userdata('userid');
		$this->setting 	= $this->M_settings->get_settings();	
		$this->user_menus = $this->M_menus->get_all_menus($this->user);
		$this->open_semester = $this->M_open_semesters->get_current_semester();	
		$this->current_grading_period = $this->M_grading_periods->get_current_grading_period();	
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		$this->view_data['user_menus'] = $this->user_menus;
		
		$this->load_enrollment_data(); //Load enrollment data if logged in
	}
	
	public function load_enrollment_data()
	{
		if(!isset($this->session->userdata['userid']) || empty($this->session->userdata['userid'])) //CHECK IF ALIVE
		{}
		else{
			$this->load->model('M_enrollments');
			$this->student = $this->M_enrollments->profile_by_user_id($this->session->userdata['userid']);
		}
	}
	
	public function _output($output)
    {
        if($this->content_view !== FALSE && empty($this->content_view)){
			$this->content_view = $this->router->class . '/' . $this->router->method;
        }
		
		
        $yield = file_exists(APPPATH . 'views/' . $this->content_view . EXT) ? $this->load->view($this->content_view, $this->view_data, TRUE) : FALSE ;
        
		if($this->disable_layout == FALSE)
		{
			
			if($this->layout_view)
			{
				$this->view_data['yield'] = $yield;
				$this->view_data['disable_menus'] = $this->disable_menus;
				if($this->disable_views == false){
					echo $this->load->view('layouts/' . $this->layout_view, $this->view_data, TRUE);
				}
			}else{
				//if($this->disable_views == false){
					echo $yield;
				//}
			}
		}else{
			if($this->disable_views == false){
				echo $this->load->view($this->content_view, $this->view_data, TRUE);
			}
		}
		
		if($this->disable_views == false){
			//output profiler
			echo $output;
		}
    }
	
	function issue_count($user_id)
	{
	  $count = 0;
		$this->load->model(array('M_issues'));
	  // Count Issues
	  $issues = $this->M_issues->count_all_by_user_id($user_id);
	  if (!empty($issues)) {
	    $count += intval($issues) ;
	  }
	  
	  $this->view_data['total_issues'] = $count;
	}
	
	function pagination_style()
	{
	    // Style
	  $config['full_tag_open'] = '<ul class="pagination">';
      $config['full_tag_close'] = '</ul>';
      $config['prev_link'] = '&lt; Prev';
      $config['prev_tag_open'] = '<li>';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = 'Next &gt;';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';
      $config['first_link'] = FALSE;
      $config['last_link'] = FALSE;
      
      return $config;
      
	}
}

/* 
* End File MY_Controller.php
*/
