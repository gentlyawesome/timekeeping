<div id="right">
		  
<div id="right_bottom">
  <a class='btn btn-success' href="<?php echo base_url(); ?>open_semester/create" rel="facebox">New Open Semester</a><br/><br/>
<?echo form_open('');?>
<table class="paginated">
  <tr>
    <th>Use</th>
    <th>Academic Year</th>
    <th>Semester</th>
    <th>Action</th>
  </tr>
  <tbody>
  
		 <?php if($open_semesters){ ?>
  <?php foreach( $open_semesters as $open_semester): ?>
    <tr>
      <td><?php 
		$sel = $open_semester->use == '1' ? 'checked' : '';
		$sel_caption = $open_semester->use == '1' ? 'Current' : '';
		?>
		<input type='radio' name='current' <?=$sel?> value='<?=$open_semester->id;?>' /> <?=$sel_caption?>
		</td>
      <td><?php echo $open_semester->academic_year; ?></td>
      <td><?php echo $open_semester->name; ?></td>
      <td><a href="<?php echo base_url()."open_semester/edit/".$open_semester->id; ?>" rel="facebox" class="actionlink">Edit</a> | 
      <a href="<?php echo base_url()."open_semester/destroy/".$open_semester->id; ?>" rel="facebox" class="actionlink confirm">Destroy</a></td>
    </tr>
  <?php endforeach; ?>
  <?php } ?>
  </tbody>
  <tr>
    <th>Use</th>
    <th>Academic Year</th>
    <th>Semester</th>
    <th>Action</th>
  </tr> 
</table>

	<?
		echo form_submit('','Set as Current Semester');
		?>
		| <a class='btn btn-success' href="<?php echo base_url(); ?>open_semester/create" rel="facebox">New Open Semester</a>
		<?
		echo form_close();
	?>		

</div>

</div>
