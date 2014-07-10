<?$this->load->view('registration/header');?>

<?=form_open('','onsubmit="return validate(this)"');?>		

<?$this->load->view('registration/_enrollment_form');?>			
	
	<div class="well">
		<div class="row small_font">
			<div class="col-md-8"></div>
			<div class="col-md-4">
				
				<?=form_submit('','Save and Finish your Registration','id="submit"');?>
				
			</div>
		</div>
	</div>	
	
<?=form_close();?>