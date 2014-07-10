<?php
class M_employees extends MY_Model{

	  protected $_table = 'employees';

	  public function __construct()
	  {
		parent::__construct();
		$this->load->database();
	  }

	  public function employees_for_tk($plus_admin = false)
	  {

	  	$res = array(''=>'Select');	

	  	if($plus_admin){
	  		$sql = "SELECT 
		  			id,
		  			last_name,
		  			first_name,
		  			middle_name,
		  			empid
		  			FROM $this->_table
		  			ORDER BY empid
		  	";
	  	}else{
		  	$sql = "SELECT 
		  			id,
		  			last_name,
		  			first_name,
		  			middle_name,
		  			empid
		  			FROM $this->_table
		  			WHERE admin = 0
		  			ORDER BY empid
		  	";
		 }

	  	$q = $this->db->query($sql);
	  	if($q->num_rows() > 0){
			foreach($q->result() as $key => $v){
				$res[$v->empid] = $v->first_name.' '.$v->last_name;
			}
	  	}

	  	return $res;
	  }
	}
?>
