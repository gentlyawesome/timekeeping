<?php

class M_block_section_settings extends CI_Model
{
	private $_table = 'block_system_settings';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_all_list()
	{
		$sql = "SELECT open_semesters.use,open_semesters.id, CONCAT( academic_years.year_from,  ' - ', academic_years.year_to ) AS academic_year, semesters.name FROM open_semesters
				LEFT JOIN academic_years ON (academic_years.id = open_semesters.academic_year_id) 
				LEFT JOIN semesters ON (semesters.id = open_semesters.semester_id) 
				";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function find_all()
	{
		$sql = "select 	
					id,
					name,
					created_at,
					updated_at
				FROM $this->_table
				ORDER BY name";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	function get_ay_sem()
	{
		$sql = "SELECT CONCAT( ay.year_from,  ' - ', ay.year_to ) AS academic_year, s.name, ay.year_from,ay.year_to,semester_id
					 FROM  `open_semesters` AS os
					RIGHT JOIN semesters AS s ON s.id = os.semester_id
					RIGHT JOIN academic_years AS ay ON ay.id = os.academic_year_id
					WHERE os.use =1
					LIMIT 1";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	function update_open_semester_userId($open_semester_id,$userid)
	{
		$input['open_semester_id'] = $open_semester_id;
		$input['updated_at'] = NOW;

		$this->db->where('user_id', $userid);
		$this->db->update('open_semester_employee_settings', $input); 
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	function insert_open_semester_userId($open_semester_id,$userid)
	{
		$input['open_semester_id'] = $open_semester_id;
		$input['user_id'] = $user_id;
		$input['created_at'] = NOW;
		$input['updated_at'] = NOW;

		$this->db->insert('open_semester_employee_settings', $input); 
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function create_block_section_settings($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function get_block_section_settings($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function update_block_section_settings($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_open_semesters($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function reset_open_semester(){
		$sql = "UPDATE
				$this->_table
				SET `use` = ?";
		$query = $this->db->query($sql,array('0'));
	}
}

?>