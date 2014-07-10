<?php

class MY_Controller Extends CI_Controller
{
	protected $layout_view = 'application';
	protected $content_view ='';
	protected $view_data = array();
	protected $userid;
	protected $disable_layout = FALSE;
	protected $disable_menus = FALSE;
	protected $disable_views = FALSE; //DISABLE THE LOADING OF VIEW - FOR AJAX PURPOSE DEC 11 2013
	
	public function __construct()
	{
		parent::__construct();
		
		$this->output->enable_profiler(FALSE);
		$this->load->model(array('M_companyinfo','M_sys_par','M_users'));
		$this->userid = $this->session->userdata('userid');
		$this->user = $this->M_users->get($this->session->userdata('userid'));
		$this->is_admin = $this->user ? $this->user->admin == 1 ? true : false : false;
		$this->companyinfo 	= $this->M_companyinfo->get_info();
		$this->syspar 	= $this->M_sys_par->get_sys_par();	
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
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
				echo $this->load->view('layouts/' . $this->layout_view, $this->view_data, TRUE);
			}else{
				echo $yield;
			}
		}else{
			echo $this->load->view($this->content_view, $this->view_data, TRUE);
		}
		
		//output profiler
		echo $output;
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

	function _msg($type = FALSE,$message = FALSE,$redirect = FALSE,$var_name = 'system_message')
	{
		$template = "";
		$type = strtolower(trim($type));
		switch($type)
		{
		 	case $type == 'e':
				$template = "<div class='alert alert-danger'><i class='fa fa-exclamation'></i>&nbsp; ".$message."</div>";
				
			break;
			case $type == 's':
				$template = "<div class='alert alert-success'><i class='fa fa-check'></i>&nbsp; ".$message."</div>";
			break;
			case $type == 'n':
				$template = "<div class='alert alert-info'><i class='fa fa-check'></i>&nbsp; ".$message."</div>";
			break;
			case $type == 'p':
				$template = $message;
			break;
			case $type === FALSE;
				$template = $message;
			break;
		}

		if($type AND $message AND $redirect)
		{
			$this->session->set_flashdata($var_name,$template);	
			redirect($redirect);
		}elseif($type AND $message AND $redirect == FALSE){
			return $template;
		}
		
		if($redirect == FALSE AND $message == FALSE AND $redirect == FALSE)
		{
			return $this->session->flashdata($var_name);
		}
	}
}

/* 
* End File MY_Controller.php
*/
