<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main Extends MY_Enrollment
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('erollment_session');
	
	
	
	}
	public function index()
	{
		$this->token->set_token();
		$this->view_data['form_token'] = $this->token->get_token();
		if($this->input->post('start_enrollment') !== false)
		{
			if($this->token->validate_token($this->input->post('form_token')))
			{
				switch($status = $this->input->post('status',TRUE))
				{
					case strtolower($status) == 'new':
						$this->enrollment_session->start('new');
						redirect('enrollment/new');
					break;
					case strtolower($status) == 'old':
						if($status && $this->input->post('studid'))
						{
							
						}
						
					break;
					case strtolower($status) == 'returnee':
						$this->enrollment_session->start('returnee');
						redirect('enrollment/new');
					break;
					case strtolower($status) == 'transferee':
						$this->enrollment_session->start('transferee');
						redirect('enrollment/new');
					break;
					case strtolower($status) == 'cross':
						$this->enrollment_session->start('cross');
						redirect('enrollment/new');
					break;
					default:
						
					break;
				}
				
			}else
			{	
				$this->token->destroy_token();
				$this->view_data['system_message'] = '<span class="alert alert-danger" style="padding:5px 10px;">Invalid Form Submit</span>';
			}
		}
	}
}