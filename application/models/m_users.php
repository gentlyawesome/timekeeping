<?php

class M_users extends MY_Model{

  	protected $_table = "users";

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	function get_profile($id){
		$q = $this->db->where('id', $id)->where('is_active', 1)->get('users');
		if($q->num_rows() >= 1){
			$row = $q->row();
			
			//GET USER DATA AND PUT IT TO SESSION
			$userdata = array(
						'userid' => $row->id,
						'username' => $row->name,
						'userlogin' => $row->login,
						'is_admin' => $row->admin,
						'logged_in' => TRUE
					);
			
			$this->session->set_userdata($userdata);
			
			
			return true;
		}else{
			return false;
		}
	}
}

?>
