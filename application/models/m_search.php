<?php
class M_search Extends CI_Model
{
    private $ci;
    private $yf;
    private $yt;
    private $id;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->ci =& get_instance();
        $this->yf = $this->ci->open_semester->year_from;
        $this->yt = $this->ci->open_semester->year_to;
        $this->id = $this->ci->open_semester->id;
    }
    
    public function search($array, $type=0)
    {
        if ($array['fname'] == NULL AND $array['lastname'] == NULL AND $array['studid'] == NULL) {
            $sql   = "SELECT enrollments.id, enrollments.studid, enrollments.name, years.year, courses.course, enrollments.user_id 
            FROM enrollments 									
            LEFT JOIN years ON (years.id = enrollments.year_id) 					
            LEFT JOIN semesters ON (semesters.id = enrollments.semester_id) 					
            LEFT JOIN courses ON (courses.id = enrollments.course_id) 					
            WHERE enrollments.semester_id='$this->id' 					
            AND enrollments.sy_from='$this->yf' 					
            AND enrollments.sy_to='$this->yt' 					
            AND enrollments.is_paid= '0' 
            AND enrollments.is_deleted = 0";
            $query = $this->db->query($sql);
        } else {
            foreach ($array as $key => $value) {
                if (empty($value) OR $value == NULL OR $value == FALSE) {
                } else {
                    if ($key == 'fname' OR $key == 'lastname' OR $key == "studid") {
                        
                        $search['enrollments.' . $key] = '%' . $value . '%';
                    }
                }
            }
            $cols  = implode(' like ? AND ', array_keys($search)) . ' like ? ';
            $vals  = array_values($search);
            $sql   = "SELECT enrollments.id, enrollments.studid,enrollments.name , years.year, courses.course 
                      FROM enrollments 											
                      LEFT JOIN years ON (years.id = enrollments.year_id) 						
                      LEFT JOIN semesters ON (semesters.id = enrollments.semester_id) 						
                      LEFT JOIN courses ON (courses.id = enrollments.course_id) 						
                      WHERE $cols						
                      AND (enrollments.semester_id='$this->id' 						
                      AND enrollments.sy_from='$this->yf' 						
                      AND enrollments.sy_to='$this->yt' 						
                      AND enrollments.is_paid= '0' 
                      AND enrollments.is_deleted = 0)";
            $query = $this->db->query($sql, $vals);
        }
        
        return $query->num_rows() > 0 ? $query->result() : FALSE;
    }
    
    
    public function search_employee($array)
    {
        if ($array['name'] == NULL AND $array['employeeid'] == NULL) {
        } else {
            if ($array['name'] == NULL) {
                $id    = $this->db->escape_like_str($array['employeeid']);
                $sql   = "SELECT id,employeeid,first_name,last_name,role From employees where employeeid like '%" . $id . "%'";
                $query = $this->db->query($sql, array(
                    $array['employeeid']
                ));
				
            } elseif ($array['employeeid'] == NULL) {
                $name  = $this->db->escape_like_str($array['name']);
                $sql   = "SELECT id,employeeid,first_name,last_name,role From employees where							first_name like '%" . $name . "%' OR last_name like '%" . $name . "%' OR middle_name like '%" . $name . "%'";
				
                $query = $this->db->query($sql);
            } else {
				$name  = $this->db->escape_like_str($array['name']);
				$id  = $this->db->escape_like_str($array['employeeid']);
                $sql   = "SELECT id,employeeid,first_name,last_name,role 
						From employees 
						where employeeid like '%".$id."%' AND (first_name like '%" . $name . "%' OR last_name like '%" . $name . "%' OR middle_name like '%" . $name . "%')";
                $query = $this->db->query($sql);
            }
			
            return $query->num_rows() > 0 ? $query->result() : FALSE;
        }
    }
	
	public function get_paid_students($start=0,$limit=100)
	{
			$start = $this->db->escape_str($start);
			$limit = $this->db->escape_str($limit);
			$ci =& get_instance();
			$semester_id = $ci->open_semester->id;
			$sy_from = $ci->open_semester->year_from;
			$sy_to = $ci->open_semester->year_to;
			
			$sql = 	"SELECT enrollments.id as enrollment_id,enrollments.name, enrollments.studid, years.year, courses.course 
						FROM enrollments
						LEFT JOIN years ON (years.id = enrollments.year_id) 						
						LEFT JOIN semesters ON (semesters.id = enrollments.semester_id) 						
						LEFT JOIN courses ON (courses.id = enrollments.course_id) 	
						WHERE enrollments.is_paid = 1
					  AND enrollments.semester_id = ?
					  AND enrollments.sy_from = ?
					  AND enrollments.sy_to = ?
					  ORDER BY enrollments.name ASC
						LIMIT ".$limit.",".$start;
			$query = $this->db->query($sql,array($semester_id,$sy_from, $sy_to));
			// vp($this->db->last_query(), true);
		if ($query->num_rows() > 0) {
	            foreach ($query->result() as $row)
				{
	                $data[] = $row;
	            }
	            return $data;
	        }
	        return false;
	}
	
	public function count_paid_students()
	{
			$ci =& get_instance();
			$semester_id = $ci->open_semester->id;
			$sy_from = $ci->open_semester->year_from;
			$sy_to = $ci->open_semester->year_to;
			
			$sql = 	"SELECT enrollments.id as enrollment_id,enrollments.name, enrollments.studid, years.year, courses.course 
						FROM enrollments
						LEFT JOIN years ON (years.id = enrollments.year_id) 						
						LEFT JOIN semesters ON (semesters.id = enrollments.semester_id) 						
						LEFT JOIN courses ON (courses.id = enrollments.course_id) 	
						WHERE enrollments.is_paid = 1
					  AND enrollments.semester_id = ?
					  AND enrollments.sy_from = ?
					  AND enrollments.sy_to = ?
					  ORDER BY enrollments.name ASC";
			$query = $this->db->query($sql,array($semester_id,$sy_from, $sy_to));
			return $query->num_rows();
	}
}
