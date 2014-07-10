<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session_checker->open_semester();
		$this->session_checker->check_if_alive();
		$this->session_checker->secure_page('student');
		$this->load->helper('my_dropdown');
		$this->load->library(array('form_validation'));		
		$this->load->model(array('M_messages','M_conversation'));
	}
	
	public function index()
	{
		// vd($this->open_semester);
		redirect('messages/inbox');
	}
	
	public function inbox($page = 0, $recipient_id = false)
	{
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		//CONFIGURATION
		$config['fields'] = array(
			'conversation.id',
			'conversation.user1_id',
			'conversation.user2_id',
			'u1.name as user1_name',
			'u1.login as user1_login',
			'u2.name as user2_name',
			'u2.login as user2_login',
		);
		
		$where['conversation.deleted'] = 0;
		$where['conversation.user1_id'] = $this->userid;
		$or_where['conversation.user2_id'] = $this->userid;
		$config['where'] = $where;
		$config['or_where'] = $or_where;
		$config['join'][] = array(
			"table" => "users u1",
			"on"	=> "u1.id = conversation.user1_id",
			"type"  => "LEFT"
		);
		$config['join'][] = array(
			"table" => "users u2",
			"on"	=> "u2.id = conversation.user2_id",
			"type"  => "LEFT"
		);
		
		$config['order'] = "conversation.updated_at DESC";
		$config['start'] = false;
		$config['limit'] = false;
		
		$this->load->library("pagination");
		$pg_config['full_tag_open'] = '<ul id="pg_recipient" class="pagination pagination-sm">';
		 $pg_config['full_tag_close'] = '</ul>';
		 $pg_config['prev_link'] = '<span class="glyphicon glyphicon-chevron-left"></span>';
		 $pg_config['prev_tag_open'] = '<li>';
		 $pg_config['prev_tag_close'] = '</li>';
		 $pg_config['next_link'] = '<span class="glyphicon glyphicon-chevron-right"></span>';
		 $pg_config['next_tag_open'] = '<li>';
		 $pg_config['next_tag_close'] = '</li>';
		 $pg_config['cur_tag_open'] = '<li class="active"><a href="#">';
		 $pg_config['cur_tag_close'] = '</a></li>';
		 $pg_config['num_tag_open'] = '<li>';
		 $pg_config['num_tag_close'] = '</li>';
		 $pg_config['first_link'] = FALSE;
		 $pg_config['last_link'] = FALSE;
		$pg_config["base_url"] = base_url() ."messages/inbox";
		
		
		$config['all'] = true;
		$config['count'] = true;
		$this->view_data['total_rows'] = $pg_config["total_rows"] = $this->M_conversation->get_record("conversation", $config);
		
		$pg_config["per_page"] = 20;
		$pg_config['num_links'] = 8;
		$pg_config["uri_segment"] = 3;
		$this->pagination->initialize($pg_config);
		
		$config['start'] = $page;
		$config['limit'] = $pg_config['per_page'];
		$config['all'] = false;
		$config['count'] = false;
		
		$this->view_data['recipients'] = $recipients = $this->M_conversation->get_record("conversation", $config);
		$this->view_data['links'] = $links = $this->pagination->create_links();
		
		//GET NUMBER OF UNREAD MESSAGE OF EACH RECIPIENTS
		$recipients_count = array();
		if($recipients)
		{
			foreach($recipients as $obj)
			{
				$recipients_count[$obj->id] = $this->M_messages->get_unread($obj->id, $this->userid);
			}
			
			$this->view_data['recipients_count'] = $recipients_count;
		}
	}
	
	public function conversation()
	{
	}
	
	public function new_message()
	{
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
		if($_POST)
		{
			$this->session_checker->check_if_alive();
			if($this->form_validation->run('new_message') !== FALSE)
			{
				$recipient_id = $this->input->post('recipient_id');
				$message = trim($this->input->post('message'));
				
				//CHECK IF CONVERSATION OF BOTH PARTY EXIST
				$con = $this->M_conversation->get_conversation($this->userid, $recipient_id);
				
				//IF CONVERSATION EXIST GET ID
				if($con)
				{
					//UPDATE FOR SORTING PURPOSE
					$conversation['updated_at'] = NOW;
					$rs_con = $this->M_conversation->update($con->id, $conversation);
					
					$data['conversation_id'] = $con->id;
				}
				else //ELSE CREATE CONVERSATION FIRST
				{
					$conversation['user1_id'] = $this->userid;
					$conversation['user2_id'] = $recipient_id;
					
					$rs_con = $this->M_conversation->insert($conversation, true);
					
					if($rs_con['status'])
					{
						$data['conversation_id'] = $rs_con['id'];
					}
				}
				
				if($data['conversation_id'] != "")
				{
					$data['message'] = $message;
					$data['sender_id'] = $this->userid;
					$data['recipient_id'] = $recipient_id;
					$rs = $this->M_messages->insert($data, true); //SAVE MESSAGE
					$this->session->set_flashdata('system_message', '<div class="alert alert-success">Message was successfully sent.</div>');
					redirect('messages/inbox');
				}
				else
				{
					$this->session->set_flashdata('system_message', '<div class="alert alert-danger">Message was not send please try again.</div>');
				}
			}
		}
	}
}