
 <?php 
		$value = array(
              'name'        => 'remarks[value]',
              'value'       => isset($remarks->value) ? $remarks->value : '',
              'maxlength'   => '100',
              'size'        => '50',
              'style'       => 'width:50%',
            );
		

		$is_deduction = array(
			'name'        => 'remarks[is_deduction]',
			'value'		  => 'yes',
			'checked'     => isset($remarks->is_deduction) ? ($remarks->is_deduction == 1 ? true : false) : false,
			);
		
		$is_payment = array(
			'name'        => 'remarks[is_payment]',
			'value'		  => 'yes',
			'checked'     => isset($remarks->is_payment) ? ($remarks->is_payment == 1 ? true : false) : false,
			);
?>

  <p>
    <label for="year">Remarks</label><br/>
	<?php 
		echo form_input($value);
	?>
  </p>
  
  <p>
	<?php 
		echo form_checkbox($is_deduction);
	?>
    <label for="is_deduction">Is Deduction</label><br />
  </p>
  
  <p>
	<?php 
		echo form_checkbox($is_payment);
	?>
	<label for="is_payment">Is Payment</label><br />
  </p>
  <div class="clear"></div>

