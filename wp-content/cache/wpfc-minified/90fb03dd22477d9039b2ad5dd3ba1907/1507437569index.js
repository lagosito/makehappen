// source --> http://demo4site.com/dev1/studiotiger/wp-content/themes/studiotiger/js/comman.js?ver=4.8.2 
(function($){$(function(){var scroll=$(document).scrollTop();var headerHeight=$('.page-header').outerHeight();$(window).scroll(function(){var scrolled=$(document).scrollTop();if(scrolled>headerHeight){$('.page-header').addClass('off-canvas');}else{$('.page-header').removeClass('off-canvas');}if(scrolled>scroll){$('.page-header').removeClass('fixed');}else{$('.page-header').addClass('fixed');}scroll=$(document).scrollTop();});});})(jQuery);