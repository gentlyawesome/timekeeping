<?php $this->load->view('layouts/_student_data'); ?>

<?if($payment_details):?>
	<table width='100%'>
		<?$ctr = 1;?>
		<tr>
			<th>Grading Period</th>
			<th>Amount</th>
			<th>Paid Amount</th>
			<th>Balance</th>
			<th>Is Paid?</th>
			<!--th>Promisory Action</th-->
			<th>Is Promisory?</th>
		</tr>
		<?php 
			$ctr = 1; 
			$pass = false;
			$pass2 = false;
		?>
		<?foreach($payment_details as $obj):?>
			<?php
				$xstyle = "";
				$pointer = "";
				
				if($pass == false)
				{
					if(count($payment_details) == 1) //FULLTIME PAYMENT
					{
						$xstyle = "style='color:#3b5998;font-weight:bold;font-size:12pt;'";
						$pointer = "<span class='glyphicon glyphicon-hand-right'></span>";
						$pass = true;
					}
					else //INSTALLMENT
					{
						//HIGHLIGHT CURRENT GRADING PERIOD
						if($obj->is_downpayment == 1){
							if($obj->is_paid == 0 && $obj->is_promisory == 0){
								$xstyle = "style='color:#3b5998;font-weight:bold;font-size:12pt;'";
								$pointer = "<span class='glyphicon glyphicon-hand-right'></span>";
								$pass = true;
							}
						}else{
							if($obj->grading_period_id == $current_period->id)
							{
								$xstyle = "style='color:#3b5998;font-weight:bold;font-size:12pt;'";
								$pointer = "<span class='glyphicon glyphicon-hand-right'></span>";
								$pass = true;
							}
						}
					}
				}
			?>
			<tr <?=$xstyle?> >
				<td><?=$pointer;?>
					<?
						if(count($payment_details) == 1)
						{
							echo strtoupper($current_period->grading_period);
						}
						else
						{
							if($obj->is_downpayment == 1)	{
								echo "DOWNPAYMENT";
							}
							else{
								echo strtoupper($obj->grading_period);
							}
						}
					?>
				</td>
				<td>&nbsp; &#8369; &nbsp;<?=number_format($obj->amount, 2, '.',' ')?></td>
				<td>&#8369; &nbsp;<?=number_format($obj->amount_paid, 2, '.',' ')?></td>
				<td>&#8369; &nbsp;<?=number_format($obj->balance, 2, '.',' ')?></td>
				<td><?=$obj->is_paid == 1 ? 'YES' : 'NO' ?></td>
				<td><?=$obj->is_promisory == 1 ? 'YES' : 'NO' ?></td>
				<!--td>
					<?php
						/* if($pass){	
							if(!$pass2) //CURRENT GRADING PERIOD WITH ADD & EDIT
							{
								if($obj->studentpromisory_id){?>
									<a class='btn btn-success' href="<?=base_url()?>promisory/edit/<?=$obj->studentpromisory_id;?>/<?=$enrollment_id?>">Edit Promisory</a>
									<a class='btn btn-success' href="<?=base_url()?>promisory/print/<?=$obj->studentpromisory_id;?>">Print</a>
								<?
								}else
								{
									if($obj->is_paid != 1){?>
									<a class='btn btn-success' href="<?=base_url()?>promisory/create/<?=$obj->id;?>/<?=$enrollment_id;?>">Create Promisory</a>
									<?}
								}
								$pass2 = true;
							}
						}else{ //PREVIOUS GRADING PERIOD WITH EDIT
							if($obj->studentpromisory_id){?>
									<a class='btn btn-success' href="<?=base_url()?>promisory/edit/<?=$obj->studentpromisory_id;?>/<?=$enrollment_id?>">Edit Promisory</a>
									<a class='btn btn-success' href="<?=base_url()?>promisory/print/<?=$obj->studentpromisory_id;?>">Print</a>
							<?}
						} */
					?>
				</td-->
				
			</tr>
		<?$ctr++;?>
		<?endforeach;?>
	</table>
<?endif;?>