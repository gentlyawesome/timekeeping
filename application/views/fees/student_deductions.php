<div class="well">
<table >
	<tr>
		<th>Student Id</th>
		<th>Student Name</th>
		<th>Course</th>
		<th>Year Level</th>
		<th>Deductions</th>
	</tr>
	<?
	$ctr = 0;
	?>
	<?if($students):?>
	<?foreach($students as $obj):?>
		
		<tr>	
			<td><?=$obj->studid;?></td>
			<td><?=$obj->name;?></td>
			<td><?=$obj->course;?></td>
			<td><?=$obj->year;?></td>
			<?if(isset($deductions[$obj->studid])):?>
			<td>
				<table>
					<tr>
						<th>Amount</th>
						<th>Remarks</th>
					</tr>
				<?foreach($deductions[$obj->studid] as $val):?>
					<tr>
						<td><?=number_format($val->amount, 2);?></td>
						<td><?=$val->remarks;?></td>
					</tr>
				<?endforeach;?>
				</table>
			<?endif;?>
			<td>
		</tr>
	<?endforeach;?>
	<tr class=''>
		<td colspan = 8 style='text-align:right'>Total No. of Records</td>
		<td><div class='badge'><?=$total_rows?></div></td>
	</tr>
	<?else:?>
	<tr>
		<td colspan = '13'>No record found.</td>
	</tr>
	<?endif;?>
</table>
<?= $links;?>
</div>