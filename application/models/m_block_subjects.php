<?php

class M_block_subjects extends CI_Model
{
	private $_table = 'block_subjects';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function find_all()
	{
		$sql = "select 	
					*
				FROM $this->_table
				ORDER BY id";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function get_block_subjects($id){

		// $query = $this->db->where('block_system_setting_id',$id)->get($this->_table);
		// return $query->num_rows() > 0 ? $query->result() : FALSE;
		
		$sql = "SELECT 
					block_subjects.id,
					block_subjects.subject_id,
					block_subjects.block_system_setting_id,
					subjects.sc_id,
					subjects.units,
					subjects.lec,
					subjects.lab,
					subjects.time,
					subjects.day,
					subjects.room,
					subjects.load,
					subjects.code,
					subjects.subject
				FROM
				$this->_table
				LEFT JOIN subjects ON subjects.id = block_subjects.subject_id
				WHERE block_subjects.block_system_setting_id = ?
				ORDER BY block_subjects.id";
			
		$query = $this->db->query($sql,array($id));
		// echo "<pre>";
		// var_dump($this->db->last_query());
		// echo "</pre>";
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function create_block_subjects($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function update_open_semesters($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_block_subjects($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_all_block_subjects_per_block_section($where = false)
	{
		$this->db->where('block_system_setting_id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}

?>
