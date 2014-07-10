<ul class="nav nav-tabs">
	<li <?= ($this->router->class == "employees" && $this->router->method == 'display') ? "class='active'" : '' ?>>
	  <a href="<?php echo base_url('employees/display/'.$id); ?>">Profile</a></li>
	  
	<? if(strtolower($this->session->userdata['userType']) == "hrd") :?>
		<li <?= ($this->router->class == "employees" && $this->router->method == 'edit') ? "class='active'" : '' ?>>
		<a href="<?php echo base_url('employees/edit/'.$id); ?>">Update Profile</a></li>
	<? endif;?>
	
	<?if(isset($personal_info) && $personal_info):?>
	
	<? if(strtolower($personal_info->role) == "teacher") :?>
		<li <?= ($this->router->class == "employees" && $this->router->method == 'add_assignsubject') ? "class='active'" : '' ?>>
		<a href="<?php echo base_url('employees/add_assignsubject/'.$id); ?>">Asign Subject</a></li>
	<?endif;?>
	
	<?endif;?>
	
	<li <?= ($this->router->class == "employees" && $this->router->method == 'add_assign_course') ? "class='active'" : '' ?>>
	  <a href="<?php echo base_url('employees/add_assign_course/'.$id); ?>">Assign Course</a></li>
	  
	<li <?= ($this->router->class == "change_password" && $this->router->method == 'reset') ? "class='active'" : '' ?>>
	  <a href="<?php echo base_url('change_password/reset/'.$id); ?>">Change Password</a></li>
	
</ul>

<br/>