<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employees extends MY_Controller {
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model(array(
				'M_enrollments',
				'M_core_model',
				'M_assignsubjects',
				'M_subjects'
				));
		$this->load->helper(array('url_encrypt','my_dropdown'));
	}
	
	// Create
	public function create()
	{
		$this->load->library(array('form_validation','login'));

		$this->view_data['system_message'] = $this->session->flashdata('system_message');

		#load model 
		$this->load->model('M_employees');
		$this->load->model('M_users');

		if($this->input->post('save_employees')){

			$data = $this->input->post('data');

			foreach ($data as $key => $value) {
				$this->view_data[$key] = $value;
			}

			#check if id already exist
			$exist = $this->M_employees->pull(array('empid'=>$data['empid']));
			if($exist){ 
				$this->view_data['system_message'] = "<div class='alert alert-danger'>Employee Id must be unique.</div>";					
				
			}else{

				#SAVE DATA
				$data['joining_date'] = NOW;
				$rs = (object)$this->M_employees->insert($data);
				if($rs->status){

					unset($users);
					$emp = $this->M_employees->get($rs->id);

					$users['employee_id'] = $emp->id;
					$users['login'] = $emp->empid;
					$users['email'] = $emp->email;
					$users['name'] = $emp->first_name.' '.$emp->middle_name.' '.$emp->last_name;
					$users['is_active'] = 1;
					$this->login->_generate_password($users['login']);
					$users['crypted_password'] = $this->login->get_password();
					$users['salt'] = $this->login->get_salt();

					$rs_u = (object)$this->M_users->insert($users);

					if($rs_u->status){
						$this->_msg('s','Employee was successfully created', current_url());
					}

				}else{
					$this->_msg('e','Data was not saved. Please try again', current_url());
				}
			}
		}
	}
	
	// Retrieve
	public function index($page = 0)
	{
		//PAGINATION
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		// vp($_GET);
		$filter['users.is_active'] = 1;
		$filter['users.admin <>'] = 1;
		$like = false;
		$or_like = false;
		$order_by = false;
		
		$arr_filters = array();
		$suffix = "";
		
		if($_GET)
		{
			if(isset($_GET['name']) && trim($_GET['name']) != ''){
				$this->view_data['name'] = $name = trim($_GET['name']);
				$or_like['employees.last_name'] = $name;
				$or_like['employees.middle_name'] = $name;
				$or_like['employees.first_name'] = $name;
				$arr_filters['name'] = $name;
			}
			
			if(isset($_GET['empid']) && trim($_GET['empid']) != ''){
				$this->view_data['empid'] = $empid = trim($_GET['empid']);
				$like['employees.empid'] = $empid;
				$arr_filters['empid'] = $empid;
				
			}
		}
		
		//CONFIGURATION
		$get['fields'] = array(
				"employees.*",
				"CONCAT(employees.last_name,',',employees.first_name,' ', employees.middle_name) as fullname"
		);
		
		$get['where'] = $filter;
		$get['like'] = $like;
		$get['or_like'] = $or_like;
		
		$get['join'] = array(
			
			1 => array(
				"table" => "users",
				"on"	=> "users.login = employees.empid",
				"type"  => "LEFT"
			)
			
		);
		$get['order'] = "employees.name";
		$get['all'] = true; //GET ALL EXCLUDE LIMIT
		$get['count'] = true; //RETURN COUNT NOT ROW
		$get['array'] = false; //RETURN OBJECT NOT ARRAY
		$get['single'] = false; //RETURN ALL NOT SINGLE
		
	
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."employees/index";
		$config['suffix'] = '?'.http_build_query($_GET, '', "&");
		$config['first_url'] = $config['base_url'].$config['suffix']; 
		
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_core_model->get_record("employees", $get);
		
		$config["per_page"] = 5;
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
		$config['start'] = $page;
		$config['limit'] = $config['per_page'];
		
		$get['start'] = $page;
		$get['limit'] = $config['per_page'];
		
		$this->view_data['search'] = $search = $this->M_core_model->get_record("employees", $get);
		$this->view_data['links'] = $this->pagination->create_links();
	}
	
	
	public function display($id)
	{
		$this->load->model(array('M_employees'));
		$this->load->model(array('M_assignsubjects'));
		$this->load->model(array('M_assign_courses'));
		
		$this->view_data = $this->M_employees->get_employee_profile($id);
	
		$this->view_data['id'] = $id;

		$this->view_data['assign_courses'] = $this->M_assign_courses->get_employee_assigned_courses($id);
		$this->view_data['assignsubjects'] = $this->M_assignsubjects->get_employee_assignsubjects($id);
	}
	
	// Update
	public function edit($id)
	{
		$this->load->library(array('form_validation','login'));
		
		$this->load->model(array('M_employees','M_career_services','M_work_experiences','M_voluntary_works','M_training_programs','M_other_informations','M_users'));
		
		$this->view_data = $this->M_employees->get_employee_profile($id);
		
		$employees_table = $this->view_data['personal_info']; //FROM DATABASE
		
		$this->view_data['id'] = $id;

		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		if($_POST)
		{
			if($this->form_validation->run('users') !== FALSE)
			{
				$all = $this->input->post('user');
				
				$employee_attr = $all['employees_attributes'];
				
				$personal_info = $employee_attr['personal_info'];
				
				$personal_info['updated_at'] = date('Y-m-d H:i:s');
				
				$result = $this->M_employees->update_employee($personal_info, $id);
			
				if($result)
				{
					
					#region SAVE CAREER SERVICES
					$this->M_career_services->delete_career_services_by_employee_id($id); //DELETE AND INSERT
					foreach($employee_attr['career_services_attributes'] as $key => $value){
						if(trim($value['career']) != ""){
						
							$value['employee_id'] = $id;
							$value['created_at'] = date('Y-m-d H:i:s');
							$value['updated_at'] = date('Y-m-d H:i:s');
								
							$career_result = $this->M_career_services->create_career_services($value);
							
						}
					}
					#endregion
					
					#region SAVE WORK EXPERIENCES
					$this->M_work_experiences->delete_work_experiences_by_employee_id($id); //DELETE AND INSERT
					foreach($employee_attr['work_experiences_attributes'] as $key => $value){
						
						if(trim($value['position']) != ""){
						
							$value['employee_id'] = $id;
							$value['created_at'] = date('Y-m-d H:i:s');
							$value['updated_at'] = date('Y-m-d H:i:s');
								
							$we_result = $this->M_work_experiences->create_work_experiences($value);
						}
					}
					#endregion
					
					#region SAVE VOLUNTARY WORKS
					$this->M_voluntary_works->delete_voluntary_works_by_employee_id($id); //DELETE AND INSERT
					foreach($employee_attr['voluntary_works_attributes'] as $key => $value){
					
						if(trim($value['name']) != ""){
						
							$value['employee_id'] = $id;
							$value['created_at'] = date('Y-m-d H:i:s');
							$value['updated_at'] = date('Y-m-d H:i:s');
								
							$vo_result = $this->M_voluntary_works->create_voluntary_works($value);
						}
					}
					#endregion
					
					#region SAVE TRAINING PROGRAMS
					$this->M_training_programs->delete_training_programs_by_employee_id($id);//DELETE AND INSERT
					foreach($employee_attr['training_programs_attributes'] as $key => $value){
					
						if(trim($value['title']) != ""){
						
							$value['employee_id'] = $id;
							$value['created_at'] = date('Y-m-d H:i:s');
							$value['updated_at'] = date('Y-m-d H:i:s');
								
							$tp_result = $this->M_training_programs->create_training_programs($value);
						}
					}
					#endregion
					
					#region SAVE OTHER INFORMATION
					$this->M_other_informations->delete_other_informations_by_employee_id($id); //DELETE AND INSERT
					foreach($employee_attr['other_informations_attributes'] as $key => $value){
					
						if(trim($value['recognition']) != ""){
						
							$value['employee_id'] = $id;
							$value['created_at'] = date('Y-m-d H:i:s');
							$value['updated_at'] = date('Y-m-d H:i:s');
								
							$oi_result = $this->M_other_informations->create_other_informations($value);
						}
					}
					#endregion
					
					#region SAVE USER
					$user_info['login'] = trim($personal_info['employeeid']);
					$user_info['name'] = trim($personal_info['first_name']).' '.trim($personal_info['middle_name']).' '.trim($personal_info['last_name']);
					$user_info['email'] = trim($personal_info['email']);
					$user_info['updated_at'] = date('Y-m-d H:i:s');
					
					// $roles = array(
						// 'Employee' => 'Employee',
						// 'Teacher' => 'Teacher',
						// 'Registrar' => 'Registrar',
						// 'Finance' => 'Finance',
						// 'HRD' => 'HRD',
						// 'Librarian' => 'Librarian',
						// 'Dean' => 'Dean',
						// 'Custodian' => 'Custodian',
						// 'Cashier' => 'Cashier',
						// 'Guidance' => 'Guidance',
						// 'Assistant_To_The_President' => 'Assistant To The President',
					// );
					
					// foreach($roles as $key => $value){
						// $user_info[strtolower(trim($key))] = 0;
					// }
					
					// $user_info[strtolower(trim($personal_info['role']))] = 1;
					$user_info['department'] = $personal_info['role'];
				
					$this->login->_generate_password($user_info['login']);
					$user_info['crypted_password'] = $this->login->get_password();
					$user_info['salt'] = $this->login->get_salt();
					
					$user_result = $this->M_users->update_users_by_login($user_info,$employees_table->employeeid);
					
					#endregion
					
					activity_log('create employee',$this->userlogin,'User/employee Created by: '.$this->user.' Success; Employee Id: '.$id.' User ID : '.$employees_table->employeeid);
					
					log_message('error','Employee Updated by: '.$this->user.'Success; Employee Id: '.$id);
					log_message('error','User Updated by: '.$this->user.'Success; User Id: '.$id);
					$this->session->set_flashdata('system_message', '<div class="alert alert-success">Employee successfully updated.</div>');
					
					redirect(current_url());
				}
				
			}
		}
	}
	
	
	// Assign Subject
	public function add_assignsubject($employee_id = false, $page = 0)
	{
		if(!$employee_id){ show_404(); }
		
		$this->load->model(array('M_subjects','M_employees','M_assignsubjects'));
		
		$this->view_data = $this->M_employees->get_employee_profile($employee_id);
		
		$this->view_data['employee_id'] = $employee_id;
		
		$this->view_data['assignsubjects'] = $this->M_assignsubjects->get_employee_assignsubjects($employee_id);
		
		$this->view_data["employee_id"] = $employee_id;
		$this->view_data["id"] = $employee_id;
		$this->view_data['subjects'] = $this->M_subjects->current_batch_subject($this->open_semester->year_from, $this->open_semester->year_to, $this->open_semester->id);
		
		// SELECT 
			// assignsubjects.id, 
			// subjects.sc_id,
			// subjects.subject,
			// subjects.time,
			// subjects.day, 
			// subjects.code, 
			// subjects.room, 
			// assignsubjects.subject_id
		// FROM assignsubjects
		// LEFT JOIN subjects on subjects.id = assignsubjects.subject_id
		// WHERE assignsubjects.employee_id = '256
		
				$filter = false;
		$like = false;
		$order_by = false;
		
		$filter['assignsubjects.employee_id'] = $employee_id;
		
		$arr_filters = array();
		if($_POST)
		{	
		
		}
		
		//CONFIGURATION
		$get['fields'] = array(
			'assignsubjects.id', 
			'subjects.sc_id',
			'subjects.subject',
			'subjects.time',
			'subjects.day', 
			'subjects.code', 
			'subjects.room', 
		);
		
		$get['where'] = $filter;
		$get['like'] = $like;
		$get['join'] = array(
			
			1 => array(
				"table" => "subjects",
				"on"	=> "subjects.id = assignsubjects.subject_id",
				"type"  => "LEFT"
			)
		);
		
		$get['order'] = "subjects.subject";
		$get['all'] = true; //GET ALL EXCLUDE LIMIT
		$get['count'] = true; //RETURN COUNT NOT ROW
		$get['array'] = false; //RETURN OBJECT NOT ARRAY
		$get['single'] = false; //RETURN ALL NOT SINGLE
		
	
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."employees/add_assignsubject/".$employee_id;
		$suffix = '?'.http_build_query($_GET, '', "&");
		$suffix = str_replace("&submit=Search", "", $suffix);
		$config['suffix'] = $suffix;
		$config['first_url'] = $config['base_url'].$config['suffix']; 
		
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_core_model->get_record("assignsubjects", $get);
		
		$config["per_page"] = 5;
		$config['num_links'] = 10;
		$config["uri_segment"] = 4;
		// $config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		
		//FOR PAGINATION
		$get['all'] = false;
		$get['count'] = false;
		if($this->input->post('submit') == "Print")
		{
			$get['all'] = true;
		}
		$config['start'] = $page;
		$config['limit'] = $config['per_page'];
		
		$get['start'] = $page;
		$get['limit'] = $config['per_page'];
	
		$this->view_data['assignsubjects'] = $assignsubjects = $this->M_core_model->get_record("assignsubjects", $get);
		$this->view_data['links'] = $this->pagination->create_links(); 
	}
	
	public function ajax_get_subjects($employee_id = false, $page = 0)
	{
		$this->disable_menus = true;
		$this->disable_views = true;
		
		$this->view_data = $_POST;
		
		$this->view_data['employee_id'] = $employee_id;
		
		$this->view_data['assignsubjects'] = $assignsubjects = $this->M_assignsubjects->get_employee_assignsubjects($employee_id);
		
		$this->view_data['subjects'] = $subjects = $this->M_subjects->current_batch_subject($this->open_semester->year_from, $this->open_semester->year_to, $this->open_semester->id);
		
		// SELECT 
			// subjects.sc_id, 
			// subjects.id,
			// subjects.subject,
			// subjects.units,
			// subjects.time,
			// subjects.day,
			// subjects.code,
			// subjects.room
		// FROM subjects 
		// WHERE subjects.year_from = '2012'
		// AND subjects.year_to = '2013'
		// AND subjects.semester_id = '2'
		
		//PAGINATION
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		$filter = false;
		$like = false;
		$order_by = false;
		
		$filter['subjects.semester_id'] = $this->open_semester->id;
		$filter['subjects.year_from'] = $this->open_semester->year_from;
		$filter['subjects.year_to'] = $this->open_semester->year_to;
		
		$not_in = false;
		
		//EXCLUDE ADDED SUBJECTS
		if($assignsubjects){
			foreach($assignsubjects as $sub){
				$not_in[] = $sub->subject_id;
			}
		}
		
		$get['not_in']['field'] = 'subjects.id';
		$get['not_in']['data'] = $not_in;
		
		$arr_filters = array();
		$suffix = "";
		
		if($_POST)
		{	
			if(isset($_POST['fields']) && $_POST['fields'] != "")
			{
				$f = $_POST['fields'];
				
				if(isset($_POST['keyword']) && $_POST['keyword'] != "")
				{
					$like[$f] = $_POST['keyword'];
				}
			}
		}
		
		if(!isset($page)){ $page = 0; }
		
		//CONFIGURATION
		$get['fields'] = array(
				'subjects.sc_id', 
				'subjects.id',
				'subjects.subject',
				'subjects.units',
				'subjects.time',
				'subjects.day',
				'subjects.code',
				'subjects.room'
		);
		
		$get['where'] = $filter;
		$get['like'] = $like;
		
		$get['order'] = "subjects.subject";
		$get['all'] = true; //GET ALL EXCLUDE LIMIT
		$get['count'] = true; //RETURN COUNT NOT ROW
		$get['array'] = false; //RETURN OBJECT NOT ARRAY
		$get['single'] = false; //RETURN ALL NOT SINGLE
		
	
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."employees/ajax_get_subjects/".$employee_id;
		$suffix = '?'.http_build_query($_GET, '', "&");
		$suffix = str_replace("&submit=Search", "", $suffix);
		$config['suffix'] = $suffix;
		$config['first_url'] = $config['base_url'].$config['suffix']; 
		
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_core_model->get_record("subjects", $get);
		
		$config["per_page"] = 15;
		$config['num_links'] = 5;
		$config["uri_segment"] = 4;
		// $config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		
		//FOR PAGINATION
		$get['all'] = false;
		$get['count'] = false;
		if($this->input->post('submit') == "Print")
		{
			$get['all'] = true;
		}
		$config['start'] = $page;
		$config['limit'] = $config['per_page'];
		
		$get['start'] = $page;
		$get['limit'] = $config['per_page'];
	
		$this->view_data['subjects'] = $search = $this->M_core_model->get_record("subjects", $get);
		$this->view_data['links'] = $this->pagination->create_links(); 
		
		echo $this->load->view('employees/ajax_get_subjects', $this->view_data, true);
	}
	
	public function ajax_select_subject()
	{
		$this->disable_menus = true;
		$this->disable_views = true;
		
		$employee_id = $this->input->post('employee_id');
		$subject_id = $this->input->post('subject_id');
		
		$ret['status'] = 0;
		
		if($employee_id && $subject_id) 
		{
			$subject = $this->M_subjects->get($subject_id);
			if($subject)
			{
				//CHECK IF ALREADY ADDED
				$ad_sub = $this->M_assignsubjects->get_subject_by_subject_id($employee_id, $subject_id);
				
				if(!$ad_sub)
				{
					unset($data);
					$data['employee_id'] = $employee_id;
					$data['subject_id'] = $subject_id;
					
					$rs = $this->M_assignsubjects->create_assignsubjects($data);
					
					if($rs['status'])
					{
						$ret['status'] = 1;
						$id = $rs['id'];
						
						$ret['row'] = "
							<tr>
								 <td>$subject->sc_id</td>
								 <td>$subject->code</td>
								 <td>$subject->subject</td>
								 <td>$subject->time</td>
								 <td>$subject->day</td>
								 <td>$subject->room</td>
								  <td>
									<a class='confirm btn btn-danger btn-sm' href='".base_url('employees/delete_subject/'.$employee_id.'/'.$subject->id)."' title='Delete ".$subject->subject."?' ><span class='glyphicon glyphicon-trash' ></span></a>
								 </td>
							</tr>
						";
						
						activity_log('Add Employee Subject', $this->userlogin,' Employee ID : '.$employee_id.' Subject ID : '.$subject_id);
					}
				}
				else
				{
					$ret['status'] = 2; //ADDED ALREADY
				}
			}
		}
		
		echo json_encode($ret);
	}
	
	public function delete_subject($employee_id = false, $id = false)
	{
		if(!$id) { show_404(); }
		if(!$employee_id) { show_404(); }
		
		$rs = $this->M_assignsubjects->get($id);
		
		if($rs)
		{
			$subject = $this->M_subjects->get($rs->subject_id);
			
			$rs_del = $this->M_assignsubjects->delete_record($id);
			
			if($rs_del['status'])
			{
				activity_log('Delete Employee Assign Subject', $this->userlogin, 'Assignsubjects ID : '.$id.' Subject ID : '.$rs->subject_id);
				$this->session->set_flashdata('system_message', '<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span>&nbsp; Successfully delete assigned subject.</div>');
				redirect('employees/add_assignsubject/'.$employee_id);
			}
			else
			{
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp; Record failed to delete.</div>');
				redirect('employees/add_assignsubject/'.$employee_id);
			}
		}
	}
	
	// Assign Course to Employee
	public function add_assign_course($employee_id = false, $page = 0)
	{
		if(!$employee_id) { show_404(); }
		$this->load->helper('my_dropdown');
		$this->load->model(array('M_subjects','M_employees','M_assign_courses','M_courses'));
		$this->view_data = $this->M_employees->get_employee_profile($employee_id);
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		$this->view_data['courses'] = $this->M_courses->get('',array('course','id'));	
		$this->view_data['assign_courses'] = $this->M_assign_courses->get_employee_assigned_courses($employee_id);

		$this->view_data["employee_id"] = $employee_id;
		$this->view_data["id"] = $employee_id;
		
		// SELECT 
			// assign_courses.id, 
			// assign_courses.course_id, 
			// assign_courses.employee_id, 
			// courses.course AS course_name
	          // FROM assign_courses
	          // LEFT JOIN courses on courses.id = assign_courses.course_id
	          // WHERE assign_courses.employee_id = '256'
		
		$filter = false;
		$like = false;
		$order_by = false;
		
		$filter['assign_courses.employee_id'] = $employee_id;
		
		$arr_filters = array();
		if($_POST)
		{	
			if(isset($_POST['fields']) && $_POST['fields'] != "")
			{
				$f = $_POST['fields'];
				
				if(isset($_POST['keyword']) && $_POST['keyword'] != "")
				{
					$like[$f] = $_POST['keyword'];
				}
			}
		}
		
		//CONFIGURATION
		$get['fields'] = array(
				'assign_courses.id', 
				'assign_courses.course_id', 
				'assign_courses.employee_id', 
				'courses.course'
		);
		
		$get['where'] = $filter;
		$get['like'] = $like;
		$get['join'] = array(
			
			1 => array(
				"table" => "courses",
				"on"	=> "courses.id = assign_courses.course_id",
				"type"  => "LEFT"
			)
		);
		
		$get['order'] = "courses.course";
		$get['all'] = true; //GET ALL EXCLUDE LIMIT
		$get['count'] = true; //RETURN COUNT NOT ROW
		$get['array'] = false; //RETURN OBJECT NOT ARRAY
		$get['single'] = false; //RETURN ALL NOT SINGLE
		
	
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."employees/add_assign_course/".$employee_id;
		$suffix = '?'.http_build_query($_GET, '', "&");
		$suffix = str_replace("&submit=Search", "", $suffix);
		$config['suffix'] = $suffix;
		$config['first_url'] = $config['base_url'].$config['suffix']; 
		
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_core_model->get_record("assign_courses", $get);
		
		$config["per_page"] = 15;
		$config['num_links'] = 10;
		$config["uri_segment"] = 4;
		// $config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		
		//FOR PAGINATION
		$get['all'] = false;
		$get['count'] = false;
		if($this->input->post('submit') == "Print")
		{
			$get['all'] = true;
		}
		$config['start'] = $page;
		$config['limit'] = $config['per_page'];
		
		$get['start'] = $page;
		$get['limit'] = $config['per_page'];
	
		$this->view_data['assign_courses'] = $assign_courses = $this->M_core_model->get_record("assign_courses", $get);
		$this->view_data['links'] = $this->pagination->create_links(); 
		
		if ($this->input->post())
		{
			$this->M_assign_courses->insert_to_db($this->input->post());
			$this->session->set_flashdata('system_message', '<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span>&nbsp; Successfully assigned course.</div>');
			redirect(current_url());
		}
	}
	
	public function delete_assign_course($id = false, $employee_id = false)
	{
		if(!$id || !$employee_id){ show_404(); }
		
		$this->load->model(array('M_subjects','M_employees','M_assign_courses','M_courses'));
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		$rs = $this->M_assign_courses->get($id);
		
		if($rs)
		{
			$rs_del = $this->M_assign_courses->delete_from_db($id);
			
			if($rs_del['status'])
			{
				activity_log('Delete Employee Assign Course', $this->userlogin, 'Assign course ID : '.$id.' Course ID : '.$rs->course_id);
				$this->session->set_flashdata('system_message', '<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span>&nbsp; Successfully delete assigned course.</div>');
				redirect('employees/add_assign_course/'.$employee_id);
			}
			else
			{
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp; Record failed to delete.</div>');
				redirect('employees/add_assign_course/'.$employee_id);
			}
		}
	}
}
