<?php

class MY_Model Extends CI_Model
{
	private $ci;

	protected $_table = '';
	protected $_uid = false;
	protected $before_create = array();
	protected $after_create = array();
	
	
	protected $enrollment_link = '';
	
	public function __construct()
	{
		parent::__construct();
		$this->ci =& get_instance();

		if($this->_uid == false){
			$this->_uid = 'id'; //DEFAULT UNIQUE ID
		}
	}
	
	private function get_sy()
	{
		/*
		* id,sy_from,sy_to,is_set
		*/
		$sql = "SELECT * FROM school_years s WHERE s.is_set = 'yes' limit 1";
		$query = $this->db->query($sql);
		return $query->num_rows() >= 1 ? $query->row() : FALSE;
	}
	
	private function get_gp()
	{
		/*
		* gp_id,gp_code,gp_desc,gp_stat
		*/
		$sql = "SELECT gp_id,gp_code,gp_desc,gp_stat FROM grading_periods g WHERE g.is_set = 'yes' limit 1";
		$query = $this->db->query($sql);
		return $query->num_rows() >= 1 ? $query->row() : FALSE;
	}
	
	
	private function get_user()
	{
		$data['usertype'] = $this->ci->session->userdata('userType');
		$data['userid'] = $this->ci->session->userdata('userid');
		return (object)$data;
	}
	
	private function _set_config_items()
	{
		$sql = 'SELECT * FROM backend_settings';
		$query = $this->db->query($sql);
		$data= $query->num_rows() >=1 ? $query->row() : FALSE;
	
		if($data !== FALSE)
		{
			$this->enrollment_link = $data->enrollment_link;
			$this->student_link =$data->student_link;
			$this->accounting_link = $data->accounting_link;

		}
	}
	
	public function get()
	{
		$args = func_get_args(); //GET FUNCTION PARAMETERS as ARRAY
	
		if (count($args) > 1 || is_array($args[0]))
		{
			$this->db->where($args[0]);
		}
		else
		{
			$this->db->where($this->_uid, $args[0]);
		}
	
		$query = $this->db->get($this->_table);
		
		return $query->num_rows() > 0 ? $query->row() : false;
	}

