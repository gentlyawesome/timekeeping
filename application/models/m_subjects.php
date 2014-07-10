<?php



class M_subjects Extends CI_Model
{

	private $_table = 'subjects';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function search_subjects($start=0,$limit=100,$data, $ret_count = false)
	{
		$start = $this->db->escape_str($start);
		$limit = $this->db->escape_str($limit);
		unset($data['search_subjects']);
		foreach($data as $key => $value)
		{
			if(!empty($value))
			{
				$filtered[trim($key)] = trim($value);
			}
		}
		$query = $this->db->select(array('id','sc_id','code','subject','units','lec','lab','time','day','room','subject_load','original_load','year_to','year_from'))->like($filtered)->get($this->_table, $start, $limit);
		
		// vd($this->db->last_query());
		if($ret_count){
			return $query->num_rows();
		}else{
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}
	
	}
	
	public function find_all()
	{
		$sql = "select *
				FROM $this->_table
				ORDER BY id";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function get($id = false,$array = false,$where = false)
	{
		if($id == false)
		{
			if($array == false)
			{
				if($where == false)
				{
					$query = $this->db->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}else
				{
					$query = $this->db->where($where)->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}
			}else
			{
				if($where == false)
				{
					$query = $this->db->select($array)->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}else
				{
					$query = $this->db->select($array)->where($where)->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}
			}
		}else
		{
			if($array == false)
			{
				if($where == false)
				{
					$query = $this->db->where('id',$id)->get($this->_table);
					return $query->num_rows() > 0 ? $query->row() : FALSE;
				}else
				{
					$query = $this->db->where('id',$id)->where($where)->get($this->_table);
					return $query->num_rows() > 0 ? $query->row() : FALSE;
				}
			}else
			{	
				if($where == false)
				{
					$query = $this->db->select($array)->where('id',$id)->get($this->_table);
					return $query->num_rows() > 0 ? $query->row() : FALSE;
				}else
				{
					$query = $this->db->select($array)->where('id',$id)->where($where)->get($this->_table);
					return $query->num_rows() > 0 ? $query->row() : FALSE;
				
				}
			}
		}
	}
	
	public function reset_subject_load($id)
	{
		$this->db->set('subject_load',0)->where('id',$id)->update($this->_table);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function update_table($data,$id)
	{
		foreach($data as $key => $value)
		{
			$columns_array[] = $key; 
		}
		$columns = implode(',',$columns_array);
		$query = $this->db->select($columns)->where($data)->get($this->_table);
		if($query->num_rows() > 0)
		{
			return true;
		}else
		{
			$this->db->set($data)->where('id',$id)->update($this->_table);
			return $this->db->affected_rows() > 0 ? TRUE : FALSE;
		}
	}
	
	public function update_load($id, $condition)
	{
	  if ($condition == "remove") {
		$sql = "
		    UPDATE subjects SET subjects.subject_load = subjects.subject_load - 1
		    WHERE subjects.id = ?
				";
	  }
	  
	  if($condition == "add"){
		$sql = "
		    UPDATE subjects SET subjects.subject_load = subjects.subject_load + 1
		    WHERE subjects.id = ?
				";
	  }
				
		$query = $this->db->query($sql,array($id));
		
		return $this->db->affected_rows() >= 1 ? TRUE : FALSE;
	}
	
	public function subjects_for_selected_course($c,$y,$s,$yf,$yt,$eid)
	{
		$sql = "	SELECT s.id,s.subject,s.units,s.time,s.day,s.code,s.room
					FROM subjects as s,studentsubjects as ss
					WHERE s.year_from = ?
					AND s.year_to = ?
					AND s.course_id = ?
					AND s.year_id = ?
					AND s.semester_id = ?
					AND s.id NOT IN (select subject_id from studentsubjects where enrollmentid = ? )
					GROUP by s.subject
					";
		$query = $this->db->query($sql,array($yf,$yt,$c,$y,$s,$eid));
		return $query->num_rows() > 0 ? $query->result() : FALSE; 
	}
	
	public function subjects_for_selected_semester($s,$yf,$yt)
	{
		$sql = "	SELECT s.id,s.subject,s.units,s.time,s.day,s.code,s.room, s.sc_id
					FROM subjects as s
					WHERE s.year_from = ?
					AND s.year_to = ?
					AND s.semester_id = ?
					ORDER BY s.code
					";
		$query = $this->db->query($sql,array($yf,$yt,$s));
		return $query->num_rows() > 0 ? $query->result() : FALSE; 
	}
	
	public function subjects_count($s,$yf,$yt)
	{
		$sql = "SELECT count(s.id) as total
					FROM subjects as s
					WHERE s.year_from = ?
					AND s.year_to = ?
					AND s.semester_id = ?
					ORDER BY s.code ASC
					";
		$query = $this->db->query($sql,array($yf,$yt,$s));
		return $query->num_rows() > 0 ? $query->row()->total : FALSE; 
	}
	
	//Pagination
	public function subjectlist($s, $yf, $yt, $eid, $start=0,$limit=100)
	{
			$start = $this->db->escape_str($start);
			$limit = $this->db->escape_str($limit);
			$sql = 	"SELECT s.id, s.code, s.subject, s.units, s.time, s.time, s.day, s.room, s.sc_id, s.subject_load
					  FROM subjects as s
					  WHERE s.year_from = ?
					  AND s.year_to = ?
					  AND s.semester_id = ?
					  AND s.id NOT IN (SELECT subject_id FROM studentsubjects WHERE studentsubjects.enrollmentid = ? )
					  ORDER BY s.code ASC
						LIMIT ".$limit.",".$start;
			$query = $this->db->query($sql,array($yf, $yt, $s, $eid));
			
		if ($query->num_rows() > 0) {
	            foreach ($query->result() as $row)
				{
	                $data[] = $row;
	            }
	            return $data;
	        }
	        return false;
	}
	
	// End pagination
	
	public function current_batch_subject($year_from, $year_to, $semester)
	{
		$sql = "SELECT subjects.sc_id, subjects.id,subjects.subject,subjects.units,subjects.time,subjects.day,subjects.code,subjects.room
					FROM subjects 
					WHERE subjects.year_from = ?
					AND subjects.year_to = ?
					AND subjects.semester_id = ?
					";
		$query = $this->db->query($sql,array($year_from, $year_to, $semester));
		return $query->num_rows() > 0 ? $query->result() : FALSE; 
	}
	
	public function create_subjects($data)
	{
		$this->db->insert($this->_table,$data);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function update_subjects($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_subjects($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
    public function fetch_subjects($limit, $start) {
        $this->db->limit($limit, $start);
		$this->db->order_by('subject');
		
        $input = $this->session->userdata('search_subject');
		unset($input['search_subjects']);
		
        $query = $this->db->select(array('id','sc_id','code','subject','units','lec','lab','time','day','room','subject_load','original_load','year_to','year_from'))->or_like($input)->get('subjects');
		
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
   
    public function fetch_subjects2($limit, $start) {
        $this->db->limit($limit, $start);
		
        $input = $this->session->userdata('search_subject');
		unset($input['search_subjects']);
		
		$filter = " WHERE TRUE ";
		
		foreach($input as $field => $value){
			if(trim($value) != ""){
				$filter .= " AND ".$field." LIKE '%".$value."%' ";
			}
		}
		
		
		$sql = "select 	
			    'id',
				'sc_id',
				'code',
				'subject',
				'units',
				'lec',
				'lab',
				'time',
				'day',
				'room',
				'subject_load',
				'original_load',
				'year_to',
				'year_from'
				FROM $this->_table
				$filter
				ORDER BY subject";
				var_dump($sql);
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
   
   	public function search_student_subject($data = false,$start = NULL,$limit = NULL,$search_count = false )
	{
		$ci =& get_instance();
		$year_f = $this->db->escape_str($ci->open_semester->year_from);
		$year_t = $this->db->escape_str($ci->open_semester->year_to);
		$sem_id = $this->db->escape_str($ci->open_semester->id);
		$start = $this->db->escape_str($start);
		$limit = $this->db->escape_str($limit);
		if($data == false AND $start !== false)
		{
			$sql = 'SELECT id,sc_id,subject,code,time,day,room,units,lec,lab,`load` FROM '.$this->_table.' 
					WHERE year_from = '.$year_f.' 
					AND year_to = '.$year_t. ' 
					AND semester_id = '.$sem_id;
			if($start == null OR $limit == null){
			}
			else{
				$sql .= ' LIMIT '.$limit.','.$start;
			}
					
			return $this->db->query($sql)->result();
			
		}elseif($data !== false)
		{
			unset($data['search_subjects']);
			foreach($data as $k => $v)
			{
				if(!empty($v))
				{
					$where[$k] = '%'.$v.'%';
				}
			}
				
			$cols = implode(' like ? OR ',array_keys($where)).' like ? ';
			$vals = array_values($where);
			
			$sql = 'SELECT id,sc_id,subject,code,time,day,room FROM '.$this->_table.'
					WHERE year_from = '.$year_f.' 
					AND year_to = '.$year_t. ' 
					AND semester_id = '.$sem_id.'
					AND '.$cols.' LIMIT '.$limit.','.$start;
			return $this->db->query($sql,$vals)->result();
			
		}
	}
	
	public function count_subjects_for_current_open_semester($data = false)
	{
		$ci =& get_instance();
		$year_f = $this->db->escape_str($ci->open_semester->year_from);
		$year_t = $this->db->escape_str($ci->open_semester->year_to);
		$sem_id = $this->db->escape_str($ci->open_semester->id);
	
		if($data == false)
		{
			$sql = 'SELECT count(id) as totals FROM '.$this->_table.' 
					WHERE year_from = '.$year_f.' 
					AND year_to = '.$year_t. ' 
					AND semester_id = '.$sem_id;		
			return $this->db->query($sql)->row()->totals;			
		}else{
		
			unset($data['search_subjects']);
			foreach($data as $k => $v)
			{
				if(!empty($v))
				{
					$where[$k] = '%'.$v.'%';
				}
			}
			$cols = implode(' like ? OR ',array_keys($where)).' like ? ';
			$vals = array_values($where);
			
			$sql = 'SELECT count(id) as totals FROM '.$this->_table.'
					WHERE year_from = '.$year_f.' 
					AND year_to = '.$year_t. ' 
					AND semester_id = '.$sem_id.'
					 AND '. $cols;
			return $this->db->query($sql,$vals)->row()->totals;				
		}
	}
	
	public function recalculate_subject_load($data, $condition)
	{
	  $this->load->model(array('M_subjects'));
	  
		$sql = "select *
				FROM $this->_table as s
				WHERE s.id = ? 
				";
		$query = $this->db->query($sql,array($data));
		$s = $query->num_rows() > 0 ? $query->row() : FALSE;
		
		
	   $this->M_subjects->update_load($data, $condition);  
	}
	
	
	public function get_current_subjects()
	{
		$ci =& get_instance();
		$year_f = $this->db->escape_str($ci->open_semester->year_from);
		$year_t = $this->db->escape_str($ci->open_semester->year_to);
		$sem_id = $this->db->escape_str($ci->open_semester->semester_id);
		
		$sql = "SELECT 
				*
				FROM $this->_table 
				WHERE year_from = ? 
				AND year_to = ?
				AND semester_id = ?
				ORDER BY code";
		
		$query = $this->db->query($sql,array($year_f, $year_t, $sem_id));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}

}
