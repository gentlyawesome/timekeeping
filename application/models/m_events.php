<?php
	
class M_events Extends CI_Model
{
	private $__table = 'events';
	private $_table = 'events';
	
	public function count_events()
	{
		return $this->db->count_all($this->__table);
	}
	
	public function get_events($id=FALSE)
	{
		if($id == FALSE){
			$query = $this->db->get($this->__table);
			return $query->num_rows() >= 1 ? $query->result() : FALSE;
		}else{
			$query = $this->db->where('id',$id)->get($this->__table);
			return $query->num_rows() >= 1 ? $query->row() : FALSE;
		}
	}
	
	public function create_event($input = false)
	{
		$this->db->insert($this->__table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function update_event($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->__table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	public function delete_event($where = false)
	{
		$this->db->where('id',$where)->delete($this->__table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function find($start=0,$limit=100, $filter = false, $all = false, $ret_count = false){
		
		$start = $this->db->escape_str($start);
		$limit = $this->db->escape_str($limit);
		$ci =& get_instance();
		
		//GET Library FIELDS
		$sql = "DESCRIBE $this->_table";
		$query = $this->db->query($sql);
		$fields = $query->result();
		$fields_array = array();
		foreach($fields as $val){
			
			$fields_array[] = $this->_table.'.'.$val->Field;
		}
		
		//ADD FILTERS
		// $fields_array[] = 'users.name';
		
		$param = array();
		if($filter != false){
			//if filter is array
			if(is_array($filter)){
				foreach($filter as $key => $value){
		
					$param[$key] = $value;
				}
			}
			
		}
		
		if(is_string($filter)){
			$param = $filter;
		}
		
		$this->db->select($fields_array);
		$this->db->from($this->_table);
		$this->db->where($param);
		$this->db->order_by("events.created_at", "DESC"); 
		// $this->db->join('users', 'users.id = '.$this->_table.'.user_id','LEFT');
		
		
		if($all == false){
			$this->db->limit($limit, $start);
		}
		
		$query = $this->db->get();
		// vd($this->db->last_query());
		if($ret_count == false){
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}else{
			return $query->num_rows();
		}
	}
}