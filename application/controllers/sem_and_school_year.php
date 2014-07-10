<?php
	
class Sem_and_school_year Extends MY_Controller
{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper(array('url','form','my_dropdown','url_encrypt'));
			$this->load->library(array('form_validation'));
			$this->load->model(array('M_settings','M_enrollments', "M_issues"));
			$this->session_checker->open_semester();
		}
		
		public function index()
		{
			$this->view_data['system_message'] = $this->session->flashdata('system_message');
			$this->session_checker->check_if_alive();	
		
			$this->view_data['enrollments'] = $enrollments = $this->M_enrollments->get_all_student_enrollments($this->student->login);
			
			if($enrollments == false)
			{
				  $this->session->set_flashdata('system_message', '<div class="alert alert-danger">You dont have an existing enrollment record. Please contact your school admin.</div>');
			}
			
			if($_POST)
			{
				$id = $this->input->post('radio_select');
				if($id)
				{
					// vp($this->student->login);
					$this->M_enrollments->reset_enrollment_is_used($this->student->login);
					$data['is_used'] = 1;
					$rs = $this->M_enrollments->update_enrollments($data,$id); //RESET EN
					
					$this->session->set_flashdata('system_message', '<div class="alert alert-success">Default Sem and School year was successfully changed.</div>');
					redirect(current_url());
				}
			}
		}
		
}