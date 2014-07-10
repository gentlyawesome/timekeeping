<?php

class Registration Extends MY_Controller
{
	public function __construct(){
		parent::__construct();
		$this->session_checker->open_semester();
		$this->load->helper(array('url_encrypt'));
		$this->load->model(array('M_open_semesters','M_enrollments','M_enrollment_process','M_temp_start','M_grading_periods','M_student_previous_accounts','M_temp_enrollments'));
		$this->load->helper(array('my_dropdown'));
	}
	
	public function check_student_has_existing_enrollment_already($studid)
	{
		$this->load->model(array('M_enrollments'));
		$en = $this->M_enrollments->get_current_enrollment($studid);
	
		if($en){
			redirect('registration/check_enrollment');
		}
	}
	
	public function check_enrollment()
	{
		//Viewing purpose only
	}
	
	public function check_if_student_existing($studid){
		$en = $this->M_enrollments->get_enrollments_by_studid($studid);
		if($en)
		{}
		else{
			$this->session->set_flashdata('system_message', "<div class='alert alert-danger'>Student ID Doesn't Exist.</div>");
			redirect('student');
		}
	}

	public function index($par = false)
	{
		$this->session_checker->check_if_alive();
		
		$this->load->helper(array('my_dropdown'));
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		$this->view_data['back_url'] = "#";
		
		//GET OPEN SEMESTER
		$this->view_data['open_enrollment'] = $open = $this->M_open_semesters->get_ay_sem();
		$this->view_data['student'] = $this->student;
		$this->view_data['process'] = "START";
		
		if($open->open_enrollment == 1)
		{
			$this->check_student_has_existing_enrollment_already($this->student->studid);
			
			if($par != 'back'){
				$this->check_if_there_is_unfinish_enrollment();
			}
			
			if($_POST)
			{
				$submit = $this->input->post('submit');
				$course_id = $this->input->post('course_id');
				$year_id = $this->input->post('year_id');
				
				//SAVE FIRST PROCESS TO TEMP_START TABLE
				$data['studid'] = $this->student->studid;
				$data['course_id'] = $course_id;
				$data['year_id'] = $year_id;
				$data['type'] = strtolower($submit);
				
				$this->M_temp_start->delete_temp_start_by_studid($this->student->studid); //RESET TABLE
				$rs = $this->M_temp_start->insert($data);
				
				if($rs)
				{
					redirect('registration/continue_registration/'.$rs['id']);
				}
			}
		}
	}
	
	public function check_if_there_is_unfinish_enrollment()
	{
		$this->load->model(array('M_temp_start'));
		
		$temp_start = $this->M_temp_start->get_temp_start($this->student->studid);
		
		if($temp_start)
		{
			redirect('registration/continue_recent_enrollment/'.$temp_start->id);
		}
	}
	
	public function continue_recent_enrollment($id)
	{
		$this->load->model(array('M_temp_start'));
		
		$this->view_data['temp_start'] = $temp_start = $this->M_temp_start->get_temp_start($this->student->studid);
		
		if($_POST)
		{
			if(isset($_POST['continue']))
			{
				//CHECK WHERE THE USER STOPPED IN THE REGISTRATION
				$this->validate_temporary_tables($id);
				
			}
			if(isset($_POST['start']))
			{
				//RESET ALL TEMPORARY TABLES AND GO TO INDEX
				$this->reset_all_temp_tables($temp_start->id);
				redirect('registration');
			}
		}
	}
	
