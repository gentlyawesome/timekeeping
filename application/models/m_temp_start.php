<?php

class M_temp_start Extends MY_Model
{
	protected $_table = 'temp_start';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function delete_temp_start_by_studid($id)
	{
		$this->db->where('studid',$id)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_temp_start($id)
	{
		$this->db->where('id',$id)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function get_temp_start($studid)
	{
		$query = $this->db->where('studid', $studid)->get($this->_table);
		return $query->num_rows() > 0 ? $query->row() : false;
	}
}