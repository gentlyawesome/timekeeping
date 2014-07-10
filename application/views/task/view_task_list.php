<div id="right">
	<?php 
		$formAttrib = array('id' => 'search_task', 'class' => 'form-inline', 'method' => 'GET');
		echo form_open('task/view_task_list/0', $formAttrib);
	?>

	<?if($this->is_admin):?>
	<div class="form-group">
		Employee
	<?=form_dropdown('users_id',$user_list,isset($users_id)?$users_id:'','id="monitoring_users_id" class="form-control"');?>
	</div>
	<?endif;?>


 <div class="form-group">
 	<input type="checkbox" id='check_dfrom' onclick="check_date(this)" checked>
    <input id="date_from" class="date_filter form-control date_pick" type="text" value="<?=isset($date_from)?$date_from:''?>" name="date_from" placeholder="Date From">
  </div>

  <div class="form-group">
    <input id="date_to" class="date_filter form-control date_pick" type="text" value="<?=isset($date_to)?$date_to:''?>" name="date_to" placeholder="Date To">
  </div>
  <script type="text/javascript">
  	function check_date(data)
  	{
  		var xval = $(data).attr('checked');
  		if(xval){
  			$('.date_filter').attr('disabled',false);
  		}else{
  			$('.date_filter').attr('disabled',true);
  		}
  	}
  </script>

  <div class="form-group">
  	Client
    <?=form_dropdown('client_id',$client_list,isset($client_id)?$client_id:'','id="monitoring_client_id" class="form-control"');?>
  </div>

  <div class="form-group">
  	Project
    <?=form_dropdown('project_id',$project_list,isset($project_id)?$project_id:'','id="monitoring_project_id" class="form-control"');?>
  </div> 
  
   		<?php echo form_submit('submit', 'Search','class="btn btn-sm"'); ?>
   		<?php echo form_submit('print', 'Print','class="btn btn-warning btn-sm"'); ?>
		<?echo form_close();?>
<br>
<?echo isset($links) ? $links : NULL;?>
	
	<br />
	<table>
		<tr>
			<?if($this->is_admin):?>
				<th>ID:Employee</th>
			<?endif;?>
		  <th>Date</th>
		  <th>Client</th>
		  <th>Project</th>
		  <th>Module</th>
		  <!-- <th>Hour</th> -->
		  <th>Task</th>
		</tr>
		<tbody>
		<?$hours = 0;?>
		<?if($search):?>
			
			<?foreach($search as $obj):?>
				<?$hours += $obj->hour?>
				<tr>
					<?if($this->is_admin):?>
						<td><?=$obj->empid;?>-<?=$obj->emp_name;?></td>
					<?endif;?>
					
					<td><?=date('m-d-Y',strtotime($obj->date))?></td>
					<td><?=$obj->client_code?>-<?=$obj->client_name?></td>
					<td><?=$obj->project_code?>-<?=$obj->project_name?></td>
					<td><?=$obj->module?></td>
					<!-- <td><?=$obj->hour?></td> -->
					<td><?=$obj->task?></td>
				</tr>
			<?php endforeach; ?>
			<?if($hours>0):?>
			<!-- <tr> -->
				<!-- <td colspan='4' align='right'><b>Total Hours</b></td> -->
				<!-- <td><span class='badge'><?=($hours) ? $hours : 0;?></span></td> -->
				<!-- <td></td> -->
				<!-- <td></td>
			</tr> -->
			<?endif;?>
			<tr>
				<td colspan='5' align='right'><b>Total Records</b></td>
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