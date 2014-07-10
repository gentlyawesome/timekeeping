<?php

class Fees Extends MY_Controller
{
	public function __construct(){
		parent::__construct();
		$this->session_checker->open_semester();
		$this->load->helper(array('url_encrypt'));
		$this->load->model(array('M_student_total_file'));
	}
		

	public function index()
	{
		$this->load->model(array('M_fees','M_enrollments'));
		$this->session_checker->check_if_alive();
		$this->view_data['fees'] = $this->M_fees->find_all();
		$this->view_data['system_message'] = $this->session->flashdata('system_message');		

		$rs = $this->M_enrollments->get_open_enrollment($this->student->login);
		
		if($rs)
		{
			redirect('fees/view_fees/'.$rs->id);
		}
		else
		{
			   $this->session->set_flashdata('system_message', '<div class="alert alert-danger">You dont have an existing enrollment record. Please contact your school admin.</div>');
		}
	}
	
	
	
	// Update
	public function edit($id)
	{
		$this->load->model(array('M_fees'));
		
		$this->view_data['fees'] = $this->M_fees->get_fees($id);
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		if($_POST)
		{
			$data = $this->input->post('fees');
			$data['is_deduction'] = isset($data['is_deduction']) ? 1 : 0;
			$data['is_active'] = isset($data['is_active']) ? 1 : 0;
			$data['is_nstp'] = isset($data['is_nstp']) ? 1 : 0;
			$data['is_misc'] = isset($data['is_misc']) ? 1 : 0;
			$data['is_package'] = isset($data['is_package']) ? 1 : 0;
			$data['is_other'] = isset($data['is_other']) ? 1 : 0;
			$data['donot_show_in_old'] = isset($data['donot_show_in_old']) ? 1 : 0;
			$data['updated_at'] = date('Y-m-d H:i:s');
			// var_dump($data);
			$result = $this->M_fees->update_fees($data, $id);
			
			if($result['status'])
			{
				log_message('error','Fees Updated by: '.$this->user.'Success; Fee Id: '.$id);
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger">Fees successfully updated.</div>');
				redirect('fees');
			}
		}
	}
		
	public function view_fees($enrollment_id = false)
	{
		if($enrollment_id == false){ show_404();}
		
		$this->load->model(array('M_enrollments','M_student_finances','M_student_fees', 'M_student_previous_accounts', 'M_student_subjects', 'M_student_deductions','M_coursefees','M_assign_coursefees','M_studentpayments', 'M_additional_charges','M_student_total_file',
		'M_subjects'));
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
#			Top header data of student
		$this->view_data['student'] = $p = $this->M_enrollments->profile($enrollment_id);
		$this->view_data['enrollment_id'] = $enrollment_id;
		
		$this->issue_count($p->user_id);
		
		//GET STUDENT FINANCE
		$this->view_data['student_finance'] = $studentfinances = $this->M_student_finances->get_student_finance($enrollment_id);
		
		//GET STUDENT TOTALS
		$this->view_data['student_total'] = $student_total = $this->M_student_total_file->get_student_total_file($enrollment_id);
		
		if($studentfinances)
		{
			//GET STUDENT FEES
			$stud_fees = $this->M_student_fees->get_student_fees($studentfinances->id);
		}
		
		//GET SUBJECTS
		$this->view_data['subjects'] = $subjects = $this->M_student_subjects->get_studentsubjects($enrollment_id);
		//LOOP SUBJECTS TO GET TOTAL NUMBER OF UNIT LAB AND LEC
		$subjects_units = 0;
		$total_lec = 0;
		$total_lab = 0;
		$has_nstp = 0;
		
		if($subjects)
		{
			foreach($subjects as $subject)
			{				
				$subjects_units += $subject->units;
				$total_lec += $subject->lec;
				$total_lab += $subject->lab;
				if($subject->is_nstp == 1)
				{
					$has_nstp++;
				}	
			}				
		}
		
		$this->view_data['subject_units'] = $subjects_units;
		$this->view_data['total_lec'] = $total_lec;
		$this->view_data['total_lab'] = $total_lab;
		$this->view_data['has_nstp'] = $has_nstp;
		
		//ARRANGE STUDENT FEES
		if(isset($stud_fees) && $stud_fees)
		{
			$student_fees = array();
			
			foreach($stud_fees as $cf)
			{
				if($cf->is_tuition_fee == 1)
				{
					$student_fees['tuition_fee'][0] = $cf;
					// $total_tuition = $subjects_units * $cf->value;
					// $total_amount_due += $total_tuition;
				}
				else if($cf->is_lab == 1)
				{
				
					$student_fees['lab'][$cf->id]['data'] = $cf;
					$student_fees['lab'][$cf->id]['value'] = $cf->value * $total_lab;
				}
				else if($cf->is_misc == 1)
				{
					$student_fees['misc'][] = $cf;
					// $total_amount_due += $cf->value;
				}
				else if($cf->is_other == 1)
				{
					$student_fees['other'][] = $cf;
					// $total_amount_due += $cf->value;
				}
				else if($cf->is_nstp == 1)
				{
					$student_fees['nstp'][] = $cf;
					// $total_amount_due += $cf->value;
				}
				else{}
			}
			$this->view_data['student_fees'] = $student_fees;
		}

		$this->view_data['course'] = $p->course_id; 
		$this->view_data['year'] = $p->year_id;
		$this->view_data['semester'] = $p->sem_id;
		$this->view_data['enrollment_id'] = $p->id;
		
		
		//Ajax Subject
		$this->view_data['eid'] = $p->id;
		$this->view_data['y'] = $p->year_id;
		$this->view_data['c'] = $p->course_id;
		$this->view_data['s'] = $p->semester_id;
	}
	
