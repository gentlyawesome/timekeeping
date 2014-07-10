<script type="text/javascript">
  function view_subjects(e, element, id)
  {
		e.preventDefault();
		var url = $(element).attr('href');
		
		$.ajax({
			'type' : 'POST',
			'url' : url,
			'datatype' : 'html',
			'data' : {
					'id' : id
				},
			'success' : function(data) {
					$('#alertModal_Body').html(''); 
					$('#alertModal_Label').text('Subjects of '+$('#td_block_name_'+id).text()); //SET MODAL TITLE
					$('#alertModal_Body').html(data); //SET MODAL CONTENT
					$('#alertModal').modal('show'); //SHOW MODAL
			},
				
		});
  }
</script>

<?$this->load->view('section_offering/menu_tab')?>
<br/>
<table>
	  <tr>
		<th>Block Section</th>
		<th>Year</th>
		<th>Action</th>
	  </tr>
	<? $num = 0 ?>
	<?php if(empty($blocks) == FALSE):?>
		<? foreach($blocks as $obj): ?>
			<tr>
			  
				<td id='td_block_name_<?=$obj->id?>'><?= $obj->name;?></td>
				<td><?= $obj->year;?></td>
				<td>
					<?= badge_link('section_offering/view_subjects/'.$obj->id, "primary", 'View Subjects','onclick="view_subjects(event, this,\''.$obj->id.'\'); return false;"'); ?>
				</td>
			</tr>
		<? endforeach;?>
		<tr>
			<td colspan=2 class="text-right">Total No. of Records</td>
			<td><div class='badge'><?=$total_rows;?></div></td>
		</tr>
	<?php else:?>
		<tr>
			<td colspan=3 class="text-center">----NO data to show---</td>
		</tr>	
	<?php endif;?>
</table>
<?= $links;?>