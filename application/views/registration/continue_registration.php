<?$this->load->view('registration/header');?>

<?if($start->type == "block"):?>
	 <script>
	  $(function() {
			  $('.radio1').on('switch-change', function () {
				$('.radio1').bootstrapSwitch('toggleRadioStateAllowUncheck', true);
			  });
	  }); 
	  
	  function view_subject(data, id){
		var cap = $(data).text();
		if(cap=="View Subjects"){
			$('#block_'+id).show('slow');
			$(data).text("Hide Subjects");
		}else{
			$('#block_'+id).hide('slow');
			$(data).text("View Subjects");
		}
	  }
	  
	  function xvalidate(){
	  
		just_a_moment();

		var ctr = $('input:radio:checked').length;
		
		if(ctr <= 0)
		{
			closeui();
			notify_modal('Error','<h4>No block subject selected.</h4>');
			return false;
		}
		else
		{
			// $('#confirm_modal').modal('show');
			
			// $('#confirm_subject').click(function(){
				// console.log('x');
				// return true
			// });
			return true;
		}
		
	  }
	 </script>
	<div class="well">
			<?=form_open('','onsubmit="return xvalidate()"');?>
			<fieldset class="scheduler-border">
				<legend class="scheduler-border">Select Block Section</legend>
				<?php if($course_blocks){?>


					<div class="well">

						<div class="row small_font">
							 <div class="col-md-2"><strong>Select</strong></div>
							 <div class="col-md-8"><strong>Block</strong></div>
							 <div class="col-md-2">Action</div>
						</div>

						<?php
							if($course_blocks){
								foreach($course_blocks as $value)
								{
								?>
									<div class="row small_font">
										<div class="col-md-2">
											<div class="make-switch radio1 switch-small">
											<input id="option1" type="radio" checked="checked" name="course_blocks" value='<?=$value->block_system_setting_id;?>' />
											</div>
										</div>
										<div class="col-md-8"><?=strtoupper($value->name)?></div>
										<div class="col-md-2"><a href="javascript:;" onclick='view_subject(this, "<?=$value->block_system_setting_id;?>")' >View Subjects</a></div>
									</div>
									<div class="row small_font">
										<div class="col-md-12">
								<?php
									if(isset($block_subjects[$value->block_system_setting_id])){
									?>
										<table class="paginated" id="block_<?=$value->block_system_setting_id;?>" style='display:none'>

												   <tr><th colspan='11' style='text-align:center;'>Assigned Subjects</th><tr>
												  <tr>
													<th>#</th>
													<th>Subject Code</th>
													<th>Section Code</th>
													<th>Description</th>
													<th>Unit</th>
													<th>Lec</th>
													<th>Lab</th>
													<th>Time</th>
													<th>Day</th>
													<th>Room</th>
												  </tr>
									<?
											$tot_lec = 0;
											$tot_lab = 0;
											$tot_units = 0;
											$ctr = 0;
											foreach($block_subjects[$value->block_system_setting_id] as $block_subject)
											{
												$tot_lec += floatVal($block_subject->lec);
												$tot_lab += floatVal($block_subject->lab);
												$tot_units += floatVal($block_subject->units);
											?>
														<tr>
															<td><?=++$ctr;?></td>
															<td><?=$block_subject->sc_id;?></td>
															<td><?=$block_subject->code;?></td>
															<td><?=$block_subject->subject;?></td>
															<td><?=$block_subject->units;?></td>
															<td><?=$block_subject->lec;?></td>
															<td><?=$block_subject->lab;?></td>
															<td><?=$block_subject->time;?></td>
															<td><?=$block_subject->day;?></td>
															<td><?=$block_subject->room;?></td>
														</tr>
										<?}?>
														<tr>
															<td></td>
															<td></td>
															<td></td>
															<td><?=$tot_units;?></td>
															<td><?=$tot_lec;?></td>
															<td><?=$tot_lab;?></td>
															<td></td>
															<td></td>
															<td></td>
														</tr>
										</table>
										</div>
									</div>
									<?}
								}
							}
						?>
					</div>
					<div class="well">
						<div class="row small_font">
							<div class="col-md-8"></div>
							<div class="col-md-4">
								<?=form_submit('','Save and Continue to Assessment');?>
							</div>
						</div>
					</div>
					<?
					}
					else{
					?>
					<div class='alert alert-danger'>Block Section in not set. Please contact the admin of the school.</div>
					<?}?>
			</fieldset>
			<?=form_close();?>
	</div>
	
<?else:?>
	
	<?=form_open('','onsubmit="return validate()"');?>
	<?$this->load->view('registration/_subject_form');?>
	<div class="well">
		<div class="row small_font">
			<div class="col-md-8"></div>
			<div class="col-md-4">
				<?=form_submit('','Save and Continue to Assessment');?>
			</div>
		</div>
	</div>
	<?=form_close();?>
<?endif;?>