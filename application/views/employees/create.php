<?echo form_open('','onsubmit="return validate()" class="form-horizontal"');?>
<fieldset>

	<?$this->load->view('employees/_form')?>

	<!-- Button (Double) -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="button1id">Double Button</label>
	  <div class="col-md-8">
	    <input type="submit" value="Save Changes" name="save_employees"  class="btn btn-success btn-sm" />
	    <a href="<?=site_url('employees')?>" class="btn btn-default btn-sm">Go Back</a>
	  </div>
	</div>

</fieldset>
<?echo form_close();?>