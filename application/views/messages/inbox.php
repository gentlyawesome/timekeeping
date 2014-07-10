<script type='text/javascript'>
	var x = 0;
	$(function() {
		//PREVENT LINKS FROM REDIRECTING
		$('#pg_recipient li a').click(function(event){
			event.preventDefault();
			var href = $(this).attr("href");
			next_page = (href.substr(href.lastIndexOf('/') + 1));
			Search_inbox(next_page);
		})
		
		setInterval(function(){
		  check_new_message();
		},5000);
	});
	
	function check_new_message()
	{
		var userid = "<?=$this->session->userdata['userid'];?>";
		if(userid == null || userid == "") 
		{ return false; }
		
		//FIRST CHECK IF THERE IS A SELECTED RECIPIENT
		//CHECK HIDDEN VALUE
		var conversation_id = $('#hidden_conversation_id').val();
		var recipient_id = $('#hidden_recipient_id').val();
		
		var controller = 'ajax_message';
		var base_url = '<?php echo base_url(); ?>'; 
		
		if(conversation_id != null && conversation_id != ""
			&& recipient_id != null && recipient_id != "")
		{
			//CHECK IF THERE ARE NEW UNREAD MESSAGES FROM RECIPIENT THROUGH AJAX	
			$.ajax({
				'url' : base_url + '' + controller + '/check_new_unread_message',
				'type' : 'POST', 
				'async': false,
				'data' : {
					'conversation_id' : conversation_id,
					'recipient_id' : recipient_id
				},
				'dataType' : 'json',
				'success' : function(data){ 
					
					if(data.status)
					{
						select_recipient(conversation_id, $( "a[conversation_id*='"+conversation_id+"']" ), recipient_id); //RELOAD THE GET MESSAGES LIST
					}
					
				}
			})
		}
		
		//UPDATE INBOX LIST BADGES FOR UNREAD MESSAGES
		
		//GET INBOX LIST THAT ARE BEIGN DISPLAYED
		
		$('#recipient_content div a').each(function(){
			
			var conversation_id = $(this).attr('conversation_id');
			
			$.ajax({
				'url' : base_url + '' + controller + '/check_all_unread_message',
				'type' : 'POST', 
				'async': false,
				'data' : {
					'conversation_id' : conversation_id
				},
				'dataType' : 'json',
				'success' : function(data){ 
					
					if(data.unread > 0)
					{
						$('#badge_read_'+conversation_id).text(data.unread);
					}
				}
			})
		});
		
	}
	
	function Search_inbox(page)
	{
		var page = page == null ? 0 : page;
		if(page == '#') { return }
		
		$.blockUI({ message: "" }); 
		var xreturn = false;
		var controller = 'ajax_message';
		var base_url = '<?php echo base_url(); ?>'; 
		
		$.ajax({
			'url' : base_url + '' + controller + '/get_inbox/'+page,
			'type' : 'POST', 
			'async': false,
			'data' : {},
			'dataType' : 'html',
			'success' : function(data){ 
				$('#inbox_list').html('');
				$('#inbox_list').html(data);
				
				$('#pg_recipient li a').click(function(event){
					event.preventDefault();
					var href = $(this).attr("href");
					next_page = (href.substr(href.lastIndexOf('/') + 1));
					Search_inbox(next_page);
				})
			}
		})
		.done(function() {
			  $.unblockUI(); 
		  });
		
	}
	
	function Search_message(page, conversation_id)
	{
		var page = page == null ? 0 : page;
		if(page == '#') { return }
		
		$.blockUI({ message: "" }); 
		var xreturn = false;
		var controller = 'ajax_message';
		var base_url = '<?php echo base_url(); ?>'; 
		
		$.ajax({
			'url' : base_url + '' + controller + '/get_message/'+page,
			'type' : 'POST', 
			'async': false,
			'data' : {
				'conversation_id' : conversation_id
			},
			'dataType' : 'html',
			'success' : function(data){ 
				$('#message_content div').remove();
				$('#message_content').html(data);
				
				$('#pg_message_list li a').click(function(event){
					event.preventDefault();
					var href = $(this).attr("href");
					next_page = (href.substr(href.lastIndexOf('/') + 1));
					Search_message(next_page, conversation_id);
				})
			}
		})
		.done(function() {
			  $.unblockUI(); 
		  });
		
	}
	
	function select_recipient(conversation_id, element, recipient_id)
	{
		$.blockUI({ message: "<h4>Please wait while the system fetches your messages...</h4>" }); 
		var xreturn = false;
		var controller = 'ajax_message';
		var base_url = '<?php echo base_url(); ?>'; 
		$.ajax({
			'url' : base_url + '' + controller + '/get_message',
			'type' : 'POST', 
			'async': false,
			'data' : {
						'conversation_id' : conversation_id
						},
			'dataType' : 'html',
			'success' : function(data){ 
				$('#message_content div').remove();
				$('#message_content').html(data);
				
				//REMOVE BADGE OF UNREAD
				$('#badge_read_'+conversation_id).hide('slow');
				
				$('#pg_message_list li a').click(function(event){
					event.preventDefault();
					var href = $(this).attr("href");
					next_page = (href.substr(href.lastIndexOf('/') + 1));
					Search_message(next_page, conversation_id);
				});
				
				$('#recipient_content div a').removeClass('active');
				$(element).addClass('active');
				
				$('#btn_reply').removeAttr('disabled');
				$('#hidden_conversation_id').val(conversation_id);
				$('#hidden_recipient_id').val(recipient_id);
				
			}
		})
		.done(function() {
			  $.unblockUI(); 
		});
	}
	
	function delete_message(element, id)
	{
		$.blockUI({ message: "<h4>Please wait while the system removes your message...</h4>" }); 
		var xreturn = false;
		var controller = 'ajax_message';
		var base_url = '<?php echo base_url(); ?>'; 
		$.ajax({
			'url' : base_url + '' + controller + '/delete_message',
			'type' : 'POST', 
			'async': false,
			'data' : {
						'id' : id
						},
			'dataType' : 'json',
			'success' : function(data){ 
				
				if(data.status)
				{
					$('#message_id_'+id).hide('slow');
				}
			}
		})
		.done(function() {
			  $.unblockUI(); 
		});
	}
	
	function reply()
	{
		var txtarea = $('#message');
		
		if(txtarea.val().trim() == "")
		{
			$('#message').focus();
			return false;
		}
		
		$.blockUI({ message: "<h4>Message sending...</h4>" }); 
		var xreturn = false;
		var controller = 'ajax_message';
		var base_url = '<?php echo base_url(); ?>'; 
		
		var conversation_id = $('#hidden_conversation_id').val();
		var recipient_id = $('#hidden_recipient_id').val();
		
		if(conversation_id == "") { return; }
		if(recipient_id == "") { return; }
		
		$.ajax({
			'url' : base_url + '' + controller + '/reply',
			'type' : 'POST', 
			'async': false,
			'data' : {
						'message' : txtarea.val().trim(),
						'conversation_id' : conversation_id,
						'recipient_id' : recipient_id
						},
			'dataType' : 'html',
			'success' : function(data){ 
				if(data.trim() != "FAILED")
				{
					$('#message_content div').remove();
					$('#message_content').html(data);
					
					$('#pg_message_list li a').click(function(event){
						event.preventDefault();
						var href = $(this).attr("href");
						next_page = (href.substr(href.lastIndexOf('/') + 1));
						Search_message(next_page, conversation_id);
					})
					
					$('#message').val('');
					$('#message').focus();
				}
			}
		})
		.done(function() {
			  $.unblockUI(); 
		});
		
		return false;
	}
	
