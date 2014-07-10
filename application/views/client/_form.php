<?
  //FOR EDIT
  $edit = false;
  if(isset($client_data) && $client_data){
    $edit = true;
  }

?>


<!-- Select Client Code -->
<div class="form-group">
  <label class="col-md-4 control-label" for="code">Client Code</label>
  <div class="col-md-6">
  	<input <?=$edit ? 'readonly' : ''?> value="<?=set_value('client[code]', $edit ? $client_data->code : '')?>" id="code" name="client[code]" maxlength="25" type="text" placeholder="Client Code" class="form-control input-md" required>
  </div>
</div>

<!-- Select Client Name -->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Client Name</label>
  <div class="col-md-6">
    <input value="<?=set_value('client[name]', $edit ? $client_data->name : '')?>" id="name" name="client[name]" maxlength="100" type="text" placeholder="Client Name" class="form-control input-md" required>
  </div>
</div>

<!-- Select Client Address -->
<div class="form-group">
  <label class="col-md-4 control-label" for="address">Client Address</label>
  <div class="col-md-6">
    <input value="<?=set_value('client[address]', $edit ? $client_data->address : '')?>" id="address" name="client[address]" maxlength="255" type="text" placeholder="Client Address" class="form-control input-md" required>
  </div>
</div>

<!-- Select Client Telepone -->
<div class="form-group">
  <label class="col-md-4 control-label" for="tel">Client Telephone</label>
  <div class="col-md-6">
    <input value="<?=set_value('client[tel]', $edit ? $client_data->tel : '')?>" id="tel" name="client[tel]" maxlength="50" type="text" placeholder="Client Telephone" class="form-control input-md" required>
  </div>
</div>

<!-- Select Client Email -->
<div class="form-group">
  <label class="col-md-4 control-label" for="tel">Client Email</label>
  <div class="col-md-6">
    <input value="<?=set_value('client[email]', $edit ? $client_data->email : '')?>" id="email" name="client[email]" maxlength="100" type="text" placeholder="Client Email" class="form-control input-md" required>
  </div>
</div>

<!-- Select Client Contact Person -->
<div class="form-group">
  <label class="col-md-4 control-label" for="tel">Contact Person</label>
  <div class="col-md-6">
    <input value="<?=set_value('client[contact_person]', $edit ? $client_data->contact_person : '')?>" id="contact_person" name="client[contact_person]" maxlength="255" type="text" placeholder="Contact Person" class="form-control input-md" required>
  </div>
</div>

<!-- Select Client Contact Person Telephone -->
<div class="form-group">
  <label class="col-md-4 control-label" for="tel">Contact Person Telephone</label>
  <div class="col-md-6">
    <input value="<?=set_value('client[contact_person_tel]', $edit ? $client_data->contact_person_tel : '')?>" id="contact_person_tel" name="client[contact_person_tel]" maxlength="255" type="text" placeholder="Contact Person Telephone" class="form-control input-md" required>
  </div>
</div>

<!-- Select Client Active / NOt -->
<div class="form-group">
  <label class="col-md-4 control-label" for="tel">Is Active?</label>
  <div class="col-md-6">
    <?
      $active = array(
          1 => "YES",
          0 => "NO"
        );

      echo form_dropdown('client[is_active]',$active,set_value('client[is_active]', $edit ? $client_data->is_active : ''),'class="form-control"');
    ?> 
  </div>
</div>

