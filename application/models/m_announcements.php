<?php
	
class M_announcements Extends CI_Model
{

	private $_table = 'announcements';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get_all()
	{
		//print_r($data);
		$sql = "select message, date
				FROM announcements
				ORDER BY created_at desc LIMIT 15";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function find_all()
	{
		//print_r($data);
		$sql = "select id, message, date
				FROM announcements
				ORDER BY created_at";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function create_announcement($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function get_announcement($id = false)
	{
		$sql = "select announcements.id, announcements.message, announcements.date, announcements.to_student, announcements.to_employee, announcements.to_all, users.name
				FROM announcements
				LEFT JOIN users ON announcements.user_id = users.id
				WHERE announcements.id = ?
				ORDER BY announcements.created_at desc";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	
	public function find($start=0,$limit=100, $filter = false, $all = false, $ret_count = false){
		
		$start = $this->db->escape_str($start);
		$limit = $this->db->escape_str($limit);
		$ci =& get_instance();
		
		//GET Library FIELDS
		$sql = "DESCRIBE $this->_table";
		$query = $this->db->query($sql);
		$fields = $query->result();
		$fields_array = array();
		foreach($fields as $val){
			
			$fields_array[] = $this->_table.'.'.$val->Field;
		}
		
		//ADD FILTERS
		$fields_array[] = 'users.name';
		
		$param = array();
		if($filter != false){
			//if filter is array
			if(is_array($filter)){
				foreach($filter as $key => $value){
		
					$param[$key] = $value;
				}
			}
			
		}
		
		if(is_string($filter)){
			$param = $filter;
		}
		
		$this->db->select($fields_array);
		$this->db->from($this->_table);
		$this->db->where($param);
		$this->db->order_by("announcements.created_at", "DESC"); 
		$this->db->join('users', 'users.id = '.$this->_table.'.user_id','LEFT');
		
		
		if($all == false){
			$this->db->limit($limit, $start);
		}
		
		$query = $this->db->get();
		// vd($this->db->last_query());
		if($ret_count == false){
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}else{
			return $query->num_rows();
		}
	}
	
	public function update_announcement($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_announcement($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}