<?php

class M_monitoring extends MY_Model{

  	protected $_table = "monitoring";

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
}

?>
