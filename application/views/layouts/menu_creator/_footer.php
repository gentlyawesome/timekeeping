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
    </body>
</html>