	public function view_deducted_fees($enrollment_id = false)
	{
		$this->session_checker->check_if_alive();
		if($enrollment_id !== false AND ctype_digit($enrollment_id))
		{
			$this->view_data['system_message'] = $this->session->flashdata('system_message');
			$this->load->model('M_student_deductions');
			$this->view_data['enrollment_id'] = $enrollment_id;
			$this->view_data['deducted_fees'] = $this->M_student_deductions->get(false,array('id','amount','remarks','created_at'),array('enrollment_id'=>$enrollment_id));	
			
		}else{
			show_404();
		}
	}
	
	public function show_deducted_fee($id = false,$eid = false)
	{
		if(($id !== false AND ctype_digit($id)) AND ($eid !== false AND ctype_digit($eid)))
		{
			$this->token->set_token();
			$this->view_data['form_token'] = $this->token->get_token();
			$this->view_data['this_eid'] = $eid;
			$this->view_data['this_fid'] = $id;
			$this->load->model('M_student_deductions');
			$this->view_data['deducted_fee'] = $this->M_student_deductions->get(false,false,array('enrollment_id'=>$eid,'id'=>$id));

		}else
		{
			if($this->input->post('delete_deducted_fee'))
			{
				// if($this->token->validate_token($this->input->post('token'))){}
				$this->load->model('M_student_deductions');
				$amount = $this->input->post('amount');
				$post_fid = $this->input->post('fid');
				$post_eid = $this->input->post('eid');
				if($this->M_student_deductions->destroy_deducted_fee($post_fid,$post_eid))
				{
						$this->load->model('M_student_totals');
						$student_total = $this->M_student_totals->get_student_total($post_eid);
						$updated_amount = $student_total->remaining_balance + $amount;
						if($this->M_student_totals->update_student_totals(array('remaining_balance'=>$updated_amount),array('enrollment_id'=>$post_eid)))
						{
							log_message('info','Delete from deducted fees by: '.$this->user. '; Amount: '.$amount.'; from student Enrollment Id: '.$post_eid );
							$this->session->set_flashdata('system_message','<div class="alert alert-success">Deducted Fee was deleted from Records</div>');
							$this->token->destroy_token();
							redirect('fees/view_deducted_fees/'.$post_eid);
						}else
						{
							log_message('error','fees/show_deducted_fee/update_student_totals : unable to update student totals remaining_balance to: '.$updated_amount.'; student enrollment id: '.$post_eid);
							$this->view_data['system_message'] = '<div class="alert alert-danger">Fee was deleted but unable to deduct from student totals</div>';
						}
				}else{
					log_message('error','fees/show_deducted_fee/destroy_deducted_fee : unable to destroy fee id: '.$post_fid);
					$this->view_data['system_message'] = '<div class="alert alert-danger">Unable to delete fee</div>';
				}
			
			}else{
				show_404();
			}
		}
	}
	

	
	public function add_fees($sfid = false,$enrollment_id = false)
	{
		$this->session_checker->check_if_alive();
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		if($sfid !== false AND (int)$sfid)
		{
			$this->load->model('M_student_fees');
			$this->token->set_token();
			$this->view_data['form_token'] = $this->token->get_token();
			$this->view_data['fees'] = $this->M_student_fees->get_unassigned_fees($sfid);
			$this->view_data['sfid'] = $sfid;
			$this->view_data['eid'] = $enrollment_id;
			
			if($this->input->post('add_fee') !== false)
			{
				if($this->input->post('fee') !== false)
				{
					if($this->token->validate_token($this->input->post('form_token')))
					{
						$this->load->model('M_student_fees');
						$result = $this->M_student_fees->assign_fees($this->input->post('fee'),$this->input->post('sfid'),$this->input->post('eid'));
						if($result['status'] == 'true')
						{
							log_message('info','Added Fees by: '.$this->user.' '.$result['log'].' Enrollment Id: '.$enrollment_id.'; Student FInance id: '.$sfid);
							$this->session->set_flashdata('system_message','<div class="alert alert-success">Fee Was Successfully Added</div>');
							$this->token->destroy_token();
							redirect(current_url());
						}else{
							log_message('info','Added Fees by: '.$this->user.' '.$result['log'].' Enrollment Id: '.$enrollment_id.'; Student FInance id: '.$sfid);
							$this->view_data['system_message'] = '<div class="alert alert-danger">An error was encountered while proccessing your request</div>';
						}
					}else{
						log_message('info','Added Fees by: '.$this->user.' '.$result['log'].' Enrollment Id: '.$enrollment_id.'; Student FInance id: '.$sfid);
						$this->view_data['system_message'] = '<div class="alert alert-danger">Invalid Form Submit</div>';
					}
				}
			}
		}else{
			show_404();
		}
	}
	
