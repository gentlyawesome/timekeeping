// Place your application-specific JavaScript functions and classes here
// This file is automatically included by javascript_include_tag :defaults
//$.ajaxSetup ({
//    // Disable caching of AJAX responses
//    cache: false
//});$(function(){
	$.ajaxSetup ({
    // Disable caching of AJAX responses
    cache: false
});
	$(function(){    			
    		$.facebox.settings.closeImage = '/images/closelabel.png'
			$.facebox.settings.loadingImage = '/images/loading.gif'
			$('a[class*=facebox_link]').facebox();
			//$('a[class*=menuAjax]').menuAjax();
			$('a[id*=ext]').externalLink();
			$('#announcement_board').vTicker({
				speed: 500,
				pause: 8000,
				showItems: 1,
				animation: 'fade',
				mousePause: true,
				height:0,
				direction: 'up'
				});
			updateJavascript();
			updateLinks();
    	});
	
	function defaultText(){
		$('input[id*=search]').each(function() {
        	$.data(this, 'default', "Search here . . .");
        	$(this).css('color', "#ccc");
    		}).focus(function() {
    		    if (!$.data(this, 'edited')) {
    		        this.value = "";
    		        $(this).css('color', "#000");
    		    }
    		}).change(function() {
    		    $.data(this, 'edited', this.value != "");
    		     $(this).css('color', "#000");
    		}).blur(function() {
    		    if (!$.data(this, 'edited')) {
    		        this.value = $.data(this, 'default');
    		        $(this).css('color', "#ccc");
    		    }
    	});
	};
	

	
	function updateTable(){
		$('#content').html("<div id='load'></div>");
		var path = window.location.pathname;
		$.ajax({
			type: 'GET',
			url: path,
			success: function(data){
				$("#content").replaceWith($('#content', $(data)));
				
				//setTimeout(function(){
				//	window.location = window.location.href;
				//}, 5000);	
			}
		});
	}
	
	function updateTable2(){
		$('#content').html("<div id='load'></div>");
		var path = window.location.pathname;
		$.ajax({
			type: 'GET',
			url: path,
			success: function(data, text){
				$("#content").replaceWith($('#content', $(data)));
				$('#flash').html("<div id='flash_notice'>Success.</div>");
				updateJavascript();
				updateLinks();
			},error:function(){
				updateJavascript();
				updateLinks();
				$('#flash').html("<div id='flash_error'>We are sorry but an error occured upon your request.</div>");}
		});
	}
	
	function updateTable3(){
		$('#popup_content').html("<div id='load'></div>");
		var path = window.location.pathname;
		$.ajax({
			type: 'GET',
			url: path,
			success: function(data, text){
				$('#popup_content').replaceWith($('#popup_content', $(data)));
				$('#flash').html("<div id='flash_notice'>Success.</div>");
				updateJavascript();
				updateLinks();
			},error:function(){
				updateJavascript();
				updateLinks();
				$('#flash').html("<div id='flash_error'>We are sorry but an error occured upon your request.</div>");}
		});
	}
	
	function cornerInput(){
		$("input").corner('5px');
    	$("select").corner('5px');
    	$('form p').corner('5px');
    	$('form p').hover(function(){
			$(this).css("background-color", "#bfe293");
		}, function(){
			$(this).css("background-color", "#fff");
		});
	};
	
	function updateJavascript(){
		$(function(){
			cornerDivs();
    		$('#delete').deleteAjax();
    		var table = $('#table');
    		$('#filter').keyup(function(){
    		  $.uiTableFilter( table, this.value );
    		});
    		$("table[id*=table]").tablesorter({widthFixed: true, widgets: ['zebra']});
    		//.tablesorterPager({container: $("div#pager")}); 
    		$('#flash_notice').hide();
    		$('#flash_error').hide();
    		
    		setTimeout(function(){
    			$("#flash_error").slideDown("slow");
				$("#flash_notice").slideDown("slow");
			}, 500);
			setTimeout(function(){
    			$("#flash_error").slideUp("slow");
				$("#flash_notice").slideUp("slow");
			}, 10000);
    		
    		if($('#myList-nav').is(':empty')){
    			$('#myList').listnav({ 
		    			includeNums: false,  
    			noMatchText: 'There are no matching entries.',
    			initLetter: 'a' 
		  		});
    		};
    		$('#fee').accordion();
			$('#grade').accordion();
			$('#exam').accordion();
			$("table[id*=table]").tablesorter({widthFixed: true, widgets: ['zebra']});
			$("#student_subjects").accordion();
    		
    
    		
    			
    			
		});
			
	};
	
	function cornerDivs(){
		$(function(){
			$('#calendar table').corner('5px');
			$('#menu ul').corner("top 5px");
			$('a[class*=actionlink]').corner('5px');
			$('#user_link').corner("bottom 5px");
			$('#footer p').corner("5px");
    		$("input").corner('5px');
    		$("select").corner('5px');
    		$("#announcement_board").corner('5px');
    		$('#content').corner('5px');
    		$('#content a').corner('5px');
    		$('a[class*=first_menu_links]').corner('top 5px');
    		$('.student_search').corner('5px');
    		$('.student_search').hover(function(){
			$(this).css("background-color", "#e2f7c8");
				}, function(){
			$(this).css("background-color", "#fff");
			});
		});
	};
	
	function updateLinks(){
		$(function(){
			$.facebox.settings.closeImage = '/images/closelabel.png'
			$.facebox.settings.loadingImage = '/images/loading.gif'
			$('a[rel*=facebox]').facebox();
			$('a[id*=delete]').deleteAjax();
			$('a[class*=delete]').deleteAjax();
			$('a[id*=remove]').removeThis();
			$('a[id*=reopen]').reopenAjax();
			$('a[id*=delete_facebox]').deletefaceboxAjax();
			$('a[class*=edit_feeval]').openLink();
		});
	};
	
	function jqueryDate(){
		$( "input[class*=date_pick]" ).datepicker({
		yearRange: "-90:+0",
		changeMonth: true,
		changeYear: true
		});
    	$( "input[class*=date_pick]" ).datepicker({ dateFormat: 'yy-mm-dd' });
    	//getter
		var dateFormat = $( "input[class*=date_pick]" ).datepicker( "option", "dateFormat" );
		//setter
		$( "input[class*=date_pick]" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );	
		$('input[class*=datepicktime]').datetimepicker();
	};
	
	function manipulateTable(){
		$(function(){
			$('#content #pager img').bind('click', function(event){
			updateLinks();
		    });
		
		    $('#content #pager .pagesize').change(function(){
		    	updateLinks();
		    });
		});
		
	};
	
	
	jQuery.fn.externalLink = function(){
			this.click(function(){
				var external_link = "";
				external_link = this.href;
				alert(external_link);
			return false;
			});
	};
	
	
	jQuery.fn.deleteAjax = function (){
		   this.click(function() {
		   	if(confirm("Are You Sure?")){
   			 $.post(this.href, { _method: 'delete' }, null, "script");
   			 $(this).parents('tr:first').remove();
		   		//var hash = window.location.hash;
		   		//var new_link = hash.replace("#", '');
		   		//updateTable2("/"+new_link);
		   		updateTable2();
   			}
   		 	return false;
  			});
		};

	jQuery.fn.deleteAjax2 = function (){
		   this.click(function() {
		   	if(confirm("Are You Sure?")){
   			 $.post(this.href, { _method: 'delete' }, null, "script");
   			 $(this).parents('tr:first').remove();
		   		//var hash = window.location.hash;
		   		//var new_link = hash.replace("#", '');
		   		//updateTable2("/"+new_link);
   			}
   		 	return false;
  			});
		};

	jQuery.fn.deleteAjaxPopup = function (){
		   this.click(function() {
		   	if(confirm("Are You Sure?")){
   			 $.post(this.href, { _method: 'delete' }, null, "script");
   			 jQuery(document).trigger('close.facebox');
		   		//var hash = window.location.hash;
		   		//var new_link = hash.replace("#", '');
		   		//updateTable2("/"+new_link);
		   		updateTable2();
   			}
   		 	return false;
  			});
		};
		
	jQuery.fn.deletefaceboxAjax = function (){
	   this.click(function() {
	   	if(confirm("Are You Sure?")){
   		 $.post(this.href, { _method: 'delete' }, null, "script");
   		 jQuery(document).trigger('close.facebox');
		   		//var hash = window.location.hash;
		   		//var new_link = hash.replace("#", '');
		   		//updateTable2("/"+new_link);
		   		updateTable2();
   		}
   	 	return false;
  		});
	};
		
	jQuery.fn.removeThis = function (){
		   this.click(function() {
		   	if(confirm("Are You Sure?")){
		   	$.post(this.href, { _method: 'delete' }, null, "script");
   			 $(this).parent('p:first').remove();	
		   	}
   		 	return false;
  			});
		};
	
	jQuery.fn.updateAjax = function () {  
		  this.submit(function () {  
		    $.post($(this).attr('action'), $(this).serialize(), null, "script");
		   	jQuery(document).trigger('close.facebox');
		   		//var hash = window.location.hash;
		   		//var new_link = hash.replace("#", '');
		   		//updateTable2("/"+new_link);
		   		updateTable2();
		    return false;  
		  });  
		};
   jQuery.fn.updateAjax2 = function(){
   		this.submit(function(){
   			$.ajax({
   				type: 'PUT',
   				url: this.attr('action'),
   				data: this.serialize(),
   				dataType: 'script',
   				success:function(){
   				updateTable2();
   				}
   			});
   		});
   };
		
	jQuery.fn.createAjax = function () {  
		  this.submit(function () {  
		    $.post($(this).attr('action'), $(this).serialize(), null, "script");
		   	jQuery(document).trigger('close.facebox');
		   		//var hash = window.location.hash;
		   		//var new_link = hash.replace("#", '');
		   		//updateTable2("/"+new_link);
		   		updateTable2();
		    return false;  
		  });  
		};
		
	jQuery.fn.closeUpdate = function(){
		this.click(function(){
		    	jQuery(document).trigger('close.facebox');
		   		updateTable2();
		});	
	};
		
	jQuery.fn.jForm = function () {  
		  this.submit(function () {  
		    $.ajax({
		    	type: 'POST',
		    	url: $(this).attr('action'), 
		    	data: $(this).serialize(),
		    	dataType: "script",
		    	success: function(data){
		    	jQuery(document).trigger('close.facebox');
		   		//var hash = window.location.hash;
		   		//var new_link = hash.replace("#", '');
		   		//updateTable2("/"+new_link);
		   		updateTable2();
				},error:function(){
					jQuery(document).trigger('close.facebox');
					$('#content').html("<div id='error'>We are sorry but the page your are looking for got an error. Please contact the administrator immediately after seeing this message. Thank you</div>");
				}
		    	 
	    	 });
		   	$(this).find(":submit").attr('value','Saving . . .');
		   	$(this).find(":submit").attr('disabled','disabled');
		    return false;  
		  });  
		};
		
	jQuery.fn.jForm2 = function () {  
		  this.submit(function () {  
		    $.ajax({
		    	type: 'POST',
		    	url: $(this).attr('action'), 
		    	data: $(this).serialize(),
		    	dataType: "script",
		    	success: function(data){
		    	//jQuery(document).trigger('close.facebox');
		   		//var hash = window.location.hash;
		   		//var new_link = hash.replace("#", '');
		   		//updateTable2("/"+new_link);
		   		updateTable3();
				},error:function(){
					jQuery(document).trigger('close.facebox');
					$('#content').html("<div id='error'>We are sorry but the page your are looking for got an error. Please contact the administrator immediately after seeing this message. Thank you</div>");
				}
		    	 
	    	 });
		   	$(this).find(":submit").attr('value','Saving . . .');
		   	$(this).find(":submit").attr('disabled','disabled');
		    return false;  
		  });  
		};
		
		
	jQuery.fn.jLink = function () {  
		  this.click(function () {  
		    $.post($(this).attr('action'), $(this).serialize(), null, "script");
		   	alert("Form Submitted.");
		    return false;  
		  });  
		};
			
		
	jQuery.fn.reopenAjax = function(){
		this.click(function(){
		 	jQuery(document).trigger('close.facebox');
		 	var link = $(this).attr("href");
		 	$.facebox(function() { 
  				$.get(link, function (data) { $.facebox(data); } ); 
			});
			return false;
		 });	
	};
	
	jQuery.fn.sliderAjax = function(){
		this.click(function(){
			$('div.slider_content').slideUp('normal');
			$(this).next().slideDown('normal');
		});	
		$('div.slider_content').slideUp('normal');
	};
	
	jQuery.fn.openLink = function(){
		this.click(function(){
			$(this).parents('div:eq(2)').html("<div id='load'></div>").load(this.href);
			return false;
		});
	};
	
	jQuery.fn.openLink2 = function(){
		this.click(function(){
			$(this).parents('div:eq(0)').html("<div id='load'></div>").load(this.href);
			return false;
		});
	};
	
	jQuery.fn.menuAjax = function(){
		this.click(function(){
			cornerDivs();
			$('#content').html("<div id='load'></div>");
			var path = this.href;
			$.ajax({
				type: 'GET',
				url: path,
				success: function(data){
					cornerDivs();
					var array_path = path.split("/");
					window.location.hash = array_path[3];
					$("#content").replaceWith($('#content', $(data)));
    				updateLinks();
    				updateJavascript();
				},error: function(){
					$('#content').html("<div id='error'>We are sorry but the page your are looking for got an error. Please contact the administrator immediately after seeing this message. Thank you</div>");
				}
			});
			return false;
		});
	};
	

	

		
	
	
