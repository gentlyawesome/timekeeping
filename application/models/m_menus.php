<?php

class M_menus Extends My_Model
{
	protected $_table = 'menus';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all_menus($usertype='')
	{
		#REGION GET USER MENUS AND PUT IT TO SESSION
		$user_menus = false;
		//GET LEVEL ONE MENUS OR HEADER MENUS
		$sql = "SELECT
				*
				FROM menus
				WHERE department = ?
				AND visible = ?
				AND menu_lvl = ?
				GROUP BY menu_grp
				ORDER BY menu_num
			";
		$query = $this->db->query($sql, array($usertype, 1, 1));
		if($query->num_rows() > 0){
			$rs =  $query->result();
			
			foreach($rs as $obj1){
				//GET LEVEL TWO MENUS
				$user_menus[] = $obj1;
				$sql2 = "SELECT
					*
					FROM menus
					WHERE department = ?
					AND visible = ?
					AND menu_lvl = ?
					AND menu_grp = ?
					ORDER BY menu_num";
				$query2 = $this->db->query($sql2, array($usertype, 1, 2, $obj1->menu_sub));
				if($query2->num_rows() > 0){
					
					$rs2 = $query2->result();
					foreach($rs2 as $obj2){
						//GET THE MENU
						
						$user_menus[] = $obj2;
					}
				}
			}
		}
		
		return $user_menus;
	}
	
	public function find_all($where = false)
	{
		if($where != false)
		{
			$query = $this->db->select('*')->where($where)->get($this->_table);
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}
		else
		{
			$sql = "select *
				FROM $this->_table
				ORDER BY id";
			$query = $this->db->query($sql);
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}
	}
	
	public function get_menus_group_by_department()
	{
		$sql = "SELECT 
				department
				FROM $this->_table
				GROUP BY department
				ORDER BY department";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function get_header_menus_by_department($department)
	{
		$sql = "SELECT 
				*
				FROM $this->_table
				WHERE department = ?
				AND menu_lvl = 1
				ORDER BY menu_num";
		$query = $this->db->query($sql, array($department));
		return $query->num_rows() > 0 ? $query->result() : FALSE;

	}
	
	public function get_sub_menus_by_menu_sub($department, $menu_sub)
	{
		$sql = "SELECT 
				*
				FROM $this->_table
				WHERE department = ?
				AND menu_grp = ?
				AND menu_lvl = 2
				ORDER BY menu_num";
		$query = $this->db->query($sql, array($department, $menu_sub));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function create_menus($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function get_menus($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function update_menus($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_menus($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}


}