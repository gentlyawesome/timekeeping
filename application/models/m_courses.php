<?php

class M_courses Extends CI_Model
{
	private $_table = 'courses';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/*
		@id = primary key of data if  false will get all
		@array = columns names to retrieve if false will get all
	*/
	
	public function get($id = false,$array = false)
	{
		if($id == false)
		{
				if($array == false)
				{
					$query = $this->db->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}else
				{
					$query = $this->db->select($array)->get($this->_table);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}
		}else
		{
			if($array == false)
			{
				$query = $this->db->where('id',$id)->get($this->_table);
				return $query->num_rows() > 0 ? $query->row() : FALSE;
			}else
			{
				$query = $this->db->select($array)->where('id',$id)->get($this->_table);
				return $query->num_rows() > 0 ? $query->row() : FALSE;
			}
		}
		
	}
	
	public function getbacandtwo($array = false)
	{
		$query = $this->db->select($array)->like('course', 'Bachelor', 'after')->or_like('course', 'Two', 'after')->get($this->_table);
		
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function masterlist()
	{
	  $ci =& get_instance();
	  $semester_id = $ci->open_semester->id;
	  $sy_from = $ci->open_semester->year_from;
	  $sy_to = $ci->open_semester->year_to;
	  
		$sql = "SELECT courses.id,courses.course
					FROM courses
					ORDER BY courses.course ASC";
		$query = $this->db->query($sql, array($semester_id, $sy_from, $sy_to));
		//return $query->num_rows() > 0 ? $query->result() : FALSE;
		
		foreach ($query->result() as $key => $row) {
		  $data[$key]['course_id'] = $row->id;
		  $data[$key]['course_name'] = $row->course;
		  $data[$key]['total_studs'] = $this->get_total($row->id, $semester_id, $sy_from, $sy_to);
		  $data[$key]['male'] = $this->get_male($row->id, $semester_id, $sy_from, $sy_to);
		  $data[$key]['female'] = $this->get_female($row->id, $semester_id, $sy_from, $sy_to);
		}
		
		return (object)$data;
	}
	
	
	private function get_total($id, $semester_id, $sy_from, $sy_to){
	  $sql = "SELECT count(e.id) as total_studs
					FROM enrollments e
					WHERE e.course_id = ?
					AND e.is_paid = 1
					AND e.semester_id = ?
					AND e.sy_from = ?
					AND e.sy_to = ?
					";
		$query = $this->db->query($sql, array($id,$semester_id, $sy_from, $sy_to));
		
		//var_dump($this->db->last_query()); die();
		return $query->num_rows() > 0 ? $query->row()->total_studs : FALSE;
	}
	
	private function get_male($id, $semester_id, $sy_from, $sy_to){
	  $sql = "SELECT count(e.id) as total_studs
					FROM enrollments e
					WHERE e.course_id = ?
					AND e.sex = 'Male'
					AND e.is_paid = 1
					AND e.semester_id = ?
					AND e.sy_from = ?
					AND e.sy_to = ?
					";
		$query = $this->db->query($sql, array($id,$semester_id, $sy_from, $sy_to));
		
		//var_dump($this->db->last_query()); die();
		return $query->num_rows() > 0 ? $query->row()->total_studs : FALSE;
	}
	
	private function get_female($id, $semester_id, $sy_from, $sy_to){
	  $sql = "SELECT count(e.id) as total_studs
					FROM enrollments e
					WHERE e.course_id = ?
					AND e.sex = 'Female'
					AND e.is_paid = 1
					AND e.semester_id = ?
					AND e.sy_from = ?
					AND e.sy_to = ?
					";
		$query = $this->db->query($sql, array($id,$semester_id, $sy_from, $sy_to));
		
		//var_dump($this->db->last_query()); die();
		return $query->num_rows() > 0 ? $query->row()->total_studs : FALSE;
	}
	
	public function get_gender_count($id, $gender){
	  $ci =& get_instance();
	  $semester_id = $ci->open_semester->id;
	  $sy_from = $ci->open_semester->year_from;
	  $sy_to = $ci->open_semester->year_to;
	  $sql = "SELECT count(e.id) as total_studs
					FROM enrollments e
					WHERE e.course_id = ?
					And e.sex = ?
					AND e.is_paid = 1
					AND e.semester_id = ?
					AND e.sy_from = ?
					AND e.sy_to = ?
					";
		$query = $this->db->query($sql, array($id, $gender, $semester_id, $sy_from, $sy_to));
		
		//var_dump($this->db->last_query()); die();
		return $query->num_rows() > 0 ? $query->row()->total_studs : FALSE;
	}
	
	
	public function masterlist_course_enrollment_profile($course,$start=0,$limit=100)
	{
			$start = $this->db->escape_str($start);
			$limit = $this->db->escape_str($limit);
			$ci =& get_instance();
	    $semester_id = $ci->open_semester->id;
	    $sy_from = $ci->open_semester->year_from;
	    $sy_to = $ci->open_semester->year_to;
			$sql = 	"SELECT enrollments.id as enrollment_id,enrollments.name, enrollments.studid, years.year
						FROM enrollments
						LEFT JOIN courses on courses.id = enrollments.course_id
						LEFT JOIN years on years.id = enrollments.year_id
						WHERE enrollments.course_id = ? 
						AND enrollments.is_paid = 1
					  AND enrollments.semester_id = ?
					  AND enrollments.sy_from = ?
					  AND enrollments.sy_to = ?
					  ORDER BY enrollments.name ASC
						LIMIT ".$limit.",".$start;
			$query = $this->db->query($sql,array($course, $semester_id,$sy_from, $sy_to));
			
		if ($query->num_rows() > 0) {
	            foreach ($query->result() as $row)
				{
	                $data[] = $row;
	            }
	            return $data;
	        }
	        return false;
	}
	
	
	public function masterlist_course_enrollment_profile_gender($course,$gender,$start=0,$limit=100)
	{
			$start = $this->db->escape_str($start);
			$limit = $this->db->escape_str($limit);
			$ci =& get_instance();
	    $semester_id = $ci->open_semester->id;
	    $sy_from = $ci->open_semester->year_from;
	    $sy_to = $ci->open_semester->year_to;
			$sql = 	"SELECT enrollments.id as enrollment_id,enrollments.name, enrollments.studid, enrollments.sex, years.year
						FROM enrollments
						LEFT JOIN courses on courses.id = enrollments.course_id
						LEFT JOIN years on years.id = enrollments.year_id
						WHERE enrollments.course_id = ? 
					  AND enrollments.sex = ?
						AND enrollments.is_paid = 1
					  AND enrollments.semester_id = ?
					  AND enrollments.sy_from = ?
					  AND enrollments.sy_to = ?
					  ORDER BY enrollments.name ASC
						LIMIT ".$limit.",".$start;
			$query = $this->db->query($sql,array($course, $gender, $semester_id,$sy_from, $sy_to));
			
		if ($query->num_rows() > 0) {
	            foreach ($query->result() as $row)
				{
	                $data[] = $row;
	            }
	            return $data;
	        }
	        return false;
	}
	
	public function masterlist_count($course)
	{
#		$sql = 	"SELECT count(enrollments.id) as total
#				FROM enrollments
#				LEFT JOIN enrollments on enrollments.profile_id = profiles.id
#				LEFT JOIN courses on courses.id = enrollments.course_id
#				WHERE enrollments.course_id = ? and enrollments.is_paid = 1";


	  $ci =& get_instance();
	  $semester_id = $ci->open_semester->id;
	  $sy_from = $ci->open_semester->year_from;
	  $sy_to = $ci->open_semester->year_to;
    $sql = "SELECT count(e.id) as total
					FROM enrollments e
					WHERE e.course_id = ?
					AND e.is_paid = 1
					AND e.semester_id = ?
					AND e.sy_from = ?
					AND e.sy_to = ?";
			$query = $this->db->query($sql,array($course, $semester_id, $sy_from, $sy_to));
		 return $query->num_rows() > 0 ? $query->row()->total : FALSE;
	}
	
	public function unassigned()
	{
		$sql = "SELECT count(*) as unassigned FROM `enrollments` WHERE ISNULL(`course_id`)";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function for_tesda_report_masterlist($id)
	{
		 $ci =& get_instance();
		 $semester_id = $ci->open_semester->id;
		 $sy_from = $ci->open_semester->year_from;
		 $sy_to = $ci->open_semester->year_to;
		 
		$sql = "SELECT 
				enrollments.id as enrollment_id, 
				enrollments.name,
				courses.course,years.year
				FROM enrollments
				LEFT JOIN courses on courses.id = enrollments.course_id
				Left JOIN years ON years.id = enrollments.year_id
				WHERE enrollments.course_id = ? 
				AND enrollments.is_paid = 1 
				ORDER BY years.year, enrollments.name ASC";
		$query = $this->db->query($sql,array($id));
		// vp($this->db->last_query());
		// vd('');
		return $query->num_rows() > 0 ? $query->result() : false;
	}

	public function get_all()
	{
		//print_r($data);
		$sql = "select message, date
				FROM $this->_table
				ORDER BY created_at desc LIMIT 15";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function find_all()
	{
		//print_r($data);
		$sql = "select *
				FROM $this->_table
				ORDER BY id";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function create_courses($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function get_courses($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function update_courses($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function delete_courses($where = false)
	{
		$this->db->where('id',$where)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}



}
