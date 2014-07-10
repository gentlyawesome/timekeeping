<?php
	
class M_student_totals Extends CI_Model
{
	private $_table = 'student_totals';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_student_total($data)
	{
#		$sql = "select tuition_fee_per_unit, total_units, less_nstp, tuition_fee, lab_fee_per_unit, total_lab, lab_fee, total_rle, previous_account, total_amount, total_deduction, total_payment, remaining_balance, preliminary, midterm, semi_finals, finals, total_misc_fee, total_other_fee, total_charge,additional_charge
#				FROM student_totals
#				WHERE enrollment_id = ?";
#		$query = $this->db->query($sql,array($data));
#		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function insert_student_total($input)
	{
		$input['created_at'] = NOW;
		$input['updated_at'] = NOW;
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function update_student_totals($data = false, $where = false)
	{
		$this->db->set($data)->where($where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
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
	
	public function delete_student_total($data)
	{
		$this->db->where('enrollment_id', $data);
		$this->db->delete('student_totals'); 
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function get_all_student_totals_remaining_balance_with_profiles()
	{
		$ci =& get_instance();
		$yearf = $ci->open_semester->year_from;
		$yeart = $ci->open_semester->year_to;
		
		$sql = "SELECT concat(p.first_name,' ',p.middle_name,' ',p.last_name) as fullname,st.remaining_balance,st.id as st_id
				FROM student_totals st
				LEFT JOIN enrollments e ON e.id = st.enrollment_id
				LEFT JOIN profiles p ON p.id = e.profile_id
				WHERE YEAR(st.created_at) >= ".$this->db->escape_str($yearf)."
				AND YEAR(st.created_at) <=".$this->db->escape_str($yeart);
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function fetch_remaining_balance_with_profiles($data = false,$start = false,$limit = false)
	{
		$ci =& get_instance();
		$yearf = $ci->open_semester->year_from;
		$yeart = $ci->open_semester->year_to;
		
		if($start !== false AND $data == false)
		{
			$sql = "SELECT concat(p.first_name,' ',p.middle_name,' ',p.last_name) as fullname,st.remaining_balance,st.id as st_id
			FROM student_totals st
			LEFT JOIN enrollments e ON e.id = st.enrollment_id
			LEFT JOIN profiles p ON p.id = e.profile_id
			WHERE YEAR(st.created_at) >= ".$this->db->escape_str($yearf)."
			AND YEAR(st.created_at) <=".$this->db->escape_str($yeart)."
			limit ".$this->db->escape_str($limit).",".$this->db->escape_str($start);
			
			$query = $this->db->query($sql);
			return $query->num_rows() > 0 ? $query->result() : FALSE;
			
		}elseif($data !== false)
		{	
		foreach($data as $k => $v)
		{
			if(!empty($v))
			{
				if($k == 'name')
				{
					$where['p.first_name'] ='%'.$v.'%';
					$where['p.middle_name'] ='%'.$v.'%';
					$where['p.last_name'] ='%'.$v.'%';
				}elseif($k == 'student_id')
				{
					$where['e.studid'] = '%'.$v.'%';
				}
			}	
		}
			
		$columns = implode(' like ? OR ',array_keys($where)).' like ? ';
		$values = array_values($where);
		
		$sql ="SELECT concat(p.first_name,' ',p.middle_name,' ',p.last_name) as fullname, `st`.`remaining_balance`, `st`.`id` as st_id
		FROM (`student_totals` st)
		LEFT JOIN `enrollments` e ON `e`.`id` = `st`.`enrollment_id`
		LEFT JOIN `profiles` p ON `p`.`id` = `e`.`profile_id`
		WHERE 'YEAR(st.created_at)' >= ".$this->db->escape_str($yearf)."
		AND 'YEAR(st.created_at)' <= ".$this->db->escape_str($yeart)." OR
		$columns limit " .$this->db->escape_str($limit).",".$this->db->escape_str($start)."";
		
		$query = $this->db->query($sql,$values);					
		return $query->num_rows() > 0 ? $query->result() : FALSE;				
		}
	}
	
	public function count_searched_student_remaining_balance($data)
	{
		$ci =& get_instance();
		$yearf = $ci->open_semester->year_from;
		$yeart = $ci->open_semester->year_to;
		
		foreach($data as $k => $v)
		{
			if(!empty($v))
			{
				if($k == 'name')
				{
					$where['p.first_name'] ='%'.$v.'%';
					$where['p.middle_name'] ='%'.$v.'%';
					$where['p.last_name'] ='%'.$v.'%';
				}elseif($k == 'student_id')
				{
					$where['e.studid'] = '%'.$v.'%';
				}
			}	
		}
		
		$columns = implode(' like ? OR ',array_keys($where)).' like ?';
		$values = array_values($where);
			
			
		$sql ="SELECT  count(`st`.`id`) as totals
		FROM (`student_totals` st)
		LEFT JOIN `enrollments` e ON `e`.`id` = `st`.`enrollment_id`
		LEFT JOIN `profiles` p ON `p`.`id` = `e`.`profile_id`
		WHERE 'YEAR(st.created_at)' >= ".$this->db->escape_str($yearf)."
		AND 'YEAR(st.created_at)' <= ".$this->db->escape_str($yeart)."
		OR $columns";

		$query = $this->db->query($sql,$values);	
		return $query->num_rows() > 0 ? $query->row()->totals : FALSE;			
	}
}
