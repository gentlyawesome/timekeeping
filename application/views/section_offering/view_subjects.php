<style type="text/css">
	.modal-dialog{
	  width: 75%; /* desired relative width */
	 }
</style>	
<center>
<table class="paginated" border='1' style='border-collapse:collapse' >
	  <tr>
		<th>Subject Code</th>
		<th>Section Code</th>
		<th>Description</th>
		<th>Unit</th>
		<th>Lec</th>
		<th>Lab</th>
		<th>Time</th>
		<th>Day</th>
		<th>Room</th>
		<th>Remaining Load</th>
	  </tr>
	  <?php
		if(is_array($block_subjects)){
		
			foreach($block_subjects as $block_subject){?>
				<tr>
					<td><?=$block_subject->sc_id;?></td>
					<td><?=$block_subject->code;?></td>
					<td><?=$block_subject->subject;?></td>
					<td><?=$block_subject->units;?></td>
					<td><?=$block_subject->lec;?></td>
					<td><?=$block_subject->lab;?></td>
					<td><?=$block_subject->time;?></td>
					<td><?=$block_subject->day;?></td>
					<td><?=$block_subject->room;?></td>
					<td><?=$block_subject->load;?></td>
				</tr>
			<?php
			}
		}
		else
		{?>
		<tr>
				<td colspan='9'>No subjects available</td>
		</tr>
		
		<?}
	  ?>
</table>
</center>	