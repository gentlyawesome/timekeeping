<?php
class M_login Extends CI_Model
{	
	public function get_login_credentials($login)
	{
		if($login)
		{
			$sql = "
					SELECT u.id,u.crypted_password,u.salt 
					FROM users u
					WHERE u.login = ? 
					AND u.is_active = 1
					LIMIT 1";
			$query = $this->db->query($sql,array($login));
			return $query->num_rows() > 0 ? $query->row() : FALSE;
		}
		return FALSE;
	}
	
	
	
}
