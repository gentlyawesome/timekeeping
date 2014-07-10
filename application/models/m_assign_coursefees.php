<?php
	
class M_assign_coursefees Extends CI_Model
{
	private $_table = 'assign_coursefees';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_assign_course_fee($data)
	{
		//print_r($data);
		$sql = "select coursefinance_id
				FROM assign_coursefees
				WHERE year_id = ? AND course_id = ? AND semester_id = ? AND academic_year_id = ?";
		$query = $this->db->query($sql,$data);
		return $query->num_rows() > 0 ? $query->row() : FALSE;
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
	
	public function get_all_by_coursefinance_id($id = false)
	{
		$sql = "select
				$this->_table.id,
				$this->_table.year_id,
				years.year,
				$this->_table.course_id,
				courses.course
				FROM $this->_table
				LEFT JOIN years ON years.id = $this->_table.year_id
				LEFT JOIN courses on courses.id = $this->_table.course_id
				WHERE $this->_table.coursefinance_id = ?
				ORDER BY $this->_table.id";
				// vd($sql);
		$query = $this->db->query($sql, array($id));
		
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
	
	public function create_assign_coursefees($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function get_assign_coursefees($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function update_assign_coursefees($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_assign_coursefees($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}