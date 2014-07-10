<?php
	class MY_form_validation extends CI_Form_validation{
		
		private $ci;
		
		public function __construct($rules = array()) 
		{ 
		  parent::__construct($rules); 
		  $this->CI->lang->load('MY_form_validation'); 
		  $this->ci =& get_instance();
		}
		
		public function is_existing($value, $par = ""){
			
			$this->ci->load->model('M_enrollments');
			
			$res = $this->ci->M_enrollments->get_by(array('studid'=> $value), true);
			
			if($res)
			{
				return true;
			}
			else{
				return false;
			}
		}
	}
?>