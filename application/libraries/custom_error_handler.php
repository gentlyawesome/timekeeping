<?php


class Custom_error_handler
{
	private $ci;
	private $error_handler_message = false;
	
	private $code;
	private $error;
	private $message;
	private $line;
	private $last_error;
	
	
	public function __construct()
	{
		$this->ci =& get_instance();
	}
	
	public function initialize_error_handling($x = false)
	{
		$this->error_handler_message = $x;
		set_error_handler($this->myErrorHandler());
		register_shutdown_function($this->fatalErrorShutdownHandler());
		$this->last_error = error_get_last();
	}

	
	function fatalErrorShutdownHandler()
	{

		if ($this->last_error['type'] === E_ERROR) 
		{
			// fatal error
			$this->code 	= E_ERROR;
			$this->error 	= $this->last_error['message'];
			$this->message	= $this->last_error['file'];			
			$this->line		= $this->last_error['line'];
			$this->myErrorHandler();
		 }
	}

	
	function myErrorHandler() 
	{
		ob_start();
		print_r($this->last_error);
		die();
		$ticket_number = substr(md5(rand(1000,9999).time()),0,15);
		log_message('error',$this->code.' | '.$this->error.' | '.$this->message.' | '.$this->line.' |ticket_number '.$ticket_number);
		if($this->error_handler_message == false){
			die('An Error Occured while processing request Contact system administrator ,ticket request number '.$ticket_number);
		}else{
			die($this->error_handler_message.' ticket request number '.$ticket_number);
		}
	}
}