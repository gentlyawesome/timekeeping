<?=form_open('','class="form-horizontal"')?>

<?@$this->load->view('modules/_form');?>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id"></label>
  <div class="col-md-8">
    <input type='submit' name='save' value="Add Module" class="btn btn-success">
    <a href="<?=site_url('modules')?>" class="btn btn-primary" >View Module List</a>
  </div>
</div>
</form>
