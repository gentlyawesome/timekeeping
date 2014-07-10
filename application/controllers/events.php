<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session_checker->open_semester();
	}
	
	public function index()
	{
		$this->session_checker->check_if_alive();
		
		$this->load->model(array('M_events'));
		
		/*
		$this->view_data['date'] = $this->M_events->get_events();
		$this->view_data['total_rows'] = $this->M_events->count_events();
	
		$config['day_type'] = 'long'; 
		$config['show_next_prev'] = TRUE; 
		$config['next_prev_url'] = 'http://php.372429327833758.info/events/index/'; 
		
		print_r();
		
		$config['template'] = '
			{table_open}<table class="calendar">{/table_open}
			{heading_row_start}<tr>{/heading_row_start}
			{heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
			{heading_title_cell}<th colspan="{colspan}" id="title_cell">{heading}</th>{/heading_title_cell}
			{heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
			{heading_row_end}</tr>{/heading_row_end}
			{week_day_cell}<th class="day_header">{week_day}</th>{/week_day_cell}
			{cal_cell_content}<a class="with_content" href="{content}">{day} {content}</a>{/cal_cell_content}
			{cal_cell_content_today}<div class="today_with_content"><a href="{content}">{day}</a></div>{/cal_cell_content_today}
			{cal_cell_no_content}<div class="not_today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content}
			{cal_cell_no_content_today}<div class="today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content_today}
		';  
		
		$this->load->library('calendar',$config);
		*/
		$this->view_data['dates'] = $this->M_events->get_events();
	}
	
	public function create()
	{
		$this->session_checker->check_if_alive();
		
		$this->load->model(array('M_events'));
		
		$this->view_data['event'] = FALSE;
		
		if($_POST)
		{
			while(list(,$val) = each($_POST['to_what'])){
				if($val=='is_holiday'){$data['is_holiday']=1;}
				if($val=='to_all'){$data['to_all']=1;}
			}
			$data['description'] = $_POST['description'];
			$data['title'] = $_POST['title'];
			$data['start_date'] = date('Y-m-d H:i:s',strtotime($_POST['start_date']));
			$data['end_date'] = date('Y-m-d H:i:s',strtotime($_POST['end_date']));
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');
			
			$result = $this->M_events->create_event($data);
			if($result['status'])
			{
				redirect('events');
			}
		}
	
	}
	
	public function edit($id)
	{
		$this->session_checker->check_if_alive();
		
		$this->load->model(array('M_events'));
		
		$this->view_data['event'] = $this->M_events->get_events($id);
		
		if($_POST)
		{
			if($_POST)
			{
			if(isset($_POST['to_what']))
			{
			while(list(,$val) = each($_POST['to_what'])){
				if($val=='is_holiday'){$data['is_holiday']=1;}else{$data['is_holiday']=0;}
				if($val=='to_all'){$data['to_all']=1;}else{$data['to_all']=0;}
			}
			}
			$data['title'] = $_POST['title'];
			$data['description'] = $_POST['description'];
			$data['start_date'] = date('Y-m-d H:i:s',strtotime($_POST['start_date']));
			$data['end_date'] = date('Y-m-d H:i:s',strtotime($_POST['end_date']));
			$data['updated_at'] = date('Y-m-d H:i:s');
			$id = $_POST['id'];
			
			$result = $this->M_events->update_event($data,$id);
			if($result['status'])
			{
				redirect('events');
			}
			}
		}
	}
	
	public function display($id)
	{
		$this->session_checker->check_if_alive();
		
		$this->load->model(array('M_events'));
		
		$this->view_data['event'] = $this->M_events->get_events($id);
	}
	public function destroy($id)
	{
		$this->session_checker->check_if_alive();
		
		$this->load->model(array('M_events'));
		
		$result = $this->M_events->delete_event($id);
		redirect('events');
	}
}