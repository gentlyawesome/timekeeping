<?php
class M_payment_records extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	private $_table = 'payment_records';
	private $sp = 'studentpayments';
	private $st = 'student_totals';
	private $sd = 'student_deductions';
	
	public function add_payment_record($data,$id)
	{
		$studentpayments_old_account = $this->get_student_old_account($id);
		// $studenttotals = $this->get_remaining_balance($id);
		
		$for_studentpayments['total'] = $studentpayments_old_account->old_account + $data['amount'] + $data['old_account'] + $data['other'];
		$for_studentpayments['or_no'] = $data['receipt_number'];
		$for_studentpayments['account_recivable_student'] = $data['amount'];
		$for_studentpayments['old_account'] = $data['old_account'];
		$for_studentpayments['other'] = $data['other'];
		$for_studentpayments['date'] = $data['date_of_payment'];
		$for_studentpayments['created_at'] = date('Y-m-d H:i:s',time());
		$for_studentpayments['updated_at'] = date('Y-m-d H:i:s',time());
		$for_studentpayments['remarks'] = $data['remarks'];
		$for_studentpayments['group_or_no'] = $data['group_or_no'];
		$for_studentpayments['enrollmentid'] = $id;
		$for_studentpayments['studentfinance_id'] = $this->get_studentfinance_id($id)->id;
		
		// $for_student_totals['remaining_balance'] = ($studenttotals != 0) ? $studenttotals->remaining_balance - $data['amount'] : $data['amount'];
		// $for_student_totals['total_payment'] = ($studenttotals != 0) ? $studenttotals->total_payment + $data['amount'] : $data['amount'];
	
		$this->db->insert($this->sp,$for_studentpayments);
		
		if($this->db->affected_rows() > 0)
		{
			
			return array('status'=>'true','log'=>'Process was successfull');
			
			//REMOVE STUDENT TOTALS WALA PA DAW
			
			// $this->db->set($for_student_totals)->where('enrollment_id',$id)->update($this->st);
			
			// if($this->db->affected_rows() > 0)
			// {
				// return array('status'=>'true','log'=>'Process was successfull');
			// }else{
				// return array('status'=>'false','log'=>'Unable to update Student Totals');
			// }
		
		}else{
			return array('status'=>'false','log'=>'Unable to Insert to Student payments');
		}
	}
	
	public function add_deduction($data,$id)
	{	
		// $studenttotals = $this->get_remaining_balance($id);
		// $this->db->set('remaining_balance',$studenttotals->remaining_balance - $data['amount'])->where('enrollment_id',$id)->update($this->st);
		// if($this->db->affected_rows() > 0)
		// {
			if(trim($data['amount'] != ""))
			{
				$data['created_at'] = date("Y-m-d H:i:s",time());  ;
				$data['updated_at'] = date("Y-m-d H:i:s",time());  ;
				$this->db->insert($this->sd,$data);
				return $this->db->affected_rows() > 0 ? array('status'=>'true','log'=>'Process Done!') : array('status'=>'false','log'=>'Unable to create deduction');
			}
			else{
				return array('status'=>'false','log'=>'Amount should not be blank');
			}
		// }else{
			// return array('status'=>'false','log'=>'Unable to update Student Totals');
		// }
	}
	
	
	private function get_student_old_account($id)
	{
		$query = $this->db->select('old_account')->where('enrollmentid',$id)->get($this->sp);
		return $query->num_rows() > 0 ? $query->row() : 0 ;
	}
	
	private function get_remaining_balance($id)
	{
		$query = $this->db->select(array('remaining_balance','total_payment'))->where('enrollment_id',$id)->get($this->st);
		return $query->num_rows() > 0 ? $query->row() : 0 ;
	}
	
	/* verify_data
	 * @param array
	 * @param int
	*  verifies if data entered by user is existing already in the database
	*  $strict level 1,2
	*  level 1 = if one field has existing data in database returns true else false
	*  level 2 = if all field has existing data in database returns true else false
	*  12/11/2012
	*/
	public function verify_data($data,$strict_level)
	{		
			if($strict_level == 1)
			{
				$query = $this->db->or_where($data)->get($this->__table);
			}elseif($strict_level == 2){
				$query = $this->db->where($data)->get($this->__table);
			}
			return $query->num_rows() > 0 ? TRUE : FALSE;
	}
	
	public function get_studentfinance_id($enrollment_id = false){
	
		$query = $this->db->where('enrollmentid',$enrollment_id)->get('studentfinances');
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function get($id = false,$array = false,$where = false)
	{
		if($id == false)
		{
			if($array == false)
			{
				if($where == false)
				{
					$query = $this->db->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}else
				{
					$query = $this->db->where($where)->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}
			}else
			{
				if($where == false)
				{
					$query = $this->db->select($array)->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}else
				{
					$query = $this->db->select($array)->where($where)->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}
			}
		}else
		{
			if($array == false)
			{
				if($where == false)
				{
					$query = $this->db->where('id',$id)->get($this->_table);
					return $query->num_rows() > 0 ? $query->row() : FALSE;
				}else
				{
					$query = $this->db->where('id',$id)->where($where)->get($this->_table);
					return $query->num_rows() > 0 ? $query->row() : FALSE;
				}
			}else
			{	
				if($where == false)
				{
					$query = $this->db->select($array)->where('id',$id)->get($this->_table);
					return $query->num_rows() > 0 ? $query->row() : FALSE;
				}else
				{
					$query = $this->db->select($array)->where('id',$id)->where($where)->get($this->_table);
					return $query->num_rows() > 0 ? $query->row() : FALSE;
				
				}
			}
		}
	}
	
	public function delete_student_payment($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}




/*
total payment += total payment;
total balance = total payment - total balance
less deduction = 
*/

?>
