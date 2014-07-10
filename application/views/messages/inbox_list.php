
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
				}
				else
				{
					//display user 1
					$name = $obj->user1_name == "" ? $obj->user1_login : $obj->user1_name; ////GET LOGIN IF NAME BLANK
				}
				
				$name = ucwords(ellipsis($name, 20));
			?>
			
		  <a href="javascript:;" class="list-group-item" style='font-size:8pt' conversation_id='<?=$obj->id?>' onclick="select_recipient('<?=$obj->id?>')" >
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
		<div class="well" id='message_content'>
			<p>Select recipient from the left.</p>
		</div>
  </div>