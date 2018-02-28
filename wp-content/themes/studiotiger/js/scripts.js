
(function($){
	$(function(){	
			var scroll = $(document).scrollTop();
			var headerHeight = $('.page-header').outerHeight();
			//console.log(headerHeight);
	
			$(window).scroll(function() {
				// scrolled is new position just obtained
				var scrolled = $(document).scrollTop();
								
				// optionally emulate non-fixed positioning behaviour
			
				if (scrolled > headerHeight){
					$('.page-header').addClass('off-canvas');
				} else {
					$('.page-header').removeClass('off-canvas');
				}

			    if (scrolled > scroll){
			         // scrolling down
					 $('.page-header').removeClass('fixed');
			      } else {
					  //scrolling up
					  $('.page-header').addClass('fixed');
			    }				
				 
				scroll = $(document).scrollTop();	
			 });
    
    
 	});
})(jQuery); 


function scroll_to_class(element_class, removed_height) {
	var scroll_to = $(element_class).offset().top - removed_height;
	if($(window).scrollTop() != scroll_to) {
		$('html, body').stop().animate({scrollTop: scroll_to}, 0);
	}
}

function bar_progress(progress_line_object, direction) {
	var number_of_steps = progress_line_object.data('number-of-steps');
	var now_value = progress_line_object.data('now-value');
	var new_value = 0;
	if(direction == 'right') {
		new_value = now_value + ( 100 / number_of_steps );
	}
	else if(direction == 'left') {
		new_value = now_value - ( 100 / number_of_steps );
	}
	progress_line_object.attr('style', 'width: ' + new_value + '%;').data('now-value', new_value);
}

//prevstep

function fistclick(stepno){
    var current_active_step = $(".f1 .btn-next").parents('.f1').find('.f1-step.active');

        if(stepno==1){			
				
                current_active_step.removeClass("active");
				current_active_step.addClass("activated");
				$(".step").css({"display": "none"}); 
				$("#step_1").removeClass("activated");
				$("#step_1").addClass("active");
				$("#step1").fadeIn();
                                $('#result1').css("display","none");
                                $('#result2').css("display","none");
                                $('#result3').css("display","none");
                                $('#result4').css("display","none");
                                $('#select-serices li').removeClass('selected');
                                $('#step_2').addClass('dishable');
                                $('#step_2').removeClass('activated');
                                $('#step_3').addClass('dishable');
                                $('#step_3').removeClass('activated');
                                $('#step_4').addClass('dishable');
                                $('#step_4').removeClass('activated');
                             
                                
                                
        }
         if(stepno==2){
			var className = $('#step_2').attr('class');
                 
			if(className != "f1-step dishable step2"){
                current_active_step.removeClass("active");
				current_active_step.addClass("activated");
				$(".step").css({"display": "none"}); 
				$("#step_2").removeClass("activated");
				$("#step_2").addClass("active");
				$("#step2").fadeIn();
                                $('#step_3').addClass('dishable');
                                $('#step_3').removeClass('activated');
                                $('#step_4').addClass('dishable');
                                $('#step_4').removeClass('activated');
			}
        }
        if(stepno==3){
			var className = $('#step_3').attr('class');
			if(className != "f1-step dishable step3"){
				
                current_active_step.removeClass("active");
				current_active_step.addClass("activated");
				$(".step").css({"display": "none"}); 
				$("#step_3").removeClass("activated");
				$("#step_3").addClass("active");
				$("#step3").fadeIn();
                                $('#step_4').addClass('dishable');
                                $('#step_4').removeClass('activated');
			}
        }
		if(stepno==4){
			var className = $('#step_4').attr('class');
			if(className != "f1-step dishable step4"){
				
                current_active_step.removeClass("active");
				current_active_step.addClass("activated");
				$(".step").css({"display": "none"}); 
				$("#step_4").removeClass("activated");
				$("#step_4").addClass("active");
				$("#step4").fadeIn();
                                
			}
        }
        
}       

