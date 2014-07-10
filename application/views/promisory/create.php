<div id="right">
	<div>
		<?echo form_open('','onsubmit="return validate()"');?>
		<?$this->load->view('promisory/_form')?>
		
			<?
				echo form_submit('','Submit');
				?>
				| <a class='btn btn-primary' href="<?php echo base_url(); ?>promisory/index/<?=$enrollment_id?>" rel="facebox" class="actionlink">Back to Promisory</a>
				<?
				echo form_close();
			?>
		
	</div>
</div>
	
	<div class="clear"></div>
</div>