
<style>
	.mylabel{
		font-size:11pt;
	}
	.row > div{
		#border : 1px solid gray;
	}
	
	input select {
		border-color: gray;
	}
</style>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/enrollment.js"></script>

<div class='alert alert-info'>
	<h4>Update your personal information.</h4><br/>
	<div class='label label-warning'>All inputs with * sign are required fields.</strong></div>
</div>

	<fieldset class="scheduler-border">
			<legend class="scheduler-border">Personal data</legend>		
			<br/>
			
			<div class="row">
				<div class="col-sm-2 mylabel">Last Name *</div>
				<div class="col-sm-2 mylabel"><input label="ID NO" class="not_blank" id="lastname" name="user[enrollment_attributes][lastname]" size="15" title="Last Name" type="text"  value='<?=isset($enroll) ? $enroll->lastname: ""?>' /></div>
				<div class="col-sm-2 mylabel">First Name *</div>
				<div class="col-sm-2 mylabel"> <input class="not_blank" id="fname" name="user[enrollment_attributes][fname]" size="15" title="First Name" type="text" value='<?=isset($enroll) ? $enroll->fname: ""?>' /></div>
				<div class="col-sm-2 mylabel">Middle Name *</div>
				<div class="col-sm-2 mylabel"> <input class="not_blank" id="middlename" name="user[enrollment_attributes][middle]" size="15" title="Middle Name" type="text" value='<?=isset($enroll) ? $enroll->middle: ""?>' /></div>
			</div>

			<div class="row">
			  <div class="col-md-2 mylabel">Gender *</div>
			  <div class="col-md-2">
					<?						
						$gender = array(
							"Male" => "Male",
							"Female" => "Female"
						)
					?>
					<?=form_dropdown('user[enrollment_attributes][sex]', $gender,isset($enroll)?$enroll->civil_status:'','class="not_blank"')?>
			  </div>
			  <div class="col-md-2 mylabel">Civil Status *</div>
			  <div class="col-md-2">
					<?						
						$cs = array(
							"" => "Select Civil Status",
							"Single" => "Single",
							"Married" => "Married",
							"Widowed" => "Widowed",
							"Divorced" => "Divorced",
						)
					?>
					<?=form_dropdown('user[enrollment_attributes][civil_status]', $cs,isset($enroll)?$enroll->civil_status:'','class="not_blank"')?>
			  </div>
			</div>
			
			<div class="row">
				<div class="col-sm-2 mylabel">Date of Birth *</div>
				<div class="col-sm-2 mylabel"><input class='not_blank date_pick' id="birthdate" name="user[enrollment_attributes][date_of_birth]" size="10" type="text" value='<?=isset($enroll) ? $enroll->date_of_birth: ""?>' /></div>
				<div class="col-sm-2 mylabel">Birth Place *</div>
				<div class="col-sm-2 mylabel"> <input class="not_blank" id="birthplace" name="user[enrollment_attributes][place_of_birth]" size="20" type="text" value='<?=isset($enroll) ? $enroll->place_of_birth: ""?>' /></div>
				<div class="col-sm-2 mylabel">Age *</div>
				<div class="col-sm-2 mylabel"> <input class="not_blank" id="age" name="user[enrollment_attributes][age]" size="2" type="text" value='<?=isset($enroll) ? $enroll->age: ""?>' /></div>
			</div>
			
			<div class="row">
				<div class="col-sm-2 mylabel">Nationality *</div>
				<div class="col-sm-2 mylabel"><input class="not_blank" id="nationality" name="user[enrollment_attributes][nationality]" size="20" type="text" value='<?=isset($enroll) ? $enroll->nationality: ""?>' /></div>
				<div class="col-sm-2 mylabel">Religion *</div>
				<div class="col-sm-2 mylabel"> <input class="not_blank" id="religion" name="user[enrollment_attributes][religion]" size="20" type="text" value='<?=isset($enroll) ? $enroll->religion: ""?>' /></div>
				<div class="col-sm-2 mylabel">Contact Number</div>
				<div class="col-sm-2 mylabel"> <input class="novalidate" id="mobile" name="user[enrollment_attributes][mobile]" size="20" type="text" value='<?=isset($enroll) ? $enroll->mobile: ""?>' /></div>
			</div>
			
			<div class="row">
				<div class="col-sm-2 mylabel">Are you a foreigner?</div>
				<div class="col-sm-2 mylabel">
					<?						
						$lp = array(
							"0" => "No",
							"1" => "Yes"
						)
					?>
					<?=form_dropdown('user[enrollment_attributes][is_foreigner]', $lp,isset($enroll)?$enroll->is_foreigner:'','class=""')?>
				</div>
				
				<div class="col-sm-2 mylabel">Email</div>
				<div class="col-sm-2 mylabel"><input class="novalidate" id="fake_email" name="user[enrollment_attributes][fake_email]" size="10" type="text" value='<?=isset($enroll) ? $enroll->fake_email: ""?>' /></div>
				<div class="col-sm-2 mylabel">Disability</div>
				<div class="col-sm-2 mylabel"> <input class="novalidate" id="user_enrollment_attributes_disability" name="user[enrollment_attributes][disability]" value='<?=isset($enroll) ? $enroll->disability: ""?>' size="10" type="text" value="" /></div>
			</div>
			
			<div class="row">
				<div class="col-sm-3 mylabel">Street No./ House No. *</div>
				<div class="col-sm-3 mylabel"><input id="user_enrollment_attributes_street_no" name="user[enrollment_attributes][street_no]" class='not_blank' size="10" type="text" value='<?=isset($enroll) ? $enroll->street_no: ""?>' /></div>
				<div class="col-sm-3 mylabel">Present Address *</div>
				<div class="col-sm-3 mylabel"> <input class="not_blank" id="present_address" name="user[enrollment_attributes][present_address]" size="30" type="text" value='<?=isset($enroll) ? $enroll->present_address: ""?>' /></div>
			</div>
			
			<div class="row">
				<div class="col-sm-3 mylabel">Barangay</div>
				<div class="col-sm-3 mylabel"><input id="user_enrollment_attributes_street_no" name="user[enrollment_attributes][barangay]" class='not_blank' size="10" type="text" value='<?=isset($enroll) ? $enroll->barangay: ""?>' /></div>
				<div class="col-sm-3 mylabel">Municipality</div>
				<div class="col-sm-3 mylabel"> <input class="not_blank" id="present_address" name="user[enrollment_attributes][municipal]" value='<?=isset($enroll) ? $enroll->municipal: ""?>' size="30" type="text" /></div>
			</div>
			
			<div class="row">
				<div class="col-sm-3 mylabel">Provincial Address *</div>
				<div class="col-sm-3 mylabel">
					<?php
						$country = array(
				 "Abra",
				  "Agusan del Norte",
				  "Agusan del Sur",
				  "Aklan",
				  "Albay",
				  "Antique",
				  "Apayao",
				  "Aurora",
				  "Basilan",
				  "Bataan",
				  "Batanes",
				  "Batangas",
				  "Benguet",
				  "Biliran",
				  "Bohol",
				  "Bukidnon",
				  "Bulacan",
				  "Cagayan",
				  "Camarines Norte",
				  "Camarines Sur",
				  "Camiguin",
				  "Capiz",
				  "Catanduanes",
				  "Cavite",
				  "Cebu",
				  "Compostela Valley",
				  "Cotabato",
				  "Davao del Norte",
				  "Davao del Sur",
				  "Davao Oriental",
				  "Eastern Samar",
				  "Guimaras",
				  "Ifugao"<
				  "Ilocos Norte",
				  "Ilocos Sur",
				  "Iloilo",
				  "Isabela",
				  "Kalinga",
				  "La Union",
				  "Laguna",
				  "Lanao del Norte",
				  "Lanao del Sur",
				  "Leyte",
				  "Maguindanao",
				  "Marinduque",
				  "Masbate",
				  "Metro Manila",
				  "Misamis Occidental",
				  "Misamis Oriental",
				  "Mountain Province",
				  "Negros Occidental",
				  "Negros Oriental",
				  "Northern Samar",
				  "Nueva Ecija",
				  "Nueva Vizcaya",
				  "Occidental Mindoro",
				  "Oriental Mindoro",
				  "Palawan",
				  "Pampanga",
				  "Pangasinan",
				  "Quezon",
				  "Quirino",
				  "Rizal",
				  "Romblon",
				  "Samar",
				  "Sarangani",
				  "Siquijor",
				  "Sorsogon",
				  "South Cotabato",
				  "Southern Leyte",
				  "Sultan Kudarat",
				  "Sulu",
				  "Surigao del Norte",
				  "Surigao del Sur",
				  "Tarlac",
				  "Tawi Tawi",
				  "Zambales",
				  "Zamboanga del Norte",
				  "Zamboanga del Sur",
				  "Zamboanga Sibugay",
				  "Others"
			);
				//echo form_dropdown('user[enrollment_attributes][province]', $country, isset($enroll)?$enroll->province:'','class="select_option not_blank"');
				echo province_dropdown('user[enrollment_attributes][province]',isset($enroll)?$enroll->province:'',"", '');
					?>
				</div>
				<div class="col-sm-3 mylabel">Living with parents</div>
				<div class="col-sm-3 mylabel">
					<?						
						$lp = array(
							"1" => "Yes",
							"0" => "No"
						)
					?>
					<?=form_dropdown('user[enrollment_attributes][living_with_parents]', $lp,isset($enroll)?$enroll->living_with_parents:'','class="not_blank"')?>
				</div>
			</div>
