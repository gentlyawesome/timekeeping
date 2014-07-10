<?php
	
class M_assign_courses Extends CI_Model
{

  private $_table = "assign_courses";
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function insert_to_db($data)
	{
	  $this->db->insert($this->_table,$data);
	}
	
	public function get_employee_assigned_courses($id)
	{
	  $sql = "SELECT assign_courses.id, assign_courses.course_id, assign_courses.employee_id, courses.course AS course_name
	          FROM assign_courses
	          LEFT JOIN courses on courses.id = assign_courses.course_id
	          WHERE assign_courses.employee_id = ?";
	          
	  $query = $this->db->query($sql,array($id));
	  return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function delete_from_db($id)
	{
	  $this->db->where('id', $id);
    $this->db->delete($this->_table); 
	}
	
}
