<?php
	
class M_promissory_notes Extends CI_Model
{
	private $__table = 'promissory_notes';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function create_promissory_notes($input)
	{
		$id = $input['enrollment_id'];
		$stot['preliminary'] = $input['preliminary'] ;
		$stot['midterm'] = $input['midterm'] ;
		$stot['semi_finals'] = $input['semi_finals'] ;
		$stot['finals'] = $input['finals'] ;
		
		$stot['updated_at'] = NOW;
		$this->db->where('enrollment_id', $id);
		$this->db->update('student_totals', $stot); 
			if( $this->db->affected_rows() > 0 )
			{
				
				return array('status'=>'true');
			}
			else
			{
				return array('status'=>'false');
			}
	}
	
	public function add_promissory_notes($input)
	{
		$input['created_at'] = NOW;
		$input['updated_at'] = NOW;
		$this->db->insert($this->__table,$input);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}

	public function get_promissory_notes($data)
	{
		$sql = "select id, value, date
				FROM promissory_notes
				WHERE is_delete = '0' AND enrollment_id = ?";
		$query = $this->db->query($sql,array($data));
		return $query->num_rows() > 0 ? $query->result() : FALSE;
	}
	
	public function set_delete_promissory_notes($id,$data)
	{
		$datus = array(
            'is_delete' => $data
        );
		
		$this->db->where('id', $id);
		$this->db->update('promissory_notes', $datus); 
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}
	
	/* verify_data
	 * @param array
	 * @param int
	*  verifies if data entered by user is existing already in the database
	*  $strict level 1,2
	*  level 1 = if one field has existing data in database returns true else false
	*  level 2 = if all field has existing data in database returns true else false
	*  12/11/2012
	*/
	public function verify_data($data,$strict_level)
	{
			if($strict_level == 1)
			{
				$query = $this->db->or_where($data)->get($this->__table);
			}elseif($strict_level == 2){
				$query = $this->db->where($data)->get($this->__table);
			}
			return $query->num_rows() > 0 ? TRUE : FALSE;
	}
}