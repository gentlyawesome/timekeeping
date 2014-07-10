<?php

class M_profiles Extends CI_Model
{

	private $_table = 'profiles';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	
	}
	/*
		@id = primary key of data if  false will get all
		@array = columns names to retrieve if false will get all
	*/
		
	public function get($id = false,$array = false)
	{
		if($id == false)
		{
				if($array == false)
				{
					$query = $this->db->get($this->_table);
				}else
				{
					$query = $this->db->select($array)->get($this->_table);
				}
		}else
		{
			if($array == false)
			{
				$query = $this->db->where('id',$id)->get($this->_table);
			}else
			{
				$query = $this->db->select($array)->where('id',$id)->get($this->_table);
			}
		}
		
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	
	public function update_table($data,$id)
	{
		foreach($data as $key => $value)
		{
			$columns_array[] = $key; 
		}
		$columns = implode(',',$columns_array);
		$query = $this->db->select($columns)->where($data)->get($this->_table);
		if($query->num_rows() > 0)
		{
			return true;
		}else
		{
			$this->db->set($data)->where('id',$id)->update($this->_table);
			return $this->db->affected_rows() > 0 ? TRUE : FALSE;
		}
	}






}