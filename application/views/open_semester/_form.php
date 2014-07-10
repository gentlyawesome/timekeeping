<?php foreach($opensemesters as $opensemester): ?>
	<?php echo form_radio('open_semester_id',$opensemester->id, $opensemester->id == $opensemesteruser->open_semester_id ? "TRUE":"" ); ?> <?php echo $opensemester->academic_year; ?> <?php echo $opensemester->name; ?> <br />
<?php endforeach; ?>