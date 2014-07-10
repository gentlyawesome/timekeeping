<?php

class M_student_total_file Extends MY_Model
{
	protected $_table = 'student_total_file';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_student_total_file($id)
	{
		$query = $this->db->where('enrollment_id', $id)->get($this->_table);
		return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function update_student_total_file($data, $enrollment_id)
	{
		$this->db->set($data)->where('enrollment_id',$enrollment_id)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function deduct_student_payment($enrollment_id = false, $amount = 0, $type = "PAYMENT")
	{
		$ret['status'] = false; 
		
		if($enrollment_id == false) 
		{ 
			$ret['msg'] = "Missing enrollment.";
		}
		
		$student_total = $this->get_student_total_file($enrollment_id);
		
		if($student_total)
		{
			if($amount > 0)
			{
				//DEDUCT TO BALANCE
				$data['balance'] = $balance = $student_total->balance - $amount;
				//LESS PAYMENT
				if($type == "PAYMENT"){
					$data['total_payment'] = $student_total->total_payment + $amount;
				}
				else{ //LESS DEDUCTION
					$data['less_deduction'] = $student_total->less_deduction + $amount;
				}
				$data['total_deduction'] = $student_total->total_deduction + $amount;
				$data['updated_at'] = NOW;
				$rs = $this->update_student_total_file($data, $enrollment_id);
				
				$this->update_status($enrollment_id);
				
			}
		}
		else
		{
			$ret['status'] = false;
			$ret['msg'] = "Missing enrollment.";
		}
		
		return $ret;
	}
	
	public function reverse_student_total($enrollment_id, $amount = 0, $type='PAYMENT')
	{
		$ret['status'] = false; 
		
		if($enrollment_id == false) 
		{ 
			$ret['msg'] = "Missing enrollment.";
		}
		
		$student_total = $this->get_student_total_file($enrollment_id);
		
		if($student_total)
		{
			if($amount > 0)
			{
				//DEDUCT TO BALANCE
				$data['balance'] = $balance = $student_total->balance + $amount;
				//LESS PAYMENT
				if($type == "PAYMENT")
				{
					$data['total_payment'] = $student_total->total_payment - $amount;
				}else //LESS DEDUCTION
				{
					$data['less_deduction'] = $student_total->less_deduction - $amount;
				}
				$data['total_deduction'] = $student_total->total_deduction - $amount;
				$data['updated_at'] = NOW;
				
				
				$rs = $this->update_student_total_file($data, $enrollment_id);
		
				$this->update_status($enrollment_id); //UPDATE STATUS OF PAYMENT
			}
		}
		else
		{
			$ret['status'] = false;
			$ret['msg'] = "Missing enrollment.";
		}
		
		return $ret;
	}
	
	public function add_additional_charge($enrollment_id, $amount)
	{
		$ret['status'] = false; 
		
		if($enrollment_id == false) 
		{ 
			$ret['msg'] = "Missing enrollment.";
			
			return $ret;
		}
		
		$student_total = $this->get_student_total_file($enrollment_id);
		
		if($student_total)
		{
			if($amount > 0)
			{
				//ADD TO BALANCE
				$data['balance'] = $balance = $student_total->balance + $amount;
				$data['additional_charge'] = $additional_charge = $student_total->additional_charge + $amount;
				$data['total_charge'] = $total_charge = $student_total->total_charge + $amount;
				$data['total_amount_due'] = $total_amount_due = $student_total->total_amount_due + $amount;
				$data['updated_at'] = NOW;
				
				$rs = $this->update_student_total_file($data, $enrollment_id);
		
				$this->update_status($enrollment_id); //UPDATE STATUS OF PAYMENT
			}
		}
		
		return $ret;
	}
	
	public function reverse_additional_charge($enrollment_id, $amount = 0)
	{
		$ret['status'] = false; 
		
		if($enrollment_id == false) 
		{ 
			$ret['msg'] = "Missing enrollment.";
			return $ret;
		}
		
		$student_total = $this->get_student_total_file($enrollment_id);
		
		if($student_total)
		{
			if($amount > 0)
			{
				//ADD TO BALANCE
				$data['balance'] = $balance = $student_total->balance - $amount;
				$data['additional_charge'] = $additional_charge = $student_total->additional_charge - $amount;
				$data['total_charge'] = $total_charge = $student_total->total_charge - $amount;
				$data['total_amount_due'] = $total_amount_due = $student_total->total_amount_due - $amount;
				$data['updated_at'] = NOW;
				
				
				$rs = $this->update_student_total_file($data, $enrollment_id);
		
				$this->update_status($enrollment_id); //UPDATE STATUS OF PAYMENT
			}
		}
		else
		{
			$ret['status'] = false;
			$ret['msg'] = "Missing enrollment.";
		}
		
		return $ret;
	}
	
	public function get_subject($subject_id)
	{
		$sql = "
			SELECT id, units, lab, lec
			FROM subjects
			WHERE id = ?
			";
		$query = $this->db->query($sql, array($subject_id));
		return $query->num_rows > 0 ? $query->row() : false;
	}
	
	public function add_subject_amount($enrollment_id, $amount = 0, $subject_id)
	{
		
		$ret['status'] = false; 
		
		if($enrollment_id == false) 
		{ 
			$ret['msg'] = "Missing enrollment.";
			
			return $ret;
		}
		
		$student_total = $this->get_student_total_file($enrollment_id);
		$subject = $this->get_subject($subject_id);
		
		if($student_total && $subject)
		{
			if($amount > 0)
			{
				//ADD TO BALANCE
				$data['balance'] = $balance = $student_total->balance + $amount;
				$data['total_charge'] = $total_charge = $student_total->total_charge + $amount;
				$data['total_amount_due'] = $total_amount_due = $student_total->total_amount_due + $amount;
				$data['subject_units'] = $student_total->subject_units + $subject->units;
				$data['total_lab'] = $student_total->total_lab + $subject->lab;
				$data['total_lec'] = $student_total->total_lec + $subject->lec;
				$data['updated_at'] = NOW;
				
				$rs = $this->update_student_total_file($data, $enrollment_id);
				$ret['status'] = $rs; 
				$this->update_status($enrollment_id); //UPDATE STATUS OF PAYMENT
			}
		}
		
		return $ret;
	}
	
	public function reverse_subject_amount($enrollment_id, $amount = 0, $subject_id)
	{
		$ret['status'] = false; 
		
		if($enrollment_id == false) 
		{ 
			$ret['msg'] = "Missing enrollment.";
			
			return $ret;
		}
		
		$student_total = $this->get_student_total_file($enrollment_id);
		$subject = $this->get_subject($subject_id);
		
		if($student_total && $subject)
		{
			if($amount > 0)
			{
				//ADD TO BALANCE
				$data['balance'] = $balance = $student_total->balance - $amount;
				$data['total_charge'] = $total_charge = $student_total->total_charge - $amount;
				$data['total_amount_due'] = $total_amount_due = $student_total->total_amount_due - $amount;
				$data['subject_units'] = $student_total->subject_units - $subject->units;
				$data['total_lab'] = $student_total->total_lab - $subject->lab;
				$data['total_lec'] = $student_total->total_lec - $subject->lec;
				$data['updated_at'] = NOW;
				
				$rs = $this->update_student_total_file($data, $enrollment_id);
				$ret['status'] = $rs; 
				$this->update_status($enrollment_id); //UPDATE STATUS OF PAYMENT
			}
		}
		
		return $ret;
	}
	
	public function update_status($enrollment_id)
	{
		$student_total = $this->get_student_total_file($enrollment_id);
		
		if($student_total)
		{
			if($student_total->balance <= 0)
			{
				$data['status'] = "PAID";
			}
			else if($student_total->balance >= $student_total->total_amount_due)
			{
				$data['status'] = "UNPAID";
			}
			else
			{
				$data['status'] = "PARTIALLY PAID";
			}
			
			$rs = $this->update_student_total_file($data, $enrollment_id);
		}
	}
	
	public function delete_student_total_file($where = false)
	{
		$this->db->where('enrollment_id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}