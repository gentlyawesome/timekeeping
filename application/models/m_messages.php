<?php

class M_messages Extends MY_Model
{
	protected $_table = 'messages';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}	
	
	public function get_unread($id, $userid)
	{
		$sql = "
			SELECT *
			FROM $this->_table
			WHERE `conversation_id` = ?
			AND `read` = ?
			AND `deleted` = ?
			AND sender_id <> ?
		";
		
		$query = $this->db->query($sql, array($id, 0, 0, $userid));
		
		return $query->num_rows();
	}
	
	public function get_all_unread($userid)
	{
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
	
	public function get_new_unread_message($conversation_id, $recipient_id)
	{
		$sql = "
			SELECT *
			FROM $this->_table
			WHERE `conversation_id` = ?
			AND `read` = ?
			AND `deleted` = ?
			AND recipient_id = ?
		";
		
		$query = $this->db->query($sql, array($conversation_id, 0, 0, $this->session->userdata['userid']));
		// vd($this->db->last_query());
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	public function update_unread_to_read($conversation_id, $userid)
	{
		$date_read = NOW;
		$sql = "
			UPDATE $this->_table
			set `read` = ?,
			date_read = ?
			WHERE `conversation_id` = ?
			AND `read` = ?
			AND `deleted` = ?
			AND `recipient_id` = ?
		";
		$query = $this->db->query($sql, array(1,$date_read,$conversation_id, 0, 0, $userid));
		// vd($this->db->last_query());
		return $query;
	}
	
	public function update_message($data = false, $where = false)
	{
		$this->db->set($data)->where('id',$where)->update($this->_table);
		return $this->db->affected_rows() > 0 ? array('status'=>'true') : array('status'=>'false');
	}
}