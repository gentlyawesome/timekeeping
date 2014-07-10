<ul class="nav nav-tabs">
  <li class="<?=$this->router->method == 'inbox' ? "active" : ''?>">
	<a href="<?php echo base_url('messages/inbox'); ?>"><span class="glyphicon glyphicon-envelope"></span>
	&nbsp;
	Inbox</a>
  </li>
  
  <li class="<?=$this->router->method == 'new_message' ? "active" : ''?>">
	<a href="<?php echo base_url('messages/new_message'); ?>">
	<span class="glyphicon glyphicon-plus"></span>
	&nbsp;
	New Message</a>
  </li>
</ul>