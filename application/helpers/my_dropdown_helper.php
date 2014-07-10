<?php



/*
	Year Dropdown
	@param string $name name attribute of the select field
	@param mixed $selected_option selected value of select field
 */
function year_dropdown($name,$selected_option = NULL,$attr = "", $default = false){

	$ci =& get_instance();
	$ci->load->model('M_years');
	$years = $ci->M_years->get('',array('year','id'));	

	if(!empty($years))
	{
		if($default == false){
		//	$year_opt[''] = 'Choose Year';
		}else{
			$year_opt[''] = $default;
		}
		foreach($years as $y){
			$year_opt[$y->id] = $y->year;

		}
	}else
	{
		$year_opt[] = 'No data to show';
	}
	return form_dropdown($name,$year_opt,$selected_option,$attr);
}


/*
	Course Dropdown
	@param string $name name attribute of the select field
	@param mixed $selected_option selected value of select field
 */
function course_dropdown($name,$selected_option = NULL,$attr = "",$default = false){

	$ci =& get_instance();
	$ci->load->model('M_courses');
	$years = $ci->M_courses->get('',array('course','id'));	

	if(!empty($years))
	{
		if($default == false){
			//$year_opt[''] = 'Choose Course';
		}else{
			$year_opt[''] = $default;
		}
		foreach($years as $y){
			
			$year_opt[$y->id] = $y->course;

		}
	}else
	{
		$year_opt[] = 'No data to show';
	}
	
	return form_dropdown($name,$year_opt,$selected_option,$attr);
}

/*
	Role or Department Dropdown
	@param string $name name attribute of the select field
	@param mixed $selected_option selected value of select field
 */
function departments_dropdown($name,$selected_option = NULL,$attr = "",$default = false){

	$ci =& get_instance();
	$ci->load->model('M_departments');
	$years = $ci->M_departments->get_all_department_for_welcome_screen();	

	if(!empty($years))
	{
		if($default == false){
			//$year_opt[''] = 'Choose Year';
		}else{
			$year_opt[''] = $default;
		}
		foreach($years as $y){
			
			$year_opt[$y->department] = $y->description;

		}
	}else
	{
		$year_opt[] = 'No data to show';
	}
	
	return form_dropdown($name,$year_opt,$selected_option,$attr);
}
/*
	Items
	@param string $name name attribute of the select field
	@param mixed $selected_option selected value of select field
 */
function items_dropdown($name,$selected_option = NULL,$attr = "",$default = false){

	$ci =& get_instance();
	$ci->load->model('M_items');
	$filter['unit_left >'] = 0;
	$years = $ci->M_items->find(0,0, $filter, true);
	
	if(!empty($years))
	{
		if($default == false){
			//$year_opt[''] = 'Choose Year';
		}else{
			$year_opt[''] = $default;
		}
		foreach($years as $y){
			
			$year_opt[$y->id] = $y->item.'  -  Unit Left : '.$y->unit_left;

		}
	}else
	{
		$year_opt[] = 'No data to show';
	}
	
	return form_dropdown($name,$year_opt,$selected_option,$attr);
}


/*
	Semester Dropdown
	@param string $name name attribute of the select field
	@param mixed $selected_option selected value of select field
 */
function semester_dropdown($name,$selected_option = NULL, $attr = "", $default = false){

	$ci =& get_instance();
	$ci->load->model('M_semesters');
	$years = $ci->M_semesters->get('',array('name','id'));	

	if(!empty($years))
	{
		foreach($years as $y){
			if($default != false)
			{
				$year_opt[''] = $default;
			}
			$year_opt[$y->id] = $y->name;

		}
	}else
	{
		$year_opt[] = 'No data to show';
	}
	
	return form_dropdown($name,$year_opt,$selected_option, $attr);
}

/*
	Library Category
	@param string $name name attribute of the select field
	@param mixed $selected_option selected value of select field
 */