	/*
		GET OR PULL SINGLE RECORD
		@PARAM1 ID can be array('e_id'=>1) 
		@PARAM2 Fieds Array of fields
	*/
	public function pull($where, $fld = '*')
	{
		$this->db->select($fld);
		if (is_array($where))
		{
			$this->db->where($where);
		}
		else
		{
			$this->db->where($this->_uid, $where);
		}
	
		$query = $this->db->get($this->_table);
		
		return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function fetch_all($where = false)
	{
		$uid = $this->_uid == false ? 'id' : $this->_uid;
		if($where != false)
		{
			$query = $this->db->select('*')->where($where)->get($this->_table);
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}
		else
		{
			$sql = "select *
				FROM $this->_table
				ORDER BY $uid";
			$query = $this->db->query($sql);
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}
	}
	
	public function get_all()
	{
		$args = func_get_args();
		
		if (count($args) > 1 || is_array($args[0]))
		{
			$this->db->where($args[0]);
		}
		else
		{
			$this->db->where('id', $args[0]);
		}
		
		$query = $this->db->get($this->_table);
		
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	public function insert($data, $skip_validation = FALSE)
	{
		$data['created_at'] = $data['updated_at'] = date('Y-m-d H:i:s');

		$data = $this->observe('before_create', $data);

		if (!$skip_validation && !$this->validate($data))
		{
			$success = FALSE;
		}
		else
		{
			$success = $this->db->insert($this->_table, $data);
		}

		if ($success)
		{
			$this->observe('after_create', $data);

			return array('id' => $this->db->insert_id(), 'status' => true);
		}
		else
		{
			return FALSE;
		}
	}
	
	public function update()
	{
		$args = func_get_args();
		$args[1]['updated_at'] = date('Y-m-d H:i:s');

		if (is_array($args[0]))
		{
			$this->db->where($args[0]);
		}
		else
		{
			$this->db->where($this->_uid, $args[0]);
		}
		
		$this->db->update($this->_table, $args[1]);

		return $this->db->affected_rows() > 0 ? true : false;
	}
	
	public function delete()
	{
		$args = func_get_args();
	
		if (count($args) > 1 || is_array($args[0]))
		{
			$this->db->where($args[0]);
		}
		else
		{
			$this->db->where($this->_uid, $args[0]);
		}
	
		$this->db->delete($this->_table);

		return $this->db->affected_rows() > 0 ? true : false;
	}

	public function observe($event, $data)
	{
		if (isset($this->$event) && is_array($this->$event))
		{
			foreach ($this->$event as $method)
			{
				$data = call_user_func_array(array($this, $method), array($data));
			}
		}
		
		return $data;
	}

	public function validate($data)
	{
		if (!empty($this->validate))
		{
			foreach ($data as $key => $value)
			{
				$_POST[$key] = $value;
			}

			$this->load->library('form_validation');
			$this->form_validation->set_rules($this->validate);

			return $this->form_validation->run();
		}
		else
		{
			return TRUE;
		}
	}

	/*
		GET RECORD AND ARRANGE TO ARRAY FOR FORM_DROPDOWN READY
	*/
	public function get_for_dd($field = false, $where = false, $def = false)
	{
		$ret = array();
		$table = $this->_table;
		if($table != false)
		{
			$config['all'] = true;
			$config['count'] = false;
			$config['fields'] = $field;
			$config['where'] = $where;

			if($def){
				$ret[''] = $def;
			}

			$rs = $this->get_record($table, $config);
			
			if($rs){
				foreach ($rs as $key => $value) {
					if(count($field) <= 2){
						$ret[$value->$field[0]] = $value->$field[1];
					}else{
						$desc = "";

						for($i = 1; $i <= count($field) - 1; $i++){
							
							if($i == 1){
								$desc = $value->$field[1];
							}else{
								$desc .= " - ".$value->$field[$i];
							}
						}
						
						$ret[$value->$field[0]] = $desc;
					}
				}
			}
		}

		return $ret;
	}

	/* QUERY RECORD
	  @sql - query to be executed
	  @parameter(array) - parameter of the query with ? mark

	*/
	public function query($sql, $parameter = array(), $single = false){
		$q = $this->db->query($sql, $parameter);
		if($q->num_rows() > 0){
			if($single){
				return $q->row();
			}else{
				return $q->result();
			}
		}

		return false;
	}
	
	
	/*table - table name
	@start - start record for pagination
	@limit - limit record for pagination
	@filter (array) - add filter or where
			//index - add operator ex filter['id =']
			//value - value of the filter ex filter['id ='] = 100
	@order_by (string) - order or the record
	@all - exclude the limit and start return all records 
	@count - return the count or all records
	@par - addition parameter for future purpose
	*/
	
	public function fetch_record($start=0,$limit=100, $filter = false,$order_by = false, $all = false, $ret_count = false, $par = ""){
		
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
		// $fields_array[] = 'librarycategory.category';
		
		$param = array();
		if($filter != false){
			//if filter is array
			
			if(is_array($filter)){
				foreach($filter as $key => $value){
		
					$param[$key] = $value;
				}
			}
		}
		
		$this->db->select($fields_array);
		$this->db->from($this->_table);
		$this->db->where($param);
		if($order_by == false)
		{
			$this->db->order_by("id", "ASC"); 
		}else{
			$this->db->order_by($order_by); 
		}
		// $this->db->join('librarycategory', 'librarycategory.id = '.$this->_table.'.librarycategory_id','LEFT');
		
		
		if($all == false){
			$this->db->limit($limit, $start);
		}
		
		$query = $this->db->get();
		
		if($ret_count == false){
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}else{
			return $query->num_rows();
		}
	}
	
	/* Dynamic Get Record */
	/* table - table name */
	/* config (array) - filter, like, order, group, fields */
	public function get_record($table = false, $config = array(), $debug = false)
	{
		if($table == false)
		{
			$table = $this->_table;
		}
		
		//CONFIGURATION
		//$config['fields'] = specific fields
		//$config['where'] = AND conditions
		//$config['or_where'] = OR conditions
		//$config['like'] = LIKE conditions
		//$config['or_like'] = OR LIKE conditions
		// $config['join'][] = array(
			// "table" = "TABLE NAME",
			// "on"	= "ON STRING",
			// "type"  = "LEFT,RIGHT"
		// )
		//$config['not_in'] = array(
			// "field" => "field_name",
			// "data" => "ARRAY OR STRING"
		// )
		//$config['group'] = GROUP BY conditions
		//$config['order'] = ORDER BY conditions
		//$config['start'] = LIMIT START conditions
		//$config['limit'] = LIMIT END conditions
		//$config['all'] = true or false : return all removes limit
		//$config['count'] = true or false : return count not the row
		//$config['array'] = true or false : return array instead of object
		//$config['single'] = true or false : return single record
		
		
		
		//FIELDS CONFIGURATION
		if(isset($config['fields']) && $config['fields'] != false)
		{
			$this->db->select($config['fields']);
		}
		else
		{
			$this->db->select('*');
		}
		
		$this->db->from($table); //FROM TABLE
		
		//WHERE
		if(isset($config['where']) && $config['where'] != false)
		{
			$this->db->where($config['where']);
		}
		
		//OR WHERE
		if(isset($config['or_where']) && $config['or_where'] != false)
		{
			$this->db->or_where($config['or_where']);
		}
		
		//LIKE
		if(isset($config['like']) && $config['like'] != false)
		{
			$this->db->like($config['like']);
		}
		
		//OR LIKE
		if(isset($config['or_like']) && $config['or_like'] != false)
		{
			$this->db->or_like($config['or_like']);
		}
		
		//WHERE NOT IN
		//$this->db->where_not_in('username', $names);
		if(isset($config['not_in']) && $config['not_in'] != false)
		{
			$xnot_in = $config['not_in'];
			if(isset($xnot_in['field']) && $xnot_in['field'] != false)
			{
				if(isset($xnot_in['data']) && $xnot_in['data'] != false)
				{
					if(is_array($xnot_in['data'])){
						$this->db->where_not_in($xnot_in['field'], $xnot_in['data']);
					}
					else if(is_string($xnot_in['data'])){
						
						$_xfilter = $xnot_in['field'].' NOT IN ( ' .$xnot_in['data']. ' ) ';
						
						// $this->db->where(“events.id NOT IN (SELECT event_id2 FROM related_events”);
						
						$this->db->where($_xfilter);
					}
				}
			}
		}
		
		//JOIN STATEMENTS
		if(isset($config['join']) && is_array($config['join']))
		{
			foreach($config['join'] as $join)
			{
				if($join['table'] != "")
				{
					$this->db->join($join['table'], $join['on'],strtoupper($join['type']));
				}
			}
		}
		
		//GROUP
		if(isset($config['group']) && $config['group'] != false)
		{
			$this->db->group_by($config['group']);
		}
		
		//ORDER BY
		if(isset($config['order']) && $config['order'] != false)
		{
			$this->db->order_by($config['order']);
		}
		
		//CHECK IF ALL IF TRUE
		if(isset($config['all']) && $config['all'] == true)
		{
		}
		else
		{
			//LIMIT START END
			if(isset($config['limit']) && isset($config['start']))
			{
				$this->db->limit($config['limit'], $config['start']);
			}
			else
			{
				if(isset($config['limit']))
				{
					$this->db->limit($config['limit']);
				}
			}
		}
		
		$query = $this->db->get(); //EXECUTE QUERY
	
		//CHECK IF DEBUG
		if($debug)
		{
			vp($this->db->last_query());
			vd('');
		}
		
		//CHECK IF COUNT TRUE
		if(isset($config['count']) && $config['count'] == true)
		{
			return $query->num_rows();
		}
		else
		{	
			//CHECK IF SINGLE
			if(isset($config['single']) && $config['single'] == true)
			{
				if(isset($config['array']) && $config['array'] == true)
				{
					return $query->num_rows > 0 ? $query->first_row('array') : false;
				}
				else
				{
					return $query->num_rows > 0 ? $query->row() : false;
				}
			}
			else
			{
				if(isset($config['array']) && $config['array'] == true)
				{
					return $query->num_rows > 0 ? $query->result_array : false;
				}
				else
				{
					return $query->num_rows > 0 ? $query->result() : false;
				}
			}
		}
		
		return false;
	}

}