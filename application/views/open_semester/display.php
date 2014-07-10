<div id="right">

	<div id="right_top" >
		  <p id="right_title">Grading Period</p>
	</div>
	<div id="right_bottom">

<div id="grading_period_show">
<p>
	Grading Period :
	<a href='#'>
<?php echo $grading_periods->grading_period; ?><br>
	</a>
</p>
</div>

<p>
	<a href="<?php echo base_url(); ?>grading_periods/edit/<?=$grading_periods->id?>"  rel="facebox" class="actionlink">Edit</a> |
	<a href="<?php echo base_url(); ?>grading_periods/destroy/<?=$grading_periods->id?>" rel="facebox" class="actionlink confirm">Destroy</a> |
	<a href="<?php echo base_url(); ?>grading_periods" rel="facebox" class="actionlink">View All</a>
</p>

	</div>

</div>