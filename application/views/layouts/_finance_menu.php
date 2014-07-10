<?php
	$new = sha1('new');
	$this->load->helper(array('url_encrypt'));
	$print_crypt = sha1('for_printing_security');
	$l = _se($print_crypt);
?>

<div class="list-group">
  <a href="#" class="list-group-item active">Student Section</a>
	<a href="<?=site_url('search/search_student');?>" class="list-group-item">Search Student</a>
	<a href="<?=site_url('search/search_enrollee');?>" class="list-group-item">Enrollees</a>
	<a href="<?=site_url('finance/all_payment_report');?>" class="list-group-item">Daily Collection</a>
	<a href="<?=site_url('search/list_students/unpaid');?>" class="list-group-item">List of Unpaid Students</a>
	<a href="<?=site_url('search/list_students/paid');?>" class="list-group-item">List of Paid Students</a>
	<a href="<?php echo base_url(); ?>search/list_students/fullpaid" class="list-group-item">Fully Paid Students</a>
	<a href="<?php echo base_url(); ?>search/list_students/partialpaid" class="list-group-item">Partial Paid Students</a>
	<a href="<?=site_url('search/master_list_by_course');?>" class="list-group-item">Master list by course</a>
	
	<a href="#" class="list-group-item active">Employee Section</a>
	<a href="<?=site_url('search/search_employee');?>" class="list-group-item">Search Employee</a>
	
	<a href="#" class="list-group-item active">Excel Section</a>
	<a href="<?php echo base_url(); ?>fees/student_charges" class="list-group-item">Student Charges</a>
	<a href="<?php echo base_url(); ?>excels/student_charges" class="list-group-item">Download Student Charges Excel</a>
	<a href="<?php echo base_url(); ?>payment_record/student_payments" class="list-group-item">Student Payments</a>
	<a href="<?php echo base_url(); ?>excels/student_payments" class="list-group-item">Download Student Payments Excel</a>
	<a href="<?php echo base_url(); ?>fees/student_deductions" class="list-group-item">Student Deductions</a>
	<a href="<?php echo base_url(); ?>excels/student_deductions" class="list-group-item">Download Student Deductions</a>
	<a href="<?php echo base_url(); ?>payment_record/remaining_balance_report" class="list-group-item">Remaining Balance Report</a>
	<a href="<?php echo base_url(); ?>payment_record/download_remaining_balance_report" class="list-group-item">Download Remaining Balance Report</a>
	<a href="<?php echo base_url(); ?>excels/download_remaining_balance_report" class="list-group-item">Download All Student Profile</a>
	<a href="<?php echo base_url(); ?>payment_center" class="list-group-item">Generate Exam Permit</a>
	
	<a href="#" class="list-group-item active" class="list-group-item">Setting</a>
	<a href="<?php echo base_url(); ?>subjects" class="list-group-item">Subject</a>
	<a href="<?php echo base_url(); ?>remarks" class="list-group-item">Remarks</a>
	<a href="<?php echo base_url(); ?>permit_settings" class="list-group-item">Permit Settings</a>
	<a href="<?php echo base_url(); ?>" class="list-group-item">Assessment Settings</a>
</div>

			
