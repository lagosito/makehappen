jQuery(".scroll").click(function() {
	jQuery('html,body').animate({
		scrollTop: jQuery("#about").offset().top
	}, 'slow');
});
jQuery('.navbar-right li').removeClass('menu-item');
jQuery('.singlepagi a').addClass('rounded-btn');
jQuery('#team-box0').addClass('light-orange');
jQuery('#team-box1').addClass('light-blue');
jQuery('#team-box2').addClass('dark-brown');
jQuery('#team-box3').addClass('light-brown'); /*owl carousle * // client logo slider on home page * */
jQuery(document).ready(function() {
	jQuery('.clients-logo-slider .owl-carousel').owlCarousel({
		loop: true,
		responsiveClass: true,
		responsive: {
			0: {
				items: 2,
				nav: true
			},
			600: {
				items: 3,
				nav: false
			},
			1000: {
				items: 4,
				nav: true,
				loop: false,
			}
		}
	});
	$('.collaborate-video-1').owlCarousel({
		items: 1,
		merge: true,
		loop: true,
		margin: 10,
		video: true,
		lazyLoad: true,
		center: true
	});
	$('.collaborate-video-2').owlCarousel({
		items: 1,
		merge: true,
		loop: true,
		margin: 10,
		video: true,
		lazyLoad: true,
		center: true
	});
	$('.img-slider').owlCarousel({
		items: 1,
		loop: true,
		margin: 10,
		center: true
	});
}); /*text rotator js home page banner slider*/
(function($) {
	function textRotate(classSelector, animationTime, ease, intervalLength, color) {
		var spanHeight = $(classSelector + " > p").height();
		$(classSelector).parent().css("height", spanHeight + "px");
		$(".sentence > p").css("display", "inline");
		$("head").append("<style>.sentence p {display: inline-block;}.sentence span {overflow: hidden;display: inline-block;position: relative;-webkit-transform: translateY(20%);-ms-transform: translateY(20%);transform: translateY(20%);}.sentence span div {display: inline-block;}.sentence span div p {display: block;background-color: transparent;top: 0;}.sentence span div p span {top: 0;height: auto;display: inline;}</style>");
		if (color !== "") {
			$(classSelector + " > p").css("color", color);
		}
		var iniElmWidth = $(classSelector + " > p:nth-child(1) > span").width();
		$(classSelector).css("width", iniElmWidth);
		$(classSelector + " > p").each(function() {
			var newValue = $(this).html().split(" ").join("&nbsp;");
			$(this).html(newValue);
//			console.log(newValue);
		});
		var numOfWords = $(classSelector + " > p").length;
		var count = 1;
		$(classSelector).css("will-change", "transform");
		$(classSelector).css("transform", "translateY(0)");
		$(classSelector).css("transition", "transform " + animationTime + "s " + ease + ", width " + animationTime + "s " + ease);
		setInterval(function() {
			if (count < numOfWords) {
				count++;
//				console.log(count);
				var elmWidth = $(classSelector + " > p:nth-child(" + count + ") > span").width();
				$(classSelector).css("width", elmWidth);
				var move = (count - 1) * spanHeight;
				$(classSelector).css("transform", "translateY(-" + move + "px)");
			} else if (count >= numOfWords) {
				count = 1;
				var elmWidth = $(classSelector + " > p:nth-child(1) > span").width();
				$(classSelector).css("width", elmWidth);
				$(classSelector).css("transform", "translateY(0px)");
			}
		}, intervalLength);
	}
	textRotate(".rotate", 1, "ease", 5000, "#F30A49");
})(jQuery); /*text rotator js home page banner slider*/