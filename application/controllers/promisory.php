<?php
	
class Promisory Extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','form','my_dropdown','url_encrypt'));
		$this->load->library(array('form_validation'));
		$this->load->model(array('M_settings',
		'M_enrollments', 
		"M_studentpromisory",
		'M_student_subjects',
		'M_grading_periods',
		'M_studentpayments_details',
		'M_student_total_file'));
		$this->session_checker->open_semester();
		
	}
	
	public function index($enrollment_id = false)
	{
		if($enrollment_id == false){ show_404(); }
		$this->view_data['employeid'] = $enrollment_id;
		$this->view_data['student_profile'] = $this->view_data['student'] = $p = $this->M_enrollments->profile($enrollment_id); // student profile
		
		// Count Issues
		$this->issue_count($p->user_id);
		
		$this->view_data['enrollment_id'] = $enrollment_id;
		
		$this->view_data['promisory'] = $this->M_studentpromisory->get_all($enrollment_id);
		
		$this->view_data['current_period'] = $this->current_grading_period;
		
		$this->view_data['student_total'] = $this->M_student_total_file->get_student_total_file($enrollment_id);
		
		$this->view_data['payment_details'] = $this->M_studentpayments_details->get_record_by_enrollment_id($enrollment_id);
	}
	
	public function create($studentpayments_details_id = false, $enrollment_id = false){
		
		if($studentpayments_details_id == false) { show_404(); }
		if($enrollment_id == false) { show_404(); }
		
		$this->view_data['enrollment_id'] = $enrollment_id;
		
		$this->view_data['current_period'] = $this->current_grading_period;
		
		if($_POST)
		{
			$date = $this->input->post('date');
			$promisory = $this->input->post('promisory');
			
			if($date && $promisory)
			{
				$data['date'] = $date;
				$data['promisory'] = $promisory;
				$data['studentpayment_details_id'] = $studentpayments_details_id;
				$data['enrollment_id'] = $enrollment_id;
				$data['created_at'] = NOW;
				$data['updated_at'] = NOW;
				
				$rs = $this->M_studentpromisory->create_record($data);
				
				if($rs['status'])
				{
					$for_promisory['is_promisory'] = 1;
					$for_promisory['studentpromisory_id'] = $rs['id'];
					$for_promisory['updated_at'] = NOW;
					$rs_upd = $this->M_studentpayments_details->update_record_by_id($for_promisory, $studentpayments_details_id);
					
					//UPDATE CURRENT PAYMENT DETAILS : FOR NEXT PAYMENT DETAILS
					$payment_details = $this->M_studentpayments_details->get_record_by_enrollment_id($enrollment_id);
					
					$this->M_studentpayments_details->reset_current();
					
					foreach($payment_details as $obj)
					{
						//GET FIRST DETAIL WITH BALANCE
						if(floatval($obj->amount_paid) <= 0 && $obj->is_promisory == 0){
							$upd['is_current'] = 1;
							$this->M_studentpayments_details->update_record_by_id($upd, $obj->id);
							break;
						}
					}
					
					log_message('error','Promisory Created by: '.$this->user.'Success; Promisory Id: '.$rs['id']);
					$this->session->set_flashdata('system_message', '<div class="alert alert-success">Promisory successfully added.</div>');
					redirect('promisory/index/'.$enrollment_id);
				}
			}
			else
			{
					$this->session->set_flashdata('system_message', '<div class="alert alert-danger">All fields are required.</div>');
					redirect(current_url());
			}
		}
	}
	
	public function edit($id = false, $enrollment_id = false)
	{
		if($id == false) { show_404(); }
		if($enrollment_id == false) { show_404(); }
		
		$this->view_data['current_period'] = $this->current_grading_period;
		
		$this->view_data['promisory'] = $this->M_studentpromisory->get($id);
		
		$this->view_data['enrollment_id'] = $enrollment_id;
	}
	
	public function view($enrollment_id = false)
	{
		if($enrollment_id == false){ show_404(); }
		$this->view_data['employeid'] = $enrollment_id;
		$this->view_data['student_profile'] = $this->view_data['student'] = $p = $this->M_enrollments->profile($enrollment_id); // student profile
		
		// Count Issues
		$this->issue_count($p->user_id);
		
		$this->view_data['promisory'] = $this->M_studentpromisory->get_all($enrollment_id);
		
		$this->view_data['current_period'] = $this->M_grading_periods->get_current_grading_period();
		
		$this->view_data['student_total'] = $this->M_student_total_file->get_student_total_file($enrollment_id);
		
		$this->view_data['payment_details'] = $this->M_studentpayments_details->get_record_by_enrollment_id($enrollment_id);
	}
}
