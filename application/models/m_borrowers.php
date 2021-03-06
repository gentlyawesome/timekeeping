<?php

class M_borrowers Extends CI_Model
{
	private $_table = 'borrowers';
	
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
	
	public function find_all($start=0,$limit=100, $filter = false, $all = false, $ret_count = false){
		
		$start = $this->db->escape_str($start);
		$limit = $this->db->escape_str($limit);
		$ci =& get_instance();
		
		//ADD FILTERS
		$xfilter = "";
		$param = array();
		if($filter != false){
			//if filter is array
			if(is_array($filter)){
				foreach($filter as $key => $value){
					$xfilter .= " $key ? ";
					$param[] = $value;
				}
			}
			else{ //if filter is string
				$xfilter = $filter;
			}
			
		}
		
		$sql="SELECT 
			*
			FROM $this->_table
			WHERE TRUE
			$xfilter
			ORDER BY id";
		if($all == false){
			$sql .= " LIMIT ".$start.",".$limit;
		}
		
		$query = $this->db->query($sql,$param);
		// vp($this->db->last_query());
		if($ret_count == false){
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}else{
			return $query->num_rows();
		}
	}
	
	public function create_borrowers($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function get_borrowers($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function get_borrowers_by_libcard_id($id = false)
	{
		$sql = "select 
				$this->_table.id, 
				$this->_table.users_id, 
				$this->_table.date_due, 
				$this->_table.librarycard_id, 
				$this->_table.date_return, 
				$this->_table.date_borrowed, 
				$this->_table.date_to_be_returned,
				users.name
				FROM $this->_table
				LEFT JOIN users ON users.id = $this->_table.users_id
				WHERE $this->_table.librarycard_id = ?
				ORDER BY $this->_table.id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function update_borrowers($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_borrowers($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}


}