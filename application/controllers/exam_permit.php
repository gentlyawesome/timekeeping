<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Exam_permit extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->session_checker->open_semester();
		$this->session_checker->secure_page(array('finance','cashier'));
		$this->load->helper('my_dropdown');
    }
	
	
	public function index()
	{
		$this->session_checker->check_if_alive();
		$this->load->helper('url_encrypt');
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		$this->load->model('M_core_model', 'm');
		$this->load->model('M_student_grades', 's');
		
		if($_POST)
		{
			$this->view_data['type'] = $type = $this->input->post('type');
			$this->view_data['year_id'] = $year_id = $this->input->post('year_id');
			$this->view_data['semester_id'] = $semester_id = $this->open_semester->id;
			$this->view_data['course_id'] = $course_id = $this->input->post('course_id');
			$this->view_data['per_page'] = $per_page = $this->input->post('per_page');
			
			$fields = array(
				
				'enrollments.id',
				'enrollments.studid',
				'enrollments.name',
				'enrollments.status',
				'years.year',
				'enrollments.year_id',
				'enrollments.semester_id',
				'courses.course',
				'enrollments.course_id',
				'enrollments.sy_from',
				'enrollments.sy_to',
				'semesters.name as semester',
				'student_grade_files.id as student_grade_file_id'
				
			);
			
			//FILTERS
			$where['enrollments.is_paid'] = 1;
			$where['enrollments.is_deleted'] = 0;
			$where['enrollments.sy_from'] = $this->open_semester->year_from;
			$where['enrollments.sy_to'] = $this->open_semester->year_to;
			if($year_id != "")
			{
				$where['enrollments.year_id'] = $year_id;
			}
			
			if($semester_id != "")
			{
				$where['enrollments.semester_id'] = $semester_id;
			}
			
			if($course_id != "")
			{
				$where['enrollments.course_id'] = $course_id;
			}
			
			
			//CONFIGURATION
			$config['fields'] = $fields;
			$config['where'] = $where;
			$config['join'][] = array(
				"table" => "courses",
				"on"	=> "courses.id = enrollments.course_id",
				"type"  => "LEFT"
			);
			$config['join'][] = array(
				"table" => "years",
				"on"	=> "years.id = enrollments.year_id",
				"type"  => "LEFT"
			);
			$config['join'][] = array(
				"table" => "semesters",
				"on"	=> "semesters.id = enrollments.semester_id",
				"type"  => "LEFT"
			);
			$config['join'][] = array(
				"table" => "student_grade_files",
				"on"	=> "student_grade_files.user_id = enrollments.id",
				"type"  => "LEFT"
			);
			$config['order'] = "enrollments.name ASC";
			
			$config['all'] = true;
			
			$this->view_data['students'] = $rs = $this->m->get_record("enrollments", $config);
			
			foreach($rs as $student)
			{
				$this->view_data['studentsubjects'][$student->id] = $this->s->get_student_grade_by_student_grade_file_id($student->student_grade_file_id);
				// vd($this->view_data['studentsubjects']);
			}
			
			if($rs)
			{
				$this->generate_pdf($this->view_data);
			}
			else
			{
				$this->session->set_flashdata('system_message', '<div class="alert alert-danger">No record found.</div>');
			}
		}
	}
	
	public function generate_grade_slip_per_student($id = false)
	{
		if($id == false) { show_404(); }
		$this->load->model('M_core_model', 'm');
		$this->load->model('M_student_grades', 's');	
		
		$fields = array(
				
				'enrollments.id',
				'enrollments.studid',
				'enrollments.name',
				'enrollments.status',
				'years.year',
				'enrollments.year_id',
				'enrollments.semester_id',
				'courses.course',
				'enrollments.course_id',
				'enrollments.sy_from',
				'enrollments.sy_to',
				'semesters.name as semester',
				'student_grade_files.id as student_grade_file_id'
				
			);
			
			//FILTERS
			$where['enrollments.id'] = $id;
			
			//CONFIGURATION
			$config['fields'] = $fields;
			$config['where'] = $where;
			$config['join'][] = array(
				"table" => "courses",
				"on"	=> "courses.id = enrollments.course_id",
				"type"  => "LEFT"
			);
			$config['join'][] = array(
				"table" => "years",
				"on"	=> "years.id = enrollments.year_id",
				"type"  => "LEFT"
			);
			$config['join'][] = array(
				"table" => "semesters",
				"on"	=> "semesters.id = enrollments.semester_id",
				"type"  => "LEFT"
			);
			$config['join'][] = array(
				"table" => "student_grade_files",
				"on"	=> "student_grade_files.user_id = enrollments.id",
				"type"  => "LEFT"
			);
			$config['order'] = "enrollments.name ASC";
			
			$config['all'] = true;
			
			$this->view_data['students'] = $rs = $this->m->get_record("enrollments", $config);
			$this->view_data['per_page'] = 1;
			
			foreach($rs as $student)
			{
				$this->view_data['studentsubjects'][$student->id] = $this->s->get_student_grade_by_student_grade_file_id($student->student_grade_file_id);
			}
			
			$this->generate_pdf($this->view_data);
		
		
	}
	
	public function generate_pdf($data = false)
	{
		if($data == false) { show_404(); }
		
		$this->load->helper('print');
			
		$this->load->library('mpdf');

		$students = $data['students'];
		$studentsubjects = $data['studentsubjects'];
		
		$html .= _css(); //GET CSS
		$html .= _css_grade_slip($data['per_page']); //GET CSS
		
		if($students)
		{
			$html .= "";
			$ctr = 0;
			$per_page = $data['per_page'];
			$xpass = false;
			
			foreach($students as $stud)
			{
				$ctr++;
				
				$student[] = $stud;
				$subject[$stud->id] = $studentsubjects[$stud->id];
				
				if($ctr == $per_page)
				{
					if($xpass == false){
						$xpass = true;
					}else{
						$html .= "<pagebreak />";
					}
					
					$mpdf=new mPDF('','FOLIO','','',10,10,5,5,0,0); 
					$html .= _html_exam_permit($student, $subject, $per_page); //CREATES PER PAGE
					
					unset($student);
					unset($subject);
			
					$ctr = 0;
					// break;
				}
				
			}
			
			$mpdf->WriteHTML($html);
			$mpdf->Output();
		
		}
		else
		{
			$this->session->set_flashdata('system_message', '<div class="alert alert-danger">No record found.</div>');
			redirect('generate_grade_slip');
		}
	}
	
	
    public function generate()
    {
        $this->session_checker->check_if_alive();
        $this->load->model(array(
            'M_courses'
        ));
        $this->view_data['courses'] = $this->M_courses->get(FALSE, array(
            'id',
            'course'
        ));
    }
    public function print_generate()
    {
        $this->session_checker->check_if_alive();
		
		$this->view_data['system_message'] = $this->session->flashdata('system_message');
		
        $this->load->model(array(
            'M_enrollments',
            'M_settings',
            'M_permit_setting',
            'M_student_subjects'
        ));
        if ($_POST) {
            $cid            = $_POST['course'];
            $setting        = $this->M_settings->get_settings();
            $permit_setting = $this->M_permit_setting->get_settings();
            $enrollments    = $this->M_enrollments->get_enrollments_for_generation_of_exam_permit($cid, $this->open_semester->id, $this->open_semester->year_from, $this->open_semester->year_to);
           				
            if ($enrollments) {
                $this->load->helper('print_exam_permit');
                $h      = "8";
              
                $hm     = $h * 60;
                $ms     = $hm * 60;
                $now    = time();
                $gmt    = local_to_gmt($now);
                $gmdate = $gmt + ($ms);
              
                $max    = sizeof($enrollments);
                
                //print_html defined at helpers/print_helper.php			
                $html = print_html($enrollments, $setting, $permit_setting, $gmdate, $max);
                $this->load->library('mpdf');
                $mpdf = new mPDF('', 'LETTER', '', '', 5, 5, 5, 5, 0, 0);
                $mpdf->WriteHTML($html);
                $mpdf->Output();
            } else {
                $this->view_data['system_message'] = "<div class='alert alert-danger'>There are no students under this course.</div>";
                redirect('exam_permit/generate');
            }
        }
    }
}