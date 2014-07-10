<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Announcements extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session_checker->open_semester();
		$this->session_checker->secure_page('all');
	}

	// Create
	public function create()
	{
		$this->load->model(array('M_announcements'));
		
		$this->view_data['announcement'] = FALSE;
		
		if($_POST)
		{
			if(isset($_POST['to_whom'])){
			while(list(,$val) = each($_POST['to_whom'])){
				if($val=='student'){$data['to_student']=1;}
				if($val=='employee'){$data['to_employee']=1;}
				if($val=='all'){$data['to_all']=1;}
			}
			}
			$data['message'] = $_POST['message'];
			$data['date'] = date('Y-m-d H:i:s',strtotime($_POST['date']));
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');
			$data['user_id'] = $this->session->userdata('userid');
			
			$result = $this->M_announcements->create_announcement($data);
			if($result['status'])
			{
				redirect('announcements');
			}
		}
	}
	
	// Retrieve
	public function index()
	{
		$this->load->model(array('M_announcements'));
		
		if( $this->session->userdata['userType'] == "teacher" || $this->session->userdata['userType'] == "finance" || $this->session->userdata['userType'] == "registrar" | $this->session->userdata['userType']== "hrd" )
		{
			$this->view_data['announcements'] = $this->M_announcements->find_all_by_user_id($this->session->userdata['userid']);
		}
		elseif($this->session->userdata('userType') == "student")
		{
			$this->view_data['announcements'] = $this->M_announcements->find_all_to_students();
		}
		else
		{
			$this->view_data['announcements'] = $this->M_announcements->find_all();
		}
	}
	
	public function display($id)
	{
		$this->load->model(array('M_announcements'));
		
		$this->view_data['announcement'] = $this->M_announcements->get_announcement($id);
	}
	
	// Update
	public function edit($id)
	{
		$this->load->model(array('M_announcements'));
		
		$this->view_data['announcement'] = $this->M_announcements->get_announcement($id);
		
		if($_POST)
		{
			if($_POST)
			{
			while(list(,$val) = each($_POST['to_whom'])){
				if($val=='student'){$data['to_student']=1;}else{$data['to_student']=0;}
				if($val=='employee'){$data['to_employee']=1;}else{$data['to_employee']=0;}
				if($val=='all'){$data['to_all']=1;}else{$data['to_all']=0;}
			}
			$data['message'] = $_POST['message'];
			$data['date'] = date('Y-m-d H:i:s',strtotime($_POST['date']));
			$data['updated_at'] = date('Y-m-d H:i:s');
			$data['user_id'] = $this->session->userdata('userid');
			$id = $_POST['id'];
			
			$result = $this->M_announcements->update_announcement($data,$id);
			if($result['status'])
			{
				redirect('announcements');
			}
			}
		}
	}
	
	// Update
	public function destroy($id)
	{
		$this->load->model(array('M_announcements'));
		
		$result = $this->M_announcements->delete_announcement($id);
		redirect('announcements');
	}
}