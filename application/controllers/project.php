<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('form_validation'));
		$this->load->helper(array('url','form','my_dropdown'));

		$this->load->model('M_project','m_p');
	}

	public function create()
	{
		$this->session_checker->secure_page('admin');

		if($this->input->post('save')){

			if($this->form_validation->run('project') === FALSE)
			{

			}
			else
			{
				$data = $this->input->post('project');
				// vd($data);
				$result = (object)$this->m_p->insert($data);

				if($result->status){
					$this->_msg('s','Your project was successfully save.','project/create');
				}else{
					$this->_msg('e','Your project was not save. Please try again','project/create');
				}
			}
		}
		
	}

	public function edit($project_id = false)
	{
		$this->session_checker->secure_page('admin');

		$this->view_data['project_data'] = $c = $this->m_p->get($project_id);

		if($c)
		{
			if($this->input->post('save')){

				if($this->form_validation->run('project2') === FALSE)
				{

				}
				else
				{
					$data = $this->input->post('project');
					// vd($data);
					$result = (object)$this->m_p->update($project_id,$data);

					if($result){
						$this->_msg('s','Your project was updated successfully.','project/edit/'.$project_id);
					}else{
						$this->_msg('e','Your project was not save. Please try again','project/edit/'.$project_id);
					}
				}
			}
		}
		else
		{
			show_404();
		}
		
	}

	public function destroy($project_id = false)
	{
		$this->session_checker->secure_page('admin');

		$this->view_data['project_data'] = $c = $this->m_p->get($project_id);

		if($c)
		{
			$result = $this->m_p->delete($project_id);		

			if($result){
				$this->_msg('s','Your project was successfully deleted.','project');
			}else{
				$this->_msg('e','Your project was not save. Please try again','project');
			}
		}
		else
		{
			show_404();
		}
		
	}

	public function index($page = 0)
	{
		//PAGINATION
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		$filter = false;
		$like = false;
		$order_by = false;
		
		$this->view_data['is_active'] = 1;

		if($_GET)
		{
			if(isset($_GET['code']) && trim($_GET['code']) != ''){
				$this->view_data['code'] = $code = trim($_GET['code']);
				$like['code'] = $code;
			}

			if(isset($_GET['name']) && trim($_GET['name']) != ''){
				$this->view_data['name'] = $name = trim($_GET['name']);
				$like['name'] = $name;
			}

			if(isset($_GET['is_active'])){
				// vd($_GET['is_active']);
				$this->view_data['is_active'] = true;
				$filter['is_active'] = 1;
			}else{
				$this->view_data['is_active'] = false;
				$filter['is_active'] = 0;
			}
		}
		
		$get['where'] = $filter;
		$get['like'] = $like;
		
		$get['order'] = "code, name";
		$get['all'] = true; //GET ALL EXCLUDE LIMIT
		$get['count'] = true; //RETURN COUNT NOT ROW
		$get['array'] = false; //RETURN OBJECT NOT ARRAY
		$get['single'] = false; //RETURN ALL NOT SINGLE
		
	
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."project/index";
		$suffix = '?'.http_build_query($_GET, '', "&");
		$suffix = str_replace("&submit=Search", "", $suffix);
		$config['suffix'] = $suffix;
		$config['first_url'] = $config['base_url'].$config['suffix']; 
		
		$this->view_data['total_rows'] = $config["total_rows"] = $this->m_p->get_record("project", $get);
		
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
		$this->view_data['search'] = $search = $this->m_p->get_record("project", $get);
		$this->view_data['links'] = $this->pagination->create_links();
		
		if($this->input->post('submit') == "Print")
		{
			$this->print_task_list($this->view_data);
		}
	}
}