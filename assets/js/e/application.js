$(function(){

/*
$('form').submit(function() { 
   var form_id = $(this).attr('id');
   if(form_id != 'new_user'){
    $('.default-value').each(function(){
      var defaultVal = $(this).attr('title');
      if ($(this).val() == defaultVal){
        $(this).val('');
      }
    }); 
    //$(":submit").attr("disabled", "disabled");  
    //$(":submit").addClass("disabled"); 
    } 
});
*/

	$('#header ul li a').corner("top 3px");
	$('.boxed').corner();
	$('.boxed1').corner();
	$('.boxed2').corner();
	$('.boxed3').corner();
	$('.boxed4').corner();
	$('input').corner("3px");
	$('div').corner();//Date Pick

/*
	$("#enroll2").children().find(":input").each(function(){
		var classname = $("#"+this.id).attr('class');
		if(classname != "novalidate" ){
		   $("#"+this.id).validate({
		          expression: "if (VAL) return true; else return false;",
		          message: "Please select "+ classname +"."
		   });
		};
	});
*/
	
  $('.default-value').each(function(){
    var defaultVal = $(this).attr('title');
    $(this).focus(function(){
      if ($(this).val() == defaultVal){
        $(this).removeClass('active').val('');
	$(this).css('color', '#000');
      }
    })
    .blur(function(){
      if ($(this).val() == ''){
        $(this).addClass('active').val(defaultVal);
	$(this).css('color', '#cdcdcd');
      }
    })
    .blur().addClass('active');
  });


});