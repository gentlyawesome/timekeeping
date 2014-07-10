<?php
	
class M_demands_return_lost Extends My_Model
{
	protected $_table = 'demands_return_lost';

	public function create_demands_return_lost($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function get_demands_return_lost($id = false)
	{
		$sql = "select 
					*
				FROM $this->_table
				WHERE $this->_table.id = ?
				ORDER BY $this->_table.id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function get_demands_return_lost_by_demand_id($id)
	{
		$sql = "select 
					*
				FROM $this->_table
				WHERE $this->_table.demands_id = ?
				ORDER BY $this->_table.id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function update_demands_return_lost($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_demands_return_lost($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
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
		$fields_array[] = 'users.name';
		$fields_array[] = 'items.item';
		// $fields_array[] = 'demands.unit_left';
		// $fields_array[] = 'demands.category';
		// $fields_array[] = 'demands.serial';
		// $fields_array[] = 'demands.purchase_price';
		
		$param = array();
		if($filter != false){
			//if filter is array
			if(is_array($filter)){
				foreach($filter as $key => $value){
		
					$param[$key] = $value;
				}
			}
			
		}
		
		$this->db->select($fields_array);
		$this->db->from($this->_table);
		$this->db->where($param);
		$this->db->order_by("demands.date", "DESC"); 
		$this->db->join('users', 'users.id = '.$this->_table.'.user_id','LEFT');
		$this->db->join('items', 'items.id = '.$this->_table.'.item_id','LEFT');
		
		
		if($all == false){
			$this->db->limit($limit, $start);
		}
		
		$query = $this->db->get();
		// vp($this->db->last_query());
		if($ret_count == false){
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}else{
			return $query->num_rows();
		}
	}
}