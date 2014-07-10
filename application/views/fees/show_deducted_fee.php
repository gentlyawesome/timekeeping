<?php

$amount = set_value('amount') == false ? $deducted_fee[0]->amount : set_value('amount');
$_amount = $deducted_fee[0]->amount;
$remarks = set_value('remarks') == false ? $deducted_fee[0]->remarks : set_value('remarks');
$date_c = $deducted_fee[0]->created_at;
$date_u = $deducted_fee[0]->updated_at;

/* END CONFIG */
?>

<div id="right">
	<div id="right_bottom">
	
	<div id="parent">

	<?php   
	echo validation_errors() == '' ? NULL : '<div class="alert alert-danger">'.validation_errors().'</div>';
	?>
	  <p>
		<label>Date Created:</label>
		<input type="text" value="<?=$date_c;?>" disabled>
	</p>
	<p>
		<label>Last updated on:</label>
		<input type="text" value="<?=$date_u;?>" disabled>
	  </p>
	  <p>
		<label>Amount</label><br />
		
		<input type="text" name="amount" value="<?=$amount;?>" disabled>
	  </p>
	  
	  <p>
		<label>Remarks</label><br />
			<textarea name="remarks" style="min-width:700px;max-width:700px;min-height:300px;max-height:300px;" disabled><?=$remarks;?></textarea>
	  </p>
	<form action="<?=site_url('fees/show_deducted_fee/');?>" method="POST">
		<input type="hidden" name="amount" value="<?=$amount;?>">
		<input type="hidden" name="token" value="<?=$form_token;?>">
		<input type="hidden" name="fid" value="<?=$this_fid;?>">
		<input type="hidden" name="eid" value="<?=$this_eid;?>">
		<input type="submit" name="delete_deducted_fee" value="delete">
		| <a class='btn btn-success' href="<?php echo site_url('fees/view_fees').'/'.$this_eid; ?>">View Fees</a>
		| <a class='btn btn-success' href="<?php echo site_url('fees/view_deducted_fees').'/'.$this_eid; ?>">Back To List</a>
	</form>
	
	</div>

	</div>
	
	<div class="clear"></div>
</div>