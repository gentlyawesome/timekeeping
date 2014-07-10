<?=form_open('','class="form-horizontal"')?>

<?@$this->load->view('client/_form');?>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id"></label>
  <div class="col-md-8">
    <input type='submit' name='save' value="Update Client" class="btn btn-success">
    <a href="<?=site_url('client')?>" class="btn btn-primary" >View Client List</a>
  </div>
</div>
</form>
