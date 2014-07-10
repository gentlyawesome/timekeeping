$(document).ready(function() { 
	// $('.edit-grade-form').submit(function(e){
	//  e.preventDefault();
	//  var input = $(this).find('input[name="value"] ');
	//  var parent = $(this).parent('td');
	//  var submit = $(this).find('input[type="submit"]');
	//  submit.attr("disabled", 'disabled');
	//  $.ajax({
	// 			url: $(this).attr('action'),
	// 			type: "POST",
	// 			dataType: "json",
	// 			data: $(this).serialize(),
	// 			success: function (data) {
	// 		input.val('');
	// 				input.attr('placeholder', 'saving..');
	// 		input.attr("disabled", 'disabled');
	// 				setTimeout(function(){input.attr('placeholder', data.new_value);}, 3000);
	// 			setTimeout(function(){parent.effect('highlight', {color: "#DFF0D8"}, 2000);}, 3000);	
	// 			setTimeout(function(){submit.removeAttr('disabled');}, 3000);	
	// 			setTimeout(function(){input.removeAttr('disabled');}, 3000);	
	// 			},
	// 			error: function (xhr, status) {
	// 				alert('Sorry, but something went wrong.');		
	// 			},
	// 			complete: function (xhr, status) {
	// 			}
	// 		});
	// });
	
  $('.tp').tooltip();

    $('#subject_list tr td a').click(function (e) {
	run_pleasewait();
    e.preventDefault();
	$(this).attr('disabled', true);
      var parent = $(this).closest('tr');
      var cloned_parent = parent.clone(true);
	  
      parent.addClass('success');
        $.ajax({
            url: $(this).attr('href'),
            type: "POST",
            dataType: "json",
            success: function (data) {
			  cloned_parent.find('td:first').hide();
			  cloned_parent.find('td:last').remove();
              cloned_parent.find('td:last').after("<td>"+data.url+"</td>");
			 
              $('#user_subjects_total').before(cloned_parent);
              
              $('#total_units').text(data.units);
              $('#total_labs').text(data.labs);
			  $('#total_lec').text(data.units - data.labs);
              parent.hide('slow');
              refresh_deletion();
            },
            error: function (xhr, status) {
                /* alert("Sorry, there was a problem!"); */
		
            },
            complete: function (xhr, status) {
                close_pleasewait()
            }
        });
    });
     

    refresh_deletion();
    
    // --- Hide Image ---
    $( '#ajaxLoadAni' ).fadeOut( 'slow' );
    
    // --- Calendar Function ---
    $( ".datepicker" ).datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:"1995:y"
    });
	
	$( ".date_pick" ).datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange:"1985:y",
			dateFormat:'yy-mm-dd'
    });
    
    $( ".datepicker2" ).datepicker({
            changeMonth: true,
            changeYear: true,
            minDate: "-15y",
            maxDate: "y"
    });
	
    $( ".datepicker-payment" ).datepicker({
		changeMonth: true
    });	
	
    
	$( ".datepicker3" ).datepicker({
            changeMonth: true,
            changeYear: true,
        });
	
    // --- Accordion Function ---
    $('.accordion h3.head').click(function() {
        $(this).next().slideToggle('slow');
        return false;
    })
    $('.accordion h3.head2').click(function() {
        $(this).prev().slideToggle('slow');
        return false;
    });
    
    // --- Student Stat ---
    $( '.studentStat' ).click(function(){
        var a = $('input[name=student_status]:checked').val();
        if(a=='new')
        {
            $('input[name=student_id]').val('');
            $('#studentId').css({ "display" : "none" });
        }
        else
        {
            $('#studentId').css({ "display" : "block" });
        }
    });
	
	//Puts Red Border Color on required fields
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
	});
	
		$('.is_number').each(function(){
		
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
	});

    
    // --- Modal ---
    $( '#msgDialog' ).dialog({
        autoOpen: false,
        
        buttons: {
            'Ok': function() {
                $( this ).dialog( 'close' );
            }
        }
    });
    
    // --- Tab ---
    // Tabs
    $('#tabs').tabs();
    
    // --- Get The Base URL ---
    var baseurl = $('#baseurl').val();    
    
    // --- Confirm Deletion ---
    
    // $('a.confirm').click(function(e){
      // e.preventDefault();
      // var url = $(this).attr('href');
      // $('#myModal').modal('show');
      // $('#myModal #confirm').click(function(){
        // window.location = url;
      // });
    // });
	
	$('a.confirm').click(function(e){
      e.preventDefault();
      var url = $(this).attr('href');
      var title = $(this).attr('title');
      $('#myModal').modal('show');
	   if(title != "" && title != null){
		
			$('#myModal .modal-body').html('<p>'+title+'</p>');
	   }
      $('#myModal #confirm').click(function(){
        window.location = url;
      });
    });

	// $('input.confirm').click(function(event){
	// 	event.preventDefault();
	// 	var title = $(this).attr('title');
	// 	console.log($(this));
	// 	var form = $(this).closest("form");
	// 	$('#myModal').modal('show');
	// 	if(title != "" && title != null){

	// 		$('#myModal .modal-body').html('<p>'+title+'</p>');
	// 	}
	// 	$('#myModal #confirm').click(function(){
	// 		$($(this).closest("form")).submit();
	// 		console.log(form);
	// 	});
	// });
    
    $('a.confirm-auto').click(function(e){
      e.preventDefault();
      var url = $(this).attr('href');
      $('#myModal').modal('show');
      $('#myModal #confirm').click(function(){
        window.location = url;
      });
    });
	
	$('.confirm-auto2').click(function(e){
      e.preventDefault();
      var url = $(this).attr('href');
      $('#myModal').modal('show');
      $('#myModal #confirm').click(function(){
        window.location = url;
      });
    });
    
    // --- Create Subject To Curriculum Record ---
    $( '.subject_to_curriculum' ).click(function(){        
            
            $( '#ajaxLoadAni' ).fadeIn( 'slow' );
            
            var target = $(this).attr("id");
            
            $.ajax({
                dataType : 'json',
                url: baseurl + 'admin/create_subject_to_curriculum',
                type: 'POST',
                data: $( '#myform' + target ).serialize(),
                
                success: function( response ) {
                    
                        $( '#msgDialog > p' ).html( 'inserted' );
                        $( '#msgDialog' ).dialog( 'option', 'title', 'Success' ).dialog( 'open' );
                        $( '#ajaxLoadAni' ).fadeOut( 'slow' );
                        
                    
                }

            });
            
            return false;
        
    });
	
	// CHECK ALL CHECKBOXES
	$('.check_all').click(function(){
		
		var id = $(this).attr('id');
		
		if($(this).is(':checked')){
			$('.'+id).attr('checked', 'checked');
		}
		else if($(this).not(':checked')){
			$('.'+id).removeAttr('checked');
		}
	});
	
	$('.time').timepicker({
			timeFormat: 'h:mm'
	});
	
	//AUTO NUMERIC INPUT
	// $('.currency').on("keypress keyup blur",function (event) {
		
	   // $(this).val($(this).val().replace(/[^0-9\.]/g,''));
		// if ((event.which != 46 || $(this).val().indexOf('.') != -1) 
			// && (event.which < 48 || event.which > 57)) {
			// event.preventDefault();
		// }
	// });
	
	// $('.currency').number( true, 2,'.', '' ); 
	
	$('input.numeric').live('keyup', function(e) {
	  $(this).val($(this).val().replace(/[^0-9]/g, ''));
	});
	
	$(document).ajaxStart(function(){
		run_pleasewait();
	}).ajaxStop($.unblockUI);

});// --- end document ready ---


