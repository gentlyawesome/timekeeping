<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('form_validation'));
		$this->load->helper(array('url','form','my_dropdown'));
	}

	public function index(){

	}

	public function add_daily_task()
	{
		$this->session_checker->secure_page('user');

		//LOAD MODELS
		$this->load->model('M_client','m_c');
		$this->load->model('M_project','m_p');
		$this->load->model('M_module','m_m');
		$this->load->model('M_monitoring','m_mon');

		$this->view_data['client_list'] = $cl = $this->m_c->get_for_dd(array('id','code','name'), array('is_active'=>1),'Select');
		$this->view_data['project_list'] = $pl = $this->m_p->get_for_dd(array('id','code','name'), array('is_active'=>1),'Select');
		$this->view_data['module_list'] = $ml = $this->m_m->get_for_dd(array('id','module'), false, 'Select');

		if($this->input->post('save_task')){

			if($this->form_validation->run('monitoring') === FALSE)
			{

			}
			else
			{
				$data = $this->input->post('monitoring');
				$data['userid'] = $this->user->id;
				$data['empid'] = $this->user->login;
				
				$result = (object)$this->m_mon->insert($data);

				if($result->status){
					$this->_msg('s','Your task was successfully save.','task/add_daily_task');
				}else{
					$this->_msg('e','Your task was not save. Please try again','task/add_daily_task');
				}
			}
		}
		
	}

	public function view_task_list($page = 0)
	{
		//LOAD MODELS
		$this->load->model('M_client','m_c');
		$this->load->model('M_project','m_p');
		$this->load->model('M_module','m_m');
		$this->load->model('M_monitoring','m_mon');
		$this->load->model('M_users','m_u');

		$this->view_data['client_list'] = $cl = $this->m_c->get_for_dd(array('id','code','name'), array('is_active'=>1),'Select');
		$this->view_data['project_list'] = $pl = $this->m_p->get_for_dd(array('id','code','name'), array('is_active'=>1),'Select');
		$this->view_data['module_list'] = $ml = $this->m_m->get_for_dd(array('id','module'), false, 'Select');
		$this->view_data['user_list'] = $ul = $this->m_u->get_for_dd(array('id','login','name'), array('admin'=>0,'is_active'=>1), 'Select');

		//PAGINATION
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		$filter = false;
		$like = false;
		$order_by = false;
		
		if(!$this->is_admin){
			$filter['monitoring.userid'] = $this->userid;
		}
		
		if($_GET)
		{
			if($this->is_admin)
			{
				if(isset($_GET['users_id']) && trim($_GET['users_id']) != ''){
					$this->view_data['users_id'] = $users_id = trim($_GET['users_id']);
					$filter['monitoring.userid'] = $users_id;
				}
			}

			if(isset($_GET['date_from']) && trim($_GET['date_from']) != ''){
				$this->view_data['date_from'] = $date_from = trim($_GET['date_from']);
				$filter['DATE(monitoring.date) >='] = $date_from;
			}
			if(isset($_GET['date_to']) && trim($_GET['date_to']) != ''){
				$this->view_data['date_to'] = $date_to = trim($_GET['date_to']);
				$filter['DATE(monitoring.date) <='] = $date_to;
			}

			if(isset($_GET['client_id']) && trim($_GET['client_id']) != ''){
				$this->view_data['client_id'] = $client_id = trim($_GET['client_id']);
				$filter['monitoring.client_id'] = $client_id;
			}

			if(isset($_GET['project_id']) && trim($_GET['project_id']) != ''){
				$this->view_data['project_id'] = $project_id = trim($_GET['project_id']);
				$filter['monitoring.project_id'] = $project_id;
			}
		}
		
		//CONFIGURATION
		$get['fields'] = array(
				'monitoring.*',
				'project.code as project_code',
				'project.name as project_name',
				'client.code as client_code',
				'client.name as client_name',
				'modules.module',
				'users.name as emp_name'
		);
		
		$get['where'] = $filter;
		$get['like'] = $like;
		
		$get['join'] = array(
			
			1 => array(
				"table" => "project",
				"on"	=> "monitoring.project_id = project.id",
				"type"  => "LEFT"
			),
			2 => array(
				"table" => "client",
				"on"	=> "monitoring.client_id = client.id",
				"type"  => "LEFT"
			),
			3 => array(
				"table" => "modules",
				"on"	=> "monitoring.module_id = modules.id",
				"type"  => "LEFT"
			),
			4 => array(
				"table" => "users",
				"on"	=> "monitoring.userid = users.id",
				"type"  => "LEFT"
			)
		);
		$get['order'] = "monitoring.date DESC";
		$get['all'] = true; //GET ALL EXCLUDE LIMIT
		$get['count'] = true; //RETURN COUNT NOT ROW
		$get['array'] = false; //RETURN OBJECT NOT ARRAY
		$get['single'] = false; //RETURN ALL NOT SINGLE
		
	
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."task/view_task_list";
		$suffix = '?'.http_build_query($_GET, '', "&");
		$suffix = str_replace("&submit=Search", "", $suffix);
		$config['suffix'] = $suffix;
		$config['first_url'] = $config['base_url'].$config['suffix']; 
		
		$this->view_data['total_rows'] = $config["total_rows"] = $this->m_mon->get_record("monitoring", $get);
		
		$config["per_page"] = 30;
		$config['num_links'] = 10;
		$config["uri_segment"] = 3;
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		
		//FOR PAGINATION
		$config['start'] = $page;
		$config['limit'] = $config['per_page'];
		
		$get['start'] = $page;
		$get['limit'] = $config['per_page'];
		$get['all'] = false;
		$get['count'] = false;
		$this->view_data['search'] = $search = $this->m_mon->get_record("monitoring", $get);
		$this->view_data['links'] = $this->pagination->create_links();
		
		if($this->input->post('submit') == "Print")
		{
			$this->print_task_list($this->view_data);
		}
	}
}