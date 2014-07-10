<div id="right">
	<div id="right_bottom">

	<div>
	<?  
	echo validation_errors('<div class="alert alert-danger">', '</div>');
	?>
		<?echo form_open('');?>
		<?$this->load->view('remarks/_form')?>
		
			<?
				echo form_hidden('id', $remarks->id);
				echo form_submit('','Save Changes');
				?>
				| <a class='btn btn-success' href="<?php echo base_url(); ?>remarks" rel="facebox" class="actionlink">Back to list of Remarks</a>
				<?
				echo form_close();
			?>
		
	</div>
</div>
	
	<div class="clear"></div>
</div>