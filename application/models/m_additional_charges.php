<?php
	
class M_additional_charges Extends CI_Model
{
  private $_table = 'additional_charges';
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_total_by_enrollment_id($data)
	{
		$sql = "SELECT value
		        FROM additional_charges
		        WHERE additional_charges.enrollment_id = ?";
		        
		$query = $this->db->query($sql,$data);
		
		
		$value = 0.0;
		if ($query->num_rows() > 0) {
		  foreach ($query->result() as $row) {
		    $value += $row->value;
		  }
		}
		return $value;
	}
	
	public function get_additional_charge($data)
	{
		$sql = "SELECT *
		        FROM additional_charges
		        WHERE additional_charges.enrollment_id = ?";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function get_additional_charge_total($data)
	{
		$sql = "SELECT SUM(value) as total
		        FROM additional_charges
		        WHERE additional_charges.enrollment_id = ?";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->row()->total : FALSE;
	}
	
	
#	public function get($id = false,$array = false)
#	{
#		if($id == false)
#		{
#				if($array == false)
#				{
#					$query = $this->db->get($this->_table);
#					return $query->num_rows() > 0 ? $query->result() : FALSE;
#				}else
#				{
#					$query = $this->db->select($array)->get($this->_table);
#					return $query->num_rows() > 0 ? $query->result() : FALSE;
#				}
#		}else
#		{
#			if($array == false)
#			{
#				$query = $this->db->where('id',$id)->get($this->_table);
#				return $query->num_rows() > 0 ? $query->row() : FALSE;
#			}else
#			{
#				$query = $this->db->select($array)->where('id',$id)->get($this->_table);
#				return $query->num_rows() > 0 ? $query->row() : FALSE;
#			}
#		}
#		
#	}
	
	public function find_all($id)
	{
		$sql = "select 	*
				FROM $this->_table
				WHERE additional_charges.enrollment_id = ?
				ORDER BY id";
		$query = $this->db->query($sql, array($id));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function create($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function get($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function update($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}
