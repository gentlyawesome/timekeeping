<?php



class M_finance_queries Extends CI_Model
{

	private $gp_table = 'group_payments';
	
	public function new_group_payment($data)
	{
		$query = $this->db->get_where($this->gp_table, $data);
		if($query->num_rows() > 0 )
		{
			return array('status'=>'FALSE','log'=>'Date already Exisitng in database');
		}else
		{
			$data['created_at'] = NOW;
			$this->db->insert($this->gp_table,$data);
			return $this->db->affected_rows() > 0 ? array('status'=>'TRUE','log'=>'Group has been Created') : array('status'=>'FALSE','log'=>'Process Encountered An Error, Please Try Again');	
		}
	}
	
	public function all_group_payments()
	{
		$query = $this->db->select(array('id','start_date','end_date'))->get($this->gp_table);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function del_group($id)
	{
		$this->db->where('id', $id)->delete($this->gp_table); 
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	public function get_payment_data($id,$start = false,$limit = false)
	{
			$sql = "SELECT p.first_name,p.last_name,
										p.middle_name,
										p.id as profile_id,
										sp.id as student_payments_id,
										sp.account_recivable_student as payments,
										sp.remarks,
										sp.old_account,
										sp.or_no,
										date(sp.date) as stud_payment_date,
										e.id as enrollment_id,
										date(gp.start_date) as start_date,
										date(gp.end_date) as end_date
						FROM group_payments gp,studentpayments sp
						LEFT JOIN enrollments e ON e.id = sp.enrollmentid 
						LEFT JOIN profiles p ON e.profile_id = p.id 
						WHERE date(sp.date) >= gp.start_date
						AND date(sp.date) <= gp.end_date
						AND gp.id = ?"; 
			$sql .= $start == false ? "" : "limit $limit,$start";
			$query = $this->db->query($sql,array($id));
			return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function count_payment_data($id)
	{
			$sql = "SELECT count(sp.id) as total
						FROM group_payments gp,studentpayments sp
						LEFT JOIN enrollments e ON e.id = sp.enrollmentid 
						LEFT JOIN profiles p ON e.profile_id = p.id 
						WHERE date(sp.date) >= gp.start_date
						AND date(sp.date) <= gp.end_date
						AND gp.id = ? ";
			$query = $this->db->query($sql,array($id));
			return $query->num_rows() > 0 ? $query->row()->total : FALSE;
	}
	
	public function get_student_charges()
	{
		$sql ="SELECT concat(p.first_name,' ',p.last_name,' ',p.middle_name) as fullname,
					p.id as profile_id,
					st.total_units,st.tuition_fee_per_unit,
					st.lab_fee_per_unit,
					st.total_misc_fee,
					st.total_other_fee,
					st.tuition_fee,
					st.lab_fee,
					st.less_nstp,
					st.additional_charge,
					st.total_charge
					from student_totals st
					LEFT JOIN enrollments e ON e.id = st.enrollment_id
					LEFT JOIN profiles p ON p.id = e.profile_id
					GROUP BY profile_id
					";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	
	public function fetch_student_charges($start = false,$limit = false)
	{
		if($start !== false)
		{
				$sql ="SELECT
				CONCAT( p.first_name,  ' ', p.last_name,  ' ', p.middle_name ) AS fullname, 
				p.id AS profile_id, 
				st.total_units, 
				st.tuition_fee_per_unit, 
				st.lab_fee_per_unit, 
				st.total_misc_fee, 
				st.total_other_fee, 
				st.tuition_fee, 
				st.lab_fee, 
				st.less_nstp, 
				st.additional_charge, 
				st.total_charge
				FROM student_totals st
				LEFT JOIN enrollments e ON e.id = st.enrollment_id
				LEFT JOIN profiles p ON p.id = e.profile_id
				GROUP BY profile_id
				LIMIT $limit,$start";
				$query = $this->db->query($sql);
				return $query->num_rows() > 0 ? $query->result() : FALSE;
				
		}else{
				$sql ="SELECT count(enrollment_id) as total
					from student_totals st
					LEFT JOIN enrollments e ON e.id = st.enrollment_id
					LEFT JOIN profiles p ON p.id = e.profile_id
					GROUP BY profile_id";
				$query = $this->db->query($sql);
				return $query->num_rows() > 0 ? $query->result_array() : FALSE;
		}
	}
	
	
	public function all_student_payments()
	{
		$sql = "SELECT concat(p.first_name,' ',p.middle_name,' ',p.last_name) as fullname,				
			DATE_FORMAT(date,'%M %d, %Y') as date_of_payment,				
			account_recivable_student,old_account,total,enrollmentid,or_no				
			FROM studentpayments sp				
			LEFT JOIN enrollments e ON e.id = sp.enrollmentid				
			LEFT JOIN profiles p ON p.id = e.profile_id";
		$query = $this->db->query($sql);
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function get_student_payments($data = false,$start = false,$limit = false)	
	{		
		if($start !== false AND $data == false)		
		{			
			$sql = "SELECT concat(p.first_name,' ',p.middle_name,' ',p.last_name) as fullname,				
			DATE_FORMAT(date,'%M %d, %Y') as date_of_payment,				
			account_recivable_student,old_account,sp.total,sp.enrollmentid,or_no				
			FROM studentpayments sp				
			LEFT JOIN enrollments e ON e.id = sp.enrollmentid				
			LEFT JOIN profiles p ON p.id = e.profile_id				
			limit ".$this->db->escape_str($limit).",".$this->db->escape_str($start);
			// var_dump($sql);
			$query = $this->db->query($sql);			
			return $query->num_rows() > 0 ? $query->result() : FALSE;		
		}elseif($data !== false)
		{			
			$query = $this->db->select(array("concat(p.first_name,' ',p.middle_name,' ',p.last_name) as fullname",				
									"DATE_FORMAT(date,'%M %d, %Y') as date_of_payment",				
									"account_recivable_student","old_account","total","enrollmentid","or_no"))
					->from('studentpayments sp')
					->join('enrollments e','e.id = sp.enrollmentid','left')
					->join('profiles p','p.id = e.profile_id','left')
					->or_like($data,'both')
					->limit($start,$limit)
					->get();
						
			return $query->num_rows() > 0 ? $query->result() : FALSE;
		}else{			
			$sql = "SELECT count(sp.id) as total
			FROM studentpayments sp				
			LEFT JOIN enrollments e ON e.id = sp.enrollmentid				
			LEFT JOIN profiles p ON p.id = e.profile_id";			
			$query = $this->db->query($sql);			
			return $query->num_rows() > 0 ? $query->row()->total : FALSE;					
		}
		
	}
	
	public function count_searched_student_payments($data)
	{
		$query = $this->db->select(array("count(or_no) as totals"))
				->from('studentpayments sp')
				->join('enrollments e','e.id = sp.enrollmentid','left')
				->join('profiles p','p.id = e.profile_id','left')
				->or_like($data,'both')
				->get();
		return $query->num_rows() > 0 ? $query->row()->totals : FALSE;
	}
}