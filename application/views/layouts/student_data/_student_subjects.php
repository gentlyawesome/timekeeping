<table>
	<tr>
		<th>Subject Code</th>
		<th>Section Code</th>
		<th>Description</th>
		<th>Units</th>
		<th>Lab</th>
		<th>Lec</th>
    <th>Time</th>
    <th>Day</th>
	</tr>
<?php if(!empty($subjects)):?>
<?php foreach($subjects as $s): ?>
	<tr>
    <td><?php echo $s->sc_id; ?></td>
	  <td><?php echo $s->code; ?></td>
	  <td><?php echo $s->subject; ?></td>
	  <td><?php echo $s->units; ?></td>
	  <td><?php echo $s->lab; ?></td>
	  <td><?php echo $s->lec; ?></td>
    <td><?php echo $s->time; ?></td>
    <td><?php echo $s->day; ?></td>
  </tr>
	<?php endforeach;endif; ?>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>Total</td>
		<td><?php if(!empty($subject_units))echo number_format($subject_units['total_units'],2,'.',' '); ?></td>
		<td><?php if(!empty($subject_units))echo number_format($subject_units["total_lab"],2,'.',' '); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
	
