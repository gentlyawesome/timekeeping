<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excels extends MY_Controller {
	
	//ALL EXCEL MUST BE HERE
	
	public function __construct()
	{
		parent::__construct();
		$this->session_checker->open_semester();
		$this->session_checker->secure_page('All');
	}
	
	public function index(){
	
	}
	
	public function student_charges()
	{
		$this->load->Model(array('M_enrollments','M_fees'));
		
		$this->load->helper('my_dropdown');
		
		if($_POST){
			
			$year_id = $this->input->post('year_id');
			$course_id = $this->input->post('course_id');
			
			
			$param = array();
			$param[' AND full_paid <> '] = 1;
			if($year_id != ""){
				$param[' AND year_id = '] = $year_id;
				$param[' AND course_id = '] = $course_id;
			}
			
			$rs = $this->M_enrollments->get_all_updaid_enrollments(0,100, $param, $all = true);
			
			if($rs){
				
					$data = array();
					
					foreach($rs as $obj)
					{
						$data[] = $this->M_fees->get_enrollment_total_fees($obj->id); //GET FEE PROFILES
					}

					$this->load->library('../controllers/_the_downloadables');
					$this->_the_downloadables->_generate_student_charges2($data);					
				
			}else{
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger">No record found.</div>');
				redirect(current_url());
			}
			
		}
	}

	public function student_payments()
	{
		$this->load->Model(array('M_enrollments','M_fees','M_studentpayments'));
		
		$this->load->helper('my_dropdown');
		
		if($_POST){
			
			$year_id = $this->input->post('year_id');
			$course_id = $this->input->post('course_id');
			
			
			$param = array();
			$param[' AND full_paid <> '] = 1;
			if($year_id != ""){
				$param[' AND year_id = '] = $year_id;
				$param[' AND course_id = '] = $course_id;
			}
			
			$rs = $this->M_enrollments->get_all_updaid_enrollments(0,100, $param, $all = true);
			
			if($rs){
				
					$payments = false;
					
					foreach($rs as $obj)
					{
						$payments[$obj->id] = $this->M_studentpayments->get_payments_enrollment_id($obj->id);
					}

					$this->load->library('../controllers/_the_downloadables');
					$this->_the_downloadables->_generate_student_payments($rs, $payments);					
				
			}else{
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger">No record found.</div>');
				redirect(current_url());
			}
			
		}
	}
	
	public function student_deductions($page = 0)
	{
		$this->load->Model(array('M_enrollments','M_student_deductions'));
		
		$this->load->helper('my_dropdown');
		
		if($_POST){
			
			$year_id = $this->input->post('year_id');
			$course_id = $this->input->post('course_id');
			
			
			$param = array();
			if($year_id != ""){
				$param[' AND e.year_id = '] = $year_id;
				$param[' AND e.course_id = '] = $course_id;
			}
			
			$rs = $this->M_student_deductions->get_all_students_with_deduction(0,100, $param, true);
			
			if($rs){
				
					$data = false;
					
					foreach($rs as $obj)
					{
						$data[$obj->studid] = $this->M_student_deductions->get_student_deduction_byenrollment_id($obj->enrollment_id); //GET DEDUCTIONs
					}

					$this->load->library('../controllers/_the_downloadables');
					$this->_the_downloadables->_generate_student_deductions($rs, $data);					
				
			}else{
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger">No record found.</div>');
				redirect(current_url());
			}
			
		}
	}
	
	public function download_all_student_profile()
	{
		$this->session_checker->check_if_alive(); // check if session is valid		
		
		$this->load->helper('my_dropdown');
			
		if($_POST)
		{
			$this->load->model('M_enrollments');
			
			$year_id = $this->input->post('year_id');
			
			$course_id = $this->input->post('course_id');
			
			$param = false;
			
			if($year_id != ""){
				$param['enrollments.year_id = '] = $year_id;
				$param['enrollments.course_id = '] = $course_id;
			}
			
			$rs = $this->M_enrollments->get_all_student_profile_for_report($param);
			if($rs)
			{
				$this->load->library('../controllers/_the_downloadables');// include downloadables controller
				$this->_the_downloadables->_print_all_student_profiles($rs);// calls print method on downloadables controller
			}else
			{
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger">No record found.</div>');
				redirect(current_url());
			}
		}
	}
	
}