<?php
	
class M_demands Extends My_Model
{
	protected $_table = 'demands';

	public function create_demands($input = false)
	{
		$this->db->insert($this->_table,$input);
		// vd($this->db->last_query());
		$rs = $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
		
		if($rs['status'])
		{
			$data['borrow_no'] = str_pad($rs['id'], 12, "0", STR_PAD_LEFT);
			$this->update_demands($data, $rs['id']);
		}
		
		return $rs;
	}
	
	public function update_demands_status($id = false)
	{
		if($id != false){  
			$bi = $this->get_demands($id);
			if($bi)
			{
				$old_status = strtoupper($bi->status);
				$new_status = "";
				
				$total_return = $bi->unit_return + $bi->unit_lost_return;
				
				if($total_return >= $bi->unit)
				{
					if($bi->unit_lost_return > 0)
					{
						if($bi->unit_return == 0)
						{
							$new_status = "LOST/DAMAGE";
						}
						else
						{
							$new_status = "RETURNED W/ LOST/DAMAGE";
						}
					}
					else
					{
						$new_status = "RETURNED";
					}
				}
				else if($total_return == 0)
				{
					$new_status = "UNRETURN";
				}
				else
				{
					if($bi->unit_lost_return == 0)
					{
						$new_status = "PARTIAL RETURNED";
					}
					else
					{
						$new_status = "PARTIAL RETURNED W/ LOST/DAMAGE";
					}
				}
				
				if($new_status != $old_status)
				{
					$data['updated_at'] = NOW;
					$data['status'] = $new_status;
					$rs = $this->update_demands($data, $id);
				}
			}
		}
		
		return array('status' => 'false');
	}
	
	public function get_demands($id = false)
	{
		$sql = "select 
					$this->_table.id,
					$this->_table.borrow_no,
					$this->_table.date,
					$this->_table.user_id,
					$this->_table.item_id,
					$this->_table.unit,
					$this->_table.unit_return,
					$this->_table.unit_unreturn,
					$this->_table.unit_lost_return,
					$this->_table.price,
					$this->_table.amount,
					$this->_table.status,
					users.name,
					items.item
				FROM $this->_table
				LEFT JOIN users ON users.id = $this->_table.user_id
				LEFT JOIN items ON items.id = $this->_table.item_id
				WHERE $this->_table.id = ?
				ORDER BY $this->_table.id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function update_demands($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_demands($where = false)
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