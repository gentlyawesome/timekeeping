<ul class="nav navbar-nav navbar-left">
  <li><a href="#">Date: <?php 
	$h = "8";// Hour for time zone goes here e.g. +7 or -4, just remove the + or -
	$hm = $h * 60;
	$ms = $hm * 60;
	$now = time();
	$gmt = local_to_gmt($now);
	$gmdate = $gmt+($ms); // the "-" can be switched to a plus if that's what your time zone is.
	echo date("F d, Y",$gmdate); 
	?></a></li>
  <li><a href="#">Time: <?php echo date("h:i:s A",$gmdate); ?></a></li>        
</ul>

<ul class="nav navbar-nav navbar-right">
  <li>
	<a href="#">
		WELCOME : 
		<img src="<?php echo base_url(); ?>assets/images/student.png" style="height: 25px; width: 25px;" />
		<?=strtoupper($this->session->userdata['username']);?>
	</a></li>
  <li><a href="#"><?php $this->load->view('layouts/open_semester'); ?></a></li>
</ul>