function librarycategory_dropdown($name,$selected_option = NULL, $default = false, $attr=''){

	$ci =& get_instance();
	$ci->load->model('M_librarycategory');
	$librarycategory = $ci->M_librarycategory->get('',array('category','id'));	

	if(!empty($librarycategory))
	{
		if($default == false){
			
		}else{
			$lib_opt[''] = $default;
		}
		foreach($librarycategory as $y){
			
			$lib_opt[$y->id] = $y->category;

		}
	}else
	{
		$lib_opt[] = 'No data to show';
	}
	
	return form_dropdown($name,$lib_opt,$selected_option,$attr);
}

/*
	Library STATUS
	@param string $name name attribute of the select field
	@param mixed $selected_option selected value of select field
 */
function librarystatus_dropdown($name,$selected_option = NULL, $default = false, $attr=''){

	$ci =& get_instance();
	$ci->load->model('M_librarystatus');
	$librarycategory = $ci->M_librarystatus->get('',array('status','id'));	

	if(!empty($librarycategory))
	{
		if($default == false){
			
		}else{
			$lib_opt[''] = $default;
		}
		foreach($librarycategory as $y){
			
			$lib_opt[$y->status] = $y->status;

		}
	}else
	{
		$lib_opt[] = 'No data to show';
	}
	
	return form_dropdown($name,$lib_opt,$selected_option,$attr);
}

/*
	USERS
	@param string $name name attribute of the select field
	@param mixed $selected_option selected value of select field
 */
function users_dropdown($name,$selected_option = NULL, $default = false, $attr=''){

	$ci =& get_instance();
	$ci->load->model('M_users');
	$librarycategory = $ci->M_users->find_all();	

	if(!empty($librarycategory))
	{
		if($default == false){
			
		}else{
			$lib_opt[''] = $default;
		}
		foreach($librarycategory as $y){
			if(trim($y->name)==""){
				$lib_opt[$y->id] = $y->login;
			}else{
				$lib_opt[$y->id] = $y->name;
			}

		}
	}else
	{
		$lib_opt[] = 'No data to show';
	}
	
	return form_dropdown($name,$lib_opt,$selected_option,$attr);
}

function users_dropdown_for_messages($name,$selected_option = NULL, $default = false, $attr=''){

	$ci =& get_instance();
	$ci->load->model('M_users');
	$filter['department <>'] = 'student';
	$filter['department <> '] = '';
	$filter['department IS NOT NULL'] = null;
	$librarycategory = $ci->M_users->find_all($filter);	

	if(!empty($librarycategory))
	{
		if($default == false){
			
		}else{
			$lib_opt[''] = $default;
		}
		foreach($librarycategory as $y){
			if(trim($y->name)==""){
				$lib_opt[$y->id] = $y->login .' [ '.strtoupper($y->department).' ]';
			}else{
				$lib_opt[$y->id] = $y->name .' [ '.strtoupper($y->department).' ]';
			}

		}
	}else
	{
		$lib_opt[] = 'No data to show';
	}
	
	return form_dropdown($name,$lib_opt,$selected_option,$attr);
}

/*
	STUDENT 
	@param string $name name attribute of the select field
	@param mixed $selected_option selected value of select field
 */
function student_dropdown($name,$selected_option = NULL, $default = false, $attr=''){

	$ci =& get_instance();
	$ci->load->model('M_enrollments');
	// $librarycategory = $ci->M_enrollments->get_all_student_profile_for_report(false, array('id','name'));	
	
	$param['semester_id'] = $ci->open_semester->id;
	$param['sy_from'] = $ci->open_semester->year_from;
	$param['sy_to'] = $ci->open_semester->year_to;
	
	$librarycategory = $ci->M_enrollments->find(0,0, $param, true);
	

	if(!empty($librarycategory))
	{
		if($default == false){
			
		}else{
			$lib_opt[''] = $default;
		}
		foreach($librarycategory as $y){
			$lib_opt[$y->id] = $y->name;
		}
	}else
	{
		$lib_opt[] = 'No data to show';
	}
	
	return form_dropdown($name,$lib_opt,$selected_option,$attr);
}




