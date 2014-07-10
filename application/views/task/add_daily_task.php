<?=form_open('','class="form-horizontal"')?>
<fieldset>

<!-- Form Name -->
<!-- <legend>Form Name</legend> -->

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="date">Date</label>  
  <div class="col-md-6">
  <input value="<?=set_value('monitoring[date]',date('Y-m-d'))?>" id="monitoring_date" name="monitoring[date]" type="text" placeholder="yyyy-mm-dd" class="form-control input-md date_pick" required>
  <span class="help-block">Date of the task finish</span>  
  </div>
</div>

<!-- Select Client -->
<div class="form-group">
  <label class="col-md-4 control-label" for="client_id">Client / Customer</label>
  <div class="col-md-6">
  	<?=form_dropdown('monitoring[client_id]',$client_list,set_value('monitoring[client_id]'),'id="monitoring_client_id" class="form-control" required');?>
  	<span class="help-block">Customer which the project is under.</span>  
  </div>
</div>

<!-- Select Project -->
<div class="form-group">
  <label class="col-md-4 control-label" for="project_id">Project</label>
  <div class="col-md-6">
  	<?=form_dropdown('monitoring[project_id]',$project_list,set_value('monitoring[project_id]'),'id="monitoring_project_id" class="form-control" required');?>
  	<span class="help-block">Name of the Project.</span>  
  </div>
</div>

<!-- Select Module -->
<div class="form-group">
  <label class="col-md-4 control-label" for="project_id">Module</label>
  <div class="col-md-6">
  	<?=form_dropdown('monitoring[module_id]',$module_list,set_value('monitoring[module_id]'),'id="monitoring_module_id" class="form-control" required');?>
  	<span class="help-block">What module of the project you are working on.</span>  
  </div>
</div>

<!-- Text input-->
<!-- <div class="form-group">
  <label class="col-md-4 control-label" for="hour">Hour(s)</label>  
  <div class="col-md-6">
  <input value="<?=set_value('monitoring[hour]')?>" id="monitoring_hour" name="monitoring[hour]" maxlength="4" type="text" placeholder="0.00" class="currency form-control input-md" required>
  <span class="help-block">How many hour/s did you finish this task.</span>  
  </div>
</div> -->

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="task">Task List</label>
  <div class="col-md-6">                     
    <textarea class="form-control" id="monitoring_task" name="monitoring[task]"><?=set_value('monitoring[task]')?></textarea>
    <span class="help-block">Your list of task finish.</span>  
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id"></label>
  <div class="col-md-8">
    <input type='submit' name='save_task' value="Save Task" class="btn btn-success btn-sm">
    <a href="<?=site_url('task/view_task_list')?>" class="btn btn-primary btn-sm" >View Task List</a>
  </div>
</div>

</fieldset>
</form>
