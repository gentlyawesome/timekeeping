<div id="right">
	<div id="right_bottom">
	
	<div>
	<?  
	echo validation_errors('<div class="alert alert-danger">', '</div>');
	?>
		<?echo form_open('');?>
		<?$this->load->view('announcements/_form')?>
		
			<?
				echo form_hidden('id', $announcement->id);
				echo form_submit('','Post');
				?>
					<a class='btn btn-success' href="<?php echo base_url(); ?>announcements">Back To List Of Announcements</a>
				<?
				echo form_close();
			?>
		
	</div>
	<div class="clear"></div>
	
</div>
	
	<div class="clear"></div>
</div>