/*
	Subject Dropdown
	@param string $name name attribute of the select field
	@param mixed $selected_option selected value of select field
 */
function subject_dropdown($name,$selected_option = NULL){

	$ci =& get_instance();
	$ci->load->model('M_subjects');
	$years = $ci->M_subjects->get('',array('id','code','subject'),array('semester_id'=>$ci->open_semester->id,'year_from'=>$ci->open_semester->year_from,'year_to'=>$ci->open_semester->year_to));

	if(!empty($years))
	{
		foreach($years as $y){
			$year_opt[''] = 'Choose subject';
			$year_opt[$y->id] = $y->code | $y->subject;

		}
	}else
	{
		$year_opt[] = 'No data to show';
	}
	
	return form_dropdown($name,$year_opt,$selected_option);
}

/*
* day select
* accepts string, format must be days of week
*
* 		$days['SN'] = 'Sunday';
*		$days['M'] = 'Monday';
*		$days['T'] = 'Tuesday';
*		$days['W'] = 'Wednesday';
*		$days['TH'] = 'Thursday';
*		$days['F'] = 'Friday';
*		$days['S'] = 'Saturday';
*  
*      Or Edit as needed
*/

function day_select($day = false)
{
		$days['SN'] = 'Sunday';
		$days['M'] = 'Monday';
		$days['T'] = 'Tuesday';
		$days['W'] = 'Wednesday';
		$days['TH'] = 'Thursday';
		$days['F'] = 'Friday';
		$days['S'] = 'Saturday';
		//
		$check_box = '';


	if(empty($day) !== TRUE)
	{
		//Split DAYS to array
		$data_from_db = preg_split('/(?=TH|M|T|W|F|S)/', trim($day), -1, PREG_SPLIT_NO_EMPTY);

		// days of week config


		//set the value of data to it's key
		foreach($data_from_db as $key => $value){
			$s_days[$value] = $value;
		}

		//check if selected days from db is on the config
		foreach($days as $key => $value){
			if(array_key_exists($key,$s_days))
			{
				$check_box .= '<span class="uniq">'.$days[$key].'<input type="checkbox" id="checkbox_day" name="days[]" value="'.$key.'" checked></span>';
			}else{
				$check_box .= '<span class="uniq">'.$days[$key].'<input type="checkbox" id="checkbox_day" name="days[]" value="'.$key.'"></span>';
			}
		}
	}else
	{
		foreach($days as $key => $value)
		{
			$check_box .= '<span class="uniq">'.$days[$key].'<input type="checkbox" id="checkbox_day" name="days[]" value="'.$key.'"></span>';
		}
	}
	
	return $check_box;

}

function month_select($name,$selected_option = NULL, $attr = "")
{
	$month = array(
			01 => 'January',
			02 => 'February',
			03 => 'March',
			04 => 'April',
			05 => 'May',
			06 => 'June',
			07 => 'July',
			08 => 'August',
			09 => 'September',
			10 => 'October',
			11 => 'November',
			12 => 'December',
		);
	return form_dropdown($name,$month,$selected_option,$attr);
}

function month_day_select($name,$selected_option = NULL, $attr = "")
{
	$dat = array();
	for($i = 1; $i <= 31; $i++)
	{
		$dat[$i] = str_pad($i, 2, "0", STR_PAD_LEFT);
	}
	return form_dropdown($name,$dat,$selected_option,$attr);
}

function years_select($name,$selected_option = NULL, $attr = "")
{
	$dat = array();
	$current_year = date('Y');
	
	for($i = $current_year; $i >= 1930; $i--)
	{
		$dat[$i] = $i;
	}
	return form_dropdown($name,$dat,$selected_option,$attr);
}