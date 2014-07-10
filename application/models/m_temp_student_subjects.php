<?php
class M_temp_student_subjects Extends MY_Model
{
	protected $_table = 'temp_studentsubjects';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function reset_student_subjects($id)
	{
		$sql = "
			DELETE
			FROM $this->_table
			WHERE temp_start_id = ?
		";
		$query = $this->db->query($sql, array($id));
		return $this->db->affected_rows() > 0 ? true : false;
	}
	
	public function get_temp_student_subjects($id)
	{
		$sql = "
			SELECT
			*
			FROM $this->_table
			WHERE temp_start_id = ?
		";
		
		$query = $this->db->query($sql, array($id));
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	public function get_block_system_setting_id($id)
	{
		$sql = "
			SELECT
			t.id,
			b.name
			FROM $this->_table t
			LEFT JOIN block_system_settings b on b.id = t.block_system_setting_id
			WHERE temp_start_id = ?
			AND t.block_system_setting_id <> ''
			LIMIT 1
		";
		
		$query = $this->db->query($sql, array($id));
		return $query->num_rows() > 0 ? $query->row() : false;
	}
}
