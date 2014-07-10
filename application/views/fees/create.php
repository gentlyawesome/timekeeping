<div id="right">
	<div>
	<?  
	echo validation_errors('<div class="alert alert-danger">', '</div>');
	?>
		<?echo form_open('');?>
		<?$this->load->view('fees/_form')?>
		
			<?
				echo form_submit('','Save Changes');
				echo form_close();
			?>
		
	</div>
	<div class="clear"></div>
	<br/>
	<p>
		<a href="<?php echo base_url(); ?>fees" rel="facebox" class="actionlink">Back to list of Fees</a>
	</p>
</div>
	
	<div class="clear"></div>
</div>