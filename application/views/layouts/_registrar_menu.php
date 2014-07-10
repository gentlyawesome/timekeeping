<?php
	$new = sha1('new');
	$this->load->helper(array('url_encrypt'));
	$print_crypt = sha1('for_printing_security');
	$l = _se($print_crypt);
?>
<div class="list-group">
  <a href="#" class="list-group-item active">Student Section</a>
	<a href="<?php echo site_url(); ?>search/search_student" class="list-group-item">Search Student</a>
  <a href="<?php echo site_url(); ?>search/master_list_by_course" class="list-group-item">Master list by course</a>
  <a href="<?php echo site_url(); ?>search/search_enrollee" class="list-group-item">Enrollees</a>
	<a href="<?=site_url('enrollees/daily_enrollees');?>"  class="list-group-item">Daily Enrollees</a>
	<a href="<?=site_url('registrar/subject_grades?id=main');?>" class="list-group-item">Subject Grades</a>
	<a href="<?=site_url('registar/generate_grade_slip');?>" class="list-group-item">Generate Grade Slip</a>
	<a href="<?=site_url('search/list_students/paid');?>" class="list-group-item">Paid Students</a>
	<a href="<?=site_url('search/deleted_accounts');?>" class="list-group-item">Deleted Accounts</a>
	
	
  <a href="#" class="list-group-item active" class="list-group-item">Report</a>
	<a href="<?php echo site_url(); ?>subjects" class="list-group-item">Subject</a>
	<a href="<?php echo site_url(); ?>ched" class="list-group-item">CHED</a>
	
	
  <a href="#" class="list-group-item active" class="list-group-item">Download</a>
	<a href="<?=site_url('registrar/generate_student_profile_excel/?id='.$l->link.'&di='.$l->hash);?>"class="confirm list-group-item" title="Continue Download?">All Student Profile</a>
	<a href="<?php echo site_url('tesda/tesda_by_course');?>" class="list-group-item">TESDA by Course</a>
</div>

	<!--<p class="acc" id="acc_first">Settings</p>
	<div class="acc_con">
		<a href="<?php echo base_url(); ?>certificate_of_enrollment_settings">Certificate of Enrollment</a>
        <a href="/summary_of_credits">Summary Of Credits</a>
	</div>-->
