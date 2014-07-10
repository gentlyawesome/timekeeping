<?php
$userType = $this->session->userdata['userType'];
if ($userType == 'president')
{
?>
<img src="<?php echo base_url(); ?>assets/images/president.png" style="height: 25px; width: 25px;" /> President 
<?php 
}
elseif ($userType == 'admin')
{
?>
<img src="<?php echo base_url(); ?>assets/images/administrator.png" style="height: 25px; width: 25px;" /> Administrator 
<?php
}
elseif ($userType == 'dean')
{
?>
<img src="<?php echo base_url(); ?>assets/images/dean.png" style="height: 25px; width: 25px;" /> Dean/ Assessment Office 
<?php
}
elseif ($userType == 'office_assistant')
{
?>
<img src="<?php echo base_url(); ?>assets/images/assistant.png" style="height: 25px; width: 25px;" /> Office Assistant 
<?php
}
elseif ($userType == 'student_examiner')
{
?>
<img src="<?php echo base_url(); ?>assets/images/registrar.png" style="height: 25px; width: 25px;" /> Student Examiner 
<?php
}
elseif ($userType == 'registrar')
{
?>
<img src="<?php echo base_url(); ?>assets/images/registrar.png" style="height: 25px; width: 25px;" /> Registrar 
<?php
}
elseif ($userType == 'finance')
{
?>
<img src="<?php echo base_url(); ?>assets/images/financer.png" style="height: 25px; width: 25px;" /> Finance Manager 
<?php
}
elseif ($userType == 'hrd')
{
?>
<img src="<?php echo base_url(); ?>assets/images/hrd.png" style="height: 25px; width: 25px;" /> Human Resource 
<?php
}
elseif ($userType == 'teacher')
{
?>
<img src="<?php echo base_url(); ?>assets/images/teacher.png" style="height: 25px; width: 25px;" /> Teacher 
<?php
}
elseif ($userType == 'librarian')
{
?>
<img src="<?php echo base_url(); ?>assets/images/library.png" style="height: 25px; width: 25px;" /> Library
<?php
}
elseif ($userType == 'custodian')
{
?>
<img src="<?php echo base_url(); ?>assets/images/inventory.png" style="height: 25px; width: 25px;" /> Custodian 
<?php
}
elseif ($userType == 'student')
{
?>
<img src="<?php echo base_url(); ?>assets/images/student.png" style="height: 25px; width: 25px;" /> Student 
<?php
} else {
?>
Welcome
<?php
}
?>
