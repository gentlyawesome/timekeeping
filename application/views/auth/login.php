<div class="row">
	<div class="col-md-6">                    
        
        <div class="panel panel-default" style='border:1px solid gray; !important'>

            <div class="panel-heading black">
                <div class="panel-title white-font"><strong>User Authentication</strong></div>
            </div>     

            <div style="padding-top:30px" class="panel-body" >
                
            	

			    <?php if(isset($system_message)) echo $system_message;
				  echo validation_errors('<div class="alert alert-danger">', '</div>');
			    ?>
                    
                <?=form_open('','id="loginform" class="form-horizontal" role="form"')?>
                    
                    <div class="form-group">
					  <label class="col-md-2 control-label" for="login">Employee ID</label>
					  <div class="col-md-9">
					    <div class="input-group">
					      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					      <input id="login" name="login" class="form-control" placeholder="Login" type="text" required>
					    </div>
					  </div>
					</div>

					<div class="form-group">
					  <label class="col-md-2 control-label" for="password">Password</label>
					  <div class="col-md-9">
					    <div class="input-group">
					      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					      <input id="password" name="password" class="form-control" placeholder="Password" type="password" autoComplete="Off" required>
					    </div>
					  </div>
					</div>

					<div class="form-group">
					  <label class="col-md-2 control-label" for="captcha">Captcha</label>

					  <div class="col-md-4">
					    <div class="input-group">
					      <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
					      <input id="captcha" name="captcha" class="form-control" placeholder="Captcha" type="text" required>
					    </div>
					  </div>

					  <div class="col-md-4">
					    <div class="input-group">
					     	<?echo $cap_image;?>
					    </div>
					        <p class="help-block">Verify that you are human.</p>
					  </div>
					</div>

					<div class="form-group">
					  <label class="col-md-2 control-label" for="prependedtext"></label>
					  <div class="col-md-9">
					    <div class="input-group">
					      <input class="btn btn-success btn-sm" name="commit" type="submit" value="Login" />
                          <a id="btn-clr" href="javascript:;" onclick="clear_e()" class="btn btn-default btn-info  btn-sm">Clear Entries</a>
                          <script type="text/javascript">
                          	function clear_e()
                          	{
                          		$('input[type="text"]').val('');
                          	}
                          </script>
					    </div>
					  </div>
					</div>


                    <!-- <div class="form-group">
                        <div class="col-md-12 control">
                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                Don't have an account! 
                            <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                Sign Up Here
                            </a>
                            </div>
                        </div>
                    </div>  -->

                </form> 
            </div>                     
        </div>  
    </div>
    <div class="col-md-6">                    
        <div class="panel panel-default">

            <div class="panel-heading">
                <span>INSTRUCTIONS</span>
            </div>     

            <div style="padding-top:30px" class="panel-body" >
            	<ul>
            		<li>To sign-in, specify your username, password and captcha and click the login button.</li>
            		<li>To clear entries, click on the Clear Entries button.</li>
            		<li>To change the captcha, just refresh the page.</li>
            		<li>The default password is your last name (small caps).</li>
            	</ul>
				
            </div>                     
        </div>  
    </div>
	<!-- <div class="col-md-6">
           <div class="col-md-4 col-md-offset-4">
		    <p class="text-center">  
		    <?php if(isset($system_message)) echo $system_message;
			  echo validation_errors('<div class="alert alert-danger">', '</div>');
		    ?>
		    </p>
		  </div>
			<?php echo form_open('', "class='form-signin'");?>
			<h2 class="form-signin-heading"><?php echo ucwords($UserType); ?> Login</h2>
				<input class="form-control" type="text" value="" name="login" placeholder="Login" value='<?=isset($login)?$login:''?>' >
				<input class="form-control" type="password" value="" name="password" placeholder="Password">
			
			<h5 class="form-signin-heading">Verify that you are human. Enter the letters below.</h5>
			<?echo $cap_image;?><br/><br/>
				<input class="form-control" type="text" value="" name="captcha" placeholder="Captcha">
				<br/>
				<input class="btn btn-lg btn-primary btn-block" name="commit" type="submit" value="Login" />
		  <?php
			echo form_hidden('userType', $UserType);
			echo form_close();
		  ?>
	</div> -->
</div>

  

