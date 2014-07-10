<?=form_open('','class="form-horizontal"')?>

<?@$this->load->view('project/_form');?>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id"></label>
  <div class="col-md-8">
    <input type='submit' name='save' value="Add Project" class="btn btn-success">
    <a href="<?=site_url('project')?>" class="btn btn-primary" >View Project List</a>
  </div>
</div>
</form>
