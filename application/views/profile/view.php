
<?php 
if(!empty($student_profile)):
		$firstname 		= set_value('first_name') 			== FALSE ? $student_profile->first_name			: set_value('first_name');
		$lastname		= set_value('last_name') 			== FALSE ? $student_profile->last_name			: set_value('last_name');
		$middlename		= set_value('middle_name') 			== FALSE ? $student_profile->middle_name 		: set_value('middle_name');
		$gender			= set_value('gender') 				== FALSE ? $student_profile->gender 			: set_value('gender');
		$civilstatus	= set_value('civil_status') 		== FALSE ? $student_profile->civil_status 		: set_value('civil_status');
		$dateofbirth 	= set_value('date_of_birth') 		== FALSE ? $student_profile->date_of_birth 		: set_value('date_of_birth');
		$placeofbirth 	= set_value('place_of_birth') 		== FALSE ? $student_profile->place_of_birth		: set_value('place_of_birth');
		$age 			= set_value('age') 					== FALSE ? $student_profile->age 				: set_value('age');
		$disability 	= set_value('disability') 			== FALSE ? $student_profile->disability 		: set_value('disability');
		$nationality	= set_value('nationality') 			== FALSE ? $student_profile->nationality 		: set_value('nationality');
		$religion		= set_value('religion') 			== FALSE ? $student_profile->religion 			: set_value('religion');
		$mobile			= set_value('mobile') 				== FALSE ? $student_profile->mobile	 			: set_value('mobile');
		$email			= set_value('email') 				== FALSE ? $student_profile->email	 			: set_value('email');
		$presentadd		= set_value('present_address') 		== FALSE ? $student_profile->present_address	: set_value('present_address');
		$fathername		= set_value('father_name') 			== FALSE ? $student_profile->father_name 		: set_value('father_name');
		$fatherocc		= set_value('father_occupation') 	== FALSE ? $student_profile->father_occupation	: set_value('father_occupation');
		$fathercon		= set_value('father_contact_no') 	== FALSE ? $student_profile->father_contact_no	: set_value('father_contact_no');
		$mothername		= set_value('mother_name') 			== FALSE ? $student_profile->mother_name		: set_value('mother_name');
		$motherocc		= set_value('mother_occupation') 	== FALSE ? $student_profile->mother_occupation	: set_value('mother_occupation');
		$mothercon		= set_value('mother_contact_no') 	== FALSE ? $student_profile->mother_contact_no	: set_value('mother_contact_no');
		$parentsadd		= set_value('parents_address') 		== FALSE ? $student_profile->parents_address	: set_value('parents_address');
		$guardianname	= set_value('guardian_name') 		== FALSE ? $student_profile->guardian_name		: set_value('guardian_name');
		$guardianrel	= set_value('guardian_relation') 	== FALSE ? $student_profile->guardian_relation	: set_value('guardian_relation');
		$guardiancon	= set_value('guardian_contact_no') 	== FALSE ? $student_profile->guardian_contact_no: set_value('guardian_contact_no');
		$guardianadd	= set_value('guardian_address') 	== FALSE ? $student_profile->guardian_address	: set_value('guardian_address');
		//$provinicaladd	= set_value('provinical_address') 	== FALSE ? $student_profile->provincial_address	: set_value('provinical_address');

		/*Other School profile*/
		$elementary 	= set_value('elementary') 			== FALSE ? $student_profile->elementary			: set_value('elementary');
		$elementaryadd 	= set_value('elementary_address') 	== FALSE ? $student_profile->elementary_address	: set_value('elementary_address');
		$elementarydate = set_value('elementary_date') 		== FALSE ? $student_profile->elementary_date	: set_value('elementary_date');
		
		$secondary 		= set_value('secondary') 			== FALSE ? $student_profile->secondary			: set_value('secondary');
		$secondaryadd 	= set_value('secondary_address') 	== FALSE ? $student_profile->secondary_address	: set_value('secondary_address');
		$secondarydate 	= set_value('secondary_date') 		== FALSE ? $student_profile->secondary_date		: set_value('secondary_date');
		
		$tertiary		= set_value('tertiary') 			== FALSE ? $student_profile->tertiary			: set_value('tertiary');
		$tertiaryadd	= set_value('tertiary_address') 	== FALSE ? $student_profile->tertiary_address	: set_value('tertiary_address');
		$tertiarydate	= set_value('tertiary_date') 		== FALSE ? $student_profile->tertiary_date		: set_value('tertiary_date');
		$tertiarydeg	= set_value('tertiary_degree') 		== FALSE ? $student_profile->tertiary_degree	: set_value('tertiary_degree');
		
		$vocational		= set_value('vocational') 			== FALSE ? $student_profile->vocational			: set_value('vocational');
		$vocationaladd	= set_value('vocational_address') 	== FALSE ? $student_profile->vocational_address	: set_value('vocational_address');
		$vocationaldate	= set_value('vocational_date') 		== FALSE ? $student_profile->vocational_date	: set_value('vocational_date');
		$vocationaldeg	= set_value('vocational_degree') 	== FALSE ? $student_profile->vocational_degree	: set_value('vocational_degree');
		
		$others			= set_value('others') 				== FALSE ? $student_profile->others				: set_value('others');
		$othersadd		= set_value('others_address') 		== FALSE ? $student_profile->others_address		: set_value('others_address');
		$othersdate		= set_value('others_date') 			== FALSE ? $student_profile->others_date		: set_value('others_date');
		$othersdeg		= set_value('others_degree') 		== FALSE ? $student_profile->others_degree		: set_value('others_degree');
		$living_with_parents		= set_value('living_with_parents') 		== FALSE ? $student_profile->living_with_parents		: set_value('living_with_parents');
		$is_scholar		= set_value('is_scholar') 		== FALSE ? $student_profile->is_scholar		: set_value('is_scholar');
		$is_graduating		= set_value('is_graduating') 		== FALSE ? $student_profile->is_graduating		: set_value('is_graduating');
		
		$studid			= $student_profile->studid;
		//$stud_type    = $student_profile->student_type;
		$sy_to			= $student_profile->sy_to;
		$sy_from		= $student_profile->sy_from;
		$enrollment_id  	= $student_profile->enrollment_id;
		$course 		= set_value('course') == false ? $student_profile->course_id : set_value('course');
		$year 			= set_value('year') == false ? $student_profile->year_id : set_value('year');
		$semester 	= set_value('semester') == false ? $student_profile->sem_id : set_value('semester');
