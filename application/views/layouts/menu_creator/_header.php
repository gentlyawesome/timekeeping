<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<link REL="SHORTCUT ICON" HREF="<?=base_url('assets/images/favicon.ico');?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $this->setting->school_name; ?></title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url('assets/css/pace.css'); ?>" rel="stylesheet" type="text/css" /><link href="<?php echo base_url('assets/css/custom-theme/jquery-ui-1.8.18.custom.css'); ?>" rel="stylesheet" type="text/css" media="all" />
	 <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.18.custom.min.js"></script>
    </head>
    <body>
	  <?php $this->load->view('layouts/_alert'); ?>
  <!-- Wrap all page content here -->
    <div id="wrap">
	  <!-- Fixed navbar -->
      <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php echo $this->setting->school_name; ?></a>
          </div>
          <div class="collapse navbar-collapse">
            
             
          </div><!--/.nav-collapse -->
        </div>
      </div>
      
      <!-- Begin page content -->
      <div class="container">

        
        <div class="col-md-2">
         			
        </div>
        
        
        <div class="col-md-10">
        <?if(isset($system_message))echo $system_message;
	        echo validation_errors('<div class="alert alert-danger">', '</div>');
	      ?>
            <div class="page-header">
              <h3><?= ucwords(str_replace('_', ' ', $this->router->class)) ?>
               <small><?= (ucwords(str_replace('_', ' ', $this->router->method)) == "Index") ? "" : ucwords(str_replace('_', ' ', $this->router->method)) ?></small></h3>
			    </div>