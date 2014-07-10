<?php
/*
	SLY
	THIS IS LIBRARY FOR create read update & delete function
*/
class _Sylvercrud
{
	private $ci;
	private $view_data;
	private $title;
	private $_sql;
	private $_crud;
	private $_crud_extension;

	public $_table;
	public $_config;
	public $_html;

	//PAGER
	private $_per_page;
	private $_num_links;
	private $_uri_segment;
	private $_page;
	private $_order;
	private $_total_rows;
	private $_column_names;
	private $_hide_id;

	private $_system_message;
	private $_disable_system_message;
	private $_selected_id;
	private $_controller_method;


	
	public function __construct($config=false)
	{
		$this->ci =& get_instance();

		/*CONFIG PARAMETER MUST*/

		/*
		TYPE
			query = CRUD will depend on the given query
			custom = CRUD will depend on the custom config
		*/	


		if($config && is_array($config))
		{
			$this->load_config($config);


			if(isset($config['type']) && trim($config['type']) == "query" )
			{
				if(isset($_POST['save']) && $_POST['save'] == "Save" )
				{
					//SAVE THE FORM
					$this->save_create();
				}
				elseif(isset($_POST['update_save']) && $_POST['update_save'] == "Save" )
				{
					$this->save_edit();
				}
				else
				{
					if($this->ci->uri->segment($this->_uri_segment) == "create")
					{
						$this->create();
					}
					elseif($this->ci->uri->segment($this->_uri_segment) == "view")
					{
						$this->view();	
					}
					elseif($this->ci->uri->segment($this->_uri_segment) == "edit")
					{
						$this->edit();
					}
					elseif($this->ci->uri->segment($this->_uri_segment) == "delete")
					{
						$this->delete();
					}
					else
					{
						$this->load_query();
					}
				}
			}
			elseif (isset($config['type']) && trim($config['type']) == "custom" )
			{
				$this->load_custom();	
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	private function load_config($config)
	{

		$this->_config = $config = (object)$config;
		
		$this->_table = $this->view_data['table'] = isset($this->_config->table) ? $this->_config->table : '';
		$this->_crud = $this->view_data['crud'] = isset($this->_config->crud) ? $this->_config->crud : false;
		$this->_crud_extension = $this->view_data['crud_extension'] = isset($this->_config->crud_extension) ? $this->_config->crud_extension : false;
		$this->title = $this->view_data['title'] = isset($this->_config->title) ? $this->_config->title : '';
		
		$this->_sql = isset($this->_config->sql) ? $this->_config->sql : '';
		$this->_per_page = isset($this->_config->pager['per_page']) ? $this->_config->pager['per_page'] : 25;
		$this->_num_links = isset($this->_config->pager['num_links']) ? $this->_config->pager['num_links'] : 10;
		$this->_uri_segment = isset($this->_config->pager['uri_segment']) ? $this->_config->pager['uri_segment'] : 3;
		$this->_order = isset($this->_config->order) ? $this->_config->order : '';
		$this->_hide_id = $this->view_data['hide_id'] = isset($this->_config->hide_id) ? $this->_config->hide_id : true;

		$this->_page = $this->ci->uri->segment($this->_uri_segment) ? (intval($this->ci->uri->segment($this->_uri_segment)) ? $this->ci->uri->segment($this->_uri_segment) : 0) : 0 ;

		$this->_controller_method = $this->view_data['controller_method'] = $this->ci->router->class.'/'.$this->ci->router->method;

		$this->_disable_system_message = $this->view_data['disable_system_message'] = isset($this->_config->disable_system_message)?$this->_config->disable_system_message:false;
		$this->view_data['disable_title'] = isset($this->_config->disable_title)?$this->_config->disable_title:false;
		$this->_system_message = $this->view_data['system_message'] = $this->ci->session->flashdata('system_message');

		$this->ci->load->model('M_core_model','m');
		$this->ci->m->set_table($this->_table);

		//SET SELECTED ID
		if($this->ci->uri->segment($this->_uri_segment) 
			&& $this->ci->uri->segment($this->_uri_segment+1)
			&& intval($this->ci->uri->segment($this->_uri_segment+1)) )
		{
			$this->_selected_id = $this->ci->uri->segment($this->_uri_segment+1);
		}else
		{
			$this->_selected_id = false;
		}
	}

	private function load_query()
	{
		$query = $this->ci->db->query($this->get_sql_query());
		$query_fields = $query->list_fields();

		//SEARCH TRUE/FALSE
		$this->view_data['search'] = $this->_config->search;

		unset($config);
		$this->ci->load->library("pagination");
		//$config = $this->pagination_style();
		$config["base_url"] = site_url() .$this->ci->router->class."/".$this->ci->router->method;
		$suffix = '?'.http_build_query($_GET, '', "&");
		$suffix = str_replace("&submit=Search", "", $suffix);
		$config['suffix'] = $suffix;
		$config['first_url'] = $config['base_url'].$config['suffix']; 

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

		$this->view_data['total_rows'] = $config["total_rows"] = $this->get_total_rows();
		
		// $config['use_page_numbers'] = TRUE;
		$this->ci->pagination->initialize($config);
		
		$config['start'] = $this->_page;
		$config['limit'] = $this->_per_page;
		$config['num_links'] = $this->_num_links;
		
		$this->view_data['result'] = $result = $query->num_rows() > 0 ? $query->result() : false;
		$this->view_data['links'] = $this->ci->pagination->create_links();

		//CHECK IF THERE IS TABLE COLUMN ALIAS
		if(isset($this->_config->column_name) && is_array($this->_config->column_name) ) 
		{
			$this->view_data['column_name'] = $this->_column_names = $this->_config->column_name;
		}
		else
		{
			$this->view_data['column_name'] = $this->_column_names = $query_fields;
		}

		$this->view_data['filter_list'] = $this->get_filter_array_for_dd($result);

		$this->_html = $this->ci->load->view('_crud/index',$this->view_data, true); //RETURN HTML CODES
	}

	private function create()
	{
		$this->_html = $this->ci->load->view('_crud/create',$this->view_data, true); //RETURN HTML CODES
	}

	private function view()
	{
		$this->view_data['edit_record'] = $er = $this->ci->m->get($this->_selected_id);
		$this->view_data['view_only'] = true;
		
		if($er){
			$this->_html = $this->ci->load->view('_crud/view',$this->view_data, true); //RETURN HTML CODES
		}else{
			show_404();
		}
	}

	private function edit()
	{
		$this->view_data['edit_record'] = $er = $this->ci->m->get($this->_selected_id);
		
		if($er){
			$this->_html = $this->ci->load->view('_crud/edit',$this->view_data, true); //RETURN HTML CODES
		}else{
			show_404();
		}
	}

	private function delete()
	{
		$er = $this->ci->m->get($this->_selected_id);

		if($er)
		{
			$result = $this->ci->m->delete($this->_selected_id);
			
			if($result){
				$this->_msg('s','Record was successfully removed.',$this->_controller_method);
			}else
			{
				$this->_msg('e','Delete failed. Please try again',$this->_controller_method);
			}
		}
		else
		{
			show_404();
		}
	}

	private function get_sql_query($remove_limit = false)
	{
		$sql = $this->_config->sql;

		//GET VARIABLES FOR FILTER SEARCH
		if($this->_config->search){
			//WHERE QUERY IF THERE IS A WHERE STATEMENT
			$has_where = strpos(strtolower($sql), 'where') ? true : false;

			if(
				isset($_GET['keyword']) 
				&& trim($_GET['keyword']) != ""
				&& isset($_GET['filter_by']) 
				&& trim($_GET['filter_by']) != ""
			){
				$fb = $_GET['filter_by'];
				$kw = $this->ci->db->escape('%'.trim($_GET['keyword'].'%'));
				if($has_where){
					$sql .= " AND $fb LIKE $kw";
				}else{
					$sql .= " WHERE $fb LIKE $kw";
				}

				$this->view_data['filter_by'] = $_GET['filter_by'];
				$this->view_data['keyword'] = $_GET['keyword'];
			}
		}

		if($this->_order != "")
		{
			$sql .= " ORDER BY " . $this->_order;
		}

		if($remove_limit == false)
		{
			$sql .= " LIMIT  $this->_page , $this->_per_page";
		}
		
		return $sql;
	}

	private function get_total_rows()
	{
		$query = $this->ci->db->query($this->get_sql_query(true));
		$ret = $query->num_rows();
		$this->_total_rows = $ret;
		return $ret;
	}

	private function get_column_name($data)
	{
		// vd($data);
		return $data->list_fields();
	}

	private function get_filter_array_for_dd($result)
	{
		$ret = array();

		if(isset($this->_config->column_name) && is_array($this->_config->column_name) ) 
		{
			if($this->_config->search)
			{
				$c = $this->_config->column_name;
				foreach ($this->_config->column_name as $key => $name) {

					if($key=="id" && $this->_hide_id == true)
					{
						continue;
					}

					if(isset($c[$key]))
					{
						$x = $c[$key];
						$ret[$x] = $name;
					}
				}
			}
		}
		else
		{
			if($this->_config->search)
			{
				$c = $this->_column_names;
				foreach ($c as $key => $name) 
				{
					if($key=="id" && $this->_hide_id == true)
					{
						continue;
					}
					$ret[$name] = ucwords($name);
				}
			}
		}

		return $ret;
	}

	/*SAVING OF DATA*/
	private function save_create()
	{
		$post = $this->ci->input->post();
		if($post)
		{
			//LOAD LIBRARY
			$this->ci->load->library('form_validation');

			unset($input);

			//SET RULES
			$has_rules = 0;
			$this->ci->form_validation->set_error_delimiters('<div class="alert alert-xs alert-danger">', '</div>'); 
			foreach ($this->_crud as $key => $value) {
				$value = (object)$value;
				if(isset($value->rules)){
					$this->ci->form_validation->set_rules($value->field, $value->label,$value->rules);		
					$has_rules++;
				}

				$attr = (object)$value->attr;				
				if( isset($_POST[$attr->name]) && trim($this->ci->input->post($attr->name)) )
				{
					switch (strtolower($value->type)) {
						case 'text':
						case 'select':
							$input[$value->field] = trim($this->ci->input->post($attr->name));
							break;
						
						default:
							# code...
							break;
					}
				}
			}

			//PUSH CRUD EXTENSION BEFORE ADDING
			
			if($this->_crud_extension){
				foreach ($this->_crud_extension as $key => $value) {
					$input[$key] = $value;
				}
			}
			
			if($this->ci->form_validation->run())
			{
				$this->ci->m->set_table($this->_table);
				$result = (object)$this->ci->m->insert($input);
				if($result->status)
				{
					$this->_msg('s','Data was successfully saved.',current_url());
				}
				else
				{
					$this->_msg('e','Saving Failed. Please try again.',current_url());
				}
			}
			else
			{
				$this->create();
			}
		}
		else
		{
			show_404();
		}
	}
	private function save_edit()
	{
		if($this->_selected_id)
		{
			$data_record = $this->ci->m->get($this->_selected_id);

			if($data_record)
			{
				$post = $this->ci->input->post();
				if($post)
				{
					//LOAD LIBRARY
					$this->ci->load->library('form_validation');

					unset($input);

					//SET RULES
					$has_rules = 0;
					$this->ci->form_validation->set_error_delimiters('<div class="alert alert-xs alert-danger">', '</div>'); 
					foreach ($this->_crud as $key => $value) {
						$value = (object)$value;
						if(isset($value->rules)){
							
							if(strpos($value->rules, "is_unique")){
								$xname = $value->attr['name'];
								$xcheck = $data_record->$xname;
								$value->rules = str_replace("]", ".$xcheck]", $value->rules);
							}
							
							$this->ci->form_validation->set_rules($value->field, $value->label,$value->rules);		
							$has_rules++;
						}

						$attr = (object)$value->attr;				
						if( isset($_POST[$attr->name]) && trim($this->ci->input->post($attr->name)) )
						{
							switch (strtolower($value->type)) {
								case 'text':
								case 'select':
								case 'date':
									$input[$value->field] = trim($this->ci->input->post($attr->name));
									break;
								
								default:
									# code...
									break;
							}
						}
					}
					
					if($this->ci->form_validation->run())
					{
						$this->ci->m->set_table($this->_table);
						$result = $this->ci->m->update($this->_selected_id,$input);
						if($result)
						{
							$this->_msg('s','Data was successfully updated.',current_url());	
						}
						else
						{
							$this->_msg('e','Saving Failed. Please try again.',current_url());	
						}
					}
					else
					{
						$this->edit();
					}
				}
				else
				{
					$this->_msg('e','Saving Failed. Please try again.',current_url());	
				}
			}
			else
			{
				$this->_msg('e','Saving Failed. Please try again.',current_url());	
			}
		}
		else
		{
			show_404();
		}
	}
	/*End of saving data*/

	/*Form Validation of Unique while edit*/
	public function username_check($str)
	{
		$this->form_validation->set_message('username_check', 'The %s field can not be the word "test"');
		if ($str == 'test')
		{
			
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	public function _msg($type = FALSE,$message = FALSE,$redirect = FALSE,$var_name = 'system_message')
	{
		$template = "";
		$type = strtolower(trim($type));
		switch($type)
		{
		 	case $type == 'e':
				$template = "<div class='alert alert-danger'><i class='fa fa-exclamation'></i>&nbsp; ".$message."</div>";
				
			break;
			case $type == 's':
				$template = "<div class='alert alert-success'><i class='fa fa-check'></i>&nbsp; ".$message."</div>";
			break;
			case $type == 'n':
				$template = "<div class='alert alert-info'><i class='fa fa-check'></i>&nbsp; ".$message."</div>";
			break;
			case $type == 'p':
				$template = $message;
			break;
			case $type === FALSE;
				$template = $message;
			break;
		}

		if($type AND $message AND $redirect)
		{
			$this->ci->session->set_flashdata($var_name,$template);	
			redirect($redirect);
		}elseif($type AND $message AND $redirect == FALSE){
			return $template;
		}
		
		if($redirect == FALSE AND $message == FALSE AND $redirect == FALSE)
		{
			return $this->ci->session->flashdata($var_name);
		}
	}
}

?>