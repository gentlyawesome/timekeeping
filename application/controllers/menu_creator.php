<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_creator extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('M_menus','M_departments','M_users'));
	}

	public function index()
	{
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		$this->layout_view = 'menu_creator/index';
		
		$this->view_data['departments'] = $department = $this->M_menus->get_menus_group_by_department();
		
		$user_menus = false;
		
		if($department){
			$headers = false;
			foreach($department as $obj){ //LOOP DEPARTMENT
				$header_menu = $this->M_menus->get_header_menus_by_department($obj->department);
				if($header_menu){
					foreach($header_menu as $head){ //LOOP MENU HEADER : LEVEL 1
						
						$headers[$obj->department][] = $head;
						
						$sub_menu = $this->M_menus->get_sub_menus_by_menu_sub($obj->department,$head->menu_sub);
						// vp($sub_menu);
						if($sub_menu){
							foreach($sub_menu as $key => $xmenus){ // LOOB SUB MENU : LEVEL 2
								$user_menus[$obj->department][$head->menu_sub][] = $xmenus;
							}
						}
					}
				}
			}
			$this->view_data['headers'] = $headers;
			
		}
		
		$this->view_data['user_menus'] = $user_menus;
		
		// vp($this->session->userdata);
	}
	
	public function create_menu_by_html(){
		
		//I USED THIS TO SAVE USER MENUS FROM LIST OF A TAG
		
		$this->layout_view = 'menu_creator/create_menu_by_html';
	}
	
	public function create()
	{
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		$this->view_data['departments'] = $dep = $this->M_departments->get_all_department_for_welcome_screen(1);
		$this->layout_view = 'menu_creator/create';
		
		if($_POST){
			$this->load->model(array('M_menus'));
			
			
			$department = $this->input->post('department');
				
			if(isset($department) && count($department) > 0){
				
				foreach($department as $dep)
				{
					$data = $this->input->post('menu');
					$data['department'] = $dep;
			
					$rs = $this->M_menus->create_menus($data);
			
					if($rs['status']){
						
					}
				}
				
				$this->session->set_flashdata('system_message', '<div class="alert alert-success">Menus successfully added.</div>');
				redirect(menu_creator);
			}else{
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger">No department selected.</div>');
				redirect(menu_creator);
			}
		}
	}
}
