<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session_checker->open_semester();
		$this->session_checker->check_if_alive();
	}
	
	public function index()
	{
		// vd($this->open_semester);
	}
	
	public function promisory()
	{
		//$this->session_checker->secure_page('student');
	}
}