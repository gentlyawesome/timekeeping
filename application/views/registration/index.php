<script type="text/javascript">
  function validate(data)
  {
	
	just_a_moment();
	
	var course_id = $('#course_id').val();
	var year_id = $('#year_id').val();
	
	if(course_id == "")
	{
		closeui();
		custom_modal('Error','<h4>No Course Selected</h4>');
		return false;
	}
	else
	{
		if(year_id == "")
		{
			closeui();
			custom_modal('Error','<h4>No Year Selected</h4>');
			return false;
		}
		else
		{
			return true;
		}
	}
  }
  
</script>
<?if($open_enrollment):?>
	<?if($open_enrollment->open_enrollment == 1):?>
		
		<?$this->load->view('registration/header');?>
		<?=form_open('','onsubmit="return validate(this)"');?>
		<fieldset class="scheduler-border">
			<legend class="scheduler-border">Select Course and Year</legend>
			<div>
				<table>
					<tr>
						<td>Course</td>
						<td><?=course_dropdown('course_id',$student->course_id,'id="course_id"','Select Course');?>
						</td>
						<td>Year</td>
						<td><?=year_dropdown('year_id',$student->year_id,'id="year_id"','Select Year');?></td>
					</tr>
					<tr>
						<td colspan='2' style='text-align:right'>To continue select one of these buttons.</td>
						<td colspan='2'>
							<input type="submit" class='disable_after_click' name="submit" value="Block" class="btn btn-success">
							<input type="submit" class='disable_after_click' name="submit" value="Irregular" class="btn btn-primary">
							<input type="submit" class='disable_after_click' name="submit" value="Summer" class="btn btn-danger">
						</td>
					</tr>
				</table>
			</div>
		</fieldset>
		<?=form_close();?>
		
	<?else:?>
		<a href = '<?=base_url()?>registration' class='btn btn-primary'><span class='glyphicon glyphicon-refresh'> Check Again</a>
		<br/><br/>
		<div class='jumbotron'>
			<div style='color:maroon'>Registration is not yet open. Please try again later.</div>
		</div>
	<?endif;?>
<?endif;?>