function notify_modal(title, content){
  $("#notify-modal").modal('toggle');
  $("#notify-modal #notify-modal-title").text(title);
   $("#notify-modal #notify-modal-content").html(content);
}

function custom_modal(title, html)
{
	
	$('#alertModal_Body').html(''); 
	$('#alertModal_Label').text(title); //SET MODAL TITLE
	$('#alertModal_Body').html(html); //SET MODAL CONTENT
	$('#alertModal').modal('show'); //SHOW MODAL
}

function refresh_deletion(){
	$('a.delete_subject').unbind();
	$('a.delete_subject').click(function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		var tr = $(this).closest('tr');
	        var me = $(this); 
                me.attr('disabled', true);
		$('#myModal').modal('toggle');
		$('#confirm').unbind();
		$('#confirm').click(function(){	
		
			$('#myModal').modal('hide');
			$.ajax({
				url: url,
				type: "POST",
				dataType: 'json',
				success: function (data) {
				  if (data.status) {
					notify_modal('Note', "Can't remove subject because it contains grade. Please contact your registrar for confirmation.");
					me.removeAttr('disabled');
				  }else{
			            tr.addClass('danger');
				    tr.hide('slow');
				    $('#total_units').text(data.units);
				    $('#total_labs').text(data.labs);
				    $('#total_lec').text(data.units - data.labs);
				  }
				},
				error: function (xhr, status) {
					alert("Sorry, there was a problem!");
				},
				complete: function (xhr, status) {
					var par = url.substr(url.lastIndexOf('/') + 1);
					//DONT REFRESH PAGE
					if(par == 'nf') {}
					else{ 
						location.reload(); 
					}
				}
			});  
		});  
		
	});
}
// End User Subject Ajax
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function run_pleasewait()
{
	$.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        },message: $('#please_wait') }); 
}

