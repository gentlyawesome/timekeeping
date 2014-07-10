<?php

  #doc
  #  classname:  M_assignsubjects
  #  scope:    PUBLIC
  #
  #/doc
  
  class M_assignsubjects extends CI_Model
  {
    #  internal variables
  
    #  Constructor
    private $_table = 'assignsubjects';
    function __construct ()
    {
		  parent::__construct();
		  $this->load->database();
    }
    ###
    
    public function insert_to_db($array)
	  {
	  foreach ($array['subject_ids'] as $key => $id)
    {
        $data[$key]['employee_id'] = $array['employee_id'];
        $data[$key]['subject_id'] = $id;
    }
    $this->db->insert_batch($this->_table, $data);
	  }
	  
	  public function delete_from_db($id)
	  {
	    $this->db->where('id', $id);
      $this->db->delete($this->_table); 
	  }
	  
	  public function get_employee_assignsubjects($id)
	  {
	    $sql = "SELECT assignsubjects.id, subjects.sc_id,subjects.subject,subjects.time,subjects.day, subjects.code, subjects.room
	            FROM assignsubjects
	            LEFT JOIN subjects on subjects.id = assignsubjects.subject_id
	            WHERE assignsubjects.employee_id = ?";
	    $query = $this->db->query($sql, array($id));
	    return $query->num_rows() > 0 ? $query->result() : FALSE;
	  }
	  
	  
  
  }
  ###

?>
