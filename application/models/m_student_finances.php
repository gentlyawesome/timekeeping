<?php
	
class M_student_finances Extends CI_Model
{
	private $__table = 'studentfinances';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_student_finance($data)
	{
		$sql = "select studentfinances.id, coursefinances.category2
				FROM studentfinances
				LEFT JOIN coursefinances ON coursefinances.id = studentfinances.coursefinance_id
				WHERE studentfinances.enrollmentid = ?";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function get_student_fees($data)
	{
		$sql = "select studentfees.*, fees.name, fees.is_misc, fees.is_other
				FROM studentfinances
				LEFT JOIN studentfees ON studentfees.studentfinance_id = studentfinances.id
				LEFT JOIN fees ON studentfees.fee_id = fees.id
				WHERE studentfinances.enrollmentid = ?";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function add_student_finance($input)
	{
		$this->db->insert($this->__table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function delete_student_finance($data)
	{
		$this->db->where('enrollmentid', $data);
		$this->db->delete('studentfinances'); 
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
}
