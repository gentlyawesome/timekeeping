<div class="well">
	<h4><div class='label label-info'>Year : <?=$student->year;?> </div>|<div class='label label-info'> Course : <?=$student->course?></div>|<div class='label label-info'> School Year : <?=$student->sy_from?>-<?=$student->sy_to?></div></h4>
</div>
<?php $this->load->view("layouts/student_data/_student_subjects"); ?>	