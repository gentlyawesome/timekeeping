<?php 


class M_student_deductions Extends CI_Model
{

	private $_table = 'student_deductions';

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
	
	public function sum_of_deductions($enrollment_id)
	{
		$query = $this->db->select_sum('amount')->where('enrollment_id',$enrollment_id)->get($this->_table);
		return $query->num_rows() > 0 ? $query->row() : FALSE;
	}

	public function get_sum_of_deductions($data)
	{
		$sql = "select SUM(amount) as amount
				FROM student_deductions
				WHERE enrollment_id = ?
				";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->row() : 0.00;
	}
	
	public function destroy_deducted_fee($fid,$eid)
	{
		$this->db->where('id',$fid)->where('enrollment_id',$eid,false)->delete($this->_table);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function student_deductions_with_profiles()
	{
		$sql = "SELECT CONCAT( p.first_name,  ' ', p.middle_name,  ' ', p.last_name ) AS fullname, DATE_FORMAT( sd.created_at,  '%M %d, %Y' ) AS date_created, amount, remarks, sd.id AS student_deductions_id, sd.enrollment_id
				FROM student_deductions sd
				LEFT JOIN enrollments e ON e.id = sd.enrollment_id
				LEFT JOIN profiles p ON p.id = e.profile_id";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function student_deductions_count($id)
	{
		$sql = "SELECT count(sd.id) as total_count
				FROM student_deductions sd
				WHERE sd.enrollment_id = ?";
		$query = $this->db->query($sql, array($id));
		return $query->num_rows() > 0 ? $query->row()->total_count : FALSE;
	}
	
	public function fetch_student_deductions_with_profiles($data =false,$start = false,$limit = false)
	{
		$ci =& get_instance();
		$year = $ci->open_semester->year_from;
		if($start !== false AND $data == false)
		{
			$sql = "SELECT CONCAT( p.first_name,  ' ', p.middle_name,  ' ', p.last_name ) AS fullname, DATE_FORMAT( sd.created_at,  '%M %d, %Y' ) AS date_created, amount, remarks, sd.id AS student_deductions_id, sd.enrollment_id
			FROM student_deductions sd
			LEFT JOIN enrollments e ON e.id = sd.enrollment_id
			LEFT JOIN profiles p ON p.id = e.profile_id
			WHERE YEAR(sd.created_at) <= ".$this->db->escape_str($year)."
			limit ".$this->db->escape_str($limit).",".$this->db->escape_str($start);
			
			$query = $this->db->query($sql);
			return $query->num_rows() > 0 ? $query->result() : FALSE;
			
		}elseif($data !== false)
		{
			foreach($data as $k => $v)
			{
				if(!empty($v))
				{
					if($k == 'name')
					{
						$where['p.first_name'] = $v;
						$where['p.middle_name'] = $v;
						$where['p.last_name'] = $v;
					}elseif($k == 'student_id')
					{
						$where['e.studid'] = $v;
					}
				}
			}
		
			$query = $this->db->select(array(
											"CONCAT( p.first_name,  ' ', p.middle_name,  ' ', p.last_name ) AS fullname",
											"DATE_FORMAT( sd.created_at,  '%M %d, %Y' ) AS date_created",
											"amount", "remarks", "sd.id AS student_deductions_id", "sd.enrollment_id"))
							->FROM('student_deductions sd')
							->JOIN('enrollments e','e.id = sd.enrollment_id','left')
							->JOIN('profiles p','p.id = e.profile_id','left')
							->where('YEAR(sd.created_at)',$year)
							->or_like($where)
							->limit($start,$limit)
							->get();
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}else
		{
			$sql = "SELECT count(sd.enrollment_id) as totals
			FROM student_deductions sd
			LEFT JOIN enrollments e ON e.id = sd.enrollment_id
			LEFT JOIN profiles p ON p.id = e.profile_id";
			$query = $this->db->query($sql);
			return $query->num_rows() > 0 ? $query->row()->totals : FALSE;
			
		}
	}
	
	public function get_total_num_rows($data)
	{
		foreach($data as $k => $v)
		{
			if(!empty($v))
			{
				if($k == 'name')
				{
					$where['p.first_name'] = $v;
					$where['p.middle_name'] = $v;
					$where['p.last_name'] = $v;
				}elseif($k == 'student_id')
				{
					$where['e.studid'] = $v;
				}
			}
		}
		$ci =& get_instance();
		$year = $ci->open_semester->year_from;
		$query = $this->db->select(array(
										"count(sd.enrollment_id) as totals"))
						->FROM('student_deductions sd')
						->JOIN('enrollments e','e.id = sd.enrollment_id','left')
						->JOIN('profiles p','p.id = e.profile_id','left')
						->where('YEAR(sd.created_at)',$year)
						->or_like($where)
						->get();
		return $query->num_rows() > 0 ? $query->row()->totals : FALSE;
		
	}
	
	public function get_student_deduction_byenrollment_id($id = false)
	{
		$sql = "select *
				FROM $this->_table
				WHERE enrollment_id = ?
				ORDER BY id";
		$query = $this->db->query($sql,array($id));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function get_all_students_with_deduction($start=0,$limit=100, $filter = false, $all = false, $ret_count = false){
		
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
		
		$sql="SELECT sd.id,e.id as enrollment_id,e.name, e.studid, y.year, c.course
				FROM $this->_table sd
				LEFT JOIN enrollments e ON e.id = sd.enrollment_id
				LEFT  JOIN years y ON y.id = e.year_id
				LEFT JOIN courses c ON c.id = e.course_id
				WHERE 
				e.semester_id = ?
				AND e.sy_from = ?
				AND e.sy_to = ?
				$xfilter
				GROUP BY e.studid
				ORDER BY e.name ASC";
				if($all == false){
					$sql .= " LIMIT ".$limit.",".$start;
				}
		// vd($sql);
		$query = $this->db->query($sql,$param);
		if($ret_count == false)
		{
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}else
		{
			return $query->num_rows(); 
		}
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

}
