<div id="right">

	<div id="right_top" >
		  <p id="right_title">Add Fees</p>
	</div>
	
	<div id="right_bottom">
		<?php   ?>
		<form action="<?=site_url('fees/add_fees/'.$sfid.'/'.$eid);?>" method="POST">
		<table>
		  <tr>
			<th>&nbsp;</th>
			<th>Name</th>
			<th>Rate</th>
		  </tr>
		  <?php if(!empty($fees)):?>
				<?php foreach($fees as $m):?>
				<tr>
					<td><input type="checkbox" name="fee[]" value="<?=$m->id;?>"></td>
					<td><?=$m->name;?></td>
					<td>&#8369; <?=$m->value;?></td>
				</tr>
				<?php endforeach;?>
		  <?php else:?>
			  <tr>
					<td>----Unable to Fetch data---</td>
					<td>----Unable to Fetch data---</td>
					<td>----Unable to Fetch data---</td>
			  </tr>
		 <?php endif;?>

		 	<tfoot>

		  </tfoot>
		</table>
		<input type="hidden" name="form_token" value="<?=$form_token;?>">
		<input type="hidden" name="sfid" value="<?=$sfid;?>">
		<input type="hidden" name="eid" value="<?=$eid;?>">
		<input type="submit" name="add_fee" value="Add Fee">
		</form>
		
		<p><a href="<?=site_url('fees/view_fees/'.$eid);?>">back To Student Profile</a></p>
	</div>

	<div class="clear"></div>

</div>