<div class="well">
<!--a class='btn btn-success' href='<?=base_url()?>fees/student_charges/download'>Download All in Excel</a>
<br/>
<br/-->
<table >
	<tr>
		<th>Enrollment Id</th>
		<th>Name</th>
		<th>Course</th>
		<th>Year Level</th>
		<th>Tuition Fee</th>
		<th>Misc. Fee</th>
		<th>Additional Charges</th>
		<th>Previous Account</th>
		<th>Total Charge</th>
	</tr>
	<?
	$ctr = 0;
	?>
	<?if($student_charges):?>
	<?foreach($student_charges as $obj):?>
		<?
			$ctr++;
			$p = $obj['student_profile'];
			
			$tuition_fee = 0;
			$total_misc_fee = 0;
			$additional_charge = 0;
			$previous_account = 0;
			$total_charge = 0;
			
			if(isset($obj['student_total'])){
				$tuition_fee = $obj['student_total']['tuition_fee'];
				$total_misc_fee = $obj['student_total']['total_misc_fee'];
				$additional_charge = $obj['student_total']['additional_charge'];
				$previous_account = $obj['student_total']['previous_account'];
				$total_charge = $obj['student_total']['total_charge'];
			}
			
		?>
		<tr>	
			<td><?=$obj['enrollment_id'];?></td>
			<td><?=$p->last_name.', '.$p->first_name.' '.$p->middle_name;?></td>
			<td><?=$p->course;?></td>
			<td><?=$p->year;?></td>
			<td><?=number_format($tuition_fee, 2);?></td>
			<td><?=number_format($total_misc_fee, 2);?></td>
			<td><?=number_format($additional_charge, 2);?></td>
			<td><?=number_format($previous_account, 2);?></td>
			<td><?=number_format($total_charge, 2);?></td>
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