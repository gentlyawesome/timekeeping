<div id="right">
	<?php 
		$formAttrib = array('id' => 'search_task', 'class' => 'form-inline', 'method' => 'GET');
		echo form_open('project/index/0', $formAttrib);
	?>


	<div class="form-group">
		<input id="code" class="form-control" type="text" value="<?=isset($code)?$code:''?>" name="code" placeholder="Project Code">
	</div>

	<div class="form-group">
		<input id="name" class="form-control" type="text" value="<?=isset($name)?$name:''?>" name="name" placeholder="Project Name">
	</div>

	<div class="form-group">
		Is Active
		<input id="is_active" class="form-control" type="checkbox" value="" name="is_active" <?=$is_active == 1 ? 'checked' : ''?>>
	</div>
  
	<?php echo form_submit('submit', 'Search','class="btn btn-sm"'); ?>
	<a class="btn btn-sm btn-primary" href="<?=site_url('project/create')?>">Create New</a>
	<?php echo form_submit('print', 'Print','class="btn btn-warning btn-sm"'); ?>
	<?echo form_close();?>
<br>
<?echo isset($links) ? $links : NULL;?>
	
	<br />
	<div class="table-responsive">
	<table class="table">
		<tr>
		  <th>Code</th>
		  <th>Name</th>
		  <th>Date Started</th>
		  <th>Date End</th>
		  <th>Is Done</th>
		  <th>Active</th>
		  <th>Action</th>
		</tr>
		<tbody>
		<?if($search):?>
			
			<?foreach($search as $obj):?>
				<tr>
					<td><?=$obj->code?></td>
					<td><?=$obj->name?></td>
					<td><?=date('d-m-Y', strtotime($obj->date_started))?></td>
					<td><?=$obj->is_done == 1 ? date('d-m-Y', strtotime($obj->date_end)) : ''?></td>
					<td><?=$obj->is_done == 1 ? 'YES' : 'NO'?></td>
					<td><?=$obj->is_active ? 'YES' : 'NO'?></td>
				
					<td>
						
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-caret-square-o-down"></i> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
							
							<li><a class="" href="<?=base_url('project/edit/'.$obj->id)?>"><i class="fa fa-edit"></i>&nbsp;  Edit</a></li>
							<li><a class="confirm" href="<?=base_url('project/destroy/'.$obj->id)?>"><i class="fa fa-trash-o"></i>&nbsp;  Delete</a></li>
							
							
						 </ul>
						</div>
						
					</td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan='6' align='right'><b>Total Records</b></td>
				<td><span class='badge'><?=($total_rows) ? $total_rows : 0;?></span></td>
			</tr>
			
		<?else:?>
		<tr>
		<td colspan="5">
			No Record Found.
		</td>
		</tr>
		<?endif;?>
		</tbody>
	</table>
	<?echo isset($links) ? $links : NULL;?>
	</div>
	</div>
</div>