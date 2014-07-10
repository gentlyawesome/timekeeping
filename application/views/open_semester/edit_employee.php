<div id="right">
	<div id="right_top" >
		  <p id="right_title">Open Semester Employee Setting</p>
	</div>
	<div id="right_bottom">

	<div>
	<?  
	echo validation_errors('<div class="alert alert-danger">', '</div>');
	?>
		<?echo form_open('');?>
		<?$this->load->view('open_semester/_form')?>
		
			<?
				echo form_submit('','Set Semester');
				echo form_close();
			?>
		
	</div>
	<div class="clear"></div>

</div>
	
	<div class="clear"></div>
</div>