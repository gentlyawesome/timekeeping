<?$this->load->view('registration/header');?>
<script type="text/javascript">
  function xvalidate(){
	just_a_moment();
  }
</script>
<?php if(!empty($coursefinances)){ ?>
<div class='well'>
	<fieldset class="scheduler-border">
		<legend class="scheduler-border">ASSESSMENT FEES</legend>
		<div class="row">

			<div class="col-md-12">

				
			  <table>
				  <tr>
					  <td>Payment Category:
					  <?php echo $coursefinances->category2; ?>
					  </td>
					  <td>Has NSTP : <?php echo $has_nstp > 0 ? "Yes" : "No"; ?></td>
				  </tr>
			  </table>
			</div>

			<div class="col-md-12">
			<table >
				<tr>
					<th>Fee</th>
					<th>Amount</th>
				</tr>
				<tr>
					<td align="left">
						<b>
						<?
							if(isset($student_fees['tuition_fee']))
							{
								$xtuition_fee = $student_fees['tuition_fee']['data'];
								echo $xtuition_fee->name;
								echo " (".$subject_units." x ".number_format($xtuition_fee->value,2,'.',' ').")";
							}
						?>
						</b>
					</td>
					<td align="right"><?=isset($student_fees['tuition_fee']['total']) ? number_format($student_fees['tuition_fee']['total'],2,'.',' ') : ''?></td>
				</tr>
				<tr>
				  <td align="left"><b>Miscellaneous Fees</b></td>
				  <td align="right">&nbsp;</td>
				</tr>
				<?php if(!empty($student_fees['misc'])):?>
					<?php foreach($student_fees['misc'] as $sf): ?>
						<tr class="profile_box">
								<td align="left"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$sf->name ?></td>
								<td align="right"><?php echo number_format($sf->value,2,'.',' '); ?></td>
						</tr>
					<?php endforeach; ?>
				<?php else:?>
					<tr>
						<td>No fee</td>
						<td>No fee</td>
					</tr>
				<?php endif;?>
				
				<?php if(!empty($student_fees['other'])):?>	
				<tr>
					<td align="left"><b>Other Charges</b></td>
					<td align="right">&nbsp;</td>
				</tr>	
					<?php foreach($student_fees['other'] as $sf): ?>
							<tr class="profile_box">
									<td align="left"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$sf->name ?></td>
									<td align="right"><?php echo number_format($sf->value,2,'.',' '); ?></td>
							</tr>
					<?php endforeach; ?>
				<?php endif;?>
				
				<?php if(!empty($student_fees['nstp'])):?>	
				<tr>
					<td align="left"><b>NSTP</b></td>
					<td align="right">&nbsp;</td>
				</tr>	
					<?php foreach($student_fees['nstp'] as $sf): ?>
							<tr class="profile_box">
									<td align="left"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$sf->name ?></td>
									<td align="right"><?php echo number_format($sf->value,2,'.',' '); ?></td>
							</tr>
					<?php endforeach; ?>
				<?php endif;?>
				
				<tr>
					<th align="left"><b>TOTAL AMOUNT</b></th>
					<th align="right"><div class='badge' style='float:right'><?=number_format($total_amount_due, 2, '.', ' ')?></div></th>
				</tr>	
			</table>
			</div>
		</div>
	</fieldset>
</div>
<?php } ?>

<?=form_open('registration/payment/'.$id,'onsubmit="return xvalidate()"');?>					
	<div class="well">
		<div class="row small_font">
			<div class="col-md-8"></div>
			<div class="col-md-4">
				<?=form_submit('','Confirm and Continue to Payment');?>
				<!--a class='btn btn-success' href='<?=base_url()?>registration/payment/<?=$id?>'>Confirm and Continue to Payment</a-->
			</div>
		</div>
	</div>				
<?=form_close();?>

<div class="well">
	<fieldset class="scheduler-border">
		<?
			if($block_system_settings){
				$xtitle = "BLOCK NAME : ".$block_system_settings->name;
			}
			else{
				$xtitle = "SUBJECTS";
			}
		?>
			<legend class="scheduler-border"><?=$xtitle?></legend>
			<div>
				<table>
					<tr>
						<th>#</th>
						<th>Subject Code</th>
						<th>Subject Code</th>
						<th>Description</th>
						<th>Units</th>
						<th>Lab</th>
						<th>Lec</th>
					<th>Time</th>
					<th>Day</th>
					</tr>
				<?php if(!empty($subjects)):?>
				<?
					$total_units = 0;
					$total_lec = 0;
					$total_lab = 0;
					$ctr = 0;
				?>
				
				<?php foreach($subjects as $subject): ?>
					<?
						if($subject == false) { continue; }
						$total_units += $subject->units;
						$total_lec += $subject->lec;
						$total_lab += $subject->lab;
					?>
					<tr>
					<td><?php echo ++$ctr; ?></td>
					<td><?php echo $subject->sc_id; ?></td>
					  <td><?php echo $subject->code; ?></td>
					  <td><?php echo $subject->subject; ?></td>
					  <td><?php echo $subject->units; ?></td>
					  <td><?php echo $subject->lab; ?></td>
					  <td><?php echo $subject->lec; ?></td>
					<td><?php echo $subject->time; ?></td>
					<td><?php echo $subject->day; ?></td>
				  </tr>
					<?php endforeach;endif; ?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Total</td>
						<td id="total_units"><?php echo number_format($total_units,2,'.',' '); ?></td>
						<td id="total_labs"><?php echo number_format($total_lab,2,'.',' '); ?></td>
						<td id="total_labs"><?php echo number_format($total_lec,2,'.',' '); ?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</div>
	</fieldset>
</div>