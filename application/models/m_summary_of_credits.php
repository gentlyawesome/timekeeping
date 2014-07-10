<?php
	
class M_summary_of_credits Extends CI_Model
{
	private $__table = 'summary_of_credits';
	
	public function get($id=FALSE)
	{
		if($id == FALSE){
			$sql = "SELECT summary_of_credits.id, courses.course FROM summary_of_credits
				LEFT JOIN courses ON (summary_of_credits.course_id = courses.id)
				";
			$query = $this->db->query($sql);
			return $query->num_rows() >= 1 ? $query->result() : FALSE;
		}else{
			$sql = "SELECT id, course_id FROM summary_of_credits
				WHERE (id= '$id')";
			$query = $this->db->query($sql);
			return $query->num_rows() >= 1 ? $query->row() : FALSE;
		}
	}
	
	public function get_courses()
	{
			$sql = "SELECT courses.id, courses.course FROM courses 
				WHERE courses.id NOT IN (SELECT course_id FROM summary_of_credits)
				";
			$query = $this->db->query($sql);
			return $query->num_rows() >= 1 ? $query->result() : FALSE;
	}
	
	public function create_summary_of_credit($input = false)
	{
		$this->db->insert($this->__table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function update_summary_of_credit($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->__table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_summary_of_credits($where = false)
	{
		$this->db->where('id',$where)->delete($this->__table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}