<?php
	
class M_student_subjects Extends CI_Model
{
	private $_table = 'studentsubjects';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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
  	
	public function get_lab_kind($data, $lab_kind)
	{
	  $value = 0.0;
	  if(is_array($data))
	  {
		  foreach ($data as $row) {
			if (strpos(strtolower($row->lab_kind),strtolower($lab_kind)) !== false) {
			  $value += $row->lab;
			}
		  }  
		  return $value;
	  }
	  return $value;
	}
	
	public function get_class_list_by_subject($subject_id, $year_from, $year_to,$semester_id)
	{
		$sql = "select enrollments.name AS student_name, enrollments.studid, enrollments.id, years.year, courses.course, semesters.name, enrollments.sex 
				FROM studentsubjects as ss
				LEFT JOIN subjects ON ss.subject_id = subjects.id
				LEFT JOIN enrollments ON ss.enrollmentid = enrollments.id
				LEFT JOIN years ON enrollments.year_id = years.id
				LEFT JOIN courses ON enrollments.course_id = courses.id
				LEFT JOIN semesters ON enrollments.semester_id = semesters.id
				WHERE ss.subject_id = ? 
				AND enrollments.sy_from = ?
				AND enrollments.sy_to =?
				AND enrollments.semester_id = ?
				AND enrollments.is_paid = 1
				ORDER BY enrollments.name ASC";
		$query = $this->db->query($sql,array($subject_id, $year_from, $year_to,$semester_id));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	
	
	
	public function get_student_subjects($data,$c,$y,$s)
	{
		$sql = "select ss.id,subjects.sc_id, subjects.code, subjects.subject, subjects.units, subjects.lab, subjects.lec, subjects.time, subjects.day, ss.enrollmentid, subjects.lab_kind
				FROM studentsubjects as ss
				LEFT JOIN subjects ON ss.subject_id = subjects.id
				WHERE ss.enrollmentid = ? 
				AND ss.course_id = ? 
				AND ss.year_id = ? 
				AND ss.semester_id = ?
				";
		$query = $this->db->query($sql,array($data,$c,$y,$s));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function get_student_subjects_units($data,$c,$y,$s)
	{
		$sql = "select SUM(subjects.units) as total_units, SUM(subjects.lab) as total_labs,  ss.enrollmentid
				FROM studentsubjects as ss
				LEFT JOIN subjects ON ss.subject_id = subjects.id
				WHERE ss.enrollmentid = ? 
				AND ss.course_id = ? 
				AND ss.year_id = ? 
				AND ss.semester_id = ?
				";
		$query = $this->db->query($sql,array($data,$c,$y,$s));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	public function add_student_subject($input,$user_cred)
	{	
		$insert_this[] = NULL;
		foreach($input as $key => $value)
		{
			$subject_log[] = $value;
			$insert_this[$key]['subject_id'] = $value;
			$insert_this[$key]['year_id'] = $user_cred['year'];
			$insert_this[$key]['semester_id'] = $user_cred['sems'];
			$insert_this[$key]['course_id'] = $user_cred['cors'];
			$insert_this[$key]['enrollmentid'] = $user_cred['enid'];
		}
			$subject = implode(',',$subject_log);
			$this->db->insert_batch($this->_table,$insert_this);
			return $this->db->affected_rows() > 0 ? array('status'=>'true','log'=>'Added Subject ID(s): '.$subject.'; ') : array('status'=>'false','log'=>'Unable to add Subject ID(s): '.$subject. '; ');
	}
	
	public function destroy_subject($id)
	{
		$this->db->set('deleted',1)->where('id',$id)->update($this->_table);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function create_student_subject($data)
	{
		$this->db->insert($this->_table,$data);
		return $this->db->affected_rows() > 0 ? array('status'=>'true','id'=>$this->db->insert_id()) : array('status'=>'false');
	}

	
	public function recalculate_load($data, $condition)
	{
	  $this->load->model(array('M_subjects'));
	  
	  
		$sql = "select s.subject_load, s.id
				FROM studentsubjects as ss
				LEFT JOIN subjects s ON ss.subject_id = s.id
				WHERE ss.enrollmentid = ? 
				";
		$query = $this->db->query($sql,array($data));
		$result = $query->num_rows() > 0 ? $query->result() : FALSE;
		
		if($result !== FALSE){
		  foreach ($result as $s) {
	      if ($condition == "add") {
	        $this->M_subjects->update_load($s->id, 'add');
	      }
	    
	      if ($condition == "remove") {
	        $this->M_subjects->update_load($s->id, 'remove');
	      }   
	      
	    }
	  }
	}
		
	
	public function get_studentsubjects($data)
	{
		$sql = "select 
					ss.id,
					subjects.sc_id, 
					subjects.code, 
					subjects.subject, 
					subjects.units, 
					subjects.lab, 
					subjects.lec, 
					subjects.time, 
					subjects.day, 
					ss.enrollmentid, 
					subjects.lab_kind, 
					subjects.subject_load, 
					subjects.id as subjectid, 
					subjects.room, 
					subjects.lec,
					subjects.is_nstp,
					b.name as block_name
				FROM studentsubjects as ss
				LEFT JOIN subjects ON ss.subject_id = subjects.id
				LEFT JOIN block_system_settings b ON b.id = ss.block_system_setting_id
				WHERE ss.enrollmentid = ?
				";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function get_studentsubjects_total($studentsubjects)
	{
	  $data["total_units"] = $data["total_lab"] = 0;
	  if(!empty($studentsubjects)){
		foreach ($studentsubjects as $s) {
		  $data["total_units"] += $s->units;
		  $data["total_lab"] += $s->lab;
		}
		}
		
		return $data;
	}
	
	public function get_units($eid)
	{
		$sql = "select SUM(subjects.units) as total_units, SUM(subjects.lab) as total_labs,  ss.enrollmentid
				FROM studentsubjects as ss
				LEFT JOIN subjects ON ss.subject_id = subjects.id
				WHERE ss.enrollmentid = ? 
				";
		$query = $this->db->query($sql,array($eid));
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}
	
	
	public function get_all_nstp_student()
	{
		$ci =& get_instance();
		
		$sql = "
			SELECT 
				ss.id,
				e.name,
				s.subject,
				s.code,
				c.course
				FROM 
				studentsubjects ss
				LEFT JOIN enrollments e ON e.id = ss.enrollmentid
				LEFT JOIN subjects s ON s.id = ss.subject_id
				LEFT JOIN courses c ON c.id = ss.course_id
				WHERE s.code LIKE '%NSTP%'
				GROUP BY ss.enrollmentid
				ORDER BY e.name	
		";
	}
	
	public function add_ajax($input = false)
	{
		$this->db->insert($this->_table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true', 'id' => $this->db->insert_id()) : array('status'=>'false');
	}

}
