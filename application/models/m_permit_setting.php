<?php

class M_permit_setting extends CI_Model{


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_settings(){
		$q = $this->db->get('permit_settings');
		return $q->num_rows() >= 1 ? $q->row() : FALSE;
	}

}

?>