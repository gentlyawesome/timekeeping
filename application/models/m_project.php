<?php

class M_project extends MY_Model{

  	protected $_table = "project";

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
}

?>
