<?$this->load->view('employees/_tab');?>
<script type="text/javascript">
  function add_subject(data)
  {
	run_pleasewait();
	
	var url = $(data).attr('href');
	
	search_subject(url);
  }
  
  function search_click()
  {
	run_pleasewait();
	
	var url = $('#btn_addsubject').attr('href');
	
	$.ajax({
		
		'url' : url,
		'type' : 'POST', 
		'async': false,
		'data' : $('#search_form *').serialize(),
		'dataType' : 'html',
		'success' : function(data){ 
			
			// close_pleasewait();
			// close_pleasewait();
			custom_jmodal('Select Subjects', data, 800, 400);
			// custom_modal('Select Subjects', data);
			
			//PREVENT LINKS FROM REDIRECTING
			$('.subject_paginate_links li a').click(function(event){
				event.preventDefault();
				var href = $(this).attr("href");
				next_page = (href.substr(href.lastIndexOf('/') + 1));
				
				if(next_page && next_page != '#')
				{
					search_subject(href);
				}
			});
			
			$('.subject_paginate_links li a').css('font-size','8pt');
		}
		
	});
  }
  
  function search_subject(url)
  {
	
	run_pleasewait();
	
	$.ajax({
		
		'url' : url,
		'type' : 'POST', 
		'async': false,
		'data' : $('#search_form *').serialize(),
		'dataType' : 'html',
		'success' : function(data){ 
		
			// close_pleasewait();
			custom_jmodal('Select Subjects', data, 800, 400);
			// custom_modal('Select Subjects', data);
			
			//PREVENT LINKS FROM REDIRECTING
			$('.subject_paginate_links li a').click(function(event){
				event.preventDefault();
				var href = $(this).attr("href");
				next_page = (href.substr(href.lastIndexOf('/') + 1));
				if(next_page && next_page != '#')
				{
					search_subject(href);
				}
			});
			
			$('.subject_paginate_links li a').css('font-size','8pt');
		}
		
	});
  }
  
  function select_subject(employee_id, subject_id, el)
  {
	run_pleasewait();
	
	$.ajax({
		
		'url' : "<?=base_url('employees/ajax_select_subject')?>",
		'type' : 'POST', 
		'async': false,
		'data' : {
			'employee_id' : employee_id,
			'subject_id' : subject_id
		},
		'dataType' : 'json',
		'success' : function(data){ 
		
			if(data.status == 1)
			{
				close_pleasewait();
				custom_modal('Success','<h4> Subject Added. </h4>');
				
				$(el).parent().parent().hide('slow');
				console.log(data.row);
				$('#subjects_table tr:last').after(data.row);
			}
			else if(data.status == 0)
			{
				close_pleasewait();
				custom_modal('Failed','<h4> Transaction failed. Please try again.</h4>');
			}
			else if(data.status == 2)
			{
				close_pleasewait();
				custom_modal('Failed','<h4> Subject Already Added.</h4>');
			}
			else{}
		}
		
	});
  }
  
</script>
<button id='btn_addsubject' class='btn btn-default btn-sm' onclick="add_subject(this)" href='<?=base_url('employees/ajax_get_subjects/'.$employee_id.'/0');?>'><span class = 'glyphicon glyphicon-plus'></span>&nbsp; Add Subject</button>

<br/>
<br/>

<table id='subjects_table'>
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
	
	<?if($assignsubjects):?>
	
	<?foreach($assignsubjects as $row):?>
		
		<tr>
			 <td><?= $row->sc_id;?></td>
			 <td><?= $row->code;?></td>
			 <td><?= $row->subject;?></td>
			 <td><?= $row->time;?></td>
			 <td><?= $row->day;?></td>
			 <td><?= $row->room;?></td>
			 <td>
				<a class='confirm' href="<?=base_url('employees/delete_subject/'.$employee_id.'/'.$row->id)?>" title='Delete <?=$row->subject?>?' ><span class='glyphicon glyphicon-trash' ></span>&nbsp; Delete</a>
			 </td>
		</tr>
		
	<?endforeach;?>
	
	<?else:?>
	
	<tr>
		 <td colspan=5 ><p>No subject assign.</p></td>
	</tr>
	
	<?endif;?>
	
</table>

<?echo isset($links) ? $links : NULL;?>
