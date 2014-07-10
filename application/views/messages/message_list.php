<style>
	.class_sender {
	color: #3b5998;
	font-weight: bold;
	cursor: pointer;
	text-decoration: none;
	}
	.class_recipient {
	color: maroon;
	font-weight: bold;
	cursor: pointer;
	text-decoration: none;
	}
	.sender_time {
	color: gray;
	cursor: pointer;
	text-decoration: none;
	font-size:7pt;
	}
	.class_unread {
		background-color: #3b5998;
		color:white;
	}
	.class_read {
	
	}
</style>
<?if($messages):?>
	<?foreach($messages as $obj):?>
		<?
			$userid = $this->session->userdata['userid'];
			$name = $obj->sender_id == $userid ? "You" : $obj->name;
			$xclass = $obj->sender_id == $userid ? "class_sender" : "class_recipient";
			$name = ucwords($name);
			$rd_class =  strtoupper($name) == "YOU" ? "class_read" : ($obj->read == 0 ? "class_unread" : "class_read");
		?>
		<div id='message_id_<?=$obj->id?>' class='<?=$rd_class?> well'>
			<div>
				<div class="row">
					<div class="col-xs-12 col-md-8">
						<span class="glyphicon glyphicon-user"></span>
						<a class='<?=$xclass?>' href="#"><?=$name?></a>
					</div>
				  <div class="col-xs-6 col-md-3">
						<span class="glyphicon glyphicon-time"></span>
						<a class='sender_time' href="#"><?=date('m/d/Y g:h a', strtotime($obj->updated_at))?></a>
				  </div>
				  <?if(strtoupper($name) == "YOU"):?>
				  <div class="col-xs-6 col-md-1">
						<a href="javascript:;" onclick = "delete_message(this,'<?=$obj->id?>')"><span class="glyphicon glyphicon-remove"></span></a>
				  </div>
				  <?endif;?>
				</div>
				
				
				<div class='message_body'>
					<?=nl2br(htmlentities($obj->message))?>
				</div>
			</div>
		</div>
	<?endforeach;?>
	<?=$links?>
<?endif;?>