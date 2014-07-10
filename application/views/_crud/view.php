<div class="row">
<?=form_open('','class="form-horizontal"')?>
<fieldset>

<!-- Form Name -->
<?if(isset($disable_title) && $disable_title == true ):?>
<?else:?>
  <legend>Create : <?=$title?></legend>
<?endif;?>
      
      <?$this->load->view('_crud/_form');?>
    
      <!-- Button (Double) -->
    <div class="form-group">
      <label class="col-md-2 control-label" for="button1id">Actions</label>
      <div class="col-md-6">
        <a href="<?=site_url($controller_method)?>" class="btn btn-sm btn-default">View List</a>
      </div>
    </div>

</fieldset>
</form>
</div>