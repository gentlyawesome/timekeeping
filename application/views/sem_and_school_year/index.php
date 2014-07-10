<script type="text/javascript">
	$(document).ready(function(){
		
		  $('.radio1').on('switch-change', function () {
			$('.radio1').bootstrapSwitch('toggleRadioStateAllowUncheck', true);
		  });
		
	});
	
	function validate()
	{
		var num = parseInt($( "input:checked" ).length);
		
		if(num == 0)
		{	
			notify_modal('Error', 'No selected record');
			return false;
		}
	}
</script>
<?if($enrollments):?>
	<?=form_open('','onsubmit="return validate()"');?>
	<div class='alert alert-info'>Note : This will serve as the current enrollment that you can view in your profile page.</div>
	<table>
		<tr>
			<th>Select</th>
			<th>Semester</th>
			<th>Academic Year</th>
		</tr>
	<?foreach($enrollments as $obj):?>
		<tr>
			<td>
				<div class="make-switch radio1 switch-small">
				<input id="option5" type="radio" name="radio_select" id='id_<?=$obj->id?>' value='<?=$obj->id?>' <?=$obj->is_used == 1 ? 'checked' : ''?> />	
				</div>
			</td>
			<td><?=$obj->name?></td>
			<td><?=$obj->sy_from?>-<?=$obj->sy_to?></td>
		</tr>
	<?endforeach;?>
	</table>
	<?=form_submit('','Save','')?>
	<?=form_close();?>
<?endif;?>