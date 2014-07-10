<?if($user_menus):?>
	<div class="list-group">
	<?foreach($user_menus as $obj):?>
		
			<?if($obj->controller === "#"):?>
				<a href="#" class="list-group-item active"><?=$obj->caption;?></a>
			<?elseif($obj->controller === "messages"):?>
				<a href="<?=base_url()?><?=$obj->controller;?>" class="list-group-item"><?=$obj->caption;?>
				<span class='badge' id='menu_unread_badge' ></span>
				</a>
				
			<?else:?>
				<a href="<?=base_url()?><?=$obj->controller;?>" class="list-group-item"><?=$obj->caption;?></a>
			<?endif;?>
		
	<?endforeach;?>
	</div>
<?endif;?>