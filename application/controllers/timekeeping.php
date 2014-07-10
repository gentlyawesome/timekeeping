<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timekeeping extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('M_users','M_captcha'));
		$this->load->helper(array('url','form','my_dropdown'));
		$this->load->library(array('form_validation','login'));		

		#load models
		$this->load->model('M_employees');
		$this->load->model('M_users');
		$this->load->model('M_timekeeping');
	}

	public function view($empid = false){
		if($id === false){ show_404(); }
	}

	public function index()
	{
		$this->layout_view = 'welcome';	
		$this->view_data['employers'] = $this->M_employees->employees_for_tk();
		$this->view_data['system_message'] = $this->session->flashdata('system_message');

		if($this->input->post()){

			$empid = $this->view_data['empid'] = $this->input->post('empid', true);
			$password = $this->view_data['secreto'] = $this->input->post('secreto', true);

			#check null values
			if($empid == "" || $password == ""){
				$this->_msg('e','Please fill up all the fields.', current_url());
			}

			#validate password
			if(!$this->login->_validate_password($empid,$password)){
				$this->_msg('e','Wrong Password', current_url());
			}

			#check if time in already exist
			unset($get);
			$get['where']['DATE(date)'] = date('Y-m-d');
			$get['where']['empid'] = $empid;
			$get['where']['logtype'] = 'IN';
			$get['single'] = true;
			$ex_in = $this->M_timekeeping_file->get_record('timekeeping_file', $get);

			#Get Timekeeping Record
				unset($get);
				$get['where']['empid'] = $empid;
				$get['where']['DATE(date)'] = date('Y-m-d');
				$get['single'] = true;
				$tk = $this->M_timekeeping->get_record('timekeeping', $get);
				$tk_id = $tk ? $tk->id : false;

			#TIME IN
			if($this->input->post('btn_in') && $this->input->post('btn_in') == "TIME IN"){

				

				#if timekeeping record in null create it first
				if($tk === false){
					unset($data);
					$data['empid'] = $empid;
					$data['date'] = date('Y-m-d');
					$rs = (object)$this->M_timekeeping->insert($data);
					
					if($rs->status === false){
						$this->_msg('e','Something went wrong, please try again', current_url());
					}
					$tk_id = $rs->id;
				}else{
					$tk_id = $tk->id;
				}

				unset($data);
				$data['date'] = date('Y-m-d');
				$data['timekeeping_id'] = $tk_id;
				$data['logtype'] = 'IN';
				$data['empid'] = $empid;
				$data['time'] = date('H:i:s');
				$rs = (object)$this->M_timekeeping_file->insert($data);
				
				if($rs->status){
					$this->_msg('s','Your time-in was successfull', current_url());
				}else{
					$this->_msg('e','Failed. Please try again', current_url());
				}
			}

			#TIME OUT
			if($this->input->post('btn_out') && $this->input->post('btn_out') == "TIME OUT"){
				
				if($tk == false){
					$this->_msg('e','You cannot Time Out without a time in.', current_url());
				}

				if($ex_in == false){
					$this->_msg('e','You cannot Time Out without a time in.', current_url());
				}

				unset($data);
				$data['date'] = date('Y-m-d');
				$data['timekeeping_id'] = $tk_id;
				$data['logtype'] = 'OUT';
				$data['empid'] = $empid;
				$data['time'] = date('H:i:s');
				$rs = (object)$this->M_timekeeping_file->insert($data);
				if($rs->status){

					$this->_msg('s','Your time-out was successfull', current_url());
				}else{
					$this->_msg('e','Failed. Please try again', current_url());
				}
			}

			#VIEW RECORD
			if($this->input->post('btn_view') && $this->input->post('btn_view') == "VIEW"){
				
				unset($get);
				$get['where']['empid'] = $empid;
				$get['where']['DATE(date)'] = date('Y-m-d');
				$get['order'] = 'id';
				$this->view_data['view_record'] = $this->M_timekeeping_file->get_record(false, $get);
			}
		}
	}

	public function index_old()
	{
		$this->layout_view = 'welcome';	
		$this->view_data['employers'] = $this->M_employees->employees_for_tk();
		$this->view_data['system_message'] = $this->session->flashdata('system_message');

		if($this->input->post()){
			
			$empid = $this->view_data['empid'] = $this->input->post('empid', true);
			$password = $this->view_data['secreto'] = $this->input->post('secreto', true);

			#check null values
			if($empid == "" || $password == ""){
				$this->_msg('e','Please fill up all the fields.', current_url());
			}

			#validate password
			if(!$this->login->_validate_password($empid,$password)){
				$this->_msg('e','Wrong Password', current_url());
			}

			#check if time in already exist
			unset($get);
			$get['where']['DATE(date)'] = date('Y-m-d');
			$get['where']['empid'] = $empid;
			$get['where']['in <> '] = '';
			$get['where']['in IS NOT NULL'] = NULL;
			$get['where']['in <> '] = '00:00:00';
			$get['single'] = true;
			$ex_in = $this->M_timekeeping->get_record('timekeeping', $get);

			#check if time out already exist
			unset($get);
			$get['where']['DATE(date)'] = date('Y-m-d');
			$get['where']['empid'] = $empid;
			$get['where']['out <> '] = '';
			$get['where']['out IS NOT NULL'] = NULL;
			$get['where']['out <> '] = '00:00:00';
			$get['single'] = true;
			$ex_out = $this->M_timekeeping->get_record('timekeeping', $get);
			

			#TIME IN
			if($this->input->post('btn_in') && $this->input->post('btn_in') == "TIME IN"){
				
				if($ex_in){
					$this->_msg('e','Time In Already Exist.', current_url());
				}

				unset($data);
				$data['date'] = NOW;
				$data['empid'] = $empid;
				$data['in'] = date('H:i:s');
				$rs = (object)$this->M_timekeeping->insert($data);
				if($rs->status){
					$this->_msg('s','Your time-in was successfull', current_url());
				}else{
					$this->_msg('e','Failed. Please try again', current_url());
				}
			}

			#TIME OUT
			if($this->input->post('btn_out') && $this->input->post('btn_out') == "TIME OUT"){
				
				if($ex_in == false){
					$this->_msg('e','You cannot Time Out without a time in.', current_url());
				}

				if($ex_out){
					$this->_msg('e','Time Out Already Exist.', current_url());
				}

				unset($data);
				$data['out'] = date('H:i:s');
				$rs = (object)$this->M_timekeeping->timeout($ex_in->id, $data);
				if($rs){

					$this->_msg('s','Your time-out was successfull', current_url());
				}else{
					$this->_msg('e','Failed. Please try again', current_url());
				}
			}
		}
	}
}