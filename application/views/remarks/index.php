<div id="right">
<div id="right_bottom">
  
<p><a class='btn btn-success' href="<?php echo base_url(); ?>remarks/create" rel="facebox">New Remarks</a></li></p>
<table id="table">
	<tr>
		<th>Remarks</th>
		<th>Deduction</th>
		<th>Payment</th>
		<th>Action</th>
	</tr>
<tbody>
	
  <?php if($remarks){ ?>
  <?php foreach( $remarks as $remark): ?>
    <tr>
      <td><?php echo $remark->value ; ?></td>
      <td><?php $ded = ($remark->is_deduction) == 1 ? "Yes" :  "No"; echo $ded; ?></td>
      <td><?php $pay = ($remark->is_payment) == 1 ? "Yes" :  "No"; echo $pay; ?></td>
      <td><a href="<?php echo base_url()."remarks/edit/".$remark->id; ?>" rel="facebox" class="actionlink">Edit</a> | 
      <a href="<?php echo base_url()."remarks/destroy/".$remark->id; ?>" rel="facebox" class="actionlink confirm">Destroy</a></td>
   	</td>
    </tr>
  <?php endforeach; ?>
  <?php } ?>
  
</tbody>
	<tr>
		<th>Remarks</th>
		<th>Deduction</th>
		<th>Payment</th>
		<th>Action</th>
  </tr>
</table>

<p><a class='btn btn-success' href="<?php echo base_url(); ?>remarks/create" rel="facebox">New Remarks</a></li></p>

</div>

</div>
