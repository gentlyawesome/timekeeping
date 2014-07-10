<?php
	
class M_coursefees Extends CI_Model
{
	private $_table = 'coursefees';
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
	
	public function get_coursefees($id){
		$sql = "SELECT 
					coursefees.id,
					coursefees.coursefinance_id,
					coursefees.fee_id,
					coursefinances.category2,
					coursefees.value,
					fees.name
				FROM coursefees
				LEFT JOIN fees ON (fees.id = coursefees.fee_id)
				LEFT JOIN coursefinances ON (coursefinances.id = coursefees.coursefinance_id)
				WHERE coursefees.id = ?
				ORDER BY coursefees.id";
			
		$query = $this->db->query($sql,array($id));
		// var_dump($this->db->last_query());
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function get_all_course_fees($data)
	{
		$sql = "select 
					coursefees.id, 
					coursefees.fee_id, 
					fees.name, 
					coursefees.value, 
					fees.is_misc, 
					fees.is_lab, 
					fees.is_other, 
					fees.position,
					fees.is_tuition_fee,
					fees.is_nstp
				  FROM coursefees
				  LEFT JOIN fees ON coursefees.fee_id = fees.id
				  WHERE coursefees.coursefinance_id = ?";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}

	public function get_course_fee_by_finance_id($id){
		$sql = "SELECT 
					coursefees.id,
					coursefees.coursefinance_id,
					coursefees.fee_id,
					coursefees.value,
					fees.name
				FROM coursefees
				LEFT JOIN fees ON (fees.id = coursefees.fee_id)
				WHERE coursefees.coursefinance_id = ?
				ORDER BY coursefees.id";
			
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function create_coursefees($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function update_coursefees($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_coursefees($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_all_by_coursefinance_id($where = false)
	{
		$this->db->where('coursefinance_id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}
