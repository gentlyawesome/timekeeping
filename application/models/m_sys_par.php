<?php

class M_sys_par Extends MY_Model
{
	protected $_table = 'sys_par';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_sys_par()
	{
		$sql = "select *
				FROM $this->_table
				LIMIT 1";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
}