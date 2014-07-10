<?$this->load->view('employees/_tab');?>

<div id="header" style='text-align:left;'>I. Personal Information</div>
	 <table>
	   <tr>
		  <th>Employee ID</th>
		  <td><?=$personal_info->employeeid;?></td>
	   </tr>
	   <tr>
		  <th>Department</th>
		  <td><?=$personal_info->department;?></td>
	   </tr>
	   <tr>
		  <th>Role</th>
		  <td><?=$personal_info->role;?></td>
	   </tr>
	   <tr>
		  <th>Join Date</th>
		  <td><?=$personal_info->joining_date;?></td>
	   </tr>
	   <tr>
		  <th>Last Name</th>
		  <td><?=$personal_info->last_name;?></td>
	   </tr>
	   <tr>
		  <th>First Name</th>
		  <td><?=$personal_info->first_name;?></td>
	   </tr>
	   <tr>
		  <th>Middle Name</th>
		  <td><?=$personal_info->middle_name;?></td>
	   </tr>
	   <tr>
		  <th>Date of Birth</th>
		  <td><?=$personal_info->dob;?></td>
	   </tr>
	   <tr>
		  <th>Place of Birth</th>
		  <td><?=$personal_info->place_of_birth;?></td>
	   </tr>
	   <tr>
		  <th>Sex</th>
		  <td><?=$personal_info->gender;?></td>
	   </tr>
	   <tr>
		  <th>Civil Status</th>
		  <td><?=$personal_info->martial_status;?></td>
	   </tr>
	</table>
	<table>
	   <tr>
		  <th>Citizenship</th>
		  <td><?=$personal_info->citizenship;?></td>
		  <th>Residential Address</th>
		  <td><?=$personal_info->residential_address;?></td>
	   </tr>
	   <tr>
		  <th>Religion</th>
		  <td><?=$personal_info->religion;?></td>
		  <th>Permanent Address</th>
		  <td><?=$personal_info->permanent_address;?></td>
	   </tr>
	   <tr>
		  <th>SSS ID No.</th>
		  <td><?=$personal_info->sss_id_no;?></td>
		  <th>E-mail (if any)</th>
		  <td><?=$personal_info->email;?></td>
	   </tr>
	   <tr>
		  <th>Pag-ibig No.</th>
		  <td><?=$personal_info->pagibig_no;?></td>
		  <th>Cellphone No. (if any)</th>
		  <td><?=$personal_info->cellphone;?></td>
	   </tr>
	   <tr>
		  <th>Philhealth No.</th>
		  <td><?=$personal_info->philhealth_no;?></td>
		  <th>TIN</th>
		  <td><?=$personal_info->tin;?></td>
	   </tr>
	</table>
	<br />
	<div id="header" style='text-align:left;'>II. FAMILY BACKGROUND</div>
	<hr>
	<table>
	   <tr>
		  <th>&nbsp;</th>
		  <th>Spouse</th>
		  <th>Name of Child</th>
		  <th>Date of Birth</th>
	   </tr>
	   <tr>
		  <th>Last Name</th>
		  <td><?=$personal_info->spouse_last_name;?></td>
		  <td><?=$personal_info->child1;?></td>
		  <td><?=$personal_info->child1bday;?></td>
	   </tr>
	   <tr>
		  <th>First Name</th>
		  <td><?=$personal_info->spouse_first_name;?></td>
		  <td><?=$personal_info->child2;?></td>
		  <td><?=$personal_info->child2bday;?></td>
	   </tr>
	   <tr>
		  <th>Middle Name</th>
		  <td><?=$personal_info->spouse_middle_name;?></td>
		  <td><?=$personal_info->child3;?></td>
		  <td><?=$personal_info->child3bday;?></td>
	   </tr>
	   <tr>
		  <th>Occupation</th>
		  <td><?=$personal_info->spouse_occupation;?></td>
		  <td><?=$personal_info->child4;?></td>
		  <td><?=$personal_info->child4bday;?></td>
	   </tr>
	   <tr>
		  <th>Employer/ Bus. Name</th>
		  <td><?=$personal_info->spouse_employer;?></td>
		  <td><?=$personal_info->child5;?></td>
		  <td><?=$personal_info->child5bday;?></td>
	   </tr>
	   <tr>
		  <th>Business Address</th>
		  <td><?=$personal_info->spouse_business_address;?></td>
		  <td><?=$personal_info->child6;?></td>
		  <td><?=$personal_info->child6bday;?></td>
	   </tr>
	   <tr>
		  <th>Telephone No.</th>
		  <td><?=$personal_info->spouse_telephone;?></td>
		  <td><?=$personal_info->child7;?></td>
		  <td><?=$personal_info->child7bday;?></td>
	   </tr>
	</table>
	<br />
	<table>
	   <tr>
		  <th>Father</th>
		  <th>&nbsp;</th>
	   </tr>
	   <tr>
		  <th>Last Name</th>
		  <td><?=$personal_info->father_last_name;?></td>
	   </tr>
	   <tr>
		  <th>First Name</th>
		  <td><?=$personal_info->father_first_name;?></td>
	   </tr>
	   <tr>
		  <th>Middle Name</th>
		  <td><?=$personal_info->father_middle_name;?></td>
	   </tr>
	</table>
	<br />
	<table>
	   <tr>
		  <th>Mother</th>
		  <th>&nbsp;</th>
	   </tr>
	   <tr>
		  <th>Last Name</th>
		  <td><?=$personal_info->mother_last_name;?></td>
	   </tr>
	   <tr>
		  <th>First Name</th>
		  <td><?=$personal_info->mother_first_name;?></td>
	   </tr>
	   <tr>
		  <th>Middle Name</th>
		  <td><?=$personal_info->mother_middle_name;?></td>
	   </tr>
	</table>
	<br />
	<div id="header" style='text-align:left;'>III. EDUCATIONAL BACKGROUND</div>
	<hr>
	<table>
	   <tr>
		  <th>LEVEL</th>
		  <th>NAME OF SCHOOL</th>
		  <th>DEGREE COURSE</th>
		  <th>YEAR GRADUATED</th>
	   </tr>
	   <tr>
		  <th>Elementary</th>
		  <td><?=$personal_info->elementary_name;?></td>
		  <td><?=$personal_info->elementary_degree;?></td>
		  <td><?=$personal_info->elementary_year;?></td>
	   </tr>
	   <tr>
		  <th>Secondary</th>
		  <td><?=$personal_info->secondary_name;?></td>
		  <td><?=$personal_info->secondary_degree;?></td>
		  <td><?=$personal_info->secondary_year;?></td>
	   </tr>
	   <tr>
		  <th>Vocational</th>
		  <td><?=$personal_info->vocational_name;?></td>
		  <td><?=$personal_info->vocational_degree;?></td>
		  <td><?=$personal_info->vocational_year;?></td>
	   </tr>
	   <tr>
		  <th>College</th>
		  <td><?=$personal_info->college_name;?></td>
		  <td><?=$personal_info->college_degree;?></td>
		  <td><?=$personal_info->college_year;?></td>
	   </tr>
	   <tr>
		  <th>Graduate Studies</th>
		  <td><?=$personal_info->graduate_name;?></td>
		  <td><?=$personal_info->graduate_degree;?></td>
		  <td><?=$personal_info->graduate_year;?></td>
	   </tr>
	</table>
	<br />
	<div id="header" style='text-align:left;'>IV.</div>
	<hr>
	<table>
	   <tr>
		  <th>Career Service/ RA 1080 (BOARD/BAR)</th>
		  <th>Rating</th>
		  <th>Date of examination/ conferment</th>
	   </tr>
	   <?php
		if($career_services != false){
		foreach($career_services as $value)
		{ ?>
		<tr>
			 <td><?=$value->career;?></td>
			 <td><?=$value->rating;?></td>
			 <td><?=$value->date_of_examination;?></td>
		</tr>
		<?php }}?>
	</table>
	<br />
	<div id="header" style='text-align:left;'>V. WORK EXPERIENCE</div>
	<hr>
	<table>
	   <tr>
		  <th colspan=2>Inclusive Dates</th>
		  <th>Position Title <br />(Write in full)</th>
		  <th>Agency/ Office/ Company <br />(Write in full)</th>
	   </tr>
	    <tr>
		  <th>From</th>
		  <th>To</th>
		  
	   </tr>
	   <?php	
	   if($work_experiences != false){
		foreach($work_experiences as $value)
		{ ?>
		<tr>
			 <td><?=$value->from;?></td>
			 <td><?=$value->to;?></td>
			 <td><?=$value->position;?></td>
			 <td><?=$value->agency;?></td>
		</tr>
		<?php }}?>
	</table>
	<br />
	<table>
	   <tr>
		  <th>Voluntary work or involvement in civic/ non-government/ people /voluntary organizations</th>
	   </tr>
	</table>
	<table>
	   <tr>
		  <th>Name</th>
		  <th>Address</th>
	   </tr>
	    <?php	
		if($voluntary_works != false){
		foreach($voluntary_works as $value)
		{ ?>
		<tr>
			 <td><?=$value->name;?></td>
			 <td><?=$value->address;?></td>
		</tr>
		<?php }}?>
	</table>
	<br />
	<div id="header" style='text-align:left;'>VII. TRAINING PROGRAMS</div>
	<hr>
	<table>
	   <tr>
		  <th rowspan = 2>TITLE OF SEMINAR/CONFERENCE/WORKSHOP/SHORT COURSES<br />(Write in full)</th>
		  <th colspan=2>INCLUSIVE DATES OF ATTENDANCE</th>
		  <th rowspan = 2>CONDUCTED/SPONSORED BY <br />(Write in full)</th>
	   </tr>
	   <tr>
		  <th>From</th>
		  <th>To</th>
	   </tr>
	    <?php	
		if($training_programs != false){
		foreach($training_programs as $value)
		{ ?>
		<tr>
			 <td><?=$value->title;?></td>
			 <td><?=$value->from;?></td>
			 <td><?=$value->to;?></td>
			 <td><?=$value->conducted;?></td>
		</tr>
		<?php }}?>
	</table>
	<br />
	<div id="header" style='text-align:left;'>VIII. OTHER INFORMATION</div>
	<hr>
	<table>
	   <tr>
		  <th>NON-ACADEMIC DISTINCTIONS/RECOGNITION</th>
		  <th>MEMBERSHIP IN ASSOCIATION ORGANIZATION</th>
	   </tr>
	    <?php
		if($other_informations != false){
		foreach($other_informations as $value)
		{ ?>
		<tr>
			 <td><?=$value->recognition;?></td>
			 <td><?=$value->organization;?></td>
		</tr>
		<?php }}?>
	</table>
	<br />
	<table>
	   <tr>
		  <th>Community Tax Certificate No.</th>
		  <td><?=$personal_info->community_tax;?></td>
	   </tr>
	   <tr>
		  <th>Issued At</th>
		  <td><?=$personal_info->issued_at;?></td>
	   </tr>
	   <tr>
		  <th>Issued On</th>
		  <td><?=$personal_info->issued_on;?></td>
	   </tr>
	</table>

	<p>
		<a class='btn btn-danger' href="<?php echo base_url(); ?>employees/edit/<?=$personal_info->id?>"><span class='glyphicon glyphicon-pencil' ></span>&nbsp;  Edit Profile</a> |
		<a class='btn btn-default btn-sm' href="<?php echo base_url(); ?>employees/print/<?=$personal_info->id?>"><span class='glyphicon glyphicon-print' ></span>&nbsp;  Print</a> 
	</p>