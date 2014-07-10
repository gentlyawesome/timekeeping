<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Remarks extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session_checker->open_semester();
		$this->session_checker->secure_page(array('admin','finance'));
	}
	
	// Create
	public function create()
	{
		$this->load->model(array('M_remarks'));
		
		$this->view_data['year'] = FALSE;
		
		if($_POST)
		{
			$data = $this->input->post('remarks');
			$data['is_deduction'] = isset($data['is_deduction']) ? 1 : 0;
			$data['is_payment'] = isset($data['is_payment']) ? 1 : 0;
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');
			
			$result = $this->M_remarks->create_remarks($data);
			
			if($result['status'])
			{
				log_message('error','Remarks Created by: '.$this->user.'Success; Remarks Id: '.$id);
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger">Remark successfully added.</div>');
				redirect('remarks');
			}
		}
	}
	
	// Retrieve
	public function index()
	{
		$this->load->model(array('M_remarks'));
		$this->view_data['remarks'] = $this->M_remarks->find_all();
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		// var_dump($this->view_data['remarks']);
	}
	
	public function display($id)
	{
		$this->load->model(array('M_remarks'));
		
		$this->view_data['remarks'] = $this->M_remarks->get_remarks($id);
	}
	
	// Update
	public function edit($id)
	{
		$this->load->model(array('M_remarks'));
		
		$this->view_data['remarks'] = $this->M_remarks->get_remarks($id);
		
		if($_POST)
		{
			$data = $this->input->post('remarks');
			$data['is_deduction'] = isset($data['is_deduction']) ? 1 : 0;
			$data['is_payment'] = isset($data['is_payment']) ? 1 : 0;
			$data['updated_at'] = date('Y-m-d H:i:s');
			
			$result = $this->M_remarks->update_remarks($data, $id);
			
			if($result['status'])
			{
				log_message('error','Remarks Updated by: '.$this->user.'Success; Remarks Id: '.$id);
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger">Remark successfully updated.</div>');
				redirect('remarks');
			}
		}
	}
	
	// Destroy
	public function destroy($id)
	{
		$this->load->model(array('M_remarks'));
		
		$result = $this->M_remarks->delete_remarks($id);
		log_message('error','Remarks Deleted by: '.$this->user.'Success; Remarks Id: '.$id);
		$this->session->set_flashdata('system_message', '<div class="alert alert-danger">Remark successfully deleted.</div>');
		redirect('remarks');
	}
}