function close_pleasewait()
{
	$.unblockUI();
}

function numVal(data)
{
	if(data == "" || data == null)
	{
		return 0;
	}
	else
	{
		return parseFloat(data.replace(/[^0-9.]/g, ""));
	}
}

function custom_jmodal(xtitle, xcontent, xwd, xht)
{
	close_jmodal();
	xtitle = (xtitle) ? xtitle : 'Some Title';
	xcontent = (xcontent) ? xcontent : '';
	xwd = (xwd) ? xwd : 300;
	xht = (xht) ? xht : 300;
	
	$('#j_modal').html(xcontent);
	
	// --- Modal ---
    $( '#j_modal' ).dialog({
        autoOpen: true,
        modal: true,
		title: xtitle,
		width: xwd,
		height: xht,
		position: ['center'],
        buttons: {
            'Close': function() {
                $( this ).dialog( 'close' );
            }
        }
    });
}

function close_jmodal()
{
	$( '#j_modal' ).dialog( 'close' );
}

function growl(title, msg)
{
	// $.growlUI(title, msg);
	
	$('.growl_title').html(title);
	$('.growl_msg').html(msg);
	
	$.blockUI({ 
            message: $('div.growl'), 
            fadeIn: 700, 
            fadeOut: 700, 
            timeout: 2000, 
            showOverlay: false, 
            centerY: false, 
            css: { 
                width: '350px', 
                bottom: '10px',
                top: '-100',
                left: '', 
                right: '10px', 
                border: 'none', 
                padding: '5px', 
                backgroundColor: 'black', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .6, 
                color: '#fff'
            } 
        }); 	
}


/*
	SLY
	JNOTIFY PLUGIN
	REFERENCE : http://www.myjqueryplugins.com/jquery-plugin/jnotify
*/
function jnotice(title, msg)
{
	 jNotify(
		'<i class="fa fa-info-circle fa-2x"></i> &nbsp; <strong>'+title+'</strong><br /><strong>'+msg+'</strong>',
		{
		  autoHide : true, // added in v2.0
		  clickOverlay : false, // added in v2.0
		  MinWidth : 250,
		  TimeShown : 2000,
		  ShowTimeEffect : 200,
		  HideTimeEffect : 200,
		  LongTrip :20,
		  HorizontalPosition : 'right',
		  VerticalPosition : 'top',
		  ShowOverlay : false,
   		ColorOverlay : 'black',
		  OpacityOverlay : 0.3,
		  onClosed : function(){ // added in v2.0
		   
		  },
		  onCompleted : function(){ // added in v2.0
		   
		  }
		});
	  
}