<?php

class M_training_programs Extends CI_Model
{
	private $_table = 'training_programs';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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
	
	public function find_all()
	{
		//print_r($data);
		$sql = "select *
				FROM $this->_table
				ORDER BY id";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function create_training_programs($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function get_training_programs($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function update_training_programs($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_training_programs($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_training_programs_by_employee_id($where = false)
	{
		$this->db->where('employee_id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}


}