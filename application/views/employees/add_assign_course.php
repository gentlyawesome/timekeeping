<?$this->load->view('employees/_tab');?>
<div id="right">
	<div id="right_bottom">
<form action="<?= site_url('employees/add_assign_course/'. $employee_id.'/0');?>" class="new_assign_course" id="new_assign_course" method="post">
 <input name="employee_id" type="hidden" value="<?= $employee_id;?>" />
  <table>
    <tr>
		<th>
			<?
				$arr_courses = array();
				if($courses){
					foreach($courses as $obj):
						$pass = false;
						//EXCLUDE ALREADY ADDED
						if($assign_courses){
							foreach($assign_courses as $as){
								if($as->course_id == $obj->id)
								{
									$pass = true;
									break;
								}
							}
						}
						
						if(!$pass):
							$arr_courses[$obj->id] = $obj->course;
						endif;
					endforeach;
				}
				
				echo form_dropdown('course_id',$arr_courses);
			?>
		</th>
	  <td><input type="submit" value="Add" /></td>
    </tr>
  </table>
</form>
	</div>
</div>

<?echo isset($links) ? $links : NULL;?>
<table>
  <tr>
	<th>Assigned Courses</th>
	<th>Action</th>
  </tr>
  <? if(!empty($assign_courses)) :?>
  <? foreach($assign_courses as $row):?>
  <tr>
	<td><?= $row->course;?></td>
	<td><a class="confirm" title="Delete <?=$row->course?>?"href="<?= site_url('employees/delete_assign_course/' . $row->id .'/' . $row->employee_id );?>"><span class='glyphicon glyphicon-trash' ></span>&nbsp; Delete</a></td>
  </tr>
  <? endforeach;?>
  <? endif;?>
</table>
