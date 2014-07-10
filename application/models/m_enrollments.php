<?php
	
class M_enrollments Extends CI_Model
{
	
	private $enrollment_tbl = 'enrollments';
	private $profile_tbl = '';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($id = false,$array = false)
	{
		if($id == false)
		{
				if($array == false)
				{
					$query = $this->db->get($this->enrollment_tbl);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}else
				{
					$query = $this->db->select($array)->get($this->enrollment_tbl);
					return $query->num_rows() > 0 ? $query->result() : FALSE;
				}
		}else
		{
			if($array == false)
			{
				$query = $this->db->where('id',$id)->get($this->enrollment_tbl);
				return $query->num_rows() > 0 ? $query->row() : FALSE;
			}else
			{
				$query = $this->db->select($array)->where('id',$id)->get($this->enrollment_tbl);
				return $query->num_rows() > 0 ? $query->row() : FALSE;
			}
		}
		
	}
	
	public function get_by($array, $single = false){
		
		$query = $this->db->where($array)->get($this->enrollment_tbl);
		
		if($single){
			return $query->num_rows() > 0 ? $query->row() : FALSE;
		}else{
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}
	}
	
	public function check_if_paid($id)
	{
	  $sql = "SELECT is_paid
	          FROM enrollments
	          WHERE id = ?";
	          
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->row()->is_paid == 1 ? TRUE : FALSE : FALSE;
		
	}
	