$(document).on('click', '.btn-select', function (e) {
    e.preventDefault();
    var ul = $(this).find("ul");
    if ($(this).hasClass("active")) {
        if (ul.find("li").is(e.target)) {
            var target = $(e.target);
            target.addClass("selected").siblings().removeClass("selected");
            var value = target.html();
            $(this).find(".btn-select-input").val(value);
            $(this).find(".btn-select-value").html(value);
             
            /*rsm */
            var sdate= $('a.btn-select.sdate').find(".btn-select-value").text();
            var syear= $('a.btn-select.syear').find(".btn-select-value").text();
            var edate= $('a.btn-select.edate').find(".btn-select-value").text();
            var eyear= $('a.btn-select.eyear').find(".btn-select-value").text();

            if(sdate!="Select Option" && syear!="Select Option" && edate!="Select Option" && eyear!="Select Option"){
                  $('#bts3').removeAttr("disabled"); 
            }
            else
            {
              $('#bts3').attr("disabled","disabled");   
            }    
             
            /* rsm */

        }
        ul.hide();
        $(this).removeClass("active");
    }
    else {
        $('.btn-select').not(this).each(function () {
            $(this).removeClass("active").find("ul").hide();
        });
        ul.slideDown(300);
        $(this).addClass("active");
    }
});
        
