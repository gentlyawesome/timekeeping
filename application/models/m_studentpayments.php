<?php

class M_studentpayments Extends CI_Model
{

	private $_table = 'studentpayments';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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

	public function get_sum_student_payments($data)
	{
		$sql = "select SUM(account_recivable_student) as account_recivable_student
				FROM studentpayments
				WHERE enrollmentid = ?
				";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function get_count_student_payments($data)
	{
		$sql = "select count(id) as payment_count
				FROM studentpayments
				WHERE enrollmentid = ?
				";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->row()->payment_count : FALSE;
	}
	
	public function destroy_payment_record($pid,$eid)
	{
		$this->db->where('id',$pid)->where('enrollmentid',$eid)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	
	}
	
	public function get_payments_bydate($date_from, $date_to)
	{
		$sql = "
			SELECT 
			*
			FROM $this->_table
			WHERE DATE(`date`)
			BETWEEN ? AND ?
		";
		$query = $this->db->query($sql,array($date_from, $date_to));
		
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function get_payments_enrollment_id($enrollmentid = false)
	{
		$sql = "
			SELECT 
			*
			FROM $this->_table
			WHERE enrollmentid = ?
			ORDER BY id
		";
		
		$query = $this->db->query($sql,array($enrollmentid));
		
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function get_group_payments_bydate($date_from, $date_to)
	{	
		$sql = "
			SELECT 
				$this->_table.or_no,
				$this->_table.group_or_no,
				$this->_table.student_id,
				$this->_table.account_recivable_student,
				$this->_table.remarks,
				enrollments.name
			FROM $this->_table
			LEFT JOIN enrollments ON enrollments.id = $this->_table.enrollmentid
			WHERE 
			$this->_table.account_recivable_student > 0 AND
			DATE($this->_table.date)
			BETWEEN ? AND ?
		";
		$query = $this->db->query($sql,array($date_from, $date_to));
		
		$data['account_recivable_student'] = $query->num_rows() > 0 ? $query->result() : FALSE;
		
		$sql = "
			SELECT 
				$this->_table.or_no,
				$this->_table.group_or_no,
				$this->_table.student_id,
				$this->_table.account_recivable_student,
				$this->_table.remarks,
				enrollments.name
			FROM $this->_table
			LEFT JOIN enrollments ON enrollments.id = $this->_table.enrollmentid
			WHERE 
			$this->_table.old_account > 0 AND
			DATE($this->_table.date)
			BETWEEN ? AND ?
		";
		$query = $this->db->query($sql,array($date_from, $date_to));
		
		$data['old_account'] = $query->num_rows() > 0 ? $query->result() : FALSE;
		
		$sql = "
			SELECT 
				$this->_table.or_no,
				$this->_table.group_or_no,
				$this->_table.student_id,
				$this->_table.account_recivable_student,
				$this->_table.remarks,
				enrollments.name
			FROM $this->_table
			LEFT JOIN enrollments ON enrollments.id = $this->_table.enrollmentid
			WHERE 
			$this->_table.other > 0 AND
			DATE($this->_table.date)
			BETWEEN ? AND ?
		";
		$query = $this->db->query($sql,array($date_from, $date_to));
		
		$data['other'] = $query->num_rows() > 0 ? $query->result() : FALSE;
		
		return $data;
	}
	
	public function count_all_updaid_enrollments(){
		
		$ci =& get_instance();
		$semester_id = $ci->open_semester->id;
		$sy_from = $ci->open_semester->year_from;
		$sy_to = $ci->open_semester->year_to;
		
		$sql="SELECT e.id,e.name, e.studid, years.year, courses.course
						   FROM enrollments AS e
						   LEFT JOIN years ON years.id = e.year_id
						   LEFT JOIN courses ON courses.id = e.course_id
						   WHERE 
						   e.semester_id = ?
						   AND e.sy_from = ?
						   AND e.sy_to = ?
						   AND full_paid <> 1
						   ORDER BY e.name ASC"
						   ;
		$query = $this->db->query($sql,array($semester_id,$sy_from, $sy_to ));
		
		return $query->num_rows();
	}
}

