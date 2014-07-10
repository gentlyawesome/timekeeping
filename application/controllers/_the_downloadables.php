<?php
/*
* All Excel Generating functions in here
* 
*/
class _The_downloadables Extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->session_checker->open_semester();
	}
	public function _test()
	{
		show_404();
	}
	
	public function _print_all_student_profiles($p)
	{
			$this->load->library('excel');
			$objectSheet = $this->excel->getActiveSheet();
			ini_set('memory_limit','500M');
			ini_set('max_execution_time',60);
			
			$objectSheet->setTitle('Student Profiles');
			$objectSheet->setCellValue('A1','Student Profiles');
				
			$objectSheet->setCellValue('A2', 'Name of Student');
			$objectSheet->setCellValue('B2', 'Gender');
			$objectSheet->setCellValue('C2', 'Civil Status');
			$objectSheet->setCellValue('D2', 'Date of Birth');
			$objectSheet->setCellValue('E2', 'Place of Birth');
			$objectSheet->setCellValue('F2', 'Age');
			$objectSheet->setCellValue('G2', 'Disablity');
			$objectSheet->setCellValue('H2', 'Nationality');
			$objectSheet->setCellValue('I2', 'Nationality');
			$objectSheet->setCellValue('J2', 'Mobile #');
			$objectSheet->setCellValue('K2', 'E-Mail Address');
			$objectSheet->setCellValue('L2', 'Present Address');
			$objectSheet->setCellValue('M2', 'Father\'s Name');
			$objectSheet->setCellValue('N2', 'Father\'s Occupation');
			$objectSheet->setCellValue('O2', 'Mothers Name');
			$objectSheet->setCellValue('P2', 'Mothers Occupation');
			$objectSheet->setCellValue('Q2', 'Parent\'s Address');
			$objectSheet->setCellValue('R2', 'Guardian\'s Name');
			$objectSheet->setCellValue('S2', 'Relationship with Guardian\'s');
			$objectSheet->setCellValue('T2', 'Guardian\'s Contact #');
			$objectSheet->setCellValue('U2', 'Guardian\'s Address');
			$objectSheet->setCellValue('V2', 'Elementary School Attended');
			$objectSheet->setCellValue('W2', 'Elementary School Address');
			$objectSheet->setCellValue('X2', 'Elementary School Date Attended');
			$objectSheet->setCellValue('Y2', 'Secondary School Attended');
			$objectSheet->setCellValue('Z2', 'Secondary School Address');
			$objectSheet->setCellValue('AA2', 'Secondary School Date Attended');
			$objectSheet->setCellValue('AB2', 'Vocational School Attended');
			$objectSheet->setCellValue('AC2', 'Vocational School Address');
			$objectSheet->setCellValue('AD2', 'Vocational School Degree');
			$objectSheet->setCellValue('AE2', 'Vocational School Date Attended');
			$objectSheet->setCellValue('AF2', 'Tertiary School name');
			$objectSheet->setCellValue('AG2', 'Tertiary School Address');
			$objectSheet->setCellValue('AH2', 'Tertiary School Degree');
			$objectSheet->setCellValue('AI2', 'Tertiary School Date Attended');
			// Set cell width
			$width = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI');
			for($x = 0;$x < count($width);$x++)
			{
				$objectSheet->getColumnDimension($width[$x])->setWidth(30);
			}
				
			$c = $s = 3;
			foreach($p as $p)
			{
				$fullname = ucwords($p->first_name.' , '.$p->middle_name.' , '.$p->last_name);
				$objectSheet->setCellValue('A'.($c), ucwords($p->name));
				$objectSheet->setCellValue('B'.($c), $p->sex);
				$objectSheet->setCellValue('C'.($c), $p->civil_status);
				$objectSheet->setCellValue('D'.($c), $p->date_of_birth);
				$objectSheet->setCellValue('E'.($c), $p->place_of_birth);
				$objectSheet->setCellValue('F'.($c), $p->age );
				$objectSheet->setCellValue('G'.($c),$p->disability);
				$objectSheet->setCellValue('H'.($c),$p->nationality);
				$objectSheet->setCellValue('I'.($c),$p->religion);
				$objectSheet->setCellValue('J'.($c),$p->mobile);
				$objectSheet->setCellValue('K'.($c),$p->email);
				$objectSheet->setCellValue('L'.($c),$p->present_address);
				$objectSheet->setCellValue('M'.($c),$p->father_name);
				$objectSheet->setCellValue('N'.($c),$p->father_occupation);
				$objectSheet->setCellValue('O'.($c),$p->mother_name);
				$objectSheet->setCellValue('P'.($c),$p->mother_occupation);
				$objectSheet->setCellValue('Q'.($c),$p->parents_address);
				$objectSheet->setCellValue('R'.($c),$p->guardian_name);
				$objectSheet->setCellValue('S'.($c),$p->guardian_relation);
				$objectSheet->setCellValue('T'.($c),$p->guardian_contact_no);
				$objectSheet->setCellValue('U'.($c),$p->guardian_address);
				$objectSheet->setCellValue('V'.($c),$p->elementary);
				$objectSheet->setCellValue('W'.($c),$p->elementary_address);
				$objectSheet->setCellValue('X'.($c),$p->elementary_date);
				$objectSheet->setCellValue('Y'.($c),$p->secondary);
				$objectSheet->setCellValue('Z'.($c),$p->secondary_address);
				$objectSheet->setCellValue('AA'.($c),$p->secondary_date);
				$objectSheet->setCellValue('AB'.($c),$p->vocational);
				$objectSheet->setCellValue('AC'.($c),$p->vocational_address);
				$objectSheet->setCellValue('AD'.($c),$p->vocational_degree);
				$objectSheet->setCellValue('AE'.($c),$p->vocational_date);
				$objectSheet->setCellValue('AF'.($c),$p->tertiary);
				$objectSheet->setCellValue('AG'.($c),$p->tertiary_address);
				$objectSheet->setCellValue('AH'.($c),$p->tertiary_degree);
				$objectSheet->setCellValue('AI'.($c),$p->tertiary_date);
				$c++;
			}
				
			$objectSheet->getStyle('A1')->getFont()->setSize(20);
			$objectSheet->mergeCells('A1:F1');
			$objectSheet->getStyle("A2:AI2")->applyFromArray(array("font" => array( "bold" => true)));
			$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
			$objectSheet->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
			$filename='student_profiles_'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format				
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			@ob_end_clean(); 
			//force user to download the Excel file without writing it to server's HD 
			$objWriter->save('php://output'); 
			@$objectSheet->disconnectWorksheets(); 
			unset($objectSheet);
	}
	
	public function _print_all_subject()
	{
		$this->load->model('M_subjects');
		$p =$this->M_subjects->find_all();
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		
		$objectSheet->setTitle('Subject List');
		$objectSheet->setCellValue('A1','Subject List');
		
		$objectSheet->setCellValue('A2','Subject Code');
		$objectSheet->setCellValue('B2', 'Section Code');
		$objectSheet->setCellValue('C2', 'Description');
		$objectSheet->setCellValue('D2', 'Unit');
		$objectSheet->setCellValue('E2', 'Lec');
		$objectSheet->setCellValue('F2', 'Lab');
		$objectSheet->setCellValue('G2', 'Time');
		$objectSheet->setCellValue('H2', 'Day');
		$objectSheet->setCellValue('I2', 'Room');
		$objectSheet->setCellValue('J2', 'Remaining Slots');
		$objectSheet->setCellValue('K2', 'Academic Year');
		
		$width = array('A','B','C','D','E','F','G','H','I','J','K','L','M');
		for($x = 0;$x < count($width);$x++)
		{
			$objectSheet->getColumnDimension($width[$x])->setWidth(20);
		}
		
		$c = $s = 3;
		foreach($p as $p)
		{
			$objectSheet->setCellValue('A'.($c), $p->sc_id);
			$objectSheet->setCellValue('B'.($c), $p->code);
			$objectSheet->setCellValue('C'.($c), $p->subject);
			$objectSheet->setCellValue('D'.($c), $p->units);
			$objectSheet->setCellValue('E'.($c), $p->lec);
			$objectSheet->setCellValue('F'.($c), $p->lab );
			$objectSheet->setCellValue('G'.($c),$p->time);
			$objectSheet->setCellValue('H'.($c),$p->day);
			$objectSheet->setCellValue('I'.($c),$p->room);
			$objectSheet->setCellValue('J'.($c),$p->subject_load);
			$objectSheet->setCellValue('K'.($c),$p->year_from.'-'.$p->year_to);
			$c++;
		}
		
		$objectSheet->getStyle('A1')->getFont()->setSize(20);
		$objectSheet->mergeCells('A1:K1');
		$objectSheet->getStyle("A2:K1")->applyFromArray(array("font" => array( "bold" => true)));
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objectSheet->getStyle('A2:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		
		$filename='Subject_List'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
			
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
			
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);	
	}
	
	public function _generate_payment_report($id)
	{
		$this->load->model('m_finance_queries','m');
		$results = $this->m->get_payment_data($id);
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		//load our new PHPExcel library
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$objectSheet->setTitle('Payments');
		//set cell A1 content with some text
		$objectSheet->setCellValue('A1','Payments From '.date('M d, Y',strtotime($results[0]->start_date)).' to '.date('M d, Y',strtotime($results[0]->end_date)));
		$objectSheet->setCellValue('A2', 'Fullname');
		$objectSheet->setCellValue('B2', 'Remarks');
		$objectSheet->setCellValue('C2', 'OR Number');
		$objectSheet->setCellValue('D2', 'Date Paid');
		$objectSheet->setCellValue('E2', 'Payments');
		$objectSheet->setCellValue('F2', 'Old Accounts');
			//change the font size
		$objectSheet->getStyle('A1')->getFont()->setSize(20);
			//merge cell A1 until D1
		$objectSheet->mergeCells('A1:F1');
		$objectSheet->getStyle("A2:F2")->applyFromArray(array("font" => array( "bold" => true)))
														  ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		
		$count = 3;
		foreach($results as $r)
		{	
			$objectSheet->setCellValue('A'.$count,ucwords($r->first_name.' '.$r->middle_name.' '.$r->last_name))
															->setCellValue('B'.$count,$r->remarks)
															->setCellValue('C'.$count,$r->or_no)
															->setCellValue('D'.$count,date('M d, Y',strtotime($r->stud_payment_date)))
															->setCellValue('E'.$count,$r->payments)
															->setCellValue('F'.$count,$r->old_account);
															
			$objectSheet->getStyle('D'.($count))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);												
			$objectSheet->getStyle('D'.($count))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);
			$objectSheet->getStyle('E'.($count))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			$objectSheet->getStyle('E'.($count))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$objectSheet->getStyle('F'.($count))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			$objectSheet->getStyle('F'.($count))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
											
			$count++;
		}
			
		$objectSheet->getColumnDimension('A')->setWidth(25);
		$objectSheet->getColumnDimension('B')->setWidth(25);
		$objectSheet->getColumnDimension('C')->setWidth(25);
		$objectSheet->getColumnDimension('D')->setWidth(25);
		$objectSheet->getColumnDimension('E')->setWidth(15);
		$objectSheet->getColumnDimension('F')->setWidth(15);
													
		$objectSheet->setCellValue('D'.$count,'TOTAL');
		$objectSheet->setCellValue('E'.$count,'=SUM(E3:E'.($count-1).')');
		$objectSheet->setCellValue('F'.$count,'=SUM(F3:F'.($count-1).')');
		
		$objectSheet->getStyle('E'.($count).':F'.($count))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		$objectSheet->getStyle('E'.($count).':F'.($count))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	
	
		//set aligment to center for that merged cell (A1 to D1)
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 
		$filename='payments_from_'.$results[0]->start_date.'_to_'.$results[0]->end_date.'.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
						 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);	
	}
	
	public function _generate_student_charges()
	{
		$this->load->model('m_finance_queries','m');
		// $p =$this->m->get_student_charges();
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$objectSheet->setTitle('Student Charges');
		$objectSheet->setCellValue('A1','Student Charges');
		$objectSheet->setCellValue('A2', 'Fullname');
		$objectSheet->setCellValue('B2', 'Total Units');
		$objectSheet->setCellValue('C2', 'Tuition Fee / Unit');
		$objectSheet->setCellValue('D2', 'Lab Fee / Unit');
		$objectSheet->setCellValue('E2', 'Total Misc Fee');
		$objectSheet->setCellValue('F2', 'Total Others Fee');
		$objectSheet->setCellValue('G2', 'Tuition Fee');
		$objectSheet->setCellValue('H2', 'Lab Fee');
		$objectSheet->setCellValue('I2', 'Less NSTP');
		$objectSheet->setCellValue('J2', 'Additional Charge');
		$objectSheet->setCellValue('K2', 'Total Charge');
			
			
		$objectSheet->getStyle('A1')->getFont()->setSize(20);
		$objectSheet->mergeCells('A1:K1');
		$objectSheet->getStyle("A2:K2")->applyFromArray(array("font" => array( "bold" => true)));
		
		$objectSheet->getColumnDimension('A')->setWidth(25);
		$objectSheet->getColumnDimension('B')->setWidth(25);
		$objectSheet->getColumnDimension('C')->setWidth(25);
		$objectSheet->getColumnDimension('D')->setWidth(25);
		$objectSheet->getColumnDimension('E')->setWidth(20);
		$objectSheet->getColumnDimension('F')->setWidth(20);
		$objectSheet->getColumnDimension('G')->setWidth(20);
		$objectSheet->getColumnDimension('H')->setWidth(20);
		$objectSheet->getColumnDimension('I')->setWidth(20);
		$objectSheet->getColumnDimension('J')->setWidth(20);
		$objectSheet->getColumnDimension('K')->setWidth(20);
			
		// $c = 3;
		// foreach($p as $p)
		// {
			// $objectSheet->setCellValue('A'.($c), $p->fullname);
			// $objectSheet->setCellValue('B'.($c), $p->total_units);
			// $objectSheet->setCellValue('C'.($c), $p->tuition_fee_per_unit);
			// $objectSheet->setCellValue('D'.($c),$p->lab_fee_per_unit);
			// $objectSheet->setCellValue('E'.($c), $p->total_misc_fee);
			// $objectSheet->setCellValue('F'.($c), $p->total_other_fee);
			// $objectSheet->setCellValue('G'.($c),$p->tuition_fee);
			// $objectSheet->setCellValue('H'.($c), $p->lab_fee);
			// $objectSheet->setCellValue('I'.($c), $p->less_nstp);
			// $objectSheet->setCellValue('J'.($c), $p->additional_charge);
			// $objectSheet->setCellValue('K'.($c), $p->total_charge);
			
			// $objectSheet->getStyle('A'.($c).':K'.($c))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
			// $objectSheet->getStyle('C'.($c).':K'.($c))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);		
			// $c++;
		// }

			
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objectSheet->getStyle('A2:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$filename='student_charges'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
						 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);
	}
	
	public function _generate_remaining_balance()
	{
		$this->load->model('m_student_totals','m');
		$p = $this->m->get_all_student_totals_remaining_balance_with_profiles();
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		ini_set('memory_limit','100M');
		ini_set('max_execution_time',60);	
		$objectSheet->setTitle('Student Remaining Balance');
		$objectSheet->setCellValue('A1','Student Remaining Balance');
		$objectSheet->setCellValue('A2', 'Name of Student');
		$objectSheet->setCellValue('B2', 'Remaining Balance');
		$objectSheet->getColumnDimension('A')->setWidth(25);
		$objectSheet->getColumnDimension('B')->setWidth(25);
			
		$c = $s = 3;
		foreach($p as $p)
		{
			$objectSheet->setCellValue('A'.($c), ucwords($p->fullname));
			$objectSheet->setCellValue('B'.($c), $p->remaining_balance);
			$c++;
		}
			
		$objectSheet->setCellValue('B'.$c,'=SUM(B3:B'.($c-1).')');
		$objectSheet->getStyle('B'.($s).':B'.($c))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		$objectSheet->getStyle('B'.($s).':B'.($c))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$objectSheet->getStyle('A1')->getFont()->setSize(20);
		$objectSheet->mergeCells('A1:b1');
		$objectSheet->getStyle("A2:D2")->applyFromArray(array("font" => array( "bold" => true)));
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objectSheet->getStyle('A2:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$filename='student_remaining_balance_'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
			
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
			
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);			
	}
	
	public function _generate_student_payments_report()
	{
		$this->load->model('m_finance_queries','m');
		$p =$this->m->all_student_payments();
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		ini_set('memory_limit','100M');
		ini_set('max_execution_time',60);	
			
		$objectSheet->setTitle('Student Payments');
		$objectSheet->setCellValue('A1','Student Payments');
		$objectSheet->setCellValue('A2', 'Name of Student');
		$objectSheet->setCellValue('B2', 'Date Of Payment');
		$objectSheet->setCellValue('C2', 'Account Recieved From Student');
		$objectSheet->setCellValue('D2', 'Old Account');
		$objectSheet->setCellValue('E2', 'total');
		$objectSheet->setCellValue('F2', 'Original Reciept Number');
			
		$objectSheet->getColumnDimension('A')->setWidth(25);
		$objectSheet->getColumnDimension('B')->setWidth(25);
		$objectSheet->getColumnDimension('C')->setWidth(25);
		$objectSheet->getColumnDimension('D')->setWidth(25);
		$objectSheet->getColumnDimension('E')->setWidth(20);
		$objectSheet->getColumnDimension('F')->setWidth(20);
		$objectSheet->getColumnDimension('G')->setWidth(20);
		$objectSheet->getColumnDimension('H')->setWidth(20);
		$objectSheet->getColumnDimension('I')->setWidth(20);
		$objectSheet->getColumnDimension('J')->setWidth(20);
		$objectSheet->getColumnDimension('K')->setWidth(20);
			
			
		$c = $s = 3;
		foreach($p as $p)
		{
			$objectSheet->setCellValue('A'.($c), $p->fullname);
			$objectSheet->setCellValue('B'.($c), $p->date_of_payment);
			$objectSheet->setCellValue('C'.($c), $p->account_recivable_student);
			$objectSheet->setCellValue('D'.($c),$p->old_account);
			$objectSheet->setCellValue('E'.($c), $p->total);
			$objectSheet->setCellValue('F'.($c), $p->or_no);		
			$c++;
		}
		$objectSheet->setCellValue('C'.$c,'=SUM(C3:C'.($c-1).')');
		$objectSheet->setCellValue('D'.$c,'=SUM(D3:D'.($c-1).')');
		$objectSheet->setCellValue('E'.$c,'=SUM(E3:E'.($c-1).')');
		$objectSheet->getStyle('A'.($s).':E'.($c))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		$objectSheet->getStyle('C'.($s).':E'.($c))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$objectSheet->getStyle('A1')->getFont()->setSize(20);
		$objectSheet->mergeCells('A1:F1');
		$objectSheet->getStyle("A2:F2")->applyFromArray(array("font" => array( "bold" => true)));
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objectSheet->getStyle('A2:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$filename='student_payments_'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);
	}
	
	public function _generate_student_deductions_report()
	{
		$this->load->model('m_student_deductions','m');
		$p =$this->m->student_deductions_with_profiles();
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		ini_set('memory_limit','100M');
		ini_set('max_execution_time',60);
		
		$objectSheet->setTitle('Student Deductions');
		
		$objectSheet->setCellValue('A2', 'Name of Student');
		$objectSheet->setCellValue('B2', 'Date Creatd');
		$objectSheet->setCellValue('C2', 'Amount Deducted from student');
		$objectSheet->setCellValue('D2', 'Remarks');
		
		$objectSheet->getColumnDimension('A')->setWidth(25);
		$objectSheet->getColumnDimension('B')->setWidth(25);
		$objectSheet->getColumnDimension('C')->setWidth(25);
		$objectSheet->getColumnDimension('D')->setWidth(30);		

		$c = $s = 3;
		$header = 'All Student Deductions From '.$p[0]->date_created.' to ';
		foreach($p as $p)
		{
			$objectSheet->setCellValue('A'.($c), ucwords($p->fullname));
			$objectSheet->setCellValue('B'.($c), $p->date_created);
			$objectSheet->setCellValue('C'.($c), $p->amount);
			$objectSheet->setCellValue('D'.($c),$p->remarks);	
			$c++;
		}
		$header .=$p->date_created;
		$objectSheet->setCellValue('A1',$header);
		$objectSheet->setCellValue('C'.$c,'=SUM(C3:C'.($c-1).')');
		$objectSheet->getStyle('C'.($s).':C'.($c))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		$objectSheet->getStyle('C'.($s).':C'.($c))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);	
		$objectSheet->getStyle('A1')->getFont()->setSize(20);
		$objectSheet->mergeCells('A1:D1');
		$objectSheet->getStyle("A2:D2")->applyFromArray(array("font" => array( "bold" => true)));
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objectSheet->getStyle('A2:D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$filename='student_deductions_'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);
	}
	
	public function _generate_tesda_by_course_report($id)
	{
		$this->load->model('M_courses','m');
		$p = $this->m->for_tesda_report_masterlist($id);
		if($p==false){
			// echo "<script>";
			// echo "alert('No record found.')";
			// echo "</script>";
			$this->session->set_flashdata('system_message', '<div class="alert alert-danger">No record found.</div>');
			redirect('tesda/tesda_by_course');
			return;
		}
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		ini_set('memory_limit','200M');
		ini_set('max_execution_time',60);
		$course = $p[0]->course;
		$objectSheet->setTitle('Student By Course');
		$objectSheet->setCellValue('A1','Student By Course: '.$course);
		$objectSheet->setCellValue('A2', 'Name of Student');
		$objectSheet->setCellValue('b2', 'Year');
			
		$objectSheet->getColumnDimension('A')->setWidth(45);
		$objectSheet->getColumnDimension('B')->setWidth(20);
		
		$c = $s = 3;
		foreach($p as $p)
		{
			$fullname = ucwords($p->name);
			$objectSheet->setCellValue('A'.($c), ucwords($fullname));
			$objectSheet->setCellValue('B'.($c), $p->year);
			$c++;
		}
		
		$objectSheet->mergeCells('A1:B1');
		$objectSheet->getStyle('A1')->getFont()->setSize(15);
		$objectSheet->getStyle("A2:B2")->applyFromArray(array("font" => array( "bold" => true)));
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objectSheet->getStyle('A2:B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$filename=$course.'_student_course_profile_'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);
	
	}

	public function _generate_student_charges2($student_charges)
	{	
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		ini_set('memory_limit','500M');
		ini_set('max_execution_time',60);
		
		$objectSheet->setTitle('Student Charges');
		$objectSheet->setCellValue('A1','Student Charges');
		
		$objectSheet->setCellValue('A2', 'Enrollment Id');
		$objectSheet->setCellValue('B2', 'Name');
		$objectSheet->setCellValue('C2', 'Course');
		$objectSheet->setCellValue('D2', 'Year Level');
		$objectSheet->setCellValue('E2', 'Tuition Fee');
		$objectSheet->setCellValue('F2', 'Misc. Fee');
		$objectSheet->setCellValue('G2', 'Additional Charges');
		$objectSheet->setCellValue('H2', 'Previous Account');
		$objectSheet->setCellValue('I2', 'Total Charge');
		
		// Set cell width
		$width = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI');
		for($x = 0;$x < count($width);$x++)
		{
			$objectSheet->getColumnDimension($width[$x])->setWidth(30);
		}
			
		$c = $s = 3;
		
		#region PRINT RECORDS
		
		if($student_charges)
		{	
			foreach($student_charges as $obj)
			{
				
				$p = $obj['student_profile'];
				
				$tuition_fee = 0;
				$total_misc_fee = 0;
				$additional_charge = 0;
				$previous_account = 0;
				$total_charge = 0;
				
				if(isset($obj['student_total'])){
					$tuition_fee = $obj['student_total']['tuition_fee'];
					$total_misc_fee = $obj['student_total']['total_misc_fee'];
					$additional_charge = $obj['student_total']['additional_charge'];
					$previous_account = $obj['student_total']['previous_account'];
					$total_charge = $obj['student_total']['total_charge'];
				}
				
				$fullname = ucwords($p->first_name.' , '.$p->middle_name.' , '.$p->last_name);
				
				$objectSheet->setCellValue('A'.($c), $obj['enrollment_id']);
				$objectSheet->setCellValue('B'.($c), $fullname);
				$objectSheet->setCellValue('C'.($c), $p->course);
				$objectSheet->setCellValue('D'.($c), $p->year);
				$objectSheet->setCellValue('E'.($c), $tuition_fee);
				$objectSheet->setCellValue('F'.($c), $total_misc_fee );
				$objectSheet->setCellValue('G'.($c),$additional_charge);
				$objectSheet->setCellValue('H'.($c),$previous_account);
				$objectSheet->setCellValue('I'.($c),$total_charge);
				$c++;
			}
		}
		
		#endregion
			
		$objectSheet->getStyle('A1')->getFont()->setSize(20);
		$objectSheet->mergeCells('A1:F1');
		$objectSheet->getStyle("A2:AI2")->applyFromArray(array("font" => array( "bold" => true)));
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objectSheet->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$filename='student_charges_'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format				
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');   
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);
	}

	public function _generate_student_payments($enrollments, $payments)
	{	
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		ini_set('memory_limit','500M');
		ini_set('max_execution_time',60);
		
		$objectSheet->setTitle('Student Payments');
		$objectSheet->setCellValue('A1','Student Payments');
		
		$objectSheet->setCellValue('A2', 'Enrollment Id');
		$objectSheet->setCellValue('B2', 'Student Name');
		$objectSheet->setCellValue('C2', 'Course');
		$objectSheet->setCellValue('D2', 'Year Level');
		$objectSheet->setCellValue('E2', 'Payment');
		$objectSheet->mergeCells('E2:G2');
		$objectSheet->setCellValue('E3', 'OR #');
		$objectSheet->setCellValue('F3', 'AMOUNT');
		$objectSheet->setCellValue('G3', 'REMARKS');
		$objectSheet->setCellValue('H3', 'DATE');
		
		
		// Set cell width
		$width = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI');
		for($x = 0;$x < count($width);$x++)
		{
			$objectSheet->getColumnDimension($width[$x])->setWidth(30);
		}
			
		$c = $s = 4;
		
		#region PRINT RECORDS
		
		if($enrollments)
		{	
			foreach($enrollments as $obj)
			{
				$objectSheet->setCellValue('A'.($c), $obj->id);
				$objectSheet->setCellValue('B'.($c), $obj->name);
				$objectSheet->setCellValue('C'.($c), $obj->course);
				$objectSheet->setCellValue('D'.($c), $obj->year);
				if(isset($payments[$obj->id])){
					foreach($payments[$obj->id] as $val){
						$objectSheet->setCellValue('E'.($c), $val->or_no);
						$objectSheet->setCellValue('F'.($c), $val->total);
						$objectSheet->setCellValue('G'.($c), $val->remarks);
						$objectSheet->setCellValue('H'.($c), date('m-d-Y', strtotime($val->date)));
						$c++;
					}
				}
				$c++;
			}
		}
		
		#endregion
			
		$objectSheet->getStyle('A1')->getFont()->setSize(20);
		$objectSheet->mergeCells('A1:F1');
		$objectSheet->getStyle("A2:AI2")->applyFromArray(array("font" => array( "bold" => true)));
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objectSheet->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$filename='student_pay_'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format				
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');   
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);
	}
	
	public function _generate_student_deductions($students, $deductions)
	{	
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		ini_set('memory_limit','500M');
		ini_set('max_execution_time',60);
		
		$objectSheet->setTitle('Student Deductions');
		$objectSheet->setCellValue('A1','Student Deductions');
		
		$objectSheet->setCellValue('A2', 'Student ID');
		$objectSheet->setCellValue('B2', 'Student Name');
		$objectSheet->setCellValue('C2', 'Course');
		$objectSheet->setCellValue('D2', 'Year Level');
		$objectSheet->setCellValue('E2', 'Deductions');
		$objectSheet->mergeCells('E2:F2');
		$objectSheet->setCellValue('E3', 'AMOUNT');
		$objectSheet->setCellValue('F3', 'REMARKS');
		
		
		// Set cell width
		$width = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI');
		for($x = 0;$x < count($width);$x++)
		{
			$objectSheet->getColumnDimension($width[$x])->setWidth(30);
		}
			
		$c = $s = 4;
		
		#region PRINT RECORDS
		
		if($students)
		{	
			foreach($students as $obj)
			{
				$objectSheet->setCellValue('A'.($c), $obj->id);
				$objectSheet->setCellValue('B'.($c), $obj->name);
				$objectSheet->setCellValue('C'.($c), $obj->course);
				$objectSheet->setCellValue('D'.($c), $obj->year);
				if(isset($deductions[$obj->studid])){
					foreach($deductions[$obj->studid] as $val){
						$objectSheet->setCellValue('E'.($c), $val->amount);
						$objectSheet->setCellValue('F'.($c), $val->remarks);
						$c++;
					}
				}
				$c++;
			}
		}
		
		#endregion
			
		$objectSheet->getStyle('A1')->getFont()->setSize(20);
		$objectSheet->mergeCells('A1:F1');
		$objectSheet->getStyle("A2:AI2")->applyFromArray(array("font" => array( "bold" => true)));
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objectSheet->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$filename='student_pay_'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format				
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');   
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);
	}
	
	public function _generate_remaining_balance_report($enrollments)
	{	
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		ini_set('memory_limit','500M');
		ini_set('max_execution_time',60);
		
		$objectSheet->setTitle('Remaining Balance');
		$objectSheet->setCellValue('A1','Remaining Balance');

		$objectSheet->setCellValue('A2', 'Enrollment ID');
		$objectSheet->setCellValue('B2', 'Student Name');
		$objectSheet->setCellValue('C2', 'Course');
		$objectSheet->setCellValue('D2', 'Year Level');
		$objectSheet->setCellValue('E2', 'Category');
		$objectSheet->setCellValue('F2', 'Tuition Fee Per Unit');
		$objectSheet->setCellValue('G2', 'Lab Fee Per Unit');
		$objectSheet->setCellValue('H2', 'Misc Fee');
		$objectSheet->setCellValue('I2', 'Total Units');
		$objectSheet->setCellValue('J2', 'Total Lab Units');
		$objectSheet->setCellValue('K2', 'Tuition Fee');
		$objectSheet->setCellValue('L2', 'Lab Fee');
		$objectSheet->setCellValue('M2', 'Additional Charges');
		$objectSheet->setCellValue('N2', 'Total Charges');
		$objectSheet->setCellValue('O2', 'Previous Account');
		$objectSheet->setCellValue('P2', 'Total Deductions');
		$objectSheet->setCellValue('Q2', 'Total Amount');
		$objectSheet->setCellValue('R2', 'Total Payment');
		$objectSheet->setCellValue('S2', 'Remaining Balance');
		
		
		// Set cell width
		$width = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI');
		for($x = 0;$x < count($width);$x++)
		{
			$objectSheet->getColumnDimension($width[$x])->setWidth(30);
		}
			
		$c = $s = 3;
		
		#region PRINT RECORDS
		
		if($enrollments)
		{	
			foreach($enrollments as $obj)
			{
			
				$student = $obj['student'];
				$student_profile = $obj['student_profile'];
				$student_total = $obj['student_total'];
				$fullname = $student_profile->last_name.', '.$student_profile->first_name.' '.$student_profile->middle_name;
				
				
				$lab_fee = $obj['lab_a_fee_total'] + $obj['lab_b_fee_total'] + $obj['lab_c_fee_total'];
				
				$student_total['remaining_balance'] = $student_total['remaining_balance'] <= 0 ? 0 : $student_total['remaining_balance'];
				
				$objectSheet->setCellValue('A'.($c), $obj['enrollment_id']);
				$objectSheet->setCellValue('B'.($c), $fullname);
				$objectSheet->setCellValue('C'.($c), $student->course);
				$objectSheet->setCellValue('D'.($c), $student->year);
				if(isset($obj['student_finance']->category2)){
					$objectSheet->setCellValue('E'.($c), $obj['student_finance']->category2);
				}			
				$objectSheet->setCellValue('F'.($c), $student_total['tuition_fee_per_unit']);
				$objectSheet->setCellValue('G'.($c), $student_total['lab_fee_per_unit']);
				$objectSheet->setCellValue('H'.($c), $student_total['total_misc_fee']);
				$objectSheet->setCellValue('I'.($c), $student_total['total_units']);
				$objectSheet->setCellValue('J'.($c), $student_total['total_lab_units']);
				$objectSheet->setCellValue('K'.($c), $student_total['tuition_fee']);
				$objectSheet->setCellValue('L'.($c), $lab_fee);
				$objectSheet->setCellValue('M'.($c), $student_total['additional_charge']);
				$objectSheet->setCellValue('N'.($c), $student_total['total_charge']);
				$objectSheet->setCellValue('O'.($c), $student_total['previous_account']);
				$objectSheet->setCellValue('P'.($c), $student_total['total_deduction']);
				$objectSheet->setCellValue('Q'.($c), $student_total['total_amount']);
				$objectSheet->setCellValue('R'.($c), $student_total['total_payment']);
				$objectSheet->setCellValue('S'.($c), $student_total['remaining_balance']);
				$c++;
			}
		}
		
		#endregion
			
		$objectSheet->getStyle('A1')->getFont()->setSize(20);
		$objectSheet->mergeCells('A1:F1');
		$objectSheet->getStyle("A2:AI2")->applyFromArray(array("font" => array( "bold" => true)));
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objectSheet->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$filename='remaining_balance_'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format				
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');   
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);
	}

	public function _generate_ched_report($data)
	{	
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		ini_set('memory_limit','500M');
		ini_set('max_execution_time',60);
		
		$years = $data['years']->year;
		$semesters = $data['semesters']->name;
		$course = $data['courses']->course;
		$title = 'Year : '.$years.' | Semester : | '.$semesters.' | Course : '.$course;
		$filename = $years.'_'.$semesters.'_'.$course.'_'.date('m_d_y_h-i-s',time()).'.xls'; //save our workbook as this file name
		$objectSheet->setTitle("Ched Report");
		$objectSheet->setCellValue('A1',$title);

		//SET COLUMN HEADER
		$objectSheet->setCellValue('A2', 'Student Name');
		$a = 'A'; 
		for($i=1;$i<=$data['no_subjects'];$i++)
		{
			$row = ++$a.'2';
			$objectSheet->setCellValue($row, 'Subject Code');
			$row = ++$a.'2';
			$objectSheet->setCellValue($row, 'Earned Units');
		} 
		$row = ++$a.'2';
		$objectSheet->setCellValue($row, 'Total Units');
		
		$c = $s = 3;
		
		//PRINT RECORDS
		$students = $data['students'];
		$studentsubjects = $data['studentsubjects'];
		if($students)
		{
			foreach($students as $student)
			{	
				$total_units = 0;
				$used_row = 0;
				
				$objectSheet->setCellValue('A'.($c), $student->name);
				$b = 'A';
				if(isset($studentsubjects[$student->id]) && is_array($studentsubjects[$student->id]))
				{
					foreach($studentsubjects[$student->id] as $subject)
					{
						if($subject)
						{	
							$total_units += $subject->units;
							$used_row++;
							
							$objectSheet->setCellValue(++$b.($c), $subject->code);
							$objectSheet->setCellValue(++$b.($c), $subject->units);
						}
					}
				}
				
				//CREATE BLANK
				for($x = $used_row+1; $x <= $data['no_subjects']; $x++)
				{
					$b++;
					$b++;
				}
				
				$objectSheet->setCellValue(++$b.($c), $total_units);
				$c++;
			}
			
		}
		
		// Set cell width
		$width = array('B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI');
		for($x = 0;$x < count($width);$x++)
		{
			$objectSheet->getColumnDimension($width[$x])->setWidth(15);
		}
		$width = array('A');
		for($x = 0;$x < count($width);$x++)
		{
			$objectSheet->getColumnDimension($width[$x])->setWidth(45);
		}
		$c = $s = 3;
		
		#region PRINT RECORDS
		
		
		#endregion
			
		$objectSheet->getStyle('A1')->getFont()->setSize(15);
		$objectSheet->mergeCells('A1:F1');
		$objectSheet->getStyle("A2:AI2")->applyFromArray(array("font" => array( "bold" => true)));
		$objectSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$objectSheet->getStyle('A2:H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format				
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');   
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);
	}

	public function _generate_student_gradeslip($data)
	{
		$students = $data['students'];
		$studentsubjects = $data['studentsubjects'];
		
		$this->load->library('excel');
		$objectSheet = $this->excel->getActiveSheet();
		ini_set('memory_limit','500M');
		ini_set('max_execution_time',60);
		
		$n = 0;
		
		$width = array('A','B','C','D','E');
		for($x = 0;$x < count($width);$x++)
		{
			if($width[$x] == 'C')
				$objectSheet->getColumnDimension($width[$x])->setWidth(35);
			else
				$objectSheet->getColumnDimension($width[$x])->setWidth(20);
			
		}
		
		foreach($students as $student)
		{
			$objectSheet->setTitle('Student Grade Slip');
			$objectSheet->setCellValue('A'.++$n,$this->setting->school_name);  
			$objectSheet->mergeCells('A'.$n.':F'.$n);
			$objectSheet->getStyle('A'.$n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objectSheet->getStyle('A'.$n)->getFont()->setSize(20); 
			$objectSheet->mergeCells('A'.$n.':F'.$n);
			$objectSheet->getStyle('A'.$n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objectSheet->setCellValue('A'.++$n,$this->setting->school_address); 
			$objectSheet->mergeCells('A'.$n.':F'.$n);
			$objectSheet->getStyle('A'.$n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objectSheet->setCellValue('A'.++$n,$this->setting->school_telephone); 
			$objectSheet->mergeCells('A'.$n.':F'.$n);
			$objectSheet->getStyle('A'.$n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			$objectSheet->setCellValue('A'.++$n,$this->setting->email); 
			$objectSheet->mergeCells('A'.$n.':F'.$n);
			$objectSheet->getStyle('A'.$n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			// $objectSheet->getStyle('A2:A4')->getFont()->setSize(12);
			
			$n++;
			$objectSheet->setCellValue('A'.++$n,'Grade Slip');
			$objectSheet->getStyle('A'.$n)->getFont()->setBold(true);
			$objectSheet->mergeCells('A'.$n.':F'.$n);
			$objectSheet->getStyle('A'.$n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$n+=2;
			
			$objectSheet->setCellValue('A'.$n,"Time :  ".date('g:h A'));
			$objectSheet->setCellValue('B'.$n,"Date :  ".date('M d, Y'));
			$objectSheet->setCellValue('C'.$n,"Term :  ".$student->semester);
			$objectSheet->setCellValue('D'.$n,"SY : ".$student->sy_from."-".$student->sy_to);
			$objectSheet->setCellValue('E'.$n,"Admission Status : ".$student->status);
			
			$objectSheet->setCellValue('A'.++$n,'ID No : '.$student->studid); 
			$objectSheet->getStyle('A'.$n)->getFont()->setBold(true);
			
			$objectSheet->setCellValue('B'.$n,'Student Name : '.strtoupper($student->name));
			$objectSheet->getStyle('B'.$n)->getFont()->setBold(true);
			
			$objectSheet->setCellValue('A'.++$n,'Course : '.strtoupper($student->course));
			$objectSheet->getStyle('A'.$n)->getFont()->setBold(true);
			
			$n++;
			$objectSheet->setCellValue('A'.++$n,'Subject Code'); 
			$objectSheet->getStyle('A'.$n.':E'.$n)->getFont()->setBold(true);
			
			$objectSheet->setCellValue('B'.$n,'Section Code');
			$objectSheet->setCellValue('C'.$n,'Subject Description');
			$objectSheet->setCellValue('D'.$n,'Final Grade');
			$objectSheet->setCellValue('E'.$n,'Final Remarks');
			$n++;
			
			if(isset($studentsubjects[$student->id]) && is_array($studentsubjects[$student->id]))
			{
				foreach($studentsubjects[$student->id] as $sub)
				{
					$objectSheet->setCellValue('A'.$n,$sub->sc_id);
					$objectSheet->setCellValue('B'.$n,$sub->code);
					$objectSheet->setCellValue('C'.$n,$sub->subject);
					$objectSheet->setCellValue('D'.$n,$sub->value);
					$objectSheet->setCellValue('E'.$n,$sub->remarks);
					$n++;
				}
			}
			
			$n++;
			$objectSheet->setCellValue('A'.$n,$this->session->userdata['username']);
			$objectSheet->getStyle('A'.++$n)->getFont()->setSize(12);
			
			$n += 3;
		}
		
		$filename = "Student_grade_slip_".date('m_d_y_h-i-s',time()).'.xls';
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format				
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');   
		@ob_end_clean(); 
		//force user to download the Excel file without writing it to server's HD 
		$objWriter->save('php://output'); 
		@$objectSheet->disconnectWorksheets(); 
		unset($objectSheet);
	}
}