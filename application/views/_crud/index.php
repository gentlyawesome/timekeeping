<?
	if(isset($disable_system_message) && $disable_system_message == false)
	{
		if(isset($system_message) && $system_message)
		{
			echo $system_message;
			echo validation_errors();
		}
	}
?>
<!-- FILTER IF AVAILABLE -->
<?if($search):?>
<div class="row">
	<div class="col-md-12">
		<?=form_open('','class="form-vertical" method="GET"')?>
			<!-- Prepended text-->
			<!-- Select Basic -->
			<div class="form-group">
			  <label class="col-md-1 control-label" for="selectbasic">Filter By</label>
			  <div class="col-md-2">
			  	<?=form_dropdown('filter_by',$filter_list,isset($filter_by)?$filter_by:'')?>
			  </div>
			  <div class="col-md-2">
			    <input id="keyword" name="keyword" class="form-control" placeholder="Keyword" type="text" value="<?=isset($keyword)?$keyword:''?>" >
			  </div>

			  <div class="col-md-4">
			    <input type="submit" class="btn btn-default btn-sm btn-sm" value="Search" name="search" >
			    <!-- <input type="submit" class="btn btn-default btn-sm btn-sm" value="Create" name="create" > -->
			    <a class="btn btn-default btn-sm btn-sm" href="<?=site_url($controller_method).'/create'?>">Create New Record</a>
			  </div>
			</div>
		</form>
	</div>
</div><hr>
<?endif;?>

<?if($result):?>
<div class="row">
	<div class="col-md-12">
		<?=isset($links) ? $links : ''?>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<?if(isset($column_name) && $column_name):?>

						<?foreach ($column_name as $key => $value):?>
							<?if($value=="id" && $hide_id):?>
							<?else:?>
							<th><?=ucwords($value)?></th>
							<?endif;?>

						<?endforeach;?>

					<?endif?>
					<th>Actions</th>
				</tr>

				<?foreach ($result as $key => $value):?>
					
					<tr>
					<?foreach ($value as $col => $col_value):?> 
						
						<?if($col=="id" && $hide_id):?>
							<?else:?>
							<td><?=$col_value?></td>
							<?endif;?>
						<?endforeach;?>
					
					<td>
						<div class="btn-group btn-group-sm">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-caret-square-o-down"></i> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?=site_url($controller_method.'/view/'.$value->id)?>"><i class="fa fa-file-text"></i>&nbsp;  View</a></li>
								<li><a href="<?=site_url($controller_method.'/edit/'.$value->id)?>"><i class="fa fa-file-text"></i>&nbsp;  Edit</a></li>
								<li><a href="<?=site_url($controller_method.'/delete/'.$value->id)?>"><i class="fa fa-file-text confirm"></i>&nbsp;  Delete</a></li>
							</ul>
						</div>
					</td>

					</tr>
				<?endforeach;?>
			</table>
		</div>
	</div>
</div>
<?else:?>
	<hr>
	<div class="alert alert-danger"><strong><p>No Record Found.</p></strong></div>
<?endif?>