<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
  public function __construct()
	{
		parent::__construct();
		$this->session_checker->check_if_alive();
	}
	
	public function check_employee_duplicate(){
		$this->load->model(array('M_employees','M_users'));
		$employeeid = $this->input->post('employeeid');
		$id = $this->input->post('id');
		$par = $this->input->post('par');
		
		// $this->dump($employeeid);
		// $this->dump($id);
		// $this->dump($par);
		
		$param['employeeid'] = $employeeid;
		$param2['login'] = $employeeid;
		
		if($par == "edit")
		{
			$enrollment = $this->M_employees->get_employee($id);
			if($enrollment)
			{
				$param['employeeid <> '] = $enrollment->employeeid;
				$param2['login <> '] = $enrollment->employeeid;
			}
		}
		//CHECK IF DUPLICATE
		$data['isduplicate'] = FALSE;
		
		$rs = $this->M_employees->get_enrollment_by($param, true);
		if($rs){
			$data['isduplicate'] = true;
			echo json_encode($data);
			
		}
		$rs = $this->M_users->get_users_by($param2, true);
		if($rs){
			$data['isduplicate'] = true;
			echo json_encode($data);
			
		}
		echo json_encode($data);
	}
	
	public function add_subject_ajax()
	{
		$this->load->model(array('M_student_subjects', 'M_subjects', 'M_enrollments'));
		$data['enrollmentid'] = $eid = $this->input->post('eid');
		$data['subject_id'] = $subject_id = $this->input->post('subject_id');
		$data['year_id'] = $this->input->post('year_id');
		$data['semester_id'] = $this->input->post('semester_id');
		$data['course_id'] = $this->input->post('course_id');
		
		$rs = $this->M_student_subjects->add_ajax($data);
		
		$ret = array();
		
		if($rs['status']){
			
			$ret['subject_id'] = $subject_id;
			$ret['x'] = '<html>';
			
			if ($this->M_enrollments->check_if_paid($eid)) {
			  $this->M_subjects->recalculate_subject_load($subject_id, 'remove');
			}
		}
		
		echo json_encode($ret);
		
    // $this->session->set_flashdata('system_message', '<div class="alert alert-success">Successfully added student subject.</div>');
		//redirect("/subjects/add_subject/$y/$c/$s/$eid");
	}
	
	public function search_users($page = 0){
		
		$this->load->model(array('M_users'));
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		$filter = false;
		
		if($_POST){
			
			$login = $this->input->post('borrower_login');
			$name = $this->input->post('borrower_name');
			if(trim($login) != ""){
				$filter['users.login LIKE '] = "%".$login."%";
			}
			if(trim($name) != ""){
				$filter['users.name LIKE '] = "%".$name."%";
			}
			
			$page = 0;
		}
		
		$this->load->library("pagination");
		 $config['full_tag_open'] = '<ul class="pagination">';
		 $config['full_tag_close'] = '</ul>';
		 $config['prev_link'] = '&lt; Prev';
		 $config['prev_tag_open'] = '<li>';
		 $config['prev_tag_close'] = '</li>';
		 $config['next_link'] = 'Next &gt;';
		 $config['next_tag_open'] = '<li>';
		 $config['next_tag_close'] = '</li>';
		 $config['cur_tag_open'] = '<li class="active"><a href="#">';
		 $config['cur_tag_close'] = '</a></li>';
		 $config['num_tag_open'] = '<li>';
		 $config['num_tag_close'] = '</li>';
		 $config['first_link'] = FALSE;
		 $config['last_link'] = FALSE;
		
		$config["base_url"] = base_url() ."books/create_borrower";
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_users->find(0,0,$filter, true, true);
		$config["per_page"] = 30;
		$config['num_links'] = 5;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$this->view_data['users'] =  $users = $this->M_users->find($page, $config["per_page"], $filter);
		$this->view_data['links'] = $this->pagination->create_links();
		$this->view_data['count'] = count($users);
		
		echo json_encode($this->view_data);
	}
	
	public function search_items($page = 0){
		
		$this->load->model(array('M_items'));
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		$filter = false;
		
		if($_POST){
			
			$field = $this->input->post('fields');
			$keyword = $this->input->post('keyword');
			if(trim($keyword) != ""){
				$filter[$field.' LIKE '] = "%".$keyword."%";
			}
			$page = 0;
		}
		
		$this->load->library("pagination");
		 $config['full_tag_open'] = '<ul class="pagination">';
		 $config['full_tag_close'] = '</ul>';
		 $config['prev_link'] = '&lt; Prev';
		 $config['prev_tag_open'] = '<li>';
		 $config['prev_tag_close'] = '</li>';
		 $config['next_link'] = 'Next &gt;';
		 $config['next_tag_open'] = '<li>';
		 $config['next_tag_close'] = '</li>';
		 $config['cur_tag_open'] = '<li class="active"><a href="#">';
		 $config['cur_tag_close'] = '</a></li>';
		 $config['num_tag_open'] = '<li>';
		 $config['num_tag_close'] = '</li>';
		 $config['first_link'] = FALSE;
		 $config['last_link'] = FALSE;
		
		$config["base_url"] = base_url() ."borrow_items/create";
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_items->find(0,0,$filter, true, true);
		$config["per_page"] = 30;
		$config['num_links'] = 5;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$this->view_data['items'] =  $items = $this->M_items->find($page, $config["per_page"], $filter);
		$this->view_data['links'] = $this->pagination->create_links();
		$this->view_data['count'] = count($items);
		
		echo json_encode($this->view_data);
	}
	
	public function search_students($page = 0, $semester_id='', $year_from = '', $year_to = ''){
		
		$this->load->model(array('M_enrollments'));
		
		$filter = false;
		
		if($_POST){
			
			$login = $this->input->post('studid');
			$name = $this->input->post('name');
			if(trim($login) != ""){
				$filter['enrollments.studid LIKE '] = "%".$login."%";
			}
			if(trim($name) != ""){
				$filter['enrollments.name LIKE '] = "%".$name."%";
			}
			
			$filter['enrollments.semester_id'] = $semester_id;
			$filter['enrollments.sy_from'] = $year_from;
			$filter['enrollments.sy_to'] = $year_to;
			$filter['enrollments.is_deleted'] = 0;
			
			$page = 0;
		}
		
		$this->load->library("pagination");
		 $config['full_tag_open'] = '<ul class="pagination">';
		 $config['full_tag_close'] = '</ul>';
		 $config['prev_link'] = '&lt; Prev';
		 $config['prev_tag_open'] = '<li>';
		 $config['prev_tag_close'] = '</li>';
		 $config['next_link'] = 'Next &gt;';
		 $config['next_tag_open'] = '<li>';
		 $config['next_tag_close'] = '</li>';
		 $config['cur_tag_open'] = '<li class="active"><a href="#">';
		 $config['cur_tag_close'] = '</a></li>';
		 $config['num_tag_open'] = '<li>';
		 $config['num_tag_close'] = '</li>';
		 $config['first_link'] = FALSE;
		 $config['last_link'] = FALSE;
		
		$config["base_url"] = base_url() ."books/create_borrower";
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_enrollments->find(0,0,$filter, true, true);
		$config["per_page"] = 30;
		$config['num_links'] = 5;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$this->view_data['users'] =  $users = $this->M_enrollments->find($page, $config["per_page"], $filter);
		$this->view_data['links'] = $this->pagination->create_links();
		$this->view_data['count'] = count($users);
		
		echo json_encode($this->view_data);
	}
	
	public function search_students_for_grade_slip($page = 0, $year_from = '', $year_to = ''){
		
		$this->load->model(array('M_enrollments'));
		
		$filter = false;
		
		if($_POST){
			
			$field = $this->input->post('fields');
			$keyword = $this->input->post('keyword');
			
			$year_id = $this->input->post('year_id');
			$semester_id = $this->input->post('semester_id');
			$course_id = $this->input->post('course_id');
			
			if(trim($keyword) != ""){
				$filter[$field.' LIKE '] = "%".$keyword."%";
			}
			
			if(trim($year_id) != ""){
				$filter['enrollments.year_id'] = $year_id;
			}
			if(trim($semester_id) != ""){
				$filter['enrollments.semester_id'] = $semester_id;
			}
			if(trim($course_id) != ""){
				$filter['enrollments.course_id'] = $course_id;
			}
			
			$filter['enrollments.sy_from'] = $year_from;
			$filter['enrollments.sy_to'] = $year_to;
			$filter['enrollments.is_deleted'] = 0;
			$filter['enrollments.is_paid'] = 1;
		}
		
		$this->load->library("pagination");
		 $config['full_tag_open'] = '<ul class="pagination">';
		 $config['full_tag_close'] = '</ul>';
		 $config['prev_link'] = '&lt; Prev';
		 $config['prev_tag_open'] = '<li>';
		 $config['prev_tag_close'] = '</li>';
		 $config['next_link'] = 'Next &gt;';
		 $config['next_tag_open'] = '<li>';
		 $config['next_tag_close'] = '</li>';
		 $config['cur_tag_open'] = '<li class="active"><a href="#">';
		 $config['cur_tag_close'] = '</a></li>';
		 $config['num_tag_open'] = '<li>';
		 $config['num_tag_close'] = '</li>';
		 $config['first_link'] = FALSE;
		 $config['last_link'] = FALSE;
		
		$config["base_url"] = base_url() ."ajax/search_students_for_grade_slip";
		$this->view_data['total_rows'] = $config["total_rows"] = $this->M_enrollments->find(0,0,$filter, true, true);
		$config["per_page"] = 30;
		$config['num_links'] = 5;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$this->view_data['users'] =  $users = $this->M_enrollments->find($page, $config["per_page"], $filter);
		$this->view_data['links'] = $this->pagination->create_links();
		$this->view_data['count'] = count($users);
		
		echo json_encode($this->view_data);
	}
	
	public function check_item()
	{
		$this->load->model('M_items');
		
		$id = $this->input->post('id');
		$unit = $this->input->post('unit');
		
		$item = $this->M_items->get($id);
		
		if((float)$unit > (float)$item->unit_left)
		{
			$data['validate'] = false;
			$data['msg'] = 'There are only '. $item->unit_left .' unit/s left. Please change the quantity. ';
		}
		else
		{
			$data['validate'] = true;
			$data['msg'] = '';
		}
		
		echo json_encode($data);
	}
	
	public function save_menu()
	{
		$this->load->model('M_menus');
		$data['department'] = $this->input->post('department');
		$data['controller'] = $this->input->post('controller');
		$data['caption'] = 	$this->input->post('caption');
		$data['menu_lvl'] = $this->input->post('menu_lvl');
		$data['menu_grp'] = $this->input->post('menu_grp');
		$data['menu_sub'] = $this->input->post('menu_sub');
		$data['menu_num'] = $this->input->post('menu_num');
		
		$rs = $this->M_menus->create_menus($data);
		
		// vp($rs);
	}
}