	public function destroy_fees($sfid = false,$fid = false,$eid = false)
	{
		if($sfid !== false && $fid !== false && $eid !== false)
		{
			$fid = intval($fid);
			$sfid = intval($sfid);
			$eid = intval($eid);
			$jquery = $this->input->post('jquery');
			if($jquery == false)
			{
				$this->load->model('M_student_fees');
				if($this->M_student_fees->destroy_fee($sfid,$fid,$eid))
				{
					$this->session->set_flashdata('system_message', '<div class="alert alert-success">Fees were successfully destroyed</div>');
					redirect(current_url());
				}else
				{
					 $this->view_data['system_message'] = '<div class="alert alert-danger">An error was encountered while proccessing your request</div>';
				}
			}else
			{
				$this->load->model('M_student_fees');
				$result = $this->M_student_fees->destroy_fee($sfid,$fid,$eid);
				if($result['status'] == 'true')
				{
					log_message('info','Destroy Fees By: '.$this->user.'; Student Finance Id: '.$sfid.'; Fee Id: '.$fid.'; Student Enrollment Id :'.$eid);
					echo 'true';
					//echo $result['log']; // debug
					die();//stops php from sending the views so that browser will only receive true
				}else
				{
					log_message('error','Unable to Destroy Fee ID: '.$fid.'; Student Finance Id: '.$sfid.'; Student Enrollment Id: '.$eid.'; Process Request By: '.$this->user);
					echo 'false';
					//echo $result['log']; // debug
					die();//stops php from sending the views so that browser will only receive false
				}
			}
		}else{
			show_404();
		}
	}
	
	public function delete_previous_account($id, $eid)
	{
	  $this->load->model(array('M_student_previous_accounts'));
	  
	  $result = $this->M_student_previous_accounts->destroy($id);
	  
		log_message('error','Previous Account Deleted by: '.$this->user.'Success; Previous Account Id: '.$id);
		$this->session->set_flashdata('system_message', '<div class="alert alert-success">Previous Account successfully deleted.</div>');
		redirect('/fees/view_fees/'.$eid);
	}
	
	public function delete_additional_charge($id, $eid)
	{
	  $this->load->model(array('M_additional_charges'));
	  
	  $result = $this->M_additional_charges->destroy($id);
	  
		log_message('error','Additional Charge Deleted by: '.$this->user.'Success; Additional Charge Id: '.$id);
		$this->session->set_flashdata('system_message', '<div class="alert alert-success">Additional successfully deleted.</div>');
		redirect('/fees/view_fees/'.$eid);
	}
	
	public function destroy_subject($id)
	{		
		$jquery = $this->input->post('jquery');
		if($jquery == false)
		{
			$this->load->model('M_student_fees');
			if($this->M_student_fees->destroy_fees($id))
			{
				$this->session->set_flashdata('system_message', '<div class="alert alert-success">Update was successfull</div>');
				redirect(current_url());
			}else
			{
				 $this->view_data['system_message'] = '<div class="alert alert-danger">An error was encountered while proccessing your request</div>';
			}
		}else
		{
			$this->load->model('M_student_subjects');
			if($this->M_student_subjects->destroy_subject($id))
			{
				echo 'true';
				die();//stops php from sending the views so that browser will only receive true
			}else
			{
				echo 'false';
				die();//stops php from sending the views so that browser will only receive false
			}
		}
	}
	
