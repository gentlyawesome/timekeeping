<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search Extends MY_Controller
{
	public function __construct(){
		parent::__construct();
		$this->session_checker->open_semester();
		$this->load->model(array('M_enrollments'));
		$this->load->helper(array('url_encrypt'));
		$this->session_checker->secure_page('all');
		$this->load->model('M_core_model');
		$this->load->helper('my_dropdown');
	}
		

	public function index()
	{
		$this->session_checker->check_if_alive();
	}
	
	public function search_student_old()
	{
		show_404(); //BACKUP old search
		$this->session_checker->check_if_alive();
		
		if($_POST)
		{
			$this->load->model('M_search');
			$input['lastname'] = $this->input->post('lastname');
			$input['fname'] = $this->input->post('firstname');
			$input['studid'] = $this->input->post('studid');
			$this->view_data['search'] = $this->M_search->search($input,1);
		}
	}
	
	public function search_student($page = 0)
	{
		// SELECT enrollments.id, enrollments.studid,enrollments.name , years.year, courses.course 
                      // FROM enrollments 											
                      // LEFT JOIN years ON (years.id = enrollments.year_id) 						
                      // LEFT JOIN semesters ON (semesters.id = enrollments.semester_id) 						
                      // LEFT JOIN courses ON (courses.id = enrollments.course_id) 						
                      // WHERE enrollments.studid like '%2080788%' 						
                      // AND (enrollments.semester_id='1' 						
                      // AND enrollments.sy_from='2012' 						
                      // AND enrollments.sy_to='2013' 						
                      // AND enrollments.is_paid= '0' 
                      // AND enrollments.is_deleted = 0)
					  
					  
		
		
		//PAGINATION
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		$filter = false;
		$like = false;
		$order_by = false;
		
		$filter['enrollments.semester_id'] = $this->open_semester->id;
		$filter['enrollments.sy_from'] = $this->open_semester->year_from;
		$filter['enrollments.sy_to'] = $this->open_semester->year_to;
		$filter['enrollments.is_deleted'] = 0;
		// $filter['enrollments.is_paid'] = 0;
		
		if($_POST)
		{
			$this->view_data['lastname'] = $lastname = trim($this->input->post('lastname'));
			$this->view_data['fname'] = $fname = trim($this->input->post('fname'));
			$this->view_data['studid'] = $studid = trim($this->input->post('studid'));
			$this->view_data['year_id'] = $year_id = trim($this->input->post('year_id'));
			
			if($lastname != ""){
				$like['enrollments.lastname'] = $lastname;
			}
			if($fname != ""){
				$like['enrollments.fname'] = $fname;
			}
			if($studid != ""){
				$like['enrollments.studid'] = $studid;
			}
			if($year_id != ""){
				$like['enrollments.year_id'] = $year_id;
			}
			
			$page = 0;
		}
		
		//CONFIGURATION
		$get['fields'] = array(
				'enrollments.id',
				'enrollments.studid',
				'enrollments.name' ,
				'years.year',
				'courses.course' 
		);
		
		$get['where'] = $filter;
		$get['like'] = $like;
		
		$get['join'] = array(
			
			1 => array(
				"table" => "courses",
				"on"	=> "courses.id = enrollments.course_id",
				"type"  => "LEFT"
			),
			2 => array(
				"table" => "years",
				"on"	=> "years.id = enrollments.year_id",
				"type"  => "LEFT"
			)
		);
		$get['order'] = "enrollments.name";
		$get['all'] = true; //GET ALL EXCLUDE LIMIT
		$get['count'] = true; //RETURN COUNT NOT ROW
		$get['array'] = false; //RETURN OBJECT NOT ARRAY
		$get['single'] = false; //RETURN ALL NOT SINGLE
		
	
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."search/search_student";
		
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_core_model->get_record("enrollments", $get);
		
		$config["per_page"] = 30;
		$config['num_links'] = 10;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		
		//FOR PAGINATION
		$get['all'] = false;
		$get['count'] = false;
		if($this->input->post('submit') == "Print")
		{
			$get['all'] = true;
		}
		$get['start'] = $page;
		$get['limit'] = $config['per_page'];
		
		$this->view_data['search'] = $search = $this->M_core_model->get_record("enrollments", $get);
		$this->view_data['links'] = $this->pagination->create_links();
		
		if($this->input->post('submit') == "Print")
		{
			$this->print_nstp_students($this->view_data);
		}
	}

	public function search_enrollee()
	{
		$this->session_checker->check_if_alive();
		
		if($_POST)
		{
			$this->load->model('M_search');
			$input['lastname'] = $this->input->post('lastname');
			$input['fname'] = $this->input->post('firstname');
			$input['studid'] = $this->input->post('studid');
			$this->view_data['search'] = $this->M_search->search($input,0);
		}
	}
	
	public function search_employee()
	{
		
		if($this->input->post('search_employee'))
		{
		$this->load->model('M_search');
		$input['name'] = $this->input->post('name');
		$input['employeeid'] = $this->input->post('login');
		$this->view_data['search'] = $p = $this->M_search->search_employee($input);
		
		}
	}
	
	public function master_list_by_course()
	{
		$this->session_checker->check_if_alive();
		$this->load->model('M_courses');
		$this->view_data['masterlist'] = $master_list = $this->M_courses->masterlist();
		$this->view_data['unassigned'] = $this->M_courses->unassigned();
	}
	
	public function master_list($course_id = false)
	{
		if($course_id !== false AND ctype_digit($course_id))
		{
			$this->load->model('M_courses');
			$this->load->library("pagination");
			$config = $this->pagination_style();
			$config["base_url"] = base_url() ."search/master_list/$course_id/";
			$this->view_data['total_rows'] = $config["total_rows"] = $this->M_courses->masterlist_count($course_id);
			$config["per_page"] = 50;
			$config['num_links'] = 10;
			$config["uri_segment"] = 4;
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$this->pagination->initialize($config);
			$this->view_data['course'] = $this->M_courses->get($course_id);
			$this->view_data['course_id'] = $course_id;
			$this->view_data['search_results'] = $this->M_courses->masterlist_course_enrollment_profile($course_id,$config["per_page"], $page);
			$this->view_data['links'] = $this->pagination->create_links();
		}else
		{
			show_404();
		}
	}
	
	public function master_list_gender($course_id = false, $gender = false)
	{
		if($course_id !== false AND ctype_digit($course_id))
		{
			$this->load->model('M_courses');
			$this->load->library("pagination");
			$config = $this->pagination_style();
			$config["base_url"] = base_url() ."search/master_list_gender/$course_id/$gender";
			$this->view_data['total_rows'] = $config["total_rows"] = $this->M_courses->get_gender_count($course_id, $gender);
			$config["per_page"] = 50;
			$config['num_links'] = 10;
			$config["uri_segment"] = 5;
			$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
			$this->pagination->initialize($config);
			$this->view_data['course'] = $this->M_courses->get($course_id);
			$this->view_data['gender'] = $gender;
			$this->view_data['course_id'] = $course_id;
			$this->view_data['search_results'] = $this->M_courses->masterlist_course_enrollment_profile_gender($course_id, $gender, $config["per_page"], $page);
			$this->view_data['links'] = $this->pagination->create_links();
		}else
		{
			show_404();
		}
	}
	
	public function list_students($x = false, $page = 0)
	{
		// SELECT e.id,e.name, e.studid, years.year, courses.course
						   // FROM enrollments AS e
						   // LEFT JOIN years ON years.id = e.year_id
						   // LEFT JOIN courses ON courses.id = e.course_id
						   // WHERE  is_paid = 1 
						   // AND e.semester_id = '1'
						   // AND e.sy_from = '2013'
						   // AND e.sy_to = '2014'
						   // ORDER BY e.name ASC
						   // LIMIT 0 , 30
						   
		if($x == false) { show_404(); }
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		$filter = false;
		$like = false;
		$order_by = false;
		
		$filter['enrollments.semester_id'] = $this->open_semester->id;
		$filter['enrollments.sy_from'] = $this->open_semester->year_from;
		$filter['enrollments.sy_to'] = $this->open_semester->year_to;
		$filter['enrollments.is_deleted'] = 0;
		
		switch(strtolower($x)){
			case "paid":
				$filter['is_paid'] = 1;
			break;
			case "unpaid":
				$filter['is_paid'] = 0;
			break;
			case "fullpaid":
				$filter['full_paid'] = 1;
			break;
			case "partialpaid":
				$filter['full_paid'] = 0;
				$filter['is_paid'] = 1;
			break;
			default:
				show_404();
			break;
		}
		
		if($_POST)
		{
			$this->view_data['lastname'] = $lastname = trim($this->input->post('lastname'));
			$this->view_data['fname'] = $fname = trim($this->input->post('fname'));
			$this->view_data['studid'] = $studid = trim($this->input->post('studid'));
			$this->view_data['year_id'] = $year_id = trim($this->input->post('year_id'));
			
			if($lastname != ""){
				$like['enrollments.lastname'] = $lastname;
			}
			if($fname != ""){
				$like['enrollments.fname'] = $fname;
			}
			if($studid != ""){
				$like['enrollments.studid'] = $studid;
			}
			if($year_id != ""){
				$like['enrollments.year_id'] = $year_id;
			}
			
			$page = 0;
		}
		
		//CONFIGURATION
		
		//Fields to GET
		$get['fields'] = array(
				'enrollments.id',
				'enrollments.studid',
				'enrollments.name' ,
				'years.year',
				'courses.course' 
		);
		
		$get['where'] = $filter;
		$get['like'] = $like;
		
		$get['join'] = array(
			
			1 => array(
				"table" => "courses",
				"on"	=> "courses.id = enrollments.course_id",
				"type"  => "LEFT"
			),
			2 => array(
				"table" => "years",
				"on"	=> "years.id = enrollments.year_id",
				"type"  => "LEFT"
			)
		);
		$get['order'] = "enrollments.name";
		$get['all'] = true; //GET ALL EXCLUDE LIMIT
		$get['count'] = true; //RETURN COUNT NOT ROW
		$get['array'] = false; //RETURN OBJECT NOT ARRAY
		$get['single'] = false; //RETURN ALL NOT SINGLE
		
	
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."search/list_students/".$x;
		
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_core_model->get_record("enrollments", $get);
		
		$config["per_page"] = 30;
		$config['num_links'] = 10;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		
		//FOR PAGINATION
		$get['all'] = false;
		$get['count'] = false;
		if($this->input->post('submit') == "Print")
		{
			$get['all'] = true;
		}
		$get['start'] = $page;
		$get['limit'] = $config['per_page'];
		
		$this->view_data['results'] = $results = $this->M_core_model->get_record("enrollments", $get);
		$this->view_data['links'] = $this->pagination->create_links();
	}
	
	public function list_students_old($x = false)
	{
		
		if($x !== false AND (trim($x) == 'paid' OR trim($x) == 'unpaid' OR trim($x) == 'fullpaid' OR trim($x) == 'partialpaid' ))
		{
			$this->load->model('M_enrollments');
			$this->load->library("pagination");
			$config = $this->pagination_style();
			$config["base_url"] = base_url() ."search/list_students/$x";
	    $this->view_data['total_rows'] = $config["total_rows"] = $this->M_enrollments->count_paid_unpaid($x);
	    $config["per_page"] = 30;
	    $config["uri_segment"] = 4;
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
	    $this->pagination->initialize($config); 
	    $this->view_data["results"] = $results = $this->M_enrollments->paid_unpaid($x,$config["per_page"], $page);
	    $this->view_data['links'] = $this->pagination->create_links();
			$this->view_data['title'] = $x;
		}else
		{
			show_404();
		}	
	}
	
	public function deleted_accounts()
	{
		
		$this->session_checker->check_if_alive();
		if($this->input->post('search_deleted_user'))
		{
			$lastname = $this->input->post('lastname',TRUE);
			$firstname = $this->input->post('firstname',TRUE);
			$idno = $this->input->post('idno',TRUE);
			$semester_id_eq = $this->input->post('semester_id_eq',TRUE);
			$sy_from_eq = $this->input->post('sy_from_eq',TRUE);
			$sy_to_eq = $this->input->post('sy_to_eq',TRUE);
			$is_paid_eq = $this->input->post('is_paid_eq',TRUE);
			
			$this->view_data['search'] = $this->M_enrollments->search_deleted_accounts($firstname, $lastname, $idno, $semester_id_eq, $sy_from_eq, $sy_to_eq);
		}
	}
	
	public function destroy_enrollment($id = false)
	{
		$jquery = $this->input->post('jquery');
		if($jquery == false)
		{
			if($this->M_enrollments->destroy_enrollment($id))
			{
				log_message('info','Destroy Enrollment By: '.$this->user. '; Id: '.$id.';');
				$this->session->set_flashdata('system_message', '<div class="alert alert-success">Student Deleted</div>');
				redirect(current_url());
			}else
			{
				log_message('error','Destroy Enrollment By: '.$this->user. 'FAILED  on dean/destroy_enrollment; Id: '.$id.';');
				$this->view_data['system_message'] = '<div class="alert alert-danger">An error was encountered while processing your request</div>';
			}
		}else{
			if($this->M_enrollments->destroy_enrollment($id))
			{
				log_message('info','Destroy Enrollment By: '.$this->user. '; Id: '.$id.';');
				echo 'true';
				die();//stops php from sending the views so that browser will only receive true
			}else
			{
				log_message('error','Destroy Enrollment By: '.$this->user. 'FAILED on dean/destroy_enrollment; Id: '.$id.';');
				echo 'false';
				die();//stops php from sending the views so that browser will only receive false
			}
		}
	}
	
	public function restore_enrollment($id = false)
	{
		$jquery = $this->input->post('jquery');
		if($jquery == false)
		{
			if($this->M_enrollments->restore_enrollment($id))
			{	
				log_message('info','Restore Enrollment By: '.$this->user. '; Id: '.$id.';');
				$this->session->set_flashdata('system_message', '<div class="alert alert-success">Student Restored</div>');
				redirect(current_url());
			}else
			{
				log_message('info','Restore Enrollment By: '.$this->user. 'Failed on dean/restore_enrollment; Id: '.$id.';');
				$this->view_data['system_message'] = '<div class="alert alert-danger">An error was encountered while processing your request</div>';
			}
		}else{
			if($this->M_enrollments->restore_enrollment($id))
			{
				log_message('info','Restore Enrollment By: '.$this->user. '; Id: '.$id.';');
				echo 'true';
				die();//stops php from sending the views so that browser will only receive true
			}else
			{
				log_message('error','Restore Enrollment By: '.$this->user. 'FAILED  on dean/restore_enrollment; Id: '.$id.';');
				echo 'false';
				die();//stops php from sending the views so that browser will only receive false
			}
		}
	}
	
	public function list_paid_students($page=0)
	{
		$this->load->model('M_search');
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."search/list_paid_students";
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_search->count_paid_students();
		$config["per_page"] = 100;
		$config['num_links'] = 10;
		$config["uri_segment"] = 3;
		// $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// vp($page, true);
		$this->pagination->initialize($config);
		$this->view_data['search_results'] = $this->M_search->get_paid_students($config["per_page"], $page);
		$this->view_data['links'] = $this->pagination->create_links();
	}

}
