<div class="row">
	<?php 
		$formAttrib = array('id' => 'search_employee', 'class' => 'form-inline', 'method' => 'GET');
		echo form_open('employees/index/0', $formAttrib);
	?>
    
	<div class="form-group">
		<input id="name" class="form-control" type="text" value="<?=isset($name)?$name:''?>" name="name" placeholder="Name">
	</div>

	<div class="form-group">
		<input id="empid" class="form-control" type="text" value="<?=isset($empid)?$empid:''?>" name="empid" placeholder="Employee ID / Login ID">
	</div>
	
	<?php echo form_submit('submit', 'Search','class="btn btn-sm"'); ?>

	<a class="btn btn-sm btn-primary" href="<?=site_url('employees/create')?>" > Create Employee</a>

	<?echo form_close();?>
</div>
<br/>
<div class="row">
	<div class="table-responsive">
		<table class="table">
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Sex</th>
				<th>Action</th>
			</tr>
			<?if($search):?>
				<?foreach ($search as $key => $value):?>
					<tr>
						<td><?=$value->empid?></td>
						<td><?=$value->fullname?></td>
						<td><?=$value->gender?></td>
						<td>
							<div class="btn-group btn-group-sm">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-caret-square-o-down"></i> <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
								<li><a href="<?=base_url('employees/edit/'.$value->id)?>"><i class="fa fa-file-text"></i>&nbsp;  Edit</a></li>
								<li><a href="<?=base_url('employees/destroy/'.$value->id)?>"><i class="fa fa-trash-o"></i>&nbsp;  Delete</a></li>
							 </ul>
							</div>
						</td>
					</tr>	
				<?endforeach;?>
			<?endif;?>
		</table>
		<?=$links;?>
	</div>
</div>