<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Section_offering extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session_checker->open_semester();
		$this->session_checker->check_if_alive();
		$this->session_checker->secure_page('student');
		$this->load->model('M_enrollments');
	}
	
	public function index($page = 0)
	{
		$this->load->model(array('M_course_blocks','M_core_model'));
		$this->view_data['course'] = $this->student->course;
		$this->view_data['course_id'] = $course_id = $this->student->course_id;
		$this->view_data['year_id'] = $year_id = $this->student->year_id;
		
		//GET BLOCK SECTION OF THE STUDENT COURSE	
		
		//CONFIGURATION
		$config['fields'] = array(
			'block_system_settings.id',
			'block_system_settings.name',
			'block_system_settings.year_id',
			'years.year'
		);
		$config['where'] = array(
			'course_blocks.course_id' => $course_id
		);
		//$config['or_where'] = OR conditions
		//$config['like'] = LIKE conditions
		$config['join'][] = array(
			"table" => "course_blocks",
			"on"	=> "course_blocks.block_system_setting_id = block_system_settings.id",
			"type"  => "LEFT"
		);
		$config['join'][] = array(
			"table" => "years",
			"on"	=> "years.id = course_blocks.year_id",
			"type"  => "LEFT"
		);
		$config['group'] = "course_blocks.block_system_setting_id";
		$config['order'] = "block_system_settings.id, years.year";
		//$config['start'] = LIMIT START conditions
		//$config['limit'] = LIMIT END conditions
		
		//$config['count'] = true or false : return count not the row
		//$config['array'] = true or false : return array instead of object
		//$config['single'] = true or false : return single record
		
		$this->load->library("pagination");
		$pg_config = $this->pagination_style();
		$pg_config["base_url"] = base_url() ."books/index";
		
		$config['all'] = false;
		$config['count'] = true;
		
		$this->view_data['total_rows'] = $pg_config["total_rows"] = $this->M_core_model->get_record('block_system_settings', $config);
		$pg_config["per_page"] = 30;
		$pg_config['num_links'] = 10;
		$pg_config["uri_segment"] = 3;
		
		$config['start'] = $page;
		$config['limit'] = $pg_config['per_page'];
		$config['all'] = false;
		$config['count'] = false;
		
		$this->pagination->initialize($pg_config);
		$this->view_data['blocks'] = $this->M_core_model->get_record('block_system_settings', $config);
		$this->view_data['links'] = $this->pagination->create_links();
	}
	
	public function search($page = 0)
	{
		$this->load->helper('my_dropdown');
		$this->load->model(array('M_course_blocks','M_core_model'));
		// vd($this->open_semester);
		$this->view_data['course'] = $this->student->course;
		$this->view_data['course_id'] = $course_id = $this->student->course_id;
		$this->view_data['year_id'] = $year_id = $this->student->year_id;
		
		$this->view_data['type'] = $type = 'block'; //default selection
		
		if($_POST)
		{
			if(isset($_POST['action']) && $_POST['action'] == 'ajax')
			{
				$this->disable_views = true; //DISABLE THE CONTROLLER TO LOAD THE VIEWS
				$this->layout_view = false; //REMOVE LAYOUT - TRUE THIS IS YOU USED HTML IN YOU AJAX
			}
			
			$this->view_data['type'] = $type = $this->input->post('type');
			$this->view_data['keyword'] = $keyword = trim($this->input->post('keyword'));
			$this->view_data['year_id'] = $year_id = $this->input->post('year_id');
			$page = 0; //reset page to 0
			$filter = array();
			switch($type)
			{
				case "block":
					
					if($keyword != "")
					{
						$filter['block_system_settings.name'] = $keyword;
					}
					
					$config['like'] = $filter;
					
				break;
				
				case "course":
					
					
					if($keyword != ""){
						$filter['courses.course'] = $keyword;
					}
					
					$config['like'] = $filter;
					
					unset($filter);
					if(isset($year_id) && $year_id != '')
					{
						$filter['course_blocks.year_id'] = $year_id;
					}
					
					$filter['course_blocks.academic_year_id'] = $this->open_semester->academic_year_id;
					$filter['course_blocks.semester_id'] = $this->open_semester->semester_id;
					
					$config['where'] = $filter;
					
					$config['join'][] = array(
						"table" => "courses",
						"on"	=> "courses.id = course_blocks.course_id",
						"type"  => "LEFT"
					);
					$config['join'][] = array(
						"table" => "years",
						"on"	=> "years.id = course_blocks.year_id",
						"type"  => "LEFT"
					);
					
					$config['join'][] = array(
						"table" => "block_system_settings",
						"on"	=> "block_system_settings.id = course_blocks.block_system_setting_id",
						"type"  => "LEFT"
					);
					
				break;
				
				case "subject":
					if($keyword != ""){
						$filter['subjects.subject'] = $keyword;
					}
					
					$config['like'] = $filter;
					
					unset($filter);
					if(isset($year_id) && $year_id != '')
					{
						$filter['subjects.year_id'] = $year_id;
					}
					
					$filter['subjects.year_from'] = $this->open_semester->year_from;
					$filter['subjects.year_to'] = $this->open_semester->year_to;
					$filter['subjects.semester_id'] = $this->open_semester->semester_id;
					
					$config['where'] = $filter;
					
					$config['join'][] = array(
						"table" => "subjects",
						"on"	=> "subjects.id = block_subjects.subject_id",
						"type"  => "LEFT"
					);
					$config['join'][] = array(
						"table" => "block_system_settings",
						"on"	=> "block_system_settings.id = block_subjects.block_system_setting_id",
						"type"  => "LEFT"
					);
					
				break;
			}
		}
		
		switch($type)
		{
			case "block":
				$table = "block_system_settings";
				
				//CONFIGURATION
				$config['fields'] = array(
					'block_system_settings.id',
					'block_system_settings.name'
				);	
				
			break;
			
			case "course":
				$table = "course_blocks";
				
				$config['fields'] = array(
					'course_blocks.id',
					'years.year',
					'courses.course',
					'block_system_settings.name'
				);	
			break;
			
			case "subject":
				$table = "block_subjects";
				$config['fields'] = array(
					'block_subjects.id',
					'block_subjects.subject_id',
					'block_subjects.block_system_setting_id',
					'subjects.sc_id',
					'subjects.units',
					'subjects.lec',
					'subjects.lab',
					'subjects.time',
					'subjects.day',
					'subjects.room',
					'subjects.load',
					'subjects.code',
					'subjects.subject',
					'block_system_settings.name as block'
				);	
				
			break;
		}
		
		
		$this->load->library("pagination");
		$pg_config = $this->pagination_style();
		$pg_config["base_url"] = base_url() ."section_offering/search";
		
		$config['all'] = false;
		$config['count'] = true;
		
		$this->view_data['total_rows'] = $pg_config["total_rows"] = $this->M_core_model->get_record($table, $config);
		$pg_config["per_page"] = 25;
		$pg_config['num_links'] = 5;
		$pg_config["uri_segment"] = 3;
		
		$config['start'] = $page;
		$config['limit'] = $pg_config['per_page'];
		$config['all'] = false;
		$config['count'] = false;
		
		$this->pagination->initialize($pg_config);
		$this->view_data['records'] = $this->M_core_model->get_record($table, $config);
		$this->view_data['links'] = $this->pagination->create_links();
		
		
	}
	
	public function view_subjects($id = false)
	{
		//THIS IS AN AJAX FUNCTION
		
		$this->disable_views = true; //DISABLE THE CONTROLLER TO LOAD THE VIEWS
		$this->layout_view = false; //REMOVE LAYOUT - TRUE THIS IS YOU USED HTML IN YOU AJAX
		
		$this->load->model(array('M_block_subjects'));
		
		$id = $this->input->post('id');
		
		$this->view_data['block_subjects'] = $this->M_block_subjects->get_block_subjects($id);
		
		$this->load->view('section_offering/view_subjects', $this->view_data);
	}
	
	public function view_courses($id = false)
	{
		//THIS IS AN AJAX FUNCTION
		
		$this->disable_views = true; //DISABLE THE CONTROLLER TO LOAD THE VIEWS
		$this->layout_view = false; //REMOVE LAYOUT - TRUE THIS IS YOU USED HTML IN YOU AJAX
		
		$this->load->model(array('M_course_blocks'));
		
		$id = $this->input->post('id');
		
		$this->view_data['course_blocks'] = $this->M_course_blocks->get_course_blocks($id);
		
		$this->load->view('section_offering/view_courses', $this->view_data);
	}
}