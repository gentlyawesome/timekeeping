<?php

class M_coursefinances Extends CI_Model
{
	private $_table = 'coursefinances';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function find_all($array = false)
	{
		$method = 'result';
		if($array){ $method = 'result_array'; }
		$sql = "select *
				FROM $this->_table
				ORDER BY category2";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->$method() : FALSE;
	}
	
	public function create_coursefinances($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function get_coursefinances($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function get_coursefinances_category($category = false)
	{
		$sql = "select category2
				FROM $this->_table
				WHERE category = ?
				LIMIT 1";
		$query = $this->db->query($sql,array($category));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
		
		
	}
	
	public function update_coursefinances($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_coursefinances($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}


}