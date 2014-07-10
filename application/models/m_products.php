<?php
	
class M_products Extends CI_Model
{
	private $__table = 'products';

	public function get_products($id = FALSE)
	{
		if($id == FALSE){
			$sql = "SELECT id, product, min, max FROM products
				";
			$query = $this->db->query($sql);
			return $query->num_rows() >= 1 ? $query->result() : FALSE;
		}else{
			$sql = "SELECT id, product, min, max FROM products
				WHERE (id = '$id')";
			$query = $this->db->query($sql);
			return $query->num_rows() >= 1 ? $query->row() : FALSE;
		}
	}
}