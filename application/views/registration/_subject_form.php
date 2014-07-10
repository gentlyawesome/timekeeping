<style>
	.xlabel{
		color: gray;
	}
	
	div#tabs ul li, div#tabs ul li a {
	  width: 25px;
	  padding: 0;
	  margin: 0;
	}
	
	.mytable{
		font-size:8pt;
	}
	
	.well, .small_font{
		font-size:12pt;
	}
</style>
 <script>
  $(function() {
    $( "#tabs" ).tabs();
	$(":checkbox").change(function(){
		var ctr = parseInt($('#selected_subject').text().trim());
		
		if($(this).is(":checked")){
			$('#selected_subject').text(ctr+1);
		}else{
			if(ctr > 0){
				$('#selected_subject').text(ctr-1);
			}
		}
	});
	
	$('#selected_subject').text($('input[type="checkbox"]:checked').length);
  });
  
  function Clear(){
	$(":checkbox").attr('checked',false);
	$('#selected_subject').text('0');
  }
  
  function validate(){
	var ctr = $('input[type="checkbox"]:checked').length;
	
	if(ctr <= 0)
	{
		 $.blockUI({ message: '<h3>No subject selected.</h3>' }); 
		 $.blockUI.defaults.applyPlatformOpacityRules = false;
        $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
		return false;
	}
	else
	{
		return true;
	}
	
	return false;
  }
  
  </script>

<button type="button" onclick='Clear()' class="btn btn-warning">Clear Check</button>
<span class='small_font'>Selected Subjects:</span><span class="badge" id="selected_subject" >0</span><br/><br/>

<div class='well' id='subjects_container'>
<div id="tabs">
	<ul>
<?php

	$alphabet = array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	
	$alphabet_array = array();
	//GENERATE AND ARRANGE ARRAY OF SUBJECTS
	if($subjects){
		foreach($subjects as $key => $value){
			if($value != null){
				$f_letter = strtolower(trim($value->code[0]));
				if($f_letter != ""){
					$pass = 0;
					$pass2 = 0;
					foreach($alphabet as $letter)
					{
						$pass2++;
						if($letter == $f_letter)
						{
							$alphabet_array[$letter][$key] = $value;
							$pass++;
							break;
						}
					}
					//NO Category
					if($pass == 0 && $pass2 > 0)
					{
						$alphabet_array['others'][$key] = $value;
					}
				}
			}
		}
	}
	?>
	
	<?
	
	foreach($alphabet as $letter)
	{
		$count = "";
		$style= "";
		if(isset($alphabet_array[$letter])){
			$count = count($alphabet_array[$letter]);
			$style = count($alphabet_array[$letter]) > 0 ? "style='color:blue;'" : '';
			if($count > 0){ ?>
				<li><a href="#tabs-<?=$letter?>"><span <?=$style?> ><?=strtoupper($letter)?></span></a></li>
			<?}
		}		
	}
	
	//Display OTHERS
	if(isset($alphabet_array['others']))
	{
		?>	
			<li><a href="#tabs-others">~</a></li>
		<?php	
	}
	
?>
	</ul>
<?php
	foreach($alphabet as $letter)
	{
		if(isset($alphabet_array[$letter]))
		{
		?>
			<div id="tabs-<?=$letter?>">
			<table class='table mytable'>
				<tr>
					<th>Select</th>
					<th>Subject Code</th>
					<th>Description</th>
					<th>Units</th>
					<th>Lec</th>
					<th>Lab</th>
					<th>Time</th>
					<th>Day</th>
					<th>Room</th>
					
				</tr>
			<?
			foreach($alphabet_array[$letter] as $subject)
			{
			?>
				<tr>
				<td>
					<?if($subject->original_load <= 0 || $subject->subject_load == 0){?>
					<span>FULL</span>
					<?}else{
					?>
					<input type='checkbox' name='subject[]' value='<?=$subject->id;?>' />
					<?}?>
				</td>
				<td><span><?=$subject->code;?></span></td>
				<td><span><?=$subject->subject;?></span></td>
				<td><span><?=$subject->units;?></span></td>
				<td><span><?=$subject->lec;?></span></td>
				<td><span><?=$subject->lab;?></span></td>
				<td><span><?=$subject->time;?></span></td>
				<td><span><?=$subject->day;?></span></td>
				<td><span><?=$subject->room;?></span></td>
				</tr>
			<?
			}
			?>
			</table>
			</div>
			<?
		}
		else
		{
			?>
				<!--div id="tabs-<?=$letter?>">No available subjects.</div-->
			<?php
		}
	}
?>
</div>
</div>