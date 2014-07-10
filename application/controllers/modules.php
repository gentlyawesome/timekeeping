<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modules extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('form_validation'));
		$this->load->helper(array('url','form','my_dropdown'));

		$this->load->model('M_module','m_m');
	}

	public function create()
	{
		$this->session_checker->secure_page('admin');

		if($this->input->post('save')){

			if($this->form_validation->run('modules') === FALSE)
			{

			}
			else
			{
				$data = $this->input->post('module');
				// vd($data);
				$result = (object)$this->m_m->insert($data);

				if($result->status){
					$this->_msg('s','Your module was successfully save.','modules/create');
				}else{
					$this->_msg('e','Your module was not save. Please try again','modules/create');
				}
			}
		}
		
	}

	public function edit($module_id = false)
	{
		$this->session_checker->secure_page('admin');

		$this->view_data['module_data'] = $c = $this->m_m->get($module_id);

		if($c)
		{
			if($this->input->post('save')){

				if($this->form_validation->run('modules') === FALSE)
				{

				}
				else
				{
					$data = $this->input->post('module');
					// vd($data);
					$result = (object)$this->m_m->update($module_id,$data);

					if($result){
						$this->_msg('s','Your module was updated successfully.','modules/edit/'.$module_id);
					}else{
						$this->_msg('e','Your module was not save. Please try again','modules/edit/'.$module_id);
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

		$this->view_data['project_data'] = $c = $this->m_m->get($project_id);

		if($c)
		{
			$result = $this->m_m->delete($project_id);		

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

		if($_GET)
		{
			if(isset($_GET['module']) && trim($_GET['module']) != ''){
				$this->view_data['module'] = $module = trim($_GET['module']);
				$like['module'] = $module;
			}
		}
		
		$get['where'] = $filter;
		$get['like'] = $like;
		
		$get['order'] = "module";
		$get['all'] = true; //GET ALL EXCLUDE LIMIT
		$get['count'] = true; //RETURN COUNT NOT ROW
		$get['array'] = false; //RETURN OBJECT NOT ARRAY
		$get['single'] = false; //RETURN ALL NOT SINGLE
		
	
		$this->load->library("pagination");
		$config = $this->pagination_style();
		$config["base_url"] = base_url() ."modules/index";
		$suffix = '?'.http_build_query($_GET, '', "&");
		$suffix = str_replace("&submit=Search", "", $suffix);
		$config['suffix'] = $suffix;
		$config['first_url'] = $config['base_url'].$config['suffix']; 
		
		$this->view_data['total_rows'] = $config["total_rows"] = $this->m_m->get_record("modules", $get);
		
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
		$this->view_data['search'] = $search = $this->m_m->get_record("modules", $get);
		$this->view_data['links'] = $this->pagination->create_links();
		
		if($this->input->post('submit') == "Print")
		{
			$this->print_task_list($this->view_data);
		}
	}
}