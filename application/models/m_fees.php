<?php

class M_fees Extends CI_Model
{
	private $_table = 'fees';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($id = false,$array = false)
	{
		if($id == false)
		{
				if($array == false)
				{
					$query = $this->db->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}else
				{
					$query = $this->db->select($array)->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}
		}else
		{
			if($array == false)
			{
				$query = $this->db->where('id',$id)->get($this->_table);
				return $query->num_rows() > 0 ? $query->row() : FALSE;
			}else
			{
				$query = $this->db->select($array)->where('id',$id)->get($this->_table);
				return $query->num_rows() > 0 ? $query->row() : FALSE;
			}
		}
		
	}
	
	public function get_all()
	{
		//print_r($data);
		$sql = "select message, date
				FROM $this->_table
				ORDER BY created_at desc LIMIT 15";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function find_all()
	{
		//print_r($data);
		$sql = "select *
				FROM $this->_table
				ORDER BY id";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function create_fees($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function get_fees($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function update_fees($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_fees($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}

	public function get_enrollment_total_fees($enrollment_id = false)
	{
			if($enrollment_id == false){
				
				return false;
			}
			
			$this->load->model(array('M_enrollments','M_student_finances','M_student_fees', 'M_student_previous_accounts', 'M_student_subjects', 'M_student_deductions','M_coursefees','M_assign_coursefees','M_studentpayments'));
			
#			Top header data of student
			$p = $this->M_enrollments->profile($enrollment_id);
			$view_data['enrollment_id'] = $enrollment_id;
			
#			Used for layouts/student_data
			$subjects =  $this->M_student_subjects->get_studentsubjects($enrollment_id);
			$subject_units = $this->M_student_subjects->get_studentsubjects_total($subjects);
			
			$view_data['student_profile'] = $this->M_enrollments->profile($enrollment_id); // student profile
			
			$student_finance =  $this->M_student_finances->get_student_finance($enrollment_id);
			
			if(!empty($student_finance))
			{
				// for total payment variables
				$totalprevious_account = 0.00;
				
				//Get course Finance
				$enrollee = $this->M_enrollments->profile($enrollment_id);
				$data[] = $enrollee->year_id;
				$data[] = $enrollee->course_id;
				$data[] = $enrollee->sem_id;
				$data[] = $this->open_semester->academic_year_id;
				$assigned_course_fee = $this->M_assign_coursefees->get_assign_course_fee($data);
				
				$studentfinance['coursefinance_id'] =  ($assigned_course_fee) ? $assigned_course_fee->coursefinance_id : '';
				$studentfinance['student_id']  = $enrollee->user_id;
				$studentfinance['enrollmentid']  = $enrollment_id;
				$studentfinance['year_id'] = $enrollee->year_id;
				$studentfinance['semester_id'] = $enrollee->sem_id;
				$studentfinance['course_id'] = $enrollee->course_id;
		
				$this->M_student_finances->add_student_finance($studentfinance);
				//$view_data['student_finance'] =  $this->M_student_finances->get_student_finance($enrollment_id);
				$studfin = $this->M_student_finances->get_student_finance($enrollment_id);
			
				$nstp_exist = 0;
				$lab_exist = 0;
				$lec_exist = 0;
				$bsba_units = 0;
				$lab1_units = 0;
				$lab2_units = 0;
		    
		    if (isset($subjects)){
				foreach($subjects as $k => $s):
				  
					if(preg_match("/^nstp/", strtolower($s->code))){
						$nstp_exist++;
					}
					
					if($s->lab_kind == "BSBA"){
						$bsba_units += $s->lab;
					}
					
					if($s->lab_kind == "LAB1"){
						$lab1_units += $s->lab;
					}
					
					if($s->lab_kind == "LAB2"){
						$lab2_units += $s->lab;
					}
				endforeach;
				}
				
					
				$view_data["nstp"] = $nstp_exist;
				$student_total_units = $subject_units['total_units'];
				//End Student Subject Units
		
				// Loop through Coursefees
				//Temp-Variable
				$tuition_fee = 0.0;
				$lab_fee = 0.0;
				$rle_fee = 0.0;
				$misc_fee = 0.0;
				$other_fee = 0.0;
				$lab_a_fee = 0.0;
				$lab_b_fee = 0.0;
				$lab_c_fee = 0.0;
				$bsba_fee = 0.0;
				$lab1_fee = 0.0;
				$lab2_fee = 0.0;
				
				$coursefees = false;
				if($assigned_course_fee)
				{
					$coursefees = $this->M_coursefees->get_all_course_fees($assigned_course_fee->coursefinance_id);
			
					foreach($coursefees as $cf):
						$studentfee['student_id'] = $enrollee->user_id;
						$studentfee['studentfinance_id'] = $studfin->id;
			  
						if( strtolower($cf->name) == "tuition fee per unit" )
						{
							$studentfee['fee_id'] = $cf->fee_id;
							$tuition_fee += $cf->value;
						}
			  
						if( strtolower($cf->name) == "laboratory fee per unit" )
						{
							$studentfee['fee_id'] = $cf->fee_id;
							$lab_fee += $cf->value;
						}
						
						if (preg_match("/bsba laboratory/",$cf->name)){
						  $bsba_fee += $cf->value;
						}
						
						if (preg_match("/laboratory 1/",$cf->name)){
						  $lab1_fee += $cf->value;
						}
						
						if (preg_match("/laboratory 2/",$cf->name)){
						  $lab2_fee += $cf->value;
						}
								
						
			  
						if( $cf->is_misc == 1 )
						{
							$misc_fee += $cf->value;
						}
			  
						if( $cf->is_other == 1 )
						{
							$other_fee += $cf->value;
						}
			  
						$studentfee['fee_id'] = $cf->fee_id;
						$studentfee['value'] = $cf->value;
						$studentfee['position'] = $cf->position;
				
						
					endforeach;
				}
			
			
			  $view_data['lab_a'] = $bsba_units;
			  $view_data['lab_b'] = $lab1_units;
			  $view_data['lab_c'] = $lab2_units;
			
			  $view_data['lab_a_fee'] = $bsba_fee;
			  $view_data['lab_b_fee'] = $lab1_fee;
			  $view_data['lab_c_fee'] = $lab2_fee;
			
			  $view_data['lab_a_fee_total'] = $lab1_total_fee = $bsba_units*198.00;
			  $view_data['lab_b_fee_total'] = $lab2_total_fee = $lab1_units*263.00;
			  $view_data['lab_c_fee_total'] = $lab3_total_fee = $lab2_units*318.00;
			  $total_custom_lab = $lab1_total_fee + $lab2_total_fee + $lab3_total_fee;
				
				
		
				# Computations for student total
				$student_total['enrollment_id'] = $enrollment_id;
				$student_total['total_units'] = $student_total_units;
				$student_total['tuition_fee_per_unit'] = $tuition_fee;
				$student_total['lab_fee_per_unit'] = $lab_fee;
				$student_total['total_misc_fee'] = $misc_fee;
				$student_total['total_other_fee'] = $other_fee;
				$student_total['additional_charge'] = $p->total_additional_charges;
				$student_total['previous_account'] = $totalprevious_account;
    
    
				$total_tuition_fee = $tuition_fee*$student_total_units;
				$total_misc = $misc_fee;
				$total_other = $other_fee;
				# End Computations
	  
				# Save Computation Totals
	  
				# Tuition Fee
				$student_total['tuition_fee'] = $total_tuition_fee;
				# RLE Fee
#				$student_total['total_rle'] = $total_rle;
				
				$total_stud_payment = $this->M_studentpayments->get_sum_student_payments($enrollment_id);
				$total_stud_dec = $this->M_student_deductions->get_sum_of_deductions($enrollment_id);
				if($total_stud_payment->account_recivable_student != '')
				{
					$student_total['total_payment'] = $total_stud_payment->account_recivable_student;
				}
				else
				{
					$student_total['total_payment'] = 0.00;
				}
				if($total_stud_dec->amount != '')
				{
					$student_total['total_deduction'] = $total_stud_dec->amount;
				}
				else
				{
					$student_total['total_deduction'] = 0.00;
				}
				
				$student_total["total_student_deduction"] = $total_stud_payment->account_recivable_student + $total_stud_dec->amount;
    
    
				# Total Charge
				$student_total['total_charge'] = $total_tuition_fee  + $total_misc + $total_other+$total_custom_lab;
				# Total Payable/ Amount
				$student_total['total_amount'] = $student_total['total_charge'] + $totalprevious_account;
				# Calculate Remaining Balance
				$student_total['remaining_balance'] = $student_total['total_amount'] - ($total_stud_dec->amount + $total_stud_payment->account_recivable_student);
				
				
				$view_data['student_total'] = $student_total;
				
				# End Save Computation Totals
			}
			
			
			$view_data['total_deductions'] = $this->M_student_deductions->sum_of_deductions($enrollment_id);
			$studentfinance =  $this->M_student_finances->get_student_finance($enrollment_id);
			// $view_data['sfid'] = $studentfinance->id;		
			// $view_data['studentfees'] =  $this->M_student_fees->get_student_fees($studentfinance->id);
			
			// $student_fees = $this->M_student_fees->get_student_fees($studentfinance->id);
			$view_data['previous'] =  $this->M_student_previous_accounts->get_student_previous_accounts($enrollment_id);
			
			/* get student subjects where student course_id,sem_id,year_id equal to subjects*/
			$student_subjects = $this->M_student_subjects->get_student_subjects($enrollment_id,$p->course_id,$p->year_id,$p->sem_id);
			//$view_data['student_subjects'] =  $student_subjects;
			
			
			
			
			$view_data['course'] = $p->course_id;
			$view_data['year'] = $p->year_id;
			$view_data['semester'] = $p->sem_id;
			$view_data['enrollment_id'] = $p->id;
			
			return $view_data;
	}
	
}