<div class="row">
<div class="twelve columns">
  <div id="school_name">
  <h1><?php echo $this->setting->school_name; ?> </h1>	
  </div>
  Date: <?php 
	$h = "8";// Hour for time zone goes here e.g. +7 or -4, just remove the + or -
	$hm = $h * 60;
	$ms = $hm * 60;
	$now = time();
	$gmt = local_to_gmt($now);
	$gmdate = $gmt+($ms); // the "-" can be switched to a plus if that's what your time zone is.
	echo date("F d, Y",$gmdate); 
	?><br />
  Time: <?php echo date("h:i:s A",$gmdate); ?><br />
  </div>
</div>

