<?
  //FOR EDIT
  $edit = false;
  if(isset($project_data) && $project_data){
    $edit = true;
  }

?>


<!-- Select Project Code -->
<div class="form-group">
  <label class="col-md-4 control-label" for="code">Project Code</label>
  <div class="col-md-6">
  	<input <?=$edit ? 'readonly' : ''?> value="<?=set_value('project[code]', $edit ? $project_data->code : '')?>" id="code" name="project[code]" maxlength="25" type="text" placeholder="Project Code" class="form-control input-md" required>
  </div>
</div>

<!-- Select Project Name -->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Project Name</label>
  <div class="col-md-6">
    <input value="<?=set_value('project[name]', $edit ? $project_data->name : '')?>" id="name" name="project[name]" maxlength="100" type="text" placeholder="Project Name" class="form-control input-md" required>
  </div>
</div>

<!-- Select Client Active / NOt -->
<div class="form-group">
  <label class="col-md-4 control-label" for="is_active">Is Active?</label>
  <div class="col-md-6">
    <?
      $active = array(
          1 => "YES",
          0 => "NO"
        );

      echo form_dropdown('project[is_active]',$active,set_value('project[is_active]', $edit ? $project_data->is_active : ''),'class="form-control"');
    ?> 
  </div>
</div>

<!-- Select Project Started -->
<div class="form-group">
  <label class="col-md-4 control-label" for="date_started">Date Stared</label>
  <div class="col-md-6">
    <input value="<?=set_value('project[date_started]', $edit ? date('Y-m-d', strtotime($project_data->date_started)) : '')?>" id="date_started" name="project[date_started]" type="text" placeholder="yyyy-dd-mm" class="form-control input-md date_pick" required>
  </div>
</div>

<!-- Select Client IS DONE / NOt -->
<div class="form-group">
  <label class="col-md-4 control-label" for="is_done">Is DONE?</label>
  <div class="col-md-6">
    <?
      $active = array(
          0 => "NO",
          1 => "YES"
        );

      echo form_dropdown('project[is_done]',$active,set_value('project[is_done]', $edit ? $project_data->is_done : ''),'class="form-control"');
    ?> 
  </div>
</div>

<!-- Select Project Date EDnd -->
<div class="form-group">
  <label class="col-md-4 control-label" for="date_end">Date End</label>
  <div class="col-md-6">
    <input value="<?=set_value('project[date_end]', $edit && $project_data->is_done == 1 ? date('Y-m-d', strtotime($project_data->date_end)) : '')?>" id="date_end" name="project[date_end]" type="text" placeholder="yyyy-dd-mm" class="form-control input-md date_pick">
  </div>
</div>

