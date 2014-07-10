<div class="list-group">
  <a href="#"  class="list-group-item active">Account</a>
  <a href="<?=base_url()?>home"  class="list-group-item">Home</a>
  <a href="<?=base_url()?>sem_and_school_year"  class="list-group-item"><span class="glyphicon glyphicon-cog"></span>&nbsp; Sem / School Year</a>
  <a href="<?=base_url()?>calendar"  class="list-group-item">Calendar</a>
  <a href="<?=base_url()?>change_password/index/<?php echo $this->session->userdata('userid'); ?>"  class="list-group-item">Change Password</a>
  <a href="<?php echo base_url(); ?>auth/logout"  class="list-group-item">Logout</a>
</div>

