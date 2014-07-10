<?php
	
class M_employee_attendances Extends CI_Model
{
  private $_table = 'employeeattendances';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function load_employee_db(){$this->load->model("m_employees");}
	
	public function create_attendances($selected_employee_ids, $year, $month, $day)
	{
	  $all_employees = $this->m_employees->load_active_employees_ids();
	  
	  foreach ($all_employees as $key => $value)
	  {
	    $employee_ids[] = $value['id'];
	  }
	  
	  
	  foreach ($employee_ids as $key => $row)
	  {
	    if (in_array($row, array_values($selected_employee_ids['employee_ids'])))
	    {
	       $selected[$key] = $row;
	    }
	    else
	    {
	       $unselected[$key] = $row;
	    }
	    
	  }
	  
	  foreach ($selected as $key => $id)
    {
        $data[$key]['year'] = $selected_employee_ids['year'];
        $data[$key]['month'] = $selected_employee_ids['month'];
        $data[$key]['day'] = $selected_employee_ids['day'];
        $data[$key]['employee_id'] = $id;
    }
    
    foreach ($unselected as $key => $id)
    {
        $data[$key]['year'] = $selected_employee_ids['year'];
        $data[$key]['month'] = $selected_employee_ids['month'];
        $data[$key]['day'] = $selected_employee_ids['day'];
        $data[$key]['employee_id'] = $id;
    }
    
    $this->db->insert_batch($this->_table, $data);
    
	  
	  
	}
	
}
