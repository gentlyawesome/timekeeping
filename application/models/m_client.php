<?php

class M_client extends MY_Model{

  	protected $_table = "client";

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
}

?>
