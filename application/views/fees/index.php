<div id="right">

	<div id="right_top" >
		<p id="right_title">Fees : Index</p>
	</div>
			  
	<div id="right_bottom">
		  
		<p><a href="<?php echo base_url(); ?>fees/create" rel="facebox">New Fee</a></li></p>
		<table id="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Deduction</th>
				<th>Active</th>
				<th>Not Added to Old Students</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Name</th>
				<th>Deduction</th>
				<th>Active</th>
				<th>Not Added to Old Students</th>
		  </tr>
		</tfoot>
		<tbody>
			
		  <?php if($fees){ ?>
		  <?php foreach( $fees as $fee): ?>
			<tr>
			  <td><?php echo $fee->name ; ?></td>
			  <td><?php $ded = ($fee->is_deduction) == 1 ? "Yes" :  "No"; echo $ded; ?></td>
			  <td><?php $pay = ($fee->is_active) == 1 ? "Yes" :  "No"; echo $pay; ?></td>
			  <td><?php $pay = ($fee->donot_show_in_old) == 1 ? "Yes" :  "No"; echo $pay; ?></td>
			  <td><a href="<?php echo base_url()."fees/edit/".$fee->id; ?>" rel="facebox" class="actionlink">Edit</a></td>
			  <td><a href="<?php echo base_url()."fees/destroy/".$fee->id; ?>" rel="facebox" class="actionlink confirm">Destroy</a></td>
			</td>
			</tr>
		  <?php endforeach; ?>
		  <?php } ?>
		  
		</tbody>
		</table>
		<p><a href="<?php echo base_url(); ?>fees/create" rel="facebox">New Fee</a></li></p>
		
	</div>

</div>
