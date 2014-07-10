<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<link REL="SHORTCUT ICON" HREF="<?=base_url('assets/images/favicon.ico');?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $this->setting->school_name; ?></title>
     <?php $xbootstrap = $this->syspar->bootstrap_theme ? strtolower($this->syspar->bootstrap_theme) : 'default';?>
    <link href="<?php echo base_url('assets/css/bootstrap.'.$xbootstrap.'.min.css'); ?>" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url('assets/css/pace.css'); ?>" rel="stylesheet" type="text/css" /><link href="<?php echo base_url('assets/css/custom-theme/jquery-ui-1.8.18.custom.css'); ?>" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.18.custom.min.js"></script>
    <link href="<?php echo base_url('assets/css/bootstrap-switch.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/login.css'); ?>" rel="stylesheet" type="text/css" />
    
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pace.js"></script>
     <script type='text/javascript'>
      $(document).ready(function() {      
        var base_url = "<?=site_url()?>";
        <?if(isset($system_message) && $system_message):?>
          <?$xmsg = str_replace('"',"'",$system_message);?>
          <?$xmsg = str_replace('\r\n'," ",$xmsg);?>
          <?$xmsg = str_replace('\n'," ",$xmsg);?>
          <?$xmsg = str_replace('\r'," ",$xmsg);?>
          try{
              growl('<p>System Message</p>',"<?=$xmsg?>");
          }
          catch(err){
            //Handle errors here
          }
        <?else:?>
        <?endif;?>    
      });
      </script>
    </head>
    <body>
    <?php @$this->load->view('layouts/_alert'); ?>
    <div id="msgDialog"></div>
  <!-- Wrap all page content here -->

    <div id="wrap">
      <div class="navbar navbar-default">
      <!-- <div class="navbar-collapse collapse navbar-responsive-collapse"> -->
        <div class="navbar-header">
          <a class="navbar-brand" href="#"><strong><?echo $this->companyinfo->name; ?></strong></a>
        </div>
      </div>
      
      <!-- Begin page content -->
      <div class="">
        <div class="col-md-12">