</script>

<?php $this->load->view('messages/menu_tab'); ?>

<br/>

<div class="row" id='inbox_list'>
  <div class="col-md-3" id='recipient_content'>
	<div class="list-group">
	 <?if($recipients):?>
		<?foreach($recipients as $obj):?>
			
			<?
				$userid = $this->session->userdata['userid'];
				if($userid == $obj->user1_id) 
				{
					//display user 2
					$name = $obj->user2_name == "" ? $obj->user2_login : $obj->user2_name; //GET LOGIN IF NAME BLANK
					$recipient_id = $obj->user2_id;
				}
				else
				{
					//display user 1
					$name = $obj->user1_name == "" ? $obj->user1_login : $obj->user1_name; ////GET LOGIN IF NAME BLANK
					$recipient_id = $obj->user1_id;
				}
				
				$name = ucwords(ellipsis($name, 20));
			?>
			
		  <a href="javascript:;" class="list-group-item" style='font-size:8pt' conversation_id='<?=$obj->id?>' onclick="select_recipient('<?=$obj->id?>', this,'<?=$recipient_id?>')" >
			<span class="glyphicon glyphicon-user"></span>
			<?=$name ?>
			
				<span class="badge" id='badge_read_<?=$obj->id?>' style='font-size:6pt'><?=isset($recipients_count[$obj->id]) && $recipients_count[$obj->id] > 0 ? $recipients_count[$obj->id] : ''?></span>
			
		  </a>
		<?endforeach;?>
		<?=$links?>
	 <?else:?>
	 <a href="#" class="list-group-item">No message</a>
	 <?endif;?>
	</div>
  </div>
  
  <div class="col-md-8" >
		<div class="wells">
		<? $frmattr = 'class="form-horizontal" role="form" onsubmit="return reply()"'; ?>
			<?echo form_open('', $frmattr)?>
			  <div class="form-group">
				<div class="col-sm-12">
				  <textarea name ='message' id ='message' class="form-control" rows="4"></textarea>
				  <input type="hidden" id="hidden_conversation_id" name="hidden_conversation_id" value="" />
				  <input type="hidden" id="hidden_recipient_id" name="hidden_recipient_id" value="" />
				</div>
				
			  </div>
			  <div class="form-group" style='float:right'>
				<div class="col-sm-12">
				  <button type="submit" disabled id='btn_reply' class="btn btn-primary">Submit</button>
				</div>
			  </div>
			</form>
		</div>
		<br/>
		<br/>
		<br/>
		<div class="well" id='message_content'>
			<p>Select recipient from the left.</p>
		</div>
  </div>
</div>