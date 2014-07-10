<?  echo validation_errors('<div class="alert alert-danger">', '</div>');?>

<?echo form_open('');?>
		
<?$this->load->view('issues/_form')?>
		
<?
	echo form_submit('','Save Changes');
  echo form_close();
?>
<br>
<a href="<?php echo base_url(); ?>issues/view/<?= $enrollment_id ?>/<?= $user_id ?>" >Back to List</a>
