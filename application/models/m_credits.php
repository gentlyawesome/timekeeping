<?php
	
class M_credits Extends CI_Model
{
	private $__table = 'credits';
	
	public function get($id=FALSE)
	{
		if($id == FALSE){
			$sql = "SELECT courses.course, credits.subject, credits.value, credits.id, credits.summary_of_credit_id FROM credits
				LEFT JOIN summary_of_credits ON (credits.summary_of_credit_id = summary_of_credits.id)
				LEFT JOIN courses ON (summary_of_credits.course_id = courses.id)
				";
			$query = $this->db->query($sql);
			return $query->num_rows() >= 1 ? $query->result() : FALSE;
		}else{
			$sql = "SELECT courses.course, credits.subject, credits.value, credits.id, credits.summary_of_credit_id FROM credits
				LEFT JOIN summary_of_credits ON (credits.summary_of_credit_id = summary_of_credits.id)
				LEFT JOIN courses ON (summary_of_credits.course_id = courses.id)
				WHERE (credits.summary_of_credit_id = '$id')";
			$query = $this->db->query($sql);
			return $query->num_rows() >= 1 ? $query->result() : FALSE;
		}
	}
	
	public function get_credits($id=FALSE)
	{
		if($id == FALSE){
			$sql = "SELECT subject, value, id, summary_of_credit_id FROM credits
				";
			$query = $this->db->query($sql);
			return $query->num_rows() >= 1 ? $query->result() : FALSE;
		}else{
			$sql = "SELECT subject, value, id, summary_of_credit_id FROM credits
				WHERE (id = '$id')";
			$query = $this->db->query($sql);
			return $query->num_rows() >= 1 ? $query->row() : FALSE;
		}
	}
	
	public function create_credit($input)
	{
		$this->db->insert($this->__table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function update_credit($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->__table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_credits($where = false)
	{
		$this->db->where('id',$where)->delete($this->__table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}