<script type="text/javascript">
	function validate(){
		
		var xdate = $('#date');
		var xprom = $('#promisory');
		
		if(xdate.val().trim() == "")
		{
			custom_modal('Required','<h4>Date is required.</h4>');
			return false;
		}
		else
		{
			if(xprom.val().trim() == "")
			{
				custom_modal('Required','<h4>Promisory Note is required.</h4>');
				return false;
			}
		}
		
	}
</script>
<div class="row">
  <div class="col-md-2" for='date'>Date</div>
  <div class="col-md-4"><input type='text' name='date' id='date' value='<?=isset($promisory)?$promisory->date : date('Y-m-d')?>' placeHolder='Required' class='not_blank date_pick' /></div>
</div>

<br/>

<div class="row">
  <div class="col-md-2" for='promisory'>Promisory</div>
  <div class="col-md-10">
	<textarea name="promisory" id='promisory' class='not_blank form-control' style="min-width:500px;max-width:700px;min-height:100px;max-height:300px;" rows="40" cols="150" >
		<?=isset($promisory)?$promisory->promisory : ''?>
	</textarea>
  </div>
</div>

<br/>