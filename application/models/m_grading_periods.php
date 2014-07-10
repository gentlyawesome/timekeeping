<?php
class M_grading_periods Extends CI_Model
{
	private $_table = 'grading_periods';
	
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
	
	public function find_all()
	{
		$sql = "select 	
					id,
						grading_period,
						is_set,
						created_at,
						updated_at
				FROM $this->_table
				ORDER BY id";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function create_grading_periods($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function get_grading_periods($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function update_grading_periods($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_grading_periods($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function reset_grading_period(){
		$sql = "UPDATE
				$this->_table
				SET is_set = ?";
		$query = $this->db->query($sql,array('0'));
	}
	
	public function get_current_grading_period()
	{
		$sql = "
			SELECT *
			FROM $this->_table
			WHERE is_set = ?
		";
		
		$query = $this->db->query($sql, array(1));
		
		return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function get_all_array(){
		$sql = "select 	
					id,
						grading_period,
						is_set,
						orders,
						created_at,
						updated_at
				FROM $this->_table
				ORDER BY orders";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result_array() : FALSE;
	}
}