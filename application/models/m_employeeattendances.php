<?php

class M_employeeattendances Extends CI_Model
{
	private $_table = 'employeeattendances';
	
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
	
	public function find_all()
	{
		//print_r($data);
		$sql = "select *
				FROM $this->_table
				ORDER BY id";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function create_employeeattendances($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function get_employeeattendances($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function get_employeeattendances_bydate($year, $month, $day)
	{
		$sql = "select 
					$this->_table.id,
					$this->_table.reason,
					$this->_table.start_date,
					$this->_table.end_date,
					$this->_table.employee_id,
					$this->_table.month,
					$this->_table.day,
					$this->_table.year,
					$this->_table.timein,
					$this->_table.timeout,
					CONCAT(employees.last_name,',',employees.first_name,' ',employees.middle_name) AS `name`
				FROM $this->_table
				LEFT JOIN employees ON (employees.id = $this->_table.employee_id)
				WHERE $this->_table.year = ?
				AND $this->_table.month = ?
				AND $this->_table.day = ?
				ORDER BY $this->_table.id";
		// echo "<pre>";
		// var_dump($sql);
		// echo "</pre>";
		$query = $this->db->query($sql,array($year, $month, $day));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function update_employeeattendances($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_employeeattendances($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}


}