	public function profile($data)
	{
		$sql = "select 
		         enrollments.*,
		         enrollments.guardian as guardian_name,
		         enrollments.fake_email as email,
					   enrollments.fname as first_name,
					   enrollments.name as full_name,
					   enrollments.middle as middle_name,
					   enrollments.lastname as last_name,
					   enrollments.sex as gender,
					   enrollments.id as enrollment_id,
					   courses.course,
					   years.year , 
					   years.id as year_id,
					   semesters.id as sem_id,
					   semesters.name,
					   users.login
				FROM enrollments
				LEFT JOIN courses  ON courses.id = enrollments.course_id
				LEFT JOIN years	  ON years.id = enrollments.year_id
				LEFT JOIN semesters ON semesters.id = enrollments.semester_id
				LEFT JOIN users ON users.id = enrollments.user_id
				WHERE enrollments.id = ?";
		$query = $this->db->query($sql,array($data));
		// vd($this->db->last_query());
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function profile_by_user_id($data)
	{
		$sql = "select 
		         enrollments.*,
		         enrollments.guardian as guardian_name,
		         enrollments.fake_email as email,
					   enrollments.fname as first_name,
					   enrollments.name as full_name,
					   enrollments.middle as middle_name,
					   enrollments.lastname as last_name,
					   enrollments.sex as gender,
					   enrollments.id as enrollment_id,
					   courses.course,
					   years.year , 
					   years.id as year_id,
					   semesters.id as sem_id,
					   semesters.name,
					   users.login
				FROM enrollments
				LEFT JOIN courses  ON courses.id = enrollments.course_id
				LEFT JOIN years	  ON years.id = enrollments.year_id
				LEFT JOIN semesters ON semesters.id = enrollments.semester_id
				LEFT JOIN users ON users.id = enrollments.user_id
				WHERE enrollments.user_id = ?
				ORDER BY enrollments.id DESC";
		$query = $this->db->query($sql,array($data));
		
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	
	public function enrollee_profile($data)
	{
		$sql = "select concat(profiles.last_name,' , ',profiles.first_name,' ',profiles.middle_name) as stud_name,
					   courses.course,
					   years.year , 
					   years.id as year_id,
					   semesters.name as sem_name,
					   users.login
				FROM enrollments
				LEFT JOIN profiles ON profiles.id = enrollments.profile_id
				LEFT JOIN courses  ON courses.id = enrollments.course_id
				LEFT JOIN years	  ON years.id = enrollments.year_id
				LEFT JOIN semesters ON semesters.id = enrollments.semester_id
				LEFT JOIN users ON users.id = enrollments.user_id
				WHERE enrollments.deleted = 0 AND enrollments.id = ?";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	
	
	public function get_enrollments_for_ched_report($c,$y,$s,$year_from,$year_to)
	{
		$sql = "select users.name, enrollments.id
				FROM enrollments
				LEFT JOIN users ON users.id = enrollments.user_id
				WHERE enrollments.is_deleted = 0 
				AND enrollments.is_paid = 1 
				AND enrollments.course_id = ?
				AND enrollments.year_id = ?
				AND enrollments.semester_id = ?
				AND enrollments.sy_from = ?
				AND enrollments.sy_to = ?";
		$query = $this->db->query($sql,array($c,$y,$s,$year_from,$year_to));
		// vd($this->db->last_query());
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function get_enrollments_for_generation_of_exam_permit($c,$s,$year_from,$year_to)
	{
		$sql = "select users.name, enrollments.id, semesters.name, enrollments.sy_from, enrollments.sy_to, enrollments.status, enrollments.studid, enrollments.name, courses.course, years.year
				FROM enrollments
				LEFT JOIN semesters ON semesters.id = enrollments.semester_id
				LEFT JOIN users ON users.id = enrollments.user_id
				LEFT JOIN courses ON courses.id = enrollments.course_id
				LEFT JOIN years ON years.id = enrollments.year_id
				WHERE enrollments.is_deleted = 0 
				AND enrollments.is_paid = 1 
				AND enrollments.course_id = ?
				AND enrollments.semester_id = ?
				AND enrollments.sy_from = ?
				AND enrollments.sy_to = ?
				ORDER BY users.name ASC";
		$query = $this->db->query($sql,array($c,$s,$year_from,$year_to));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}

	public function search_deleted_accounts($firstname, $lastname, $idno, $semester_id_eq, $sy_from_eq, $sy_to_eq)
	{
		if(!empty($firstname) && $firstname!='')
		{
			$sql = "SELECT enrollments.id, enrollments.studid, profiles.first_name, profiles.last_name, years.year, semesters.name, courses.course FROM enrollments 
			LEFT JOIN profiles ON (enrollments.profile_id = profiles.id) 
			LEFT JOIN years ON (years.id = enrollments.year_id) 
			LEFT JOIN semesters ON (semesters.id = enrollments.semester_id)
			LEFT JOIN courses ON (courses.id = enrollments.course_id)
			WHERE profiles.first_name LIKE '%$firstname%' AND enrollments.semester_id='$semester_id_eq' AND enrollments.sy_from='$sy_from_eq' AND enrollments.sy_to='$sy_to_eq'  AND enrollments.is_deleted = 1";
		}
		elseif(!empty($lastname) && $lastname!='')
		{
			$sql = "SELECT enrollments.id, enrollments.studid, profiles.first_name, profiles.last_name, years.year, semesters.name, courses.course FROM enrollments 
			LEFT JOIN profiles ON (enrollments.profile_id = profiles.id) 
			LEFT JOIN years ON (years.id = enrollments.year_id) 
			LEFT JOIN semesters ON (semesters.id = enrollments.semester_id)
			LEFT JOIN courses ON (courses.id = enrollments.course_id)
			WHERE profiles.last_name LIKE '%$lastname%' AND enrollments.semester_id='$semester_id_eq' AND enrollments.sy_from='$sy_from_eq' AND enrollments.sy_to='$sy_to_eq'  AND enrollments.is_deleted = 1";
		}
		elseif(!empty($idno) && $idno!='')
		{
			$sql = "SELECT enrollments.id, enrollments.studid, profiles.first_name, profiles.last_name, years.year, semesters.name, courses.course FROM enrollments 
			LEFT JOIN profiles ON (enrollments.profile_id = profiles.id) 
			LEFT JOIN years ON (years.id = enrollments.year_id) 
			LEFT JOIN semesters ON (semesters.id = enrollments.semester_id)
			LEFT JOIN courses ON (courses.id = enrollments.course_id)
			WHERE enrollments.studid LIKE '%$idno%' AND (enrollments.semester_id='$semester_id_eq' AND enrollments.sy_from='$sy_from_eq' AND enrollments.sy_to='$sy_to_eq' AND enrollments.is_deleted = 1)";
		}
		else
		{
			$sql = "SELECT enrollments.id, enrollments.studid, profiles.first_name, profiles.last_name, years.year, semesters.name, courses.course FROM enrollments 
			LEFT JOIN profiles ON (enrollments.profile_id = profiles.id) 
			LEFT JOIN years ON (years.id = enrollments.year_id) 
			LEFT JOIN semesters ON (semesters.id = enrollments.semester_id)
			LEFT JOIN courses ON (courses.id = enrollments.course_id)
			WHERE enrollments.semester_id='$semester_id_eq' AND enrollments.sy_from='$sy_from_eq' AND enrollments.sy_to='$sy_to_eq' AND enrollments.is_deleted = 1";
		}
		
		$q = $this->db->query($sql); 
		return $q->num_rows() >= 1 ? $q->result() : FALSE;
	}
	
	public function get_enrollee($semester_id_eq, $sy_from_eq, $sy_to_eq)
	{
		$sql = "SELECT enrollments.id, enrollments.studid, profiles.first_name, profiles.last_name, years.year, semesters.name, courses.course FROM enrollments 
			LEFT JOIN profiles ON (enrollments.id = profiles.enrollment_id) 
			LEFT JOIN years ON (years.id = enrollments.year_id) 
			LEFT JOIN semesters ON (semesters.id = enrollments.semester_id)
			LEFT JOIN courses ON (courses.id = enrollments.course_id)
			WHERE enrollments.semester_id='$semester_id_eq' AND enrollments.sy_from='$sy_from_eq' AND enrollments.sy_to='$sy_to_eq' AND enrollments.is_paid=0
			AND enrollments.deleted = 0";
		
		$q = $this->db->query($sql); 
		return $q->num_rows() >= 1 ? $q->result() : FALSE;
	}
	
	public function get_enrollee_bydate($semester_id_eq, $sy_from_eq, $sy_to_eq, $date)
	{
		$sql = "SELECT 
					enrollments.id, 
					enrollments.studid, 
					enrollments.is_paid, 
					enrollments.name as fullname,
					years.year, 
					semesters.name, 
					courses.course 
				FROM enrollments 
				LEFT JOIN years ON (years.id = enrollments.year_id) 
				LEFT JOIN semesters ON (semesters.id = enrollments.semester_id)
				LEFT JOIN courses ON (courses.id = enrollments.course_id)
				WHERE enrollments.semester_id='$semester_id_eq' 
				AND enrollments.sy_from='$sy_from_eq' 
				AND enrollments.sy_to='$sy_to_eq' 
				AND (DATE(enrollments.created_at) = ?) 
				AND enrollments.is_paid = 0
				ORDER BY enrollments.name";
		
		$q = $this->db->query($sql,array($date)); 
		return $q->num_rows() >= 1 ? $q->result() : FALSE;
	}
	
	public function update_table($data,$id)
	{
		/*get all data key as db column names */
		foreach($data as $key => $value)
		{
			$columns_array[] = $key; 
		}
		$columns = implode(',',$columns_array);
		
		/* select if data input is the same with data on the db */
		$query = $this->db->select($columns)->where($data)->get($this->enrollment_tbl);
		
		/*  if query returns > 0 then data is already present 
		     return true so that it will go to the second process updating the profile table 
		*/
		if($query->num_rows() > 0)
		{
			return true;
		}else
		{
			/* if num_rows() returns 0 then data is not present or not the same so continue update */
			$this->db->set($data)->where('id',$id)->update($this->enrollment_tbl);
			return $this->db->affected_rows() > 0 ? TRUE : FALSE;
		}
	}
	
	public function update_enrollments($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->enrollment_tbl);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
	
	public function create_enrollments($input = false)
	{
		$this->db->insert("enrollments",$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}
	
	public function destroy_enrollment($id)
	{
		$this->db->set('deleted',1)->where('id',$id)->update($this->enrollment_tbl);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function restore_enrollment($id)
	{
		$this->db->set('deleted',0)->where('id',$id)->update($this->enrollment_tbl);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function view_grade($enrollment_id,$data)
	{
		$datus = array(
            'block_viewing_of_grade' => $data
        );

		$this->db->where('id', $enrollment_id);
		$this->db->update('enrollments', $datus); 
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function paid_unpaid($x,$start,$limit)
	{
		
		//List of paid is_paid  = 1
		//List of uppaid is_paid  = 0
		//List of fullpaid full_paid  = 1
		//List of partial is_paid = 1 and full_paid  = 0

		$ci =& get_instance();
		$semester_id = $ci->open_semester->id;
		$sy_from = $ci->open_semester->year_from;
		$sy_to = $ci->open_semester->year_to;
		
		$s =strip_tags(intval($start));
		$l =strip_tags(intval($limit));
		
		switch(strtolower($x)){
			case "paid":
				$xfilter = " is_paid = 1 ";
			break;
			case "unpaid":
				$xfilter = " is_paid = 0 ";
			break;
			case "fullpaid":
				$xfilter = " full_paid = 1 ";
			break;
			case "partialpaid":
				$xfilter = " full_paid = 0 AND is_paid = 1 ";
			break;
		}
			
			$sql="SELECT e.id,e.name, e.studid, years.year, courses.course
						   FROM enrollments AS e
						   LEFT JOIN years ON years.id = e.year_id
						   LEFT JOIN courses ON courses.id = e.course_id
						   WHERE $xfilter
						   AND e.semester_id = ?
						   AND e.sy_from = ?
						   AND e.sy_to = ?
						   ORDER BY e.name ASC
						   LIMIT $l , $s" ;
				$query = $this->db->query($sql,array($semester_id,$sy_from, $sy_to ));
			vp($this->db->last_query());
			vd('');
			if ($query->num_rows() > 0) {
	            foreach ($query->result() as $row) {
	                $data[] = $row;
	            }
	            return $data;
	        }
	        return false;
	}
	
	public function get_all_updaid_enrollments($start=0,$limit=100, $filter = false, $all = false){
		
		$start = $this->db->escape_str($start);
		$limit = $this->db->escape_str($limit);
		$ci =& get_instance();
		$semester_id = $ci->open_semester->id;
		$sy_from = $ci->open_semester->year_from;
		$sy_to = $ci->open_semester->year_to;
		
		$param[] = $semester_id;
		$param[] = $sy_from;
		$param[] = $sy_to;
		
		//ADD FILTERS
		$xfilter = "";
		if($filter != false){
			//if filter is array
			if(is_array($filter)){
				foreach($filter as $key => $value){
					$xfilter .= " $key ? ";
					$param[] = $value;
				}
			}
			else{ //if filter is string
				$xfilter = $filter;
			}
			
		}
		
		$sql="SELECT e.id,e.name, e.studid, years.year, courses.course
						   FROM enrollments AS e
						   LEFT JOIN years ON years.id = e.year_id
						   LEFT JOIN courses ON courses.id = e.course_id
						   WHERE 
						   e.semester_id = ?
						   AND e.sy_from = ?
						   AND e.sy_to = ?
						   $xfilter
						   ORDER BY e.name ASC";
		if($all == false){
			$sql .= " LIMIT ".$limit.",".$start;
		}
		
		$query = $this->db->query($sql,$param);
		// vd($this->db->last_query());
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function count_all_updaid_enrollments($x = 'unpaid'){
		
		$ci =& get_instance();
		$semester_id = $ci->open_semester->id;
		$sy_from = $ci->open_semester->year_from;
		$sy_to = $ci->open_semester->year_to;
		
		$filter = "";
		
		switch($x){
			case "unpaid":
				$filter = " AND full_paid <> 1 ";
			break;
			case "paid":
				$filter = " AND is_paid = 1 ";
			break;
		}
		
		$sql="SELECT e.id,e.name, e.studid, years.year, courses.course
						   FROM enrollments AS e
						   LEFT JOIN years ON years.id = e.year_id
						   LEFT JOIN courses ON courses.id = e.course_id
						   WHERE 
						   e.semester_id = ?
						   AND e.sy_from = ?
						   AND e.sy_to = ?
						   $filter
						   ORDER BY e.name ASC"
						   ;
		$query = $this->db->query($sql,array($semester_id,$sy_from, $sy_to ));
		// vp('xcount');
		// vp($this->db->last_query());
		return $query->num_rows();
	}
	
	public function count_paid_unpaid($x)
	{
		$ci =& get_instance();
		$semester_id = $ci->open_semester->id;
		$sy_from = $ci->open_semester->year_from;
		$sy_to = $ci->open_semester->year_to;
		
		switch(strtolower($x)){
			case "paid":
				$xfilter = " is_paid = 1 ";
			break;
			case "unpaid":
				$xfilter = " is_paid = 0 ";
			break;
			case "fullpaid":
				$xfilter = " full_paid = 1 ";
			break;
			case "partialpaid":
				$xfilter = " full_paid = 0 AND is_paid = 1 ";
			break;
		}
			
		$sql="SELECT e.id,e.name, e.studid, years.year, courses.course
					   FROM enrollments AS e
					   LEFT JOIN years ON years.id = e.year_id
					   LEFT JOIN courses ON courses.id = e.course_id
					   WHERE $xfilter
					   AND e.semester_id = ?
					   AND e.sy_from = ?
					   AND e.sy_to = ?
					   ORDER BY e.name ASC
					   ";
			$query = $this->db->query($sql,array($semester_id,$sy_from, $sy_to ));
		
		return $query->num_rows();
	}
	
	public function get_subject_class_list($subject_id)
	{
	  $ci =& get_instance();
	  $sql = "SELECT enrollments.id, enrollments.name, enrollments.studid
	          FROM studentsubjects
	          JOIN enrollments on studentsubjects.enrollmentid = enrollments.id
	          WHERE studentsubjects.subject_id = ?
	          AND enrollments.is_paid = 1
	          AND enrollments.semester_id = ?
	          AND enrollments.sy_from = ?
	          AND enrollments.sy_to = ?";
	          
	  $query = $this->db->query($sql, array($subject_id, $ci->open_semester->id, $ci->open_semester->year_from, $ci->open_semester->year_to));
	  return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	

    public function fetch_enrollments($limit, $start, $query) 
	{
        $this->db->limit($limit, $start);
        if (!empty($query)) {
            foreach ($query as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
   
   public function get_all_student_profile_for_report($filter=false, $fields = false)
   {
		$ci =& get_instance();
		
		//GET ENROLLMENTS FIELDS
		// $sql = "DESCRIBE enrollments";
		// $query = $this->db->query($sql);
		// $fields = $query->result();
		// $fields_array = array();
		// foreach($fields as $val){
			
			// $fields_array[] = $this->enrollment_tbl.'.'.$val->Field;
		// }
		// $fields_array[] = 'years.year';
		// $fields_array[] = 'courses.course';
		
		$param['semester_id'] = $ci->open_semester->id;
		$param['sy_from'] = $ci->open_semester->year_from;
		$param['sy_to'] = $ci->open_semester->year_to;
		$param['is_deleted'] = 0;
		
		if($filter != false){
			if(is_array($filter)){
				foreach($filter as $key => $val){
					$param[$key] = $val;
				}
			}
		}
		
		if($fields){
			$this->db->select($fields);
		}else{
			$this->db->select('*');
		}
		$this->db->from($this->enrollment_tbl);
		$this->db->where($param);
		$this->db->order_by("name", "ASC"); 
		// $this->db->join('years', 'years.id = '.$this->enrollment_tbl.'.year_id','LEFT');
		// $this->db->join('courses', 'courses.id = '.$this->enrollment_tbl.'.course_id','LEFT');

		$query = $this->db->get();
		
		return $query->num_rows() > 0 ? $query->result() : FALSE;
   }
   
   	public function get_last_enrollment_with_balance($id){
	
		$ci =& get_instance();
		$sql = "select 
					id
				FROM $this->enrollment_tbl
				WHERE studid = ?
				AND semester_id = ?
				AND sy_from = ?
				AND sy_to =?
				AND full_paid <> 1
				ORDER BY created_at DESC
				LIMIT 1
				";
		$param[] = $id;
		$param[] = $ci->open_semester->id;
		$param[] = $ci->open_semester->year_from;
		$param[] = $ci->open_semester->year_to;
		
		$query = $this->db->query($sql,$param);
		return $query->num_rows() > 0 ? $query->row() : FALSE;
		
	}
	
	public function find($start=0,$limit=100, $filter = false, $all = false, $ret_count = false, $like = false){
		
		$start = $this->db->escape_str($start);
		$limit = $this->db->escape_str($limit);
		$ci =& get_instance();
		
		//GET Library FIELDS
		// $sql = "DESCRIBE $this->_table";
		// $query = $this->db->query($sql);
		// $fields = $query->result();
		// $fields_array = array();
		// foreach($fields as $val){
			
			// $fields_array[] = $this->_table.'.'.$val->Field;
		// }
		
		//ADD FILTERS
		$fields_array[] = 'enrollments.id';
		$fields_array[] = 'enrollments.studid';
		$fields_array[] = 'enrollments.name';
		$fields_array[] = 'courses.course';
		$fields_array[] = 'years.year';
		
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
		$this->db->from($this->enrollment_tbl);
		$this->db->where($param);
		if($like != false){
			$this->db->like($like);
		}
		$this->db->order_by("enrollments.name", "ASC"); 
		$this->db->join('courses', 'courses.id = '.$this->enrollment_tbl.'.course_id','LEFT');
		$this->db->join('years', 'years.id = '.$this->enrollment_tbl.'.year_id','LEFT');
		
		
		if($all == false){
			$this->db->limit($limit, $start);
		}
		
		$query = $this->db->get();
		// vp($like);
		// vp($this->db->last_query());
		// die();
		if($ret_count == false){
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}else{
			return $query->num_rows();
		}
	}
	
	public function get_course_id_of_last_enrollment($studid)
	{
		$sql = "
			SELECT 
				e.id,
				e.course_id,
				c.course
			FROM $this->enrollment_tbl e
			LEFT JOIN courses c ON c.id = e.course_id
			WHERE e.studid = ?
			AND e.is_deleted = ?
			ORDER BY e.id DESC
			LIMIT 1
		";
		
		$query = $this->db->query($sql, array($studid, 0));
		// vd($this->db->last_query());
		return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function get_all_student_enrollments($login)
	{
		$sql = "
			SELECT 
				e.id,
				e.semester_id,
				e.is_used,
				e.course_id,
				e.sy_from,
				e.sy_to,
				s.name,
				c.course
			FROM $this->enrollment_tbl e
			LEFT JOIN semesters s ON s.id = e.semester_id
			LEFT JOIN courses c ON c.id = e.course_id
			WHERE e.studid = ?
			AND e.is_deleted = ?
			ORDER BY e.id DESC
		";
		
		$query = $this->db->query($sql, array($login,'0'));
		
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	public function set_enrollment_default_used($login)
	{
		//CHECK IF THERE IS ENROLLMENTS SET AS DEFAULT (enrollments.is_used = 1) IF NONE UPDATE
		$sql = "
			SELECT id 
			FROM $this->enrollment_tbl
			WHERE studid = ?
			AND is_used = ?
		";
		$query = $this->db->query($sql, array($login, 1));
		
		if($query->num_rows() <= 0)
		{
			$sql = "
				UPDATE $this->enrollment_tbl
				set is_used = ?
				WHERE studid = ?
				AND is_used = ?
				ORDER BY ID DESC
				LIMIT 1
			";
			
			$query = $this->db->query($sql, array(1,$login, 0));
		}
		
	}

	public function reset_enrollment_is_used($login)
	{
		$sql = "
			UPDATE
			$this->enrollment_tbl 
			SET is_used = ?
			WHERE studid =?
			AND is_used = ?
		";
		
		$query = $this->db->query($sql, array(0, $login,1));
	}
	
	public function get_open_enrollment($login)
	{
		$sql = "
			SELECT 
				e.id
			FROM $this->enrollment_tbl e
			WHERE e.studid = ?
			AND e.is_used = ?
			ORDER BY e.id DESC
		";
		
		$query = $this->db->query($sql, array($login, 1));
		
		return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function get_last_semester_enrolled($tudid){
	
		$sql = "select 
					$this->enrollment_tbl.studid,
					$this->enrollment_tbl.semester_id,
					semesters.name
				FROM $this->enrollment_tbl
				LEFT JOIN semesters ON semesters.id = $this->enrollment_tbl.semester_id
				WHERE $this->enrollment_tbl.studid = ?
				ORDER BY $this->enrollment_tbl.created_at DESC
				LIMIT 1
				";
		$query = $this->db->query($sql,array($tudid));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function get_last_enrollment($studid, $array = false, $all = false){
		
		$sql = "select 
					$this->enrollment_tbl.id,
					$this->enrollment_tbl.name,
					$this->enrollment_tbl.studid,
					$this->enrollment_tbl.sy_from,
					$this->enrollment_tbl.sy_to,
					$this->enrollment_tbl.course_id,
					$this->enrollment_tbl.year_id,
					$this->enrollment_tbl.semester_id,
					years.year as years,
					courses.course as course,
					semesters.name as semester
				FROM $this->enrollment_tbl
				LEFT JOIN years ON (years.id = $this->enrollment_tbl.year_id)
				LEFT JOIN courses ON (courses.id = $this->enrollment_tbl.course_id)
				LEFT JOIN semesters ON (semesters.id = $this->enrollment_tbl.semester_id)
				WHERE $this->enrollment_tbl.studid = ?
				ORDER BY $this->enrollment_tbl.created_at DESC
				LIMIT 1
				";
		$query = $this->db->query($sql,array($studid));
		if($array){
			return $query->num_rows() > 0 ? $query->first_row('array') : FALSE;
		}else{
			return $query->num_rows() > 0 ? $query->row() : FALSE;
		}
	}
	
	public function get_last_enrollment_all($studid = false){
		
		$sql = "select 
					*
				FROM $this->enrollment_tbl
				WHERE $this->enrollment_tbl.studid = ?
				ORDER BY $this->enrollment_tbl.created_at DESC
				LIMIT 1
				";
		$param[] = $studid;
		$query = $this->db->query($sql,$param);
		return $query->num_rows() > 0 ? $query->first_row('array') : FALSE;
	}
	
	public function get_current_enrollment($studid){
	
		$ci =& get_instance();
		
		$sql = "select 
					id
				FROM $this->enrollment_tbl
				WHERE semester_id = ?
				AND sy_from = ?
				AND sy_to = ?
				AND studid = ?
				AND is_deleted = ?
				LIMIT 1
				";
		$param[] = $ci->open_semester->semester_id;
		$param[] = $ci->open_semester->year_from;
		$param[] = $ci->open_semester->year_to;
		$param[] = $studid;
		$param[] = 0;
		$query = $this->db->query($sql,$param);
		// vd($this->db->last_query());
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function get_previous_unpaid_enrollment($studid){
		
		$sql = "
			SELECT
				 enrollments.id as enrollment_id,
				 student_total_file.*
			FROM $this->enrollment_tbl 
			LEFT JOIN student_total_file ON student_total_file.enrollment_id = enrollments.id
			WHERE enrollments.studid = ?
			AND enrollments.is_deleted = ?
			AND student_total_file.balance > ?
			ORDER BY enrollments.id DESC
			";
		
		$param[] = $studid;
		$param[] = 0;
		$param[] = 0;
		
		$query = $this->db->query($sql, $param);
		
		return $query->num_rows() > 0 ? $query->result() : false;
	}
}
