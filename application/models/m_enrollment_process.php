<?php

class M_enrollment_process Extends CI_Model
{
	private $ci;
	private $user_table = 'users';
	private $prof_table = 'profiles';
	private $enroll_table = 'enrollments';
	
	private $user_id;
	private $profile_id;
	private $enrollment_id;
	
	public function __construct()
	{
		parent::__construct();
		$this->ci =& get_instance();
	
	}
	public function insert_to_enrollment_table($data)
	{
		$this->db->insert($this->enroll_table,$data);
		$this->enrollment_id = $this->db->insert_id();
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function insert_to_student_profiles($data)
	{
		$data['user_id'] = $this->get_user_id();
		$data['created_at'] = NOW;
		$data['updated_at'] = NOW;
		$this->db->insert($this->prof_table,$data);
		$this->profile_id = $this->db->insert_id();
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function insert_to_user($datas)
	{
		$this->db->insert($this->user_table,$datas);
		$this->user_id = $this->db->insert_id();
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function get_subject_block_sections($data)
	{
		$sql = 'SELECT id AS section_id, name AS section_name
				FROM  `block_system_settings` 
				WHERE year_id	= ?
				AND semester_id = ?
				AND course_id	= ?';
		$query = $this->db->query($sql,$data);
		// vd($this->db->last_query());
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function insert_student_subject($data)
	{
		$sql = 'INSERT INTO studentsubjects (subject_id,enrollment_id,year_id,semester_id,course_id,enrollmentid)
				SELECT subject_id,?,?,?,?,?
				FROM block_subjects
				WHERE block_system_setting_id = ?';
		$this->db->query($sql,$data);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	
	public function test_id($id)
	{
		$sql = 'SELECT studid from enrollments where studid = ? limit 1';
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? TRUE : FALSE;
	}
	
	public function get_profile_id()
	{
		return $this->profile_id;
	}
	
	public function get_user_id()
	{
		return $this->user_id;
	}
	
	public function get_enrollment_id()
	{
		return $this->enrollment_id;
	}
	
	// deletion
	public function delete_user_row($id)
	{
		$this->db->where('id',$id)->delete($this->user_table);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function delete_enrollment_row($id)
	{
		$this->db->where('id',$id)->delete($this->enroll_table);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function delete_profile_row($id)
	{
		$this->db->where('id',$id)->delete($this->prof_table);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	
}
