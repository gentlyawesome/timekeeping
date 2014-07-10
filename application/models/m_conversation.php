<?php

class M_conversation Extends MY_Model
{
	protected $_table = 'conversation';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}	
	
	public function get_unread($sender_id, $recipient_id)
	{
		$sql = "
			SELECT *
			FROM $this->_table
			WHERE `sender_id` = ?
			AND `recipient_id` = ?
			AND `read` = ?
		";
		
		$query = $this->db->query($sql, array($sender_id, $recipient_id, 0));
		
		return $query->num_rows();
	}
	
	public function get_conversation($id1, $id2)
	{
		$sql = "
			SELECT *
			FROM $this->_table
			WHERE (`user1_id` = ? AND `user2_id` = ?)
			OR (`user1_id` = ? AND `user2_id` = ?)
			AND deleted = ?
		";
		
		$param[] = $id1;
		$param[] = $id2;
		$param[] = $id2;
		$param[] = $id1;
		$param[] = 0;
		
		$query = $this->db->query($sql, $param);
		
		return $query->num_rows > 0 ? $query->row() : false;
	}
	
	public function identify_recipient($id)
	{
	
	}
}