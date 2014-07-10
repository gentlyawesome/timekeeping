<?php
class M_companyinfo extends MY_Model{

	protected $_table = 'companyinfo';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_info(){
		$q = $this->db->get($this->_table);
		return $q->num_rows() >= 1 ? $q->row() : FALSE;
	}
}
?>