	public function continue_registration($id =false)
	{
		if($id == false) { show_404(); }
		
		$this->load->model(array('M_course_blocks','M_block_subjects','M_temp_student_subjects','M_subjects'));
		
		$this->view_data['open_enrollment'] = $open = $this->M_open_semesters->get_ay_sem();
		$this->view_data['student'] = $this->student;
		$this->view_data['process'] = "REGISTRATION";
		$this->view_data['disable_lasten'] = true;
		$this->view_data['back_url'] = base_url().'registration/index/back';
		
		$this->view_data['start'] = $data = $this->M_temp_start->get($id);
		
		if($data)
		{
			if($data->type == 'block'){
				//GET BLOCK SECTIONS OFFERED IN THE CURRENT SEMESTER
				$year_id = $data->year_id;
				$course_id = $data->course_id;
				
				$this->view_data['course_blocks'] = $course_blocks = $this->M_course_blocks->get_current_course_blocks($course_id, $year_id);
				
				$blocks = array();
				
				if($this->view_data['course_blocks']){
					foreach($this->view_data['course_blocks'] as $value){
						$blocks[$value->block_system_setting_id] = $this->M_block_subjects->get_block_subjects($value->block_system_setting_id);
					}
				}
				
				$this->view_data['block_subjects'] = $blocks;
				
				if($_POST)
				{
					$block_id = $this->input->post('course_blocks');
					if(isset($block_id) && $block_id != "")
					{
						if(isset($blocks[$block_id]))
						{
							$s = $blocks[$block_id];
							$this->M_temp_student_subjects->reset_student_subjects($id);
							foreach($s as $obj)
							{
								$subjects['subject_id'] = $obj->subject_id;
								$subjects['block_system_setting_id'] = $block_id;
								$subjects['temp_start_id'] = $id;
								$rest = $this->M_temp_student_subjects->insert($subjects); //SAVE TO TEMPORARY TABLES
							}
						}
						
						//UPDATE TEMP ENROLLMENTS BLOCK_SYSTEM_SETTING_ID
						unset($for_upd);
						$for_upd['block_system_setting_id'] = $block_id;
						$this->M_temp_enrollments->update_enrollments_by_temp_start_id($for_upd,$id);
						redirect('registration/assessment/'.$id);
					}
				}
			}
			else
			{
				$this->view_data['subjects'] = $this->M_subjects->get_current_subjects();
				
				if($_POST)
				{
					$array_subjects = $this->input->post('subject');
					if(isset($array_subjects) && is_array($array_subjects))
					{						
						$this->M_temp_student_subjects->reset_student_subjects($id);
						foreach($array_subjects as $subject_id)
						{
							$subjects['subject_id'] = $subject_id;
							$subjects['temp_start_id'] = $id;
							
							$rest = $this->M_temp_student_subjects->insert($subjects); //SAVE TO TEMPORARY TABLES
						}
						
						redirect('registration/assessment/'.$id);
					}
				}
			}
		}
		
	}
	
