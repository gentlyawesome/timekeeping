<?
  //FOR EDIT
  $edit = false;
  if(isset($module_data) && $module_data){
    $edit = true;
  }

?>


<!-- Select Project Code -->
<div class="form-group">
  <label class="col-md-4 control-label" for="module">Module Name</label>
  <div class="col-md-6">
  	<input value="<?=set_value('module[module]', $edit ? $module_data->module : '')?>" id="code" name="module[module]" maxlength="50" type="text" placeholder="Module Name" class="form-control input-md" required>
  </div>
</div>

