<div id="right">
	<div id="right_top" >
		  <p id="right_title">Student Deducted Fees</p>
	</div>
	<div id="right_bottom">
	  
	
	<div class="clear" style="margin-bottom:10px;"></div>
	
	
		<table>
			<tr>
				<th>Remarks</th>
				<th>Amount</th>
				<th>Date</th>
				<th>Action</th>
			</tr>

			<?php if(empty($deducted_fees) == FALSE):?>
				<? foreach($deducted_fees as $s): ?>
					<tr>
						<td><?=$s->remarks;?></td>
						<td>&#8369; <?=$s->amount;?></td>
						<td><?=$s->created_at;?></td>
						<td>
							  <a href="<?=site_url('fees/show_deducted_fee/'.$s->id.'/'.$enrollment_id);?>" >View</a> | <a href="<?=site_url('payment_record/delete_deduction/'.$s->id.'/'.$enrollment_id);?>" class="confirm" >Delete</a>
						</td>
					</tr>
				<? endforeach; ?>
			<?php else:?>
				<tr>
					<td>&nbsp;</td>
					<td>----NO data to show---</td>
					<td>----NO data to show---</td>
				</tr>	
			<?php endif;?>
		</table>
		
		<p>
			<a class='btn btn-success' href="<?=site_url('fees/view_fees/'.$enrollment_id);?>">Back To student fees</a> |
			<a class='btn btn-success' href="<?=site_url('payment_record/add_deduction/'.$enrollment_id);?>">Add New Deduction</a> 
		</p>
	</div>
</div>
