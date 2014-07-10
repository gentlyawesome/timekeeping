<script type="text/javascript">
  
  $(document).ready(function(){
	$('.pagination li a').click(function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		$('#search_form').attr('action', url);
		$('#submit').click();
	});
  })
  
  function type_change(element)
  {
		var x = $(element).val();
		$('#keyword').attr('placeHolder',x+' name');
		if(x != 'block')
		{
			$('.year_search').show('slow');
		}
		else
		{
			$('.year_search').hide('slow');
		}
  }
  
  
  
  function view_courses(e, data)
  {
	e.preventDefault();
	
	var id = $(data).attr('recid');
	var url = $(data).attr('href');
		
		$.ajax({
			'type' : 'POST',
			'url' : url,
			'datatype' : 'html',
			'data' : {
					'id' : id
				},
			'success' : function(data) {
			
					$('#alertModal').modal('show'); //SHOW MODAL
				
					$('#alertModal_Body').html(''); 	
					$('#alertModal_Body').html(data); //SET MODAL CONTENT
					
					$('#alertModal #alertModal_Label').text('Courses for '+$('#name_'+id).text()); //SET MODAL TITLE
			}
		});
  }
  
  function view_subjects(e, data)
  {
	
	e.preventDefault();
	
	var id = $(data).attr('recid');
	var url = $(data).attr('href');
		
		$.ajax({
			'type' : 'POST',
			'url' : url,
			'datatype' : 'html',
			'data' : {
					'id' : id
				},
			'success' : function(data) {
					$('#alertModal').modal('show'); //SHOW MODAL
					
					$('#alertModal_Body').html(''); 
					$('#alertModal_Body').html(data); //SET MODAL CONTENT
					
					$('#alertModal #alertModal_Label').text('Subjectsfor '+$('#name_'+id).text()); //SET MODAL TITLE
					
			},
				
		});
  }

  function view_block_sections(e, data)
  {
	
	e.preventDefault();
	
	var id = $(data).attr('recid');
	var url = $(data).attr('href');
		
		$.ajax({
			'type' : 'POST',
			'url' : url,
			'datatype' : 'html',
			'data' : {
					'id' : id
				},
			'success' : function(data) {
					$('#alertModal').modal('show'); //SHOW MODAL
					
					$('#alertModal_Body').html(''); 
					$('#alertModal_Body').html(data); //SET MODAL CONTENT
					
					$('#alertModal #alertModal_Label').text('Subject for '+$('#name_'+id).text()); //SET MODAL TITLE
					
			},
				
		});
  }
  
 
  
</script>

<?$this->load->view('section_offering/menu_tab')?>
<br/>

<div class="well">
	<?echo form_open('','class="form-inline" role="form" id="search_form"');?>
	<div class="form-group">
		Search In
	</div>
	 <div class="form-group">
		<?
			$xfields = array(
				"block" => "Block Section",
				"course" => "Course",
				"subject" => "Subject",
			);
			echo form_dropdown('type', $xfields, isset($type)?$type:'block','onchange = "type_change(this)"');
		?>
	</div>
	<div class="form-group">
		<label class="sr-only" for="keyword">Keyword</label>
		<input type='text' name='keyword' id='keyword' value="<?=isset($keyword)?$keyword:''?>" placeHolder="<?=$type?> name" />
	</div>
	<div class="form-group year_search" style='<?=isset($type) && $type != "block" ? "" : "display:none"?>'>
		<label for="year">Year</label>
	</div>
	<div class="form-group year_search" style='<?=isset($type) && $type != "block" ? "" : "display:none"?>'>
		<?=year_dropdown('year_id',NULL,"", 'Search To All');?>
	</div>
	<?echo form_submit('submit','Search','id="submit" class="btn-sm"');?>
</div>

<div id = 'paginated_container'>
<?
	switch($type)
	{
		case "block": 
		?>
			<table>
			  <tr>
				<th>Name</th>
				<th>Action</th>
			  </tr>
			<? $num = 0 ?>
			<?php if(empty($records) == FALSE):?>
				<? foreach($records as $obj): ?>
					<tr> 
						
						<td id='name_<?=$obj->id?>'><?= $obj->name;?></td>
						<td>
							<?= badge_link('section_offering/view_courses/'.$obj->id, "primary", 'View Courses', 'onclick="view_courses(event,this)" recid = "'.$obj->id.'" '); ?>
							<?= badge_link('section_offering/view_subjects/'.$obj->id, "primary", 'View Subjects', 'onclick="view_subjects(event, this)" recid = "'.$obj->id.'" ');?>
						</td>
					</tr>
				<? endforeach;?>
				<tr>
					<td colspan=1 class="text-right">Total No. of Records</td>
					<td><div class='badge'><?=$total_rows;?></div></td>
				</tr>
			<?php else:?>
				<tr>
					<td colspan=2 class="text-center">----NO data to show---</td>
				</tr>	
				
			<?php endif;?>
			</table>
			
		<?= $links;?>
			
		<?break; //end block
		
		case "course":
		?>
				<table class="paginated">
					<th>Year</th>
					<th>Course</th>
					<th>Block</th>
				  </tr>
				  <?php
					if(is_array($records)){
						foreach($records as $obj){?>
							<tr>
								<td><?=$obj->year;?></td>
								<td><?=$obj->course;?></td>
								<td><?=$obj->name;?></td>
							</tr>
						<?}?>
						<tr>
							<td colspan=2 class="text-right">Total No. of Records</td>
							<td><div class='badge'><?=$total_rows;?></div></td>
						</tr>
					<?}else{?>
						<tr>
							<td colspan=3 class="text-center">----NO data to show---</td>
						</tr>	
					<?}?>
				</table>	
				<?= $links;?>
		<?break; //end course
		
		case "subject":
		?>
			<table class="paginated" border='1' style='border-collapse:collapse' >
			  <tr>
				<th>Subject Code</th>
				<th>Section Code</th>
				<th>Description</th>
				<th>Unit</th>
				<th>Lec</th>
				<th>Lab</th>
				<th>Time</th>
				<th>Day</th>
				<th>Room</th>
				<th>Remaining Load</th>
				<th>Block Name</th>
			  </tr>
			  <?php
				if(is_array($records)){
				
					foreach($records as $block_subject){?>
						<tr>
							<td><?=$block_subject->sc_id;?></td>
							<td><?=$block_subject->code;?></td>
							<td><?=$block_subject->subject;?></td>
							<td><?=$block_subject->units;?></td>
							<td><?=$block_subject->lec;?></td>
							<td><?=$block_subject->lab;?></td>
							<td><?=$block_subject->time;?></td>
							<td><?=$block_subject->day;?></td>
							<td><?=$block_subject->room;?></td>
							<td><?=$block_subject->load;?></td>
							<td><?=$block_subject->block;?></td>
						</tr>
					<?php
					}
				}
				else
				{?>
				<tr>
						<td colspan='9'>No subjects available</td>
				</tr>
				
				<?}
			  ?>
		</table>
		<?= $links;?>
		<?break; //end subject
	}
?>
</div>
