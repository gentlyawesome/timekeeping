<?php
	
class Grade Extends MY_Controller
{
		public function __construct()
		{
			parent::__construct();
			$this->load->model(array('M_enrollments', 'M_student_grades', 'M_issues'));
			$this->session_checker->open_semester();
		}
		
		public function index()
		{
			$this->view_data['system_message'] = $this->session->flashdata('system_message');
			$this->session_checker->check_if_alive();
			$rs = $this->M_enrollments->get_open_enrollment($this->student->login);
			
			if($rs)
			{
				redirect('grade/view/'.$rs->id);
			}
			else
			{
				   $this->session->set_flashdata('system_message', '<div class="alert alert-danger">You dont have an existing enrollment record. Please contact your school admin.</div>');
			}
		}
		
		public function view($id)
		{
		  $this->view_data['student'] = $p = $this->M_enrollments->profile($id);
		  $this->view_data['student_grades'] = $this->M_student_grades->get_student_grades($id);
		  
		  // Count Issues
	          $this->issue_count($p->user_id);

		 // Grade Editing
		if($_POST)
		{
			$sgc_id = $this->input->post('sgc_id');
			$data['value'] = $this->input->post('value');
			$data['updated_at'] = date('Y-m-d H:i:s');
			
			$result = $this->M_student_grades->update_student_grade_category($data, $sgc_id);
			$return['new_value'] = $result['value'];
			
			echo json_encode($return);
		}
		}
}
