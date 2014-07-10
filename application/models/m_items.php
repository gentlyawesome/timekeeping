<?php
	
class M_items Extends My_Model
{
	protected $_table = 'items';

	public function create_items($input = false)
	{
		$this->db->insert($this->_table,$input);
		// vd($this->db->last_query());
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function get_items($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function update_items($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_items($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}

	public function find($start=0,$limit=100, $filter = false, $all = false, $ret_count = false){
		
		$start = $this->db->escape_str($start);
		$limit = $this->db->escape_str($limit);
		$ci =& get_instance();
		
		//GET Library FIELDS
		// $sql = "DESCRIBE $this->_table";
		// $query = $this->db->query($sql);
		// $fields = $query->result();
		// $fields_array = array();
		// foreach($fields as $val){
			
			// $fields_array[] = $this->_table.'.'.$val->Field;
		// }
		
		//ADD FILTERS
		$fields_array[] = 'items.id';
		$fields_array[] = 'items.item';
		$fields_array[] = 'items.unit_left';
		$fields_array[] = 'items.category';
		$fields_array[] = 'items.serial';
		$fields_array[] = 'items.purchase_price';
		
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
		$this->db->order_by("items.item", "ASC"); 
		// $this->db->join('librarycategory', 'librarycategory.id = '.$this->_table.'.librarycategory_id','LEFT');
		
		
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
	
	public function update_item_status($id)
	{
		//CHECK Unit left with maxinum and mininum
		
		$item = $this->get_items($id);
		
		if($item)
		{
			$maximum = (float)$item->max;
			$mininum = (float)$item->min;
			
			$unit_left = (float)$item->unit_left;
			
			$status = "";
			
			// if($unit_left > $maximum){
				// $status = "REACHED MAXIMUM";
			// }
			if($maximum == $unit_left){
				$status = "STABLE";
			}
			else
			{
				if($unit_left <= $mininum)
				{
					$status = "NEEDS RE-STOCKING";
				}
				else{
					$status = "STABLE";
				}
			}
			
			if($status != "")
			{
				$data['status'] = $status;
				$data['updated_at'] = NOW;
				
				$rs = $this->update_items($data, $id);
			}
		}
	}
}