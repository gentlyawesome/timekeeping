<?php 

switch($this->session->userdata('userType'))
{
	case strtolower($this->session->userdata('userType')) == 'dean':
		$this->load->view('layouts/_dean_menu');
	break;
	
	case strtolower($this->session->userdata('userType')) == 'cashier':
		$this->load->view('layouts/_cashier_menu');
	break;
	
	case strtolower($this->session->userdata('userType')) == 'finance':
		$this->load->view('layouts/_finance_menu');
	break;
	
	case strtolower($this->session->userdata('userType')) == 'registrar':
		$this->load->view('layouts/_registrar_menu');
	break;
			
	case strtolower($this->session->userdata('userType')) == 'hrd':
	   $this->load->view('layouts/_hrd_menu');
	break;
	case strtolower($this->session->userdata('userType')) == 'teacher':
	   $this->load->view('layouts/_teacher_menu');
	break;
	case strtolower($this->session->userdata('userType')) == 'admin':
	   $this->load->view('layouts/_admin_menu');
	break;
	case strtolower($this->session->userdata('userType')) == 'president':
	   $this->load->view('layouts/_president_menu');
	break;
	case strtolower($this->session->userdata('userType')) == 'librarian':
	   $this->load->view('layouts/_librarian_menu');
	break;
	case strtolower($this->session->userdata('userType')) == 'custodian':
	   $this->load->view('layouts/_custodian_menu');
	break;
	case strtolower($this->session->userdata('userType')) == 'guidance':
	   $this->load->view('layouts/_guidance_menu');
	break;
}	
?>
