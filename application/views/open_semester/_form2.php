<?php
	$f_acad_years = array();
	if(isset($academic_years)){
		foreach($academic_years as $obj){
			$f_acad_years[$obj->id] = $obj->year_from.'-'.$obj->year_to;
		}
	}
	$f_semesters = array();
	if(isset($semesters)){
		foreach($semesters as $obj){
			$f_semesters[$obj->id] = $obj->name;
		}
	}
?>

	<p>
		<label for="academic_years">Academic Years : </label><br />
		<?=form_dropdown('open_semesters[academic_year_id]',$f_acad_years, isset($open_semesters) ? $open_semesters->academic_year_id : '');?>
	</p>
	<p>
		<label for="semesters">Semesters : </label><br />
		<?=form_dropdown('open_semesters[semester_id]',$f_semesters, isset($open_semesters) ? $open_semesters->semester_id : '');?>
	</p>
  <div class="clear"></div>

