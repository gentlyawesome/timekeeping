$(document).ready(function()
{

$('form').submit(function() {  
    $(":submit").attr("disabled", "disabled");  
    $(":submit").val("Submit");  
    $(":submit").addClass("disabled");  
}); 
  jQuery.fn.deleteAjax = function (){
    this.click(function() {
      if(confirm("Are You Sure?")){
        $.post(this.href, { _method: 'delete' }, null, "script");
        $(this).parents('tr:first').hide("slow");
        
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

		//Student Fees
		$('.submit').hover(function(){
			//$('.values').blur(function () {

    			var sum = 0;
    			$('.values').each(function() {
    		  	  sum += Number($(this).val());
   				 });
  			  $('#total').val(sum);
  			  $('.sum').html("<p class='sum'>Total: "+ sum +" </p>");
		//});

		//$('#discount_select').keyup(function(){
			var total = $('#total').val();
			//var discount = Number($('#discount_select').val());
			//var less = total/100*discount;
			//var net = total - Number($('#discount_select').val());

			//$('#discount').val(discount);
			//$('#less').val(total/100*discount);
			//$('#net').val(total - $('#less').val());
			$('#net').val(total);

			//$('.less').html("<p class='less'>Less Discount: "+ less +" </p>");
			//$('.net').html("<p class='net'>Net Amount: "+ net +" </p>");
		//});
		});

$('a[id*=delete]').deleteAjax();
			$('a[class*=delete]').deleteAjax();
			$('a[id*=remove]').removeThis();
   //Side Menu
  //hide the all of the element with class msg_body
  //$(".acc_con").show();
  //toggle the componenet with class msg_body
//  $(".acc").click(function()
//  {
//    if($(this).attr("class") == "acc_min"){
//      $(this).attr("class", "acc");
//    }else{
//      $(this).attr("class", "acc_min");
//    };

//    $(this).next(".acc_con").slideToggle(600);
//  });



//  $("#acc_last").click(function()
//  {
//    if($(this).attr("id") == "acc_last_min"){
//      $(this).attr("id", "acc_last");
//    }else{
//      $(this).attr("id", "acc_last_min");
//    };

//    $(this).prev(".acc_con").slideToggle(600);
//  });

//  $("#acc_first").click(function()
//  {
//    if($(this).attr("id") == "acc_first_min"){
//      $(this).attr("id", "acc_first");
//    }else{
//      $(this).attr("id", "acc_first_min");
//    };

//    $(this).prev(".acc_con").slideToggle(600);
//  });


  //Table Zebra
  $("tr:odd").addClass("odd");
//  $("tr").hover(function(){
//     $(this).attr("id", "td_hover");
//  },function(){
//     $(this).attr("id", "td_unhover");
//  });

  //Rouded corners
//  $("#right_top").corner("top 5px");
//  $("#header").corner("5px");
//  $("#login_title").corner("top 5px");
//  $(".box_title").corner("top 5px");
//  $(".box_con").corner("bottom 5px");
//  $("#side_menu").corner("5px");
//  $("#right_bottom").corner("bottom 5px");
//  $("#bottom_rb1_con").corner("bottom 5px");
//  $("#bottom_rb2_con").corner("bottom 5px");
//  $("#top_rb1_con").corner("bottom 5px");
//  $("#top_rb2_con").corner("bottom 5px");
//  $("#acc_first").corner("top 5px");
//  $("#acc_last").corner("bottom 5px");
//  $("input").addClass("input_div").corner("5px");
//  $("select").addClass("input_div").corner("5px");
//  $("textarea").addClass("input_div").corner("5px");
//  $(".errorExplanation").corner("5px");
//  $("#student_tabs li a").corner("top 5px");

  //Accordion
  $('#fee').accordion();
  $('#student_subjects').accordion();


  //Submit Button
//  $('input[type=submit]').addClass("submit");
//  $('input[type=submit]').click(function(){
//    $(this).removeClass("submit").addClass("submit_ajax");
//    wait(500);
//    return true;
//  });

//  $('input[type=submit]').bind("keydown", function(e){
//    var code = (e.keyCode ? e.keyCode : e.which);
//    if(code == 13) { //Enter keycode
//    $(this).removeClass("submit").addClass("submit_ajax");
//    wait(500);
//    return true;
//    };
//  });

  //Hide box4 subjects
  $('#reason').hide();
  $('.reason').attr('disabled', true);

  //Date Pick
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
		//$('input[class*=datepicktime]').datetimepicker();


  $('.status').change(function(){
  if($(this).val() == "present"){
  $('.reason').val('');
  $('#reason').hide();
  $('.reason').attr('disabled', true);
  }else{
  $('#reason').show();
  $('.reason').removeAttr('disabled');
  };
  });


                //Assign Subject Code
		var year = '';
		var semester = '';
		var course = '';
		var subject = '';
		$('.boxed4').hide();
		$('.boxed4 :input').attr("disabled", 'disable');
		$('.boxed2 :input').find('option:first').attr('selected', 'selected').parent('select');
		$('.boxed3 :input').find('option:first').attr('selected', 'selected').parent('select');

		$('#year_select').change(function(){
			var this_val = $(this).val();
			year = this_val;
			$('.boxed4').hide();
			$('.boxed4 :input').attr("disabled", 'disable');
			$('.boxed2 :input').find('option:first').attr('selected', 'selected').parent('select');
			$('.boxed3 :input').find('option:first').attr('selected', 'selected').parent('select');
			$("#semester :input").removeAttr('disabled');
			$("#semester").show();
		});

		$('#semester_select').change(function(){
			var this_val = $(this).val();
			semester = this_val;
			$('.boxed4').hide();
			$('.boxed3 :input').attr("disabled", 'disable');
			$('.boxed4 :input').attr("disabled", 'disable');
			$('.boxed3 :input').find('option:first').attr('selected', 'selected').parent('select');
			$("#course :input").removeAttr('disabled');
			$("#course").show();
		});

		$('#course_select').change(function(){
			var this_val = $(this).val();
			course = this_val;
			subject = "subject_"+year+semester+course;
			$('.boxed4').hide();
			$('.boxed4 :input').attr("disabled", 'disable');
			$('.'+subject+" :input").removeAttr('disabled');
			$('.'+subject).show();
			//$('.'+subject).each(function(){
			//	$(this + " :input").removeAttr('disabled');
			//	$(this).show();
			//});
		});
		subject = "subject_"+$("#year_select").val()+$('#semester_select').val()+$('#course_select').val();
		$('.'+subject+" :input").removeAttr('disabled');
		$('.'+subject).show();

jQuery.fn.submitRemarks = function() {
  this.change(function() {
    alert(this.parent.id);
    //$.post(this.action, $(this).serialize(), null, "script");
    //return false;
  })
  //return this;
};


});
