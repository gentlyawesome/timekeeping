<style type="text/css">
	 fieldset.scheduler-border {
		border: 1px groove #ddd !important;
		padding: 0 1.4em 1.4em 1.4em !important;
		margin: 0 0 1.5em 0 !important;
		-webkit-box-shadow:  0px 0px 0px 0px #000;
				box-shadow:  0px 0px 0px 0px #000;
	}

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }
	
	.process-active
	{
		color: #fff;
		background-color: #463265;
		font-weight:bold;
	}
</style>

		<div class="xwell">
			<nav class="navbar navbar-default" role="navigation">
				<?if($back_url!="#"):?>
				<div class="navbar-header">
					<a class="navbar-brand" href="<?=$back_url?>"><span class="glyphicon glyphicon-hand-left">Previous</span></a>
				</div>
				<?endif;?>
			  <!-- Collect the nav links, forms, and other content for toggling -->
			  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
				  <li><a href="#" class='<?=$process=="START" ? "process-active" : ''?>'>START</a></li>
				  <li><a href="#"><span class="glyphicon glyphicon-hand-right"></span></a></li>
				  <li><a href="#" class='<?=$process=="REGISTRATION" ? "process-active" : ''?>'>REGISTRATION</a></li>
				  <li><a href="#"><span class="glyphicon glyphicon-hand-right"></span></a></li>
				  <li><a href="#" class='<?=$process=="ASSESSMENT" ? "process-active" : ''?>'>ASSESSMENT</a></li>
				  <li><a href="#"><span class="glyphicon glyphicon-hand-right"></span></a></li>
				  <li><a href="#" class='<?=$process=="PAYMENT" ? "process-active" : ''?>' >PAYMENT</a></li>
				  <li><a href="#"><span class="glyphicon glyphicon-hand-right"></span></a></li>
				  <li><a href="#" class='<?=$process=="FINISH" ? "process-active" : ''?>' >FINISH</a></li>
				</ul>
			  </div><!-- /.navbar-collapse -->
			</nav>
			<?if(isset($disable_lasten) && $disable_lasten == true):?>
			<?else:?>
			<fieldset class="scheduler-border">
				<legend class="scheduler-border">Information of Last Enrollment</legend>
				<div>
					<table>
						<tr>
							<th>Fullname</th>
							<td><?=strtoupper($student->full_name);?>
							</td><th>Student ID Number</th>
							<td><?=strtoupper($student->studid);?></td>
						</tr>
						<tr>
							<th>Course</th>
							<td><?=strtoupper($student->course);?>
							</td><th>Year Level</th>
							<td><?=strtoupper($student->year);?></td>
						</tr>
						<tr>
							<th>School Year</th>
							<td><?=$student->sy_from;?>-<?=$student->sy_to;?>
							</td><th>Semester</th>
							<td><?=strtoupper($student->name);?></td>
						</tr>
					</table>
				</div>
			</fieldset>
			<?endif;?>
		</div>
