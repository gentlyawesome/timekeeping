<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Employee ID</label>  
  <div class="col-md-4">
  <input id="empid" name="data[empid]" type="text" placeholder="Login" class="form-control input-md" maxlength="12" value="<?=isset($empid)?$empid:''?>" required>
  <span class="help-block">Employee Id / Login ID</span>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Last Name</label>  
  <div class="col-md-6">
  <input id="last_name" name="data[last_name]" type="text" placeholder="Last Name" class="form-control input-md" maxlength="120" value="<?=isset($last_name)?$last_name:''?>" required>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">First Name</label>  
  <div class="col-md-6">
  <input id="first_name" name="data[first_name]" type="text" placeholder="First Name" class="form-control input-md" maxlength="120" value="<?=isset($first_name)?$first_name:''?>" required>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Middle Name</label>  
  <div class="col-md-6">
  <input id="middle_name" name="data[middle_name]" type="text" placeholder="Middle Name" class="form-control input-md" maxlength="120" value="<?=isset($middle_name)?$middle_name:''?>" required>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Gender</label>  
  <div class="col-md-6">
  	<?
  		$sex = array(
  				'Male' => 'Male',
  				'Female' => 'Female',
  			);

  		echo form_dropdown('data[gender]', $sex, isset($gender)?$gender:'');
  	?>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Birth Date</label>  
  <div class="col-md-6">
  <input id="dob" class="date_pick" name="data[dob]" type="text" placeholder="Birth Date (yyyy-mm-dd)" class="form-control input-md" maxlength="120" value="<?=isset($dob)?$dob:date('1990-m-d')?>" required>  
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">E-mail</label>  
  <div class="col-md-6">
  <input id="email" name="data[email]" type="text" placeholder="E-mail" class="form-control input-md" maxlength="120" value="<?=isset($email)?$email:''?>" required>  
  </div>
</div>


