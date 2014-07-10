<?php
	
class M_student_previous_accounts Extends CI_Model
{
private $_table = "student_previous_accounts";
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_student_previous_accounts($data)
	{
		$sql = "select *
				FROM student_previous_accounts
				WHERE enrollment_id = ?";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	
	public function find_all($id)
	{
		$sql = "select 	*
				FROM $this->_table
				WHERE student_previous_accounts.enrollment_id = ?
				ORDER BY id";
		$query = $this->db->query($sql, array($id));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function create($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}