jQuery(document).ready(function() {
    
$(".scroll").click(function() {
    $('html,body').animate({
        scrollTop: $("#about").offset().top},
        'slow');
});

   
    $(".btn-select").each(function (e) {
        var value = $(this).find("ul li.selected").html();
        if (value != undefined) {
            $(this).find(".btn-select-input").val(value);
            $(this).find(".btn-select-value").html(value);
        }
    });
    
       /* rsm  1 step related  2 step display js*/
        $('#bts1').click(function() {
        var ptype= $('#select-fruit li.selected').attr('id');
        $('#result'+ptype).css("display","block");
        
        /* rsm inpput hiden value set */
        var result1 = $('#select-fruit li.selected .strategy-box .details-box h3').text();
        var result2 = $('#st1').attr('value',result1);
        var result3 = $('#st1').val();
       $.cookie('ptype', result3, { path:'/'});
       
        });
     
        /* rsm  1 step related  2 step display js*/
$(document).ready(function(){
    
var sel_val =  $('#select-serices li.selected input').val();
    if($('#main').val() != sel_val){

     $('#website-serices li.selected').removeClass('selected');
     if($('#website_serices li.selected').length == 0 ){

    $('#select-serices li').on('click',function(){
      
        $('#web_option ul').remove();
        ajaxcall();
      });
    }
        
        $('#main').attr('value',sel_val);
    }
    
});      
                 
 $('#bts2').on('click', function() {
    var ptype= $.cookie('ptype');
     
    if(ptype == "STRATEGY"){
       var re1= $('#strategy-serices li.selected input').val();
       $.cookie('pservice',re1,{ path:'/'});
    }
   else if(ptype == "DESIGN"){
       var re1= $('#design-serices li.selected input').val();
       $.cookie('pservice',re1,{ path:'/'});
      }
  else if(ptype=="DIGITAL INNOVATION"){
         var re1 = $('#select-serices li.selected .service-rounded-box .service-name p').text();
         console.log(re1);
         $.cookie('pservice',re1,{ path:'/'});
         var type = $('#select-serices li.selected input').val(); 
  
          if(type=="web"){
            var webserices = $('#website-serices li.selected input').val(); 
             $.cookie('webserices',webserices,{ path:'/'});
            if(webserices=="noidea"){
                var wo2 =  $('#web_option2 li.selected input').val();
                var wo3 =  $('#web_option3 li.selected input').val();
                var wo4 =  $('#web_option4 li.selected input').val();
                var wo5 =  $('#web_option5 li.selected input').val();
//               console.log(webserices+wo2+wo3+wo4+wo5);
                 $.cookie('wo2',wo2,{ path:'/'});
                 $.cookie('wo3',wo3,{ path:'/'});
                 $.cookie('wo4',wo4,{ path:'/'});
                 $.cookie('wo5',wo5,{ path:'/'});
                 
            }else{
            var wo1 =  $('#web_option1 li.selected input').val();
            var wo2 =  $('#web_option2 li.selected input').val();
            var wo3 =  $('#web_option3 li.selected input').val();
            var wo4 =  $('#web_option4 li.selected input').val();
            var wo5 =  $('#web_option5 li.selected input').val();
//            console.log(webserices+wo1+wo2+wo3+wo4+wo5);
                 $.cookie('wo1',wo1,{ path:'/'});
                 $.cookie('wo2',wo2,{ path:'/'});
                 $.cookie('wo3',wo3,{ path:'/'});
                 $.cookie('wo4',wo4,{ path:'/'});
                 $.cookie('wo5',wo5,{ path:'/'});
            }
          }
            if(type=="app"){
              var webserices = $('#website-serices li.selected input').val(); 
             $.cookie('webserices',webserices,{ path:'/'});
           
            var wo1 =  $('#web_option1 li.selected input').val();
            var wo2 =  $('#web_option2 li.selected input').val();
            var wo3 =  $('#web_option3 li.selected input').val();
            var wo5 =  $('#web_option5 li.selected input').val();
//             console.log(webserices+wo1+wo2+wo3+wo5);
                 $.cookie('wo1',wo1,{ path:'/'});
                 $.cookie('wo2',wo2,{ path:'/'});
                 $.cookie('wo3',wo3,{ path:'/'});
                 $.cookie('wo5',wo5,{ path:'/'});
              
          }
        }
  else if(ptype == "SOCIAL MEDIA"){
        var re1 = $('#social-serices li.selected .service-rounded-box .service-name p').text();
        $.cookie('pservice',re1,{ path:'/'});
     }
     
//       var sel_val =  $('#select-serices li.selected input').val();
//       if($('#main').val() != sel_val){
//         $('#website-serices li.selected').removeClass('selected');
//         if($('#website_serices li.selected').length == 0){
//        $('#web_option ul').remove();
//
//        } 
//        }
//         $('#main').attr('value',sel_val);     
          
    var web_option = $('#website-serices li.selected input').val();
       
    if($("#website-serices").length == 0 && $("#select-serices li.selected").length != 0 ){
        
         ajaxcall();
    } else if($("#web_option1").length == 0 && $("#web_option2").length == 0 && $('#website-serices li.selected').length != 0){
        $('#subfield').attr('value',web_option);
         ajaxcall();
    } else if ($('#website-serices li.selected').length != 0 && $('#subfield').val()!=web_option){
        $('#subfield').attr('value',web_option);
         $('#web_option').find("ul").slice(1,6).remove();
        ajaxcall();
     }else {
        
         return false;
    }
    
     
});
$('#bts3').on('click', function() {
               var sd1 = $('#sd1').val();
               var sy1 = $('#sy1').val();
               var ed1 = $('#ed1').val();
               var ey1 = $('#ey1').val();
              
               $.cookie('sd1',sd1, { path:'/'});
               $.cookie('sy1',sy1, { path:'/'});
               $.cookie('ed1',ed1, { path:'/'});
               $.cookie('ey1',ey1, { path:'/'});
               
 });
 $('#bts4').on('click', function() {
               var pfname = $('#pfname').val();
               var pemail = $('#pemail').val();
               var pphone = $('#pphone').val();
               var pcomname = $('#pcomname').val();
               var pmsg = $('#pmsg').val();
              
               $.cookie('pfname',pfname, { path:'/'});
               $.cookie('pemail',pemail, { path:'/'});
               $.cookie('pphone',pphone, { path:'/'});
               $.cookie('pcomname',pcomname, { path:'/'});
               $.cookie('pmsg',pmsg, { path:'/'});
               
 });
 

$(document).on('click', function (e) {
    var target = $(e.target).closest(".btn-select");
    if (!target.length) {
        $(".btn-select").removeClass("active").find("ul").hide();
    }
   
    
});

$("#select-fruit li").click(function() {
  /*rsm */ 
  $('#bts1').removeAttr("disabled"); 
  /* rsm */
  /*Add selected class*/
  $(this).addClass('selected');
  /*Remove selected class*/
  $(this).siblings().removeClass('selected');
  
  $(this).children("input[name='test1']:radio").eq(0).prop('checked',true);

});


$("#select-serices li").click(function() {  
  /*Add selected class*/
 $(this).addClass('selected');

  /*Remove selected class*/
  $(this).siblings().removeClass('selected');
});

$("#strategy-serices li").click(function() {  
  /*Add selected class*/
 $(this).addClass('selected');
  /*Remove selected class*/
  $(this).siblings().removeClass('selected');
});

$("#design-serices li").click(function() {  
  /*Add selected class*/
 $(this).addClass('selected');
  /*Remove selected class*/
  $(this).siblings().removeClass('selected');
});

$("#social-serices li").click(function() {  
  /*Add selected class*/
 $(this).addClass('selected');
  /*Remove selected class*/
  $(this).siblings().removeClass('selected');
});


      /*
        Fullscreen background
    */
    $.backstretch("assets/img/backgrounds/1.jpg");
    
    $('#top-navbar-1').on('shown.bs.collapse', function(){
    	$.backstretch("resize");
    });
    $('#top-navbar-1').on('hidden.bs.collapse', function(){
    	$.backstretch("resize");
    });
    
    /*
        Form
    */
    $('.f1 fieldset:first').fadeIn('slow');
    
//    $('.f1 input[type="text"], .f1 input[type="password"], .f1 textarea').on('focus', function() {
//    	$(this).removeClass('input-error');
//    });
    
    // next step
    $('.f1 .btn-next').on('click', function() {          
    	var parent_fieldset = $(this).parents('fieldset');
        var step1 = $('#select-fruit li.selected').attr('class');
      
   var cvalue=$('#select-fruit li.selected .strategy-box .details-box h3').text();
   
        if(step1 == 'selected'){
            var next_step=true;
            $('#select-fruit li').removeClass('selected');
            $('#web_option ul').remove();  
            $('#consult-serices li.selected').removeClass('selected');
            $('#strategy-serices li.selected').removeClass('selected');
            $('#design-serices li.selected').removeClass('selected');
            $('#social-serices li.selected').removeClass('selected');
           
          
        } else if ($('#web_option5 li.selected').length != 0 && $('#web_option4 li.selected').length != 0 && $('#web_option3 li.selected').length != 0 && $('#web_option2 li.selected').length != 0 && $('#web_option1 li.selected').length != 0 && $('#website-serices li.selected input').val()==$('#subfield').val()){
            next_step=true; 
        }  else if ($('#web_option5 li.selected').length != 0 && $('#web_option4 li.selected').length != 0 && $('#web_option3 li.selected').length != 0 && $('#web_option2 li.selected').length != 0 && $('#web_option1').length == 0 && $('#website-serices li.selected input').val()==$('#subfield').val()){
            next_step=true;  
        } 
        else if ($('#web_option5 li.selected').length != 0 && $('#select-serices li.selected input').val()=='app' && $('#web_option3 li.selected').length != 0 && $('#web_option2 li.selected').length != 0 && $('#web_option1 li.selected').length != 0){
            next_step=true; 
        } 
        else if($('#select-serices li.selected input').val() == 'cons'){
            next_step=true;
            $('#select-serices li.selected').removeClass('selected');
        } else if($('#strategy-serices li.selected').length != 0){
            next_step=true;
           $('#strategy-serices li.selected').removeClass('selected');
        } else if($('#design-serices li.selected').length != 0){
            next_step=true;
            $('#design-serices li.selected').removeClass('selected');
        } else if($('#social-serices li.selected').length != 0){
            next_step=true;
             $('#social-serices li.selected').removeClass('selected');
        } else if($('.select-year a input').val() !=  'Select Option' && $('.select-month a input').val() !=  'Select Option' &&  $('#step4').css("display")=="none")        {
            next_step=true;
        }else  {

            next_step=false;
        }
      
        
    	// navigation steps / progress steps
                var current_active_step = $(this).parents('.f1').find('.f1-step.active');
                var progress_line = $(this).parents('.f1').find('.f1-progress-line');
		var current_nonactive_step = $(this).parent('.f1').find('.f1-step.dishable');
		var clickble_class = $(this).parent('.f1').find('.f1-step.activated');

    	
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
		//console.log(current_active_step);
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active').removeClass('dishable');
				// progress bar
    			bar_progress(progress_line, 'right');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	
    }
		
		$('.f1 .step-back').on('click', function() {
 		if (clickble_class.parent('.f1').find('#step1')) {
                    
	}
				
	});
    });
    
	
function ajaxcall(){
            
            var web_id = $('#select-serices li.selected input').val();
            var web_option1 = $('#website-serices li.selected input').val();
//            var web_option2 = $('#web_option1 li.selected input').val();
//            var web_option3 = $('#web_option2 li.selected input').val();
//            var web_option4 = $('#web_option3 li.selected input').val();
//            var web_option5 = $('#web_option4 li.selected input').val();
//            var web_option6 = $('#web_option5 li.selected input').val();
                $('#page-top').addClass('body_dishable');
            $.ajax({
                type: "POST",
                url: adminurl,
                data: {
                        action:"on_step2_multiple",
                        data1:web_id,
                        data2:web_option1,
//                        data3:web_option2,
//                        data4:web_option3,
//                        data5:web_option4,
//                        data6:web_option5,
//                        data7:web_option6
                    },
                success: function(data) {
                   
                   $("#web_option").append(data);
               
                    $("#website-serices li").click(function() {  
                    /*Add selected class*/
                   $(this).addClass('selected');
                    /*Remove selected class*/
                    $(this).siblings().removeClass('selected');
                  });
                  $("#web_option1 li").click(function() {  
                    /*Add selected class*/
                   $(this).addClass('selected');
                    /*Remove selected class*/
                    $(this).siblings().removeClass('selected');
                  });
                    $("#web_option2 li").click(function() {  
                    /*Add selected class*/
                   $(this).addClass('selected');
                    /*Remove selected class*/
                    $(this).siblings().removeClass('selected');
                  });
                  $("#web_option3 li").click(function() {  
                    /*Add selected class*/
                   $(this).addClass('selected');
                    /*Remove selected class*/
                    $(this).siblings().removeClass('selected');
                  });
                  $("#web_option4 li").click(function() {  
                    /*Add selected class*/
                   $(this).addClass('selected');
                    /*Remove selected class*/
                    $(this).siblings().removeClass('selected');
                  });
                  $("#web_option5 li").click(function() {  
                    /*Add selected class*/
                   $(this).addClass('selected');
                    /*Remove selected class*/
                    $(this).siblings().removeClass('selected');
                  });
                  $("#consult-serices li").click(function() {  
                    /*Add selected class*/
                   $(this).addClass('selected');
                    /*Remove selected class*/
                    $(this).siblings().removeClass('selected');
                  });
                  
                  $('#page-top').removeClass('body_dishable');
                 }
                 
             }); 
             
         
}

//$(document).ready(function(){
//var sel_val =  $('#select-serices li.selected input').val();
//    
//        if($('#main').val() != sel_val){
//           
//         $('#website-serices li.selected').removeClass('selected');
//         if($('#website_serices li.selected').length == 0 ){
//        
//        $('#select-serices li').on('click',function(){
//         $('#web_option ul').remove();
//            
//            ajaxcall();
//            
//            $('#select-serices li').focus();
//          });
//            } 
//        }
//});
    

    // previous step
    $('.f1 .btn-previous').on('click', function() {
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	
    	$(this).parents('fieldset').fadeOut(400, function() {
    		// change icons
    		current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
    		// progress bar
    		bar_progress(progress_line, 'left');
    		// show previous step
    		$(this).prev().fadeIn();
    		// scroll window to beginning of the form
			scroll_to_class( $('.f1'), 20 );
    	});
    });
    
    // submit
    $('.f1').on('submit', function(e) {
    	// fields validation
    	$(this).find('input[type="text"], input[type="password"], textarea').each(function() {
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	// fields validation
    	
    });
    
    
});