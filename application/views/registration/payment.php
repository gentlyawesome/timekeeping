<script type="text/javascript">
  function view_division(data, id)
  {
		custom_modal('Payment Division', $('#division_'+id));
  }
  
	function xvalidate(){
		
		just_a_moment();
		
		var ctr = $('input:radio:checked').length;
		
		if(ctr <= 0)
		{
			closeui();
			notify_modal('Error','<h4>No payment plan selected.</h4>');
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

<?$this->load->view('registration/header');?>

<?=form_open('','onsubmit="return xvalidate()"');?>					
	
	<fieldset class="scheduler-border">
				<legend class="scheduler-border">Summary of Assessment</legend>			
				<div class="row">
				  <div class="col-md-4">
					<span><b>Total Number of Subjects : &nbsp;</b></span>
					<span class='badge' >&nbsp;<?=number_format($subject_total,2,'.',' ')?></span></b>
				  </div>

				  <div class="col-md-4">
					<span><b>Total Number of Units : &nbsp;</b></span>
					<span class='badge' >&nbsp;<?=number_format($subject_units,2,'.',' ')?></span></b>
				  </div>
				  
				  <div class="col-md-4">
					<span><b>Total Amount : &nbsp;</b></span>
					<span class='badge'>&nbsp;<?=number_format($total_amount_due,2,'.',' ')?></span></b>
				  </div>
				</div>
	</fieldset>
	
	<fieldset class="scheduler-border">
				<legend class="scheduler-border">Select Your Prefered Payment Division</legend>			
				<?if($payment_plan):?>
				<table>
					<th>Select</th>
					<th>Name</th>
					<th>Payment Division</th>
					<th>Action</th>
					<?foreach($payment_plan as $p):?>
						<tr>
							<td>
								<div class="make-switch radio1 switch-small">
								<input type='radio' name='radio1' class='radio1' id='radio1' value='<?=$p->id?>' ></td>
								</div>
							<td><?=$p->name?></td>
							<td><?=$p->division?></td>
							<td><a href='javascript:;' onclick='view_division(this,<?=$p->id?>)' >View Division of Payments</a></td>
						</tr>
						<tr id='tr_<?=$p->id?>' style='display:none;'>
							<td colspan='4'>
								<div id='division_<?=$p->id?>'>
									<?if($p->division == 1):?>
										<span class='aler alert-success'>One time payment (full) : &nbsp;
											<span class='badge'><?=number_format($total_amount_due,2,'.',' ')?></span>
										</span>
									<?else:?>
										<table>
										<?
											$amount = $total_amount_due / $p->division;
											for($x = 1; $x <= $p->division; $x++){
												$xx = number_rank_string($x);
												?>
												<tr>
												  <th>
													<span><b><?=$xx?>&nbsp; Payment</b></span>
												  </th>
												  
												  <td>
													<span class='badge' ><b><?=number_format($amount,'2','.',' ')?></b></span>
												  </td>
												</tr>
												<?
											}
										?>
										<tr>
										  <th>
											<span><b>Total</b></span>
										  </th>
										  
										  <td>
											<span class='badge' ><b><?=number_format($total_amount_due,'2','.',' ')?></b></span>
										  </td>
										</tr>
										</table>
									<?endif;?>
								</div>
							</td>
						</tr>
					<?endforeach;?>
				</table>
				<?else:?>
					<div class='well'>
						<div class='alert alert-danger'>
							Payment Plan was not set.
							To continue your registration please contact your school administrator.
						</div>
					</div>
				<?endif;?>
	</fieldset>

	<div class="well">
		<div class="row small_font">
			<div class="col-md-8"></div>
			<div class="col-md-4">
				<?if($payment_plan):?>
				<?=form_submit('','Save and Continue to Finish');?>
				<?endif;?>
			</div>
		</div>
	</div>				
	
<?=form_close();?>