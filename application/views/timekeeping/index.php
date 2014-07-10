<style type="text/css">
body{
	 background:#202020;
	 font:bold 12px Arial, Helvetica, sans-serif;
	 margin:0;
	 padding:0;
	 min-width:960px;
	 color:#bbbbbb; 
}

a { 
	text-decoration:none; 
	color:#00c6ff;
}

h1 {
	font: 4em normal Arial, Helvetica, sans-serif;
	padding: 20px;	margin: 0;
	text-align:center;
}

h1 small{
	font: 0.2em normal  Arial, Helvetica, sans-serif;
	text-transform:uppercase; letter-spacing: 0.2em; line-height: 5em;
	display: block;
}

h2 {
    font-weight:700;
    color:#bbb;
    font-size:20px;
}

h2, p {
	margin-bottom:10px;
}

.black-font{
	color:#000000;
}

/*
@font-face {
    font-family: 'BebasNeueRegular';
    src: url('BebasNeue-webfont.eot');
    src: url('BebasNeue-webfont.eot?#iefix') format('embedded-opentype'),
         url('BebasNeue-webfont.woff') format('woff'),
         url('BebasNeue-webfont.ttf') format('truetype'),
         url('BebasNeue-webfont.svg#BebasNeueRegular') format('svg');
    font-weight: normal;
    font-style: normal;

}*/

.container {width: 960px; margin: 0 auto; overflow: hidden;}

.clock {width:800px; margin:0 auto; padding:30px; border:1px solid #333; color:#fff; }

.Date, #Date { font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; font-size:36px; text-align:center; text-shadow:0 0 5px #00c6ff; }

ul { width:800px; margin:0 auto; padding:0px; list-style:none; text-align:center; }
ul li { display:inline; font-size:10em; text-align:center; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; text-shadow:0 0 5px #00c6ff; }

#point { position:relative; -moz-animation:mymove 1s ease infinite; -webkit-animation:mymove 1s ease infinite; padding-left:10px; padding-right:10px; }

@-webkit-keyframes mymove 
{
0% {opacity:1.0; text-shadow:0 0 20px #00c6ff;}
50% {opacity:0; text-shadow:none; }
100% {opacity:1.0; text-shadow:0 0 20px #00c6ff; }	
}


@-moz-keyframes mymove 
{
0% {opacity:1.0; text-shadow:0 0 20px #00c6ff;}
50% {opacity:0; text-shadow:none; }
100% {opacity:1.0; text-shadow:0 0 20px #00c6ff; }	
}

</style>
<script type="text/javascript">
$(document).ready(function() {

	// Create two variable with the names of the months and days in an array
	var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ]; 
	var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]

	// Create a newDate() object
	var newDate = new Date();
	// Extract the current date from Date object
	newDate.setDate(newDate.getDate());
	// Output the day, date, month and year    
	$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

	setInterval( function() {
		// Create a newDate() object and extract the seconds of the current time on the visitor's
		var seconds = new Date().getSeconds();
		// Add a leading zero to seconds value
		$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
		},1000);
		
	setInterval( function() {
		// Create a newDate() object and extract the minutes of the current time on the visitor's
		var minutes = new Date().getMinutes();
		// Add a leading zero to the minutes value
		$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
	    },1000);
		
	setInterval( function() {
		// Create a newDate() object and extract the hours of the current time on the visitor's
		var hours = new Date().getHours();

		//convert to 24 hour format - remove this if 24 hour format you like
		if(hours > 12){
			hours = hours - 12;
		}
		
		// Add a leading zero to the hours value
		$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
	    }, 1000);
	
});

</script>

<div class="container">
	<div class="clock">
		<div id="Date"></div>
		<ul>
			<li id="hours"> </li>
		    <li id="point">:</li>
		    <li id="min"> </li>
		    <li id="point">:</li>
		    <li id="sec"> </li>
		</ul>
		<br/>
		<div>
			<?echo form_open('', 'class="form-horizontal" ')?>
				<fieldset>

				<!-- Form Name -->
				<legend>Timekeeping</legend>

				<div class="form-group">
					<?=$system_message;?>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="textinput">Employee</label>  
				  <div class="col-md-5">
				  <?=form_dropdown('empid', $employers,isset($empid)?$empid:'','required id="empid"');?>
				  </div>
				</div>

				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="secreto">Password</label>
				  <div class="col-md-5">
				    <input id="secreto" name="secreto" type="password" placeholder="" class="form-control input-md" autoComplete="off" required>
				  </div>
				</div>

				<!-- Button (Double) -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="button1id">Action</label>
				  <div class="col-md-8">
				    <input type="submit" name="btn_in" class="btn btn-success" value="TIME IN">
				    <input type="submit" name="btn_out" class="btn btn-danger" value="TIME OUT">
				    <input type="submit" name="btn_view" class="btn btn-info" value="VIEW">
				  </div>
				</div>

				</fieldset>
			</form>
		</div>
	</div>
</div>

<?if(isset($view_record) && $view_record):?>
<div class="container">
	<div class="clock">
		<div id="Date">Time Record for this day.</div>
		<br/>
		<div class="table-responsive">
			<table class="table">
				<tr>
					<td>Date</td>
					<td>In</td>
					<td>Out</td>
				</tr>

				<?foreach ($view_record as $key => $value):?>
					
					<tr>

						<td><?=date('m-d-Y', strtotime($value->date))?></td>

					<?if($value->logtype == "IN"):?>
						<td><?=date('g:i a',strtotime($value->time))?></td>
						<td></td>
					<?else:?>
						<td></td>
						<td><?=date('g:i a',strtotime($value->time))?></td>
					<?endif;?>

					</tr>

				<?endforeach;?>

			</table>
		</div>
	</div>
</div>
<?endif;?>
