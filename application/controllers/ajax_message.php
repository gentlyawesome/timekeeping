<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_message extends CI_Controller {
	
  public function __construct()
	{
		parent::__construct();
		$this->session_checker->check_if_alive();
	}
	
	public function delete_message()
	{
		//DONT DELETE, ONLY UPDATE DELETE COLUMN 
		$this->load->model(array('M_messages','M_conversation'));
		$id = $this->input->post('id');
		$data['deleted'] = 1;
		
		$rs['status'] = $this->M_messages->update($id, $data);
		
		echo json_encode($rs);
	}
	
	public function reply()
	{
		$this->load->model(array('M_messages','M_conversation'));
		$message = trim($this->input->post('message'));
		$conversation_id = $this->input->post('conversation_id');
		$recipient_id = $this->input->post('recipient_id');
		
		if($message != "" && $conversation_id != "" && $recipient_id != "")
		{
			$data['conversation_id'] = $conversation_id;
			$data['message'] = $message;
			$data['sender_id'] = $this->session->userdata['userid'];
			$data['recipient_id'] = $recipient_id;
			$rs = $this->M_messages->insert($data, true); //SAVE MESSAGE
			
			$this->get_message(0);
		}
		else
		{
			echo "FAILED";
		}
	}
	
	public function check_all_unread_message()
	{
		$this->load->model(array('M_messages','M_conversation'));
		
		$conversation_id = $this->input->post('conversation_id');
		
		$userid = $this->session->userdata['userid'];
		
		$rs = $this->M_messages->get_unread($conversation_id, $userid);
		
		$data['unread'] = $rs;
		
		echo json_encode($data);
	}
	
	public function check_new_unread_message()
	{
		$conversation_id = $this->input->post('conversation_id');
		$recipient_id = $this->input->post('recipient_id');
		
		$this->load->model(array('M_messages','M_conversation'));
		
		$rs = $this->M_messages->get_new_unread_message($conversation_id, $recipient_id);
		
		$data['status'] = false;
		
		if($rs)
		{
			$data['status'] = true;
		}
		
		echo json_encode($data);
	}
	
	public function get_message($page=0)
	{
		$this->load->model(array('M_messages'));
		
		$conversation_id = $this->input->post('conversation_id');
		
		//CONFIGURATION
		$config['fields'] = array(
			'messages.id',
			'messages.message',
			'messages.sender_id',
			'messages.created_at',
			'messages.updated_at',
			'messages.read',
			'users.name',
			'users.login'
		);
		
		$where['messages.conversation_id'] = $conversation_id;
		$where['messages.deleted'] = 0;
		$config['where'] = $where;
		$config['join'][] = array(
			"table" => "users",
			"on"	=> "users.id = messages.sender_id",
			"type"  => "LEFT"
		);
		$config['order'] = "messages.updated_at DESC";
		$config['start'] = false;
		$config['limit'] = false;
		
		$this->load->library("pagination");
		$pg_config['full_tag_open'] = '<ul id="pg_message_list" class="pagination .pagination-sm">';
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
		$this->view_data['total_rows'] = $pg_config["total_rows"] = $this->M_messages->get_record("messages", $config);
		
		$pg_config["per_page"] = 20;
		$pg_config['num_links'] = 10;
		$pg_config["uri_segment"] = 3;
		$this->pagination->initialize($pg_config);
		
		$config['start'] = $page;
		$config['limit'] = $pg_config['per_page'];
		$config['all'] = false;
		$config['count'] = false;
		
		$this->view_data['conversation_id'] = $conversation_id;
		$this->view_data['messages'] = $messages = $this->M_messages->get_record("messages", $config);
		$this->view_data['links'] = $this->pagination->create_links();
		// vd($messages);
		
		$this->load->view('messages/message_list', $this->view_data);
		
		//UPDATE UNREAD MESSAGES TO READ
		$this->M_messages->update_unread_to_read($conversation_id, $this->session->userdata['userid']); 
	}
	
	public function count_all_unread_message()
	{
		$this->load->model(array('M_messages','M_conversation'));
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
		$where['conversation.user1_id'] = $this->session->userdata['userid'];
		$or_where['conversation.user2_id'] = $this->session->userdata['userid'];
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
		$pg_config["base_url"] = base_url() ."messages/inbox";
		
		
		$config['all'] = true;
		$config['count'] = false;
		
		$recipients = $this->M_conversation->get_record("conversation", $config);
		
		
		//GET NUMBER OF UNREAD MESSAGE OF EACH RECIPIENTS
		$unread = 0;
		if($recipients)
		{
			foreach($recipients as $obj)
			{
				$unread += $this->M_messages->get_unread($obj->id, $this->session->userdata['userid']);
			}
		}
		
		$data['unread'] = $unread;
		
		echo json_encode($data);
	}
	
	public function get_inbox($page = 0)
	{
		$this->load->model(array('M_messages','M_conversation'));
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
		$where['conversation.user1_id'] = $this->session->userdata['userid'];
		$or_where['conversation.user2_id'] = $this->session->userdata['userid'];
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
				$recipients_count[$obj->id] = $this->M_messages->get_unread($obj->id, $this->session->userdata['userid']);
			}
			
			$this->view_data['recipients_count'] = $recipients_count;
		}
		
		$this->load->view('messages/inbox_list', $this->view_data);
	}
}