	private function generate_fees($id = false)
	{
		if($id == false) { show_404(); }
		
		$this->load->model(array(
		'M_enrollments','M_student_finances','M_student_fees', 'M_student_previous_accounts', 'M_student_subjects', 'M_student_deductions','M_coursefees','M_assign_coursefees',
		'M_studentpayments', 'M_additional_charges',
		'M_course_blocks','M_block_subjects','M_temp_student_subjects',
		'M_temp_start','M_subjects','M_coursefinances'));
		
		$this->view_data['start'] = $start = $this->M_temp_start->get($id);
		$this->view_data['temp_subjects'] =  $temp_subjects = $this->M_temp_student_subjects->get_temp_student_subjects($id);
		
		if($temp_subjects == false)
		{
			//RETURN TO START
			redirect('registration');
		}
		
		#region GET SUBJECTS PROFILES
		$subjects = array();
		foreach($temp_subjects as $key => $obj)
		{
			$subjects[$key] = $this->M_subjects->get($obj->subject_id);
			
		}
		
		$this->view_data['subjects'] = $subjects;
		
		#endregion
		
		$this->view_data['open_enrollment'] = $open = $this->M_open_semesters->get_ay_sem();
		$this->view_data['id'] = $id;
		$this->view_data['student'] = $this->student;
		$this->view_data['process'] = "ASSESSMENT";
		$this->view_data['disable_lasten'] = true;
		$this->view_data['block_system_settings'] = $block_system_settings = $this->M_temp_student_subjects->get_block_system_setting_id($id);
		
		
		//COMPUTE FEES AND DISPLAY
		$data[] = $start->year_id;
		$data[] = $start->course_id;
		$data[] = $this->open_semester->semester_id;
		$data[] = $this->open_semester->academic_year_id;		
		$assigned_course_fee = $this->M_assign_coursefees->get_assign_course_fee($data);
		
		if($assigned_course_fee)
		{
			$this->view_data['coursefinance_id'] = $coursefinance_id = $assigned_course_fee->coursefinance_id;
			$this->view_data['coursefinances'] = $this->M_coursefinances->get_coursefinances($coursefinance_id);
			
			$total_amount_due = 0;
			$subjects_units = 0;
			$subject_total = 0;
			$total_lec = 0;
			$total_lab = 0;
			$has_nstp = 0;
			
			//LOOP SUBJECTS TO GET TOTAL NUMBER OF UNIT LAB AND LEC
			foreach($temp_subjects as $sub)
			{
				$subject = $this->M_subjects->get($sub->subject_id);
				if($subject)
				{
					$subjects_units += $subject->units;
					$subject_total++;
					$total_lec += $subject->lec;
					$total_lab += $subject->lab;
					if($subject->is_nstp == 1)
					{
						$has_nstp++;
					}
				}
			}
			
			$this->view_data['subject_units'] = $subjects_units;
			$this->view_data['subject_total'] = $subject_total;
			$this->view_data['total_lec'] = $total_lec;
			$this->view_data['total_lab'] = $total_lab;
			
			$this->view_data['has_nstp'] = $has_nstp;
			
			#region LOOP COURSE FEES
			$this->view_data['course_fees'] =  $course_fees = $this->M_coursefees->get_all_course_fees($coursefinance_id);
			
			if($course_fees)
			{
				$student_fees = array();
				
				foreach($course_fees as $cf)
				{
					if($cf->is_tuition_fee == 1)
					{
						$student_fees['tuition_fee']['data'] = $cf;
						$student_fees['tuition_fee']['total'] = $total_tuition = $subjects_units * $cf->value;
						$total_amount_due += $total_tuition;
						$this->view_data['tuition_fee'] = $cf->value;
					}
					else if($cf->is_lab == 1)
					{
					
						$student_fees['lab'][$cf->id]['data'] = $cf;
						$student_fees['lab'][$cf->id]['value'] = $cf->value * $total_lab;
						$total_amount_due += $cf->value * $total_lab;
					}
					else if($cf->is_misc == 1)
					{
						$student_fees['misc'][] = $cf;
						$total_amount_due += $cf->value;
					}
					else if($cf->is_other == 1)
					{
						$student_fees['other'][] = $cf;
						$total_amount_due += $cf->value;
					}
					else if($cf->is_nstp == 1)
					{
						$student_fees['nstp'][] = $cf;
						$total_amount_due += $cf->value;
					}
					else{}
				}
				$this->view_data['student_fees'] = $student_fees;
			}
			$this->view_data['total_amount_due'] = $total_amount_due;
			#endregion course fees
			
			
			return $this->view_data;
		}
		else
		{
			$this->session->set_flashdata('system_message', '<div class="alert alert-danger">Course fee was not assigned, please contact your school administrator.</div>');
			redirect('registration/course_fee_not_assigned');
		}
	}
	
	public function assessment($id = false)
	{
		if($id == false) { show_404(); }
		
		$this->view_data = $this->generate_fees($id);
		
		$this->view_data['back_url'] = base_url().'registration/continue_registration/'.$id;
	}
	
