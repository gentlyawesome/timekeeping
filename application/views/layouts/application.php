<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
  <link REL="SHORTCUT ICON" HREF="<?=base_url('assets/images/favicon.ico');?>">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $this->companyinfo->name; ?><?=$this->router->class!= "" ? " | ".ucwords(str_replace('_', ' ', $this->router->class)) : ''?></title>
    <?php $xbootstrap = $this->syspar->bootstrap_theme ? strtolower($this->syspar->bootstrap_theme) : 'default';?>
    <link href="<?php echo base_url('assets/css/bootstrap.'.$xbootstrap.'.min.css'); ?>" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url('assets/css/glyphicons.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/font-awesome-4.0.3/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url('assets/css/pace.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/custom-theme/jquery-ui-1.8.18.custom.css'); ?>" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo base_url('assets/js/jnotify/jNotify.jquery.css'); ?>" rel="stylesheet" type="text/css" media="all" />
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.8.18.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.number.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jnotify/jNotify.jquery.min.js"></script>
    </head>
    <body>  
   <script type='text/javascript'>
    $(document).ready(function() {      
      

      <?if(isset($system_message) && $system_message != ''):?>
        growl('<p>System Message</p>',"<?=$system_message?>");
      <?else:?>
      <?endif;?>
    });
    
    </script>
   <?php $this->load->view('layouts/_alert'); ?>
  <!-- Wrap all page content here -->
    <div id="wrap">
      
     <div class="navbar navbar-default">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?=$this->companyinfo->name?></a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
          <?@$this->load->view('layouts/_left_top_menu')?>
          <?@$this->load->view('layouts/_right_top_account_menu')?>
        </div>
      </div>
      
      <!-- Begin page content -->
      <div class="container">
        
        <div class="col-md-12">
        <?if(isset($system_message))echo $system_message;
          echo validation_errors('<div class="alert alert-danger">', '</div>');
        ?>
            <div class="page-header">
              <h3><?= ucwords(str_replace('_', ' ', $this->router->class)) ?>
        <?if(isset($custom_title) && $custom_title):?>
          <small><?=$custom_title;?></small>
        <?else:?>
        <small><?= (ucwords(str_replace('_', ' ', $this->router->method)) == "Index") ? "" : ucwords(str_replace('_', ' ', $this->router->method)) ?></small>
        <?endif;?>
        </h3>
            </div>
            <?php echo $yield; ?>
        </div>
      </div>

    </div>

    <div id="footer">
      <div class="container">
        <p class="text-muted credit">&copy; Copyright Gocloud Asia 2013</p>
      </div>
    </div>
    
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   
    <link href="<?php echo base_url('assets/css/bootstrap-switch.css'); ?>" rel="stylesheet" type="text/css" />
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pace.js"></script>
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script>
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-switch.js"></script>
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/myjs.js"></script>
     <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/blockui.js"></script>
     
    <link href="<?php echo base_url('assets/css/overwrite.css'); ?>" rel="stylesheet" type="text/css" />
  
   <!-- General Modal For Alert -->
  <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title" id="alertModal_Label">Alert</h4>
      </div>
      <div class="modal-body" id="alertModal_Body">
      ...
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
   <!-- End of alert modal -->
  
    <script>
      $('.radio1').on('switch-change', function () {
        $('.radio1').bootstrapSwitch('toggleRadioStateAllowUncheck', true);
      });
    </script>
  
  <!--PLEASE WAIT-->
  <div id='please_wait' style='display:none;'>
    <img src="<?=base_url()?>assets/images/loading.gif" ></img>
    &nbsp;
    Just a moment please.
  </div>
  
    </body>
</html>
