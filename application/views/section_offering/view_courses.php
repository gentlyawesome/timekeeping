<style type="text/css">
	.modal-dialog{
	  width: 75%; /* desired relative width */
	 }
</style>	
<center>
<table class="paginated" border='1' style='border-collapse:collapse' >
	  <tr>
		<th>Year ID</th>
		<th>Course</th>
	  </tr>
	  <?php
		if(is_array($course_blocks)){
		
			foreach($course_blocks as $obj){?>
				<tr>
					<td><?=$obj->year;?></td>
					<td><?=$obj->course;?></td>
				</tr>
			<?php
			}
		}
		else
		{?>
		<tr>
				<td colspan='9'>No course available</td>
		</tr>
		
		<?}
	  ?>
</table>
</center>	