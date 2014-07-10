<?php

class M_module extends MY_Model{

  	protected $_table = "modules";

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
}

?>
