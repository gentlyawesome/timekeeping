<?php

class M_open_semester_employee_settings Extends CI_Model
{
	private $_table = 'open_semester_employee_settings';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_open_semester_userId($id){
		$sql = "SELECT open_semester_id,id FROM open_semester_employee_settings WHERE user_id = '$id'";
		$q = $this->db->query($sql); 
		
		return $q->num_rows() >= 1 ? $q->row() : FALSE;
	}
	
	public function update_open_semester_employee_settings($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_open_semester_employee_settings($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function create_open_semester_employee_settings($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
}
