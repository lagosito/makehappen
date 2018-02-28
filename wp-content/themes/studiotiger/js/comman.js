(function($){
	$(function(){	
      // scroll is still position
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
    jQuery( document ).ready(function() {
        jQuery(".map-section").height(jQuery(".contact-left-box").height());
    });

/*text rotator js home page banner slider*/
(function ($)  
{
function textRotate(classSelector,animationTime,ease,intervalLength,color){
	
var spanHeight = $(classSelector+" > p").height();
$(classSelector).parent().css("height",spanHeight+"px");
$(".sentence > p").css("display","inline");
$("head").append("<style>.sentence p {display: inline-block;}.sentence span {overflow: hidden;display: inline-block;position: relative;-webkit-transform: translateY(20%);-ms-transform: translateY(20%);transform: translateY(20%);}.sentence span div {display: inline-block;}.sentence span div p {display: block;background-color: transparent;top: 0;}.sentence span div p span {top: 0;height: auto;display: inline;}</style>")
if(color != ""){
	$(classSelector+" > p").css("color", color);
}
var iniElmWidth = $(classSelector+" > p:nth-child(1) > span").width();
$(classSelector).css("width",iniElmWidth);
$(classSelector+" > p").each(function(){
	var newValue = $(this).html().split(" ").join("&nbsp;");
	$(this).html(newValue);
	console.log(newValue);
});
var numOfWords = $(classSelector+" > p").length;
var count = 1;
$(classSelector).css("will-change","transform");
$(classSelector).css("transform", "translateY(0)");
$(classSelector).css("transition", "transform "+animationTime+"s "+ease+", width "+animationTime+"s "+ease);
setInterval(function(){
	if(count < numOfWords){
		count++;
		console.log(count);
		var elmWidth = $(classSelector+" > p:nth-child("+count+") > span").width();
		$(classSelector).css("width",elmWidth);
		var move = (count - 1)*spanHeight;	$(classSelector).css("transform","translateY(-"+move+"px)");
	} else if (count >= numOfWords){	
		count = 1;
		var elmWidth = $(classSelector+" > p:nth-child(1) > span").width();
		$(classSelector).css("width",elmWidth);
		$(classSelector).css("transform","translateY(0px)");
	}
	},intervalLength);
}

textRotate(".rotate",1,"ease",5000,"#F30A49");

})(jQuery); 
/*text rotator js home page banner slider*/

/*Video bg*/
jQuery(document).ready(function ($) {

    $(".player").mb_YTPlayer();

});

/*Video bg*/