	public function print_fee_pdf($enrollment_id = false,$c = false,$y = false,$s = false)
	{
		$this->session_checker->check_if_alive();
		if($enrollment_id !== false AND ctype_digit($enrollment_id) AND $c !== false AND $y !== false AND $s !==false)
		{
			$this->load->model(array('M_student_totals','M_student_finances','M_student_fees', 'M_student_previous_accounts', 'M_student_subjects', 'M_promissory_notes','M_enrollments'));
			$this->load->helper('print');
			$h = "8";// Hour for time zone goes here e.g. +7 or -4, just remove the + or -
			$hm = $h * 60;
			$ms = $hm * 60;
			$now = time();
			$gmt = local_to_gmt($now);
			$gmdate = $gmt+($ms); // the "-" can be switched to a plus if that's what your time zone is.
			
			$enrollment= $this->M_enrollments->profile($enrollment_id);
			$student_total =  $this->M_student_totals->get_student_total($enrollment_id);
			$student_subjects =  $this->M_student_subjects->get_student_subjects($enrollment_id,$c,$y,$s);
			$studentfinance =  $this->M_student_finances->get_student_finance($enrollment_id);
			$studentfees =  $this->M_student_fees->get_student_fees($studentfinance->id);
			
			// print_html defined at helpers/print_helper.php
			$html = print_html($enrollment,$student_total,$student_subjects,$studentfinance,$studentfees,$gmdate); 
			$this->load->library('mpdf');
		
			$mpdf=new mPDF('','FOLIO','','',5,5,5,5,0,0); 

			$mpdf->WriteHTML($html);

			$mpdf->Output();
		}else{
			show_404();
		}
	}
	
	public function test($a,$b)
	{
		$this->load->model('M_student_fees');
		$this->M_student_fees->destroy_fee($a,$b);
	}

	public function student_charges($page=0)
	{
		$this->load->Model(array('M_enrollments','M_fees'));
	
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."fees/student_charges";
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_enrollments->count_all_updaid_enrollments();
		$config["per_page"] = 30;
		$config['num_links'] = 10;
		$config["uri_segment"] = 3;
		// $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// vp($page, true);
		$this->pagination->initialize($config);
		$xfilter = " AND full_paid <> 1 ";
		$rs = $this->M_enrollments->get_all_updaid_enrollments($config["per_page"], $page, $xfilter);
		$data = false;
		
		if($rs){
			
			foreach($rs as $obj)
			{
				$data[] = $this->M_fees->get_enrollment_total_fees($obj->id); //GET FEE PROFILES
			}	
		}
		$this->view_data['student_charges'] = $data;
		$this->view_data['links'] = $this->pagination->create_links();
	}
	
	public function student_deductions($page = 0)
	{
		$this->load->Model(array('M_enrollments','M_student_deductions'));
		
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."fees/student_deductions";
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_student_deductions->get_all_students_with_deduction(0,0, false, true,true);
		$config["per_page"] = 30;
		$config['num_links'] = 10;
		$config["uri_segment"] = 3;
		
		$this->pagination->initialize($config);
	
		$rs = $this->M_student_deductions->get_all_students_with_deduction($config["per_page"], $page);
		$data = false;
		
		if($rs){
			
			foreach($rs as $obj)
			{
				$data[$obj->studid] = $this->M_student_deductions->get_student_deduction_byenrollment_id($obj->enrollment_id); //GET DEDUCTIONs
			}	
		}
		$this->view_data['students'] = $rs; //GROUP BY STUDENTS
		$this->view_data['deductions'] = $data; //DETAILS OF DEDUCTION PER STUDENT
		$this->view_data['links'] = $this->pagination->create_links();
	}
	
	
	function reasses($enrollment_id)
	{
	  $this->load->model(array('M_subjects','M_student_subjects','M_course_blocks','M_block_section_settings','M_block_subjects',"M_assign_coursefees", "M_student_finances", "M_coursefees", "M_student_fees", 'M_enrollments'));
	 			
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
				$studfin_exist = $this->M_student_finances->all_by_enrollment_id($enrollment_id); 
				
		    if (!empty($studfin_exist)) {
		      foreach ($studfin_exist as $row) {
		        $this->M_student_fees->delete_all_fees($row->id);
		      }
		      $this->M_student_finances->delete_student_finance($enrollment_id);
		    }
		    
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
				
		
				foreach($coursefees as $cf):
				  $studentfee['created_at'] = NOW;
				  $studentfee['updated_at'] = NOW;
					$studentfee['student_id'] = $enrollee->user_id;
					$studentfee['studentfinance_id'] = $studfin['id'];
	      
					if( strtolower($cf->name) != "tuition fee per unit" and strtolower($cf->name) != "laboratory fee per unit" )
					{
						$studentfee['fee_id'] = $cf->fee_id;
					}
					
	      
					$studentfee['fee_id'] = $cf->fee_id;
					$studentfee['value'] = $cf->value;
					$studentfee['position'] = $cf->position;
					$this->M_student_fees->insert_student_fees($studentfee);
				endforeach;
				
    redirect('fees/view_fees/'. $enrollee->id);
    
    $this->view_data['system_message'] = '<div class="alert alert-success">Successfully Re-assessed fee.</div>';
	}
}
