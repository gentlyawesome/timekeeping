<?php

class M_temp_payment Extends MY_Model
{
	protected $_table = 'temp_payment';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function reset_temp_payment($id)
	{
		$sql = "
			DELETE
			FROM $this->_table
			WHERE temp_start_id = ?
		";
		$query = $this->db->query($sql, array($id));
		return $this->db->affected_rows() > 0 ? true : false;
	}
	
	public function get_temp_payment($id)
	{
		$sql = "
			SELECT
			*
			FROM $this->_table
			WHERE temp_start_id = ?
		";
		
		$query = $this->db->query($sql, array($id));
		return $query->num_rows() > 0 ? $query->row() : false;
	}
}