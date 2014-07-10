<?php
	
class M_departments Extends My_Model
{
	protected $_table = 'departments';
	
	public function get_all_department_for_welcome_screen($visible = false, $array = false)
	{
		$param = array();
		$filter = "";
		
		if($visible != false){
			$param[] = $visible;
			$filter = " AND visible = ?";
		}
		
		$sql = "select *
				FROM $this->_table
				WHERE TRUE
				$filter
				ORDER BY level,ord";
		$query = $this->db->query($sql, $param);
		if($array){
			return $query->num_rows() > 0 ? $query->result_array() : FALSE;
		}else{
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}
	}
	
	public function get_departments_group_by_levels($visible = false, $array = false)
	{
		$param = array();
		$filter = "";
		
		if($visible != false){
			$param[] = $visible;
			$filter = " AND visible = ?";
		}
		
		$sql = "select level
				FROM $this->_table
				WHERE TRUE
				$filter
				GROUP BY level
				ORDER BY level";
		$query = $this->db->query($sql, $param);
		if($array){
			return $query->num_rows() > 0 ? $query->result_array() : FALSE;
		}else{
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}
	}


}