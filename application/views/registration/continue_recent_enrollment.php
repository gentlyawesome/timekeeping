<div class="well">
	<div class='alert alert-warning'>
		<h4>You have an unfinished registration last <?=date('M d Y g:h a', strtotime($temp_start->created_at))?>.</h4>
	</div>
	
	<?=form_open('')?>
	<?=form_submit('continue','Continue Recent Registration');?>
	<?=form_submit('start','Start New Registration');?>
	<?=form_close();?>
</div>