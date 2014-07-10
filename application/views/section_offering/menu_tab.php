<ul class="nav nav-tabs">
  <li class="<?=$this->router->method == 'index' ? "active" : ''?>">
	<a href="<?php echo base_url('section_offering'); ?>"><span class="glyphicon glyphicon-hand-right"></span>
	&nbsp;
	<?=$course?></a>
  </li>
  
  <li class="<?=$this->router->method == 'search' ? "active" : ''?>">
	<a href="<?php echo base_url('section_offering/search'); ?>">
	<span class="glyphicon glyphicon-search"></span>
	&nbsp;
	Search All Block Section</a>
  </li>
</ul>