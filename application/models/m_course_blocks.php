<?php

class M_course_blocks extends CI_Model
{
	private $_table = 'course_blocks';
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
	
	public function get_course_blocks($id){

		// $query = $this->db->where('block_system_setting_id',$id)->get($this->_table);
		// return $query->num_rows() > 0 ? $query->result() : FALSE;
		$sql = "SELECT
					course_blocks.id,
					course_blocks.year_id,
					course_blocks.course_id,
					course_blocks.semester_id,
					course_blocks.academic_year_id,
					course_blocks.block_system_setting_id,
					years.year,
					courses.course,
					bss.name
				FROM $this->_table
				LEFT JOIN years ON (years.id = course_blocks.year_id) 
				LEFT JOIN courses ON (courses.id = course_blocks.course_id)
				LEFT JOIN block_system_settings bss ON bss.id = course_blocks.block_system_setting_id
				WHERE course_blocks.block_system_setting_id = ?
				ORDER BY course_blocks.id";
			
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
		
	}
	
	public function create_course_blocks($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function delete_course_blocks($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_all_course_blocks_per_block_section($where = false)
	{
		$this->db->where('block_system_setting_id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}

	public function get_current_course_blocks($course_id,$year_id)
	{
		$ci =& get_instance();
		
		$sql = "SELECT
			course_blocks.id,
			block_system_settings.id as block_system_setting_id,
			block_system_settings.name
		FROM course_blocks
		LEFT JOIN block_system_settings ON block_system_settings.id = course_blocks.block_system_setting_id
		WHERE course_blocks.course_id = ?
		AND course_blocks.year_id = ?
		AND course_blocks.semester_id = ?
		AND course_blocks.academic_year_id = ?
		ORDER BY block_system_settings.name";
		$param[0] = $course_id;
		$param[1] = $year_id;
		$param[2] = $ci->open_semester->semester_id;
		$param[3] = $ci->open_semester->academic_year_id;
		$query = $this->db->query($sql, $param);
		// vd($this->db->last_query());
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
}

?>