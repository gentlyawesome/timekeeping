<?php
// Gets the current uri controller and returns true or false
function uri($uri)
{
	$ci =& get_instance();
	return $ci->uri->segment(1) == strtolower($uri) ? TRUE : FALSE;
}
?>


<?php if(uri('enrollment')):?>
	<div id="side_menu">
		<p class="acc" id="acc_first">Student Section</p>
			<div class="acc_con">
				<a href="/search/student">Search Student</a><br>
				<a href="/student/enrollee">Enrollees</a><br>
			</div>
		<p class="acc">Course Settings</p>
			<div class="acc_con">
				<a href="/subjects">Subject</a><br />
				<a href="/master_list_by_course">Master list by course</a><br />
            </div>

			<div class="acc_con">
			    <a href="/">Home</a> <br>
				<a href="/open_semester_employee_settings/2/edit">Open Semester</a><br />
			    <a href="/change_password/7204">Change Password</a><br>
				<a href="/news-and-events">News and Events</a><br>
				<a href="/logout">Logout</a> <br>
			</div>
			<p class="acc" id="acc_last">My Account</p>
	</div>
<?php elseif(uri('cashier')):?>


<!-- cashier side menu here-->



<?php endif;?>