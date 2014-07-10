<?php


class M_student_grades Extends CI_Model
{

	public function get_student_grades_for_subject($id)
	{
		$ci =& get_instance();
		$yf = $this->db->escape_str($this->open_semester->year_from);
		$yt = $this->db->escape_str($this->open_semester->year_to);
		$s = $this->db->escape_str($this->open_semester->id);
		$sql = 'SELECT 
				DISTINCT sgf.user_id,sgc.category,sgc.value,e.studid,sg.remarks
				FROM student_grade_files sgf
				LEFT JOIN student_grades sg ON sg.student_grade_file_id = sgf.id
				LEFT JOIN student_grade_categories sgc ON sgc.student_grade_id = sg.id
				LEFT JOIN enrollments e ON e.id = sgf.user_id
				LEFT JOIN subjects  s ON s.id = sg.subjectid
				WHERE sg.subjectid = ? 
				AND e.studid != ""
				AND s.year_from >= '.$yf.' 
				AND s.year_to <= '.$yt.'
				AND s.semester_id = '.$s;
		return $this->db->query($sql,array($id))->result();
	}
	
	public function get_student_grade_by_student_grade_file_id($id)
	{
		$sql = 'SELECT 
					subjects.sc_id,
					subjects.subject,
					subjects.code,
					student_grades.value,
					student_grades.remarks,
					subjects.lec,
					subjects.lab
				FROM student_grades
				LEFT JOIN subjects ON subjects.id = subject_id
				WHERE  student_grades.student_grade_file_id = ?
				ORDER BY subjects.subject';
		return $this->db->query($sql,array($id))->result();
	}
	
	public function get_student_grade_subjects($id)
	{
		$ci =& get_instance();
		$yf = $this->db->escape_str($this->open_semester->year_from);
		$yt = $this->db->escape_str($this->open_semester->year_to);
		$s = $this->db->escape_str($this->open_semester->id);
		$sql = 'SELECT 
				DISTINCT sgf.user_id,sgc.category,sgc.value, sg.remarks, e.name, e.studid, e.id
				FROM student_grade_files sgf
				LEFT JOIN student_grades sg ON sg.student_grade_file_id = sgf.id
				LEFT JOIN student_grade_categories sgc ON sgc.student_grade_id = sg.id
				LEFT JOIN enrollments e ON e.id = sgf.user_id
				LEFT JOIN subjects  s ON s.id = sg.subjectid
				WHERE sg.subjectid = ? 
				AND sgc.category != "Remedial"
				AND sgc.category != "Semi-Finals"
				AND e.is_paid = 1
				AND e.sy_from = '.$yf.' 
				AND e.sy_to = '.$yt.'
				AND e.semester_id = '.$s.'
				ORDER BY e.name ASC, FIELD(sgc.category, "Preliminary, Midterm, Semi-Finals, Finals") DESC
				';
		$result = $this->db->query($sql,array($id));
		if ($result->num_rows() > 0) {
		  foreach ($result->result() as $key => $result) {
		    $data[$result->studid]["grades"][] = $result->value;
		    $data[$result->studid]['name'] = $result->name;
		    $data[$result->studid]['studid'] = $result->studid;
		    $data[$result->studid]['remarks'] = $result->remarks;
		    $data[$result->studid]['id'] = $result->id;
		  }
		  
		}
		return (object)$data;
	}
	
	
	public function get_student_grades($id)
	{
		$sql = 'SELECT 
				 sgf.user_id,sgc.category,sgc.value, sg.remarks, e.name, e.studid, e.id, s.subject, s.code, s.id as subject_id, s.sc_id,sg.id as student_grade_id
				FROM student_grade_files sgf
				LEFT JOIN student_grades sg ON sg.student_grade_file_id = sgf.id
				LEFT JOIN student_grade_categories sgc ON sgc.student_grade_id = sg.id
				LEFT JOIN enrollments e ON e.id = sgf.user_id
				LEFT JOIN subjects  s ON s.id = sg.subjectid
				WHERE sgf.user_id = ?
				AND sgc.category != "Remedial"
				AND sgc.category != "Semi-Finals"
				ORDER BY FIELD(sgc.category, "Preliminary, Midterm, Finals") DESC
				';
		$result = $this->db->query($sql,array($id));
		if ($result->num_rows() > 0) {
		  foreach ($result->result() as $key => $result) {
		    $data[$result->subject_id]["grades"][] = $result->value;
		    $data[$result->subject_id]['remarks'] = $result->remarks;
		    $data[$result->subject_id]['subject_desc'] = $result->subject;
		    $data[$result->subject_id]['code'] = $result->code;
		    $data[$result->subject_id]['sc_id'] = $result->sc_id;
		  }
			return (object)$data;
		}
		
		return false;
	}
	
	public function get_student_grades_transcript($id)
	{
		$sql = 'SELECT sgf.user_id,sgc.category,sgc.value, sg.remarks, e.name, e.studid, e.id, s.subject, s.code,s.sc_id, s.id as subject_id, sg.id as student_grade_id, e.studid, e.created_at, c.course, y.year, sem.name as semester_name, e.id as enrollment_id
				FROM enrollments e
				LEFT JOIN student_grade_files sgf ON sgf.user_id  = e.id
				LEFT JOIN student_grades sg ON sg.student_grade_file_id = sgf.id
				LEFT JOIN student_grade_categories sgc ON sgc.student_grade_id = sg.id
				LEFT JOIN subjects  s ON s.id = sg.subjectid
				LEFT JOIN years  y ON y.id = e.year_id
				LEFT JOIN semesters sem ON sem.id = e.semester_id
				LEFT JOIN courses  c ON c.id = e.course_id
				WHERE e.studid = ?
				AND sgc.category != "Preliminary"
				AND sgc.category != "Midterm"
				AND sgc.category != "Remedial"
				AND sgc.category != "Semi-Finals"
				ORDER BY e.created_at DESC
				';
		
		$result = $this->db->query($sql,array($id));
		if ($result->num_rows() > 0) {
		  foreach ($result->result() as $key => $result) {
		    $data[$result->enrollment_id]["year"] = $result->year;
		    $data[$result->enrollment_id]["semester"] = $result->semester_name;
		    $data[$result->enrollment_id]["course"] = $result->course;
		    
		    $data[$result->enrollment_id]["student_grades"][$result->subject_id]["value"] = $result->value;
		    $data[$result->enrollment_id]["student_grades"][$result->subject_id]['remarks'] = $result->remarks;
		    $data[$result->enrollment_id]["student_grades"][$result->subject_id]['description'] = $result->subject;
		    $data[$result->enrollment_id]["student_grades"][$result->subject_id]['code'] = $result->code; 	   
		    $data[$result->enrollment_id]["student_grades"][$result->subject_id]['sc_id'] = $result->sc_id; 	     
		  }
		  
		}
		return (object)$data;
	}
	
	
	public function create_student_grades($input = false)
	{
		$this->db->insert("student_grades",$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true', 'id' => $this->db->insert_id()) : array('status'=>'false');
	}
	
}
