<?php

	function print_html($enrollment,$student_total,$student_subjects,$studentfinance,$studentfees,$gmdate){
		$ci =& get_instance();


		$html = '
		<head>
		<style>

		html, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p, blockquote, pre,a, abbr, acronym, address, big, cite, code,del, dfn, em, img, ins, kbd, q, s, samp,small, strike, strong, sub, sup, tt, var,b, u, i, center,dl, dt, dd, ol, ul, li,fieldset, form, label, legend,table, caption, tbody, tfoot, thead, tr, th, td,article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary,time, mark, audio, video 
		{
			margin: 0;
			padding: 0;
			border: 0;
			font-size: 10px;
			font: inherit;
			vertical-align: top;
		}

		/* HTML5 display-role reset for older browsers */
		article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section 
		{
			display: block;
		}

		td
		{
		padding: 3px;
		}

		th
		{
		border-bottom: 1px solid #000;
		font-weight: bold;
		font-size:10px;
		padding: 3px;
		margin: 0px;
		text-align: center;
		}

		td.title
		{
		border-top: 1px solid #000;
		border-right: 1px solid #000;
		border-left: 1px solid #000;
		font-weight: bold;
		}

		td.title2
		{
		border-bottom: #000 1px solid;
		}

		</style>
		</head>
		<body>

		<div>

		<table style="height:1238px; width:806px;">
		<tr>
		<td style="height:600px; text-align:top;" valign="top">

		<div>
		<table width="600px" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td style="font-weight: bold;" colspan="7">
		CERTIFICATE OF MATRICULATION
		</td>
		</tr>
		<tr>
		<td colspan="2" style="font-weight: bold; background-color: #EEEEEE; text-align:center; border-top: #000 1px solid; border-bottom: #000 1px solid;">
		STUDENT\'S COPY
		</td>
		<td>
		&nbsp;
		</td>
		<td>
		&nbsp;
		</td>
		<td>
		&nbsp;
		</td>
		<td class="title title2">
		SYSTEM ID No.
		</td>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid; border-bottom: #000 1px solid;">'.
		$enrollment->login
		.'</td>
		</tr>
		<tr>
		<td colspan="7" style="line-height:0; height: 4px;">
		</td>
		</tr>
		<tr>
		<td class="title">
		STUDENT No.
		</td>
		<td colspan="3" style="border-top: #000 1px solid; border-right: #000 1px solid;">
		</td>
		<td>
		</td>
		<td class="title">
		COLLEGE
		</td>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid;">
		</td>
		</tr>
		<tr>
		<td class="title">
		STUDENT NAME
		</td>
		<td colspan="3" style="border-top: #000 1px solid; border-right: #000 1px solid; text-transform:capitalize;">'.
		$enrollment->last_name .', '. $enrollment->first_name .' '. $enrollment->middle_name
		.'</td>
		<td>
		</td>
		<td class="title">
		COURSE
		</td>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid;">'.
		$enrollment->course
		.'</td>
		</tr>
		<tr>
		<td class="title">
		CASHIER\'S CODE
		</td>
		<td colspan="3" style="border-top: #000 1px solid; border-right: #000 1px solid; text-transform:capitalize;">'.
		 $ci->session->userdata['username']
		.'</td>
		<td>
		</td>
		<td class="title">
		MAJOR
		</td>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid;">
		</td>
		</tr>
		<tr>
		<td class="title title2" style="width:150px;">
		DATE
		</td>
		<td style="width:135px; border-top: #000 1px solid; border-bottom: #000 1px solid;">
		'.
		date("F d, Y",$gmdate)
		.'</td>
		<td class="title title2" style="width:50px; text-align:center;">
		TIME
		</td>
		<td style="width:105px; border-top: #000 1px solid; border-right: #000 1px solid; border-bottom: #000 1px solid;">
		'.
		date("h:i:s A",$gmdate)
		.'</td>
		<td style="width:5px;">
		</td>
		<td class="title title2" style="width:100px;">
		S.Y./SEMESTER
		</td>
		<td style="width:250px; border-top: #000 1px solid; border-right: #000 1px solid; border-bottom: #000 1px solid;">
		'.
		$enrollment->sy_from .' - '. $enrollment->sy_to .' / '. $enrollment->name
		.'</td>
		</tr>
		<tr>
		<td colspan="7" style="line-height:0; height: 4px;">
		</td>
		</tr>
		</table>
		</div>

		<div>
		<table width="600px" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td class="title" style="text-align:center; width:340px;">
		ENROLLED SUBJECTS/CLASS SCHEDULE
		</td>
		<td style="width:5px; padding:0px;"></td>
		<td class="title" style="text-align:center; width:255px;">
		MISCELLANEOUS & OTHER FEES
		</td>
		</tr>
		<tr>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid; border-left: #000 1px solid; padding:0px;">

		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<th>Subject Code</th>
		<th>Subject Description</th>
		<th>Units</th>
		<th>Time</th>
		<th>Day</th>
		</tr>';

		foreach($student_subjects as $s)
		{
		$html .= '<tr><td>'.$s->code.'</td><td>'.$s->subject.'</td><td>'.$s->units.'</td><td>'.$s->time.'</td><td>'.$s->day.'</td></tr>';
		}

		$html .= '
		</table>

		</td>
		<td style="width:5px;"></td>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid; border-left: #000 1px solid; padding:0px;">

		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td style="width:100px; font-weight:bold; text-align:center; border-right: #000 1px solid;">
		AMOUNT
		</td>
		<td style="width:155px; font-weight:bold; text-align:center;">
		DESCRIPTION
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->total_misc_fee,2,'.',' ')
		.'</td>
		<td style="width:155px;">
		MISCELLANEOUS FEE
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">
		&nbsp;
		</td>
		<td style="width:155px; font-weight:bold;">
		OTHER FEES
		</td>
		</tr>';

		foreach($studentfees as $sf):
			if($sf->is_other == 1){
			$html .= '<tr>';
				if(strtolower($sf->name) != "tuition fee per unit" || strtolower($sf->name) != "laboratory fee per unit" || strtolower($sf->name) != "rle"){
					$html .= '<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.number_format($sf->value,2,'.',' ').'</td><td style="width:155px;">'.$sf->name.'</td>';
				}
			$html .= '</tr>';
			}
		endforeach;

		$html .= '</table>

		</td>
		</tr>
		<tr>
		<td class="title" style="text-align:center; width:340px;">
		TOTAL NUMBER OF UNITS - '.
		number_format($student_total->total_units,2,'.',' ')
		.'</td>
		<td style="width:5px;"></td>
		<td class="title" style="text-align:center; width:255px;">
		COMPUTATION
		</td>
		</tr>
		<tr>
		<td class="title" style="text-align:center; width:340px;">
		CERTIFICATION
		</td>
		<td style="width:5px;"></td>
		<td style="border-right: #000 1px solid; border-top: #000 1px solid; border-left: #000 1px solid; padding:0px;">

		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->tuition_fee + $student_total->lab_fee,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		TUITION FEE
		</td>
		</tr>
		</table>

		</td>
		</tr>
		<tr>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid; border-left: #000 1px solid; width:340px;">
		I hereby certify that I have read and fully understand the terms and conditions of my enrollment in Dr. Yanga\'s Colleges, Inc. written at the back of this Certificate of Matriculation. Furthermore, I hereby agree to pay the total payable fees based on the schedule of payment below:
		</td>
		<td style="width:5px;"></td>
		<td style="border-right: #000 1px solid; border-left: #000 1px solid; padding:0px;">

		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->total_misc_fee,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		MISCELANEOUS FEE
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->total_other_fee,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		OTHER FEES
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->total_rle,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		RELATED EXPERIENCE LEARNING
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->total_deduction + $student_total->total_payment,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		LESS: DISCOUNT
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">
		&nbsp;
		</td>
		<td style="width:155px; font-weight:bold;">
		&nbsp;
		</td>
		</tr>
		</table>

		</td>
		</tr>
		<tr>
		<td style="border-right: #000 1px solid; border-bottom: #000 1px solid; border-left: #000 1px solid; width:340px; font-weight:bold;">
		SIGNATURE OF STUDENT
		</td>
		<td style="width:5px;"></td>
		<td style="border-right: #000 1px solid; border-bottom: #000 1px solid; border-left: #000 1px solid; padding:0px;">

		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid; font-weight:bold;">'.
		number_format($student_total->remaining_balance,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		TOTAL PAYABLE FEES
		</td>
		</tr>
		</table>

		</td>
		</tr>
		</table>
		</div>

		</td>
		</tr>
		<tr>
		<td style="height:600px; text-align:top;">

		<div>
		<table width="600px" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td style="font-weight: bold;" colspan="7">
		CERTIFICATE OF MATRICULATION
		</td>
		</tr>
		<tr>
		<td colspan="2" style="font-weight: bold; background-color: #EEEEEE; text-align:center; border-top: #000 1px solid; border-bottom: #000 1px solid;">
		FINANCE COPY
		</td>
		<td>
		&nbsp;
		</td>
		<td>
		&nbsp;
		</td>
		<td>
		&nbsp;
		</td>
		<td class="title title2">
		SYSTEM ID No.
		</td>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid; border-bottom: #000 1px solid;">'.
		$enrollment->login
		.'</td>
		</tr>
		<tr>
		<td colspan="7" style="line-height:0; height: 4px;">
		</td>
		</tr>
		<tr>
		<td class="title">
		STUDENT No.
		</td>
		<td colspan="3" style="border-top: #000 1px solid; border-right: #000 1px solid;">
		</td>
		<td>
		</td>
		<td class="title">
		COLLEGE
		</td>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid;">
		</td>
		</tr>
		<tr>
		<td class="title">
		STUDENT NAME
		</td>
		<td colspan="3" style="border-top: #000 1px solid; border-right: #000 1px solid; text-transform:capitalize;">'.
		$enrollment->last_name .', '. $enrollment->first_name .' '. $enrollment->middle_name
		.'</td>
		<td>
		</td>
		<td class="title">
		COURSE
		</td>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid;">'.
		$enrollment->course
		.'</td>
		</tr>
		<tr>
		<td class="title">
		CASHIER\'S CODE
		</td>
		<td colspan="3" style="border-top: #000 1px solid; border-right: #000 1px solid; text-transform:capitalize;">'.
		 $ci->session->userdata['username']
		.'</td>
		<td>
		</td>
		<td class="title">
		MAJOR
		</td>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid;">
		</td>
		</tr>
		<tr>
		<td class="title title2" style="width:150px;">
		DATE
		</td>
		<td style="width:135px; border-top: #000 1px solid; border-bottom: #000 1px solid;">
		'.
		date("F d, Y",$gmdate)
		.'</td>
		<td class="title title2" style="width:50px; text-align:center;">
		TIME
		</td>
		<td style="width:105px; border-top: #000 1px solid; border-right: #000 1px solid; border-bottom: #000 1px solid;">
		'.
		date("h:i:s A",$gmdate)
		.'</td>
		<td style="width:5px;">
		</td>
		<td class="title title2" style="width:100px;">
		S.Y./SEMESTER
		</td>
		<td style="width:250px; border-top: #000 1px solid; border-right: #000 1px solid; border-bottom: #000 1px solid;">
		'.
		$enrollment->sy_from .' - '. $enrollment->sy_to .' / '. $enrollment->name
		.'</td>
		</tr>
		<tr>
		<td colspan="7" style="line-height:0; height: 4px;">
		</td>
		</tr>
		</table>
		</div>

		<div>
		<table width="600px" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td class="title" style="text-align:center; width:340px;">
		ENROLLED SUBJECTS/CLASS SCHEDULE
		</td>
		<td style="width:5px; padding:0px;"></td>
		<td class="title" style="text-align:center; width:255px;">
		MISCELLANEOUS & OTHER FEES
		</td>
		</tr>
		<tr>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid; border-left: #000 1px solid; padding:0px;">

		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<th>Subject Code</th>
		<th>Subject Description</th>
		<th>Units</th>
		<th>Time</th>
		<th>Day</th>
		</tr>';

		foreach($student_subjects as $s)
		{
		$html .= '<tr><td>'.$s->code.'</td><td>'.$s->subject.'</td><td>'.$s->units.'</td><td>'.$s->time.'</td><td>'.$s->day.'</td></tr>';
		}

		$html .= '
		</table>

		</td>
		<td style="width:5px;"></td>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid; border-left: #000 1px solid; padding:0px;">

		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td style="width:100px; font-weight:bold; text-align:center; border-right: #000 1px solid;">
		AMOUNT
		</td>
		<td style="width:155px; font-weight:bold; text-align:center;">
		DESCRIPTION
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->total_misc_fee,2,'.',' ')
		.'</td>
		<td style="width:155px;">
		MISCELLANEOUS FEE
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">
		&nbsp;
		</td>
		<td style="width:155px; font-weight:bold;">
		OTHER FEES
		</td>
		</tr>';

		foreach($studentfees as $sf):
			if($sf->is_other == 1){
			$html .= '<tr>';
				if(strtolower($sf->name) != "tuition fee per unit" || strtolower($sf->name) != "laboratory fee per unit" || strtolower($sf->name) != "rle"){
					$html .= '<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.number_format($sf->value,2,'.',' ').'</td><td style="width:155px;">'.$sf->name.'</td>';
				}
			$html .= '</tr>';
			}
		endforeach;

		$html .= '</table>

		</td>
		</tr>
		<tr>
		<td class="title" style="text-align:center; width:340px;">
		TOTAL NUMBER OF UNITS - '.
		number_format($student_total->total_units,2,'.',' ')
		.'</td>
		<td style="width:5px;"></td>
		<td class="title" style="text-align:center; width:255px;">
		COMPUTATION
		</td>
		</tr>
		<tr>
		<td class="title" style="text-align:center; width:340px;">
		CERTIFICATION
		</td>
		<td style="width:5px;"></td>
		<td style="border-right: #000 1px solid; border-top: #000 1px solid; border-left: #000 1px solid; padding:0px;">

		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->tuition_fee + $student_total->lab_fee,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		TUITION FEE
		</td>
		</tr>
		</table>

		</td>
		</tr>
		<tr>
		<td style="border-top: #000 1px solid; border-right: #000 1px solid; border-left: #000 1px solid; width:340px;">
		I hereby certify that I have read and fully understand the terms and conditions of my enrollment in Dr. Yanga\'s Colleges, Inc. written at the back of this Certificate of Matriculation. Furthermore, I hereby agree to pay the total payable fees based on the schedule of payment below:
		</td>
		<td style="width:5px;"></td>
		<td style="border-right: #000 1px solid; border-left: #000 1px solid; padding:0px;">

		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->total_misc_fee,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		MISCELANEOUS FEE
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->total_other_fee,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		OTHER FEES
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->total_rle,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		RELATED EXPERIENCE LEARNING
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">'.
		number_format($student_total->total_deduction + $student_total->total_payment,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		LESS: DISCOUNT
		</td>
		</tr>
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid;">
		&nbsp;
		</td>
		<td style="width:155px; font-weight:bold;">
		&nbsp;
		</td>
		</tr>
		</table>

		</td>
		</tr>
		<tr>
		<td style="border-right: #000 1px solid; border-bottom: #000 1px solid; border-left: #000 1px solid; width:340px; font-weight:bold;">
		SIGNATURE OF STUDENT
		</td>
		<td style="width:5px;"></td>
		<td style="border-right: #000 1px solid; border-bottom: #000 1px solid; border-left: #000 1px solid; padding:0px;">

		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td style="width:100px; text-align:right; border-right: #000 1px solid; font-weight:bold;">'.
		number_format($student_total->remaining_balance,2,'.',' ')
		.'</td>
		<td style="width:155px; font-weight:bold;">
		TOTAL PAYABLE FEES
		</td>
		</tr>
		</table>

		</td>
		</tr>
		</table>
		</div>

		</td>
		</tr>
		</table>

		</div>


		</body>
		';
		return $html;
	}
	
	function _css(){
		$html = "
			<style type='text/css'>
				#report_container{
					font-family: Courier New;
					left-margin: 150px;
				}
				
				.table{
					font-size:8pt;
				}
				
				.school_name{
					font-size:13pt;
					font-weight:bold;
				}
				.title{
					font-size:11pt;
				}
				.subtitle{
					font-size:8pt;
				}
				th{
					border-top: thin solid black;
					border-bottom: thin solid black;
					text-align: left;
				}
				
				.line_top td{
					border-top: thin solid black;
				}
			</style>
		";
		
		return $html;
	}
	
	function _html_group_payments($start_date, $end_date, $data, $type = ""){
	
		$ci =& get_instance();
		
		$school_name = $ci->setting->school_name;
		
		$title = "Payment Record Report of $type";
		$subtitle = "Date From : " . date('m-d-Y', strtotime($start_date))." To : ".date('m-d-Y', strtotime($end_date));
		
		$html ="<html>";
		$html .="<head>";
		$html .="<title>$title</title>";
		$html .= _css(); //GET CSS
		$html .="</head>";
		$html .="<body>";
		$html .="<div id='report_container'>";
		$html .= "
			<div class='school_name'>{$school_name}</div>
			<div class='title'>{$title}</div>
			<div class='subtitle'>{$subtitle}</div><br/>
			<table class='table'>
			<tr>
				<th>#</th>
				<th>Student Name</th>
				<th>OR #</th>
				<th>GROUP OR #</th>
				<th>Remarks</th>
				<th>Amount</th>
			</tr>
		";
		
		if($data){
		$ctr = 0;
		foreach($data as $obj){
			$ctr++;
			$html .= "<tr>
					<td>".$ctr.".</td>
					<td>".$obj->name."</td>
					<td>".$obj->or_no."</td>
					<td>".$obj->group_or_no."</td>
					<td>".$obj->remarks."</td>
					<td>".$obj->account_recivable_student."</td>
				</tr>";
		}
		}
		$html .= "</table></div>";
		$html .= "</body>";
		$html .= "</html>";
		// vd(htmlspecialchars($html));
		return $html;
	}
	
	function _html_borrow_items($data)
	{
		$ci =& get_instance();
		
		$school_name = $ci->setting->school_name;
		
		$title = "Borrowed Items Report";
		$subtitle = "Date Printed : ".date('m-d-Y g:h:s');
		
		$borrow_items = $data['borrow_items'];
		$demands_return = $data['demands_return'];
		$demands_return_lost = $data['demands_return_lost'];
		
		$html ="<html>";
		$html .="<head>";
		$html .="<title>$title</title>";
		$html .= _css(); //GET CSS
		$html .="</head>";
		$html .="<body>";
		$html .="<div id='report_container'>";
		$html .= "
			<div class='school_name'>{$school_name}</div>
			<div class='title'>{$title}</div>
			<div class='subtitle'>{$subtitle}</div><br/>
			 <div>
				<label>Borrow No.</label> : <label class = 'label label-info'>".$borrow_items->borrow_no."</label><br/>
				<label>Date Borrowed</label> : <label class = 'label label-info'>".$borrow_items->date."</label><br/>
				<label>Borrower</label> : <label class = 'label label-info'>".$borrow_items->name."</label><br/>
				<label>Items</label> : <label class = 'label label-info'>".$borrow_items->item."</label><br/>
				<label>Unit Borrowed</label> : <label class = 'label label-info'>".$borrow_items->unit."</label><br/>
			 </div>
		";
		
		$html .= "<br/>
			 <table width='100%'>
				<tr>
					<td colspan='3' style='text-align:left'>Item Return</td>
				</tr>
				<tr>
					<th style='text-align:left'>Date</th>
					<th style='text-align:left'>Quantity</th>
					<th style='text-align:left'>Remarks</th>
				</tr>";
				if($demands_return){
					foreach($demands_return as $obj)
						$html .= "<tr>
							<td>$obj->date_return</td>
							<td>$obj->unit_return</td>
							<td>$obj->remarks</td>
						</tr>";
				}
			 $html .= "</table><br/>
			  <table width='100%'>
				<tr>
					<td colspan='4' style='text-align:left'>Item Lost/Damage Return</td>
				</tr>
				<tr>
					<th style='text-align:left;border-top: thin solid black;'>Date</th>
					<th style='text-align:left'>Quantity</th>
					<th style='text-align:left'>Category</th>
					<th style='text-align:left'>Remarks</th>
				</tr>";
				if($demands_return_lost)
				{
					foreach($demands_return_lost as $obj){
						$html .= "<tr>
							<td>$obj->date_return</td>
							<td>$obj->unit_return</td>
							<td>$obj->category</td>
							<td>$obj->remarks</td>
						</tr>";
					}
				}
			 $html .= "</table>";
		
		return $html;
	}
	
	function _html_student_scholars($data)
	{
		$ci =& get_instance();
		$sy = $ci->open_semester->year_from .' - '.$ci->open_semester->year_to;
		$semester = $ci->open_semester->name;
		$school_name = $ci->setting->school_name;
		
		$title = "Student Scholar Report";
		$subtitle = "Date Printed : ".date('m-d-Y g:h:s');
		
		$demands_return = $data['search'];
		// $demands_return = null;
		
		$html ="<html>";
		$html .="<head>";
		$html .="<title>$title</title>";
		$html .= _css(); //GET CSS
		$html .="</head>";
		$html .="<body>";
		$html .="<div id='report_container'>";
		$html .= "
			<div class='school_name'>{$school_name}</div>
			<div class='title'>{$title}</div>
			<div class='subtitle'>{$semester}   of  {$sy}</div>
			<div class='subtitle'>{$subtitle}</div><br/>
		";
		
		$html .= "<br/>
			 <table width='100%'>
				<tr>
					<th style='text-align:left'>Student ID</th>
					<th style='text-align:left'>Name</th>
					<th style='text-align:left'>Year</th>
					<th style='text-align:left'>Course</th>
				</tr>";
				if($demands_return){
					foreach($demands_return as $obj)
					{
						$html .= "<tr>
							<td>$obj->studid</td>
							<td>$obj->name</td>
							<td>$obj->year</td>
							<td>$obj->course</td>
						</tr>";
					}
					$html .= "<tr class='line_top'>
								<td colspan='3' style='text-align:right'><b>Total Scholar</b></td>
								<td><b>".$data['total_rows']."</b></td>
							</tr>";
				}
			 $html .= "</table>";
		
		return $html;
	}
	
	function _html_nstp_students($data)
	{
		$ci =& get_instance();
		$sy = $ci->open_semester->year_from .' - '.$ci->open_semester->year_to;
		$semester = $ci->open_semester->name;
		$school_name = $ci->setting->school_name;
		
		$title = "NSTP Students Report";
		$subtitle = "Date Printed : ".date('m-d-Y g:h:s');
		
		$demands_return = $data['search'];
		// $demands_return = null;
		
		$html ="<html>";
		$html .="<head>";
		$html .="<title>$title</title>";
		$html .= _css(); //GET CSS
		$html .="</head>";
		$html .="<body>";
		$html .="<div id='report_container'>";
		$html .= "
			<div class='school_name'>{$school_name}</div>
			<div class='title'>{$title}</div>
			<div class='subtitle'>{$semester}   of  {$sy}</div>
			<div class='subtitle'>{$subtitle}</div><br/>
		";
		
		$html .= "<br/>
			 <table width='100%'>
				<tr>
					<th style='text-align:left'>Student ID</th>
					<th style='text-align:left'>Name</th>
					<th style='text-align:left'>Year</th>
					<th style='text-align:left'>Course</th>
				</tr>";
				if($demands_return){
					foreach($demands_return as $obj)
					{
						$html .= "<tr>
							<td>$obj->studid</td>
							<td>$obj->name</td>
							<td>$obj->year</td>
							<td>$obj->course</td>
						</tr>";
					}
					$html .= "<tr class='line_top'>
								<td colspan='3' style='text-align:right'><b>Total NSTP Students</b></td>
								<td><b>".$data['total_rows']."</b></td>
							</tr>";
				}
			 $html .= "</table>";
		
		return $html;
	}
	
	function _html_dropped_students($data)
	{
		$ci =& get_instance();
		$sy = $ci->open_semester->year_from .' - '.$ci->open_semester->year_to;
		$semester = $ci->open_semester->name;
		$school_name = $ci->setting->school_name;
		
		$title = "Dropped Students Report";
		$subtitle = "Date Printed : ".date('m-d-Y g:h:s');
		
		$demands_return = $data['search'];
		// $demands_return = null;
		
		$html ="<html>";
		$html .="<head>";
		$html .="<title>$title</title>";
		$html .= _css(); //GET CSS
		$html .="</head>";
		$html .="<body>";
		$html .="<div id='report_container'>";
		$html .= "
			<div class='school_name'>{$school_name}</div>
			<div class='title'>{$title}</div>
			<div class='subtitle'>{$semester}   of  {$sy}</div>
			<div class='subtitle'>{$subtitle}</div><br/>
		";
		
		$html .= "<br/>
			 <table width='100%'>
				<tr>
					<th style='text-align:left'>Student ID</th>
					<th style='text-align:left'>Name</th>
					<th style='text-align:left'>Year</th>
					<th style='text-align:left'>Enrollment Date</th>
				</tr>";
				if($demands_return){
					foreach($demands_return as $obj)
					{
						$html .= "<tr>
							<td>$obj->studid</td>
							<td>$obj->name</td>
							<td>$obj->year</td>
							<td>$obj->created_at</td>
						</tr>";
					}
					$html .= "<tr class='line_top'>
								<td colspan='3' style='text-align:right'><b>Total Dropped Students</b></td>
								<td><b>".$data['total_rows']."</b></td>
							</tr>";
				}
			 $html .= "</table>";
		
		return $html;
	}
	
	function _css_grade_slip($per_page = false)
	{
		$fontsize = 7;
		if($per_page)
		{
			switch($per_page)
			{
				case 3:
					$fontsize = '7';
				break;
					
				case 2:
					$fontsize = '8';
				break;
				
				case 1:
					$fontsize = '8';
				break;
				
				default:
					$fontsize = '7';
				break;
			}
		}
		
		$html .= "
						<style type='text/css'>
							.maindiv, table{
								font-family : arial;
								font-size : {$fontsize}pt;
							}
							.maindiv{
								
							}
							
							.mydiv{
								width : 100%;
								float : left;
							}
							
							.header_title{
								
							}
							
							.grade_slip{
								
							}
							
							.sub_title{
								
							}
							
							.subjects{
								
							}
							
							.center, .center span, .center p {
								text-align:center;
							}
							
						</style>
					";
		return $html;
	}
	
	
	function _html_grade_slip($students, $subjects, $per_page)
	{
		$ci =& get_instance();
		$sy = $ci->open_semester->year_from .' - '.$ci->open_semester->year_to;
		
		$base_url = base_url();
		
		$height = (100 / (int)$per_page) - 1;
		for($x = 0; $x <= $per_page-1; $x++)
		{
			$html .= "
				<div class='maindiv' style='height: {$height}%; width: 100%; float:left;'>";
					$student = $students[$x];
					
						$html.=	"
								<div class='header_title mydiv' >
									<div class='center'>
											<span class='school_name'>
												<img style='width:45px;height:45px;' src='{$base_url}{$ci->setting->logo}'/>
												{$ci->setting->school_name}
											</span><br/>
											<span>{$ci->setting->school_address}</span><br/>
											<span>{$ci->setting->school_telephone}</span><br/>
											<span>{$ci->setting->email}</span><br/>
									</div>
								</div>
								
								<div class='grade_slip mydiv center'>
									<p>Grade Slip</p>
								</div>
								
								<div class='sub_title mydiv'>
									<table><tr>
										<td style='width:20%;'>Time : &nbsp; ".date('g:h A')."</td>
										<td style='width:20%;'>Date : &nbsp; ".date('M d, Y')."</td>
										<td style='width:20%;'>Term : &nbsp; ".$student->semester."</td>
										<td style='width:20%;'>SY : &nbsp; ".$student->sy_from."-".$student->sy_to."</td>
										<td style='width:20%;'>Admission Status : &nbsp; ".$student->status."</td>
									</tr></table>
								</div>
								
								<div class='sub_title mydiv'>
									<table><tr>
										<td style='width:20%;'><b>ID Number : &nbsp; ".$student->studid."</b></td>
										<td style='width:20%;text-align:right;'><b>Student Name : &nbsp; ".strtoupper($student->name)."</b></td>
									</tr></table>
								</div>
								
								<div class='grade_slip mydiv center'>
									<table><tr>
										<td style='width:20%;'><b>Course : &nbsp; ".$student->course."</b></td>
									</tr></table>
								</div>
								
								<div class='subjects mydiv'>
									<table width='100%'>
										<tr>
											<th>Subject Code</th>
											<th>Section Code</th>
											<th>Subject Description</th>
											<th>Final Grade</th>
											<th>Final Remarks</th>
										</tr>";
										// vd($subjects[$student->id]);
										if(isset($subjects[$student->id]) && is_array($subjects[$student->id])){
											
											foreach($subjects[$student->id] as $sub):
									// vd($sub);		
									$html .= "
												<tr>
													<td>{$sub->sc_id}</td>
													<td>{$sub->code}</td>
													<td>{$sub->subject}</td>
													<td>{$sub->value}</td>
													<td>{$sub->remarks}</td>
												</tr>
											";
											
											endforeach;
											
										}
										
										
						$html .=	"</table>
								</div>
								
								<div class='grade_slip mydiv center'>
									<br/>
									<br/>
									<table><tr>
										<td style='border-top: thin solid black;'>".$ci->session->userdata['username']."</td>
									</tr></table>
								</div>
				</div>";
		}
		
		return $html;
	}
	
	function _html_exam_permit($students, $subjects, $per_page)
	{
		$ci =& get_instance();
		$sy = $ci->open_semester->year_from .' - '.$ci->open_semester->year_to;
		
		$base_url = base_url();
		
		$height = (100 / (int)$per_page) - 1;
		for($x = 0; $x <= $per_page-1; $x++)
		{
			$html .= "
				<div class='maindiv' style='height: {$height}%; width: 100%; float:left;'>";
					$student = $students[$x];
					
						$html.=	"
								<div class='header_title mydiv' >
									<div class='center'>
											<span class='school_name'>
												<img style='width:45px;height:45px;' src='{$base_url}{$ci->setting->logo}'/>
												{$ci->setting->school_name}
											</span><br/>
											<span>{$ci->setting->school_address}</span><br/>
											<span>{$ci->setting->school_telephone}</span><br/>
											<span>{$ci->setting->email}</span><br/>
									</div>
								</div>
								
								<div class='grade_slip mydiv center'>
									<p>Exam Permit</p>
								</div>
								
								<div class='sub_title mydiv'>
									<table><tr>
										<td style='width:20%;'>Time : &nbsp; ".date('g:h A')."</td>
										<td style='width:20%;'>Date : &nbsp; ".date('M d, Y')."</td>
										<td style='width:20%;'>Term : &nbsp; ".$student->semester."</td>
										<td style='width:20%;'>SY : &nbsp; ".$student->sy_from."-".$student->sy_to."</td>
										<td style='width:20%;'>Admission Status : &nbsp; ".$student->status."</td>
									</tr></table>
								</div>
								
								<div class='sub_title mydiv'>
									<table><tr>
										<td style='width:20%;'><b>ID Number : &nbsp; ".$student->studid."</b></td>
										<td style='width:20%;text-align:right;'><b>Student Name : &nbsp; ".strtoupper($student->name)."</b></td>
									</tr></table>
								</div>
								
								<div class='grade_slip mydiv center'>
									<table><tr>
										<td style='width:20%;'><b>Course : &nbsp; ".$student->course."</b></td>
									</tr></table>
								</div>
								
								<div class='subjects mydiv'>
									<table width='100%'>
										<tr>
											<th>Subject Code</th>
											<th>Section Code</th>
											<th>Subject Description</th>
											<th>Units</th>
											<th>Lab</th>
											<th>Instructor's Signature</th>
											<th>Date &nbsp; &nbsp; &nbsp; </th>
											<th>Remarks &nbsp; &nbsp; &nbsp;</th>
										</tr>";
										// vd($subjects[$student->id]);
										if(isset($subjects[$student->id]) && is_array($subjects[$student->id])){
											
											foreach($subjects[$student->id] as $sub):
									// vd($sub);		
									$html .= "
												<tr>
													<td>{$sub->sc_id}</td>
													<td>{$sub->code}</td>
													<td>{$sub->subject}</td>
													<td>{$sub->units}</td>
													<td>{$sub->lab}</td>
													<td style='border-bottom: thin solid gray;' ></td>
													<td style='border-bottom: thin solid gray;' ></td>
													<td style='border-bottom: thin solid gray;' ></td>
												</tr>
											";
											
											endforeach;
											
										}
										
										
						$html .=	"</table>
								</div>
								
								<div class='grade_slip mydiv center'>
									<br/>
									<br/>
									<table><tr>
										<td style='border-top: thin solid black;'>".$ci->session->userdata['username']."</td>
									</tr></table>
								</div>
				</div>";
		}
		
		return $html;
	}
	
