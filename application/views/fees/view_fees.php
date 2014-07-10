
<?php if(!empty($student_finance)){ ?>
<div class='well'>
	<fieldset class="scheduler-border">
		<legend class="scheduler-border">ASSESSMENT FEES</legend>
		<div class="row">

			<div class="col-md-12">

				
			  <table>
				  <tr>
					  <td>Payment Category:
					  <?php echo $student_finance->category2; ?>
					  </td>
					  <td>Has NSTP : <?php echo $has_nstp > 0 ? "Yes" : "No"; ?></td>
				  </tr>
			  </table>
			</div>

			<div class="col-md-6">
			<table >
				<tr>
					<th>Fee</th>
					<th>Amount</th>
				</tr>
				<tr>
					<td align="left">
						<b>
						<?
							$total_fees = 0;
							if($student_total)
							{
								$total_fees = $student_total->total_tuition_fee;
								echo isset($student_fees['tuition_fee'][0]) ? $student_fees['tuition_fee'][0]->name : '';
								echo " (".$student_total->subject_units." x ".number_format($student_total->tuition_fee,2,'.',' ').")";
							}
						?>
						</b>
					</td>
					<td align="right"><?=isset($student_total) ? number_format($student_total->total_tuition_fee,2,'.',' ') : ''?></td>
				</tr>
				
				<?php if(!empty($student_fees['lab'])):?>
					<?$lab_total = 0;?>
					<?php foreach($student_fees['lab'] as $sf): ?>
						<?
							$dta = $sf['data'];
							$val = $sf['value'];
							$lab_total += $val;
							$total_fees += $val;
						?>
						<tr class="profile_box">
								<td align="left"><b><?php echo $dta->name ?></b>&nbsp;<b>(<?=$total_lab?> * <?php echo number_format($dta->value,2,'.',' '); ?>)</b></td>
								<td align="right"><?php echo number_format($val,2,'.',' '); ?></td>
						</tr>
					<?php endforeach; ?>
					<!--tr>
						<td align="right">Lab Total</td>
						<td align="right"><?php echo number_format($lab_total,2,'.',' '); ?></td>
					</tr-->
				<?php endif;?>
				
				<tr>
				  <td align="left"><b>Miscellaneous Fees</b></td>
				  <td align="right">&nbsp;</td>
				</tr>
				<?php if(!empty($student_fees['misc'])):?>
					<?$misc_total = 0;?>
					<?php foreach($student_fees['misc'] as $sf): ?>
						<?
							$misc_total += $sf->value;
							$total_fees += $sf->value;
						?>
						<tr class="profile_box">
								<td align="left"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$sf->name ?></td>
								<td align="right"><?php echo number_format($sf->value,2,'.',' '); ?></td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<td align="right">Miscellaneous Total</td>
						<td align="right"><?php echo number_format($misc_total,2,'.',' '); ?></td>
					</tr>
				<?php else:?>
					<tr>
						<td>No fee</td>
						<td>No fee</td>
					</tr>
				<?php endif;?>
				
				<?php if(!empty($student_fees['other'])):?>	
				<?$other_total = 0;?>
				<tr>
					<td align="left"><b>Other Charges</b></td>
					<td align="right">&nbsp;</td>
				</tr>	
					<?php foreach($student_fees['other'] as $sf): ?>
							<?
								$other_total += $sf->value;
								$total_fees += $sf->value;
							?>
							<tr class="profile_box">
									<td align="left"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$sf->name ?></td>
									<td align="right"><?php echo number_format($sf->value,2,'.',' '); ?></td>
							</tr>
					<?php endforeach; ?>
					<tr>
						<td align="right">Other Charges</td>
						<td align="right"><?php echo number_format($other_total,2,'.',' '); ?></td>
					</tr>
				<?php endif;?>
				
				<?php if(!empty($student_fees['nstp'])):?>	
				<tr>
					<td align="left"><b>NSTP</b></td>
					<td align="right">&nbsp;</td>
				</tr>	
					<?php foreach($student_fees['nstp'] as $sf): ?>
							<?$total_fees += $sf->value;?>
							<tr class="profile_box">
									<td align="left"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$sf->name ?></td>
									<td align="right"><?php echo number_format($sf->value,2,'.',' '); ?></td>
							</tr>
					<?php endforeach; ?>
				<?php endif;?>
				<tr>
					<th align="left"><b>Total Fees</b></td>
					<th align="right"><?php echo number_format($total_fees,2,'.',' '); ?></th>
				</tr>
			</table>
			</div>
			
			<div class="col-md-6">
				<table>
				  <tr>
				  <th colspan=2 class="text-center">TOTAL CHARGES</th>
				  </tr>
					<tr>
					  <td>Additional Charges: </td>
					  <td align="right">
					  <?= number_format($student_total->additional_charge, 2, '.',' ') ;?>
					  </td>
					</tr>
					
					 
					<tr>
					<td>Total Current Charges:</td>
					<td align="right">
					<?= number_format($student_total->total_charge,2,'.',' ')  ;?>
					</td>
					</tr>
					
					<tr>
						<td>Previous Account:</td>
						<td align="right">
						<?= number_format($student_total->prev_account,2,'.',' ')  ;?>
						</td>
					</tr>
					<tr>
						<td>TOTAL AMOUNT DUE:</td>
						<td align="right">
						<span class='labal label-info'><b><?= number_format($student_total->total_amount_due,2,'.',' ')  ;?></b></span>
					</td>

				</table>


				<table>
					<tr>
						<th colspan=3 class="text-center">TOTAL DEDUCTIONS</th>
					</tr>
					<tr>
						<td>Less Deduction:</td>
						<td align="right">
							<?= number_format($student_total->less_deduction,2,'.',' ')  ;?>
						</td>
					</tr>
					<tr>
						<td>Less Payment:</td>
						<td align="right">
							<?= number_format($student_total->total_payment,2,'.',' ')  ;?>
						</td>
					</tr>
					<tr>
						<td>TOTAL DEDUCTIONS:</td>
						<td align="right">
						<?= number_format($student_total->total_deduction,2,'.',' ')  ;?>
						</td>
					</tr>
					<tr>
						<td>Remaining Balance:</td>
						<td align="right">
							<span class='labal label-info'><b><?= number_format($student_total->balance,2,'.',' ')  ;?></b></span>
						</td>
					</tr>
					<tr>
						<td>Status:</td>
						<td align="right"><?=$student_total->status?></td>
					</tr>
				</table>
					<br>
					
				</div>
				</div>
		</div>
	</fieldset>
</div>

<?php } ?>