endif;
$studtyp_opt = array(
	'new'=>'new',
	'old' => 'old',
	'returnee'=>'returnee',
	'cross-enrollee'=>'Cross Enrollee'
);

$civilstat_opt = array(
		'Single' => 'Single',
		'Married' => 'Married',
		'Divorced' => 'Divorced'
);
$gender_opt = array(
	'male'=>'male',
	'female'=>'female'
);
/* ####################################  END PHP CONFIG ##################################*/
?>

<script type="text/javascript">
  $(document).ready(function(){
	$('.registrar-form input').attr('disabled', true);
	$('.registrar-form select').attr('disabled', true);
  });
</script>

<?php $this->load->view('layouts/_student_data'); ?>


	<?php echo validation_errors() == '' ? NULL : '<div class="alert alert-danger">'.validation_errors().'</div>'?>
	<form action="<?php echo site_url('profile/view');?>" method="post" accept-charset="utf-8" class="registrar-form">
			
		<table class="blue">
			<tbody><tr><th colspan="4" class="text-align text-center">ENROLLMENT DATA</th></tr>
			<tr>
				<td>
					<label for="idno">ID NO:</label>
					<input type="text" name="id_no" value="<?php echo $studid;?>" id="id_no"style="width:100px"  /> 
				</td>
				<td>
					<label for="student_type">Student type </label>
					<?echo form_dropdown('student_type',$studtyp_opt);?>
				</td>
				<td>
				  <p>
					<label for="sy_from">School Year:</label><br>
					<div class="form-inline">
					From: <input type="text" name="sy_from" value="<?php echo $sy_from;?>" id="sy_from"style="width:100px"  /> - To: <input type="text" name="sy_to" value="<?php echo $sy_to;?>" id="sy_to" size="5"style="width:100px"  /> 
					</div>
					</p>
				</td>
			</tr>
						
			<tr>
				<td>
						<label for="semester_id">Select Semester</label>
						<?php echo semester_dropdown('semester',$semester);?>
				</td>
				<td>
					<label for="year_id">Select Year</label>
					<?php echo year_dropdown('year',$year);?>
				</td>
				<td>
					<label for="course_id">Select Course</label>
					<?php echo course_dropdown('course', $course);?>
				</td>
			</tr>
			</tbody>
		</table>

		<table class="blue">
			<tbody><tr><th colspan="2" class="text-center">PERSONAL INFORMATION</th></tr>
				<tr>
					<td><label for="lastname">Last Name </label><input type="text" name="last_name" value="<?php echo $lastname;?>" id="lastname"  /></td>
					<td><label for="firstname">First Name </label><input type="text" name="first_name" value="<?php echo $firstname;?>" id="firstname"  /></td>
				</tr>
				<tr>
					<td><label for="middlename">Middle Name </label><input type="text" name="middle_name" value="<?php echo $middlename;?>" id="middlename"  /></td>
					<td>
						<label for="gender">Gender </label>	
						<?php echo form_dropdown('gender',$gender_opt,$gender)?>
					</td>
				</tr>


				<tr>
					<td>
						<label for="civilstatus">Civil Status </label>
						<?php echo form_dropdown('civil_status',$civilstat_opt,$civilstatus);?>
					</td>
					<td>
						<label for="dob">Date of Birth </label>
						<input type="text" name="date_of_birth" value="<?php echo $dateofbirth;?>" id="dob" class="datepicker"  />
					</td>
				</tr>

				<tr>
					<td>
						<label for="pob">Place of Birth </label>
						<input type="text" name="place_of_birth" value="<?php echo $placeofbirth;?>" id="pob"  />
					</td>
					<td>
						<label for="age">Age </label>
						<input type="text" min="15" max="100" name="age" value="<?php echo $age;?>" id="age"  />
					</td>
				</tr>

				<tr>
					<td>
						<label for="disability">Disability</label>
						<input type="text" name="disability" value="<?php echo $disability;?>" id=""/>
					</td>
					<td>
						<label for="nationality">Nationality </label>
						<input type="text" name="nationality" value="<?php echo $nationality;?>" id="nationality"  />
					</td>
				</tr>


				<tr>
					<td>
						<label for="religion">Religion </label>
						<input type="text" name="religion" value="<?php echo $religion;?>" id="religion"  />
					</td>
					<td>
						<label for="contact_no">Contact Number </label>
						<input type="text" name="mobile" value="<?php echo $mobile;?>"  />
					</td>
				</tr>

				<tr>
					<td>
						<label for="email">Email </label>
						<input type="text" name="email" value="<?php echo $email;?>" id="email"  />        
					</td>
					<td>
						<label for="present_address">Present Address </label>
						<input type="text" name="present_address" value="<?php echo $presentadd;?>" id="present_address"  />
					</td>
				</tr>

				<tr>
					<td>
						<label for="fathername">Father's Name </label>
						<input type="text" name="father_name" value="<?php echo $fathername;?>" id="fathername"/>
					</td>
					<td>
						<label for="father_occupation">Occupation </label>
						<input type="text" name="father_occupation" value="<?php echo $fatherocc;?>" id="father_occupation"  />
					</td>
				</tr>

				<tr>
					<td>
						<label for="father_contact_no">Contact Number </label>
						<input type="text" name="father_contact_no" value="<?php echo $fathercon;?>" id="father_contact_no"  />
					</td>
					<td>
						<label for="mothername">Mother's Name </label>
						<input type="text" name="mother_name" value="<?php echo $mothername;?>" id="mothername"  />
					</td>
				</tr>

				<tr>
					<td>
						<label for="mother_occupation">Occupation </label>
						<input type="text" name="mother_occupation" value="<?php echo $motherocc;?>" />
					</td>
					<td>
						<label for="mother_contact_no">Contact Number </label>
						<input type="text" name="mother_contact_no" value="<?php echo $mothercon;?>" id="mother_contact_no"  />
					</td>
				</tr>

				<tr>
					<td>
						<label for="parent_address">Parent's Address </label>
						<input type="text" name="parents_address" value="<?php echo $parentsadd;?>" id="parent_address"  />
					</td>
					<td>
						<label for="guardian_name">Guardian Name </label>
						<input type="text" name="guardian_name" value="<?php echo $guardianname;?>" id="guardian_name"  />
					</td>
				</tr>

				<tr>
					<td>
						<label for="relationship">Relationship </label>
						<input type="text" name="guardian_relation" value="<?php echo $guardianrel;?>" id="relationship"  />
					</td>
					<td>
						<label for="guardian_contact_no">Contact Number </label>
						<input type="text" name="guardian_contact_no" value="<?php echo $guardiancon;?>" id="guardian_contact_no"  />
					</td>
				</tr>

				<tr>
					<td>
						<label for="guardian_address">Guardian Address </label>
						<input type="text" name="guardian_address" value="<?php echo $guardianadd;?>" id="guardian_address"  />
					</td>
					
					<td>
          <input type="hidden" value="0" name="living_with_parents">
          <input id="enrollment_living_with_parents" type="checkbox" value="<?= $living_with_parents ?>" name="living_with_parents">
          <label for="living_with_parents">Living With Parents </label>
          </td>
				</tr>
				
				<tr>
				  <td>
          <input type="hidden" value="0" name="is_scholar">
          <input id="enrollment_is_scholar" type="checkbox" value="<?= $is_scholar ?>" name="is_scholar">
          <label for="enrollment_is_scholar">School Scholar</label>
          </td>
          
          <td>
          <input type="hidden" value="0" name="is_graduating">
          <input id="enrollment_is_graduating" type="checkbox" value="<?= $is_graduating; ?>" name="is_graduating">
          <label for="enrollment_is_graduating">Student is a graduating.</label>
          </td>
				</tr>

			</tbody>
		</table>
		<table class="blue">
			<tbody>
				<tr>
					<th colspan="5" align="center" class="text-center">LAST SCHOOL ATTENDED</th>
				</tr>
					<!-- elementary school attended-->
				<tr>
					<td>
						<label for="last_school_name">Elementary School Name </label>
						<input type="text" name="elementary" value="<?php echo $elementary; ?>"/>
					</td>
					<td>
						<label for="last_school_address">Elementary School Address </label>
						<input type="text" name="elementary_address" value="<?php echo $elementaryadd;?>"   />
					</td>
					<td>
						<label for="last_school_level">Date</label>
						<input type="text" name="elementary_date" value="<?php echo $elementarydate;?>" />
					</td>
					<td></td>
				</tr>
					<!-- secondary school attended-->
				<tr>
					<td>
						<label for="last_school_name">Secondary School Name </label>
						<input type="text" name="secondary" value="<?php echo $secondary;?>"  />
					</td>
					<td>
						<label for="last_school_address">Secondary School Address </label>
						<input type="text" name="secondary_address" value="<?php echo $secondaryadd;?>" />
					</td>
					<td>
						<label for="last_school_level">Date</label>
						<input type="text" name="secondary_date" value="<?php echo $secondarydate;?>"   />
					</td>
					<td></td>
				</tr>
					<!-- vocational school attended-->
				<tr>
					<td>
						<label for="last_school_name">Vocational School Name </label>
						<input type="text" name="vocational" value="<?php echo $vocational;?>"  />
					</td>
					<td>
						<label for="last_school_address">Tertiary School Address </label>
						<input type="text" name="vocational_address" value="<?php echo $vocationaladd; ?>" />
					</td>
					<td>
						<label for="last_school_level">Degree</label>
						<input type="text" name="vocational_degree" value="<?php echo $vocationaldeg;?>" />
					</td>
					<td>
						<label for="last_school_year">Date</label>
						<input type="text" name="vocational_date" value="<?php echo $vocationaldate;?>"> 
				</tr>
					<!-- tertiary school attended-->
				<tr>
					<td>
						<label for="last_school_name">Tertiary School Name </label>
						<input type="text" name="tertiary" value="<?php echo $tertiary;?>"  />
					</td>
					<td>
						<label for="last_school_address">Tertiary School Address </label>
						<input type="text" name="tertiary_address" value="<?php echo $tertiaryadd;?>" />
					</td>
					<td>
						<label for="last_school_level">Degree</label>
						<input type="text" name="tertiary_degree" value="<?php echo $tertiarydeg;?>" />
					</td>
					<td>
						<label for="last_school_year">Date</label>
						<input type="text" name="tertiary_date" value="<?php echo $tertiarydate;?>"   />
					</td>
				</tr>
					<!-- Other school attended-->
				<tr>
					<td>
						<label for="last_school_name">Other School Name </label>
						<input type="text" name="others" value="<?php echo $others;?>"  />
					</td>
					<td>
						<label for="last_school_address">Other School Address </label>
						<input type="text" name="others_address" value="<?php echo $othersadd; ?>"  />
					</td>
					<td>
						<label for="last_school_level">Level </label>
						<input type="text" name="others_degree" value="<?php echo $othersdeg; ?>"  />
					</td>
					<td>
						<label for="last_school_year">Date</label>
						<input type="text" name="others_date" value="<?php echo $othersdeg;?>"   />
					</td>
				</tr>
			</tbody>
		</table>
		

		<div class="input-block">
			<input type="hidden" name="enrollment_id" value="<?php echo $enrollment_id;?>" />
			
			<input type="hidden" name="form_token" value="<?php echo $form_token;?>" />
		</div>

