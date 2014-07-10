<script type='text/javascript'>
	function validate()
	{
		var recipient_id = $('#recipient_id');
		var message_id = $('#message');
		
		if(recipient_id.val().trim() == "")
		{
			recipient_id.focus();
			return false;
		}
		else
		{
			if(message_id.val().trim() == "")
			{
				$('#alertModal_Label').text('Required Fields'); //SET MODAL TITLE
				$('#alertModal_Body').html('<p>No message content to send.</p>'); //SET MODAL CONTENT
				$('#alertModal').modal('show'); //SHOW MODAL
				
				message_id.focus();
				
				return false;
			}
			
			return true;
		}
	}
</script>

<?php $this->load->view('messages/menu_tab'); ?>
<br/>

<div class="alert alert-success">Please observe proper etiquette.</div>
<div class="well">
	<? $frmattr = 'class="form-horizontal" role="form" onsubmit="return validate()"'; ?>
	<?echo form_open('', $frmattr)?>
	  <div class="form-group">
		<label for="inputEmail3" class="col-sm-2 control-label">To</label>
		<div class="col-sm-10">
			<?=users_dropdown_for_messages('recipient_id',NULL, 'Choose Recipient', 'id="recipient_id"');?>
		</div>
	  </div>
	  <div class="form-group">
		<label for="inputPassword3" class="col-sm-2 control-label">Message</label>
		<div class="col-sm-10">
		  <textarea name ='message' id ='message' class="form-control" rows="7"></textarea>
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		  <button type="submit" class="btn btn-primary">Send</button>
		</div>
	  </div>
	</form>
</div>