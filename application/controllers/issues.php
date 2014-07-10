<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Issues extends MY_Controller {
  
	public function __construct(){
		parent::__construct();
		$this->session_checker->open_semester();
		$this->load->helper(array('url_encrypt'));
		$this->load->model(array('M_issues'));
	}
	
	public function view($id, $user_id)
	{
	  
	  $this->load->model(array("M_issues", "M_enrollments"));
	  
	  //Top header data of student
		$this->view_data['student'] = $p = $this->M_enrollments->profile($id);
		$this->view_data['enrollment_id'] = $id;
		
	  $this->view_data['issues'] = $issues =  $this->M_issues->get_all_by_user_id($user_id);
	  
	  
	  // Count Issues
	  $this->issue_count($p->user_id);
	}
	
	public function view_issues($id, $user_id) //FOR CUSTODIAN
	{
	  
	  $this->load->model(array("M_issues", "M_enrollments"));
	  
	  //Top header data of student
		$this->view_data['student'] = $p = $this->M_enrollments->profile($id);
		$this->view_data['enrollment_id'] = $id;
		
	  $this->view_data['issues'] = $issues =  $this->M_issues->get_all_by_user_id($user_id);
	  
	  
	  // Count Issues
	  $this->issue_count($p->user_id);
	}
	
	// Create
	public function create($enrollment_id, $user_id)
	{
		
		$this->view_data['issue'] = FALSE;
		$this->view_data['user_id'] = $user_id;
		$this->view_data['enrollment_id'] = $enrollment_id;
		
		
		if($_POST)
		{
			$data = $this->input->post('issues');
			$data['comment'] = $this->input->post('issue_comment');
			$data['resolved'] = $this->input->post('issue_resolved');
			$data['user_id'] = $user_id;
			$data['issued_by'] = strtoupper($this->session->userdata['userType']);
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');
			
			$result = $this->M_issues->create_issues($data);
			if($result['status'])
			{
				log_message('error','Issue Created by: '.$this->user.'Success; User Id: '.$id);
				$this->session->set_flashdata('system_message', '<div class="alert alert-success">Issue successfully added.</div>');
				redirect('issues/view/'.$enrollment_id.'/'.$user_id);
			}
		}
	}
	
	
	// Update
	public function edit($id, $enrollment_id)
	{
	
		$this->view_data['issues'] = $issue =  $this->M_issues->get_issues($id);
		$this->view_data['user_id'] = $issue->user_id;
		$this->view_data['enrollment_id'] = $enrollment_id;
		
		if($_POST)
		{
			$data = $this->input->post('issues');
			$data['user_id'] = $user_id;
			$data['issued_by'] = strtoupper($this->session->userdata['userType']);
			$data['updated_at'] = date('Y-m-d H:i:s');
			
			$result = $this->M_issues->update_issues($data, $id);
			
			if($result['status'])
			{
				log_message('error','issues Updated by: '.$this->user.'Success; issues Id: '.$id);
				$this->session->set_flashdata('system_message', '<div class="alert alert-success">Issue successfully updated.</div>');
				redirect('issues/view/'.'/'.$issue->user_id);
			}
		}
	}
	
	// Update
	public function destroy($id, $enrollment_id)
	{
		$issue =  $this->M_issues->get_issues($id);
		$user_id = $issue->user_id;
		$result = $this->M_issues->delete_issues($id);
		log_message('error','issues Deleted by: '.$this->user.'Success; issues Id: '.$id);
		$this->session->set_flashdata('system_message', '<div class="alert alert-success">Issue successfully deleted.</div>');
		redirect('issues/view/'.$enrollment_id.'/'.$user_id);
	}
}
