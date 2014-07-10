 <script>
	function validate(){
		
		var validate = true;
		var ctr = 0;
		var xcurrent = $('#currentpassword');
		var xnew = $('#newpassword');
		var xverify = $('#verifypassword');
		
		$('.form-control').css('border-color','gray');
		$('.form-control').each(function(){
			if($(this).val().trim() == ""){
				$(this).css('border-color','red');
				ctr++;
			}
		});
		
		if(ctr > 0 )
		{
			$.blockUI({ message: '<h3>All fields are required.</h3>' }); 
			$.blockUI.defaults.applyPlatformOpacityRules = false;
			$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
			return false;
		}
		else
		{
			if(xnew.val().trim().length < 8){
				$.blockUI({ message: '<h3>New password should be atleast 8 characters.' }); 
				$.blockUI.defaults.applyPlatformOpacityRules = false;
				$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
				return false;
			}
			if(xverify.val().trim().length < 8){
				$.blockUI({ message: '<h3>Verify password should be atleast 8 characters.' }); 
				$.blockUI.defaults.applyPlatformOpacityRules = false;
				$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
				return false;
			}
			if(xnew.val().trim() != xverify.val().trim()){
				$.blockUI({ message: '<h3>New password and verify password do not match.' }); 
				$.blockUI.defaults.applyPlatformOpacityRules = false;
				$('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
				return false;
			}
			return true;
		}
	}
 </script>
 
 <div class="alert alert-warning">
	<p>All fields are required.</p>
	<p>Mininum of eight (8) characters.</p>
  </div>
<?echo form_open('','class="form-horizontal" role="form" onsubmit="return validate()"');?>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Current Password *</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="currentpassword" name="currentpassword" placeholder="Current Password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">New Password *</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password">
    </div>
  </div>
   <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Verify Password *</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="verifypassword" name="verifypassword" placeholder="Verify Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
		<?
			echo form_submit('','Submit');
			echo form_close();
		?>
    </div>
  </div>
  
  <div id='message' style='display:none;'>
		<div id='message_list' class='alert alert-info'>
			Validating ... 
		<div>
   </div>