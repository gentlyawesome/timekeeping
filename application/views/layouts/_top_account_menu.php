<ul class="nav navbar-nav navbar-right">
  <li>
  	<a href="#">
  		<img src="<?php echo base_url(); ?>assets/images/student.png" style="height: 18px; width: 18px;" />
  	</a>
  </li>

  <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=strtoupper($this->session->userdata['username']);?> <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="<?=base_url()?>events">Calendar</a></li>
      <li><a href="<?=base_url()?>change_password/index/<?php echo $this->session->userdata('userid'); ?>">Change Password</a></li>
      <li class="divider"></li>
      <li><a href="<?php echo base_url(); ?>auth/logout">Logout</a></li>
    </ul>
  </li>
</ul>