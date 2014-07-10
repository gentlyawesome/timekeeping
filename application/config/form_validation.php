<?php
//require APPPATH.DIRECTORY_SEPARATOR.'extensions'.DIRECTORY_SEPARATOR.'enrollment_validation_config'.EXT;

/*
		'name_of_field' => array(										
							'field' => '',
							'label' => '',
							'rules' => ''
				
		)
*/

$config = array(
		'modules' => array(
				array(
										
									'field' => 'module[module]',
									'label' => 'Module Name',
									'rules' => 'required'
				
				)
		),
		'project' => array(
				array(
										
									'field' => 'project[code]',
									'label' => 'Code',
									'rules' => 'required|is_unique[project.code]'
				
				),
				array(
										
									'field' => 'project[name]',
									'label' => 'Project Name',
									'rules' => 'required'
				
				)
		),
		'project2' => array(
				array(
										
									'field' => 'project[code]',
									'label' => 'Code',
									'rules' => 'required'
				),
				array(
										
									'field' => 'project[name]',
									'label' => 'Project Name',
									'rules' => 'required'
				
				)
		),
		'client' => array(
				array(
										
									'field' => 'client[code]',
									'label' => 'Code',
									'rules' => 'required|is_unique[client.code]'
				
				),
				array(
										
									'field' => 'client[name]',
									'label' => 'Client Name',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'client[address]',
									'label' => 'Client Address',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'client[tel]',
									'label' => 'Client Telephone',
									'rules' => 'required'
				
				)
		),
		'client2' => array(
				array(
										
									'field' => 'client[code]',
									'label' => 'Code',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'client[name]',
									'label' => 'Client Name',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'client[address]',
									'label' => 'Client Address',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'client[tel]',
									'label' => 'Client Telephone',
									'rules' => 'required'
				
				)
		),
		'monitoring' => array(
				array(
										
									'field' => 'monitoring[date]',
									'label' => 'Date',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'monitoring[client_id]',
									'label' => 'Client',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'monitoring[project_id]',
									'label' => 'Project',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'monitoring[module_id]',
									'label' => 'Module',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'monitoring[hour]',
									'label' => 'Hour',
									'rules' => 'required'
				
				)
		),
		'new_message' => array(
				array(
										
									'field' => 'recipient_id',
									'label' => 'Receipt',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'message',
									'label' => 'Message Content',
									'rules' => 'required|trim'
				
				)
		),
		'update_student_profile' => array(
				array(
										
									'field' => 'first_name',
									'label' => '',
									'rules' => 'required'
				
			),
				array(
										
									'field' => 'last_name',
									'label' => '',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'middle_name',
									'label' => '',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'gender',
									'label' => '',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'civil_status',
									'label' => '',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'date_of_birth',
									'label' => '',
									'rules' => 'required'
				
				),
				array(
										
									'field' => 'place_of_birth',
									'label' => '',
									'rules' => 'required'
				
				)
		),
		'record_payment' => array(
			array(
				'field' => 'receipt_number',
				'label' => 'Receipt number',
				'rules' => 'required|is_unique[studentpayments.or_no]'
			),
			array(
				'field' => 'date_of_payment',
				'label' => 'Date of payment',
				'rules' => 'required'
			)
		),
		'record_payment2' => array(
			array(
				'field' => 'receipt_number',
				'label' => 'Receipt number',
				'rules' => 'required|is_unique[studentpayments.or_no]'
			),
			array(
				'field' => 'studid',
				'label' => 'Student ID Number',
				'rules' => 'required|is_existing'
			),
			array(
				'field' => 'date_of_payment',
				'label' => 'Date of payment',
				'rules' => 'required'
			)
		),
		'promissory_note' => array(
			array(
				'field' => 'value',
				'label' => 'Value',
				'rules' => 'required'
			),
			array(
				'field' => 'date',
				'label' => 'Date',
				'rules' => 'required'
			)
		),
		'coursefinances' => array(
			array(
				'field' => 'coursefinances[category]',
				'label' => 'Category',
				'rules' => 'required',
			),
			array(
				'field' => 'coursefinances[category2]',
				'label' => 'Category Name',
				'rules' => 'required',
			),
		),
		'coursefinances_create_fees' => array(
			array(
				'field' => 'coursefees[code]',
				'label' => 'Value',
				'rules' => 'numeric',
			),
		),
		
		'borrow_items' => array(
			array(
				'field' => 'borrow_items[date]',
				'label' => 'Date',
				'rules' => 'required',
			),
			array(
				'field' => 'borrow_items[user_id]',
				'label' => 'Borrowers',
				'rules' => 'required',
			),
			array(
				'field' => 'borrow_items[item_id]',
				'label' => 'Item',
				'rules' => 'required',
			),
			array(
				'field' => 'borrow_items[unit]',
				'label' => 'Quantity',
				'rules' => 'required|numeric',
			),
		),
		
		
		'subjects' => array(
			array(
				'field' => 'subjects[sc_id]',
				'label' => 'Subject Code',
				'rules' => 'required|trim|unique|numeric',
			),
			array(
				'field' => 'subjects[code]',
				'label' => 'Section Code',
				'rules' => 'required|trim',
			),
			array(
				'field' => 'subjects[subject]',
				'label' => 'Description',
				'rules' => 'required|trim',
			),
			array(
				'field' => 'subjects[units]',
				'label' => 'No. of Units',
				'rules' => 'required|trim|numeric',
			),
			array(
				'field' => 'subjects[time]',
				'label' => 'Time',
				'rules' => 'required|trim',
			),
			array(
				'field' => 'subjects[day]',
				'label' => 'Day',
				'rules' => 'required|trim',
			),
			array(
				'field' => 'subjects[room]',
				'label' => 'Room',
				'rules' => 'required|trim',
			),
			array(
				'field' => 'subjects[original_load]',
				'label' => 'Maximum Slots',
				'rules' => 'required|trim|numeric',
			),
		),
		'users' => array(
			array(
				'field' => 'user[employees_attributes][personal_info][employeeid]',
				'label' => 'Employee ID',
				'rules' => 'required|trim',
			),
			array(
				'field' => 'user[employees_attributes][personal_info][department]',
				'label' => 'Department',
				'rules' => 'required|trim',
			),
			array(
				'field' => 'user[employees_attributes][personal_info][last_name]',
				'label' => 'Last Name',
				'rules' => 'required|trim',
			),
			array(
				'field' => 'user[employees_attributes][personal_info][first_name]',
				'label' => 'First Name',
				'rules' => 'required|trim',
			),
			array(
				'field' => 'user[employees_attributes][personal_info][middle_name]',
				'label' => 'Middle Name',
				'rules' => 'required|trim',
			),
		),
		'enrollment' => array(
				array(
					'field' => 'year',
					'label' => 'year',
					'rules' => 'required'
				),
				array(
					'field' => 'course',
					'label' => 'course',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[last_name]',
					'label' => 'Lastname',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[first_name]',
					'label' => 'Firstname',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[middle_name]',
					'label' => 'Middle name',
					'rules' => 'required'
				),
				array(
					'field' => 'course',
					'label' => 'Course',
					'rules' => 'required'
				),
				array(
					'field' => 'year',
					'label' => 'Year',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[gender]',
					'label' => 'Gender',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[civil_status]',
					'label' => 'Civil Status',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[date_of_birth]',
					'label' => 'Date of Birth',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[place_of_birth]',
					'label' => 'Birth Place',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[age]',
					'label' => 'Age',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[disablity]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[nationality]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[religion]',
					'label' => 'Religion',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[mobile]',
					'label' => 'Mobile',
					'rules' => 'integer'
				),
				array(
					'field' => 'profile[email]',
					'label' => '',
					'rules' => 'valid_email'
				),
				array(
					'field' => 'profile[present_address]',
					'label' => 'Present Address',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[father_name]',
					'label' => 'Father\'s Name',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[father_occupation]',
					'label' => 'Father\'s Occupation',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[father_contact_no]',
					'label' => 'Father\'s Contact Number',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[mother_name]',
					'label' => 'Mother\'s name',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[mother_contact_no]',
					'label' => 'Mother\'s Contact Number',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[mother_occupation]',
					'label' => 'Mother\'s Occupation',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[parents_address]',
					'label' => 'Parent\'s Address',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[guardian_name]',
					'label' => 'Guardian\'s name',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[guardian_relation]',
					'label' => 'Relation with Guardian',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[guardian_contact_no]',
					'label' => 'Contact No. of Guardian',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[guardian_address]',
					'label' => 'Guardian\'s Address',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[elementary]',
					'label' => 'Elementary School Name',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[elementary_address]',
					'label' => 'Elementary School Address',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[elementary_date]',
					'label' => 'Elementary School Year Graduated/Last Attended',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[secondary]',
					'label' => 'Secondary Schoool Name',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[secondary_address]',
					'label' => 'Secondary School Address',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[secondary_date]',
					'label' => 'Secondary School Year Graduated/Last Attended',
					'rules' => 'required'
				),
				array(
					'field' => 'profile[vocational]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[vocational_address]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[vocational_degree]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[vocational_date]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[tertiary]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[tertiary_address]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[tertiary_degree]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[tertiary_date]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[others]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[others_address]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[others_degree]',
					'label' => '',
					'rules' => ''
				),
				array(
					'field' => 'profile[date]',
					'label' => '',
					'rules' => ''
				),
		)
);