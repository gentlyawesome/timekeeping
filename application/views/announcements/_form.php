<?
	if($announcement)
	{
		$message_val = $announcement->message;
	}else{
		$message_val = '';
	}
	$m_att = array('name'=>'message','value'=>$message_val);
	
	if($announcement)
	{
		$date_val = date('m/d/Y',strtotime($announcement->date));
	}else{
		$date_val = '';
	}
	$d_att = array('name'=>'date','value'=>$date_val, 'class'=>'datepicker', 'size'=>'20x20');
 ?>

  <p>
    <label for="message">Message</label><br />
	<?php echo form_textarea($m_att); ?>
  </p>
  <p>
    <label for="date">Date</label><br />
	<?php echo form_input($d_att); ?>
  </p>
  <div class="clear"></div>
  <p>
    <input type="checkbox" name="to_whom[]" value="student" 
	<?php if($announcement)
	{
	echo $announcement->to_student=='' || $announcement->to_student=='0' ? "":"checked"; 
	}
	?>
	/>
    <label for="to_student">To Students</label>
  </p>
  <p>
	<input type="checkbox" name="to_whom[]" value="employee" 
	<?php if($announcement)
	{
	echo $announcement->to_employee=='' || $announcement->to_employee=='0' ? "":"checked"; 
	}
	?> 
	/>
    <label for="to_employee">To Employees</label>
  </p>
  <p>
    <input type="checkbox" name="to_whom[]" value="all" 
	<?php if($announcement)
	{
	echo $announcement->to_all=='' || $announcement->to_all=='0' ? "":"checked"; 
	}
	?> 
	/>
     <label for="to_all">To All</label>
  </p>

