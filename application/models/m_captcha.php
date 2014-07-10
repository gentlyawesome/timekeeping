<?php

class M_captcha Extends MY_Model
{
	protected $_table = 'captcha';

	public function delete_recent($expiration = false){
		
		if($expiration != false)
		{
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);	
		}
	}
	
	public function check_captcha($captcha, $ip, $expiration)
	{
		$sql = "SELECT 
					*
				FROM $this->_table
				WHERE word = ? 
				AND ip_address = ? 
				AND captcha_time > ?";
		$binds = array($captcha, $ip, $expiration);
		
		$query = $this->db->query($sql, $binds);
		// vd($this->db->last_query());
		return $query->num_rows() > 0 ? true : false;
	}
}