	public function payment($id = false)
	{
		
		if($id == false) { show_404(); }
		
		$this->view_data = $this->generate_fees($id);
		
		$this->view_data['process'] = "PAYMENT";
		
		$this->load->model(array('M_payment_plan','M_temp_payment'));
		$this->load->helper('my_number');
		
		$this->view_data['payment_plan'] = $this->M_payment_plan->find_all();
		
		$this->view_data['back_url'] = base_url().'registration/assessment/'.$id;
		
		if($_POST)
		{
			$payment_plan_id = $this->input->post('radio1');
			if(isset($payment_plan_id) && $payment_plan_id != "")
			{
				$data['temp_start_id'] = $id;
				$data['payment_plan_id'] = $payment_plan_id;	
				$data['created_at'] = NOW;	
				$data['updated_at'] = NOW;	
				$this->M_temp_payment->reset_temp_payment($id); //RESET TEMPORARY PAYMENT
				$rs = $this->M_temp_payment->insert($data); //SAVE TEMPORARY PAYMENT
				if($rs['status'])
				{
					redirect('registration/finish/'.$id.'/'.$rs['id']);
				}
			}
		}
	}
	
	public function finish($id = false, $temp_payment_id = false)
	{
		if($id == false) { show_404(); }
		if($temp_payment_id == false) { show_404(); }
		$this->view_data['process'] = "FINISH";
		$this->view_data['disable_lasten'] = true;
		$this->view_data['enroll'] = $this->student;
		$this->view_data['back_url'] = base_url().'registration/payment/'.$id;
		
		$this->check_student_has_existing_enrollment_already($this->student->studid);
		
		#region SAVE WHOLE ENROLLMENT PROCESS GET DATA FROM TEMPORARY TABLES
		if($_POST)
		{
			$this->load->model(array('M_temp_start','M_temp_student_subjects'
			,'M_temp_payment','M_users','M_student_grade_files','M_payment_plan',
			'M_studentpayments_details'));
			
			//GET AND VALIDATE TEMPORARY IF DATA EXIST
			
			$this->validate_temporary_tables($id, true); //CHECK IF STUDENT REALLY FINISH THE ENROLLMENT PROCESS
			$temp_start = $this->M_temp_start->get($id);
			$temp_student_subjects = $this->M_temp_student_subjects->get_temp_student_subjects($id);
			$temp_payment = $this->M_temp_payment->get_temp_payment($id);
			
			//SAVE ENROLLMENT INFO 
			$user = $this->input->post('user');
			$data = $user['enrollment_attributes'];
			$data['status'] = 'old';
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');
			$data['firstname'] = $data['fname'];
			$data['name'] = trim($data['lastname']).', '.trim($data['fname']).' '.trim($data['middle']);
			$data['sy_from'] = $this->open_semester->year_from;
			$data['sy_to'] = $this->open_semester->year_to;
			$data['semester_id'] = $this->open_semester->semester_id;
			$data['course_id'] = $temp_start->course_id;
			$data['year_id'] = $temp_start->year_id;
			$data['studid'] = $this->student->studid;
			$data['is_active'] = 1;
			$data['is_activated'] = 1;
			$data['payment_plan_id'] = $temp_payment->payment_plan_id;
			
			//get block_id
			foreach($temp_student_subjects as $s)
			{
				if($s->block_system_setting_id != "")
				{
					$data['block_system_setting_id'] = $s->block_system_setting_id;
					break;
				}
			}
			
			#region update user table
			
			$existing_user = $this->M_users->get_user_by_login($data['studid']);//CHECK IF THE USER IS EXISTING IN USERS TABLE
			
			if($existing_user)
			{	
				$user_info['name'] = trim($data['name']);
				$user_info['email'] = trim($data['fake_email']);
				$user_info['updated_at'] = date('Y-m-d H:i:s');
				
				$user_result = $this->M_users->update_users($user_info, $existing_user->id);
			
				$data['user_id'] = $existing_user->id;
			}else{ show_404();}			
			
			#endregion
			
			$result = $this->M_enrollments->create_enrollments($data); //CREATE ENROLLMENT DATA
			
			if($result['status'] == false)
			{
				$this->session->set_flashdata('system_message', "<div class='alert alert-danger'>Saving unsuccessfull, please try again or contact your school administrator.</div>");
				redirect(current_url());
				
			}
			
			//SAVING SUCCESSFULL
			$enrollment_id = $result['id'];
			log_message('Success', 'Enrollment Created | Success; Enrollment Id: '.$id);
			
			// Create Student Grade File - holder
			$sgf_data['user_id'] = $enrollment_id;
			$sgf_data['enrollment_id'] = $enrollment_id;
			$sgf = $this->M_student_grade_files->create_student_grade_files($sgf_data);
			
			// Create fees and save total amount of payments
			$total_fees = $this->create_fees($enrollment_id, $id);
			
			//get grading period
			$grading_periods_ids = false;
			$grading_periods = $this->M_grading_periods->get_all_array();
			
			if($grading_periods){
				$ix = 2;
				foreach($grading_periods as $key => $obj){
					$grading_periods_ids[$ix] = $obj['id']; 
					$ix++;
				}
			}
			
			#region DIVIDE AMOUNT DUE AND SAVE TO PAYMENT DETAILS
			$rs_payment_plan = $this->M_payment_plan->get($temp_payment->payment_plan_id);
			if($rs_payment_plan && $total_fees)
			{
				$total_amount_due = $total_fees['total_amount_due'];
				$amount_divided = $total_amount_due / $rs_payment_plan->division;
				
				for($i = 1; $i <= $rs_payment_plan->division; $i++)
				{
					unset($payment_details);
					$payment_details['created_at'] = NOW;
					$payment_details['updated_at'] = NOW;
					$payment_details['enrollment_id'] = $enrollment_id;
					$payment_details['is_paid'] = 0;
					$payment_details['is_promisory'] = 0;
					$payment_details['amount'] = $amount_divided;
					$payment_details['amount_paid'] = 0;
					$payment_details['balance'] = $amount_divided;
					$payment_details['is_current'] = $i == 1 ? 1 : 0;
					
					$payment_details['is_downpayment'] = 0;
					if($rs_payment_plan->division > 1)
					{
						$payment_details['is_downpayment'] = $i == 1 ? 1 : 0;
						
						//MATCH TO GRADING PERIODS
						if($i == 1){
							$payment_details['grading_period_id'] = "DOWNPAYMENT"; //FIRST PAYMENT DOWNPAYMENT
						}else{
							
							if(isset($grading_periods_ids[$i])){
								$payment_details['grading_period_id'] = $grading_periods_ids[$i];
							}
						}
					}else if($rs_payment_plan->division == 1){
						$payment_details['grading_period_id'] = "CASH/FULLPAYMENT";
					}
					
					$rs_payment_details = $this->M_studentpayments_details->create_record($payment_details);
				}
			}
			#endregion
		
			//SAVE STUDENT SUBJECTS
			foreach($temp_student_subjects as $subject)
			{
				$obj = $this->M_subjects->get($subject->subject_id);
				if($obj)
				{
					$this->create_grades($sgf['id'], $subject->subject_id);
					
					$subject_data['created_at'] = date('Y-m-d H:i:s');
					$subject_data['updated_at'] = date('Y-m-d H:i:s');
					$subject_data['enrollmentid'] = $enrollment_id;
					$subject_data['course_id'] = $temp_start->course_id;
					$subject_data['subject_id'] = $subject->subject_id;
					$subject_data['year_id'] = $temp_start->year_id;
					$subject_data['semester_id'] = $this->open_semester->semester_id;
					$subject_data['block_system_setting_id'] = $subject->block_system_setting_id;
					
					$result = $this->M_student_subjects->create_student_subject($subject_data);
					
					if($result['status']){
						log_message('Success','Student subject created | Success; student subject Id: '.$result['id']);
					}
				}
			}
			
			$this->reset_all_temp_tables($temp_start->id);
			
			$this->session->set_flashdata('system_message', "<div class='alert alert-success'>Your registration was successfully submitted. To view this, kindly change the current sem / school year located at the menu.</div>");
			redirect('student');
			
		}
		#endregion
	}
	
