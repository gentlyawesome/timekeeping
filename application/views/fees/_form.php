
 <?php 
		$name = array(
              'name'        => 'fees[name]',
              'value'       => isset($fees->name) ? $fees->name : '',
              'maxlength'   => '100',
              'size'        => '50',
              'style'       => 'width:50%',
            );
		

		$is_deduction = array(
			'name'        => 'fees[is_deduction]',
			'value'		  => 'yes',
			'checked'     => isset($fees->is_deduction) ? ($fees->is_deduction == 1 ? true : false) : false,
			);
		
		$active = array(
			'name'        => 'fees[is_active]',
			'value'		  => 'yes',
			'checked'     => isset($fees->is_active) ? ($fees->is_active == 1 ? true : false) : false,
			);
			
		$donot_show_in_old = array(
			'name'        => 'fees[donot_show_in_old]',
			'value'		  => 'yes',
			'checked'     => isset($fees->donot_show_in_old) ? ($fees->donot_show_in_old == 1 ? true : false) : false,
			);
		
		$is_misc = array(
			'name'        => 'fees[is_misc]',
			'value'		  => 'yes',
			'checked'     => isset($fees->is_misc) ? ($fees->is_misc == 1 ? true : false) : false,
			);
		$is_other = array(
			'name'        => 'fees[is_other]',
			'value'		  => 'yes',
			'checked'     => isset($fees->is_other) ? ($fees->is_other == 1 ? true : false) : false,
			);
			
		$is_package = array(
			'name'        => 'fees[is_package]',
			'value'		  => 'yes',
			'checked'     => isset($fees->is_package) ? ($fees->is_package == 1 ? true : false) : false,
			);
		$is_nstp = array(
			'name'        => 'fees[is_nstp]',
			'value'		  => 'yes',
			'checked'     => isset($fees->is_nstp) ? ($fees->is_nstp == 1 ? true : false) : false,
			);
			
?>

  <p>
    <label for="fee">Fee Name</label><br/>
	<?php 
		echo form_input($name);
	?>
  </p>
  
  <p>
	<?php 
		echo form_checkbox($is_deduction);
	?>
    <label for="is_deduction">Is Deduction ?</label><br />
  </p>
  
  <p>
	<?php 
		echo form_checkbox($active);
	?>
	<label for="is_active">Is Active ?</label><br />
  </p>  
  
  <p>
	<?php 
		echo form_checkbox($donot_show_in_old);
	?>
	<label for="donot_show_in_old">Do not show in old student ?</label><br />
  </p>
  
   <p>
	<label for="is_other">Is Other Fee ?</label>
	<?php 
		echo form_checkbox($is_other);
	?>
  </p>
  
  <p>
	<label for="is_misc">Is Misc. ?</label>
	<?php 
		echo form_checkbox($is_misc);
	?>
  </p>
  
  <p>
	<label for="is_nstp">Is NSTP ?</label>
	<?php 
		echo form_checkbox($is_nstp);
	?>
  </p>  
  
  <p>
	<label for="is_package">Is Package ?</label>
	<?php 
		echo form_checkbox($is_package);
	?>
  </p>
  
  
  
  <div class="clear"></div>

