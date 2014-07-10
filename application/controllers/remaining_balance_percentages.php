<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Remaining_balance_percentages extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session_checker->open_semester();
		$this->session_checker->secure_page('admin');
	}
	
	// Create
	public function create()
	{
		$this->load->model(array('M_remaining_balance_percentages','M_semesters'));
		
		$this->view_data['remaining_balance_percentage'] = FALSE;
		
		$this->view_data['semesters'] = $this->M_semesters->find_all();
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		if($_POST)
		{
			$data = $this->input->post('remaining_balance_percentages');
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');
			
			$result = $this->M_remaining_balance_percentages->create_remaining_balance_percentages($data);
			
			if($result['status'])
			{
				log_message('error','Required Payment Percentage Created by: '.$this->user.'Success; Required Payment Percentage Id: '.$id);
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger">Required Payment Percentage successfully added.</div>');
				redirect('remaining_balance_percentages');
			}
		}
	}
	
	// Retrieve
	public function index()
	{
		$this->load->model(array('M_remaining_balance_percentages','M_semesters'));
		$this->view_data['remaining_balance_percentages'] = $this->M_remaining_balance_percentages->find_all();
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
	}
	
	public function display($id)
	{
		$this->load->model(array('M_remaining_balance_percentages'));
		
		$this->view_data['remaining_balance_percentages'] = $this->M_remaining_balance_percentages->get_remaining_balance_percentages($id);
	}
	
	// Update
	public function edit($id)
	{
		$this->load->model(array('M_remaining_balance_percentages','M_semesters'));
		
		$this->view_data['remaining_balance_percentages'] = $this->M_remaining_balance_percentages->get_remaining_balance_percentages($id);
		
		$this->view_data['semesters'] = $this->M_semesters->find_all();
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		if($_POST)
		{
			$data = $this->input->post('remaining_balance_percentages');
			$data['updated_at'] = date('Y-m-d H:i:s');
			
			$result = $this->M_remaining_balance_percentages->update_remaining_balance_percentages($data, $id);
			
			if($result['status'])
			{
				log_message('error','Required Payment Percentage Updated by: '.$this->user.'Success; Required Payment Percentage Id: '.$id);
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger">Required Payment Percentage successfully updated.</div>');
				redirect('remaining_balance_percentages');
			}
		}
	}
	
	// Update
	public function destroy($id)
	{
		$this->load->model(array('M_remaining_balance_percentages'));
		
		$result = $this->M_remaining_balance_percentages->delete_remaining_balance_percentages($id);
		log_message('error','Required Payment Percentage Deleted by: '.$this->user.'Success; Required Payment Percentage Id: '.$id);
		$this->session->set_flashdata('system_message', '<div class="alert alert-danger">Required Payment Percentage successfully deleted.</div>');
		redirect('remaining_balance_percentages');
	}
}