	private function create_grades($sgf_id, $subject_id)
	{
		$this->load->model(array('M_student_grades','M_student_grade_categories'));
	    // Create Student Grades
	    $sg_data['created_at'] = date('Y-m-d H:i:s');
	    $sg_data['updated_at'] = date('Y-m-d H:i:s');
		$sg_data['student_grade_file_id'] = $sgf_id;
		$sg_data['subject_id'] = $subject_id;
		$sg_data['subjectid'] = $subject_id;
		$sg = $this->M_student_grades->create_student_grades($sg_data);
			  
		// Create Student Grade Category
		$grading_period = array("Preliminary", "Midterm", "Semi-Finals", "Finals");
		foreach ($grading_period as $gp) 
		{
			$sgc_data['created_at'] = date('Y-m-d H:i:s');
			$sgc_data['updated_at'] = date('Y-m-d H:i:s');
			$sgc_data['category'] = $gp;
			$sgc_data['student_grade_id'] = $sg['id'];
			$this->M_student_grade_categories->create_student_grade_categories($sgc_data);
		}
	}
	
	private function create_fees($enrollment_id = false, $temp_start_id = false)
	{
		if($enrollment_id == false){ show_404(); }
		if($temp_start_id == false){ show_404(); }
		
		$this->load->model(array('M_assign_coursefees','M_student_finances','M_coursefees','M_student_fees','M_student_total_file'));
	 			
		// for total payment variables
		$totalprevious_account = 0.00;
		$totalpreliminary = 0.00;
		$totalmidterm = 0.00;
		$totalsemi_finals = 0.00;
		$totalfinals = 0.00; 
	
	    $enrollee = $this->M_enrollments->profile($enrollment_id);
		$data[] = $enrollee->year_id;
		$data[] = $enrollee->course_id;
		$data[] = $enrollee->sem_id;
		$data[] = $this->open_semester->academic_year_id;
		$assigned_course_fee = $this->M_assign_coursefees->get_assign_course_fee($data);
		if($assigned_course_fee)
		{
			$studentfinance['coursefinance_id'] = $assigned_course_fee->coursefinance_id;
			$studentfinance['student_id']  = $enrollee->user_id;
			$studentfinance['enrollmentid']  = $enrollment_id;
			$studentfinance['year_id'] = $enrollee->year_id;
			$studentfinance['semester_id'] = $enrollee->sem_id;
			$studentfinance['course_id'] = $enrollee->course_id;
			$studentfinance['created_at'] = NOW;
			$studentfinance['updated_at'] = NOW;

			$studfin = $this->M_student_finances->add_student_finance($studentfinance);		
			$coursefees = $this->M_coursefees->get_all_course_fees($assigned_course_fee->coursefinance_id);
			foreach($coursefees as $cf)
			{
				$studentfee['student_id'] = $enrollee->user_id;
				$studentfee['studentfinance_id'] = $studfin['id'];
				$studentfee['fee_id'] = $cf->fee_id;
				$studentfee['fee_id'] = $cf->fee_id;
				$studentfee['value'] = $cf->value;
				$studentfee['position'] = $cf->position;
				$studentfee['created_at'] = NOW;
				$studentfee['updated_at'] = NOW;
		
				$this->M_student_fees->insert_student_fees($studentfee);
			}
		}
		
		//GET ALL UNPAID PREVIOUS ACCOUNTS AND ADD TO TOTAL AMOUNT DUE
		$previous_account = $this->M_enrollments->get_previous_unpaid_enrollment($enrollee->studid);
		$previous_account_amount = 0;
		if($previous_account){
			
			//UPDATE TOTAL AMOUNT
			foreach($previous_account as $obj){
				$previous_account_amount += $obj->balance;
				
				$for_pa['created_at'] = NOW;
				$for_pa['updated_at'] = NOW;
				$for_pa['enrollment_id'] = $enrollment_id;
				$for_pa['prev_enrollment_id'] = $obj->enrollment_id;
				$for_pa['value'] = $obj->balance;
				
				$rs_pa = $this->M_student_previous_accounts->create($for_pa);
			}
			
		}
		
		
		unset($data);
		$data = $this->generate_fees($temp_start_id); //GET TOTAL FEES
		$data['total_amount_due'] += $previous_account_amount;
		
		$total['enrollment_id'] = $enrollment_id;
		$total['status'] = 'UNPAID';
		$total['coursefinance_id'] = $data['coursefinance_id'];
		$total['balance'] = $data['total_amount_due'];
		$total['total_charge'] = $data['total_amount_due'];
		$total['total_amount_due'] = $data['total_amount_due'];
		$total['prev_account'] = $previous_account_amount;
		$total['subject_units'] = $data['subject_units'];
		$total['total_lec'] = $data['total_lec'];
		$total['total_lab'] = $data['total_lab'];
		$total['tuition_fee'] = $data['tuition_fee'];
		$total['total_tuition_fee'] = $data['tuition_fee'] * $data['subject_units'];
			
		$result = $this->M_student_total_file->insert($total);
		
		return $total;
	}
	
