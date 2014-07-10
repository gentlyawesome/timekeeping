<?php
	
class M_student_fees Extends CI_Model
{
	private $_table = 'studentfees';
	private $st = 'student_totals';
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	
	}
	
	
	
	public function get_student_fees($data)
	{
		$sql = "select 
					studentfees.id ,
					studentfees.value,
					is_misc,
					is_lab,
					is_other,
					is_nstp,
					is_tuition_fee,
					name, 
					studentfees.studentfinance_id
				  FROM studentfees
				  LEFT JOIN fees ON studentfees.fee_id = fees.id
				  WHERE studentfees.studentfinance_id = ?";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function destroy_fee($sfid,$fid,$eid)
	{
		// get student fee value
		$query	 = $this->db->select('value')
									->where('id',$fid)
									->where('studentfinance_id',$sfid)
									->get('studentfees');
		$value 		 = $query->num_rows() > 0 ? $query->row()->value : 0 ;
		$balance 	 = $this->get_total_and_balance($eid)->remaining_balance; // get remaining balance and total payment charge
		$total	 	 = $this->get_total_and_balance($eid)->total_amount; // get remaining balance and total payment charge
		
		
		$update['remaining_balance'] = $balance - $value;
		$update['total_amount'] 	    = $total - $value;
		

		$this->db->set($update)->where('enrollment_id',$eid)->update($this->st);
		if($this->db->affected_rows() > 0)
		{
			$this->db->delete($this->_table, array('id' => $fid));
			if($this->db->affected_rows() > 0)
			{
				return array('status'=>'true','log'=>'Fee was successfully destroyed');
			}else{
				return array('status'=>'false','log'=>'Unable to update student finance');
			}
		}else{
			return array('status'=>'false','log'=>'Unable to update student totals');
		}
	}
	
	public function delete_all_fees($studfinanceid)
	{
		$this->db->where('studentfinance_id', $studfinanceid);
		$this->db->delete('studentfees'); 
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	private function get_total_and_balance($id)
	{
		$query = $this->db->select(array('remaining_balance','total_amount'))->where('enrollment_id',$id)->get($this->st);
		return $query->num_rows() > 0 ? $query->row() : 0 ;
	}
	
	public function get_unassigned_fees($id)
	{
		$sql = "	SELECT id, name , value
					FROM fees
					WHERE id NOT IN (
												SELECT fee_id
												FROM studentfees
												WHERE studentfees.studentfinance_id = ?
											)
					ORDER BY  `fees`.`id` ASC ";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function assign_fees($data,$sfid,$eid)
	{
		
		$val = array_values($data); // get post values as array
		$where = trim(substr(str_repeat(' fees.id = ? OR ',count($val)),0,-3));
		
		// get  the sum total of fees
		$sql = " SELECT sum(fees.value) as fee_total
				  FROM fees
				  WHERE $where";
		$query = $this->db->query($sql,$val);
		$totalfee = $query->num_rows() > 0 ? $query->row()->fee_total : 0;
		
		// Get data from fee for selected fees and insert on studentfees table
		$sql = "INSERT INTO studentfees (studentfinance_id,fee_id,value,created_at)
				  SELECT '$sfid',fees.id,fees.value,now()
				  FROM fees
				  WHERE $where";
		$this->db->query($sql,$data);
		// if Insert to new table was successful update studenttotals table
		if($this->db->affected_rows() > 0)
		{
			$balance 	 = $this->get_total_and_balance($eid)->remaining_balance; // get remaining balance 
			$total	 	 = $this->get_total_and_balance($eid)->total_amount; // get total amount of payable
			
			$update['remaining_balance'] = $balance + $totalfee; // calculate remainng balance ,added total fee
			$update['total_amount'] 	    = $total + $totalfee; // calculate total_amount, added total fee
			// update student_totals
			$this->db->set($update)->where('enrollment_id',$eid)->update($this->st);
			if($this->db->affected_rows() > 0)
			{
				
				return array('status'=>'true','log'=>' Added FEES total '.$totalfee.'; Fee ID(s): '.implode(',',$val).'; ');
			}else{
				return array('status'=>'false','log'=>'Unable to update student totals remaning_balance and total amount with '.$totalfee.'; Fee ID(s): '.implode(',',$val).'; ');
			}
		}else{
			return array('status'=>'false','log'=>'Unable to insert to student fees Fee ID(s): '.implode(',',$val).'; ');
		}
	}
	
	public function insert_student_fees($input)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	
	////////////////////////////////
	// BSBT Customization
	///////////////////////////////
	public function get_custom_course_fee($data, $type)
	{
	  $value = 0.0;
	  foreach ($data as $row) {
	    if (strpos(strtolower($row->name),strtolower($type)) !== false) {
	      $value += $row->value;
	    }
	  }
	  
	  return $value;
	}
}
