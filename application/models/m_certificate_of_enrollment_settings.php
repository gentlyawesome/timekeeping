<?php
	
class M_certificate_of_enrollment_settings Extends CI_Model
{
	private $__table = 'certificate_of_enrollment_settings';
	
	public function get_certificate_of_enrollment($id=FALSE)
	{
		if($id == FALSE){
			$this->db->select('id, first_paragraph, second_paragraph, signatory, signatory_position');
			$query = $this->db->get($this->__table);
		}else{
			$this->db->select('id, first_paragraph, second_paragraph, signatory, signatory_position');
			$query = $this->db->where('id',$id)->get($this->__table);
		}
		return $query->num_rows() >= 1 ? $query->row() : FALSE;
	}
	
	public function update_certificate_of_enrollment_settings($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->__table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}