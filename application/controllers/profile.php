<?php
	
class Profile Extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form','my_dropdown','url_encrypt'));
		$this->load->library(array('form_validation'));
		$this->load->model(array('M_settings','M_enrollments', "M_issues",'M_student_subjects'));
		$this->session_checker->open_semester();
		
	}
	
	public function index()
	{
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		$this->session_checker->check_if_alive();
		$rs = $this->M_enrollments->get_open_enrollment($this->student->login);
		
		if($rs)
		{
			redirect('profile/view/'.$rs->id);
		}
		else
		{
			//$this->session->set_flashdata('system_message', '<div class="alert alert-danger">You dont have an existing enrollment record. Please contact your school admin.</div>');   
		}
	}
	
	public function view($id = false)
	{
		if($id == false) { show_404(); }
		$this->session_checker->secure_page('student'); 
		$this->view_data['form_token'] = $this->token->get_token();
		$this->view_data['employeid'] = $id;
		$data =$id;
		
		if($this->input->post('update_data') !== false)
		{
			
			if($this->form_validation->run('update_student_profile') !== FALSE)
			{
			
			$profile_id = $this->input->post('profile_id');
			$enrollment_id = $data = $this->input->post('enrollment_id');
			$form_token = $this->input->post('form_token');
			
			$for_enrollment_table = array
			(
				'course_id' => $this->input->post('course'),
				'status' => $this->input->post('student_type'),
				'semester_id' => $this->input->post('semester'),
				'year_id' => $this->input->post('year'),
				'sy_from' => $this->input->post('sy_from'),
				'sy_to'  => $this->input->post('sy_to')
			);
			
			$for_profile_table = array
			(
				'first_name' => $this->input->post('first_name'),
				'middle_name' => $this->input->post('middle_name'),
				'last_name'  => $this->input->post('last_name'),
				'civil_status' => $this->input->post('civil_status'),
				'date_of_birth' => $this->input->post('date_of_birth'),
				'place_of_birth' => $this->input->post('place_of_birth'),
				'age' => $this->input->post('age'),
				'disability' => $this->input->post('disability'),
				'nationality' => $this->input->post('nationality'),
				'religion' => $this->input->post('religion'),
				'mobile' => $this->input->post('mobile'),
				'email' => $this->input->post('email'),
				'present_address' => $this->input->post('present_address'),
				'father_name' => $this->input->post('father_name'),
				'father_occupation' => $this->input->post('father_occupation'),
				'father_contact_no' => $this->input->post('father_contact_no'),
				'mother_name' => $this->input->post('mother_name'),
				'mother_occupation' => $this->input->post('mother_occupation'),
				'mother_contact_no' => $this->input->post('mother_contact_no'),
				'parents_address' => $this->input->post('parents_address'),
				'guardian_name' => $this->input->post('guardian_name'),
				'guardian_relation' => $this->input->post('guardian_relation'),
				'guardian_contact_no' => $this->input->post('guardian_contact_no'),
				'guardian_address' => $this->input->post('guardian_address'),
				'elementary' => $this->input->post('elementary'),
				'elementary_address' => $this->input->post('elementary_address'),
				'elementary_date'  => $this->input->post('elementary_date'),
				'secondary' => $this->input->post('secondary'),
				'secondary_address' => $this->input->post('secondary_address'),
				'secondary_date' => $this->input->post('secondary_date'),
				'tertiary' => $this->input->post('tertiary'),
				'tertiary_address' => $this->input->post('tertiary_address'),
				'tertiary_date' => $this->input->post('tertiary_date'),
				'tertiary_degree' => $this->input->post('tertiary_degree'),
				'vocational' => $this->input->post('vocational'),
				'vocational_address' => $this->input->post('vocational_address'),
				'vocational_date' => $this->input->post('vocational_date'),
				'vocational_degree' => $this->input->post('vocational_degree'),
				'others' => $this->input->post('others'),
				'others_address' => $this->input->post('others_address'),
				'others_date' => $this->input->post('others_date'),
				'others_degree' => $this->input->post('others_degree')
			);
			
				if($this->token->validate_token($form_token) == true)
				{
					if($this->M_enrollments->update_table($for_enrollment_table,$enrollment_id) == true)
					{
						$this->load->model('M_profiles');
						if($this->M_profiles->update_table($for_profile_table,$profile_id) == true)
						{
							log_message('info','Update Student profile by: '.$this->user. '; Profile Id: '.$profile_id.'; Enrollment Id: '.$enrollment_id);
							$this->token->destroy_token();
							$this->view_data['system_message'] = '<div class="alert alert-success">Update was successfull</div>';
						}else
						{
							log_message('error','Update Student profile by: '.$this->user. ';FAILED Profile Id: '.$profile_id.';');
							$this->view_data['system_message'] = '<div class="alert alert-danger">Update Profile table failed</div>';
						}
					}else
					{	
						log_message('error','Update Enrollment Table by: '.$this->user. ';FAILED Enrollment Id: '.$enrollment_id.';');
						$this->view_data['system_message'] = '<div class="alert alert-danger">Update Enrollment table failed</div>';
					}
				}else{
					 $this->view_data['system_message'] = '<div class="alert alert-danger">Invalid Form Submit</div>';
				}
				
			}
		}
		
		if($data !== NULL)
		{
			$this->load->model(array('M_years','M_semesters','M_courses','M_student_subjects','M_student_totals'));
			$this->view_data['student_profile'] = $this->view_data['student'] = $p = $this->M_enrollments->profile($data); // student profile
			
			$this->view_data['subjects']	 = $subjects =  $this->M_student_subjects->get_studentsubjects($data);
			$this->view_data['subject_units'] =  $this->M_student_subjects->get_studentsubjects_total($subjects);
			// vd($p);
			$this->view_data['course'] = $p->course_id;
			$this->view_data['year'] = $p->year_id;
			$this->view_data['semester'] = $p->sem_id;
			$this->view_data['enrollment_id'] = $p->id;
			
			// Count Issues
			$this->issue_count($p->user_id);
			
			//CHECK IF ENROLLMENT DELETED
			if($p && $p->is_deleted == 1)
			{
				$this->session->set_flashdata('system_message', '<div class="alert alert-success">You have been redirect because the previous enrollment that you viewed was deleted. Please set another enrollment to view.</div>');
				redirect('sem_and_school_year');
			}
	
		}else{
			show_404();
		}
	}
}
