<?if($user_menus):?>
   <ul class="nav navbar-nav">
  <?foreach($user_menus as $obj):?>
      <?$xactive = check_the_active_menu($obj->controller) ? 'active' : '';?>
      <?if($obj->controller === "#"):?>
      <?elseif($obj->controller === "messages"):?>
        <li class="<?=$xactive?>" ><a href="<?=base_url()?><?=$obj->controller;?>"><?=$obj->caption;?></a></li>
        <span class='badge' id='menu_unread_badge' ></span>
        </a>
        
      <?else:?>
        <li class="<?=$xactive?>" ><a href="<?=base_url()?><?=$obj->controller;?>"><?=$obj->caption;?></a></li>
      <?endif;?>
    
  <?endforeach;?>
  </ul>
<?endif;?>
