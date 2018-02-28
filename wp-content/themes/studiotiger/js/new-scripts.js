
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
   
	
jQuery(document).ready(function() {
	
    
    /*
        Form
    */
    $('.f1 fieldset:first').fadeIn('slow');
    
    $('.f1 input[type="text"], .f1 input[type="password"], .f1 textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    // next step
    $('.f1 .btn-next').on('click', function() {
        
    	var parent_fieldset = $(this).parents('fieldset');	
    	var next_step = true;
        // navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
        var current_nonactive_step = $(this).parent('.f1').find('.f1-step.dishable');
        var clickble_class = $(this).parent('.f1').find('.f1-step.activated');
	var parfieldset = $(this).parents("fieldset");
        
        if(parfieldset.hasClass("has-substep")){
            var $activeul = parfieldset.find("ul:visible");
            if(parfieldset.hasClass("sub-activated")){
                if($activeul.next().length > 0){
                    $activeul.next().show();
                    $activeul.hide();
                    next_step = false;
                }
                
            }else{
                var $activeli = $activeul.find("li.selected");
                var datatype = $activeli.data("type");
                parfieldset.find(".sub-fild-step").show();
                parfieldset.find(".sub-fild-step").show();
                $("#"+datatype).show();
                $("#"+datatype+" ul" ).first().show();
            }
        }
        
                
    	
    	// fields validation
    	parent_fieldset.find('input[type="text"], input[type="password"], textarea').each(function() {
    		if( $(this).val() == "" ) {
    			$(this).addClass('input-error');
    			next_step = false;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	// fields validation
    	
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
    			// change icons
				
    			current_active_step.removeClass('active').addClass('activated').next().addClass('active').removeClass('dishable');
    			
				
			// progress bar
    			bar_progress(progress_line, 'right');
    			// show next step
	    		$(this).next().fadeIn();
	    		// scroll window to beginning of the form
    			scroll_to_class( $('.f1'), 20 );
	    	});
    	}
    	
    });
	
   // previous step
    $('.f1 .btn-previous').on('click', function() {
        
    	// navigation steps / progress steps
    	var current_active_step = $(this).parents('.f1').find('.f1-step.active');
    	var progress_line = $(this).parents('.f1').find('.f1-progress-line');
    	var prevfield = current_active_step.prev();
        var parfieldset = $(this).parents("fieldset");
        
        if(parfieldset.hasClass("sub-activated")){
            var substep = $( parfieldset).find(".sub-fild-step");
            var activeul = $(substep).find("ul:visible");
//            console.log("prev: ");
//            console.log(activeul.prev().length() == 0);
//            console.log("next: ");
//            console.log(activeul.next());
            if(activeul.prev().length > 0 ){
                activeul.prev().show();
                activeul.hide();
            }
            else{
                $(".main-substep").show();
                $(".sub-fild-step").hide();
                $(".sub-fild-step ul").hide();
                parfieldset.removeClass('sub-activated');
                
            }
            
        }
        else if(prevfield.hasClass( "activated" )){
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
        }
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
    

$("#select-fruit li").click(function() {
  /*Add selected class*/
  $(this).addClass('selected');
  /*Remove selected class*/
  $(this).siblings().removeClass('selected');
  $(this).children("input[name='test1']:radio").eq(0).prop('checked',true);
  
  $(this).parents('fieldset').find('.btn-next').click();
});


$("#select-serices li").click(function() {
  /*Add selected class*/
  $(this).addClass('selected');
  /*Remove selected class*/
  $(this).siblings().removeClass('selected');
  
if($(this).hasClass("has-substep")){
    $(this).parents("fieldset").addClass("sub-activated");
    $(this).parents(".main-substep").hide();
    var datatype = $(this).data("type");
    
    $(".sub-fild-step").show();
    $("#"+datatype).show();
    $("#"+datatype+" ul" ).first().show();
}
    else{
        $(this).parents('fieldset').find('.btn-next').click();
    
}
  /*Remove selected class*/
  //$(this).siblings().removeClass('selected');
  $(this).children("input[name='test1']:radio").eq(0).prop('checked',true);
});


$(".sub-fild-step .comman-services li").on('click',function() {
    /*Add selected class*/
  $(this).addClass('selected');
  /*Remove selected class*/
  $(this).siblings().removeClass('selected');
    var $ul = $(this).parent(),
    $nextul = $ul.next(),
    $prevul = $ul.prev();
    if($nextul.length > 0 ){
        $nextul.show();
        $ul.hide();
    }else{
        $(this).parents('fieldset').find('.btn-next').click();
    }
    

});



//style select and option

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
    
});