	public function reset_all_temp_tables($id = false)
	{
		$this->load->model(array('M_temp_start','M_temp_student_subjects','M_temp_payment'));
		//DELETE TEMPORARY TABLES
		$this->M_temp_payment->reset_temp_payment($id);
		$this->M_temp_start->delete_temp_start($id);
		$this->M_temp_student_subjects->reset_student_subjects($id);
	}
	
	private function validate_temporary_tables($id = false, $checkonly = false)
	{
		if($id == false) { show_404(); }
		
		$this->load->model(array('M_temp_start','M_temp_student_subjects','M_temp_payment'));
		
		$temp_start = $this->M_temp_start->get($id);
		
		if($temp_start == false) {
			$this->session->set_flashdata('system_message', "<div class='alert alert-danger'>Please start your registration here.</div>");
			redirect('registration');
		}
		
		$temp_student_subjects = $this->M_temp_student_subjects->get_temp_student_subjects($temp_start->id);
		
		if($temp_student_subjects == false)
		{
			$this->session->set_flashdata('system_message', "<div class='alert alert-danger'>Please continue your registration here.</div>");
			redirect('registration/continue_registration/'.$temp_start->id);
		}
		
		$temp_payment = $this->M_temp_payment->get_temp_payment($temp_start->id);
		
		if($temp_payment == false)
		{
			$this->session->set_flashdata('system_message', "<div class='alert alert-danger'>Please continue your registration here.</div>");
			redirect('registration/assessment/'.$temp_start->id);
		}
		else{
		
			if($checkonly == false)
			{
				$this->session->set_flashdata('system_message', "<div class='alert alert-danger'>Please continue your registration here.</div>");
				redirect('registration/payment/'.$temp_start->id);
			}
		}
	}
	
	public function course_fee_not_assigned()
	{
		//FOR VIEWING ONLY
	}
	
	private function get_process($p)
	{
		$ret = "";
		switch($p)
		{
			case 1:
				$ret = "START";
			break;
			case 2:
				$ret = "REGISTRATION";
			break;
			case 3:
				$ret = "ASSESSMENT";
			break;
			case 4:
				$ret = "PAYMENT";
			break;
			default:
				$ret = "REGISTRATION";
			break;
		}
		return $ret;
	}
}
