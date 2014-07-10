<?

$this->load->view('employees/_tab');

$par = "edit";
?>
<?echo form_open('','onsubmit="return validate()"');?>
<?$this->load->view('employees/_form')?>

<?
	echo form_hidden('id', $personal_info->id);
	echo form_submit('','Save Changes');
	echo form_close();
?>