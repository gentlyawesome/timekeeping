<div id="right">
	<div>
	<?  
	echo validation_errors('<div class="alert alert-danger">', '</div>');
	
	?>
		<?echo form_open('');?>
		<?echo form_submit('','Save Changes');?>
		<?$this->load->view('open_semester/_form2')?>
		
			<?
				echo form_submit('','Save Changes');
				?>
				| <a class='btn btn-success' href='<?=base_url()?>open_semester'>Back to List of Open Semesters</a>
				<?
				echo form_close();
			?>
		
	</div>

</div>
	
	<div class="clear"></div>
</div>