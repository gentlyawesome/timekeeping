<div id="right">
	<?php 
		$formAttrib = array('id' => 'search_module', 'class' => 'form-inline', 'method' => 'GET');
		echo form_open('modules/index/0', $formAttrib);
	?>


	<div class="form-group">
		<input id="module" class="form-control" type="text" value="<?=isset($module)?$module:''?>" name="module" placeholder="Module Name">
	</div>
  
	<?php echo form_submit('submit', 'Search','class="btn btn-sm"'); ?>
	<a class="btn btn-sm btn-primary" href="<?=site_url('modules/create')?>">Create New</a>
	<?php echo form_submit('print', 'Print','class="btn btn-warning btn-sm"'); ?>
	<?echo form_close();?>
<br>
<?echo isset($links) ? $links : NULL;?>
	
	<br />
	<div class="table-responsive">
	<table class="table">
		<tr>
		  <th>Module</th>
		  <th>Action</th>
		</tr>
		<tbody>
		<?if($search):?>
			
			<?foreach($search as $obj):?>
				<tr>
					<td><?=$obj->module?></td>
					<td>
						
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-caret-square-o-down"></i> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
							
							<li><a class="" href="<?=base_url('modules/edit/'.$obj->id)?>"><i class="fa fa-edit"></i>&nbsp;  Edit</a></li>
							<li><a class="confirm" href="<?=base_url('modules/destroy/'.$obj->id)?>"><i class="fa fa-trash-o"></i>&nbsp;  Delete</a></li>
							
							
						 </ul>
						</div>
						
					</td>
				</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan='1' align='right'><b>Total Records</b></td>
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