</fieldset>

<fieldset class="scheduler-border">
			<legend class="scheduler-border">Parent's Information</legend>	
			<div class="row">
				<div class="col-sm-2 mylabel">Father's Name *</div>
				<div class="col-sm-2 mylabel"><input class='not_blank' id="father_name" name="user[enrollment_attributes][father_name]" size="20" type="text" value='<?=isset($enroll) ? $enroll->father_name: ""?>' /></div>
				<div class="col-sm-2 mylabel">Occupation *</div>
				<div class="col-sm-2 mylabel"> <input class='not_blank' id="father_occupation" name="user[enrollment_attributes][father_occupation]" size="20" type="text" value='<?=isset($enroll) ? $enroll->father_occupation: ""?>' /></div>
				<div class="col-sm-2 mylabel">Contact Number *</div>
				<div class="col-sm-2 mylabel"> <input class='not_blank' id="father_contact_no" name="user[enrollment_attributes][father_contact_no]" size="15" type="text" value='<?=isset($enroll) ? $enroll->father_contact_no: ""?>' /></div>
			</div>
			
			<div class="row">
				<div class="col-sm-2 mylabel">Mother's Name *</div>
				<div class="col-sm-2 mylabel"><input id="mother_name" name="user[enrollment_attributes][mother_name]" size="20" type="text" class='not_blank' value='<?=isset($enroll) ? $enroll->mother_name: ""?>' /></div>
				<div class="col-sm-2 mylabel">Occupation *</div>
				<div class="col-sm-2 mylabel"> <input id="mother_occupation" name="user[enrollment_attributes][mother_occupation]" size="20" type="text" class='not_blank' value='<?=isset($enroll) ? $enroll->mother_occupation: ""?>' /></div>
				<div class="col-sm-2 mylabel">Contact Number *</div>
				<div class="col-sm-2 mylabel"><input id="mother_contact_no" name="user[enrollment_attributes][mother_contact_no]" size="15" type="text" class='not_blank' value='<?=isset($enroll) ? $enroll->mother_contact_no: ""?>' /></div>
			</div>
			
			<div class="row">
				<div class="col-sm-2 mylabel">Parent's Address *</div>
				<div class="col-sm-6 mylabel"><input class="not_blank" id="parents_address" name="user[enrollment_attributes][parents_address]" size="40" type="text" value='<?=isset($enroll) ? $enroll->parents_address: ""?>' /></div>
			</div>
