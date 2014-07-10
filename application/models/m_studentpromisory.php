<?php

class M_studentpromisory Extends CI_Model
{
	private $_table = 'studentpromisory';
	
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
	
	public function get_all($enrollment_id)
	{
		$sql = "
			SELECT
			*
			FROM $this->_table
			WHERE enrollment_id = ?
			ORDER BY id;
		";
		
		$query = $this->db->query($sql, array($enrollment_id));
		
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	public function find_all($where = false)
	{
		if($where != false)
		{
			$query = $this->db->select('*')->where($where)->get($this->_table);
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}
		else
		{
			$sql = "select *
				FROM $this->_table
				ORDER BY id";
			$query = $this->db->query($sql);
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}
	}
	
	public function create_record($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function get_years($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function update_years($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_years($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}


}