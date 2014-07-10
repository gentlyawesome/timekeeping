<div class="form-inline" id='search_form' >
	<div class="form-group">
		Search In
	</div>

	<div class="form-group">
		<?
			$xfields = array(
				"" => "ALL",
				"subjects.sc_id" => "Section Code",
				"subjects.code" => "Subject Code",
				"subjects.subject" => "Description",
			);
			echo form_dropdown('fields', $xfields, isset($fields)?$fields:'subjects.sc_id','id="fields" class="form-control"');
		?>
	</div>
	
	<div class="form-group">
		Keyword
	</div>

	<div class="form-group">
		<input class='form-control' id="keyword" name="keyword" size="30" type="text" value="<?=isset($keyword)?$keyword:''?>" placeHolder="Description" />
	</div>

	<input id="search_semester_id_eq" name="semester_id" type="hidden" value="<?=$this->open_semester->id;?>" />
	<input id="search_year_from_eq" name="year_from" type="hidden" value="<?=$this->open_semester->year_from;?>" />
	<input id="search_year_to_eq" name="year_to" type="hidden" value="<?=$this->open_semester->year_to;?>" />

	<div class="form-group">
		<button class='btn btn-default btn-sm' onclick='search_click()' ><span class='glyphicon glyphicon-refresh'></button>
	</div>
</div>
<div class='subject_paginate_links'>
<?echo isset($links) ? $links : NULL;?>
</div>
<table width='100%' border=1 style='border-collapse:collapse;font-size:8pt;'>
	<tr>
		<th>Subject Code</th>
		<th>Section Code</th>
		<th>Description</th>
		<th>Time</th>
		<th>Day</th>
		<th>Room</th>
		<th>Action</th>
	</tr>
	
	<?
		$ctr = 0;
	?>
	
	<?if($subjects):?>
	
	<?foreach($subjects as $row):?>
		
		<tr>
			 <td><?= $row->sc_id;?></td>
			 <td><?= $row->code;?></td>
			 <td><?= $row->subject;?></td>
			 <td><?= $row->time;?></td>
			 <td><?= $row->day;?></td>
			 <td><?= $row->room;?></td>
			 <td>
				<button onclick="select_subject('<?=$employee_id?>','<?=$row->id?>',this)" class='btn btn-default btn-sm' title="Add <?=$row->subject?>" ><span class = 'glyphicon glyphicon-check'></span> ADD</button>
			 </td>
		</tr>
		
	<?endforeach;?>
	<tr>
		 <td colspan='6' text-align = 'right' >Total Subjects</td>
		 <td colspan='1'><?=$total_rows?></td>
	</tr>
	<?else:?>
	
	<tr>
		 <td colspan=7 ><p>No subject find.</p></td>
	</tr>
	
	<?endif;?>
	
</table>