</fieldset>

<fieldset class="scheduler-border">
			<legend class="scheduler-border">Academic Data</legend>		
            <div class="row">
				<div class="col-sm-3 mylabel">Are you a graduating student? *</div>
				<div class="col-sm-2 mylabel">
					<?						
						$lp = array(
							"0" => "No",
							"1" => "Yes"
						)
					?>
					<?=form_dropdown('user[enrollment_attributes][is_graduating]', $lp,isset($enroll)?$enroll->is_graduating:'','class="not_blank"')?>
				</div>
			</div>
			<strong><i>Elementary</i></strong>
			<div class="row">
				<div class="col-sm-4 mylabel">Name of School *</div>
				<div class="col-sm-5 mylabel">
					<input class="not_blank" id="elem_name" name="user[enrollment_attributes][elementary]" size="50" title="" type="text" value='<?=isset($enroll) ? $enroll->elementary: ""?>' />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Address of School *</div>
				<div class="col-sm-5 mylabel">
					<input class="not_blank" id="elem_date" name="user[enrollment_attributes][elementary_address]" size="50" type="text" value='<?=isset($enroll) ? $enroll->elementary_address: ""?>' />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Year Graduated/ Year Last Attended *</div>
				<div class="col-sm-5 mylabel">
					<input class="not_blank" id="elem_date" name="user[enrollment_attributes][elementary_date]" size="50" type="text" value='<?=isset($enroll) ? $enroll->elementary: ""?>' />
				</div>
			</div>
			
			<strong><i>Secondary</i></strong>
			<div class="row">
				<div class="col-sm-4 mylabel">Name of School *</div>
				<div class="col-sm-5 mylabel">
					<input class="not_blank" id="sec_name" name="user[enrollment_attributes][secondary]" size="50" type="text" value='<?=isset($enroll) ? $enroll->secondary: ""?>' />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Address of School *</div>
				<div class="col-sm-5 mylabel">
					<input class="not_blank" id="sec_address" name="user[enrollment_attributes][secondary_address]" size="50" type="text" value='<?=isset($enroll) ? $enroll->secondary_address: ""?>' />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Year Graduated/ Year Last Attended *</div>
				<div class="col-sm-5 mylabel">
					<input class="not_blank" id="sec_date" name="user[enrollment_attributes][secondary_date]" size="50" type="text" value='<?=isset($enroll) ? $enroll->secondary_date: ""?>' />
				</div>
			</div>
			
			<strong><i>Vocational</i></strong>
			<div class="row">
				<div class="col-sm-4 mylabel">Name of School</div>
				<div class="col-sm-5 mylabel">
					<input class='' id="user_enrollment_attributes_vocational" name="user[enrollment_attributes][vocational]" size="50" type="text" value='<?=isset($enroll) ? $enroll->vocational: ""?>' />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Address of School</div>
				<div class="col-sm-5 mylabel">
					<input class='' id="user_enrollment_attributes_vocational_address" name="user[enrollment_attributes][vocational_address]" size="50" type="text" value='<?=isset($enroll) ? $enroll->vocational_address: ""?>' />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Degree or Course</div>
				<div class="col-sm-5 mylabel">
					<input class='' id="user_enrollment_attributes_vocational_degree" name="user[enrollment_attributes][vocational_degree]" size="50" type="text" value='<?=isset($enroll) ? $enroll->vocational_degree: ""?>' />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Year Graduated/ Year Last Attended</div>
				<div class="col-sm-5 mylabel">
					<input class='' id="user_enrollment_attributes_vocational_degree" name="user[enrollment_attributes][vocational_date]" size="50" type="text" value='<?=isset($enroll) ? $enroll->vocational_date: ""?>' />
				</div>
			</div>
			
			<strong><i>Tertiary</i></strong>
			<div class="row">
				<div class="col-sm-4 mylabel">Name of School</div>
				<div class="col-sm-5 mylabel">
					<input class='' id="user_enrollment_attributes_tertiary" name="user[enrollment_attributes][tertiary]" size="50" type="text" value='<?=isset($enroll) ? $enroll->tertiary: ""?>' />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Address of School</div>
				<div class="col-sm-5 mylabel">
					<input id="user_enrollment_attributes_tertiary_address" name="user[enrollment_attributes][tertiary_address]" size="50" type="text" value='<?=isset($enroll) ? $enroll->tertiary_address: ""?>' />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Degree or Course</div>
				<div class="col-sm-5 mylabel">
					<input class='' id="user_enrollment_attributes_tertiary_degree" name="user[enrollment_attributes][tertiary_degree]" size="50" type="text"  value='<?=isset($enroll) ? $enroll->tertiary_degree: ""?>'/>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Year Graduated/ Year Last Attended *</div>
				<div class="col-sm-5 mylabel">
					<input id="user_enrollment_attributes_tertiary_degree" name="user[enrollment_attributes][tertiary_date]" size="50" type="text" value='<?=isset($enroll) ? $enroll->tertiary_date: ""?>' />
				</div>
			</div>
			
			<strong><i>Others</i></strong>
			<div class="row">
				<div class="col-sm-4 mylabel">Name of School</div>
				<div class="col-sm-5 mylabel">
					<input id="user_enrollment_attributes_others" name="user[enrollment_attributes][others]" size="50" type="text" value='<?=isset($enroll) ? $enroll->others: ""?>' />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Address of School</div>
				<div class="col-sm-5 mylabel">
					<input id="user_enrollment_attributes_others_address" name="user[enrollment_attributes][others_address]" size="50" type="text" value='<?=isset($enroll) ? $enroll->others_address: ""?>' />
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-4 mylabel">Degree or Course</div>
				<div class="col-sm-5 mylabel">
					<input id="user_enrollment_attributes_others_degree" name="user[enrollment_attributes][others_degree]" size="50" type="text" value='<?=isset($enroll) ? $enroll->others_degree: ""?>' />
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-sm-4 mylabel">Year Graduated/ Year Last Attended</div>
				<div class="col-sm-5 mylabel">
					<input id="user_enrollment_attributes_others_date" name="user[enrollment_attributes][others_date]" size="50" type="text" value='<?=isset($enroll) ? $enroll->others_date: ""?>' />
				</div>
			</div>
	
			<div id='message' title='Required Fields' style='display:none;'>
				<div id='message_list' class='alert alert-info'>
					Validating ... 
				</div>
			</div>
</fieldset>