
	$(function() {
		$('.ui-widget-overlay').live("click",function(){
            $("#message").dialog("close");
        });  
		
		$('.not_blank').each(function(){
			var xdata = $(this).val().trim();
			
			if(xdata == "")
			{
				$(this).css('border-color','red');
				$(this).attr('placeHolder','Required');
			}
			
			$(this).focusout(function(){
				
				var xdata = $(this).val().trim();
				
				if(xdata != ""){
					$(this).css('border-color','gray');
				}else{
					
					$(this).css('border-color','red');
					$(this).attr('placeHolder','Required');
				}
			});
		})
	});
  
	function validate()
	{
		var ctr = 0;
		var msg = "<ul>";
		var xfocus = "";
		$('.not_blank').css('border-color','gray');
		$('.not_blank').each(function(){
			var xval = $(this).val().trim();
			if(xval == ""){
				ctr++;
				$(this).css('border-color','red');
				if(ctr == 1) { xfocus = $(this); }
				var label = $(this).parent().prev().text();
				console.log($(this));
				msg += "<li>"
				+label+" should not be blank</li>";
			}
		});
		
		msg += "<ul>";
		
		if(ctr > 0)
		{
			xfocus.focus();
			$('#message_list').html(msg);
			$( "#message" ).dialog({
			  height : 400,
			  width:600,
			  modal : true,
			  buttons: {
				Close: function() {
				  $( this ).dialog( "close" );
				}
			  }
			});
			
			return false;
		}
		else
		{
			var status = $('#status').val();
			if($status.toLower() == "old")
			{
				var type = $('#type').val();
				if(type.toLower() != "block"){ //VALIDATE IF Has selected subject
				
				}
			}
			
		}
	}
	
	function CloseBlock(){
		$.unblockUI();
	}

