<div class="alert alert-info text-center">
  <?php echo $student->studid; ?><br />
  <?php echo ucfirst($student->last_name).', '.ucfirst($student->first_name).' '.ucfirst($student->middle_name); ?><br>
  <?php echo $student->year . ' | '.$student->name . ' | '. $student->course; ?>
  <?=isset($current_period) ? " | ".$current_period->grading_period : ''?>
</div>
<ul class="nav nav-tabs">
	<li <?= ($this->router->class == "profile" && $this->router->method == 'view') ? "class='active'" : '' ?>>
	  <a href="<?php echo base_url('profile/view/'.$student->id); ?>">Student Profile</a></li>
	
	<!--li <?= ($this->router->class == "fees" && $this->router->method == 'view_fees') ? "class='active'" : '' ?>>
	  <a href="<?php echo base_url('fees/view_fees/'.$student->id); ?>">Student Fees</a></li-->
	
	  
	<li <?= ($this->router->class == "issues" && $this->router->method == 'view') ? "class='active'" : '' ?>>
	  <a href="<?php echo base_url('issues/view/'.$student->id.'/'.$student->user_id); ?>">Issues <span class="badge"><?= $total_issues;?></span></a></li>
	  
	<li <?= ($this->router->class == "promisory" && $this->router->method == 'index') ? "class='active'" : '' ?>>
	  <a href="<?php echo base_url('promisory/index/'.$student->id); ?>">Payment Promisory</a></li>
	<li>
	
</ul>
<br>
